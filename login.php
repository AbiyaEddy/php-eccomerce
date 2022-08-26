<?php
    // no session has been started yet
    
    session_start(); 
  
// include('config.php');
include('./includes/header.php'); 
include('./includes/navbar.php'); 

include_once(__DIR__ . "/includes/config.php");
// include_once(__DIR__ . "/includes/footer.php");



try {

if(isset($_POST['login_btn'])){

    $email =$_POST['email'];
    $password =$_POST['password'];


  
        //code...
        $query = $dbcon->prepare("SELECT * FROM userstable WHERE email = :email");
        $query->bindParam(":email",$email,PDO::PARAM_STR);
        $query->execute();
    
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

       
        if($result> 0)
        {
           
                    foreach($result as $userresult){
                        
                    if(password_verify($password,$userresult['password'])){
        
                
                    
                        $_SESSION['username']=$userresult['username'];
                        $_SESSION['email']=$userresult['email'];
                        $_SESSION['id']=$userresult['id'];

                       
                        // header('Location:login.php');
                        echo"<script>window.location.href='home.php';</script>";
                        exit(0);
                        
                    }
                    
            }

    
        
     }
     else
     {
        $_SESSION['message'] = "Invalid email or password";
        // header('Location:login.php');
        echo"<script>window.location.href='login.php'</script>";
        exit();
     }
    }
    } catch (PDOException $e) {
        //throw $th;
        echo $e->getMessage();
    }
   



?>
    <!-- ========================= SECTION PAGETOP ========================= -->
        <div class="container clearfix">
            <h2 class="title-page text-center text-primary">Log In</h2>
        </div> 
   
    <!--========================= SECTION INTRO END// ========================= -->
    <!-- ========================= SECTION CONTENT END// ========================= -->
    <section class="section-content bg padding-y">
        <div class="container">
            <div class="col-md-6 mx-auto">

            <?php include('message.php');?>
            
                <div class="card">
                    <header class="card-header">
                        <h4 class="card-title mt-2">Log in</h4>
                    </header>
                    <article class="card-body">
                        <form action="login.php" name="login" method="POST">
                            <!-- form-row end.// -->
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" name ="email" id="email" class="form-control" placeholder="">
                           
</div>
                            <!-- form-row.// -->
                            <div class="form-group">
                                <label>password</label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                            <!-- form-group end.// -->
                            <div class="form-group">
                                <button type="submit" name='login_btn' class="btn btn-primary btn-block"> Log in </button>
                            </div>
                            <!-- form-group// -->
                        </form>
                    </article>
                    <!-- card-body end .// -->
                </div>
                <!-- card.// -->
            </div>
        </div>
    </section>
    <!-- ========================= FOOTER ========================= -->
  <?php include('includes/footer.php');?>