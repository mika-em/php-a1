<?php function processRow($row, &$dataPoints)
{
  echo '<tr>';
  echo '<td>' . htmlspecialchars($row['category']) . '</td>';
  echo '<td>$' . htmlspecialchars($row['total']) . '</td>';
  echo '</tr>';
  $arrayItem = array("label" => $row['category'], "y" => $row['total']);
  array_push($dataPoints, $arrayItem);
}
