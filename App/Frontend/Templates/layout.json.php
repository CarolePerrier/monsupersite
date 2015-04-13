<?php if ($user->isAuthenticated()) : ?>
	<?= $content ?>
<?php else : ?>
	<?= $error ?>
<?php endif; ?>



