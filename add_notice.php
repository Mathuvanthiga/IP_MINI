<?php
session_start();
if (!isset($_SESSION["admin"])) { header("Location: login.php"); exit(); }
include "db.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $department = $conn->real_escape_string($_POST["department"]);
    $notice_date = $conn->real_escape_string($_POST["notice_date"]);
    $urgency = $conn->real_escape_string($_POST["urgency"]);
    $details = $conn->real_escape_string($_POST["details"]);

    $sql = "INSERT INTO notices (title, department, notice_date, urgency, details)
            VALUES ('$title','$department','$notice_date','$urgency','$details')";
    if ($conn->query($sql)) { header("Location: dashboard.php"); exit(); }
    $message = "Error adding notice: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Notice</title><link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="admin-navbar"><div class="logo">📢 Digital Notice Board</div><a href="dashboard.php">← Dashboard</a></header>
<div class="form-container">
<div class="form-header"><span class="badge">CREATE NOTICE</span><h1>Add New Notice</h1><p>Publish a new announcement to the notice board.</p></div>
<?php if ($message): ?><div class="error-message"><?php echo $message; ?></div><?php endif; ?>
<form method="POST" onsubmit="return validateNoticeForm();">
<label>Notice Title</label><input type="text" name="title" id="title" placeholder="Enter notice title" required>
<label>Department</label>
<select name="department" required><option value="">Select Department</option><option>CSE</option><option>ECE</option><option>MECH</option><option>CIVIL</option><option>ALL</option></select>
<label>Notice Date</label><input type="date" name="notice_date" required>
<label>Urgency</label>
<select name="urgency" required><option value="">Select Urgency</option><option>High</option><option>Medium</option><option>Low</option></select>
<label>Notice Details</label><textarea name="details" rows="7" placeholder="Enter complete notice details..." required></textarea>
<div class="form-buttons"><a href="dashboard.php" class="clear-btn">Cancel</a><button type="submit" class="login-btn">Publish Notice</button></div>
</form>
</div>
<script src="js/script.js"></script>
</body>
</html>