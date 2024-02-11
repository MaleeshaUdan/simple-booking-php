<?php
session_start();
if(!isset($_SESSION['user'])){
    echo "<script>alert('Unortharzide access! Please login');window.location.href = 'login.php';</script>";
}
?>
<?php
require 'dbconfig.php'; 
$bookedSeats = array();
$query = "SELECT bookingNo FROM bookings where showNo =1 ";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $bookedSeats[] = $row['bookingNo'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seat Booking 01</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
  }
  .header {
    padding: 10px;
    text-align: center;
  }
  .legend {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
  }
  .legend-box {
    width: 20px;
    height: 20px;
    margin-right: 5px;
    display: inline-block;
  }
  .reserved {
    background-color: orange;

  }
  .unreserved {
    background-color: green;
    margin-left:10px;
  }
  .table-container {
    margin: 20px auto;
    width: 80%;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  td {
    border: 1px solid #ddd;
    text-align: center;
    padding: 15px;
  }
  .booked {
    background-color: orange;
  }
  .not-booked {
    background-color: green;
  }
  .seat-number {
    margin: 10px 0;
  }
  .book-button {
    padding: 10px 20px;
    background-color: black;
    color: white;
    border: none;
    cursor: pointer;
  }
</style>
</head>
<body>

<div class="header">
  <p>Hello <?php echo $_SESSION['user'];?></p>
  <h2>Welcome to Short Film Show 1</h2>
</div>

<div class="table-container">
  <table>
    <?php
    for ($row = 1; $row <= 5; $row++) {
        echo '<tr>';
        for ($col = 1; $col <= 8; $col++) {
            $seatNumber = (($row - 1) * 8) + $col;
            $bookedClass = in_array($seatNumber, $bookedSeats) ? 'booked' : 'not-booked';
            echo "<td class='{$bookedClass}'>{$seatNumber}</td>";
        }
        echo '</tr>';
    }
    ?>
  </table>
  <div class="legend">
    <div class="legend-box reserved"></div> Reserved
    <div class="legend-box unreserved"></div> Unreserved
  </div>

  <div class="seat-number">
    <form action="show1.php" method="POST">
        <label for="seatNumber">Seat Number</label>
        <input type="number" id="seatNumber" name="seatNumber">
        <button class="book-button" type="submit">Book</button>
    </form>
  </div>
</div>
</div>
<?php
    if(isset($_POST['seatNumber']) && !empty($_POST['seatNumber'])){
        $canBook="True";
        $prev_show_seat_no;
        $seatNumber = $_POST['seatNumber'];
        $user_id=$_SESSION['uid'];
        
        $sql ="SELECT * From bookings where userId= $user_id AND showNo='2'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            $userData = $result->fetch_assoc();
            $prev_show_seat_no=$userData['bookingNo'];
            $canBook="False";
        }
        else{
            $canBook="True";
        }

        if ($seatNumber>40 || $seatNumber<1) {
            echo "<p>The Seat Number is out of range!</p>"; 
        }
        elseif($canBook=="False"){
            echo "<p>You already booked a seat, the number is " . $prev_show_seat_no . "in the show 2</p>";
        }
        else{
            $sql2 = "INSERT INTO bookings (userId, showNo, bookingNo) VALUES ('$user_id', 1, '$seatNumber')";
            if ($conn->query($sql2) === TRUE) {
                echo "<p>Your seat number is " . $seatNumber . "in the show 1</p>";
            } else {
                echo "Error: " . $conn->error;
            }

        }
    }
?>
</body>
</html>

<?php
$conn->close();
?>
