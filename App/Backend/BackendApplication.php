<?php
namespace App\Backend;

use \OCFram\Application;

class BackendApplication extends Application
{
  public function __construct()
  {
    parent::__construct();

    $this->name = 'Backend';
  }

  public function run()
  {

    $controller = $this->getController();
    if (!$this->User->isAuthenticated())
    {
      $controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'index', $controller->type());
    }

    $controller->execute();

    $this->httpResponse->setPage($controller->page());
    $this->httpResponse->send();
  }
}
?>