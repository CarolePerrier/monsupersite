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
        'pseudo' => $request->postData('pseudo')
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
    
    $formBuilder = new NewsFormBuilder($author);
    $formBuilder->build();

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

  public function executeUpdateNews(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Modification d\'une news');

    if ($request->method() == 'POST')
    {
      $news = new News([
        'id' => $request->getData('id'),
        'titre' => $request->postData('titre'),
        'auteur' => $request->postData('news_fk_author'),
        'contenu' => $request->postData('contenu')
      ]);
    }
    else
    {
      $news = $this->managers->getManagerOf('News')->get($request->getData('id'));
    }

    $formBuilder = new NewsFormBuilder($news);
    $formBuilder->build();

    $form = $formBuilder->form();

    if ($request->method() == 'POST' && $form->isValid())
    {
      $this->managers->getManagerOf('News')->save($news);
      $this->app->user()->setFlash('La news a bien été modifiée');
      $this->app->httpResponse()->redirect('/admin/');
    }

    $this->page->addVar('form', $form->createView());
  }

  public function executeDeleteNews(HTTPRequest $request)
  {
    $this->managers->getManagerOf('News')->delete($request->getData('id'));
    
    $this->app->user()->setFlash('La News a bien été supprimée !');
    
    $this->app->httpResponse()->redirect('.');
  }

  public function executeDelete(HTTPRequest $request)
  {
    $newsId = $request->getData('id');
    
    $this->managers->getManagerOf('Authors')->delete($authorId);
    $this->managers->getManagerOf('News')->deleteFromNews($newsId);

    $this->app->user()->setFlash('La news a bien été supprimée !');

    $this->app->httpResponse()->redirect('.');
  }
}
?>

<?php

