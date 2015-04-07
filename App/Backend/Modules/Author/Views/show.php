<h2>Liste des auteurs</h2>
<?php if (empty($authors)) : ?>
  <p>Aucun auteur n'a encore été ajouté. Soyez le premier à vous inscrire !</p>
<?php endif; ?>
<table>
  <tr><th>Pseudo</th><th>Prénom</th><th>Nom</th><th>News</th></tr>
  <?php 
    foreach ($authors as $author) {
   		echo '<tr><td>', $author['BAC_pseudo'], '</td>&nbsp;<td> ', $author['BAC_firstname'], '</td>&nbsp;<td> ', $author['BAC_lastname'], '<td><a href="/admin/author-', $author['BAC_id'],'/', $author['BAC_firstname'],'-', $author['BAC_lastname'],'.html"><img src="/images/list.png" alt="Liste" width="20" height="20"/></a></td>'; 
  		if ($user->isAuthenticatedAdmin()) :
				echo  '<td>', '</td><td><a href="author-update-', $author['BAC_id'], '.html"><img src="/images/update.png" alt="Modifier" /></a>&nbsp;<a href="author-delete-', $author['BAC_id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a>';
			endif;
			echo '</td></tr>', "\n";
    } 
  ?>
</table>

