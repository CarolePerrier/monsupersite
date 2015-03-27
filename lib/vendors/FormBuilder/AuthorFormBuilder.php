<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class AuthorFormBuilder extends FormBuilder
{
  public function build()
  {
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
          new DateFormatValidator('Le texte ne représente pas une date valide'),
          new NotNullValidator('Merci de spécifier une date'),
        ],
      ]));
  }
}
?>