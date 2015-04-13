<?php
namespace Model;

use \Entity\News;
use \OCFram\User;
class NewsManagerPDO extends NewsManager
{
  public function getList($debut = -1, $limite = -1)
  {
    
    $sql = 'SELECT id, news_fk_author, auteur, titre, contenu, dateAjout, dateModif FROM T_BLG_news ORDER BY id DESC';
    
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
    $listeNews = $requete->fetchAll();
    
    foreach ($listeNews as $news)
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
    }
    
    $requete->closeCursor();
    
    return $listeNews;
  }

  public function getListAuthor($authorId)
  {
    $requete = $this->dao->prepare('SELECT id, news_fk_author, auteur, titre, contenu, dateAjout, dateModif FROM T_BLG_news WHERE news_fk_author = :authorId ORDER BY id DESC');
    
    $requete->bindValue(':authorId', $authorId);
    $requete->execute();
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    $listeNews = $requete->fetchAll();
    
    $requete->closeCursor();
    
    return $listeNews;
  }

  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, news_fk_author, auteur, titre, contenu FROM T_BLG_news WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();
    
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
    if ($news = $requete->fetch())
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
      
      return $news;
    }
    return null;
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM T_BLG_news')->fetchColumn();
  }

  protected function add(News $news)
  {

    $requete = $this->dao->prepare('INSERT INTO T_BLG_news SET news_fk_author = :auteurId, auteur = :auteurNews, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');
    //Get the AuthorId from his auteur
    $requeteAuteurId = $this->dao->prepare('SELECT BAC_id FROM T_BLG_authorsc WHERE BAC_pseudo = :pseudo');
    $requeteAuteurId->bindValue(':pseudo', $news->auteur());
    
    $requeteAuteurId->execute();
    if ($AuteurId = $requeteAuteurId->fetch())
    {
      $requete->bindValue(':auteurId', $AuteurId['BAC_id']);
    }
    
    $requete->bindValue(':titre', $news->titre());
    $requete->bindValue(':contenu', $news->contenu());
    $requete->bindValue(':auteurNews', $news->auteur());

    $requete->execute();
  }

    protected function modify(News $news)
    {
      $requete = $this->dao->prepare('UPDATE T_BLG_news SET news_fk_author = :auteurId, auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id');
      
      $requete->bindValue(':titre', $news->titre());
      $requete->bindValue(':auteur', $news->auteur());
      $requete->bindValue(':contenu', $news->contenu());
      $requete->bindValue(':id', $news->id(), \PDO::PARAM_INT);

      $requeteAuteurId = $this->dao->prepare('SELECT BAC_id FROM T_BLG_authorsc WHERE BAC_pseudo = :auteur');
      $requeteAuteurId->bindValue(':auteur', $news->auteur());
      $requeteAuteurId->execute();


    if ($AuteurId = $requeteAuteurId->fetch())
    {
      $requete->bindValue(':auteurId', (int)$AuteurId['BAC_id'], \PDO::PARAM_INT);
    }
      $requete->execute();
    }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM T_BLG_news WHERE id = '.(int) $id);
  }
}
?>