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
    $this->processForm($request);
    $this->page->addVar('title', 'Ajout d\'un auteur');
  }

  public function executeUpdate(HTTPRequest $request)
  {
    $this->processForm($request);
 
    $this->page->addVar('title', 'Modification d\'un auteur');
  }
  
  public function processForm(HTTPRequest $request)
  { 


    if ($request->method() == 'POST')
    {
      $author = new Author([
        'firstname' => $request->postData('firstname'),
        'lastname' => $request->postData('lastname'),
        'dateofbirth' => $request->postData('dateofbirth'),
        'auteur' => $request->postData('auteur'),
        'pwd' => $request->postData('pwd')
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
        $news = $this->managers->getManagerOf('Authors')->getUnique($request->getData('id'));
      }
      else
      {
        $author = new Author;
      }
    }
    
    $formBuilder = new AuthorFormBuilder($author);

    $formBuilder->build();

    $form = $formBuilder->form();

    var_dump($form->isValid());

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
        'id' => $request->getData('id'),
        'firstname' => $request->postData('firstname'),
        'lastname' => $request->postData('lastname'),
        'registrationdate' => $request->postData('registrationdate'),
        'dateofbirth' => $request->postData('dateofbirth'),
        'dateModif' => $request->postData('dateModif'),
        'pwd' => $request->postData('pwd'),
        'auteur' => $request->postData('auteur')
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
    $authorId = $request->getData('id');
    
    $this->managers->getManagerOf('Authors')->delete($authorId);

    $this->app->user()->setFlash('L\'auteur a bien été supprimée !');
    $this->app->httpResponse()->redirect('.');
  }


//List of all authors registered in the database
public function executeShow(HTTPRequest $request)
  {
    $author = $this->managers->getManagerOf('Authors')->getList($request->getData('id'));

    if (empty($author))
    {
      $this->app->httpResponse()->redirect404();
    }
    
    $this->page->addVar('author', $this->managers->getManagerOf('Authors')->getList($request->getData('id')));
    // $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
  }
}
?>

<?php

