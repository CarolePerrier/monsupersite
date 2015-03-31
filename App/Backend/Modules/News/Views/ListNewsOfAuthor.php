<h2>Liste des news de <?php echo $authorId; ?></h2>

<table>
  <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th></tr>
<?php
foreach ($listeNews as $news)
{
  echo '<tr><td>',$news['auteur'],'</td><td>', $news['titre'], '</td><td>', $news['dateAjout'], '</td><td>'; 
  if ($user->isAuthenticatedAdmin()) {
  echo  '<td><a href="news-update-', $news['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="news-delete-', $news['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td>';
  }
  echo '</td></tr>', "\n";
}
?>
</table>