<?php
include 'koneksi.php'; // Include your database connection
session_start(); // Start the session

// Initialize variables
$message = "";
$display_data = false;
$name = $email = $phone = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $gender = htmlspecialchars($_POST['gender']);
    $package = htmlspecialchars($_POST['package']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $participants = htmlspecialchars($_POST['participants']);

    // Use prepared statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, gender, package, start_date, end_date, participants)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $phone, $gender, $package, $start_date, $end_date, $participants);

    if ($stmt->execute()) {
        $_SESSION['booking_data'] = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'gender' => $gender,
            'package' => $package,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'participants' => $participants
        ];
        $stmt->close();
        header("Location: view.php"); // Redirect to view page
        exit(); // Ensure no further code is executed
    } else {
        $message = "Error: " . $stmt->error;
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head section remains the same -->
</head>
<body>
    <!-- Your body section remains the same -->
</body>
</html>
