<?php
 session_start();

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
    $id = $_POST['username'];
    $password = base64_encode($_POST['pass']);

    $query = "SELECT * FROM login WHERE username=:id AND password=:pass";
    
        // prepare query
        $stmt = $conn->prepare($query);
    
        // sanitize
        $password=strip_tags($password);
        
    
        // bind values
        $stmt->bindParam(":pass", $password);
        $stmt->bindParam(":id", $id);
        // execute query
        $stmt->execute();
        
         if($stmt->rowCount() > 0){
            //  echo"loged in";
             $_SESSION['username']=$id;
              header('location:menu.php');
        }
        else{
            // $_SESSION['errorid']="Invalid UserId";
            // $_SESSION['errorpass']="Invalid Password";
            echo "<script> alert('Invalid username or Password!') </script>"; 
             echo "<script>location.href='login.html'</script>";
        }
    }
  catch(PDOException $e)
    {
       // echo $e;
        header('location:login.html');   
}

 ?>