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
        <h1><a href="/">My Great Website</a></h1>
        <p><br/>
          <?php if($user->getAttribute('login')) : ?>  
              Hi <?php echo $user->getAttribute('login') ?>,
          <?php else : ?>
              You're not logged
          <?php endif;?>
        </p>
      </header>
      
      <nav>
        <ul>
          <li><a href="/">Home</a></li>
          <?php if ($user->isAuthenticated()) : ?>
          <li><a href="/admin/">News</a></li>
          <!--<li><a href="/admin/news-insert.html">Add news</a></li>-->
          <li><a href="/admin/author-show.html">Authors</a></li>

          <?php if ($user->isAuthenticatedAdmin()) : ?>
          <li><a href="/admin/author-insert.html">Add Author</a></li>
          <?php  endif; ?>
          <li><a href="/admin/LogOut/">Logout</a></li>
          <?php endif; ?>
          <li><a href="/yourdevice.html">Your Device</a></li>

          <?php if (!$user->isAuthenticated()) : ?>
          <li><a href="/author-password-recovering.html">Pwd recovering</a></li>
          <li><a href="/admin/connection.html">Connection</a></li>
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