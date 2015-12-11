#!/usr/local/bin/php
<?php
$connection = oci_connect($username = 'prose',
                          $password = '24997843p',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
}
else {
   print "Connected to Oracle!";
}
$statement = oci_parse($connection, 'select USERNAME from webuser');
oci_execute($statement);

while ($row = oci_fetch_object($statement)) {
      var_dump($row);
}

//
// VERY important to close Oracle Database Connections and free statements!
//
oci_free_statement($statement);
oci_close($connection);