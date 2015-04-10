<h2>News posted by <?php echo $authorId->pseudo(); ?></h2>

<?php if(!empty($listeNews)): ?>
	<table>
	  <tr><th>Author</th><th>Title</th><th>Adding date</th><th>Field</th></tr>
	<?php
	foreach ($listeNews as $news)
	{
	  echo '<tr><td>',$authorId->pseudo(),'</td><td>', $news['titre'], '</td><td>', $news['dateAjout'], '</td><td>', $news['contenu'], '</td><td>'; 
	  if ($user->isAuthenticatedAdmin()) {
	  	echo  '<td><a href="/admin/news-update-', $news['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="/admin/news-delete-', $news['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td>';
	  }
	  echo '</td></tr>', "\n";
	}
	?>
	</table>
<?php else : ?>
	<?php echo 'Cet auteur n\'a posté aucune news'?>
<?php endif; ?>
	
