<?php
namespace App\Backend\Modules\Connexion;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \Entity\News;
use \Entity\Author;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\NewsFormBuilder;
use \FormBuilder\AuthorFormBuilder;
use \OCFram\FormHandler;

class ConnexionController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Connexion');
    
    if ($request->postExists('login'))
    {
      $login = $request->postData('login');
      $password = $request->postData('password');
      
      $author = $this->managers->getManagerOf('Authors')->getUnique($login, $password);
      
      if ($author != null)
      {
        if ($author->authors_fk_type == 1)
        {
          echo 'test de la variable auteur';
          
          $this->app->user()->setAuthenticatedAdmin(true);
          $this->app->httpResponse()->redirect('/admin/');
          die;

        }
        else
        {
          var_dump($author);
          echo $login, $password;
          
          $this->app->user()->setAuthenticated(true);
          $this->app->httpResponse()->redirect('/admin/');
        }
        

      }
      else
      {
        $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
      }
    }
  }
}
?>