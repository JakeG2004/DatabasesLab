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

// 2. Process Form Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $address1 = $_POST['address_1'] ?? '';
    $address2 = $_POST['address_2'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $zip = $_POST['zip-code'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone-number'] ?? '';
    $info = $_POST['additional-info'] ?? '';
    
    // Process Languages
    $langs = [];
    if(isset($_POST['english'])) $langs[] = "English";
    if(isset($_POST['spanish'])) $langs[] = "Spanish";
    if(isset($_POST['french'])) $langs[] = "French";
    $languages_str = implode(", ", $langs);

    // Handle File Upload
    $target_file = "";
    if(isset($_FILES['photo-upload']) && $_FILES['photo-upload']['error'] == 0){
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . time() . "_" . basename($_FILES["photo-upload"]["name"]);
        move_uploaded_file($_FILES["photo-upload"]["tmp_name"], $target_file);
    }

    // 3. SQL INSERT Query
    $sql = "INSERT INTO employees (title, first_name, last_name, address_1, address_2, city, state, zip_code, email, phone, languages, additional_info, photo_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $title, $first_name, $last_name, $address1, $address2, $city, $state, $zip, $email, $phone, $languages_str, $info, $target_file);

    echo "<title>DBLab Week 9 Submit Page</title>";
    echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css'>";
    echo "<link rel='stylesheet' href='./styles.css'>";
    echo "<div class='custom-container'>";

    // Execute the insertion ONCE
    if ($stmt->execute()) {
        echo "<h1 class='text-success'>Registration Successful!</h1>";
        echo "<p class='lead'>New record added. Total directory updated below:</p>";
        
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
    } else {
        echo "<h1 class='text-danger'>Error</h1>" . $stmt->error;
    }

    echo "<hr><a href='index.html' class='btn btn-primary'>Add Another Employee</a>";
    echo "</div>";

    $stmt->close();
}
$conn->close();
?>