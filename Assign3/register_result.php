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
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Handle File Upload
    $target_file = "";
    if(isset($_FILES['photo-upload']) && $_FILES['photo-upload']['error'] == 0){
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . time() . "_" . basename($_FILES["photo-upload"]["name"]);
        move_uploaded_file($_FILES["photo-upload"]["tmp_name"], $target_file);
    }

    // 3. SQL INSERT Query
    $sql = "INSERT INTO users (email, first_name, last_name, phone, password, photo_path) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $email, $first_name, $last_name, $phone, $password, $target_file);
    $stmt->execute();

    echo "<title>DBLab Assignment 3 Register Results Page</title>";
    echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css'>";
    echo "<link rel='stylesheet' href='./style.css'>";
    echo "
    <nav class='navbar navbar-dark bg-dark'>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#mainMenu' aria-controls='mainMenu' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>

        <div class='collapse navbar-collapse' id='mainMenu'>
            <ul class='navbar-nav mr-auto mt-2'>
                <li class='nav-item'>
                    <a class='nav-link' href='index.php'>Home</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='login.php'>Login</a>
                </li>
                <li class='nav-item active'>
                    <a class='nav-link' href='register.html'>Register <span class='sr-only'>(current)</span></a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link text-danger' href='logout.php'>Logout</a>
                </li>
            </ul>
        </div>
    </nav>";
    echo "<div class='custom-container'>";

    // Execute the insertion ONCE
    if (TRUE) {
        echo "<h1 class='text-success'>Registration Successful</h1>";
        echo "<p class='lead'>Welcome to the new power generation big dawg.</p>";
        
        // 1. Prepare the query
        $sql = "SELECT id, photo_path, email, first_name, last_name, password FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);

        // 2. Bind and Execute
        // Note: If you are using password_hash, you'd only search by email then verify in PHP
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-hover mt-3'>";
            echo "<thead class='thead-dark'>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Password</th>
                    </tr>
                </thead><tbody>";
            
            while($row = $result->fetch_assoc()) {
                $img_src = !empty($row['photo_path']) ? $row['photo_path'] : 'https://via.placeholder.com/50';
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td><img src='$img_src' height='40' style='border-radius:50%'></td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "<p>Account not found. Don't know how you did that</p>";
        }
    } else {
        echo "<h1 class='text-danger'>Error</h1>" . $stmt->error;
    }

    echo "<hr><a href='index.php' class='btn btn-primary'>Dashboard</a>";
    echo "</div>";
    echo "
        <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js'></script>
        <script src='script.js'></script>";

    $stmt->close();
}
$conn->close();
?>