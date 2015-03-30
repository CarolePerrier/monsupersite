<?php
namespace Entity;

use \OCFram\Entity;

class Author extends Entity
{
  protected $firstname,
            $lastname,
            $registrationdate,
            $dateofbirth,
            $dateModif,
            $pwd,
            $pseudo;

  const PRENOM_INVALIDE         = 1;
  const NOM_INVALIDE            = 2;
  const DATE_NAISSANCE_INVALIDE = 3;
  const PSEUDO_INVALIDE         = 4;
  const PWD_INVALIDE            = 5;

  public function isValid()
  {
    return !(empty($this->firstname) || empty($this->lastname) || empty($this->dateofbirth) || empty($this->pwd));
  }

  public function setFirsname($firstname)
  {
    if (!is_string($firstname) || empty($firstname))
    {
      $this->erreurs[] = self::PRENOM_INVALIDE;
    }

    $this->firstname = $firstname;
  }

  public function setPwd($pwd)
  {
    if (!is_string($pwd) || empty($pwd))
    {
      $this->erreurs[] = self::PWD_INVALIDE;
    }
    $this->pwd = $pwd;
  }

  public function setLastname($lastname)
  {
    if (!is_string($lastname) || empty($lastname))
    {
      $this->erreurs[] = self::NOM_INVALIDE;
    }

    $this->lastname = $lastname;
  }

  public function setRegistrationDate(\DateTime $date)
  {
    $this->registrationdate = $date;
  }

  public function setDateModif(\DateTime $date)
  {
    $this->dateModif = $date;
  }

  public function setDateOfBirth(\DateTime $date)
  {
    $this->dateofbirth = $date;
  }

  public function firstname()
  {
    return $this->firstname;
  }

  public function pwd()
  {
    return $this->pwd;
  }

  public function lastname()
  {
    return $this->lastname;
  }

  public function pseudo()
  {
    return $this->pseudo;
  }

  public function registrationdate()
  {
    return $this->registrationdate;
  }

  public function dateModif()
  {
    return $this->dateModif;
  }

  public function dateofbirth()
  {
    return $this->dateofbirth;
  }
}
?>