<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Author;

abstract class AuthorsManager extends Manager
{
  /**
   * Méthode permettant d'ajouter un auteur.
   * @param $author Le commentaire à ajouter
   * @return void
   */
  abstract protected function add(Author $author);
  
  /**
   * Méthode permettant d'enregistrer un auteur.
   * @param $author L'auteur à enregistrer
   * @return void
   */
  public function save(Author $author)
  {
    if ($author->isValid())
    {
      $author->isNew() ? $this->add($author) : $this->modify($author);
    }
    else
    {
      throw new \RuntimeException('L\'auteur doit être validé pour être enregistré');
    }
  }
  
  /**
   * Méthode permettant de récupérer une liste d'auteurs.
   * @param $authors L'auteur sur lequelle on veut récupérer les news
   * @return array
   */
  abstract public function getList($author);

  abstract public function getUnique($login, $password);

  /**
   * Méthode permettant de supprimer un auteur.
   * @param $id L'identifiant de l'auteur à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant de supprimer tous les commentaires liés à une news
   * @param $author L'identifiant de l'auteur dont les commentaires doivent être supprimés
   * @return void
   */
  //abstract public function deleteFromAuthors($author);


  abstract public function count();

  abstract public function IsValidAuteur($value);
}
?>