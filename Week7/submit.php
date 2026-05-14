<?php

echo "<link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css\">
<link rel=\"stylesheet\" href=\"./styles.css\">";

echo "<div class=custom-container>";

echo "<h1>Form Submission</h1>";

echo "<hr>";

echo "<h2>Basic Info</h2>";
echo "Title: " . ($_POST['title'] ?? '') . "<br>";
echo "First Name: " . ($_POST['first_name'] ?? '') . "<br>";
echo "Last Name: " . ($_POST['last_name'] ?? '') . "<br>";

echo "<hr>";

echo "<h2>Addresses</h2>";
echo "Address 1: " . ($_POST['address_1'] ?? '') . "<br>";
echo "Address 2: " . ($_POST['address_2'] ?? '') . "<br>";
echo "City: " . ($_POST['city'] ?? '') . "<br>";
echo "State: " . ($_POST['state'] ?? '') . "<br>";
echo "Zip: " . ($_POST['zip-code'] ?? '') . "<br>";

echo "<hr>";

echo "<h2>Contact</h2>";
echo "Email: " . ($_POST['email'] ?? '') . "<br>";
echo "Phone: " . ($_POST['phone-number'] ?? '') . "<br>";

echo "<hr>";

echo "<h2>Languages</h2>";

if(isset($_POST['english'])) echo "English<br>";
if(isset($_POST['spanish'])) echo "Spanish<br>";
if(isset($_POST['french'])) echo "French<br>";

echo "<hr>";

echo "<h2>Additional Info</h2>";
echo ($_POST['additional-info'] ?? '') . "<br>";

echo "<hr>";

echo "<h2>Uploaded File</h2>";

if(isset($_FILES['photo-upload']) && $_FILES['photo-upload']['error'] == 0){
    echo "File name: " . $_FILES['photo-upload']['name'] . "<br>";
    echo "File size: " . $_FILES['photo-upload']['size'] . " bytes<br>";
}
else{
    echo "No file uploaded.";
}

echo "</div>";

?>