<?php session_start();
$host = "localhost";
$db_user = "infoprem_guma";
$db_passw = "miE2BLyn";
$db_name = "infoprem_guma";

$connect = new mysqli($host, $db_user, $db_passw, $db_name);
if( $connect -> connect_errno != 0)
echo 'Error: '.$connect -> connect_errno;
/*mysql_connect("localhost","infoprem_guma","miE2BLyn") or die(mysql_error()."Nie mozna polaczyc sie z baza danych. Prosze chwile odczekac i sprobowac ponownie.");
mysql_select_db("infoprem_guma") or die(mysql_error()."Nie mozna wybrac bazy danych.");
*/


?>