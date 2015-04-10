<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\CheckBoxField;
use \OCFram\ExistingAuthorValidator;
use \OCFram\EmailField;
use \OCFram\EmailValidator;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class CommentFormBuilder extends FormBuilder
{
  public function build($value)
  {
    $this->form->add(new StringField([
        'label'      => 'Author',
        'name'       => 'auteur',
        'id'         => 'auteur',
        'maxLength'  => 50,
        'validators' => [
          new MaxLengthValidator('L\'auteur spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier l\'auteur du commentaire'),
        ],
       ]))
       ->add(new TextField([
        'label'      => 'Field',
        'name'       => 'contenu',
        'id'         => 'contenu',
        'rows'       => 7,
        'cols'       => 50,
        'validators' => [
          new NotNullValidator('Merci de spécifier votre commentaire'),
        ],
       ]))
       ->add(new EmailField([
        'label'      => 'Email',
        'name'       => 'email',
        'id'         => 'email',
        'validators' => [
          new NotNullValidator('Merci de spécifier votre email'),
          new EmailValidator('Merci de rentrer un email valide'),
        ],
       ]))
       ->add(new CheckBoxField([
        'label' => 'Be notified by mail',
        'name'  => 'avertissement',
        'id'    => 'avertissement',
       ]));
  }
}
?>