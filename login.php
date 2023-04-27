<?php
session_start();
include 'connect.php';



$error = "";

$email = '';
$password = ''; 
if(isset($_POST['loginButton'])) {   
    
    
    
    $email = trim($_POST['email']); //use trim() to delete space
    $password = md5(trim($_POST['password']));
    
    //Read data from databse table
    $statement = $dbconnection->query("SELECT * FROM users WHERE email='$email' AND password='$password' ");    
    
    
   
  
    if($statement->rowCount() >= 1) {
        $result = $statement->fetch();

        echo $result['role'];        
        $_SESSION['user'] = $result;  

        //Admin dashboard or user dashboard
        if($result['role'] == 'user') {
            header('location:user-dashboard.php');
        } else {
            header('location:admin_dashboard.php'); 
        }
                       
        
    } else {       
        $error = "Invalid Email or Password";        
    }
    

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Document</title>
    <style>
        body {
            padding : 3px;
        }
    </style>
</head>
<body>
   
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">                
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">
                                <a href="index.php"><h6 class="text-white ">Home</h6></a>    
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                                                        
                            </div>
                        </div>              
                    
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                        <div class="card">
                        <div class="card-header bg-primary">
                            <div class="card-title text-white">
                                Login                        
                            </div>
                        </div>
                        <form action="login.php" method="POST">
                        <div class="card-body"> 
                        <?php
                        if($error != ""): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?php echo $error; ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>                           

                        <?php endif ?>                           
                        
                                                                        
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" >  
                                                                  
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" >                                
                                </div>           
                                                            
                        </div>
                        <div class="card-footer bg-primary">
                            <button type="submit"class="btn btn-danger" name="loginButton">Login</button>
                            <span class="float-right text-white mt-2">If you have no account yet, <a href="register.php" class="text-dark font-weight-bold">reigister here</a></span>
                        </div>
                        
                        </form>

                        </div>
                    
                        </div>
                        <div class="col-md-3"></div>
                        
                        </div>
                        
                        
                        
                    
                    </div>                    
                </div>
                
            </div>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


 <!-- //sweeAlert package -->
</body>
</html>
