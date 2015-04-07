<?php
namespace App\Frontend\Modules\devicedetect;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Mobile_Detect;

class devicedetectController extends BackController
{
	public function executedetect(HTTPRequest $request)
	{
		// Include and instantiate the class.
		//require_once 'Mobile_Detect.php';
		
		$detect = new Mobile_Detect;

		$device = '';	
		if( $detect->isTablet() ){
		 	$device = "Tablet";
		}
		 
		// Exclude tablets.
		if( $detect->isMobile() && !$detect->isTablet() ){
		 	$device = "mobile";
		}
		 
		// Check for a specific platform with the help of the magic methods:
		$Os = '';
		if( $detect->isiOS() ){
		 	$Os = "iOS";
		}
		 
		if( $detect->isAndroidOS() ){
		 	$Os = "Android";
		}
		 
		// Alternative method is() for checking specific properties.
		// WARNING: this method is in BETA, some keyword properties will change in the future.
		$browser = '';
		if($detect->is('Chrome'))
		{
			$browser = 'Chrome';
		}
		if($detect->is('iOS'))
		{
			$browser = 'iOS';
		}
		if($detect->is('Uc browser'))
		{
			$browser = 'Uc browser';
		}
		// [...]
		 
		// Batch mode using setUserAgent():
		// $userAgents = array(
		// 'Mozilla/5.0 (Linux; Android 4.0.4; Desire HD Build/IMM76D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19',
		// 'BlackBerry7100i/4.1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/103',
		// [...]
		// );
		// foreach($userAgents as $userAgent){
		 
		//   $detect->setUserAgent($userAgent);
		//   $isMobile = $detect->isMobile();
		//   $isTablet = $detect->isTablet();
		//   // Use the force however you want.
		 
		// }
		 
		// Get the version() of components.
		// WARNING: this method is in BETA, some keyword properties will change in the future.
		$version = '';
		switch (true) {
			case $detect->version('iPad'): // 4.3 (float)
					$version = $detect->version('iPad');
			case $detect->version('iPhone'): // 3.1 (float)
					$version = $detect->version('iPhone');
			case $detect->version('Android'): // 2.1 (float)
					$version = $detect->version('Android');
			case $detect->version('Opera Mini'): // 5.0 (float)
					$version = $detect->version('Opera Mini');
		}
		
		// [...]
		if($Os == '')
		{ 
			$Os = 'Your Os is unknown';
		}

		if($device == '')
		{ 
			$device = 'Your device is unknown';
		}

		if($browser == '')
		{ 
			$browser = 'Your browser is unknown';
		}

		if($version == '')
		{ 
			$version = 'Your version is unknown';
		}
		$this->page->addVar('Os', $Os);
		$this->page->addVar('device', $device);
		$this->page->addVar('browser', $browser);
		$this->page->addVar('version', $version);

	}
}
?>