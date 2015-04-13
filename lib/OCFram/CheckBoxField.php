<?php
namespace OCFram;

class CheckBoxField extends Field
{
  
  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<label>'.$this->label.'</label><input type="checkbox" name="'.$this->name.'"';
    if (!empty($this->value))
    {
      $widget .= 'value=';
    }
    
    
    $widget .= 'id="'.$this->id.'"';
    
    return $widget .= ' />';
  }
}
?>
