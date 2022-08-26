<?php
if (!isset($_SESSION)) { 
    // no session has been started yet
    session_start(); 
  } 
// include('config.php');
include_once(__DIR__ . "/includes/config.php");
// include_once(__DIR__ . "/includes/footer.php");

if(isset($_POST['login'])){
    $email =$_POST['email'];
    $password =$_POST['password'];
    $query = $dbcon->prepare("SELECT * FROM userstable WHERE email = :email");
    $query->bindParam("email",$email,PDO::PARAM_STR);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    
     if($result === false){
        $_SESSION['message']='<p class="error">Username password combination is wrong!</p>';
        header("Location:login.php");
     }else{
         if(password_verify($password,$result['password'])){
             foreach($result as $results){
                $user_id = $results['id'];
                $username = $results['username'];
                $role_as = $results['role_as'];
             }

             $_SESSION['auth'] = true;
             $_SESSION['auth_role'] = $role_as;//1 admin 0 normal user
             $_SESSION['auth_user'] = [
                'user_id'=>$user_id,
                'username'=>$username,
             ];

             if($_SESSION['auth_role']==1)
             {
                $_SESSION['message']='<p class="success">Welcome to Dashboard!</p>';
                header("Location:login.php");
                exit(0);
             }elseif($_SESSION['auth_role']==0){

             }
             $_SESSION['message']='<p class="success">Congratulations, you are logged in!</p>';
             header("Location:index.php");

          }else{
             $_SESSION['user_id'] = $result['id'];
             echo '<p class="error">Email password combination is wrong!</p>';
             header("Location:login.php");
         }
    }

}
?>
<!-- 
<div class="widget-header dropdown">
                        <a href="#" class="ml-3 icontext" data-toggle="dropdown" data-offset="20,10">
                                    <div class="icon-wrap icon-xs bg2 round text-secondary"><i class="fa fa-user"></i></div>
                                    <div class="text-wrap">
                                        <span>Login <i class="fa fa-caret-down"></i></span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <form class="px-4 py-3" action="login.php" method="POST">
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        </div>
                                        <a href="login.php">
                                        <button type="submit" name="login" class="btn btn-primary">Log in</button>
                                       </a>
                                    </form>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="register.php">Have account? Register</a>
                                    <a class="dropdown-item" href="#">Forgot password?</a>
                                </div>
                                <!--  dropdown-menu .// -->
    </div> -->

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
                        <form action="login.php" method="POST">
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
                            <!-- form-group end.// -->
                            <div class="form-group">
                                <button type="submit" name='login' class="btn btn-primary btn-block"> Log in </button>
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