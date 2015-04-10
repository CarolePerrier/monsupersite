<?php
namespace OCFram;

class Route
{
  protected $action;
  protected $module;
  protected $url;
  protected $varsNames;
  protected $vars = [];

  protected $typeName;
  protected $type;

  public function __construct($url, $module, $action, array $varsNames, $typeName)
  {
    $this->setUrl($url);
    $this->setModule($module);
    $this->setAction($action);
    $this->setVarsNames($varsNames);
    $this->setTypeName($typeName);
  }

  public function hasVars()
  {
    return !empty($this->varsNames);
  }

  public function hasType()
  {
    return !empty($this->typeName);
  }

  public function match($url)
  {
    if (preg_match('`^'.$this->url.'$`', $url, $matches))
    {
      return $matches;
    }
    else
    {
      return false;
    }
  }

  public function setAction($action)
  {
    if (is_string($action))
    {
      $this->action = $action;
    }
  }

  public function setModule($module)
  {
    if (is_string($module))
    {
      $this->module = $module;
    }
  }

  public function setUrl($url)
  {
    if (is_string($url))
    {
      $this->url = $url;
    }
  }

  public function setVarsNames(array $varsNames)
  {
    $this->varsNames = $varsNames;
  }

  public function setTypeName($typeName)
  {
    $this->typeName = $typeName;
  }

  public function setVars(array $vars)
  {
    $this->vars = $vars;
  }

  public function setType($type)
  {
    $this->type = $type;
  }
  //getter
  public function action()
  {
    return $this->action;
  }

  public function module()
  {
    return $this->module;
  }

  public function vars()
  {
    return $this->vars;
  }

  public function type()
  {
    return $this->type;
  }

  public function varsNames()
  {
    return $this->varsNames;
  }

  public function typeName()
  {
    return $this->typeName;
  }
}
?>