<?php
namespace OCFram;

class NumberField extends Field
{
  
  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<label>'.$this->label.'</label><input type="number" name="'.$this->name.'" min="1" max="4"';
    
    
    $widget .= ' value="1"';
    
    
    return $widget .= ' />';
  }
}
?>