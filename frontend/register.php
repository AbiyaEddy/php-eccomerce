<?php 

if (!isset($_SESSION)) { 
    // no session has been started yet
    session_start(); 
  } 
include('./includes/header.php');
include('./includes/navbar.php');
include('./includes/config.php');




if(isset($_POST['register'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    //  $confirmpassword = $_POST['confirmpassword'];
    $password_hash = password_hash($password,PASSWORD_BCRYPT);

    $query =  $dbcon ->prepare("SELECT * FROM userstable WHERE email=:email");
    $query->bindParam("email",$email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() >0){
        echo'<p class="error" >The email address is already registered!</p>';
    }

    if($query->rowCount()==0){
        $query =$dbcon->prepare("INSERT INTO userstable(username,password,email) VALUES(:username,:password_hash,:email)");
        $query ->bindParam("username",$username,PDO::PARAM_STR);
        $query ->bindParam("password_hash",$password_hash,PDO::PARAM_STR);
        $query ->bindParam("email",$email,PDO::PARAM_STR);
        $result =$query->execute();

        if($result){
           $_SESSION['message']="Your registration was successful!";
        }else
        {
            $_SESSION['message']="Something went wrong!";
        }
    
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
                        <form action="register.php" method="POST">
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
                                <small class="form-text text-muted">We'll never share your email with anyone else.</small>
</div>
                            <!-- form-row.// -->
                            <div class="form-group">
                                <label>password</label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                            <!-- <div class="form-group">
                                <label>Confirm Password</label>
                                <input class="form-control" type="password" name="confirmpassword" id="password">
                            </div> -->
                            <!-- form-group end.// -->
                            <div class="form-group">
                                <button type="submit" name='register' class="btn btn-primary btn-block"> Register </button>
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