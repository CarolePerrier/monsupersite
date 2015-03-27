<?php
namespace App\Backend\Modules\LogOut;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class LogOutController extends BackController
{
  public function executeLogOut(HTTPRequest $request)
  {
    $this->page->addVar('title', 'LogOut');
    if ($this->app->user()->isAuthenticated() == true)
    {
      $this->app->user()->setAuthenticated(false);
      $this->app->httpResponse()->redirect('/admin/');
    }
  }
}
?>

<!-- $this->page->addVar('title', 'Connexion');
    
    if ($request->postExists('login'))
    {
      $login = $request->postData('login');
      $password = $request->postData('password');
      
      if ($login == $this->app->config()->get('login') && $password == $this->app->config()->get('pass'))
      {
        $this->app->user()->setAuthenticated(true);
        $this->app->httpResponse()->redirect('.');
      }
      else
      {
        $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
      }
    } -->