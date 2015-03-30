<?php
namespace OCFram;

class DateValidator extends Validator
{
  
  
  public function isValid($value)
  {

    $numberofparts = 3;
    $test_arr  = explode('/', $value);
    if (count($test_arr) == $numberofparts) 
    {
      return checkdate($test_arr[0], $test_arr[1], $test_arr[2]);
    } 
      else 
    {
      return false;
    }
  }
} 
?>