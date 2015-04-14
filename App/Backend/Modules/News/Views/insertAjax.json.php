<?php	
	
	if($user->isAuthenticated())
	{
		$news = [];
		$news['auteur']  = $auteur;
		$news['contenu'] = $contenu;
		$news['titre'] = $titre;
		return $news;
	}
	else
	{
		$news = [];
		$news['erreur'] = 'Erreur';
		return $news;
	}

?>