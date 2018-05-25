<?php
	require_once 'passwordHash.php';
	 $var = "magnitude";
	 $password = passwordHash::hash($var);
	 echo $password;