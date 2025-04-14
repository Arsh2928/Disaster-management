<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?>Disaster Management System</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <i class="fas fa-shield-alt logo-icon"></i>
                <div>
                    <h1>Disaster Preparedness</h1>
                    <p>Stay Aware. Stay Safe.</p>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>/index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/disasters.php"><i class="fas fa-exclamation-triangle"></i> Recent Disasters</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/knowledge.php"><i class="fas fa-book"></i> Knowledge Base</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/contacts.php"><i class="fas fa-phone-alt"></i> Emergency Contacts</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="<?php echo BASE_URL; ?>/report.php"><i class="fas fa-plus-circle"></i> Report Disaster</a></li>
                        <?php if (isAdmin()): ?>
                            <li><a href="<?php echo BASE_URL; ?>/admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo BASE_URL; ?>/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>/login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/register.php"><i class="fas fa-user-plus"></i> Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>
    <div class="mobile-menu">
    </div>
    <main class="container">