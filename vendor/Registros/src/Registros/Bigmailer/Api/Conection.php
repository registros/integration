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
 * Description of Conection
 *
 * @author adrian
 */
abstract class Conection {

	/**
	 *
	 * @var string
	 */
	private $key;
	
	/**
	 *
	 * @var array|NULL
	 */
	private $last_response;
	
	/**
	 * 
	 * @param string $key Api key.
	 */
	function __construct($key) {
		$this->key = $key;
	}

	/**
	 * Returns last response
	 * 
	 * @return array|NULL
	 */
	public function getLastResponse() {
		return $this->last_response;
	}

	/**
	 * 
	 * @param string $class
	 * @param string $method
	 * @param array $params
	 * @return mixed
	 * @throws Exception
	 * @throws Remote
	 */
	protected function run($class, $method, $params) {
		
		$params = array_merge(array($this->key), $params);
		

		$input = array(
			'class' => $class,
			'method' => $method,
			'arguments' => $params,
		);		
		
		
		$input = json_encode($input);
		$input = rawurlencode($input);
		
		$url = "https://bigmailer.cloud/api/json/run";
//		$url = "http://bigmailer.local.net/api/json/run";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "input={$input}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close ($ch);
		
		$response = json_decode($response, TRUE);
		$this->last_response = $response;
		
		if ((!is_array($response)) or (!@$response['code'])) {
			
			$this->last_response = NULL;
			throw new Exception("Unexpected return format.");
			
		}
		
		if ($response['code'] >= 500) {
			
			$error =  @$response['error']['message'] ? "{$response['error']['message']} ({$response['code']})" : "Remote error ({$response['code']})";
			throw new Remote($error);
			
		}
		

		return @$response['result'];
		
		
	}

	
	
}
