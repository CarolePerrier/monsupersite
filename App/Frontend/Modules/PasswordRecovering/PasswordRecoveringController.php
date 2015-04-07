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
	      	  $new_password = '';
	      	  for ($i = 0; $i < 8; $i++) 
		      {
		        $new_password .= substr("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 1);
		      }
		      $new_crypt_mdp = substr(crypt($new_password, $author->salt()),0,50);
		      $this->managers->getManagerOf('Authors')->modifyPassword($author, $new_crypt_mdp);
		      $author = $this->managers->getManagerOf('Authors')->getUnique($login);
		  	  
		      $subject = 'Récupération du mot de passe de '.$login;
		   	  $message = 'Bonjour '.$login.', votre mot de passe est : '.$new_password;
		   	  
		   	   var_dump($email);
		   	   var_dump($subject);
		   	   var_dump($message);
		   	   die;
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