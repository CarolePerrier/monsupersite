<?php
namespace Entity;

use \OCFram\Entity;

class Comment extends Entity
{
  protected $commentaireId,
            $auteurId;

  public function Commentaire()
  {
  	return $this->commentaireId;
  }
  public function Auteur()
  {
  	return $this->auteurId;
  }
  public function setCommentaire($commentaireId)
  {
  	return $this->commentaireId = $commentaireId;
  }
  public function setAuteur($auteurId)
  {
  	return $this->commentaireId = $auteurId;
  }
