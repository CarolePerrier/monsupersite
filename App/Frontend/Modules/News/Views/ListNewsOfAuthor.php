<h2>Liste des news de <?php echo $authorId->pseudo(); ?></h2>

<table>
  <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Contenu</th></tr>
<?php
foreach ($listeNews as $news)
{
  echo '<tr><td>',$authorId->pseudo(),'</td><td>', $news['titre'], '</td><td>', $news['dateAjout'], '</td><td>', $news['contenu'], '</td><td>'; 
  echo '</td></tr>', "\n";
}
?>
</table>