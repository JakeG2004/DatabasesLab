<?php
// 1. Database Configuration
$host = "localhost";
$user = "root"; 
$pass = ""; 
$dbname = "lab_project"; // Reminder: Better to use a custom DB name like 'company_db' later

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<title>DBLab Week 9 View Page</title>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css'>";
echo "<link rel='stylesheet' href='./styles.css'>";
echo "<div class='custom-container'>";

echo "<h1 class='text-success'>Employee Database</h1>";
echo "<p class='lead'>Total directory below:</p>";

// 4. SQL SELECT ALL Query
$result = $conn->query("SELECT * FROM employees ORDER BY id DESC");

if ($result->num_rows > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover mt-3'>";
    echo "<thead class='thead-dark'>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Location</th>
                <th>Email</th>
                <th>Languages</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
                <th>Phone Number</th>
                <th>Additional Info</th>
            </tr>
            </thead><tbody>";
    
    while($row = $result->fetch_assoc()) {
        $img_src = !empty($row['photo_path']) ? $row['photo_path'] : 'https://via.placeholder.com/50';
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td><img src='$img_src' height='40' style='border-radius:50%'></td>";
        echo "<td>" . $row['title'] . " " . $row['first_name'] . " " . $row['last_name'] . "</td>";
        echo "<td>" . $row['city'] . ", " . $row['state'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['languages'] . "</td>";
        echo "<td>" . $row['address_1'] . "</td>";
        echo "<td>" . $row['address_2'] . "</td>";
        echo "<td>" . $row['city'] . "</td>";
        echo "<td>" . $row['state'] . "</td>";
        echo "<td>" . $row['zip_code'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['additional_info'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table></div>";
} else {
    echo "<p>No records found.</p>";
}

echo "<hr><a href='index.html' class='btn btn-primary'>Return To Add Page</a>";
echo "</div>";

$conn->close();
?>