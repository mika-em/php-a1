<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
  header('Location: /errors/error.php?type=user_only');
  exit;
}

?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/inc_header.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/inc_db.php"); ?>


<?php


$dataPoints = [];

$year = isset($_GET['year']) ? (int)$_GET['year'] : 2024;

$sql = "SELECT buckets.category as category, SUM(transactions.debit + transactions.credit) as total";
$sql .= " FROM transactions INNER JOIN buckets ON transactions.bucket_id = buckets.id";
if ($year) {
  $sql .= " WHERE strftime('%Y', transactions.date) = '$year'";
}
$sql .= " GROUP BY buckets.category";

$res = $db->query($sql);



?>
<div class="w-50 mx-auto">
  <form method="GET" action="">
    <div class="form-group">
      <label for="year">Year:</label>
      <input type="text" value="<?php echo $year ? $year : date('Y'); ?>" id="year" name="year" class="form-control" placeholder="Enter year">
    </div>
    <button type="submit" class="btn btn-primary">Filter</button>
  </form>
  <?php
  $firstRow = $res->fetchArray();
  if ($firstRow) {
    $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y'); ?>
    <h2 class="mt-5 text-center">Yearly Expense Report for <?php echo $year; ?></h2>
    <table class="table table-bordered mt-5 ">
      <thead>
        <tr>
          <th>Category</th>
          <th>Total Amount</th>
        </tr>
      </thead>
      <tbody>
        <?php

        include_once($_SERVER['DOCUMENT_ROOT'] . "/tables/report.php");

        if ($firstRow) {
          processRow($firstRow, $dataPoints);
          while ($row = $res->fetchArray()) {
            processRow($row, $dataPoints);
          }
        }
        echo '</tbody>';
        echo '</table>';
        $db->close();
        ?>
        <script>
          window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
              animationEnabled: true,
              title: {
                text: "Transactions by Category"
              },
              data: [{
                type: "pie",
                yValueFormatString: "$#,##0.00\"\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
              }]
            });
            chart.render();
          }
        </script>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

      <?php
    } else {
      echo '<div class="alert alert-info mt-5">No transactions found for the selected year.</div>';
    }
      ?>