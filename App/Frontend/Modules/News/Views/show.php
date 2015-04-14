<p>By <em><a href="/author-<?= $author->BAC_id?>/<?= $author->firstname() ?>-<?= $author->lastname()?>.html"><?= $author->pseudo() ?></a></em>, the <?= $news['dateAjout']->format('d/m/Y \a\t H\hi') ?></p>
<h2><?= $news['titre'] ?></h2>
<p><?= nl2br($news['contenu']) ?></p>
<div id="fond"></div>
<div id="modal" class="popup"></div>
<?php if ($news['dateAjout'] != $news['dateModif']) : ?>
  <p style="text-align: right;"><small><em>Modified the <?= $news['dateModif']->format('d/m/Y \a\t H\hi') ?></em></small></p>
<?php endif;

if (empty($comments))
{
  ?>
    <p id="nocomment">No comment posted yet. Be the first to add one !</p>
  <?php
}
/*********************************************Comments*********************************************/
?>


<div id="commentaires">
    <!-- les commentaires postés -->
    <?php
      foreach ($comments as $comment) {
    ?>
        <fieldset>
          <legend>
            Added by 
            <?php if($comment['email'] != null) : ?>
                <a href="/news-commented-by/<?= $comment['email'] ?>.html"><strong><?= htmlspecialchars($comment['auteur']) ?></strong></a>
            <?php else : ?>
                <strong><?= htmlspecialchars($comment['auteur']) ?></strong>
            <?php endif; ?>
             the <?= $comment['date']->format('d/m/Y \a\t H\hi') ?>
            <?php if ($user->isAuthenticatedAdmin()) { ?>
              <a href="admin/comment-update-<?= $comment['id'] ?>.html">Modify</a> |
              <a href="admin/comment-delete-<?= $comment['id'] ?>.html">Delete</a>
            <?php } ?>
          </legend>
          <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
        </fieldset>
    <?php } ?>
</div>

<h2>React</h2>
<form action="/commenter-<?= $news['id'] ?>.html" method="post" id="form">
  <p>
    <input type="hidden" id="news_id" value="<?= $news['id'] ?>" />
    <?= $form ?>
    <label value="" id="mistakes"></label>
    <input type="submit" value="Commenter" id="envoi"/>
  </p>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="./main.js" type="text/javascript"></script>
<script>
  $('#auteur').click(function(){
    document.getElementById('auteur').style.backgroundColor = "white";
    $('#mistakes').html('');
  });
  $('#contenu').click(function(){
    document.getElementById('contenu').style.backgroundColor = "white";
    $('#mistakes').html('');
  });
  $('#email').click(function(){
    document.getElementById('email').style.backgroundColor = "white";
    $('#mistakes').html('');
  });
  $('#envoi').click(function(e){
    //e.preventDefault(); // on empêche le bouton d'envoyer le formulaire
    var news    = <?php echo($news['id']); ?>;
    var author  = $('#auteur').val(); // on sécurise les données
    var field   = $('#contenu').val();
    var email   = $('#email').val();   
    var warning = $('#avertissement').val();
    var Mail = checkMail(email);
    var error = "You cannot submit this formular";
    
    if(author == "" || field == "" || email == "" || Mail == false){ // on vérifie que les variables ne sont pas vides 
      $('#mistakes').html('');
      if(Mail == false)
      {
        $('#mistakes').html('');
        $('#mistakes').append("Please enter a valid email adress<br/>");
        document.getElementById('email').style.backgroundColor = "red";
      }
      if(author == "")
      {
        document.getElementById('auteur').style.backgroundColor = "red";
      }
      if(field == "")
      {
        document.getElementById('contenu').style.backgroundColor = "red";
      }
      if(email == "")
      {
        document.getElementById('email').style.backgroundColor = "red";
      }
      $('#mistakes').append("You have to fill all fields");

    }
    else
    {
        if(document.getElementById('avertissement').checked == false)
        {
          warning = 'off';
        }
        else
        {
          warning = 'on';
        }
        $.ajax({
            url : "/commenter-"+ news +".html",
            type : "POST", // la requête est de type POST
            data : {
              news : news,
              auteur : author,
              contenu : field,
              email : email,
              avertissement : warning,
              error : error
            },// et on envoie nos données
            dataType : "json",
            success : function(html){
                var d = new Date();
                $('#nocomment').html('');
                $('#commentaires').append("<fieldset><legend>Added by <strong>" + author + "</strong> the " + d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear() + " at " + d.getHours() + "h" + d.getMinutes() + " </legend><p>" + field + "</p></fieldset>"); // on ajoute le message dans la zone prévue
                $('#form')[0].reset();
                showModal('Your comment is added !<br/>Thank you for your contribution ! ');
            }
        });

      }
      return false;
  });
  
</script>
