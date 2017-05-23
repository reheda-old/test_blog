<?php 

$connection = mysqli_connect(
	$config['db']['server'],
	$config['db']['username'],
	$config['db']['passaword'],
	$config['db']['name']
);

if ($connection == false){
	echo 'Can\'t connect to db!<br>';
	echo mysqli_connect_error();
	exit();
}

$connection->set_charset('utf8');


?>