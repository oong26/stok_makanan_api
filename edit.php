<?php
require_once 'connection.php';

$id = $_GET['id'];
$query = "SELECT * FROM menu_makanan WHERE id= $id";
$result = sqlsrv_query($conn, $query);
$data = null;

while ($row = sqlsrv_fetch_object($result)) {
    $data = $row;
}
if ($data) {
    $response = array(
        'status' => 1,
        'message' => 'Success',
        'data' => $data
    );
} else {
    $response = array(
        'status' => 0,
        'message' => 'No Data Found'
    );
}

header('Content-Type: application/json');
echo json_encode($response);

sqlsrv_close($conn);
