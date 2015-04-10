<?php
namespace OCFram;

class DateField extends Field
{
  
  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<label>'.$this->label.'</label><input type="date" name="'.$this->name.'" id="'.$this->id.'"';
    
    if (!empty($this->value))
    {
      $widget .= ' value="'.htmlspecialchars($this->value).'"';
    }
    
    return $widget .= ' />';
  }
}
?>