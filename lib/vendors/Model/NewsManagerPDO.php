<?php
namespace Model;

use \Entity\News;

class NewsManagerPDO extends NewsManager
{
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news ORDER BY id DESC';
    
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

  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news WHERE id = :id');
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
    return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
  }

  protected function add(News $news)
  {
    $requete = $this->dao->prepare('INSERT INTO news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');
    
    $requete->bindValue(':titre', $news->titre());
    $requete->bindValue(':auteur', $news->auteur());
    $requete->bindValue(':contenu', $news->contenu());
    
    $requete->execute();
  }

  class NewsManagerPDO extends NewsManager
{
  // ...
  
  protected function modify(News $news)
  {
    $requete = $this->dao->prepare('UPDATE news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id');
    
    $requete->bindValue(':titre', $news->titre());
    $requete->bindValue(':auteur', $news->auteur());
    $requete->bindValue(':contenu', $news->contenu());
    $requete->bindValue(':id', $news->id(), \PDO::PARAM_INT);
    
    $requete->execute();
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM news WHERE id = '.(int) $id);
  }

  <?php
namespace Model;
    
use \Entity\Comment;

class CommentsManager_PDO extends CommentsManager
{
  // ...
  
  protected function modify(Comment $comment)
  {
    $q = $this->dao->prepare('UPDATE comments SET auteur = :auteur, contenu = :contenu WHERE id = :id');
    
    $q->bindValue(':auteur', $comment->auteur());
    $q->bindValue(':contenu', $comment->contenu());
    $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
    
    $q->execute();
  }
  
  public function get($id)
  {
    $q = $this->dao->prepare('SELECT id, news, auteur, contenu FROM comments WHERE id = :id');
    $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $q->execute();
    
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
    
    return $q->fetch();
  }
}
}
?>