<?php
require_once '../db.php';
global $conn;

$tableName = $_POST['tableName'];
$pageNumber = isset($_POST['pageNumber']) ? $_POST['pageNumber'] : 1;
$rowofPage = isset($_POST['rowofPage']) ? $_POST['rowofPage'] : 10;
$ID = $_POST['ID'];


$query = "SELECT * FROM $tableName
          ORDER BY $ID
          LIMIT ($pageNumber - 1) * $rowofPage, $rowofPage;";

$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $data = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }

  echo $data; 
} else {
    echo "Failed";
}

?>