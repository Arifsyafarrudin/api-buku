<<<<<<< HEAD
<?php  
// config.php  
$host = 'localhost';  
$db = 'tubes_pbo';  
$user = 'root';
$pass = ''; 

try {  
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
} catch (PDOException $e) {  
    echo 'Connection failed: ' . $e->getMessage();  
}  
=======
<?php  
// config.php  
$host = 'localhost';  
$db = 'tubes_pbo';  
$user = 'root';
$pass = ''; 

try {  
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
} catch (PDOException $e) {  
    echo 'Connection failed: ' . $e->getMessage();  
}  
>>>>>>> 07fc2b772ffb2aba057972666d699f2386d1ea67
?>