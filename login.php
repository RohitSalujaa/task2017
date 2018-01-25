<?php
session_start();

if (isset($_POST['submit'])){

  $error = array();


  if(isset($_POST['name']) && empty($_POST['name']))
    $error[] = "Name the field is required";

  if(isset($_POST['password']) && empty($_POST['password']))
    $error[] = "Password the field is required";

if(empty($error)){
$servername = "localhost";
$username = "rohitsaluja2017";
$password = "u*QmQie?E}vT";
$database = "task";
// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//echo "Connected successfully";

$name = $_POST['name'];
$password = $_POST['password'];

$sql = "SELECT * FROM users where name='$name' and password = '$password' ";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "name " . $row["name"];
        $public_key = $row['public_key'];
        $password = $row['password'];
        $private_key = $row['private_key'];
        
    }
} else {
    echo "Username and Password does not match";
}




  }// error empty
}//if post


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="signup.php">Signup<span class="sr-only">(current)</span></a>
          
          </li>
          
        </ul>
      </div>
    </nav>

    <main role="main" class="container">
      <br>
      <br>

      <div class="container">


         <?php
      if(isset($error) && !empty($error))
      {
        echo "<ul>";

        foreach($error as $e)
        {
          echo "<li>".$e."</li>";
        }


        echo "<ul>";
      }
      ?>


        <p>
          <?php
          if(isset($public_key)){
            echo "<h1>This is the public key</h1>";
            echo "$public_key";
          }
            
          if(isset($private_key)){
            echo "<h1>This is the private key</h1>";
            echo "$private_key";
          }
            

            if(isset($password)){
              echo "<h1>This is the password</h1>";
            echo "$password";

            echo "<h1>This is the encrypted password</h1>";
            openssl_public_encrypt($password, $encrypted, $public_key);
            echo "<p>$encrypted</p>"; 


            }

       


            
           

            ?>
        </p>

        <h1>Login </h1>
        <p>
          <?php
          ?>
        </p>

        <form method="post" action="login.php">
          <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" name="name">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input class="form-control" type="password" name="password">
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit" name="submit">Submit</button>
          </div>
        </form>


      </div>

    </main><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
