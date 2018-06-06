<?php

/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */

namespace Registros\Bigmailer\Api;

/**
 * Description of Gdpr
 *
 * @author adrian
 */
class Gdpr extends Conection {

	
	/**
	 * Returns TRUE if GDPR permission is needed.
	 * 
	 * @param string $email
	 * @return boolean
	 * @return boolean
	 */
	public function needsPermission($email) {
		
		return (boolean)$this->run('Gdpr', __FUNCTION__, func_get_args());
		
	}
	
	/**
	 * Grants GDPR permission if it's needed.
	 * 
	 * @param string $email
	 * @param string $ip
	 * @return boolean
	 */
	public function grantPermission($email, $ip) {
		
		return (boolean)$this->run('Gdpr', __FUNCTION__, func_get_args());
	}
	
	
	/**
	 * Returns TRUE if mailing can be send.
	 * 
	 * @param string $email
	 * @return boolean
	 */
	public function canSend($email) {
		
		return (boolean)$this->run('Gdpr', __FUNCTION__, func_get_args());
	}
	
	
}
