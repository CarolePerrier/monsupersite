<h2>Liste des auteurs</h2>

<?php
if (empty($authors))
{
?>
<p>Aucun auteur n'a encore été ajouté. Soyez le premier à vous inscrire !</p>
<?php
}
?>
<table>
  <tr><th></th><th>Auteur</th><th>Prénom</th><th>Nom</th><th></th><th></th></tr>
<?php foreach ($authors as $author) { ?>
	<p>
		<?php
     		echo '<tr><td><a href="/admin/author-', $author['id'],'.html"><img src="/images/list.png" alt="Liste" width="20" height="20"/></a></td>&nbsp;<td>', $author['pseudo'], '</td>&nbsp;<td> ', $author['firstname'], '</td>&nbsp;<td> ', $author['lastname'], '</td>&nbsp;<td>', '</td><td><a href="author-update-', $author['pseudo'], '.html"><img src="/images/update.png" alt="Modifier" /></a>&nbsp;<a href="author-delete-', $author['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
      	?>
	</p>
<?php } ?>
</table>

