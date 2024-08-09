<?php
include 'koneksi.php'; 
session_start(); 


if (!isset($_GET['id'])) {
    header("Location: view.php"); 
    exit();
}

$booking_id = $_GET['id'];


$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No booking found with ID $booking_id";
    exit();
}

$booking = $result->fetch_assoc();
$stmt->close();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $gender = htmlspecialchars($_POST['gender']);
    $package = htmlspecialchars($_POST['package']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $participants = htmlspecialchars($_POST['participants']);


    $stmt = $conn->prepare("UPDATE bookings SET name = ?, email = ?, phone = ?, gender = ?, package = ?, start_date = ?, end_date = ?, participants = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $name, $email, $phone, $gender, $package, $start_date, $end_date, $participants, $booking_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Booking updated successfully!";
        header("Location: view.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Booking</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <nav>
       
    </nav>
    <main>
        <section id="edit-booking">
            <h3>Edit Booking</h3>
            <?php if (isset($_SESSION['message'])): ?>
                <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
            <?php endif; ?>
            <form action="edit_booking.php?id=<?php echo urlencode($booking_id); ?>" method="post">
             
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($booking['name']); ?>" required /><br />

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($booking['email']); ?>" required /><br />

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($booking['phone']); ?>" required /><br />

                <label for="gender">Gender:</label>
                <input type="radio" id="male" name="gender" value="male" <?php echo $booking['gender'] == 'male' ? 'checked' : ''; ?> required />
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" <?php echo $booking['gender'] == 'female' ? 'checked' : ''; ?> required />
                <label for="female">Female</label><br />

                <label for="package">Select Package:</label>
                <select id="package" name="package">
                    <option value="adventure" <?php echo $booking['package'] == 'adventure' ? 'selected' : ''; ?>>Paket Petualangan Bali</option>
                    <option value="beach" <?php echo $booking['package'] == 'beach' ? 'selected' : ''; ?>>Paket Santai di Pantai</option>
                    <option value="culture" <?php echo $booking['package'] == 'culture' ? 'selected' : ''; ?>>Paket Budaya Bali</option>
                    <option value="family" <?php echo $booking['package'] == 'family' ? 'selected' : ''; ?>>Paket Keluarga Seru</option>
                    <option value="sea" <?php echo $booking['package'] == 'sea' ? 'selected' : ''; ?>>Paket Petualangan Laut</option>
                    <option value="birthday" <?php echo $booking['package'] == 'birthday' ? 'selected' : ''; ?>>Paket Perayaan Ulang Tahun</option>
                </select><br />

                <label for="start-date">Start Date:</label>
                <input type="date" id="start-date" name="start_date" value="<?php echo htmlspecialchars($booking['start_date']); ?>" required /><br />

                <label for="end-date">End Date:</label>
                <input type="date" id="end-date" name="end_date" value="<?php echo htmlspecialchars($booking['end_date']); ?>" required /><br />

                <label for="participants">Number of Participants:</label>
                <input type="number" id="participants" name="participants" value="<?php echo htmlspecialchars($booking['participants']); ?>" required /><br />

                <input type="submit" value="Update" />
            </form>
        </section>
    </main>
    <footer>
     
    </footer>
</body>
</html>
