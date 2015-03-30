<?php
namespace App\Backend\Modules\Connexion;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \lib;

class ConnexionController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Connexion');
    
    /*if ($request->postExists('login'))
    {
      $login = $request->postData('login');
      $password = $request->postData('password');
      
      if ($login == $this->app->config()->get('login') && $password == $this->app->config()->get('pass') && '$login' != 1)
      {
        $this->app->user()->setAuthenticated(true);
        $this->app->httpResponse()->redirect('.');
      }
      elseif ($login == $this->app->config()->get('login') && $password == $this->app->config()->get('pass') && '$login' == 1)
      {
        $this->app->user()->setAuthenticatedAdmin(true);
        $this->app->httpResponse()->redirect('.');
      }
      else
      {
        $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
      }
    }
  }
}*/




$requete = $this->dao->prepare('SELECT id, authors_fk_authorsy FROM authors WHERE pseudo = :pseudo AND pwd = :pwd');
    
    $requete->bindValue(':pseudo', $login);
    $requete->bindValue(':pwd', $password);
    
    $requete->execute();
    //Login and pwd found in the database
    if ($author = $requete->fetch())
    {
      if ($author->authors_fk_authorsy == 1)
      {
        $this->app->user()->setAuthenticatedAdmin(true);
      }
      else
      {
        $this->app->user()->setAuthenticated(true);
      }
      $this->app->httpResponse()->redirect('.');
    }
    else
    {
      $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
    }
  }
}
?>