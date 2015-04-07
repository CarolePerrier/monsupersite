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

  public function getTypes()
  {
    $requete = $this->dao->prepare('SELECT * FROM T_BLG_authorsy');
    $requete->execute();
    $listTypes = $requete->fetchAll();
    return $listTypes;
  }

  public function getUnique($login)
  {
    $requete = $this->dao->prepare('SELECT BAC_id, BAC_firstname, BAC_lastname, BAC_pseudo, BAC_password, BAC_dateofbirth, BAC_registrationdate, BAC_dateModif, BAC_email, authors_fk_type, BAC_salt FROM T_BLG_authorsc WHERE BAC_pseudo = :pseudo LIMIT 1');

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
    $salt = "$2y$14$";
    for ($i = 0; $i < 22; $i++) 
    {
      $salt .= substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 1);
    }

    $requete = $this->dao->prepare('INSERT INTO T_BLG_authorsc SET BAC_firstname = :firstname, BAC_lastname = :lastname, BAC_password = :password, BAC_pseudo = :pseudo, BAC_registrationdate = NOW(), BAC_dateofbirth = :dateofbirth, BAC_dateModif = NOW(), authors_fk_type = :type, BAC_email = :email, BAC_salt = :salt');

    $requete->bindValue(':firstname', $author->firstname());
    $requete->bindValue(':lastname', $author->lastname());
    $requete->bindValue(':password', crypt($author->password(), $salt));
    $requete->bindValue(':pseudo', $author->pseudo());
    $requete->bindValue(':dateofbirth', $author->dateofbirth());
    $requete->bindValue(':type', $author->type());
    $requete->bindValue(':email', $author->email());
    $requete->bindValue(':salt', $salt);
    
    $requete->execute();

    echo 'salt '.$salt;//die;
  }

  public function modify(Author $author)
  {
    $salt = "$2y$14$";
    for ($i = 0; $i < 22; $i++) 
    {
      $salt .= substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 1);
    }
    $requete = $this->dao->prepare('UPDATE T_BLG_authorsc SET BAC_firstname = :firstname, BAC_lastname = :lastname, BAC_password = :password, BAC_pseudo = :pseudo, BAC_dateofbirth = :dateofbirth, BAC_dateModif = NOW(), BAC_email = :email, BAC_salt = :salt WHERE BAC_pseudo = :pseudo');
    
    $requete->bindValue(':firstname', $author->firstname());
    $requete->bindValue(':lastname', $author->lastname());
    $requete->bindValue(':pseudo', $author->pseudo());
    $requete->bindValue(':password', crypt($author->password(), $salt));
    $requete->bindValue(':dateofbirth', $author->dateofbirth());
    $requete->bindValue(':email', $author->email());
    $requete->bindValue(':salt', $salt);
    
    $requete->execute();
  }

  public function modifyPassword(Author $author, $newPassword)
  {
    $requete = $this->dao->prepare('UPDATE T_BLG_authorsc SET BAC_password = :password WHERE BAC_id = :id');
    
    $requete->bindValue(':password', $newPassword);
    $requete->bindValue(':id', $author->BAC_id);
    
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
      return false;
    }
    return true;
  }
}
?>