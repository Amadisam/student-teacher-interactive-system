<?php

$HOSTNAME = 'localhost';
$USERNAME = 'henryu';
$PASSWORD = '';
$DATABASE = 'henrydb';

// Create connection
$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
