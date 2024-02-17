<?php
ob_start();
session_start();

require "db_connection.php";

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['fullname']) && isset($_POST['dob']) && isset($_POST['gender']) && isset($_POST['bloodgroup']) && isset($_POST['mobile']) && isset($_POST['email']) && isset($_POST['state']) && isset($_POST['town'])) {
    $user = $_POST['username'];
    $pw = md5($_POST['password']);
    $f_name = $_POST['fullname'];
    $birthday = $_POST['dob'];
    $sex = $_POST['gender'];
    $blood = $_POST['bloodgroup'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $town = $_POST['town'];
    $state = $_POST['state'];
    $checkUserQuery = "SELECT r.rid,d.bloodgroup FROM registration r, donors d WHERE username='$user' AND password='$pw'";
    $checkUserResult = mysqli_query($con, $checkUserQuery);

    if (mysqli_num_rows($checkUserResult) > 0) {
        $row = mysqli_fetch_assoc($checkUserResult);
        $sess = $row['rid'];
        $previousBloodType = $row['bloodgroup'];
        $updateDonorsQuery = "UPDATE donors SET fullname='$f_name', dob='$birthday', sex='$sex', bloodgroup='$blood', mobile='$mobile', email='$email' WHERE id='$sess'";
        $updateLocationQuery = "UPDATE location SET town='$town', state='$state' WHERE loc_id='$sess'";
        
        mysqli_query($con, $updateDonorsQuery);
        mysqli_query($con, $updateLocationQuery);
        
        $decrementBloodQuery = "UPDATE blood SET count = count - 1 WHERE type = '$previousBloodType'";
        mysqli_query($con, $decrementBloodQuery);
        
        $incrementBloodQuery = "INSERT INTO blood (type, count) VALUES ('$blood', 1) ON DUPLICATE KEY UPDATE count = count + 1";
        mysqli_query($con, $incrementBloodQuery);
        echo '<script language="javascript">';
        echo 'alert("Updated Successfully")';
        echo '</script>';
    } else {
        $checkUsernameQuery = "SELECT username FROM registration WHERE username='$user'";
        $checkUsernameResult = mysqli_query($con, $checkUsernameQuery);

        if (mysqli_num_rows($checkUsernameResult) > 0) {
        echo '<script language="javascript">';
        echo 'alert("Username already exists. Please choose a different username.")';
        echo '</script>';
    } else {
        $insertDonorsQuery = "INSERT INTO donors (fullname, dob, sex, bloodgroup, mobile, email) VALUES ('$f_name', '$birthday', '$sex', '$blood', '$mobile', '$email')";
        $insertRegistrationQuery = "INSERT INTO registration (username, password) VALUES ('$user', '$pw')";
        $insertLocationQuery = "INSERT INTO location (town, state) VALUES ('$town', '$state')";
        
        mysqli_query($con, $insertDonorsQuery);
        mysqli_query($con, $insertRegistrationQuery);
        mysqli_query($con, $insertLocationQuery);
        
        $incrementBloodQuery = "INSERT INTO blood (type, count) VALUES ('$blood', 1) ON DUPLICATE KEY UPDATE count = count + 1";
        mysqli_query($con, $incrementBloodQuery);
        echo '<script language="javascript">';
        echo 'alert("Registration successful")';
        echo '</script>';
    }
    }
} else {
    echo '<script language="javascript">';
    echo 'alert("Please fill in all required fields")';
    echo '</script>';
}
?>

<!DOCTYPE html>
<html>
 
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="script.js"></script>
</head>
 
<body>
    <div class="col-12" style="height: 180px">
        <div id="nav" class="col-12">
            <ul>
                <li><a href="find_blood.php">Find Donor</a></li>
                <li><a class="active" href="register.php">Be A Donor</a></li>
                <?php
                if (isset($_SESSION['sess_user_id']) && !empty($_SESSION['sess_user_id'])) {
                    echo '<li style="background-color: rgba(255,0,0,0.5);"><a href="logout.php">Logout</a></ul>';
                }
                ?>
            </ul>
        </div>
        <span class="info2" style="left: 40%">REGISTER</span>
    </div>
    <div class="col-12" style="overflow: auto; padding: 0 20% 0 20%;">
        <div class="col-12" style="text-align: left; padding: 5%; background-color: #504caf;">
            <form action="register.php" method="post">
                Username(required)<span style="color: red;">*</span><br>
                <input class="in" type="text" name="username" placeholder="You can use Your email here for unique name"
                    required style="color: black;"><br><br>
                Password(required)<span style="color: red;">*</span><br>
                <input class="in" type="password" name="password" placeholder="Password" required
                    style="color: black;"><br><br>
                Fullname(required)<span style="color: red;">*</span><br>
                <input class="in" type="text" name="fullname" placeholder="Enter Fullname" required
                    style="color: black;"><br><br>
                Date Of Birth(required)<span style="color: red;">*</span><br>
                <input class="in" type="date" name="dob" placeholder="dd/mm/yyyy" required><br><br>
                Gender(required)<span style="color: red;">*</span><br>
                <input type="radio" name="gender" value="male" checked>Male
                <input type="radio" name="gender" value="female">Female
                <input type="radio" name="gender" value="other">Other<br><br>
                Blood Group(required)<span style="color: red;">*</span><br>
                <select name="bloodgroup" required>
                    <option value="">Enter Blood Group</option>
                    <option value="A pos">A+</option>
                    <option value="A neg">A-</option>
                    <option value="B pos">B+</option>
                    <option value="B neg">B-</option>
                    <option value="O pos">O+</option>
                    <option value="O neg">O-</option>
                    <option value="AB pos">AB+</option>
                    <option value="AB neg">AB-</option>
                </select><br><br>
                Mobile(required)<span style="color: red;">*</span><br>
                <input class="in" type="text" name="mobile" placeholder="Enter 10 digit Mobile No." pattern="[0-9]{10}" required
                    style="color: black;"><br><br>
                Email(required)<span style="color: red;">*</span><br>
                <input class="in" type="email" name="email" placeholder="Enter Your Email" required
                    style="color: black;"><br><br>
                Town<br>
                <input class="in" type="text" name="town" placeholder="Enter Town" style="color: black;"><br><br>
                State(required)<span style="color: red;">*</span><br>
                <input class="in" type="text" name="state" placeholder="Enter State" required
                    style="color: black;"><br><br>
                <input class="qw" style="font-size: 16px; color: white;" type="submit" value="SEND">
            </form>
        </div>
    </div>
    </div>
</body>
 
</html>