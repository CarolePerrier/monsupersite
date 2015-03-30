<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \OCFram\DateValidator;

class AuthorFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'label' => 'Pseudo',
        'name' => 'pseudo',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le pseudo spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le prénom de l\'auteur'),
        ],
       ]))
    $this->form->add(new StringField([
        'label' => 'Firstname',
        'name' => 'firstname',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le prénom spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le prénom de l\'auteur'),
        ],
       ]))
       ->add(new StringField([
        'label' => 'Lastname',
        'name' => 'lastname',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le nom spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier votre nom'),
        ],
       ]))
       ->add(new DateField([
        'label' => 'Date of Birth',
        'name' => 'dateofbirth',
        'validators' => [
          new DateValidator('La date n\'est pas valide'),
          new NotNullValidator('Merci de spécifier une date'),
          new DateValidator('Date incorrecte'),
        ],
      ]))
       ->add(new StringField([
        'label' => 'Mot de Passe',
        'name' => 'pwd',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le prénom de l\'auteur'),
        ],
       ]));
  }
}
?>