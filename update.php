<?php
require_once 'connection.php';

$currentDate = date('Y-m-d');
$json = file_get_contents('php://input');
$data = json_decode($json);
$id = $data->id;

if ($data->filename != '' && $data->tmpfile != '') {
    $filename = $data->filename . '.' . $data->file_ext;
    $tmp_file = $data->tmpfile;

    $dirname = "upload/";
    $folder = $dirname . "/";

    if (!file_exists($folder)) {
        mkdir($dirname, 0777);
    }

    $replace = substr($tmp_file, 0, strpos($tmp_file, ',') + 1);

    $image = str_replace($replace, '', $tmp_file);

    $image = str_replace(' ', '+', $image);
    if (file_put_contents($dirname . $filename, base64_decode($image))) {
        $result = sqlsrv_query($conn, "UPDATE menu_makanan SET shift = '$data->shift', kategori_menu = '$data->kategori_menu', stok = '$data->stok', stok_temp = '$data->stok_temp', nama = '$data->nama', detail = '$data->detail', tanggal = '$currentDate', gambar = '$filename' WHERE id = '$id'");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Failed',
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed to upload an image',
        );
    }
} else {
    $result = sqlsrv_query($conn, "UPDATE menu_makanan SET shift = $data->shift, kategori_menu = '$data->kategori_menu', stok = '$data->stok', stok_temp = '$data->stok_temp', nama = '$data->nama', detail = '$data->detail', tanggal = '$currentDate' WHERE id = $id");

    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Success'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed',
        );
    }
}

header('Content-Type: application/json');
echo json_encode($response);

sqlsrv_close($conn);
