<h2>Liste des auteurs</h2>

  
</form><p style="text-align: center">Il y a actuellement <?= $nombreAuthor ?> auteurs. En voici la liste :</p>

<table>
  <tr><th>Auteur</th><th>Prénom</th><th>Nom</th></tr>
<?php
	foreach ($listeAuthors as $author)
	{
	  echo '<tr><td>', $author['auteur'], '</td><td>', $author['firstname'], '</td><td> ', $author['lastname'], '</td><td>', '</td><td><a href="news-update-', $author['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="author-delete-', $author['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
	}
?>
</table>

