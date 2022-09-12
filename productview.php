<?php
session_start();


?>

<?php include('./includes/header.php'); ?>
<?php include('./includes/navbar.php'); ?>

<?php include_once(__DIR__ . "/includes/config.php"); ?>

<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $productquery = $dbcon->prepare("SELECT * FROM products WHERE id =:id");

    $productquery->bindParam(':id', $id);
    $productquery->execute();

    $product = $productquery->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        $_SESSION['message'] = "Product does not exist";
        echo "<script>window.location.href='home.php'</script>";
        exit();
    }
}

?>

<section class="py-5">
    <div class="container product-data px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img src="uploads/<?= $product['product_image']; ?>" width="500" height="500" alt="<?= $product['product_name'] ?>" |></div>
            <div class="col-md-6">
                <div class="small mb-1">SKU: BST-498</div>
                <h1 class="display-5 fw-bolder">Product Details</h1>
                <div class="fs-5 mb-5">
                    
                    <span>Price:<?= $product['product_price'] ?>Ksh</span>
                </div>
                <p class="lead"><?= $product['product_details'] ?></p>

                <div class="row py-2">
                    <div class="col-md-4">
                        <div class="input-group mb-3 " style="width:100px">
                            <div class="input-group-prepend">
                                <button class="input-group-text decrement-btn">-</button>
                            </div>
                            <input type="text" class="form-control bg-white input-quantity" value="1" disabled>
                            <div class="input-group-append">
                                <button class="input-group-text increment-btn">+</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-primary px-4 addToCartBtn" value="<?= $product['id']; ?>" type="button">Add to cart</button>

                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger px-4" type="button">Add to Wishlist</button>
                    </div>
                </div>
                <div class="">
                    <a href="home.php">
                        <button class="btn btn-success mt-3" type="button"> Back to Home</button>
                    </a>
                    </div>
            </div>
        </div>
</section>


<?php include('./includes/footer.php'); ?>