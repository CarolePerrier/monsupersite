<?php
namespace Model;

use \Entity\Author;

class AuthorManagerPDO extends AuthorManager
{
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, firstname, lastname, pseudo, registrationdate, dateofbirth, datemodif FROM authors ORDER BY id DESC';
    
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
    
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');
    
    $requete->closeCursor();
    
    return $listeAuthors;
  }

  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, firstname, lastname, pseudo, registrationdate, dateofbirth, dateModif FROM authors WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();
    
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');
    
    return null;
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM authors')->fetchColumn();
  }

  protected function add(Authors $authors)
  {
    $requete = $this->dao->prepare('INSERT INTO authors SET firstname = :firstname, lastname = :lastname, pseudo = :pseudo, registrationdate = NOW(), dateofbirth = :dateofbirth, datemodif = NOW()');
    
    $requete->bindValue(':firstname', $authors->firstname());
    $requete->bindValue(':lastname', $authors->lastname());
    $requete->bindValue(':pseudo', $authors->pseudo());
    $requete->bindValue(':dateofbirth', $authors->dateofbirth());
    
    $requete->execute();
  }

    protected function modify(Authors $authors)
    {
      $requete = $this->dao->prepare('UPDATE authors SET auteur = :auteur, titre = :titre, contenu = :contenu, dateofbirth = :dateofbirth, dateModif = NOW() WHERE id = :id');
      
      $requete->bindValue(':titre', $authors->titre());
      $requete->bindValue(':auteur', $authors->auteur());
      $requete->bindValue(':contenu', $authors->contenu());
      $requete->bindValue(':dateofbirth', $authors->dateofbirth());
      $requete->bindValue(':id', $authors->id(), \PDO::PARAM_INT);
      
      $requete->execute();
    }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM authors WHERE id = '.(int) $id);
  }
}
?>