<?php
require_once 'connection.php';

$id = $_GET['id'];
$query = "DELETE FROM menu_makanan WHERE id=".$id;
if(sqlsrv_query($conn, $query))
{
   $response=array(
      'status' => 1,
      'message' =>'Delete Success'
   );
}
else
{
   $response=array(
      'status' => 0,
      'message' =>'Delete Failed.'
   );
}
header('Content-Type: application/json');
echo json_encode($response);
?>