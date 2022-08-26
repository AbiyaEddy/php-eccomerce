<?php ?>



<?php include('./includes/header.php'); ?>


<?php include('./includes/navbar.php'); ?>

<?php include_once(__DIR__ . "/includes/config.php");?>



<div class="container-fluid px-4">
  <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">
       
        </li>
        </ol>
        <div class="row">
            <div class="col-md-12">
            <?php if(isset($_SESSION['message'])) : ?>
                    <h5 class = "alert alert-success"><?= $_SESSION['message']; ?></h5>
                    <?php 
                    unset($_SESSION['message']);
                endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Shopping Cart
                         
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Name</th>
                                    <th>Details</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>image</th>
                                    <th>Action</th>
                                <tr>
                            </thead>
                          <tbody>
                              <tr>
                                  <td>1</td>
                                  <td>2</td>
                                  <td>2</td>
                                  <td>1</td>
                                  <td>1</td>
                                  <td>t</td>
                               <td class="text-right">
                                <div class="input-group" >

                                    <form action="product.php" method="POST" class="">
                                    
                                    <button type = "submit" name="deleteProduct"class="btn btn-danger"><i class="far fa-trash-alt"></i>Remove</button>
                           
                                    </form >
                                 
                             
                                    <div>
                                </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


</div>

<?php include('./includes/footer.php'); ?>


