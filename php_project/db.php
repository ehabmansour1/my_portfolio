<?php
$host = 'mysql9.serv00.com';  // Your MySQL server host
$db = 'm2415_simple_blog_db';  // Replace with your actual database name if different
$user = 'm2415_pop';  // Replace with your MySQL username
$pass = 'e.H97451100';  // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}
?>
