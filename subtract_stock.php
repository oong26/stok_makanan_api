<?php

require_once 'connection.php';

$id = $_GET['id'];

$result = sqlsrv_query($conn, "UPDATE menu_makanan SET stok = stok - 5 WHERE id = $id");

if($result)
{
    $response=array(
        'status' => 1,
        'message' =>'Success'
    );
}
else
{
    $response=array(
        'status' => 0,
        'message' =>'Failed',
    );
}

header('Content-Type: application/json');
echo json_encode($response);

sqlsrv_close($conn);
