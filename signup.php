<?php

session_start();
ini_set('display_errors', 1);


if (isset($_POST['submit'])){

  $error = array();

  if(isset($_POST['name']) && empty($_POST['name']))
    $error[] = "Name field is required";

  if(isset($_POST['password']) && empty($_POST['password']))
    $error[] = "Password field is required ";

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


$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 4096,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);
    
// Create the private and public key
$res = openssl_pkey_new($config);


// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privKey);

//echo  $privKey;

// Extract the public key from $res to $pubKey

$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

//echo $pubKey;


$data = $_POST['password'];

// Encrypt the data to $encrypted using the public key
openssl_public_encrypt($data, $encrypted, $pubKey);
//echo "encrypted data goes here";
//echo $encrypted;
$name = $_POST['name'];

$sql = "INSERT INTO users (name,password,public_key,private_key)
VALUES ('$name', '$data', '$pubKey','$privKey')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    echo "<h1>This is the public key used to encrypt </h1>";
    echo "<p>$pubKey</p>";
    //echo "<h1>This is the  key used from the server side</h1>"
    //echo "<p>$privKey</p>";
    echo "<h1>This is encrypted password  </h1>";
    echo "<p>$encrypted</p>";
      $_SESSION['user'] = $name;

    //header('Location: http://www.oneclickproject.com/home.php');
  
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Decrypt the data using the private key and store the results in $decrypted
//openssl_private_decrypt($encrypted, $decrypted, $privKey);


//echo "decrypted data goes here";
//echo "<br>";
//echo $decrypted;  
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
          <li class="nav-item">
              <a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="container">
      <br>
      <br>
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
      <div class="container">
        <form method="post" action="signup.php">
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
