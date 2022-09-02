<?php
session_start();
 include_once("../includes/config.php");

 if(isset( $_SESSION['username']))
 {
    if(isset($_POST['scope']))
    {
    $scope =$_POST['scope'];

    switch($scope)
   
    {
        case "add":
           
            $prod_id = $_POST['prod_id'];
            $prod_qty = $_POST['prod_qty'];

            $user_id =$_SESSION['id'];
     
            $insertquery = $dbcon->prepare("INSERT INTO carts (user_id,prod_id,prod_qty) 
            VALUES(:user_id,:prod_id,:prod_qty)");
                   
            $insertquery->bindParam(':user_id',$user_id);  
            $insertquery->bindParam(':prod_id',$prod_id);
            $insertquery->bindParam(':prod_qty', $prod_qty);
            $querycartinsert =$insertquery->execute();
          
            if($querycartinsert)
            {
                echo 201;
            }
            else{
                echo 500;
            }
            break;
            default:
            echo 500;
    }

}

 }
 else
 {
    echo 401;
 }
?>