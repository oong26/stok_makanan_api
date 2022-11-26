<?php
require_once 'connection.php';

$currentDate = date('Y-m-d');
$json = file_get_contents('php://input');
$data = json_decode($json);

if ($data->filename && $data->tmpfile) {
    $tsql = "SELECT * FROM menu_makanan WHERE nama = '$data->nama'";
    $stmt = sqlsrv_query($conn, $tsql);
    $result = null;
    while ($row = sqlsrv_fetch_object($stmt)) {
        $result[] = $row;
    }

    if ($result) {
        // nama menu telah digunakan
        $response = array(
            'status' => 0,
            'message' => 'Menu telah tersedia',
        );
    } else {
        // nama menu belum digunakan
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
            $result = sqlsrv_query($conn, "INSERT INTO menu_makanan(shift, kategori_menu, stok, stok_temp, nama, detail, tanggal, gambar) VALUES($data->shift, '$data->kategori_menu', '$data->stok', '$data->stok_temp', '$data->nama', '$data->detail', '$currentDate', '$filename')");

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
    }
} else {
    $response = array(
        'status' => 0,
        'message' => 'No image uploaded',
    );
}

header('Content-Type: application/json');
echo json_encode($response);

sqlsrv_close($conn);
