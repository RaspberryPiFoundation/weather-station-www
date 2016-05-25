<?php
header('Content-Type: application/json');
$con=mysqli_connect("localhost","root","raspberry","weather");
$column_name = $_GET["col"];
$msl = 0;
if ($column_name == "MSL_PRESSURE"){
    $column_name = "AIR_PRESSURE";
    $msl = 1;
    $altitude = 112.2; // metres
}

$time_from = $_GET["from"];
$time_to = $_GET["to"];

$select_template = "SELECT %s, UNIX_TIMESTAMP(CREATED) as UNIX_TIME FROM WEATHER_MEASUREMENT WHERE CREATED >= FROM_UNIXTIME(%s) AND CREATED <= FROM_UNIXTIME(%s);";
$select_query = sprintf($select_template, $column_name, $time_from, $time_to);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, $select_query);

$rows = array();

while($row = mysqli_fetch_array($result)) {
    $time_unix = floatval($row['UNIX_TIME']) * 1000; //flot needs it in milliseconds
    if ($msl) {
         $air_value = floatval($row[$column_name]);
         $msl_value = $air_value/(pow(1-($altitude/44330.0),5.255));
         $row[$column_name] = $msl_value;
    }

    $rows[] = array( $time_unix, floatval($row[$column_name]) );
}

echo json_encode($rows);

mysqli_close($con);
?>
