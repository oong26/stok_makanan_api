<?php
require_once 'connection.php';

$currentDate = date('Y-m-d');

if ($_POST['filename'] && $_POST['tmpfile']) {
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
        $result = sqlsrv_query($conn, "INSERT INTO menu_makanan(shift, kategori_menu, stok, stok_temp, nama, detail, tanggal) VALUES($_POST[shift], '$_POST[kategori_menu]', '$_POST[stok]', '$_POST[stok_temp]', '$_POST[nama]', '$_POST[detail]', '$currentDate')");
    
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
    $response=array(
        'status' => 0,
        'message' =>'No image uploaded',
    );
}

header('Content-Type: application/json');
echo json_encode($response);

sqlsrv_close($conn);  
?>