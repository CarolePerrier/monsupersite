<?php
namespace OCFram;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \Entity\News;
use \Entity\Author;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\NewsFormBuilder;
use \FormBuilder\AuthorFormBuilder;
use \OCFram\FormHandler;
use \OCFram\managers;


class EmailValidator extends Validator
{
  public function __construct($errorMessage)
  {
    parent::__construct($errorMessage);
  }
  public function isValid($adress)
  {
    //Adresse mail trop longue (254 octets max) ou non conforme   
    return (strlen($adress)>254) || (filter_var('d', FILTER_VALIDATE_EMAIL) == false);
  }
}