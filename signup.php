<?php
 session_start();

// get database connection   
$host = "localhost";
$db_name = "food-shala";
$username = "root";
$password = "";
$conn;

// header('location:Loginform.php');

 

try {
  $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
  $username = htmlspecialchars($_POST['username']);
  $password = base64_encode($_POST['password']);
  $password1= base64_encode($_POST['password1']);
  $mail=$_POST['email'];

  $query = "SELECT * FROM login WHERE username=:username";
    // prepare query statement
  $stmt = $conn->prepare($query);
    // sanitize
  $id=htmlspecialchars(strip_tags($username));
    // bind values
  $stmt->bindParam(":username", $username);
    // execute query
  $stmt->execute();
  if($stmt->rowCount() > 0){
      echo "<script>alert('Username not  available')</script>";
      echo "<script>location.href='signup.html'</script>";
	  
    
}
else{
  if($password1==$password){
    $query = "INSERT INTO login (username,password,email) VALUES (:username,:pass,:mail)";
    
    // prepare query
    $stmt = $conn->prepare($query);

    // sanitize
    $username=htmlspecialchars(strip_tags($username));
    $password=htmlspecialchars(strip_tags($password));
    $mail=htmlspecialchars(strip_tags($mail));

    // bind values
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pass", $password);
    $stmt->bindParam(":mail",$mail);
    
    $count=$stmt->execute();
    // echo $count;
    // execute query
    if($count){
            $_SESSION['username']=$_POST['username'];
    $_SESSION['pass']=$_POST['password'];
    echo "<script> alert('Account created succesfully')</script>";
    echo "<script>location.href='login.html'</script>";

  }
  // echo 'signup last';
  else{
     header('location:signup.html');
  }
  
 
}
	else{
    echo "<script> alert('Both the passwords are not same!!') </script>";
     echo "<script>location.href='signup.html'</script>";
	}
  }
}
catch(PDOException $e)
  {
    // echo "Error: " . $e->getMessage();
    echo '<br>connection error';
	
    header('location:signup.html');
  }
  ?>