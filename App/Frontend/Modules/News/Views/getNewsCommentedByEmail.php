<h2>Liste des news de <?php echo $email; ?></h2>

<table>
  <tr><th>Titre</th><th>Date d'ajout</th><th>Contenu</th></tr>
<?php

foreach ($listeNews as $news)
{
  echo '<tr><td>', $news['titre'], '</td><td>', $news['dateAjout'], '</td><td>', $news['contenu'], '</td><td>'; 
  if ($user->isAuthenticatedAdmin()) {
  echo  '<td><a href="/admin/news-update-', $news['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="/admin/news-delete-', $news['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td>';
  }
  echo '</td></tr>', "\n";
}
?>
</table>