<?php
namespace OCFram;

abstract class Application
{
  protected $httpRequest;
  protected $httpResponse;
  protected $name;
  protected $User;
  protected $Config;
  
  public function __construct()
  {
    $this->httpRequest  = new HTTPRequest($this);
    $this->httpResponse = new HTTPResponse($this);
    $this->name         = '';
    $this->User         = new User($this);
    $this->Config       = new Config($this);
  }
  
  public function getController()
  {
    $router = new Router;

    $xml = new \DOMDocument;
    $xml->load(__DIR__.'/../../App/'.$this->name.'/Config/routes.xml');
    //get all the path in the XML file
    $routes = $xml->getElementsByTagName('route');

    // On parcourt les routes du fichier XML.
    $type = "";
    foreach ($routes as $route)
    {
      $vars = [];
      // On regarde si des variables sont présentes dans l'URL.
      if ($route->hasAttribute('vars'))
      {
        $vars = explode(',', $route->getAttribute('vars'));
      }
      if ($route->hasAttribute('type'))
      {
        $type = $route->getAttribute('type');
      }
      else
      {
        $type = '';
      }
      // On ajoute la route au routeur.
      $router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars, $type));
       
    }
    try
    {
      // On récupère la route correspondante à l'URL.
      $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
    }
    catch (\RuntimeException $e)
    {
      if ($e->getCode() == Router::NO_ROUTE)
      {
        // Si aucune route ne correspond, c'est que la page demandée n'existe pas.
        $this->httpResponse->redirect404();
      }
    }

    // On ajoute les variables de l'URL au tableau $_GET.
    $_GET = array_merge($_GET, $matchedRoute->vars());

    // On instancie le contrôleur.
    $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
      
    return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action(), $matchedRoute->type());
  }
  
  abstract public function run();
  
  public function httpRequest()
  {
    return $this->httpRequest;
  }
  
  public function httpResponse()
  {
    return $this->httpResponse;
  }
  
  public function name()
  {
    return $this->name;
  }

  public function Config()
  {
    return $this->Config;
  }
 
  public function User()
  {
    return $this->User;
  }
}
?>