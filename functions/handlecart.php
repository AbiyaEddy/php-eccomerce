<?php
session_start();
include_once("../includes/config.php");

if (isset($_SESSION['username'])) {
    if (isset($_POST['scope'])) {
        $scope = $_POST['scope'];

        switch ($scope) {
            case "add":

                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];

                $user_id = $_SESSION['id'];

                $checkcart = $dbcon->prepare("SELECT * FROM `carts` WHERE prod_id = '$prod_id' AND user_id ='$user_id'");
                $checkcart->execute();

                $checkcartquery = $checkcart->fetchAll(PDO::FETCH_ASSOC);

                if ($checkcartquery) {

                    echo "Product Already exists";
                } else {

                    $insertquery = $dbcon->prepare("INSERT INTO carts (user_id,prod_id,prod_qty) 
            VALUES(:user_id,:prod_id,:prod_qty)");

                    $insertquery->bindParam(':user_id', $user_id);
                    $insertquery->bindParam(':prod_id', $prod_id);
                    $insertquery->bindParam(':prod_qty', $prod_qty);
                    $querycartinsert = $insertquery->execute();

                    if ($querycartinsert) {
                        echo 'Product Has been added to cart successfully';
                    } else {
                        echo 500;
                    }
                }
                break;
            case "update":
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];

                $user_id = $_SESSION['id'];
                $checkcart = $dbcon->prepare("SELECT * FROM `carts` WHERE prod_id = '$prod_id' AND user_id ='$user_id'");
                $checkcart->execute();
                $cartresult = $checkcart->fetchAll(PDO::FETCH_ASSOC);

                if ($cartresult) {

                    $updatecartquery = $dbcon->prepare("UPDATE `carts` SET prod_qty ='$prod_qty' WHERE prod_id ='$prod_id' AND user_id = '$user_id'");

                    $updatecartquery->bindParam(':prod_qty', $prod_qty);
                    $updatecartquery->execute();

                    if ($updatecartquery) {

                        echo 200;
                    } else {
                        echo 500;
                    }
                } else {
                    echo "Something went wrong";
                }

                break;

            case "delete":
                $cart_id = $_POST['cart_id'];
                $user_id = $_SESSION['id'];

                $checkcart = $dbcon->prepare("SELECT * FROM `carts` WHERE cart_id = '$cart_id' AND user_id ='$user_id'");
                $checkcart->execute();

                $checkcartquery = $checkcart->fetchAll(PDO::FETCH_ASSOC);

                if ($checkcartquery > 0) {

                    $deletequery = $dbcon->prepare("DELETE FROM `carts` WHERE id ='$cart_id' AND user_id = '$user_id'");

                    $deletequery->execute();
                       
                    if ($deletequery) {
                   

                        echo 200;
                    } 
                    else
                     {
                        echo 500;
                     }
                } else {
                    echo "Something went wrong";
                }
                break;
            default:
                echo 500;
        }
    }
} else {
    echo 401;
}
