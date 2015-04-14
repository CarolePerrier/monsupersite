<?php
namespace App\Backend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \Entity\News;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\NewsFormBuilder;
use \OCFram\FormHandler;

class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des news');

    $news = new News; 
    $formBuilder = new NewsFormBuilder($news);
    $formBuilder->build(NULL);
    $form = $formBuilder->form();
   
    $manager = $this->managers->getManagerOf('News');
    $this->page->addVar('auteur',$this->app->user()->getAttribute('login'));
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('listeNews', $manager->getList());
    $this->page->addVar('nombreNews', $manager->count());
  }

  public function executeInsertAjax(HTTPRequest $request)
  {
    if(isset($_POST['auteur']) && isset($_POST['contenu']) && isset($_POST['titre']))
    {
      $variables = array(
        'auteur'        => $_POST['auteur'],
        'contenu'       => $_POST['contenu'],
        'titre'         => $_POST['titre']
      );

      $news = new News; 
      $formBuilder = new NewsFormBuilder($news);
      $formBuilder->build(NULL);

      $form = $formBuilder->form();
      
      $this->processForm($request);

    }
    else
    {
      echo "Un de vos champs est faux";
    }
    $this->page->addVar('auteur', $_POST['auteur']);
    $this->page->addVar('contenu', $_POST['contenu']);
    $this->page->addVar('titre', $_POST['titre']);
    $this->page->addVar('errors', $_POST['erreur']);
  }

  public function executeInsert(HTTPRequest $request)
  {
    $news = new News; 
    $formBuilder = new NewsFormBuilder($news);
    $formBuilder->build(NULL);
    $form = $formBuilder->form();
    $this->processForm($request);

    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'une news');
  }

  public function executeUpdate(HTTPRequest $request)
  {
    $news = new News; 
    $formBuilder = new NewsFormBuilder($news);
    $formBuilder->build(NULL);
    $form = $formBuilder->form();
    $this->processForm($request);
 
    $this->page->addVar('title', 'Modification d\'une news');
    $this->page->addVar('form', $form->createView());
  }
  
  public function processForm(HTTPRequest $request)
  {
    if ($request->method() == 'POST')
    {
      $news = new News([
        'auteur' => $this->app->user()->getAttribute('login'),
        'titre' => $request->postData('titre'),
        'contenu' => $request->postData('contenu')
      ]);

      if ($request->getExists('id'))
      {
        $news->setId($request->getData('id'));
      }
    }
    else
    {
      // L'identifiant de la news est transmis si on veut la modifier
      if ($request->getExists('id'))
      {
        $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
      }
      else
      {
        $news = new News;        
      }
    }
    $newsList = $this->managers->getManagerOf('Authors')->getList();
    $formBuilder = new NewsFormBuilder($news);
    $formBuilder->build($newsList);

    $form = $formBuilder->form();

    // On récupère le gestionnaire de formulaire (le paramètre de getManagerOf() est bien entendu à remplacer).
    $formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('News'), $request);
    if ($formHandler->process())
    {
      //$this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
      //$this->app->httpResponse()->redirect('/admin/');
    }

  }

  public function executeUpdateComment(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Modification d\'un commentaire');

    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'id' => $request->getData('id'),
        'auteur' => $request->postData('auteur'),
        'contenu' => $request->postData('contenu'),
        'email' => $request->postData('email')
      ]);
    }
    else
    {
      $comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
    }

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build(NULL);

    $form = $formBuilder->form();

    if ($request->method() == 'POST' && $form->isValid())
    {
      $this->managers->getManagerOf('Comments')->save($comment);
      $this->app->user()->setFlash('Le commentaire a bien été modifié');
      $this->app->httpResponse()->redirect('/admin/');
    }

    $this->page->addVar('form', $form->createView());
  }

  public function executeDeleteComment(HTTPRequest $request)
  {
    $comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
    $this->managers->getManagerOf('Comments')->delete($request->getData('id'));
    $this->app->user()->setFlash('Le commentaire a bien été supprimé !');    
    $this->app->httpResponse()->redirect('/news-'.$comment->news().'.html');
  }

  public function executeDelete(HTTPRequest $request)
  {
    $newsId = $request->getData('id');
    
    $this->managers->getManagerOf('News')->delete($newsId);
    $this->managers->getManagerOf('Comments')->deleteFromNews($newsId);

    $this->app->user()->setFlash('La news a bien été supprimée !');

    $this->app->httpResponse()->redirect('.');
  }
  
  public function executeListNewsOfAuthor(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Liste des news rédigées par l\'auteur');
    $this->page->addVar('listeNews', $this->managers->getManagerOf('News')->getListAuthor($request->getData('id')));
    $this->page->addVar('authorId', $this->managers->getManagerOf('Authors')->getUniqueId($request->getData('id')));
  }
}


