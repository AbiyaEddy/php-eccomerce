
<?php
$DATABASE_HOST ='localhost';
$DATABASE_USER ='root';
$DATABASE_PASS ='';
$DATABASE_NAME ='phpeccomdb';


$dsn="mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME";



try{

 $dbcon = new PDO($dsn,$DATABASE_USER,$DATABASE_PASS);

    // echo"connection Succesful";
}catch (PDOException $e){

    echo'error'. $e->getMessage();
}
?>