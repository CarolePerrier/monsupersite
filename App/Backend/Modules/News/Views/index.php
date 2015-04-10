<h2>Liste des news</h2>
<?php if(!empty($listeNews)): ?>
    <p style="text-align: center" id='news'>There is <?= $nombreNews ?> news. Here is the list :</p>
<?php else : ?>
    <p style="text-align: center" id='nonews'>There is no news up to now, be the first to add one ! </p>
<?php endif; ?>

<table id="table">
  <tr><th>Author</th><th>Title</th><th>Creation date</th><th>Last change</th></tr>
<?php
foreach ($listeNews as $news)
{
  echo '<tr><td>', $news['auteur'], '</td><td>', $news['titre'], '</td><td>the ', $news['dateAjout']->format('d/m/Y \a\table H\hi'), '</td><td>', ($news['dateAjout'] == $news['dateModif'] ? '-' : 'le '.$news['dateModif']->format('d/m/Y à H\hi'));
  if ($user->isAuthenticatedAdmin()) {
  	echo  '<td><a href="news-update-', $news['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="news-delete-', $news['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td>';
  }
  echo '</td></tr>', "\n";
}
?>
</table>
<div id="fond"></div>
<div id="modal" class="popup"></div> 
<h2>Add a news</h2>

<form action="/admin/news-insert.html" method="post" name="formulaire">
  <p>
  	<input type="hidden" id="auteur" value="<?= $auteur ?>" />
    <?= $form?>    
    <input type="submit" value="Add" id="add"/>
  </p>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="/main.js" type="text/javascript"></script>
<script>
  var nombreNews=<?php echo($nombreNews); ?>;
  $('#titre').click(function(){
    document.getElementById('titre').style.backgroundColor = "white";
  });
  $('#contenu').click(function(){
    document.getElementById('contenu').style.backgroundColor = "white";
  });
  $('#add').click(function(e){
    //e.preventDefault(); // on empêche le bouton d'envoyer le formulaire
    var author  = $('#auteur').val();
  	var title = $('#titre').val();
  	var field = $('#contenu').val();

    var textTitle = "";
    var textField = "";
    
    if(title == "" || field == "")
    {
      if(title == "")
      {
        document.getElementById('titre').style.backgroundColor = "red";
        textTitle = 'You have to specify a title';
      }
      if(field == "")
      {
        document.getElementById('contenu').style.backgroundColor = "red";
        textField = 'You have to specify a field';
      }
      showModal(textTitle + '<br/>' + textField + '<br/>');
    }
    else
    { // on vérifie que les variables ne sont pas vides 
        $.ajax({
            url : "/admin/news-insert.html",
            type : "POST", // la requête est de type POST
            data : {
              auteur : author,
              contenu : field,
              titre : title
            },// et on envoie nos données
            datatype : 'json',
            success : function(html){
                var d = new Date();  
                $('#nonews').html('');
                nombreNews = nombreNews+1;

                $('#news').html("There is " + nombreNews + " news. Here is the list :");              
                $('#table').append("<tr><td>" + author + "</td><td>" + title + "</td><td>" + "the " + d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear() + " at " + d.getHours() + "h" + d.getMinutes() + "</td><td>" + "-</td>"); // on ajoute le message dans la zone prévue
                document.getElementById('titre').value = "";
                document.getElementById('contenu').value = "";
                showModal('Your news is added ! Thank you for your contribution ! ');
            }
        });
      }  
      return false;
  });
  
</script>