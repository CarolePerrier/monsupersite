<?php
namespace OCFram;

class PasswordValidator extends Validator
{
  
  public function __construct($errorMessage, $form)
  {
    parent::__construct($errorMessage);
    $this->setform($form);
    //var_dump($form->entity());//die;
  }
  public function setform($form)
  {    
    $this->form = $form;  
  }
  public function isValid($value)
  {
    
    if($this->form->entity()->password() == $this->form->entity()->passwordCheck())
    {
      return true;
    }
    return false;
  }

}
?>