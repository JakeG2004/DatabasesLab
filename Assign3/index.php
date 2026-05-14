<?php
include("auth_session.php"); //
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Jake's Lab</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css"> </head>

<body class="p-0"> 
<nav class="navbar navbar-dark bg-dark"> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainMenu">
        <ul class="navbar-nav mr-auto mt-2">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="custom-container"> <h1>Welcome back, <?php echo $_SESSION['first_name']; ?></h1> <small>Your session is active. Looking good, big dawg.</small>
    <hr>

    <div class="row mt-4">
        <div class="col-md-8">
            <p class="font-weight-bold">Profile Details</p>
            <div class="table-responsive"> <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Avatar</th>
                            <th>Detail</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="3" class="text-center">
                                <?php 
                                    // Fallback if photo path is empty or file doesn't exist
                                    $img = !empty($_SESSION['photo_path']) ? $_SESSION['photo_path'] : 'https://via.placeholder.com/100';
                                ?>
                                <img src='<?php echo $img; ?>' height='100' width='100' style='border-radius:50%; border: 3px solid #000; object-fit: cover;'>
                            </td>
                            <td class="font-weight-bold">User Email</td>
                            <td><?php echo $_SESSION['username']; ?></td> </tr>
                        <tr>
                            <td class="font-weight-bold">First Name</td>
                            <td><?php echo $_SESSION['first_name']; ?></td> </tr>
                        <tr>
                            <td class="font-weight-bold">System ID</td>
                            <td>#<?php echo $_SESSION['user_id']; ?></td> </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-4">
            <p class="font-weight-bold">Session Control</p>
            <ul class="main-nav-list"> <li>
                    <a href="logout.php" style="background-color: #000; color: #fff; text-align: center;">
                        PEACE OUT / LOGOUT
                    </a>
                </li>
            </ul>
            <small>Clicking logout will clear your session and return you to the login screen.</small>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>