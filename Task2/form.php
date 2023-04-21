<?php 
include './connDB.php';

if(isset($_POST["submit"])){
  $name = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $errorsCollection = array();

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errorsCollection, "Invalid email address");
  }

  if (strlen($password) < 8) {
    array_push($errorsCollection,  "Password must be at least 8 characters long");
  }

  if (!empty($errorsCollection)) {
    // Display error messages to the user
    echo "<div class='error' style='color:red; 
    background-color: red;
    color: white;
    padding: 10px;
    text-align: center;
    z-index: 2;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);'>";
    foreach ($errorsCollection as $error) {
      echo "<p>" . $error . "</p> <br>";
    }
    echo "</div> <br>";
  } else {

    function passwordHashing($password){
        $salt = bin2hex(random_bytes(16));
        $hash = password_hash($password, PASSWORD_BCRYPT, ['salt' => $salt]);
        return $hash;
    }
    $hashedpassword=passwordHashing($password);
    
    // sql query for inserting the new user 
    $sql="INSERT INTO `userinfo` (`USERNAME`,`EMAIL`,`PASSWORD`) VALUES ('$name','$email','$hashedpassword')";
    $res=mysqli_query($conn,$sql);
    
    if($res){
        echo "data inserted successfully";   
      header("location:./allUsers.php");
    }
    else{
        echo "data not inserted";
        echo "<div class='error'>"."either the username length or the password length exceeds limit"."</div>";
    }

  }

}
?>
