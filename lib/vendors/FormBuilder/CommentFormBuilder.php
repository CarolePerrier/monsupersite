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
        'label' => 'Auteur',
        'name' => 'auteur',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('L\'auteur spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier l\'auteur du commentaire'),
        ],
       ]))
       ->add(new TextField([
        'label' => 'Contenu',
        'name' => 'contenu',
        'rows' => 7,
        'cols' => 50,
        'validators' => [
          new NotNullValidator('Merci de spécifier votre commentaire'),
        ],
       ]))
       ->add(new EmailField([
        'label' => 'Email',
        'name' => 'email',
        'validators' => [
          new NotNullValidator('Merci de spécifier votre email'),
          new EmailValidator('Merci de rentrer un email valide'),
        ],
       ]))
       ->add(new CheckBoxField([
        'label' => 'Etre averti par mail des nouveaux commentaires',
        'name' => 'avertissement',
       ]));
  }
}
?>