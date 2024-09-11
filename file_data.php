<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$data = [
    ['Ho', 'Ten', 'NgaySinh', 'GioiTinh', 'DiaChi', 'DonVi', 'MaSo', 'SDT', 'Email', 'Password'],
    ['Nguyen', 'Van A', '2000-01-01', 'Nam', 'Hà Nội', 'Sinh Viên', 'SV00001', '0901234567', 'vana@gmail.com', 'Password1!'],
    ['Tran', 'Thi B', '1995-05-05', 'Nu', 'Đà Nẵng', 'Giáo Viên', 'GV00002', '0912345678', 'thib@gmail.com', 'Password2!'],
    ['Le', 'Van C', '1998-12-12', 'Nam', 'Hồ Chí Minh', 'Cán Bộ Khác', 'NV00003', '0923456789', 'vanc@gmail.com', 'Password3!']
];

foreach ($data as $rowNumber => $row) {
    foreach ($row as $columnNumber => $cellValue) {
        $columnLetter = chr(65 + $columnNumber);
        $sheet->setCellValue($columnLetter . ($rowNumber + 1), $cellValue);
    }
}

$writer = new Xlsx($spreadsheet);
$temp_file = tempnam(sys_get_temp_dir(), 'sample_data.xlsx');
$writer->save($temp_file);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="sample_data.xlsx"');
header('Cache-Control: max-age=0');
header('Content-Length: ' . filesize($temp_file));

readfile($temp_file);

unlink($temp_file);
exit();
?>
