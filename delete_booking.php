<?php
include 'koneksi.php';
session_start(); 


if (!isset($_POST['id'])) {
    header("Location: view.php"); 
    exit();
}

$booking_id = $_POST['id'];


$stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    header("Location: view.php"); 
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
