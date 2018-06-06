<?php

/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */

require_once 'base.php';

/**
 * 
 */
spl_autoload_register(function ($class) {
	

	$file = str_replace('\\', '/', $class);
	$file = __DIR__ . "/src/{$file}.php";

        if (file_exists($file)) {

                include $file;
        }

});