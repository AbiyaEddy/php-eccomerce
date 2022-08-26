<?php
session_start();
include('includes/header.php');
include('includes/navbartop.php');


include_once(__DIR__ . "/includes/config.php");
// include('config.php');


if(isset($_POST['deleteProduct']))
{
    $product_id = $_POST['deleteProduct'];

    try{

        $query=$dbcon->prepare("DELETE FROM `productS` WHERE id= :product_id");
        $query->bindParam('product_id',$product_id);
        $query->execute();
        $results =  $query ->execute();

        if($results)
        {
         $_SESSION['message'] ="Product Deleted successfully";
         // header('Location:category.php');
         echo"<script>window.location.href='product.php';</script>";
             exit(0);
         }else
         {
             $_SESSION['message'] ="Error while deleting Data";
          echo"<script>window.location.href='product.php';</script>";
         //    header('Location:category-add.php');
         exit(0);
             }
       }catch(PDOException $e){
         echo $e->getMessage();
       }
}

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Products Page</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">
            Dashboard
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
                        <h4>All Products
                            <a href ="productadd.php" class="btn btn-primary float-end">Add New Product</a>
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
                                    <th>Category</th>
                                    <th>Featured</th>
                                    <th>image</th>
                                    <th>Action</th>

                                <tr>
                            </thead>
                            <tbody>

                            
                            <?php
                                $query =$dbcon->prepare("SELECT P.id,P.product_name,P.product_price,P.product_details,P.product_quantity,P.featured,P.product_image,C.name
                                FROM products P,category C
                                WHERE P.category_id = C.id;");
                                $query->execute();
                                $results =$query->fetchAll(PDO::FETCH_ASSOC);

                                   ?>

                           <?php foreach($results as $result){ ?>

                                <tr>
                               <td><?php echo $result['id']; ?></td>
                               <td><?php echo $result['product_name']; ?></td>
                               <td><?php echo substr($result['product_details'],0,30); ?></td>
                               <td><?php echo $result['product_price']; ?></td>
                               <td><?php echo $result['product_quantity']; ?></td>
                                 <td><?php echo $result['name']; ?></td>
                               
                                <td><?php echo $result['featured']; ?></td>
                               
                                <td><img src="<?php echo "uploads/".$result['product_image']; ?>" alt="image " height="100px" width="100px"></td>
                              
                               <td class="text-right">
                                <div class="input-group" >
                                <a href="productedit.php?id=<?=  $result['id']; ?>" class="btn btn-success">Edit</a>

                                    <form action="product.php" method="POST" class="">
                                    
                                    <button type = "submit" name="deleteProduct" value="<?= $result['id'];?>" class="btn btn-danger"><i class="far fa-trash-alt"></i>Delete</button>
                           
                                    </form >
                                 
                                    <?php  } ?>
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

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>