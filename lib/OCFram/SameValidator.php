<?php
namespace OCFram;

class SameValidator extends Validator
{
  
  public function __construct($errorMessage, $field)
  {
    parent::__construct($errorMessage);
    $this->setfield($field);
    //var_dump($form->entity());//die;
  }
  public function setfield($field)
  {    
    $this->field = $field;  
  }
  public function isValid($value)
  {
    if($this->field->value() == $value)
    {
      return true;
    }
    return false;
  }

}
?>