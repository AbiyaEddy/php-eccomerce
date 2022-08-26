<?php 
session_start();
include('includes/header.php');
include('includes/navbartop.php');


include_once(__DIR__ . "/includes/config.php");
// include('config.php');

if(isset($_POST['categoryadd']))
{
    $name=$_POST['name'];
    $slug=$_POST['slug'];
    $description=$_POST['description'];
    $featured = isset($_POST['featured']) ? '1':0;

    $query = $dbcon->prepare("INSERT INTO category(name,slug,description,featured) VALUES(:name,:slug,:description,:featured)");
    $query->bindParam("name",$name);
    $query->bindParam("slug",$slug);
    $query->bindParam("description",$description);
    $query->bindParam("featured",$featured);

    $query->execute();


    if($query)
    {
        $_SESSION['message'] ="Category Inserted successfully";
        echo"<script>window.location.href='category-add.php';</script>";
        exit(0);
    }else
    {
        $_SESSION['message'] ="Error while Inserting Data";
        echo"<script>window.location.href='category-add.php';</script>";
        exit(0);

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

                    <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">Category name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                       
                        <div class="col-md-6 mb-3">
                            <label for="">Slug</label>
                            <input type="text" name="slug" class="form-control">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="">Description</label>
                            <textarea name="description"  class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Featured</label>
                            <input  type="checkbox" name="featured" value="" />
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="submit" name="categoryadd" class="btn btn-primary" >Save Category</button>
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