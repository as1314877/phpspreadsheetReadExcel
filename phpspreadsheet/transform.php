<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

# $argv is array of input parameter
# $argv[1] is file path ex: "C:\Users\SunLC\Desktop\input2.xls"
# $argv[2] is ouput file store path ex: "C:\Users\SunLC\Desktop\result\"
# print_r( $argv );

$input_file_name;
$output_file_path;
$come_from;
if ( empty( $argv ) ) { # command come from web page
	$input_file_name = $_GET['file'];
	$output_file_path = $_GET['path']. '/result/';
	$come_from = 'web';
} else { # command come from terminal
	$input_file_name = $argv[1];
	$output_file_path = $argv[2];
	$come_from = 'terminal';
}


# load files
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load( $input_file_name );

$sheet_number = $spreadsheet->getSheetCount();
$sheet_names = $spreadsheet->getSheetNames();

for ( $i = 0; $i < $sheet_number; $i++ ) {
	$data = $spreadsheet->getSheet($i)->toArray( null, true, true, true );
	$output = '';
	$data_size = sizeof( $data );
	for ( $j = 1; $j <= $data_size; $j++) {
		if ( $j==1 ) {
			$output = $output . $data[$j]['A'] . '@' . $data[$j]['B'] . "\t#" . $data[$j]['C'];
		} else {
			$output = $output . "\r\n" . $data[$j]['A'] . '@' . $data[$j]['B'] . "\t#" . $data[$j]['C'];
		}
	}
	# Determine if the folder exists
	if ( !is_dir( $output_file_path ) ) {
		echo 'not exist!\n';
		if ( !mkdir( $output_file_path, 0777 ) ) { #預設的 mode 是 0777，意味著最大可能的訪問權
			echo "Failed to create a folder! ";
		}
	}
	# write output.txt
	if ( !file_put_contents( $output_file_path . $sheet_names[$i], $output ) ) {
		echo "Failed to create a file! ";
	} else {
		echo "Succeed to create a file! ";
	}
}
if ( $come_from=='web' ) {
	header('location:zipDownload.php');
}
?>