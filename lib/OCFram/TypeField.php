<?php
namespace OCFram;

class TypeField extends Field
{
  protected $type = [];

  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<label>'.$this->label.'</label><select name="'.$this->name.'" ';
    
    $widget .= '>';

    foreach($this->type AS $type)
    {
    	
       	//Utilise le tableau de valeurs
       	$widget .= '<option value='.$type['value'].'>'.$type['print'].'</option>';
    }
    $widget .= '</select>';
    
    return $widget;
  }
  public function setType($type)
  {
  	$this->type = $type;
  }
  
}
?>
