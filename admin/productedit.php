<?php 
session_start();
include('includes/header.php');
include('includes/navbartop.php');


include_once(__DIR__ . "/includes/config.php");
// include('config.php');

if(isset($_POST['updateproduct']))
{
    $product_id =$_POST['product_id'];
    $product_name =$_POST['product_name'];
    $product_price =$_POST['product_price'];
    $category_id =$_POST['category_id'];
    $product_details =$_POST['product_details'];
    $product_quantity =$_POST['product_quantity'];
    $featured = isset($_POST['featured']) ? '1':0;
    
    
    $newimage =$_FILES['product_image']['name'];
    $oldproduct_image = $_POST['oldproduct_image'];

    $path = "../uploads";

    try {
        //code...
           
    if($newimage != "")
    {
        $image_ext = pathinfo($newimage,PATHINFO_EXTENSION);

        $update_filename = time().'.'.$image_ext;
    }else
    {
        $update_filename =  $oldproduct_image ;
    }
    $queryupdate = $dbcon->prepare("UPDATE `products` 
    SET 
    product_name=:product_name,
    product_price=:product_price,
    category_id=:category_id, 
    product_details=:product_details,
    product_quantity=:product_quantity,
    featured=:featured,
    product_image=:update_filename 
    WHERE id =:product_id");
    var_dump( $queryupdate);
    
    $queryupdate->bindParam(':product_name',$product_name);
    $queryupdate->bindParam(':product_price',$product_price);
    $queryupdate->bindParam(':category_id',$category_id);
    $queryupdate->bindParam(':product_details',$product_details);
    $queryupdate->bindParam(':product_quantity',$product_quantity);
    $queryupdate->bindParam(':featured',$featured);
    $queryupdate->bindParam(':update_filename',$update_filename );
    $queryupdate->bindParam(':product_id',$product_id );

    $queryresults=$queryupdate->execute();

    if($queryresults)
    {
        if($_FILES['product_image']['name'])
        {
        move_uploaded_file($_FILES['product_image']['tmp_name'],$path.'/'.$update_filename );

        if(file_exists("../uploads".$oldproduct_image))
        {
           
            unlink("../uploads./".$oldproduct_image); 
        
           
        }
          }
           $_SESSION['message'] ="Product Updated successfully";
           echo"<script>window.location.href='product.php';</script>";
           exit(0);
        
        }
       else
       {
        $_SESSION['message'] ="Error in updating product";
        echo"<script>window.location.href='product.php';</script>";
        exit(0);
       }
    }
   
    catch (PDOException $e) {
        //throw $th;
        echo $e ->getMessage();
    }
 
}
 ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit product Page</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">
            Dashboard
        </li>
        </ol>
        <div class="row">
            <div class="col-md-8">
                <?php if(isset($_SESSION['message'])) : ?>
                    <h5 class = "alert alert-success"><?= $_SESSION['message']; ?></h5>
                     <?php 
                  unset($_SESSION['message']); endif; ?> 
                <div class="card">
                        <div class="card-header">
                                <h4>Edit Product
                                    <a href ="productadd.php" class="btn btn-danger float-end">Back</a>
                                </h4>
                        </div>
                 <div class="card-body">

                    <?php
                    if(isset($_GET['id']))
                    {
                        $product_id =$_GET['id'];

                        $query=$dbcon->prepare("SELECT * FROM `products` WHERE id=:product_id LIMIT 1");
                        $query->bindParam("product_id",$product_id);
                        $query->execute();

                        $result1= $query->fetch(PDO::FETCH_OBJ);
                    }
                   
                    ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                    <input class="form-control" type="hidden" name="product_id" value="<?= $result1->id ?>"/>
                                <div class="col-md-6 mb-3">
                                    <label for="">Product name</label>
                                    <input type="text" name="product_name" class="form-control"value="<?= $result1->product_name?>">
                                </div>
                                                    
                                <div class="col-md-6 mb-3">
                                    <label for="">Price</label>
                                    <input type="text" name="product_price" class="form-control" value="<?= $result1->product_price?>">
                                </div>
                            <div class="col-md-12 mb-3">
                                    <label for="">Select Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                    <option selected>Select Category</option>

                                    <?php 
                                    $query=$dbcon->prepare("SELECT * FROM `category`");
                                    $query ->execute();
                                    $results =$query->fetchAll(PDO::FETCH_ASSOC);
                                
                                    foreach($results as $result){
                                        { ?>

                                        <option value ="<?= $result['id'];?>"<?= $result1->category_id == $result['id']?'selected':''?>>
                                        <?=$result['name'];?>
                                       </option>
                                    
                                    <?php } ?> 
                                 

                                        <?php } ?>

                                    </select>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="">Details</label>
                                    <textarea name="product_details"  class="form-control" rows="4" value="<?= $result1->product_details?>" > <?= $result1->product_details?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                            <label for="">Quantity</label>
                            <input class="form-control" type="number" name="product_quantity" value="<?= $result1->product_quantity?>"/>
                        </div>
                                <div class="col-md-6 mb-3">
                                    <!-- <label for="">Upload Image</label> -->
                                    <input class="form-control" type="hidden" name="oldproduct_image" value="<?= $result1->product_image ?>"/>
                                    <label for="">Current Image</label>
                                    <img src ="../uploads/<?= $result1->product_image?>" alt="product image" height = "50px" width ="50px">
                                    <input class="form-control" type="file" name="product_image" value=""/>
                                </div>
                                <div class="col-md-6 mb-3">
                            <label for="">Featured</label>
                            <input  type="checkbox" name="featured" <?= $result1->featured == '0'?'':'checked'?>/>
                           </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" name="updateproduct" class="btn btn-primary" >Update Product</button>
                                </div>


                            </div>
                        </form>
                        </div>
                    </div>
                
                   </div>
                </div>

            </div>
        </div>


</div>

<?php 
include('includes/footer.php');
include('includes/scripts.php');
?>