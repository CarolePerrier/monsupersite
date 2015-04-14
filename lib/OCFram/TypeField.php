<?php
namespace OCFram;

class TypeField extends Field
{
  protected $types = [];

  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<label>'.$this->label.'</label><select name="'.$this->name.'" id="'.$this->id.'"';
    
    $widget .= '>';

    foreach($this->types AS $type)
    {
       	//Utilise le tableau de valeurs
        if($this->value == $type['BAY_id'])
        {
          $widget .= '<option value='.$type['BAY_id'].' selected="selected">'.$type['BAY_description'].'</option>';
        }
        else
        {
          $widget .= '<option value='.$type['BAY_id'].'>'.$type['BAY_description'].'</option>';
        }
    }
    $widget .= '</select>';
    
    return $widget;
  }
  public function setType($types)
  {
  	$this->types = $types;
  }
  
}
?>
