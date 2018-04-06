<?php
define ('_CONFIG_', [
	
	/* -------------------------------
	 * Config time
	 * -------------------------------
	 */
	'timezone' => date_default_timezone_set('Asia/Jakarta'),
	'now' => date("Y-m-d H:i:s"),

	/* -------------------------------
	 * Config database
	 * -------------------------------
	 */
	'db' => [
		'driver' => 'mysql',
		'host' => 'protel.mysql.database.azure.com',
		'port' => '3306',
		'username' => 'shareall@protel',
		'password' => 'ProyekTelematika1',
		'dbname' => 'buzz'
	],

	/* -------------------------------
	 * Config migration
	 * -------------------------------
	 */
	'migration' => [
		'secret_code' => 'slalala'	
	],
	/* -------------------------------
	 * Config database
	 * -------------------------------
	 */
	'mqtt' => [
		'host' => '127.0.0.1',//'broker.hivemq.com',
		'port' => '1883',
		'username' => '',
		'password' => ''
	],

]);
