<?php 

if (!isset($_SESSION)) { 
    // no session has been started yet
    ob_start();
    session_start(); 
  } 
include('./includes/header.php');
include('./includes/navbar.php');


include_once(__DIR__ . "/includes/config.php");

if(isset($_POST['registerbtn']))

{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    $hashPassword = password_hash($_POST['password'],PASSWORD_BCRYPT);

    try {
        
    if($password == $password_confirmation)
    {
        $query=$dbcon->prepare("SELECT email FROM `userstable`WHERE email=:email");
        $query ->bindParam(':email',$email);
        $query->execute();
        $result = $query->fetchColumn();
        if($result > 0)
        {
            //email already exist
            $_SESSION['message']= "Email already exists";
            // echo"<script>window.location.href=register.php</script>";
            header('Location:register.php');
            exit();
        }else
        {
            $hashPassword = password_hash($password,PASSWORD_BCRYPT);

            $userquery =$dbcon->prepare("INSERT INTO `userstable` (username,email,password) VALUES(:username,:email,:hashPassword)");
            $userquery->bindParam(':username',$username);
            $userquery->bindParam(':email',$email);
            $userquery->bindParam(':hashPassword',$hashPassword);
            $result=$userquery->execute();

            if($result)
            {
                $_SESSION['message']= "Registration was successfull";
                // echo"<script>window.location.href=login.php</script>";
                header('Location:login.php');
                exit();
            }
            else
            {
                $_SESSION['message']= "Something went Wrong during Registration ";
                // echo"<script>window.location.href=register.php</script>";
                header('Location:register.php');
                exit();
            }
        }
    }
    else
    {
        $_SESSION['message']= "Password does dont match";
        // echo"<script>window.location.href=register.php</script>";
        header('Location:register.php');
        exit();
    }
    } catch (PDOException $e){

        echo'error'. $e->getMessage();
    }

}




?>
    <!-- ========================= SECTION PAGETOP ========================= -->
        <div class="container clearfix">
            <h2 class="title-page text-center text-primary">Register</h2>
        </div> 
   
    <!--========================= SECTION INTRO END// ========================= -->
    <!-- ========================= SECTION CONTENT END// ========================= -->
    <section class="section-content bg padding-y">
        <div class="container">
            <div class="col-md-6 mx-auto">

            <?php include('message.php');?>
            
                <div class="card">
                    <header class="card-header">
                        <h4 class="card-title mt-2">Sign up</h4>
                    </header>
                    <article class="card-body">
                        <form action="" method="POST">
                            <div class="form-row">
                                <div class="col form-group">
                                    <label>Full names</label>
                                    <input type="text" name="username"  id ="username" class="form-control" placeholder="">
                                </div>
                            </div>
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
                             <div class="form-group">
                                <label>Confirm Password</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                            </div>
                            <!-- form-group end.// -->
                            <div class="form-group">
                                <button type="submit" name='registerbtn' class="btn btn-primary btn-block"> Register </button>
                            </div>
                            <!-- form-group// -->
                        </form>
                    </article>
                    <!-- card-body end .// -->
                    <div class="border-top card-body text-center">Have an account? <a href="login.php">Log In</a></div>
                </div>
                <!-- card.// -->
            </div>
        </div>
    </section>
    <!-- ========================= FOOTER ========================= -->
  <?php include('includes/footer.php');?>