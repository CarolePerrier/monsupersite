<?php
	namespace App\Frontend;

	//on va chercher l'application
	use OCFram\Application;

	class FrontendApplication extends Application
	{
		public function __construct()
		{
			//On utilise le contructeur de la classe mère
			parent::__construct();
			//On rajoute l'instaciation du nom
			$this->name = 'Frontend';
		}
	
		public function run()
		{	
			$controller = $this->getController();
			$controller->execute();

			$this->httpResponse->setPage($controller->page());
			$this->httpResponse->send();
		}
	}
?>