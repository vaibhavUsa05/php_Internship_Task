<?php include './connDB.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>All Users</title>
  <link rel="stylesheet" href="./allUsers.css">
</head>
<body>
<form class="searchUsers" method="get">
<input type="text" name="query" class="search" placeholder="Search the user by Name or Email...">
    <button type="submit">Search</button>
</form>
  <table>
  
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
    <?php
    // to show only 10 records at a time 
       $results_per_page =5;
       $page = 1;
       if(isset($_GET['page'])) {
         $page = $_GET['page'];
       }
       $offset = ($page - 1) * $results_per_page;
       
       if(isset($_GET['query'])) {
         $query = mysqli_real_escape_string($conn, $_GET['query']);
         $sql = "SELECT * FROM `userinfo` WHERE `USERNAME` LIKE '%$query%' OR `EMAIL` LIKE '$query%' LIMIT $offset, $results_per_page";
       } else {
         $sql = "SELECT * FROM `userinfo` LIMIT $offset, $results_per_page";
       }
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>".$row['USERNAME']."</td>";
          echo "<td>".$row['EMAIL']."</td>";
          echo "<td class='formAction'>
          <form method='post'>
            <input type='hidden' name='Email' value='".$row['EMAIL']."'>
            <input type='submit' name='delete' value='Delete' class='delete'>
          </form>
          <form method='post'>
            <input type='hidden' name='Email' value='".$row['EMAIL']."'>
            <input type='submit' name='edit' value='Edit' class='edit'>
          </form>
        </td>";
  
          echo "</tr>";
        }
      } else {
        echo "<span class='noData'>0 results</span>";
      }

// Count total number of records
$sql = "SELECT COUNT(*) AS total FROM `userinfo`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];

// Calculate total number of pages
$total_pages = ceil($total_records / $results_per_page);

// Display pagination buttons
echo "<div class='pagination' style='
position: relative;
z-index: 3;
display: flex;
justify-content: center;
align-items: center;
bottom: -60vh;
font-size: 20px;
'>";
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<a href='#' class='active'>$i</a>";
    } else {
        echo "<a href='./allUsers.php?page=$i'>$i</a>";
    }
}
echo "</div>";







// For deleting the record
      if(isset($_POST['delete'])) {
        $Email = $_POST['Email'];
        $sql = "DELETE FROM `userinfo` WHERE `EMAIL`='$Email'";
        $result = mysqli_query($conn, $sql);
        if($result) {
          header("Refresh:0");
        } else {
          echo "Error deleting record: " . mysqli_error($conn);
        }
      }
    
      // For Editing the record
if(isset($_POST['edit'])) {
  $Email = $_POST['Email'];
  $sql = "SELECT * FROM `userinfo` WHERE `EMAIL`='$Email'";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo "<tr class='editForm'>";
    echo "<td colspan='2'>
            <form method='post'>
              <input type='hidden' name='Email' value='".$row['EMAIL']."'>
              <input type='text' name='username' value='".$row['USERNAME']."'>
              <input type='text' name='email' value='".$row['EMAIL']."'>
              <input type='password' name='password' placeholder='enter new password...'>
              <input type='submit' name='update' value='Update'>
            </form>
          </td>";
    echo "</tr>";
  }}
     
     
  // for Updating the recording
  if(isset($_POST['update'])) {
    $Email = $_POST['Email'];
    $NewEmail = $_POST['email'];
    $Username = $_POST['username'];
    $Password = $_POST['password'];
    $errorsCollection = array();
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
      array_push($errorsCollection, "Invalid email address");
    }
    if (strlen($Password) < 8) {
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
      function passwordHashing($password) {
        $salt = bin2hex(random_bytes(16));
        $hash = password_hash($password, PASSWORD_BCRYPT, ['salt' => $salt]);
        return $hash;
      }
      $hashedpassword = passwordHashing($Password);
      // Check if new email already exists in the database
      $email_check_query = "SELECT * FROM `userinfo` WHERE `EMAIL`='$NewEmail'";
      $result = mysqli_query($conn, $email_check_query);
      if(mysqli_num_rows($result) > 0) {
          echo "Error updating record: Email already exists";
      } else {
          $sql = "UPDATE `userinfo` SET `EMAIL`='$NewEmail', `USERNAME`='$Username', `PASSWORD`='$hashedpassword' WHERE `EMAIL`='$Email'";
          $result = mysqli_query($conn, $sql);
          if($result) {
              header("Refresh:0");
          } else {
              echo "Error updating record: " . mysqli_error($conn);
          }
      }
    }
  }
  
    
    
      mysqli_close($conn);

      
    ?>
    
  </table>
</body>
</html>
