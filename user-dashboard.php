
<?php
session_start();
include 'connect.php';

$oldId = '';
$oldName = "";
$oldEmail = "";
$oldAddress = "";
$oldRole = "";
$oldPassword = "";
$user_id_to_update="";

$result = "";
$_SESSION['success_msg'] = '';
$_SESSION ['expire_time'] = '';

if(!isset($_SESSION['user'])) {   //to protect admin dashboard //this Session will start when login is successful
    
    header('location:login.php');
} elseif($_SESSION['user']['role'] != 'user') {
    header('location:admin_dashboard.php');    
}

//User Update
if(isset($_POST['user_update_button'])) {

    //Handle Password update Error 
    $id = $_POST['id'];
    $statementPassword =  $dbconnection->query("SELECT * FROM users WHERE id=$id");
    $resultPassword = $statementPassword->fetch();
    $old_password = $resultPassword['password']; 
    $input_password = $_POST['password'];
    $new_password = $old_password !=  $input_password ? md5($input_password) : $input_password; 
   
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
   

     
   

    try {
        $sql = "UPDATE users SET name=:name,email=:email,address=:address,password=:new_password WHERE id=:id";
        $statementUpdate = $dbconnection->prepare($sql);
    
        $result = $statementUpdate->execute([
            ':name' => $name,
            ':email' => $email,
            ':address' => $address,
            ':new_password' => $new_password,              
            ':id' => $id,
        
        ]);

        // //sweetalert
        if($result) {
            $_SESSION ['expire_time'] = time() + (0.1 * 60);
            $_SESSION['success_msg'] = "<script>swal('Good job!',  'Successful!', 'success');</script>";
            

         }
        
    } catch (PDOException $e) {
        die("Error Updating: ".$e->getMessage());  //like mysqli_error
    }  
    
}


//Edit Button
$user_edition_form_status = false;
if(isset($_GET['use_id_to_edit'])) {
    $user_edition_form_status = true;
    $use_id_to_edit = $_GET['use_id_to_edit'];

    $statement = $dbconnection->query("SELECT * FROM users WHERE id=$use_id_to_edit");
    $result = $statement->fetch();
    
    $oldId = $result['id'];
    $oldName = $result['name'];
    $oldEmail = $result['email'];
    $oldAddress = $result['address'];
    $oldRole = $result['role'];
    $oldPassword = $result['password'];
}

//READ user data form database and show info in edit card instead of SESSION Data
$authenticated_user_id = $_SESSION['user']['id'];
try {
    $sql = "SELECT * FROM users WHERE id=$authenticated_user_id";
    $statement = $dbconnection->query($sql);
    $result = $statement->fetch();
    
} catch (PDOException $e) {
    die("Error: ".$e->getMessage());  //like mysqli_error
} 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    
    <title>Document</title>
    <style>
        body {
            padding-top: 3px;
        }
        /* #posFixed {
            position: fixed;
            
        } */
    </style>
</head>
<body>     
    <?php
    // //sweetalert
    
    if(time() < $_SESSION ['expire_time'])  {
        echo $_SESSION['success_msg']; 
    } else {
        unset($_SESSION['success_msg']);
        unset($_SESSION['expire_time']);
    }
     
    ?>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">                
                <div class="card border-0">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">
                                    <a href="./user-dashboard.php"><h6 class="text-white">User Dashboard</h6></a>   
                           
                                </div>
                            </div>
                            <div class="col-md-6">
                            <form action="logout.php" method="GET">
                                <button type="submit" class="btn btn-danger float-right" onclick="return confirm('Are you sure to logout?');">Logout</button>
                            </form>  
                            </div>
                        </div>              
                    
                    </div>
                    <div class="card-body ">
                        <!--Display admin info -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mt-4 border-0">
                                <div class="card-body" id="posFixed">
                                <h6>User Info</h6>
                                <div>
                                Role:
                                <span class="badge badge-success pb-2"><?php echo $result['role']//dynamic; 
                                 //Static (can show with $_SESSION['user']['role'] )
                                ?></span>                            
                                </div>
                                <div>
                                Name: <?php echo $result['name']; ?> 
                                </div>
                                <div>
                                Email: <?php echo $result['email']; ?>
                                </div>
                                <div>
                                Address: <?php echo $result['address']; ?>
                                </div>
                                <div>
                                    <a href="user-dashboard.php?use_id_to_edit=<?php echo $result['id']; ?>" class="btn btn-success text-white btn-sm ">Edit Your Profile</a>
                                </div>

                                </div>
                                
                            </div>
                            </div>
                            <div class="col-md-6">
                            <?php if($user_edition_form_status == true):?>
                                <div class="card" id="posAbsolute">
                            <div class="card-header bg-success">
                            <div class="card-heading ">
                                User Edition Form
                            </div>
                            </div>

                            <form action="user-dashboard.php" method="POST">
                            <div class="card-body">                 
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="id" value="<?php echo $oldId; ?>" >
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter your new name" value="<?php echo $oldName; ?>">
                                </div>  
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your new email" value="<?php echo $oldEmail; ?>" >
                                </div>  
                                <div class="form-group">
                                    <label>Address</label>
                                   <textarea name="address" class="form-control" rows="4" placeholder="Enter your new address">
                                   <?php echo $oldAddress; ?>
                                   </textarea>
                                </div> 
                                <div class="form-group">
                                <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter your new password" value="<?php echo $oldPassword; ?>" >
                                </div> 
                                
                                <!-- <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control">
                                        <option value="">Select Role</option>
                                        <option value="admin" 
                                        <?php if($result['role'] == 'admin'):?>
                                            selected
                                            <?php endif ?> >Admin</option>
                                        <option value="user" 
                                        <?php if($result['role'] == 'user'):?>
                                            selected
                                            <?php endif ?>>User</option>
                                    </select>
                                </div>  -->
                                
                            </div>
                            <div class="card-footer bg-success">
                                <button name="user_update_button" class="btn btn-sm btn-primary">Update</button>
                            </div>
                            </form>                            
                            </div>
                            <?php endif ?>                              
                            </div>
                            
                        </div>
                    </div>                    
                </div>
                

                
            </div>
        </div>
    </div>
    
    
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>






</body>
</html>