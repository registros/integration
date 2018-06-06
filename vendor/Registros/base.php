<?php

/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */



/**
 * Is console request.
 */
define('IS_CONSOLE', (PHP_SAPI == 'cli'));


/**
 * New line string: br tag, or \n
 */
define('NEW_LINE', IS_CONSOLE ? "\n" : '<br>');


/**
 * Outputs string.
 * 
 * @param string $string
 */
function output($string) {
	
	if ($string instanceof Exception) {
	
		show($string);
		return;		
		
	}
	
	if (is_array($string)) {
		
		show($string);
		echo NEW_LINE;
		return;
	}

	echo $string, NEW_LINE;
	
}


/**
 * Render the information of exception.
 * 
 * @param Exception $exc
 * @return string
 */
function renderException(Exception $exc) {
	
	$result = array();
	$result[] = "Exception class: " . get_class($exc);
	$result[] =  $exc->getMessage() . " in " . $exc->getFile() . ":" . $exc->getLine();
	$result[] = '--';
	$result[] = 'Stack trace:';
	$result = array_merge($result, explode("\n", $exc->getTraceAsString()));
	$result = implode("\n", $result);
	
	if (!IS_CONSOLE) {
		
		$result = "<pre>{$result}</pre>";
	}
	
	return $result;
}

/**
 * 
 * @param mixed $data
 */
function show(& $data) {
	
	if ($data instanceof Exception) {
	
		echo renderException($data), NEW_LINE;
		return;		
		
	}	
	
	
	if (!IS_CONSOLE) {
		
		echo "<pre>";
	}
	
	if (is_array($data)) {
		
		print_r($data);
		
	} else {
		
		var_dump($data);
		
	}
	
	
	
	if (!IS_CONSOLE) {
		
		echo "</pre>";
	}	
	
}

/**
 * 
 * @param mixed $var
 */
function debug($var) {
	
	show($var);
	exit;
	
}
