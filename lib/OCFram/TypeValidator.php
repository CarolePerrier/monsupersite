<?php
namespace OCFram;

class TypeValidator extends Validator
{
  public function isValid($value)
  {
    return $value == 'root' || $value == 'user';
  }
}
?>