<?php
namespace Model;

use \Entity\Author;

class AuthorsManagerPDO extends AuthorsManager
{
  public function getList()
  {
    $requete = $this->dao->prepare('SELECT BAC_id, BAC_firstname, BAC_lastname, BAC_pseudo, BAC_registrationdate, BAC_dateofbirth, BAC_email, BAC_dateModif FROM T_BLG_authorsc ORDER BY BAC_id ASC');
    $requete->execute();
    // $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');
    $listAuthors = $requete->fetchAll();
    return $listAuthors;
  }

  public function getUnique($login)
  {
    $requete = $this->dao->prepare('SELECT BAC_id, BAC_firstname, BAC_lastname, BAC_pseudo, BAC_password, BAC_dateofbirth, BAC_registrationdate, BAC_dateModif, BAC_email, authors_fk_type FROM T_BLG_authorsc WHERE BAC_pseudo = :pseudo LIMIT 1');

    $requete->bindValue(':pseudo', $login, \PDO::PARAM_STR);

    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

    if ($author = $requete->fetch())
    {
      return $author;
    }

    return null;
  }

  public function getUniqueId($id)
  {
    $requete = $this->dao->prepare('SELECT * FROM T_BLG_authorsc WHERE BAC_id = :id');

    $requete->bindValue(':id', (string) $id);

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
    return $this->dao->query('SELECT COUNT(*) FROM T_BLG_authorsc')->fetchColumn();
  }

  protected function add(Author $author)
  {
    $requete = $this->dao->prepare('INSERT INTO T_BLG_authorsc SET BAC_firstname = :firstname, BAC_lastname = :lastname, BAC_password = :password, BAC_pseudo = :pseudo, BAC_registrationdate = NOW(), BAC_dateofbirth = :dateofbirth, BAC_dateModif = NOW(), authors_fk_type = :type, BAC_email = :email, BAC_salt = :salt');

    $requete->bindValue(':firstname', $author->firstname());
    $requete->bindValue(':lastname', $author->lastname());
    $requete->bindValue(':password', $author->password());
    $requete->bindValue(':pseudo', $author->pseudo());
    $requete->bindValue(':dateofbirth', $author->dateofbirth());
    $requete->bindValue(':type', $author->type());
    $requete->bindValue(':email', $author->email());
    $requete->bindValue(':salt', $author->salt());
    
    $requete->execute();
  }

    protected function modify(Author $author)
    {
      $requete = $this->dao->prepare('UPDATE T_BLG_authorsc SET BAC_firstname = :firstname, BAC_lastname = :lastname, BAC_password = :password, BAC_pseudo = :pseudo, BAC_dateofbirth = :dateofbirth, BAC_dateModif = NOW(), , BAC_email = :email WHERE BAC_ id = :id');
      
      $requete->bindValue(':firstname', $author->firstname());
      $requete->bindValue(':lastname', $author->lastname());
      $requete->bindValue(':pseudo', $author->pseudo());
      $requete->bindValue(':password', $author->password());
      $requete->bindValue(':dateofbirth', $author->dateofbirth());
      $requete->bindValue(':email', $author->email());
      $requete->bindValue(':id', $author->id(), \PDO::PARAM_INT);
      
      $requete->execute();
    }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM T_BLG_authorsc WHERE BAC_id = '.(int) $id);
  }

  public function IsValidAuteur($value)
  {
    $requete = $this->dao->prepare('SELECT BAC_id FROM T_BLG_authorsc WHERE BAC_pseudo = :pseudo');
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