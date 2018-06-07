<?php

/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */



require_once './vendor/Registros/loader.php';

use Registros\Bigmailer\Api\Contact;

try {

	$contact = new Contact('567f818f3cf812cd35f7ecbab568cd3bdea12368');
//	$result = $contact->addByIP('test@test.net', 'Test', '8.8.8.8', Contact::ADD_MODE_WITH_PERMISSION);
	$result = $contact->state('test@test.net');

	echo "Result : ";
	var_dump($result);
	echo '<br><br>';

} catch (Exception $exc) {

	show($exc);
}

if ($contact->getLastResponse()) {

	output("Last response:");
	output($contact->getLastResponse());
}