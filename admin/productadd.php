<?php 
session_start();
include('includes/header.php');
include('includes/navbartop.php');


include_once(__DIR__ . "/includes/config.php");
// include('config.php');

 if(isset($_POST['productadd']))
 {
     $product_name=$_POST['product_name'];
     $product_price=$_POST['product_price'];
     $category_id=$_POST['category_id'];
     $product_details=$_POST['product_details'];
     $product_quantity =$_POST['product_quantity'];
     
     $featured = isset($_POST['featured']) ? '1':0;
     $product_image=$_FILES['product_image']['name'];

     $path = "../uploads";

     $image_ext = pathinfo($product_image,PATHINFO_EXTENSION);

     $file_name = time().'.'.$image_ext;

    
     $query = $dbcon->prepare("INSERT INTO `products`(product_name,product_price,category_id,product_details,product_quantity,featured,product_image)
      VALUES(:product_name,:product_price,:category_id,:product_details,:product_quantity,:featured,:file_name)");

       $query->bindParam(':product_name',$product_name);
       $query->bindParam(':product_price',$product_price);
       $query->bindParam(':category_id',$category_id);
       $query->bindParam(':product_details',$product_details);
       $query->bindParam(':product_quantity',$product_quantity);
       $query->bindParam(':featured',$featured);
       $query->bindParam(':file_name',$file_name);

    $results= $query->execute();
    


     if($results)
    {
        move_uploaded_file($_FILES['product_image']['tmp_name'],$path.'/'.$file_name);
         $_SESSION['message'] ="Product Inserted successfully";
         echo"<script>window.location.href='product.php';</script>";
         exit(0);
    }else
     {
         $_SESSION['message'] ="Error while Inserting Product";
         echo"<script>window.location.href='productadd.php';</script>";
         exit(0);

     }
 }

 ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Add products Page</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">
            Dashboard
        </li>
        </ol>
        <div class="row">
            <div class="col-md-8">
                <?php if(isset($_SESSION['message'])) : ?>
                    <h5 class = "alert alert-success"><?= $_SESSION['message']; ?></h5>
                    <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Add Product
                            <a href ="productadd.php" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">

                    <form action="productadd.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">Product name</label>
                            <input type="text" name="product_name" class="form-control">
                        </div>
                       
                       
                        <div class="col-md-6 mb-3">
                            <label for="">Price</label>
                            <input type="text" name="product_price" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                            <?php 
                            $query=$dbcon->prepare("SELECT * FROM `category`");
                            $query ->execute();
                            $results =$query->fetchAll(PDO::FETCH_ASSOC);
                        
                           
                            foreach($results as $result){
                                { ?>
                               <option value="<?php echo $result['id']; ?>"><?php echo $result['name'];?> </option>
                               <?php } ?>
                                } 

                                <?php } ?>

                             </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="">Details</label>
                            <textarea name="product_details"  class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Quantity</label>
                            <input class="form-control" type="number" name="product_quantity" value="" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Upload Image</label>
                            <input class="form-control" type="file" name="product_image" value="" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Featured</label>
                            <input  type="checkbox" name="featured" value="" />
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="submit" name="productadd" class="btn btn-primary" >Save Product</button>
                        </div>


                    </div>


                    </form>
                    </div>
                </div>
            </div>
        </div>


</div>

<?php 
include('includes/footer.php');
include('includes/scripts.php');
?>