<?php
namespace OCFram;

class TypeValidator extends Validator
{
  protected $types;

  public function __construct($errorMessage, $types)
  {
    parent::__construct($errorMessage);    
    $this->setType($types);
  }

  public function isValid($value)
  {
  	foreach ($this->types as $type) 
  	{

  		if($type['BAY_id'] == $value)
  		{
  			return true;
  		}
  	}
    return false;
  }

  public function setType($types)
  {    
    if (isset($types))
    {
      $this->types = $types;
    }
    else
    {
      throw new \RuntimeException('Il doit y avoir au moins un type dans la base');
    }
  }
  
}
?>