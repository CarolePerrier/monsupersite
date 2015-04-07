<?php
namespace App\Frontend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \OCFram\FormHandler;

class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $nombreNews = $this->app->config()->get('nombre_news');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
    
    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Liste des '.$nombreNews.' dernières news');
    
    // On récupère le manager des news.
    $manager = $this->managers->getManagerOf('News');
    
    // Cette ligne, vous ne pouviez pas la deviner sachant qu'on n'a pas encore touché au modèle.
    // Contentez-vous donc d'écrire cette instruction, nous implémenterons la méthode ensuite.
    $listeNews = $manager->getList(0, $nombreNews);
    
    foreach ($listeNews as $news)
    {
      if (strlen($news->contenu()) > $nombreCaracteres)
      {
        $debut = substr($news->contenu(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
        
        $news->setContenu($debut);
      }
    }
    
    // On ajoute la variable $listeNews à la vue.
    $this->page->addVar('listeNews', $listeNews);
  }

  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'news'          => $request->getData('news'),
        'auteur'        => $request->postData('auteur'),
        'contenu'       => $request->postData('contenu'),
        'email'         => $request->postData('email'),
        'avertissement' => $request->postData('avertissement')
      ]);
    }
    else
    {
      $comment = new Comment;
    }
      
    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build(NULL);

    $form = $formBuilder->form();

    // On récupère le gestionnaire de formulaire (le paramètre de getManagerOf() est bien entendu à remplacer).
    $formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');

      
      $authorList = $this->managers->getManagerOf('Comments')->getFollowersAuthors($comment->news());

      $subject = 'Subject';
      $message = 'Comment on news you follow!';
      foreach($authorList as $author)
      {
        //Do not send a mail to the sender email
        if(strcmp($comment->email(), $author['email']) == 0)
        {
          //mail($person['email'], $subject, $message);
          //var_dump($subject); 
          //var_dump($author['email']);        
          
        }
      }
      $this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
    }

    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');

    /*******************************************************/
    
  }


  public function executeShow(HTTPRequest $request)
  {
    $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
    

   
    if (empty($news))
    {
      $this->app->httpResponse()->redirect404();
    }

    $this->page->addVar('title', $news->titre());

    $this->page->addVar('news', $news);
    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
    $this->page->addVar('author', $this->managers->getManagerOf('Authors')->getUniqueId($news->news_fk_author));
    $this->executeInsertComment($request);
    

    }
    else
      {
        echo "Vous avez oublié de remplir un des champs !";
    }
        

  }


  public function executegetNewsCommentedByEmail(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Liste des news rédigées par le détenteur de l\'email');
    
    $this->page->addVar('email', $request->getData('email'));
    
    $this->page->addVar('listeNews', $this->managers->getManagerOf('Comments')->getNewsCommentedByEmail($request->getData('email')));
  }

  public function executeListNewsOfAuthor(HTTPRequest $request)
  {

    $this->page->addVar('title', 'Liste des news rédigées par l\'auteur');
    $this->page->addVar('listeNews', $this->managers->getManagerOf('News')->getListAuthor($request->getData('id')));
    $this->page->addVar('author', $this->managers->getManagerOf('Authors')->getUniqueId($request->getData('id')));
  }
}
?>  