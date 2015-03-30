<?php
namespace Model;

use \Entity\Author;

class AuthorManagerPDO extends AuthorManager
{
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, firstname, lastname, pseudo, registrationdate, dateofbirth, dateModif FROM authors ORDER BY id DESC';
    
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
    if ($author = $requete->fetch())
    {
      $author->setDateAjout(new \DateTime($author->registrationdate()));
      $news->setDateModif(new \DateTime($author->dateModif()));
      
      return $author;
    }
    return null;
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM authors')->fetchColumn();
  }

  protected function add(Authors $authors)
  {
    $requete = $this->dao->prepare('INSERT INTO authors SET firstname = :firstname, lastname = :lastname, pwd = :pwd, pseudo = :pseudo, registrationdate = NOW(), dateofbirth = :dateofbirth, dateModif = NOW()');
    
    $requete->bindValue(':firstname', $authors->firstname());
    $requete->bindValue(':lastname', $authors->lastname());
    $requete->bindValue(':pwd', $authors->pwd());
    $requete->bindValue(':pseudo', $authors->pseudo());
    $requete->bindValue(':dateofbirth', $authors->dateofbirth());
    
    $requete->execute();
  }

    protected function modify(Authors $authors)
    {
      $requete = $this->dao->prepare('UPDATE authors SET firstname = :firstname, lastname = :lastname, pwd = :pwd, pseudo = :pseudo, dateofbirth = :dateofbirth, dateModif = NOW() WHERE id = :id');
      
      $requete->bindValue(':firstname', $authors->firstname());
      $requete->bindValue(':lastname', $authors->lastname());
      $requete->bindValue(':lastname', $authors->lastname());
      $requete->bindValue(':pwd', $authors->pwd());
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