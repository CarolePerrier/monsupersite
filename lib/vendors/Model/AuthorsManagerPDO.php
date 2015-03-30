<?php
namespace Model;

use \Entity\Author;

class AuthorsManagerPDO extends AuthorsManager
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

  public function getUnique($login, $password)
  {
    $requete = $this->dao->prepare('SELECT id, firstname, lastname, pseudo, pwd, dateofbirth, registrationdate, dateModif, authors_fk_type FROM authors WHERE pseudo = :pseudo AND pwd = :pwd');

    $requete->bindValue(':pseudo', (string) $login, \PDO::PARAM_STR);
    $requete->bindValue(':pwd', (string) $password, \PDO::PARAM_STR);

    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

    if ($author = $requete->fetch())
    {
      return $author;
    }

    return null;
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM authors')->fetchColumn();
  }

  protected function add(Author $author)
  {
    $requete = $this->dao->prepare('INSERT INTO authors SET firstname = :firstname, lastname = :lastname, pwd = :pwd, pseudo = :pseudo, registrationdate = NOW(), dateofbirth = :dateofbirth, dateModif = NOW()');
    
    $requete->bindValue(':firstname', $author->firstname());
    $requete->bindValue(':lastname', $author->lastname());
    $requete->bindValue(':pwd', $author->pwd());
    $requete->bindValue(':pseudo', $author->pseudo());
    $requete->bindValue(':dateofbirth', $author->dateofbirth());
    
    $requete->execute();
  }

    protected function modify(Author $author)
    {
      $requete = $this->dao->prepare('UPDATE authors SET firstname = :firstname, lastname = :lastname, pwd = :pwd, pseudo = :pseudo, dateofbirth = :dateofbirth, dateModif = NOW() WHERE id = :id');
      
      $requete->bindValue(':firstname', $author->firstname());
      $requete->bindValue(':lastname', $author->lastname());
      $requete->bindValue(':lastname', $author->lastname());
      $requete->bindValue(':pwd', $author->pwd());
      $requete->bindValue(':dateofbirth', $author->dateofbirth());
      $requete->bindValue(':id', $author->id(), \PDO::PARAM_INT);
      
      $requete->execute();
    }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM authors WHERE id = '.(int) $id);
  }
}
?>