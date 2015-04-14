<?php
	foreach ($listeNews as $news)
	{
	?>
		<fieldset>
          <legend>
          	<i>News : </i>
			<strong style="font-size : 13px;"><a href="news-<?= $news['id'] ?>.html"><?= $news['titre'] ?></a></strong>
			<i>Posted the <?= $news['dateAjout']->format('d/m/Y \a\t H\hi') ?></i>	
          </legend>
          <p><?= nl2br($news['contenu']) ?></p>
		</fieldset>
	<?php
	}
?>