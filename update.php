<?php
require_once 'connection.php';

$currentDate = date('Y-m-d');
$id = $_POST['id'];

if (isset($_POST['filename']) && isset($_POST['tmpfile'])) {
    $filename = $_POST['filename'];
    $tmp_file = $_POST['tmpfile'];

    $dirname = "upload/";
    $folder = $dirname . "/";

    if (!file_exists($folder)) {
        mkdir($dirname, 0777);
    }

    $replace = substr($tmp_file, 0, strpos($tmp_file, ',') + 1);

    $image = str_replace($replace, '', $tmp_file);

    $image = str_replace(' ', '+', $image);
    if (file_put_contents($dirname.$filename, base64_decode($image))) {
        $result = sqlsrv_query($conn, "UPDATE menu_makanan SET shift = '$_POST[shift]', kategori_menu = '$_POST[kategori_menu]', stok = '$_POST[stok]', stok_temp = '$_POST[stok_temp]', nama = '$_POST[nama]', detail = '$_POST[detail]', tanggal = '$currentDate', gambar = '$filename' WHERE id = '$id'");
    
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
    }
    else {
        $response=array(
            'status' => 0,
            'message' =>'Failed to upload an image',
        );
    }
} else {
    $result = sqlsrv_query($conn, "UPDATE menu_makanan SET shift = $_POST[shift], kategori_menu = '$_POST[kategori_menu]', stok = '$_POST[stok]', stok_temp = '$_POST[stok_temp]', nama = '$_POST[nama]', detail = '$_POST[detail]', tanggal = '$currentDate' WHERE id = $id");
    
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
}

header('Content-Type: application/json');
echo json_encode($response);

sqlsrv_close($conn);
?>