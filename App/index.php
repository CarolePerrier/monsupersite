
<?php
	echo "Hello Thomas<br/>";
	echo "Hello World<br/>";
	class Personnage
	{
		private $_force;
  		private $_localisation;
		private $_experience;
		private $_degats;

		const FORCE_PETITE  = 20;
		const FORCE_MOYENNE = 50;
		const FORCE_GRANDE  = 80;

		const DEGATS_PETITS = 5;
		const DEGATS_MOYENS = 10;
		const DEGATS_GRANDS = 20;


		//contructeur
		public function __construct($force, $degats) // Constructeur demandant 2 paramètres
		{
		    echo 'Voici le constructeur !<br/>'; // Message s'affichant une fois que tout objet est créé.
		    $this->setForce($force); // Initialisation de la force.
		    $this->setDegats($degats); // Initialisation des dégâts.
		    $this->_experience = 1; // Initialisation de l'expérience à 1.
		}
		public function afficherExperience()
		{
			echo $this->_experience;
		}
		//oblige le paramètre à être de class Personnage
		public function frapper(Personnage $persoAFrapper)
		{
		    // …
		}
		//accesseur
		public function force()
	    {
	    	return $this->_force;
	    }
	    //Setter
	    public function setDegats($degats)
	    {
	      // On vérifie qu'on nous donne bien soit une « FORCE_PETITE », soit une « FORCE_MOYENNE », soit une « FORCE_GRANDE ».
	      if (in_array($degats, [self::DEGATS_PETITS, self::DEGATS_MOYENS, self::DEGATS_GRANDS]))
	      {
	      	$this->_degats = $degats;
	      }
	    }
  		
  		public function setForce($force)
	    {
	      // On vérifie qu'on nous donne bien soit une « FORCE_PETITE », soit une « FORCE_MOYENNE », soit une « FORCE_GRANDE ».
	      if (in_array($force, [self::FORCE_PETITE, self::FORCE_MOYENNE, self::FORCE_GRANDE]))
	      {
	      	$this->_force = $force;
	      }
	    }

	}

	$perso = new Personnage(Personnage::FORCE_MOYENNE, Personnage::DEGATS_MOYENS);
?>

<!--Les Exceptions -->

<?php
	echo '<br/>Les Exceptions<br/>';

	echo 'Cr'.utf8_decode('é').'ation de la classe MonException<br/><--d'.utf8_decode('é').'but<br/>';
	class MonException extends Exception
	{
		public function __construct($message, $code = 0)
		{
		parent::__construct($message, $code);
		}

		public function __toString()
		{
		return $this->message;
		}
	}
	echo 'fin--><br/>';
	function additionner($a, $b)
	{
		if (!is_numeric($a) || !is_numeric($b))
		{
			throw new MonException('Les deux param'.utf8_decode('è').'tr'.utf8_decode('è').'s doivent '.utf8_decode('ê').'tre des nombres<br/>'); // On lance une nouvelle exception si l'un des deux paramètres n'est pas un nombre.
		}

		return $a + $b;
	}

	try // On va essayer d'effectuer les instructions situées dans ce bloc.
	{
	  echo additionner(12, 3), '<br />';
	  echo additionner('azerty', 54), '<br />';
	  echo additionner(4, 8);
	}

	catch (MonException $e) // On va attraper les exceptions "MonException" s'il y en a une qui est levée.
	{
		echo 'Une exception a '.utf8_decode('é').'t'.utf8_decode('é').' lanc'.utf8_decode('é').'e. Message d\'erreur : ', $e->getMessage();
	}
?>