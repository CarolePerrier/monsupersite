<?php
namespace OCFram;

class DateValidator extends Validator
{
  const $numberofparts = 3;
  
  public function isValid(\DateTime $value)
  {
    $test_arr  = explode('/', $test_date);
    if (count($test_arr) == $numberofparts) 
    {
      return checkdate($test_arr[0], $test_arr[1], $test_arr[2]);
    } 
      else 
    {
      return false;
    }
  } 
?>