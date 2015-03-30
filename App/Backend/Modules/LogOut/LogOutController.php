<?php
namespace App\Backend\Modules\LogOut;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class LogOutController extends BackController
{
  public function executeLogOut(HTTPRequest $request)
  {
    if ($this->app->user()->isAuthenticatedAdmin() == true)
    {
      $this->app->user()->setAuthenticated(false);
      $this->app->user()->setAuthenticatedAdmin(false);
      $this->app->httpResponse()->redirect('/');
    }
    elseif ($this->app->user()->isAuthenticated() == true)
    {
      $this->app->user()->setAuthenticated(false);
      $this->app->httpResponse()->redirect('/');
    }
  }
}
?>