<!DOCTYPE html>
<html lang="en">

<head>
  <title>w03Lab</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootswatch@5/dist/flatly/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body style="padding-bottom:100px " ;>
  <div style="width: 100%; max-width: 1200px; margin: auto;">
    <?php
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    if (isset($_SESSION['user_role'])) {
      $dashboardPath = ($_SESSION['user_role'] == 'admin') ? '/dashboard/admin_dashboard.php' : '/dashboard/user_dashboard.php';
    } else {
      $dashboardPath = '/';
    }
    ?>
    <a href="<?php echo $dashboardPath; ?>">
      <img src="/banner.png" alt="Banner" width=100% height="200" />
    </a>
  </div>

  </div>
  </br>

  <div class="container w-75">