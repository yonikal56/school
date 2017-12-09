<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Model {

	public function __construct()
	{
		log_message('info', 'Model Class Initialized');
	}

	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}

}
