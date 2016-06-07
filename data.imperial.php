<?php
header('Content-Type: application/json');
$con=mysqli_connect("localhost","weather","WeatherMySQLPasswd","weather");
$column_name = $_GET["col"];
$msl = 0;
if ($column_name == "MSL_PRESSURE"){
    $column_name = "AIR_PRESSURE";
    $msl = 1;
    $altitude = 112.2; // metres
}
if ($column_name == "AMBIENT_TEMPERATURE" or $column_name == "GROUND_TEMPERATURE") {
    $fahrenheit = 1;
}
if ($column_name == "WIND_SPEED" or $column_name == "WIND_GUST_SPEED") {
    $miles = 1;
}
if ($column_name == "RAINFALL") {
    $rain_inches = 1;
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
    if ($fahrenheit) {
         $temp = floatval($row[$column_name]);
         $fahren_value = (($temp / 5.0) * 9.0) + 32;
         $row[$column_name] = $fahren_value;
    }
    if ($miles) {
         $speed = floatval($row[$column_name]);
         $statute_miles = $speed / 1.609344;
         $row[$column_name] = $statute_miles;
    }
    if ($rain_inches) {
         $fall_mm = floatval($row[$column_name]);
         $fall_inches = $fall_mm / 2.54;
         $row[$column_name] = $fall_inches;
    }

    $rows[] = array( $time_unix, floatval($row[$column_name]) );
}

echo json_encode($rows);

mysqli_close($con);
?>
