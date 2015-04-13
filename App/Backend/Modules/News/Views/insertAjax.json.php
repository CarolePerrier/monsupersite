<?php  
	$error = [];
	if($error == '')
	{
		$news = [];
		$news['auteur']  = $auteur;
		$news['contenu'] = $contenu;
		$news['titre'] = $titre;
		$news['errors'] = $errors;
		return $news;
	}
	else
	{
		return $error['message']; 
	}
?>