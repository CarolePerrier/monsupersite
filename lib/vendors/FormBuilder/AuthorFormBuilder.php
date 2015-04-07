<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\PasswordField;
use \OCFram\PasswordValidator;
use \OCFram\TextField;
use \OCFram\NumberField;
use \OCFram\TypeField;
use \OCFram\EmailField;
use \OCFram\EmailValidator;
use \OCFram\DateField;
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
          new MaxLengthValidator('Le Auteur de l\'auteur spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le BAC_pseudo de l\'auteur'),
        ],
       ]))
       ->add(new StringField([
        'label' => 'Firstname',
        'name' => 'firstname',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le prénom spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le prénom de l\'auteur'),
        ],
       ]))
       ->add(new StringField([
        'label'      => 'Lastname',
        'name'       => 'lastname',
        'maxLength'  => 50,
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
       ->add(new PasswordField([
        'label'      => 'Mot de Passe',
        'name'       => 'password',
        'maxLength'  => 50,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier un mot de passe'),
          //new PasswordValidator('Les mots de passe sont différents', $this->form),
        ],
      ]))
       ->add(new PasswordField([
        'label'      => 'Confirmation',
        'name'       => 'passwordCheck',
        'maxLength'  => 50,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier un mot de passe'),
          new PasswordValidator('Les mots de passe sont différents', $this->form),
        ],
      ]))
       ->add(new EmailField([
        'label'      => 'Email',
        'name'       => 'email',
        'validators' => [
          new NotNullValidator('Merci de spécifier votre email'),
          new EmailValidator('Merci de rentrer un email valide'),
        ],
       ]))
      ->add(new TypeField([
        'label' => 'Type',
        'name'  => 'type',
        'type'  => [
                    'admin' => ['print' => 'admin', 'value' => 1],
                    'author' => ['print' => 'author', 'value' => 2],
                  ]
       ])) 
       ;
  }
}
?>