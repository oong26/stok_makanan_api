<?php 
require_once 'connection.php';

$tsql = "SELECT * FROM menu_makanan";

$stmt = sqlsrv_query($conn, $tsql);  

$data = null;

while($row=sqlsrv_fetch_object($stmt))
{
    $data[] =$row;
}
$response=array(
                'status' => 1,
                'message' =>'Success',
                'data' => $data
            );
header('Content-Type: application/json');
echo json_encode($response);

sqlsrv_free_stmt($stmt);  
sqlsrv_close($conn);  
?>