<?php
include 'koneksi.php'; 
session_start(); 

// Fetch bookings
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

if ($conn->error) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Bookings</title>
    <link rel="stylesheet" href="t.css" />
    <style>
        /* Add basic styling for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
        button {
            background-color: #f44336; /* Red background */
            color: white; /* White text */
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e60000;
        }
        .action-buttons a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <nav>
        <!-- Navigation content -->
    </nav>
    <main>
        <section id="booking-list">
            <h3>All Bookings</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Package</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Participants</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['package']); ?></td>
                    <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['participants']); ?></td>
                    <td class="action-buttons">
                        <a href="edit_booking.php?id=<?php echo urlencode($row['id']); ?>">Edit</a>
                        <form action="delete_booking.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>" />
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </section>
    </main>
    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
