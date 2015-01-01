<?php

	// define(DB_SERVER, 'mysql://$OPENSHIFT_MYSQL_DB_HOST:$OPENSHIFT_MYSQL_DB_PORT/');
	define(DB_SERVER, $_ENV['OPENSHIFT_MYSQL_DB_HOST']);
	define(DB_USER, $_ENV['OPENSHIFT_MYSQL_DB_USERNAME']);
	define(DB_PASSWORD, $_ENV['OPENSHIFT_MYSQL_DB_PASSWORD']);
	define(DB_NAME, $_ENV['OPENSHIFT_APP_NAME']);

	$dbuser = $_ENV['OPENSHIFT_MYSQL_DB_USERNAME'];
	$dbpass = $_ENV['OPENSHIFT_MYSQL_DB_PASSWORD'];
	$dbname = $_ENV['OPENSHIFT_APP_NAME'];
	$dbport = $_ENV['OPENSHIFT_MYSQL_DB_PORT'];

	// Height for the wrap around client names
	define(MAX_HEIGHT, 3);

	define(OPEN_TIME, 	'08:00:00');
	define(CLOSED_TIME, '18:00:00');

	echo exec(" mysqldump  -u'adminCK9mtjG' -p'BwfX61ptw_U5' accent > db.sql");
?>
