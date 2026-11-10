<?php
// config/database. php

$host = ' localhost' ;
$user = ' root' ;
$pass = ' ' ;
$db	= ' penj ualan' ;

// Inisialisasi koneksi dengan MySQLi secara Obj ect Oriented
$koneksi = new mysqli( $host, $user, $pass, $db);
