<?php
namespace App\Backend\Modules\Author;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Author;
use \Entity\News;
use \FormBuilder\AuthorFormBuilder;
use \FormBuilder\NewsFormBuilder;
use \OCFram\FormHandler;

class AuthorController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des auteurs');
    $manager = $this->managers->getManagerOf('Authors');
    $this->page->addVar('listeAuthors', $manager->getList());
    $this->page->addVar('nombreAuthor', $manager->count());
  }

  public function executeInsert(HTTPRequest $request)
  {
    if(!$this->app->user()->isAuthenticatedAdmin(true))
    {
      $this->app->httpResponse()->redirect('/admin/');
    }
    else
    {
      $this->processForm($request);
      $this->page->addVar('title', 'Ajout d\'un auteur');
    }
  }

  public function executeUpdate(HTTPRequest $request)
  {
    if(!$this->app->user()->isAuthenticatedAdmin(true))
    {
      $this->app->httpResponse()->redirect('/admin/');
    }
    else
    {
      $this->processForm($request); 
      $this->page->addVar('title', 'Modification d\'un auteur');
    }
  }
  
  public function processForm(HTTPRequest $request)
  { 


    if ($request->method() == 'POST')
    {

      $author = new Author([
        'firstname'   => $request->postData('firstname'),
        'lastname'    => $request->postData('lastname'),
        'dateofbirth' => $request->postData('dateofbirth'),
        'pseudo'      => $request->postData('pseudo'),
        'pwd'         => $request->postData('password'),
        'pwdCheck'    => $request->postData('passwordCheck'),
        'type'        => $request->postData('type'),
        'email'       => $request->postData('email'),
      ]);
      if ($request->getExists('id'))
      {
        $author->setId($request->getData('id'));
      }
    }
    else
    {
      // L'identifiant de l'auteur est transmis si on veut la modifier
      if ($request->getExists('id'))
      {
        $author = $this->managers->getManagerOf('Authors')->getUniqueId($request->getData('id'));
      }
      else
      {
        $author = new Author;
      }
    }
    $types = $this->managers->getManagerOf('Authors')->getTypes();
    
    $formBuilder = new AuthorFormBuilder($author);

    $formBuilder->build($types);

    $form = $formBuilder->form();

    // On récupère le gestionnaire de formulaire (le paramètre de getManagerOf() est bien entendu à remplacer).
    $formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('Authors'), $request);
    if ($formHandler->process())
    {
      $this->app->user()->setFlash($author->isNew() ? 'L\'auteur a bien été ajouté !' : 'L\'auteur a bien été modifié !');
      $this->app->httpResponse()->redirect('/admin/');
    }

    $this->page->addVar('form', $form->createView());
  }

  public function executeUpdateAuthors(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Modification d\'un auteur');

    if ($request->method() == 'POST')
    {
      $news = new Author([
        'BAC_id' => $request->getData('BAC_id'),
        'BAC_firstname' => $request->postData('BAC_firstname'),
        'BAC_lastname' => $request->postData('BAC_lastname'),
        'BAC_registrationdate' => $request->postData('BAC_registrationdate'),
        'BAC_dateofbirth' => $request->postData('BAC_dateofbirth'),
        'BAC_dateModif' => $request->postData('BAC_dateModif'),
        'BAC_password' => $request->postData('BAC_password'),
        'BAC_passwordCheck ' => $request->postData('BAC_passwordCheck'),
        'BAC_pseudo' => $request->postData('BAC_pseudo'),
        'BAC_email' => $request->postData('BAC_email'),
      ]);
    }
    else
    {
      $author = $this->managers->getManagerOf('Authors')->get($request->getData('id'));
    }

    $formBuilder = new AuthorFormBuilder($author);
    $formBuilder->build();

    $form = $formBuilder->form();

    if ($request->method() == 'POST' && $form->isValid())
    {
      $this->managers->getManagerOf('Authors')->save($author);
      $this->app->user()->setFlash('L\'auteur a bien été modifiée');
      $this->app->httpResponse()->redirect('/admin/');
    }

    $this->page->addVar('form', $form->createView());
  }

  public function executeDelete(HTTPRequest $request)
  {
    if(!$this->app->user()->isAuthenticatedAdmin(true))
    {
      $this->app->httpResponse()->redirect('/admin/');
    }
    else
    {
      $authorId = $request->getData('id');
      $this->managers->getManagerOf('Authors')->delete($authorId);
      $this->app->user()->setFlash('L\'auteur a bien été supprimée !');
      $this->app->httpResponse()->redirect('/admin/author-show.html');
    }
  }


//List of all authors registered in the database
public function executeShow(HTTPRequest $request)
  {
    $authors = $this->managers->getManagerOf('Authors')->getList();
    
    if (empty($authors))
    {
      $this->app->httpResponse()->redirect404();
    }
    $this->page->addVar('authors', $authors);
    // $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
  }

  //List of all authors registered in the database
public function executePasswordrecovering(HTTPRequest $request)
  {
    $login = $request->postData('login');
    $email = $request->postData('email');

    $author = $this->managers->getManagerOf('Authors')->getUnique($login); 
    if(is_null($author) || $author->email() != $email)
    {
      $message = "Le login ou l'email est incorrect";
    }
    else
    {
      $message = "Un email contenant votre mot de passe vous a été envoyé";
      // envoi du mail
      mail($author['email'], 'Récupération du mot de passe', $author->email());
      $this->page->addVar('message', $message);
    }
  }
}

