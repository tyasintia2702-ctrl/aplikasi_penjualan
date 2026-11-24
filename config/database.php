<?php
// config/database. php

$host = 'localhost' ;
$dbname = 'penjualan' ;
$username = 'root' ;
$password	= '' ;

// Inisialisasi koneksi dengan MySQLi secara Obj ect Oriented
$koneksi = new mysqli( $host, $username, $password, $dbname);
