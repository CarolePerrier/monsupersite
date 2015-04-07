<!DOCTYPE html>
<html>
  <head>
    <title>
      <?= isset($title) ? $title : 'Mon super site' ?>
    </title>
    
    <meta charset="utf-8" />
    
    <link rel="stylesheet" href="/css/Envision.css" type="text/css" />
  </head>
  
  <body>
    <div id="wrap">
      <header>
        <h1><a href="/">Mon super site</a></h1>
        <p>Comment ça, il n'y a presque rien ?<br/>
          <?php if($user->getAttribute('login')) : ?>  
              Bonjour <?php echo $user->getAttribute('login') ?> 
          <?php else : ?>
              Vous n'êtes pas connecté
          <?php endif;?>
        </p>
      </header>
      
      <nav>
        <ul>
          <li><a href="/">Accueil</a></li>
          <?php if ($user->isAuthenticated()) : ?>
          <li><a href="/admin/">Admin</a></li>
          <li><a href="/admin/news-insert.html">Add news</a></li>
          <li><a href="/admin/author-show.html">List of Autors</a></li>
          <?php if ($user->isAuthenticatedAdmin()) : ?>
          <li><a href="/admin/author-insert.html">Add Author</a></li>
          <?php  endif; ?>
          <li><a href="/admin/LogOut/">Logout</a></li>
          <?php endif; ?>
          <li><a href="/yourdevice.html">Your Device</a></li>
          <?php if (!$user->isAuthenticated()) : ?>
          <li><a href="/author-password-recovering.html">Récupération mdp</a></li>
          <li><a href="/admin/connexion.html">Connexion</a></li>
        <?php endif; ?>
        </ul>
      </nav>
      
      <div id="content-wrap">
        <section id="main">
          <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
          
          <?= $content ?>
        </section>
      </div>
    
      <footer></footer>
    </div>
  </body>
</html>