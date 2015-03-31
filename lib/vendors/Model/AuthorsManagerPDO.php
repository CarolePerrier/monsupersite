<?php
namespace Model;

use \Entity\Author;

class AuthorsManagerPDO extends AuthorsManager
{
  public function getList()
  {
    $requete = $this->dao->prepare('SELECT id, firstname, lastname, pseudo, registrationdate, dateofbirth, dateModif FROM authors ORDER BY id ASC');
    $requete->execute();
    // $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');
    $listAuthors = $requete->fetchAll();
    return $listAuthors;
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
    $requete = $this->dao->prepare('INSERT INTO authors SET firstname = :firstname, lastname = :lastname, pwd = :pwd, pseudo = :pseudo, registrationdate = NOW(), dateofbirth = :dateofbirth, dateModif = NOW(), authors_fk_type = :type');

    $requete->bindValue(':firstname', $author->firstname());
    $requete->bindValue(':lastname', $author->lastname());
    $requete->bindValue(':pwd', $author->pwd());
    $requete->bindValue(':pseudo', $author->pseudo());
    $requete->bindValue(':dateofbirth', $author->dateofbirth());
    $requete->bindValue(':type', $author->type());
    
    $requete->execute();
  }

    protected function modify(Author $author)
    {
      $requete = $this->dao->prepare('UPDATE authors SET firstname = :firstname, lastname = :lastname, pwd = :pwd, pseudo = :pseudo, dateofbirth = :dateofbirth, dateModif = NOW() WHERE id = :id');
      
      $requete->bindValue(':firstname', $author->firstname());
      $requete->bindValue(':lastname', $author->lastname());
      $requete->bindValue(':pseudo', $author->pseudo());
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
    $requete = $this->dao->prepare('SELECT id FROM authors WHERE pseudo = :pseudo');
    $requete->bindValue(':pseudo', $value);
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