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