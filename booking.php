<?php
include 'koneksi.php'; 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$message = "";
$name = $email = $phone = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $gender = htmlspecialchars($_POST['gender']);
    $package = htmlspecialchars($_POST['package']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $participants = htmlspecialchars($_POST['participants']);

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
        header("Location: view.php"); 
        exit(); 
    } else {
        $message = "Error: " . $stmt->error;
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Form</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
    <nav>
        <div class="layar-dalam">
            <div class="logo">
                <a href="index.html"><img src="asset/logo-white.png" class="putih" /></a>
                <a href="index.html"><img src="asset/logo-black.png" class="hitam" /></a>
            </div>
            <div class="menu">
                <a href="#" class="tombol-menu">
                    <span class="garis"></span>
                    <span class="garis"></span>
                    <span class="garis"></span>
                </a>
            </div>
        </div>
    </nav>
    <div class="layar-penuh">
        <header id="home"></header>
        <main>
            <section id="booking-form">
                <div class="layar-dalam">
                    <h3>Booking Form</h3>
                    <form action="booking_form.php" method="post">
                        <label for="name"><i class="fas fa-user"></i> Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required /><br />

                        <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required 
                            placeholder="example@domain.com" 
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" 
                            title="Please enter a valid email address, e.g., example@domain.com" /><br />

                        <label for="phone"><i class="fas fa-phone"></i> Phone:</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required /><br />

                        <label for="gender"><i class="fas fa-venus-mars"></i> Gender:</label>
                        <input type="radio" id="male" name="gender" value="male" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'male' ? 'checked' : ''; ?> required />
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'female' ? 'checked' : ''; ?> required />
                        <label for="female">Female</label><br />

                        <label for="package"><i class="fas fa-briefcase"></i> Select Package:</label>
                        <select id="package" name="package">
                            <option value="adventure" <?php echo isset($_POST['package']) && $_POST['package'] == 'adventure' ? 'selected' : ''; ?>>Paket Petualangan Bali</option>
                            <option value="beach" <?php echo isset($_POST['package']) && $_POST['package'] == 'beach' ? 'selected' : ''; ?>>Paket Santai di Pantai</option>
                            <option value="culture" <?php echo isset($_POST['package']) && $_POST['package'] == 'culture' ? 'selected' : ''; ?>>Paket Budaya Bali</option>
                            <option value="family" <?php echo isset($_POST['package']) && $_POST['package'] == 'family' ? 'selected' : ''; ?>>Paket Keluarga Seru</option>
                            <option value="sea" <?php echo isset($_POST['package']) && $_POST['package'] == 'sea' ? 'selected' : ''; ?>>Paket Petualangan Laut</option>
                            <option value="birthday" <?php echo isset($_POST['package']) && $_POST['package'] == 'birthday' ? 'selected' : ''; ?>>Paket Perayaan Ulang Tahun</option>
                        </select><br />

                        <label for="start-date"><i class="fas fa-calendar-alt"></i> Start Date:</label>
                        <input type="date" id="start-date" name="start_date" value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>" required /><br />

                        <label for="end-date"><i class="fas fa-calendar-alt"></i> End Date:</label>
                        <input type="date" id="end-date" name="end_date" value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''; ?>" required /><br />

                        <label for="participants"><i class="fas fa-users"></i> Number of Participants:</label>
                        <input type="number" id="participants" name="participants" value="<?php echo isset($_POST['participants']) ? htmlspecialchars($_POST['participants']) : ''; ?>" required /><br />

                        <input type="submit" value="Submit" />
                    </form>

                    <?php if ($message): ?>
                        <p><?php echo $message; ?></p>
                    <?php endif; ?>
                </div>
            </section>
        </main>
        <footer id="contact">
            <div class="layar-dalam">
                <div>
                    <h5>Info</h5>
                    Bali
                </div>
                <div>
                    <h5>Contact</h5>
                    @travel instagram
                </div>
                <div>
                    <h5>Help</h5>
                    911
                </div>
                <div>
                    <h5>Sitemap</h5>
                    Bali
                </div>
            </div>
            <div class="layar-dalam">
                <div class="copyright">&copy; 2024 Travelling Indonesia</div>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="javascript.js"></script>
</body>
</html>
