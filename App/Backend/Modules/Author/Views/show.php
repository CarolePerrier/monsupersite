<h2>Liste des auteurs</h2>

<?php
if (empty($authors))
{
?>
<p>Aucun auteur n'a encore été ajouté. Soyez le premier à vous inscrire !</p>
<?php
}
?>
<p>
	<?php
      echo '<tr><td>', $authors['pseudo'], '</td> <td>', $authors['firstname'], '</td>&nbsp;<td> ', $authors['lastname'], '</td>&nbsp;<td>', '</td><td><a href="author-update-', $authors['pseudo'], '.html"><img src="/images/update.png" alt="Modifier" /></a>&nbsp;<a href="author-delete-', $authors['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
      ?>
</p>
