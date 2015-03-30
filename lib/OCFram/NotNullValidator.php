<?php
namespace OCFram;

class NotNullValidator extends Validator
{
  public function isValid($value)
  {
  	var_dump($value);
    return $value != '';
  }
}
?>