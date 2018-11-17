<?php
$con=mysqli_connect("localhost","weather","WeatherMySQLPasswd","weather");
$sql  = "SELECT '%s' as HOUR, FORMAT(SUM(RAINFALL), 2) as DAILY_RAINFALL FROM (SELECT RAINFALL FROM WEATHER_MEASUREMENT WHERE CREATED BETWEEN '%s' AND '%s') RAIN";

$todaymid = strtotime('today midnight');
$todayMD = date("md", $todaymid);
$yestmid = strtotime('yesterday midnight');
$yestMD = date("md", $yestmid);
$union = " ";
$complete_query = " ";

for ($i=23;$i>=0;$i--)
{
	$ts = strtotime("-".$i." hour");
	$tdMD = date("md", $ts);
	if ($tdMD != $todayMD) {$time_from = date("Y-m-d H:00:00 ", $yestmid);}
	else {$time_from = date("Y-m-d H:00:00 ", $todaymid);}
	$time_to = date("Y-m-d H:59:59", $ts);
	$hr = date("H", $ts);
	$complete_query .= $union;
	$union = " UNION ";
	$complete_query .= sprintf($sql, $hr, $time_from, $time_to);
}

#echo "$complete_query \r\n";
$result = mysqli_query($con, $complete_query);
$rows = array();

$i=0;
while($row = mysqli_fetch_array($result)) {
	$DAILY_RAINFALL[$i++] = array('hour' => $row['HOUR'],'daily_rainfall' => $row['DAILY_RAINFALL']);
}
mysqli_commit($con);
print json_encode($DAILY_RAINFALL)."\r\n";
mysqli_close($con);

?>
