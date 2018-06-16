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
use const REGISTROS_PATH;

/**
 * Description of Form
 *
 * @author adrian
 */
class Form {
	
	/**
	 *
	 * @var string
	 */
	private $public_key;
	
	/**
	 *
	 * @var string
	 */
	private $id;
	
	/**
	 *
	 * @var string
	 */
	private $language;
	
	/**
	 *
	 * @var string 
	 */
	private $css;
	
	/**
	 *
	 * @var string
	 */
	private $callback;
	
	/**
	 *
	 * @var string 
	 */
	private $title;
	
	/**
	 *
	 * @var string 
	 */
	private $width = '100%';
	
	/**
	 *
	 * @var string 
	 */
	private $height = '320px';
	
	/**
	 *
	 * @var ICallback 
	 */
	private $callback_controller;
	
	/**
	 *
	 * @var boolean 
	 */
	private $load_on_show = TRUE;

	/**
	 * 
	 * @param string $public_key
	 */
	function __construct($public_key) {
		
		$this->public_key = trim($public_key);
		$this->id = uniqid();

	}

	/**
	 * 
	 * @return ICallback
	 */
	function getCallbackController() {
		
		if(!$this->callback_controller) {
			
			$this->callback_controller = new Callback();
		}
		
		return $this->callback_controller;
	}

	/**
	 * 
	 * @param ICallback $callback_controller
	 */
	function setCallbackController(ICallback $callback_controller) {
		$this->callback_controller = $callback_controller;
	}

	
	/**
	 * 
	 * @return string
	 */
	function getLanguage() {
		return $this->language;
	}

	/**
	 * Sets form Language
	 * 
	 * @param string $language Language code as ISO 639-1
	 */
	function setLanguage($language) {
		
		$language = trim(strtolower($language));
		
		if (!in_array($language, array('en', 'es', 'ca', 'fr', 'pl', 'pt', 'it', 'de', 'nl'))) {
			
			throw new Exception("Unsupported language");
		}
		
		$this->language = $language;
	}

	
	
	/**
	 * 
	 * @return string 
	 */
	function getCss() {
		return $this->css;
	}

	/**
	 * 
	 * @return string
	 */
	function getCallback() {
		return $this->callback;
	}

	/**
	 * 
	 * @return string
	 */
	function getTitle() {
		
		if ($this->title === FALSE) {
			
			return 'no';
		}
		
		return $this->title;
	}

	/**
	 * Sets css file.
	 * 
	 * @param string $css Full quality URL or path to local file from root directory.
	 */
	function setCss($css) {
		$this->css = $css;
	}

	/**
	 * Sets callback localization.
	 * 
	 * @param string $callback Full quality URL or path to local file from root directory.
	 */
	function setCallback($callback) {
		$this->callback = $callback;
	}

	/**
	 * Sets newsletter title.
	 * 
	 * @param string|FALSE $title Put FALSE to hidden the title.
	 */
	function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * 
	 * @return string
	 */
	function getWidth() {
		return $this->width;
	}

	/**
	 * 
	 * @return string
	 */
	function getHeight() {
		return $this->height;
	}

	/**
	 * 
	 * @param string $width
	 */
	function setWidth($width) {
		
		if (is_numeric($width)) {
			
			$height = "{$width}px";
		}		
		
		$this->width = $width;
		
	}
	
	/**
	 * 
	 * @return boolean
	 */
	function getLoadOnShow() {
		return $this->load_on_show;
	}

	/**
	 * Delayed loading until the form will be visible.
	 * 
	 * @param boolean $load_on_show
	 */
	function setLoadOnShow($load_on_show) {
		$this->load_on_show = $load_on_show;
	}

	

	/**
	 * 
	 * @param string $height
	 */
	function setHeight($height) {
		
		if (is_numeric($height)) {
			
			$height = "{$height}px";
		}
		
		$this->height = $height;
	}

	
	
	/**
	 * 
	 * @param string $file
	 * @return string
	 */
	protected function getUrl($file) {
		
		$file = trim($file);
		
		if (filter_var($file, FILTER_VALIDATE_URL)) {
			
			return $file;
		}
		
		$file = trim($file, '/');
		$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}";
		
		return $url . '/' . $file;
	}
	
	/**
	 * 
	 * @param string $name
	 * @param string $value
	 * @return string|NULL
	 */
	protected function getParam($name, $value) {
		
		if (!$value = trim($value)) {
			
			return;
		}
		
		$value = rawurlencode($value);
		return "{$name}={$value}";
		
	}
	
	/**
	 * 
	 * @param string $callback
	 * @return string
	 */
	protected function prepareCallback($callback) {
		
		$callback = $this->getUrl($callback);
		$callback = explode('?', $callback, 2);
		
		$params = @$callback[1];
		$callback = @$callback[0];
		
		if ($params) {
			
			$params .= '&amp;';
		}
		
		$params .= "session=" . $this->getCallbackController()->getSession();
		
		return $callback . "?" . $params;
		
	}
	
	
	/**
	 * Returns TRUE if the session is registered.
	 * 
	 * @return boolean
	 */
	public function isRegistered() {
	
		return $this->getCallbackController()->isRegistered();
	}
	
	
	/**
	 * 
	 * @return string
	 */
	private function getSrc() {
		
		$params = array();
		
		$css = $this->getCss();
		$callback = $this->getCallback();
		$title = $this->getTitle();
		

		
		if ($css) {
		
			$css = $this->getUrl($css);
			$params[] = $this->getParam('css', $css);
		
		}
		
		if ($callback) {
			
			$callback = $this->prepareCallback($callback);
			$params[] = $this->getParam('callback', $callback);
		}
		
		if ($title) {
			
			$params[] = $this->getParam('title', $title);
		}
		
		$params = implode('&amp;', $params);
		
		if ($language = $this->getLanguage()) {
			
			$language .= '/';
		}
		
		$result = "https://bigmailer.cloud/{$language}integration/newsletter/form/{$this->public_key}?{$params}";
//		$result = "http://bigmailer.local.net/{$language}integration/newsletter/form/{$this->public_key}?{$params}";
		
		return $result;
		
	}
	
	/**
	 * 
	 * @param string $src
	 * @return string
	 */
	private function getLoaderJS($src) {
		
		$result = REGISTROS_PATH . "/res/js/bigmailer-form-loader.js";
		$result = file_get_contents($result);
		
		$result = str_replace('_src_', $src, $result);
		$result = str_replace('_id_', $this->id, $result);
		
		$result = "<script>\n{$result}\n</script>";
		
		return $result;
	}
	
	/**
	 * Returns HTML code of IFRAME.
	 * 
	 * @return string|NULL
	 */
	public function render($show_registered = FALSE) {
		
		if (!$show_registered) {
			
			if ($this->isRegistered()) {
				
				return;
			}
			
		}
		
		$src = $this->getLoadOnShow() ? NULL : $this->getSrc();
		$src = $src ? "src='{$src}'" : NULL;

		
		$result = "<iframe id='bigmailer-iframe-{$this->id}' class='bigmailer-iframe' {$src} frameborder='0' scrolling='no' style='width: {$this->width}; height: {$this->height};' ></iframe>";
		
		if ($this->getLoadOnShow()) {
			
			$result .= $this->getLoaderJS($this->getSrc());
		}
		
//		echo "<pre>";
//		echo htmlentities($result);
//		echo "</pre>---";

		return $result;
		
	}
	
	
	
	
}
