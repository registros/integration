/**
 * Registros en la Red
 * Copyright (c) Registros en la Red
 *
 * @copyright   Registros en la Red
 * @link        http://registros.net
 */
var bigmailer_iframe_interval__id_ = setInterval(function () {

	var el = document.getElementById("bigmailer-iframe-_id_");
	var top = el.offsetTop;
	var left = el.offsetLeft;
	var width = el.offsetWidth;
	var height = el.offsetHeight;

	while (el.offsetParent) {
		el = el.offsetParent;
		top += el.offsetTop;
		left += el.offsetLeft;
	}

	var load = (
			top < (window.pageYOffset + window.innerHeight) &&
			left < (window.pageXOffset + window.innerWidth) &&
			(top + height) > window.pageYOffset &&
			(left + width) > window.pageXOffset
			);


	if (load) {

		document.getElementById("bigmailer-iframe-_id_").src = "_src_";
		clearInterval(bigmailer_iframe_interval__id_);

	}

}, 1000);