<?php
session_start();
if (!isset($_SESSION["admin"])) { header("Location: login.php"); exit(); }
include "db.php";

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$result = $conn->query("SELECT * FROM notices WHERE id=$id");
if (!$result || $result->num_rows != 1) die("Notice not found.");
$notice = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $department = $conn->real_escape_string($_POST["department"]);
    $notice_date = $conn->real_escape_string($_POST["notice_date"]);
    $urgency = $conn->real_escape_string($_POST["urgency"]);
    $details = $conn->real_escape_string($_POST["details"]);

    $sql = "UPDATE notices SET title='$title', department='$department',
            notice_date='$notice_date', urgency='$urgency', details='$details'
            WHERE id=$id";
    if ($conn->query($sql)) { header("Location: dashboard.php"); exit(); }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Notice</title><link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="admin-navbar"><div class="logo">📢 Edit Notice</div><a href="dashboard.php">← Dashboard</a></header>
<div class="form-container">
<div class="form-header"><span class="badge">UPDATE NOTICE</span><h1>Edit Notice</h1><p>Update the selected announcement.</p></div>
<form method="POST">
<label>Notice Title</label><input type="text" name="title" value="<?php echo htmlspecialchars($notice['title']); ?>" required>
<label>Department</label>
<select name="department">
<?php foreach (["CSE","ECE","MECH","CIVIL","ALL"] as $d): ?>
<option value="<?php echo $d; ?>" <?php if($notice['department']==$d) echo "selected"; ?>><?php echo $d; ?></option>
<?php endforeach; ?>
</select>
<label>Notice Date</label><input type="date" name="notice_date" value="<?php echo $notice['notice_date']; ?>" required>
<label>Urgency</label>
<select name="urgency">
<?php foreach (["High","Medium","Low"] as $u): ?>
<option value="<?php echo $u; ?>" <?php if($notice['urgency']==$u) echo "selected"; ?>><?php echo $u; ?></option>
<?php endforeach; ?>
</select>
<label>Notice Details</label><textarea name="details" rows="7" required><?php echo htmlspecialchars($notice['details']); ?></textarea>
<div class="form-buttons"><a href="dashboard.php" class="clear-btn">Cancel</a><button type="submit" class="login-btn">Update Notice</button></div>
</form>
</div>
</body>
</html>