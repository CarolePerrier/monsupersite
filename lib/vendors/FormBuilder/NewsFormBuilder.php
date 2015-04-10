<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \OCFram\ExistingAuthorValidator;

class NewsFormBuilder extends FormBuilder
{
  public function build($value)
  {
    $this->form
       ->add(new StringField([
        'label' => 'Title',
        'name' => 'titre',
        'id' => 'titre',
        'maxLength' => 100,
        'validators' => [
          new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier le titre de la news'),
        ],
       ]))
       ->add(new TextField([
        'label' => 'Field',
        'name' => 'contenu',
        'id' => 'contenu',
        'rows' => 8,
        'cols' => 60,
        'validators' => [
          new NotNullValidator('Merci de spécifier le contenu de la news'),
        ],
       ]));
  }
}
?>