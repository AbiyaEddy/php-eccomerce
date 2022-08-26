<?php 
session_start();
include('includes/header.php');
include('includes/navbartop.php');


include_once(__DIR__ . "/includes/config.php");
// include('config.php');


if(isset($_REQUEST['deleteCategory']))
{
    $category_id = $_REQUEST['deleteCategory'];


    try{

            $query = $dbcon->prepare("DELETE FROM `category` WHERE id=:category_id");
            $query->bindParam('category_id',$category_id);
            $query ->execute();
            $results =  $query ->execute();
      
        
        if($results)
       {
        $_SESSION['message'] ="Category Deleted successfully";
        // header('Location:category.php');
        echo"<script>window.location.href='category.php';</script>";
            exit(0);
        }else
        {
            $_SESSION['message'] ="Error while deleting Data";
         echo"<script>window.location.href='category.php';</script>";
        //    header('Location:category-add.php');
        exit(0);
            }
    }catch(PDOException $e){
        echo $e->getMessage();

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
            <div class="col-md-12">
            <?php if(isset($_SESSION['message'])) : ?>
                    <h5 class = "alert alert-success"><?= $_SESSION['message']; ?></h5>
                    <?php 
                    unset($_SESSION['message']);
                      endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Categories
                            <a href ="category-add.php" class="btn btn-primary float-end">Add Category</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Featured</th>
                                    <th>Action</th>
                                <tr>
                            </thead>
                            <tbody>
                                <?php
                                $query =$dbcon->prepare("SELECT * FROM `category`");
                                $query->execute();
                                $results =$query->fetchAll(PDO::FETCH_ASSOC);

                               
                                    ?>
                                
                               <?php foreach($results as $result){ ?>
                                <tr>
                               <td><?php echo $result['id']; ?></td>
                               <td><?php echo $result['name']; ?></td>
                               <td><?php echo $result['description']; ?></td>
                               <td><?php echo $result['featured']; ?></td>
                               <td>
                               <div class="input-group pl-sm-2" >
                                <a href="categoryEdit.php?id=<?= $result['id']; ?>" class="btn btn-success">Edit</a>
                                <form action="category.php" method="POST">    
                               <button type = "submit" name="deleteCategory" value="<?= $result['id'];?>" class="btn btn-danger"><i class="far fa-trash-alt"></i>Delete</button>

                              </form >
                               </div>
                                </td>
                                <?php   } ?>
                            
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