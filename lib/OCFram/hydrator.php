<?php
namespace OCFram;
//trait permettant d'hydrater à la fois la classe entity et la classe field
trait Hydrator
{
  public function hydrate($data)
  {
    foreach ($data as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      
      if (is_callable([$this, $method]))
      {
        $this->$method($value);
      }
    }
  }
}
?>