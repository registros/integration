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
	 * Contact does not exist .
	 */
	const STATE_NO_EXISTS = 0;

	/**
	 * Contact exists but without the permission to send.
	 */
	const STATE_EXISTS_WITHOUT_PERMISSION = 1;

	/**
	 * Contact exists but the sending is forbidden.
	 */
	const STATE_EXISTS_WITH_SENDING_FORBIDDEN = 2;

	/**
	 * Contact exists and has permission to send.
	 */
	const STATE_EXISTS_WITH_PERMISSION = 3;

	/**
	 * Contact exists and has permission to send but there is no information required by GDPR.
	 */
	const STATE_EXISTS_WITH_PERMISSION_GDPR_DEFICIENCY = 4;

	/**
	 * Contact exists and has permission to send but control of GDPR is disabled.
	 */
	const STATE_EXISTS_WITH_PERMISSION_GDPR_DISABLED = 5;	
	
	
	/**
	 * Returns state the contact.
	 * 
	 * @param string $email
	 * @return int
	 */
	public function state($email) {	
		
		return (int)$this->run('Contact', __FUNCTION__, func_get_args());
	}
	
	
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
