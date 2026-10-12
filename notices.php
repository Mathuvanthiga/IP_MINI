<?php
include "db.php";

$search = isset($_GET['search']) ? $_GET['search'] : "";
$department = isset($_GET['department']) ? $_GET['department'] : "";
$urgency = isset($_GET['urgency']) ? $_GET['urgency'] : "";

$sql = "SELECT * FROM notices WHERE 1=1";

if ($search != "") {
    $search_safe = $conn->real_escape_string($search);
    $sql .= " AND (title LIKE '%$search_safe%' OR details LIKE '%$search_safe%')";
}
if ($department != "") {
    $department_safe = $conn->real_escape_string($department);
    $sql .= " AND department = '$department_safe'";
}
if ($urgency != "") {
    $urgency_safe = $conn->real_escape_string($urgency);
    $sql .= " AND urgency = '$urgency_safe'";
}
$sql .= " ORDER BY notice_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Notices | Digital Notice Board</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="navbar">
    <div class="logo">📢 Digital Notice Board</div>
    <nav><a href="index.php">Home</a><a href="notices.php">Notices</a><a href="login.php">Admin Login</a></nav>
</header>

<section class="notice-page">
    <div class="page-heading">
        <span class="badge">NOTICE CENTER</span>
        <h1>College Notices</h1>
        <p>Find announcements, events and important updates.</p>
    </div>

    <form method="GET" class="filter-box">
        <input type="text" name="search" placeholder="Search notices..." value="<?php echo htmlspecialchars($search); ?>">
        <select name="department">
            <option value="">All Departments</option>
            <?php foreach (["CSE","ECE","MECH","CIVIL","ALL"] as $d): ?>
                <option value="<?php echo $d; ?>" <?php if($department==$d) echo "selected"; ?>><?php echo $d == "ALL" ? "ALL Departments" : $d; ?></option>
            <?php endforeach; ?>
        </select>
        <select name="urgency">
            <option value="">All Urgency</option>
            <?php foreach (["High","Medium","Low"] as $u): ?>
                <option value="<?php echo $u; ?>" <?php if($urgency==$u) echo "selected"; ?>><?php echo $u; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Search</button>
        <a href="notices.php" class="clear-btn">Clear</a>
    </form>

    <div class="notice-grid">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="notice-card">
            <div class="notice-top">
                <span class="department"><?php echo htmlspecialchars($row['department']); ?></span>
                <span class="urgency <?php echo strtolower($row['urgency']); ?>"><?php echo htmlspecialchars($row['urgency']); ?></span>
            </div>
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
            <div class="notice-date">📅 <?php echo date("d M Y", strtotime($row['notice_date'])); ?></div>
            <p><?php echo nl2br(htmlspecialchars($row['details'])); ?></p>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-results"><h2>📭 No Notices Found</h2><p>Try changing your search or filters.</p></div>
    <?php endif; ?>
    </div>
</section>
<footer><p>© 2026 Digital Notice Board System</p></footer>
</body>
</html>