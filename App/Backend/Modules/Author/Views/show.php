<h2>Liste des auteurs</h2>

<?php
if (empty($author))
{
?>
<p>Aucun auteur n'a encore été ajouté. Soyez le premier à vous inscrire !</p>
<?php
}

foreach ($author as $author)
{
?>
<fieldset>
	<?php
      echo '<tr><td>', $author['auteur'], '</td> <td>', $author['firstname'], '</td> <td> ', $author['lastname'], '</td><td>', '</td><td><a href="author-update-', $author['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="author-delete-', $author['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
      ?>
</fieldset>
<?php
}
?>