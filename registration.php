<?php
require_once('./config.php');

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Registration Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
  <body>
  <body>
  <div class="container">
  <div id="alert-container"></div>
    <h1>Registration Form</h1>
    <form method="post" action="registration.php">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <input type="submit" class="btn btn-primary" value="Register">
    </form>
</div>

<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = mysqli_real_escape_string($conn, $name = $_POST["name"]);
    $check_name = "SELECT * FROM users WHERE name = '$name'";
    $result = $conn->query($check_username);

    if ($result->num_rows > 0) {
        echo "<script>
        $(document).ready(function(){
          $('#alert-container').append(
            '<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">' +
            '<strong>Failed!</strong> Name is already registered try another.' +
            '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">' +
            '<span aria-hidden=\"true\">&times;</span>' +
            '</button>' +
            '</div>'
          );
        });
      </script>";
    return;
}

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        echo "<script>
        $(document).ready(function(){
          $('#alert-container').append(
            '<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">' +
            '<strong>Failed!</strong> Email is already registered try another.' +
            '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">' +
            '<span aria-hidden=\"true\">&times;</span>' +
            '</button>' +
            '</div>'
          );
        });
      </script>";
    return;
}


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
        $(document).ready(function(){
          $('#alert-container').append(
            '<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">' +
            '<strong>Failed!</strong> Email is in the wrong format.' +
            '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">' +
            '<span aria-hidden=\"true\">&times;</span>' +
            '</button>' +
            '</div>'
          );
        });
      </script>";
    return;
}

$password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();

        echo "<script>
      $(document).ready(function(){
        $('#alert-container').append(
          '<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">' +
          '<strong>Success!</strong> Your account has been created, you will be redirected to the login page soon!' +
          '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">' +
          '<span aria-hidden=\"true\">&times;</span>' +
          '</button>' +
          '</div>'
        );
      });
      setTimeout(function(){
        window.location.href = 'login.php';
      }, 4000);
    </script>";

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
$conn->close();

$_SESSION["user"] = $email;

?>

</body>
</html>