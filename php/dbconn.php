<?php
	//dados para fazer a conexão
	$bdid = 'yourDataBase';
	$server = 'yourServer';
	$bduser = 'yourDataBaseUser';
	$bdpass = 'yourDataBasePassword';
	
	$conn = new mysqli($server, $bduser, $bdpass, $bdid); // conecta no BD
	
	mysqli_set_charset($conn, 'utf8mb4');
?>			