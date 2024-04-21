<?php

$hostName = "sql312.infinityfree.com";
$dbUser = "if0_36313219";
$dbPassword = "zZZhkwieZwJhE0";
$dbName = "if0_36313219_loginform";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

// Define and hash the admin key
$adminKey = password_hash("%6M07&G*9)@!(", PASSWORD_DEFAULT); // Replace "your_admin_key" with your actual admin key
// You can generate a secure admin key using a function like password_hash()

?>
