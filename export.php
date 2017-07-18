<?php

include_once '../../../wp-load.php';
global $wpdb;
$table_name = $wpdb->prefix .'backlink_management';
$pattern = $_POST['export'];
// output headers so that the file is downloaded rather than displayed
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="'.$pattern.'.csv"');
 
// do not cache the file
header('Pragma: no-cache');
header('Expires: 0');
 
// create a file pointer connected to the output stream
$file = fopen('php://output', 'w');
 
// send the column headers
fputcsv($file, array('Id', 'Domain', 'Domain authority', 'Backlink type'));
$data = $wpdb->get_results("SELECT * from $table_name WHERE backlink_type LIKE '".$pattern."' ");
 
// Sample data. This can be fetched from mysql too
// $data = array(
//     array('Data 11', 'Data 12', 'Data 13', 'Data 14', 'Data 15'),
//     array('Data 21', 'Data 22', 'Data 23', 'Data 24', 'Data 25'),
//     array('Data 31', 'Data 32', 'Data 33', 'Data 34', 'Data 35'),
//     array('Data 41', 'Data 42', 'Data 43', 'Data 44', 'Data 45'),
//     array('Data 51', 'Data 52', 'Data 53', 'Data 54', 'Data 55')
// );
 
// output each row of the data
foreach ($data as $row)
{
	$result = get_object_vars($row);
    fputcsv($file, $result);
}
 
exit();

?>