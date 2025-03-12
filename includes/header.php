
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Bill System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Electricity Bill System</h1>
            <nav>
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <a href="../admin/admin_dashboard.php">Dashboard</a> |
                    <a href="../logout.php">Logout</a>
                <?php elseif (isset($_SESSION['cust_id'])): ?>
                    <a href="../user/user_dashboard.php">Dashboard</a> |
                    <a href="../logout.php">Logout</a>
                <?php else: ?>
                    <a href="../index.php">Login</a>
                <?php endif; ?>
            </nav>
        </header>