<?php
include 'connect.php';

$nameError = "";
$emailError = "";
$addressError = "";
$passwordError = "";
$comfirmPasswordError = "";

$name = "";
$email = "";
$address = "";
$password = "";
$confirm_password = "";

if(isset($_POST['register_button'])) {
    $name = $_POST['name'];    
    $email = $_POST['email'];  
    $address = $_POST['address'];   
    $password = $_POST['password'];       
    $confirm_password = $_POST['confirm_password'];   

    if(empty($name)) {
        $nameError = "The name field is required";        
    }
    if(empty($email)) {
        $emailError = "The email field is required";     
    }
    if(empty($address)) {
        $addressError = "The address field is required";    
    } 
    if(empty($password)) {
        $passwordError = "The password field is required";   
    } 
    if(empty($confirm_password)) {
        $comfirmPasswordError = "The confirm password field is required";
    }
    if($confirm_password != $password) {
        $comfirmPasswordError = "The password does not match";
    }

    if(!empty($name) && !empty($email) && !empty($address) && !empty($password) && !empty($confirm_password) && $confirm_password == $password) {
        $sql = "INSERT INTO users (name, email, address, password) VALUES (:name, :email, :address, :password)";

        $statement = $dbconnection->prepare($sql);

        $result = $statement->execute([
        ":name" => $name,
        ":email" => $email,
        ":address" => $address,
        ":password" => md5($password), //Encryption password added to db_table
        ]);

        if(isset($result)) {        
            echo "<script> alert('Your registration is successfully!');</script>";
            header('location:login.php');
        } else {
            echo "<script> alert('Sorry, Your registration is not successfully!');</script>";         
        }     

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
                        <div class="card-header bg-info">
                            <div class="card-title">
                                Register                        
                            </div>
                        </div>

                        <form action="register.php" method="POST">
                        <div class="card-body">                            
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control <?php if($nameError != "") { ?>
                                         is-invalid
                                    <?php } ?>" name="name" value="<?php echo $name; ?>" placeholder="Enter your name">     
                                    <i class="text-danger">
                                        <?php echo $nameError ?>
                                    </i>                           
                                </div>
                                <div class="form-group">
                                    <label class="form-label" >Email</label>
                                    <input type="email" class="form-control <?php if($emailError != "") { ?>
                                         is-invalid
                                    <?php } ?>" name="email" value="<?php echo $email; ?>" placeholder="Enter your email">
                                    <i class="text-danger">
                                        <?php echo $emailError ?>
                                    </i>                                 
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea type="text" class="form-control <?php if($addressError != "") { ?>
                                         is-invalid
                                    <?php } ?>" rows="4" name="address"  placeholder="Enter your address"><?php echo $address; ?></textarea>            
                                    <i class="text-danger">
                                        <?php echo $addressError ?>
                                    </i>                   
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control <?php if($passwordError != "") { ?>
                                         is-invalid
                                    <?php } ?>" name="password" value="<?php echo $password; ?>" placeholder="Enter your password" >     
                                    <i class="text-danger">
                                        <?php echo $passwordError ?>
                                    </i>                            
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control <?php if($comfirmPasswordError != "") { ?>
                                         is-invalid
                                    <?php } ?>" name="confirm_password" value="<?php echo $confirm_password; ?>" placeholder="Enter your confirm password" >         
                                    <i class="text-danger">
                                        <?php echo $comfirmPasswordError ?>
                                    </i>                        
                                </div>
                                
                            
                        </div>
                        <div class="card-footer bg-info">
                            <button type="submit" name="register_button" class="btn btn-danger">Register</button>
                            <span class="float-right">If you already had an account,<a href="login.php" class="text-white"> Login here</a></span>
                        </div>
                        </form>

                        </div>
                    
                        </div>
                        <div class="col-md-3">

                        </div>
                        
                        </div>
                        
                        
                        
                    
                    </div>                    
                </div>
                
            </div>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>
