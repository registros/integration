<?php

/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */

namespace Registros\Bigmailer\Newsletter;

use Registros\Bigmailer\Exception\Exception;

/**
 * Description of Callback
 *
 * @author adrian
 */
class Callback implements ICallback {
	
	/**
	 * Storage directory
	 */
	const DIR = 'var/registros/bigmailer/session/';
	
	/**
	 * Session TTL
	 */
	const TTL = 86400; // 24h
	
	/**
	 * Use files to storage information.
	 */
	const STORAGE_FILE = 1;
	
	/**
	 * Use session to storage information.
	 */
	const STORAGE_SESSION = 2;	
	
	/**
	 * 
	 */
	const SESSION_KEY = '191c596d-6482-4004-b589-7d60aa84a1e6';
	
	
	/**
	 *
	 * @var int 
	 */
	private $storage_mode = self::STORAGE_FILE;
	
	/**
	 *
	 * @var string 
	 */
	private $session;	
	
	
	/**
	 * 
	 * @return int
	 */
	function getStorageMode() {
		return $this->storage_mode;
	}

	/**
	 * 
	 * @param int $storage_mode
	 */
	function setStorageMode($storage_mode) {
		
		$this->storage_mode = $storage_mode;
	}

	
	/**
	 * 
	 * @return string
	 */
	function getSession() {
		
		if ($this->storage_mode == self::STORAGE_SESSION) {
			
			if (!session_id()) {
				
				session_start();
			}
			
		}		
		
		if (!$this->session) {
			
			$this->session = session_id();	
		}
		
		if (!$this->session) {
			
			$this->session = $_SERVER["REMOTE_ADDR"];
			$this->session .= $_SERVER["HTTP_USER_AGENT"];
			$this->session .= $_SERVER["HTTP_ACCEPT_LANGUAGE"];
			$this->session = sha1($this->session);			
			
		}
		
		return $this->session;
	}	
	
	
	/**
	 * Returns path to storage directory.
	 * 
	 * @param boolean $create Creates the directory if does not exist.
	 * @return string
	 * @throws Exception
	 */
	protected function getDir($create = TRUE)  {
				
		$result = $_SERVER["DOCUMENT_ROOT"] . '/' . self::DIR;
		
		if ((!is_dir($result)) and ($create)) {
			
			mkdir($result, 0777, TRUE);
			
			if (!is_dir($result)) {
				
				throw new Exception("The directory cannot be created : {$result}");
			}
		}
	
		return $result;
	}

	/**
	 * 
	 * @param string $session
	 * @param boolean $create_directory Creates the directory if does not exist.
	 * @return string
	 */
	protected function getFile($session, $create_directory = TRUE) {
		
		return $this->getDir($create_directory) . $session;
	}


	/**
	 * Returns TRUE if the session is registered.
	 * 
	 * @return boolean
	 * @throws Exception
	 */
	public function isRegistered() {
		
		$session = $this->getSession();
		
		if ($this->storage_mode == self::STORAGE_SESSION) {
			
			return (boolean)@$_SESSION[self::SESSION_KEY];
			
		}
		
		if ($this->storage_mode == self::STORAGE_FILE) {
			
			
			return file_exists($this->getFile($session, FALSE));
		}
		
		
		throw new Exception("Unknown storage mode.");
	}
	
	
	/**
	 * Records sessie as registered.
	 * 
	 * @param string $session ID of session.
	 * @throws Exception
	 */
	public function register($session) {
		
		if (!$session = trim($session)) {
			
			return;
		}
		
		
		if ($this->storage_mode == self::STORAGE_SESSION) {
			
			if ((session_id() != $session) and (session_id())) {
				
				throw new Exception("Session was already started with other session ID.");
			}
			
			session_id($session);
			session_start();
			
			$_SESSION[self::SESSION_KEY] = TRUE;
			
			return;
			
		}
		
		
		if ($this->storage_mode == self::STORAGE_FILE) {
		
			$file = $this->getFile($session);
			file_put_contents($file, NULL);
		
			if (rand(1, 100) == 1) { // Run only sometimes
			
				$this->scourer();
			}
			
			return;
		}
		
		throw new Exception("Unknown storage mode.");
		
			
	}	
	
	/**
	 * Removes old sessions files.
	 */
	protected function scourer() {
		
		$dir = $this->getDir();
		$files = scandir($dir);
		
		foreach($files as $file) {
			
			if (in_array($file, array('.', '..'))) {
				
				continue;
			}
			
			$file = "{$dir}{$file}";
			
			if (is_dir($file)) {
				
				continue;
			}
			
			$time = filectime($file);
			$time = time() - $time;
			
			if ($time > self::TTL) {
			
				unlink($file);
			
			}
			
		}
		

	}
	
	
	
}
