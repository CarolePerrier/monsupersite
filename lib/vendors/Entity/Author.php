<?php
namespace Entity;

use \OCFram\Entity;

class Author extends Entity
{
  protected $BAC_firstname,
            $BAC_lastname,
            $BAC_registrationdate,
            $BAC_dateofbirth,
            $BAC_dateModif,
            $BAC_password,
            $BAC_passwordCheck,
            $BAC_pseudo,
            $type,
            $BAC_email,
            $BAC_salt;

  const PRENOM_INVALIDE         = 1;
  const NOM_INVALIDE            = 2;
  const DATE_NAISSANCE_INVALIDE = 3;
  const PSEUDO_INVALIDE         = 4;
  const PWD_INVALIDE            = 5;

  public function isValid()
  {
    return !(empty($this->BAC_firstname) || empty($this->BAC_lastname) || empty($this->BAC_dateofbirth) || empty($this->BAC_password) || empty($this->type));

  }

  public function setFirstname($firstname)
  {
    if (!is_string($firstname) || empty($firstname))
    {
      $this->erreurs[] = self::PRENOM_INVALIDE;
    }

    $this->BAC_firstname = $firstname;
  }

  public function setPwd($password)
  {
    if (!is_string($password) || empty($password))
    {
      $this->erreurs[] = self::PWD_INVALIDE;
    }  
    $this->BAC_password = $password;
  }

  public function setPwdCheck($passwordCheck)
  {
    if (!is_string($passwordCheck) || empty($passwordCheck))
    {
      $this->erreurs[] = self::PWD_INVALIDE;
    }
    //var_dump($this->BAC_salt);
    $this->BAC_passwordCheck = $passwordCheck;
  }

  public function setLastname($lastname)
  {
    if (!is_string($lastname) || empty($lastname))
    {
      $this->erreurs[] = self::NOM_INVALIDE;
    }

    $this->BAC_lastname = $lastname;
  }

  public function setRegistrationDate(\DateTime $date)
  {
    $this->BAC_registrationdate = $date;
  }

  public function setDateModif(\DateTime $date)
  {
    $this->BAC_dateModif = $date;
  }

  public function setDateOfBirth($date)
  {
    $this->BAC_dateofbirth = $date;
  }

  public function setPseudo($BAC_pseudo) {
    $this->BAC_pseudo = $BAC_pseudo;
  } 

  public function setType($type) {
    $this->type = $type;
  } 

  public function setEmail($BAC_email) {
    $this->BAC_email = $BAC_email;
  } 

  public function setSalt($BAC_salt) {
    $this->BAC_salt = $BAC_salt;
  }

  public function firstname()
  {
    return $this->BAC_firstname;
  }

  public function password()
  {
    return $this->BAC_password;
  }

  public function passwordCheck()
  {
    return $this->BAC_passwordCheck;
  }

  public function lastname()
  {
    return $this->BAC_lastname;
  }

  public function pseudo()
  {
    return $this->BAC_pseudo;
  }

  public function registrationdate()
  {
    return $this->BAC_registrationdate;
  }

  public function dateModif()
  {
    return $this->BAC_dateModif;
  }

  public function dateofbirth()
  {
    return $this->BAC_dateofbirth;
  }

  public function type()
  {
    return $this->type;
  }

  public function email()
  {
    return $this->BAC_email;
  }

  public function salt()
  {
    return $this->BAC_salt;
  }
}
?>
