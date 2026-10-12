<?php
session_start();
if (!isset($_SESSION["admin"])) { header("Location: login.php"); exit(); }
include "db.php";
$result = $conn->query("SELECT * FROM notices ORDER BY id DESC");
$total = $result ? $result->num_rows : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="admin-navbar">
    <div class="logo">📢 Admin Dashboard</div>
    <div>Welcome, <b><?php echo htmlspecialchars($_SESSION["admin"]); ?></b><a href="logout.php" class="logout-btn">Logout</a></div>
</header>

<main class="dashboard">
    <div class="dashboard-header">
        <div><span class="badge">ADMIN PANEL</span><h1>Notice Management</h1><p>Manage all college announcements.</p></div>
        <a href="add_notice.php" class="btn primary">+ Add New Notice</a>
    </div>

    <div class="stat-card"><div><h3>Total Notices</h3><strong><?php echo $total; ?></strong></div><div class="stat-icon">📢</div></div>

    <div class="table-container">
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Department</th><th>Date</th><th>Urgency</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><strong><?php echo htmlspecialchars($row["title"]); ?></strong></td>
            <td><?php echo htmlspecialchars($row["department"]); ?></td>
            <td><?php echo date("d M Y", strtotime($row["notice_date"])); ?></td>
            <td><span class="urgency <?php echo strtolower($row["urgency"]); ?>"><?php echo htmlspecialchars($row["urgency"]); ?></span></td>
            <td>
                <a href="edit_notice.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                <a href="delete_notice.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this notice?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php else: ?><tr><td colspan="6">No notices available.</td></tr><?php endif; ?>
        </tbody>
    </table>
    </div>
</main>
</body>
</html>