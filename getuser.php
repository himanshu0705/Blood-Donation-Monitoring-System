<!DOCTYPE html>
<html>
 
<head>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
 
        #customers td,
        #customers th {
            border: 1px solid green;
            padding: 25px;
        }
 
        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }
 
        #customers tr:hover {
            background-color: green;
        }
 
        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #504caf;
            color: white;
        }
    </style>
</head>
 
<body>
 
    <?php
 
require "db_connection.php";
 
$q = $_GET["q"];
 
$sql = "SELECT * FROM donors JOIN location ON donors.id=location.loc_id WHERE bloodgroup = '" . $q . "'";
 
$result = mysqli_query($con, $sql);
 
echo "<h2>Donors List</h2>";
echo "<table id='customers'>
<tr>
<th>Name</th>
<th>Blood Group</th>
<th>Email Id</th>
<th>Mobile Number</th>
<th>City</th>
</tr>";
 
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['fullname'] . "</td>";
    echo "<td>" . $row['bloodgroup'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['mobile'] . "</td>";
    echo "<td>" . $row['town'] . "</td>";
    echo "</tr>";
}
 
echo "</table>";
 
mysqli_close($con);
 
?>
 
</body>
</html>