<?php
session_start();


?>

<?php include('./includes/header.php'); ?>
<?php include('./includes/navbar.php'); ?>

<?php include_once(__DIR__ . "/includes/config.php");?>

<?php

if(isset($_GET['id']))
{
    $id = $_GET['id'];

$productquery=$dbcon->prepare("SELECT * FROM products WHERE id =:id");

$productquery->bindParam(':id',$id);
$productquery->execute();

$product= $productquery->fetch(PDO::FETCH_ASSOC);


if(!$product)
{
    $_SESSION['message']="Product does not exist";
    echo"<script>window.location.href='home.php'</script>";
    exit();
}
}

?>



<div class="product content-wrapper">
    <img src="uploads/<?=$product['product_image']?>" width="500" height="500" alt="<?=$product['product_name']?>">
    <div>
        <h1 class="name"><?=$product['product_name']?></h1>
        <span class="price">
            <!-- &dollar;<?=$product['product_price']?>
            <?php if ($product['rrp'] > 0): ?>
            <span class="rrp">&dollar;<?=$product['rrp']?></span>
            <?php endif; ?> -->
        </span>
        <form action="index.php?page=cart" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['product_quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['id']?>">
            <input type="submit" value="Add To Cart">
        </form>
        <div class="description">
            <?=$product['product_details']?>
        </div>
    </div>
</div>


<?php include('./includes/footer.php'); ?>
