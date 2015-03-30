<h2>Liste des news</h2>

  
</form><p style="text-align: center">Il y a actuellement <?= $nombreAuthor ?> auteur. En voici la liste :</p>

<table>
  <tr><th>Pseudo</th><th>Prénom</th><th>Nom</th></tr>
<?php
	foreach ($listeAuthor as $author)
	{
	  echo '<tr><td>', $news['pseudo'], '</td><td>', $news['firstname'], '</td><td> ', $news['lastname'], '</td><td>', '</td><td><a href="news-update-', $news['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="news-delete-', $news['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
	}
?>
</table>

