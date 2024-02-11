<?php
session_start();
if(!isset($_SESSION['user'])){
    echo "<script>alert('Unortharzide access! Please login');window.location.href = 'login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home Page</title>
<style>
  body {
    font-family: Arial, sans-serif;
  }
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
  }
  .header .logout {
    cursor: pointer;
    text-decoration: underline;
  }
  .main-content {
    text-align: center;
    margin: 20px 0;
  }
  .main-content h1 {
    margin-bottom: 20px;
  }
  .show-links {
    display: flex;
    justify-content: space-between;
  }
  .show-links a {
    background-color: black;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
  }
</style>
</head>
<body>

<div class="header">
  <span>Hello ! | <?php echo $_SESSION['user'];?></span>
  <a href="logout.php" class="logout">Logout here</a>
</div>

<div class="main-content">
  <h1>Welcome to Vanni Vogue Short Film Festival</h1>
  <div class="show-links">
    <a href="show1.php" class="show-link">Book Show 1</a>
    <a href="show2.php" class="show-link">Book Show 2</a>
  </div>
</div>

</body>
</html>
