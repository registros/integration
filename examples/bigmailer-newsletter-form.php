<!DOCTYPE html>
<?php
/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>bigmailer-newsletter-form</title>
	</head>

	<body>
		
		<?php
		
		require_once '../vendor/Registros/loader.php';

		use Registros\Bigmailer\Newsletter\Form;

		$newsletter = new Form('9369e4a05bf1a739aa91d682fca8c905bb7af03b');
//		$newsletter->setCss('examples/bigmailer-newsletter-form.css');
		$newsletter->setCallback('examples/bigmailer-newsletter-callback.php');
//		$newsletter->setTitle('Newsletter');
		
		echo $newsletter->render();

		
		?>
		
	</body>

</html> 
