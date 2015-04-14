<?php 
	if (!isset($global_error_code))
	{
		$global_error_code = 0;//pas erreur
	}
	if (!isset($global_error_message))
	{
		$global_error_message = '';
	}

	return array(
				'error_code'    => $global_error_code,
				'error_message' => $global_error_message,
				'data'          => $content
			);
?>