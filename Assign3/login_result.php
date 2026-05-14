<?php
session_start();

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
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 3. SQL INSERT Query
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();
    $result = $stmt->get_result();

    echo "<title>DBLab Week 9 Login Result Page</title>";
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
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // This is the "Persistence" magic:
        $_SESSION['username'] = $row['email']; 
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['photo_path'] = $row['photo_path'];
        echo "<h1 class='text-success'>Login Successful!</h1>";
        echo "<p class='lead'>I knew you'd come crawling back...</p>";

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
        
                $result->data_seek(0);
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
        echo "<p>Account not found big dawg. dont know how you did that one.</p>";
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