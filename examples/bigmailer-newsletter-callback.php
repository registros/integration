<?php

/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */

require_once '../vendor/Registros/loader.php';

use Registros\Bigmailer\Newsletter\Callback;

$callback = new Callback();
//$callback->setStorageMode(Callback::STORAGE_SESSION);
$callback->register(@$_GET['session']);

