<?php
// Database connection details
$servername = "localhost"; // Your server name
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP (leave blank)
$dbname = "car_details"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Car Details
$registration_number = $_POST['registration_number'];
$make = $_POST['make'];
$model = $_POST['model'];
$colour = $_POST['colour'];
$year_of_manufacture = $_POST['year_of_manufacture'];
$mileage = $_POST['mileage'];
$mileage_unit = $_POST['mileage_unit'];
$accident_history = $_POST['accident_history'];
$asking_price = $_POST['asking_price'];
$location = $_POST['location'];

// Insert Car Details
$stmt1 = $conn->prepare("INSERT INTO car_details (registration_number, make, model, colour, year_of_manufacture, mileage, mileage_unit, accident_history, asking_price, location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt1->bind_param("ssssisssss", $registration_number, $make, $model, $colour, $year_of_manufacture, $mileage, $mileage_unit, $accident_history, $asking_price, $location);
$stmt1->execute();
$stmt1->close();

// Contact Details
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$id_number = $_POST['id_number'];
$preferred_contact = $_POST['preferred_contact'];

// Handle File Uploads
$id_photo_front = 'uploads/front_' . basename($_FILES['id_photo_front']['name']);
$id_photo_back = 'uploads/back_' . basename($_FILES['id_photo_back']['name']);

// Move uploaded files to the uploads directory
if (move_uploaded_file($_FILES['id_photo_front']['tmp_name'], $id_photo_front) && move_uploaded_file($_FILES['id_photo_back']['tmp_name'], $id_photo_back)) {
    // Insert Contact Details
    $stmt2 = $conn->prepare("INSERT INTO contact_details (first_name, last_name, email, phone, id_number, preferred_contact, id_photo_front, id_photo_back) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssssssss", $first_name, $last_name, $email, $phone, $id_number, $preferred_contact, $id_photo_front, $id_photo_back);
    $stmt2->execute();
    $stmt2->close();

    echo "New record created successfully!";
} else {
    echo "Error uploading files.";
}

// Close the database connection
$conn->close();
?>