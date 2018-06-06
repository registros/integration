<?php

/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */

namespace Registros\Bigmailer\Api;

use Registros\Bigmailer\Exception\Exception;
use Registros\Bigmailer\Exception\Remote;

/**
 * Description of Contact
 *
 * @author adrian
 */
class Contact extends Conection {
	
	
	/**
	 * Add without permission of send.
	 */
	const ADD_MODE_WITHOUT_PERMISSION = 0;
	
	/**
	 * Add in newsletter mode. 
	 * 
	 * Without permissions but a mail with solicitud of confirmation will be send.
	 */
	const ADD_MODE_NEWSLETTER = 1;
	
	/**
	 * Without permissions but a mail with request of permissions will be send.
	 */
	const ADD_MODE_REQUEST_OF_PERMISSION = 2;
	
	/**
	 * Add with permission. 
	 * 
	 * This mode requires a valid IP address of contact in order to save GDPR information.
	 */
	const ADD_MODE_WITH_PERMISSION = 3;
	
	/**
	 * Add with permission and disabled GDPR control.
	 */
	const ADD_MODE_WITH_PERMISSION_NO_GDPR = 4;	
	
	
	/**
	 * Adds new contact using the country as reference to found destination database.
	 * 
	 * @param string $email Email address
	 * @param string $name Name of contact (it can be NULL)
	 * @param string $country Code of country (ISO 3166-1)
	 * @param string $ip Contact IP
	 * @param int $mode Work mode
	 * @return boolean
	 * @throws Exception
	 * @throws Remote
	 */
	public function addByCountry($email, $name, $country, $ip = NULL, $mode = self::ADD_MODE_WITHOUT_PERMISSION) {
		
		return (boolean)$this->run('Contact', __FUNCTION__, array($email, $name, $country, $ip, $mode));
		
	}
	
	
	/**
	 * Adds new contact using the IP as reference to found destination database.
	 * 
	 * @param string $email Email address
	 * @param string $name Name of contact (it can be NULL)
	 * @param string $ip Contact IP
	 * @param int $mode Work mode
	 * @return boolean
	 * @throws Exception
	 * @throws Remote
	 */
	public function addByIP($email, $name, $ip, $mode = self::ADD_MODE_WITHOUT_PERMISSION) {
		
		return (boolean)$this->run('Contact', __FUNCTION__, array($email, $name, $ip, $mode));
		
	}	
	
	
	
	
}
