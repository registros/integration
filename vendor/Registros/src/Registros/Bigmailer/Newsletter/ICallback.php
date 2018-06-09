<?php

/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */

namespace Registros\Bigmailer\Newsletter;

/**
 *
 * @author adrian
 */
interface ICallback {
	
	
	/**
	 * Returns session ID.
	 * 
	 * @return string
	 */
	function getSession();	

	/**
	 * Returns TRUE if the session is registered.
	 * 
	 * @return boolean
	 */
	public function isRegistered();
	
	
	/**
	 * Records sessie as registered.
	 * 
	 * @param string $session ID of session.
	 */
	public function register($session);
	
}
