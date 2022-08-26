<?php 
session_start();
include('includes/header.php');
include('includes/navbartop.php');


include_once(__DIR__ . "/includes/config.php");
// include('config.php');

if(isset($_POST['updatecategory']))
{
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];

    try{

       $query =$dbcon->prepare("UPDATE category SET name=:name,slug=:slug,description=:description WHERE id =:category_id");
       $query->bindParam("name",$name);
       $query->bindParam("slug",$slug);
       $query->bindParam("description",$description);
       $query->bindParam("category_id",$category_id);

       $results=$query->execute();

       if($results)
       {
        $_SESSION['message'] ="Category Updated successfully";
        // header('Location:category.php');
        echo"<script>window.location.href='category.php';</script>";
            exit(0);
        }else
        {
            $_SESSION['message'] ="Error while Updating Data";
        header('Location:category-add.php');
        exit(0);

    }
    }catch(PDOException $e){
        echo $e-getMessage();
    }
    
}

?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Categories</h1>
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
                        <h4>Categories
                            <a href ="category-add.php" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">

                    <?php
                    if (isset($_GET['id']))
                    {
                        $categoryid = $_GET['id'];

                        $query = $dbcon->prepare("SELECT * FROM `category`WHERE id =:category_id LIMIT 1");
                        $query->bindParam("category_id",$categoryid);
                        $query->execute();

                        $result= $query->fetch(PDO::FETCH_OBJ);
                    }
                    ?>

                    <form action="" method="POST">
                        <input type="hidden" name="category_id" value="<?= $result->id?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">Category name</label>
                            <input type="text" name="name"  value="<?= $result->name?>" class="form-control">
                        </div>
                       
                        <div class="col-md-6 mb-3">
                            <label for="">Slug</label>
                            <input type="text" name="slug" value="<?= $result->slug?>"class="form-control">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="">Description</label>
                            <textarea name="description"  class="form-control"value="<?= $result->description?>" rows="4"><?= $result->description?></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <button type="submit" name="updatecategory" class="btn btn-primary" >Update Category</button>
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