<?php
namespace MySurvey\lib;

function conf(){
	return [
	'driver'	=>	'mysql',
	'host'		=> 	'localhost',
	'user'		=> 	'root',
	'pass'		=> 	'',
	'database'	=> 	'mysurvey',
	'engine'	=>	'InnoDB',
	];
}
function admins(){
	return [ //SHA-256: Generate with salt
		'admin' => 'ac0e7d037817094e9e0b4441f9bae3209d67b02fa484917065f71b16109a1a78',
		'root'	=> '28f4c77c534d5358329b61b326c995cd1743e2e37dd13949ace9c9b816de1fa9'
	];
}

//Please customize
function salt(){
	return '123456';
}
?>