<?php
session_start();
?>


<?php include('./includes/header.php'); ?>
<?php include('./includes/navbar.php'); ?>

<script src="js/custom.js"></script>
<?php include_once(__DIR__ . "/includes/config.php");?>


    <!-- ========================= SECTION MAIN ========================= -->
    <section class="section-main bg padding-top-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- ================= main slide ================= -->
                    <div class="owl-init slider-main owl-carousel" data-items="1" data-dots="false" data-nav="true">
                        <div class="item-slide">
                            <img src="images/banners/slide1.jpg">
                        </div>
                        <div class="item-slide rounded">
                            <img src="images/banners/slide2.jpg">
                        </div>
                        <div class="item-slide rounded">
                            <img src="images/banners/slide3.jpg">
                        </div>
                    </div>
                    <!-- ============== main slidesow .end // ============= -->
                </div>
                <!-- col.// -->

            </div>
        </div>
        <!-- container .//  -->
    </section>
    <!-- ========================= SECTION MAIN END// ========================= -->
    <!-- ========================= Blog ========================= -->
    <section class="section-content padding-y-sm bg">
        <div class="container">
            <header class="section-heading heading-line">
                <h4 class="title-section bg">Featured Categories</h4>
            </header>
            <div class="row">
            <?php 
                $querycategory=$dbcon->prepare("SELECT * FROM `category` WHERE featured ='1'LIMIT 3");
                $querycategory->execute();
                $querycategoryresult =$querycategory->fetchAll(PDO::FETCH_OBJ);

                foreach($querycategoryresult as $categoryrecent){   
                ?>
                <div class="col-md-4">
                    <div class="card-banner" style="height:250px; background-image: url('images/posts/1.jpg');">
                        <article class="overlay overlay-cover d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <h5 class="card-title"><?= $categoryrecent->name ?></h5>
                                <a href="#" class="btn btn-warning btn-sm"> View All </a>
                            </div>
                        </article>
                    </div>

                    
                    
                </div>
                <?php }?>
            </div>
        </div>
    </section>
    <!-- ========================= Blog .END// ========================= -->

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content padding-y-sm bg">
        <div class="container">

            <header class="section-heading heading-line">
                <h4 class="title-section bg">FEATURED PRODUCTS</h4>
            </header>
           
            <div class="row">
                 <?php 
                $queryproducts =$dbcon->prepare("SELECT * FROM `products` WHERE featured='1'LIMIT 4");
                $queryproducts->execute();
                $queryresults=$queryproducts->fetchAll(PDO::FETCH_OBJ);
                //die(json_encode($queryresults));
                foreach($queryresults as $prodresults){   
                ?>
                <div class="col-md-3">
                    <figure class="card card-product">
                             <div class="img-wrap "><img src="<?="uploads/".$prodresults->product_image?>"></div>
                            <figcaption class="info-wrap">
                                <h4 class="title"><?=$prodresults->product_name?></h4>
                                <p class="desc"><?=substr($prodresults->product_details,0,30)?></p>
                            <!-- rating-wrap.// -->
                            </figcaption>
                            <div class="bottom-wrap">                                    
                                
                                <div class="price-wrap h5">
                                    <span class="price-new">$<?=$prodresults->product_price?></span>
                                    <div>
                                    <button class="btn btn-primary addToCartBtn" value="<?=$prodresults->id ?>">Add to Cart</button>

                                    <a href='productview.php?id=<?= $prodresults->id?>' >
                                    <button class="btn btn-info">View Details</button></a>
                                    
                                    </div>
                                   
                                </div>
                            <!-- price-wrap.// -->
                            </div>
            
                        <!-- bottom-wrap.// -->
                        
                    </figure>
                    
                </div>
                <?php } ?>
            
  
                <!-- col // -->
            </div>
            <!-- row.// -->

        </div>
        <!-- container .//  -->
    </section>

    <!--test-->
    <!-- ========================= SECTION ITEMS ========================= -->
    <section class="section-request bg padding-y-sm">
        <div class="container">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase">Recently Added</h4>
            </header>
            <div class="row">
            <?php 
                $queryproductsrecent=$dbcon->prepare("SELECT * FROM `products` ORDER BY id DESC LIMIT 4");
                $queryproductsrecent->execute();
                $queryresultsrecent =$queryproductsrecent->fetchAll(PDO::FETCH_OBJ);

                foreach($queryresultsrecent as $prodrecent){   
                ?>
                <div class="col-md-3">
                  
                        <figure class="card card-product">
                        
                            <div class="img-wrap"><img src="<?="uploads/".$prodrecent->product_image?>"></div>
                            <figcaption class="info-wrap">
                                <h4 class="title"><?= $prodrecent->product_name?></h4>
                                <p class="desc"><?=substr($prodrecent->product_details,0,30)?></p>
                      
                                <!-- rating-wrap.// -->
                            </figcaption>
                            <div class="bottom-wrap">
                                <div class="price-wrap h5">
                                    <span class="price-new">$<?= $prodrecent->product_price?></span> <del class="price-old">$1980</del>
                                    <div>
                                    <button class="btn btn-primary addToCartBtn" value="<?=$prodrecent->id;?>">Add to Cart</button>

                                    <a href='productview.php?id=<?= $prodrecent->id?>' >
                                    <button class="btn btn-info">View Details</button></a>
                                    
                                    </div>
                                   
                              
                                </div>
                                <!-- price-wrap.// -->
                            </div>
                            <!-- bottom-wrap.// -->
                          
                        </figure>
                </div>

              <?php }?>
             </div>
             </div>
    
            </section>

    <!-- ========================= Subscribe ========================= -->
    <section class="section-subscribe bg-primary padding-y-lg">
        <div class="container">

            <p class="pb-2 text-center white">Delivering the latest product trends and industry news straight to your inbox</p>

            <div class="row justify-content-md-center">
                <div class="col-lg-4 col-sm-6">
                    <form class="row-sm form-noborder">
                        <div class="col-8">
                            <input class="form-control" placeholder="Your Email" type="email">
                        </div>
                        <!-- col.// -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-block btn-warning"> <i class="fa fa-envelope"></i> Subscribe </button>
                        </div>
                        <!-- col.// -->
                    </form>
                    <small class="form-text text-white-50">We’ll never share your email address with a third-party. </small>
                </div>
                <!-- col-md-6.// -->
            </div>

        </div>
        <!-- container // -->
    </section>


    <!-- ========================= Subscribe .END// ========================= -->
    <script>

                    
function addToCartClicked(event){
    var button = event.target
    var cardProduct = button.parentElement
    var title = cardProduct.getElementsByClassName('desc')[0].innerText
    console.log(title);
}

    </script>
   <?php include('includes/footer.php') ?>