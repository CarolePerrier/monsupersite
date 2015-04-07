<h2>Liste des news de <?php echo $author->pseudo(); ?></h2>

<?php if(!empty($listeNews)): ?>
	<table>
		<tr><th>Titre</th><th>Date d'ajout</th><th>Contenu</th></tr>
		<?php
			foreach ($listeNews as $news)
			{
			  echo '<tr><td>', $news['titre'], '</td><td>', $news['dateAjout'], '</td><td>', $news['contenu'], '</td><td>'; 
			  echo '</td></tr>', "\n";
			}
		?>
	</table>
<?php else : ?>
	<?php echo 'Cet auteur n\'a posté aucune news'?>
<?php endif; ?>