<?php
namespace App\Frontend\Modules\PasswordRecovering;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Author;
use \Entity\News;
use \FormBuilder\AuthorFormBuilder;
use \FormBuilder\NewsFormBuilder;
use \OCFram\FormHandler;

class PasswordRecoveringController extends BackController
{
	public function executeIndex(HTTPRequest $request)
  	{
	    $this->page->addVar('title', 'Récupération mot de passe');
	    
	    if ($request->postExists('login'))
	    {
	      $login = $request->postData('login');
	      $email = $request->postData('email');

	      $author = $this->managers->getManagerOf('Authors')->getUnique($login);
	      if(isset($author) && $author->email() == $email)
	      {
		      $subject = 'Récupération du mot de passe de '.$login;
		   	  $message = 'Bonjour '.$login.', votre mot de passe est '.$author['BAC_password'];
		   	  $message .= $login;
		   	  // var_dump($email);
		   	  // var_dump($subject);
		   	  // var_dump($message);
		   	  // die;
		      //mail($email, $subject, $message);
		      
		      echo 'Un email vous a été envoyé à l\'adresse suivante : '.$email;
		      $this->app->httpResponse()->redirect('/');
		      echo 'Un email vous a été envoyé à l\'adresse suivante : '.$email;
		  }
		  else
		  {
		  	echo 'L\'identifiant ou le mot de passe est incorrect';
		  }
  		}
  	}
}