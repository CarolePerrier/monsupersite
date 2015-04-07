<p>Par <em><a href="/author-<?= $author->BAC_id?>/<?= $author->firstname() ?>-<?= $author->lastname()?>.html"><?= $author->pseudo() ?></a></em>, le <?= $news['dateAjout']->format('d/m/Y à H\hi') ?></p>
<h2><?= $news['titre'] ?></h2>
<p><?= nl2br($news['contenu']) ?></p>

<?php if ($news['dateAjout'] != $news['dateModif']) { ?>
  <p style="text-align: right;"><small><em>Modifiée le <?= $news['dateModif']->format('d/m/Y à H\hi') ?></em></small></p>
<?php } ?>

<p><a href="commenter-<?= $news['id'] ?>.html">Ajouter un commentaire</a></p>

<?php
if (empty($comments))
{
?>
<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php
}

foreach ($comments as $comment)
{
?>
<fieldset>
  <legend>
  	Posté par 
    <?php if($comment['email'] != null) : ?>
  	    <a href="/news-commented-by/<?= $comment['email'] ?>.html"><strong><?= htmlspecialchars($comment['auteur']) ?></strong></a>
    <?php else : ?>
        <strong><?= htmlspecialchars($comment['auteur']) ?></strong>
    <?php endif; ?>
     le <?= $comment['date']->format('d/m/Y à H\hi') ?>
    <?php if ($user->isAuthenticatedAdmin()) { ?> -
      <a href="admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a> |
      <a href="admin/comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
    <?php } ?>
  </legend>
  <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
</fieldset>
<?php
}
?>

<p><a href="commenter-<?= $news['id'] ?>.html">Ajouter un commentaire</a></p>