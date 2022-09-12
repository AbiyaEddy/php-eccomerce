<?php 


include_once("config.php");

?> 


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
</head>

<body>

    <header class="section-header">
        <section class="header-main">
            <div class="container">
                <div class="row align-items-center">


                    <div class="col-lg-3">
                        <div class="brand-wrap">
                            <img class="logo" src="images/logo-dark.png">
                            <h2 class="logo-text">LOGO</h2>
                        </div>
                        <!-- brand-wrap.// -->
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <form action="#" class="search-wrap">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- search-wrap .end// -->
                    </div>
                    <!-- col.// -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="widgets-wrap d-flex justify-content-end">
                            <div class="widget-header">
                                <a href="#" class="icontext">
  
                                    <div class="text-wrap">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                            <small><i class="fa fa-shopping-cart"></i></small>
                                            <span></span>
                                        </button>

                                        <div class="modal" id="myModal">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Shopping Cart</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="container mt-3 ">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Product Name</th>
                                                                        <th>Product Image</th>
                                                                        <th>Product Price</th>
                                                                        <th>Product Quantity</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                <?php 
                                                                $userId=$_SESSION['id'];
                                                                $querycart = $dbcon->prepare("SELECT p.product_name,p.product_price, c.prod_qty,SUM(p.product_price * c.prod_qty ) AS total_price,p.product_image,c.id,c.prod_id
                                                             FROM carts as C JOIN products as p ON c.prod_id=p.id 
                                                                WHERE c.user_id=$userId GROUP BY p.id");
                                                                $querycart->execute();
                                                                $cartproducts =  $querycart->fetchAll(PDO::FETCH_ASSOC);;
                                                                
                                                                ?>
                                                                <?php foreach($cartproducts as $product){?>
                                        
                                                                   
                                                               
                                                                    <tr class="product-table">
                                                                        <td><?=$product['product_name']; ?></td>
                                                                        <td class="cartImage"><img src="uploads/<?=$product['product_image'];?>"height="50px" width="50px" alt="image"></td>
                                                                        <td class="cartPrice">KSh:<?=$product['total_price']; ?></td>

                                                                        <td class="cartQuantity">

                                                                            <div class="row py-2 product-data">
                                                                                <div class="col-md-4">
                                                                                    <input type="hidden" class="prodId" value ="<?= $product['prod_id'];?>" >
                                                                                    <div class="input-group mb-3 " style="width:100px">
                                                                                        <div class="input-group-prepend">
                                                                                            <button class="input-group-text decrement-btn updateQty">-</button>
                                                                                        </div>
                                                                                        <input type="text" class="form-control bg-white input-quantity" value="<?=$product['prod_qty']; ?>" disabled>
                                                                                        <div class="input-group-append">
                                                                                            <button class="input-group-text increment-btn updateQty">+</button>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="removeButton"><button class="btn btn-danger btn-sm deleteItem reload" value="<?=$product['id']; ?>" >Remove</button></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                            <span>Total Amount:</span>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            </div>
                            <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                            ?>
                                <div class="widget-header">
                                    <a href="logout.php" class="icontext">
                                        <div class="icon-wrap icon-xs bg2 round text-secondary"></i></div>
                                        <div class="text-wrap">
                                            <small>Log out</small>
                                            <span></span>
                                            <?php echo 'Welcome ' . $_SESSION["username"]; ?>
                                        </div>

                                    </a>
                                </div>
                            <?php } else { ?>
                                <div class="widget-header">
                                    <a href="login.php" class="icontext">
                                        <div class="icon-wrap icon-xs bg2 round text-secondary"></i></div>
                                        <div class="text-wrap">

                                            <small>Log in</small>
                                            <span></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="widget-header">
                                    <a href="register.php" class="icontext">
                                        <div class="icon-wrap icon-xs bg2 round text-secondary"></div>
                                        <div class="text-wrap">
                                            <small>Register</small>
                                            <span></span>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                            <!--  dropdown-menu .// -->
                        </div>
                        <!-- widget  dropdown.// -->
                    </div>
                    <!-- widgets-wrap.// -->
                </div>
                <!-- col.// -->
            </div>
            <!-- row.// -->
            </div>
            <!-- container.// -->
        </section>
        <!-- header-main .// -->

        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <div class="container">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link pl-0" href="#"> <strong>All category</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Fashion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Supermarket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Electronics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Baby &amp Toys</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Fitness sport</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown07">
                                <a class="dropdown-item" href="#">Foods and Drink</a>
                                <a class="dropdown-item" href="#">Home interior</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Category 1</a>
                                <a class="dropdown-item" href="#">Category 2</a>
                                <a class="dropdown-item" href="#">Category 3</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- collapse .// -->
            </div>
            <!-- container .// -->
        </nav>

    </header>
    <!-- section-header.// -->