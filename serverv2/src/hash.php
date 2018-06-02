<?php
    require 'passwordHash.php';
    $password = "magnitude";
    $hash = passwordHash::hash($password);
    echo $hash;