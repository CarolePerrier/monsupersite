<?php
namespace OCFram;

class Page extends ApplicationComponent
{
  protected $contentFile;
  protected $vars = [];
  protected $type;

  /**
   * test
   * @param string $var   varname
   * @param mixed $value value
   */
  public function addVar($var, $value)
  {
    if (!is_string($var) || is_numeric($var) || empty($var))//Si ce n'est pas une string, si c'est un nombre, si c'est vide
    {
      throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
    }
    //var_dump($var);
    $this->vars[$var] = $value;
  }

  public function getGeneratedPage()
  {
    //    var_dump($this->type);

    if (!file_exists($this->contentFile))
    {
      throw new \RuntimeException('La vue spécifiée n\'existe pas');
    }

    $user = $this->app->user();

    extract($this->vars);
    var_dump($this->type);

    ob_start();
      require $this->contentFile;
    $content = ob_get_clean();

    ob_start();
      require __DIR__.'/../../App/'.$this->app->name().'/Templates/layout.html.php';
    return ob_get_clean();
  }

  public function setContentFile($contentFile)
  {
    if (!is_string($contentFile) || empty($contentFile))
    {
      throw new \InvalidArgumentException('La vue spécifiée est invalide');
    }
    $this->contentFile = $contentFile;
  }
}