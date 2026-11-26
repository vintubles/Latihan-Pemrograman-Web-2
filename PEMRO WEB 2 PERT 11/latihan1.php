<?php
// hostname or ip of server
$servername='localhost';

// username and password
$dbusername='root';
$dbpassword='';
$link=mysqli_connect ("$servername","$dbusername","$dbpassword");
if (!$link) 
    die("Connection failed: " . mysqli_connect_error());

{
echo "berhasil coy";

}
?>