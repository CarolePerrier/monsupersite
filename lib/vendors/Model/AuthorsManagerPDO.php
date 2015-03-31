<?php
namespace Model;

use \Entity\Author;

class AuthorsManagerPDO extends AuthorsManager
{
  public function getList($debut = -1, $limite = -1)
  {
    $requete = $this->dao->prepare('SELECT id, firstname, lastname, auteur, registrationdate, dateofbirth, dateModif FROM authors ORDER BY id DESC');
    $requete->execute();
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');
    $listAuthors = $requete->fetchAll();
    return $listAuthors;
  }

  public function getUnique($login, $password)
  {
    $requete = $this->dao->prepare('SELECT id, firstname, lastname, auteur, pwd, dateofbirth, registrationdate, dateModif, authors_fk_type FROM authors WHERE auteur = :auteur AND pwd = :pwd');

    $requete->bindValue(':auteur', (string) $login, \PDO::PARAM_STR);
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
    $requete = $this->dao->prepare('INSERT INTO authors SET firstname = :firstname, lastname = :lastname, pwd = :pwd, auteur = :auteur, registrationdate = NOW(), dateofbirth = :dateofbirth, dateModif = NOW()');
    
    $requete->bindValue(':firstname', $author->firstname());
    $requete->bindValue(':lastname', $author->lastname());
    $requete->bindValue(':pwd', $author->pwd());
    $requete->bindValue(':auteur', $author->auteur());
    $requete->bindValue(':dateofbirth', $author->dateofbirth());
    
    $requete->execute();
  }

    protected function modify(Author $author)
    {
      $requete = $this->dao->prepare('UPDATE authors SET firstname = :firstname, lastname = :lastname, pwd = :pwd, auteur = :auteur, dateofbirth = :dateofbirth, dateModif = NOW() WHERE id = :id');
      
      $requete->bindValue(':firstname', $author->firstname());
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

  public function IsValidAuteur($value)
  {
    $requete = $this->dao->prepare('SELECT id FROM authors WHERE auteur = :auteur');
    $requete->bindValue(':auteur', $value);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');
    
    if ($author = $requete->fetch())
    {     
      return true;
    }
    return false;
  }
}
?>