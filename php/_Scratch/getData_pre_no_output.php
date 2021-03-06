<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>

  <head></head>

  <body>

<?php

ini_set('display_errors', 1); // show errors
error_reporting(-1); // of all levels
date_default_timezone_set('UTC'); // PHP will complain about on this error level

// attempt a connection

$dbh = pg_connect("host=localhost port=5432 dbname=geoviz user=postgres password=user");

if (!$dbh) {

    die("Error in connection: " . pg_last_error());

} /*else {
	echo "Connection successful" . "<p />";
}*/

// Bodenluft:			exlusion of lon / lat since only X and Y coordinates are necessary? // problem with ö,ä,ü in field petrograph?
// execute query:
$sql = "SELECT ST_X(geom) AS X, ST_Y(geom) AS Y, gid, standort, einheit, messw_bl, lon, lat, petrograph FROM public.bodenluft_4326";
$result = pg_query($dbh, $sql);

if (!$result) {

    die("Error in SQL query: " . pg_last_error());

}

$filename = 'Bodenluft_4326_statistics_php.csv';
$fp = fopen($filename, "w+");

// fetch a row and write the column names (!) out to the file -> first line of CSV
$row = pg_fetch_assoc($result);
$line = "";
$comma = "";
foreach($row as $name => $value) {
	$line .= strtoupper($comma . str_replace('"', '""', $name));	//letters to uppercase and ',' and ' ' are "deleted"
    $comma = ",";
}
$line .= "\n";
fputs($fp, $line);

// remove the result pointer back to the start
pg_result_seek($result, 0);

// and loop through the actual data
while($row = pg_fetch_assoc($result)) {

    $line = "";
    $comma = "";
	$replace = array(","," ");
	
    foreach($row as $value) {
		$line .= $comma . str_replace($replace,'', $value);
        $comma = ",";
    }
	
    $line .= "\n";
	
    fputs($fp, $line);

}

fclose($fp);

// free memory

pg_free_result($result);

// end of Bodenluft!

// ODL:
// execute query:
$sql = "SELECT ST_X(geom) AS X, ST_Y(geom) AS Y, gid, standort, einheit_od, messw_odl, lon, lat, petrograph FROM public.odl_4326";
$result = pg_query($dbh, $sql);

if (!$result) {

    die("Error in SQL query: " . pg_last_error());

}

$filename = 'ODL_4326_statistics_php.csv';
$fp = fopen($filename, "w+");

// fetch a row and write the column names (!) out to the file -> first line of CSV
$row = pg_fetch_assoc($result);
$line = "";
$comma = "";
foreach($row as $name => $value) {
	$line .= strtoupper($comma . str_replace('"', '""', $name));	//letters to uppercase and ',' and ' ' are "deleted"
    $comma = ",";
}
$line .= "\n";
fputs($fp, $line);

// remove the result pointer back to the start
pg_result_seek($result, 0);

// and loop through the actual data
while($row = pg_fetch_assoc($result)) {

    $line = "";
    $comma = "";
	$replace = array(","," ");
	
    foreach($row as $value) {
		$line .= $comma . str_replace($replace,'', $value);
        $comma = ",";
    }
	
    $line .= "\n";
	
    fputs($fp, $line);

}

fclose($fp);

// free memory

pg_free_result($result);

// end of ODL!

// Raumluft:
// execute query:
$sql = "SELECT ST_X(geom) AS X, ST_Y(geom) AS Y, gid, hausart, bauweise, avg_mw, min_mw, max_mw, messw_1g, messw_eg, messw_ke, lon, lat, petrograph FROM public.raumluft_4326";
$result = pg_query($dbh, $sql);

if (!$result) {

    die("Error in SQL query: " . pg_last_error());

}

$filename = 'Raumluft_4326_statistics_php.csv';
$fp = fopen($filename, "w+");

// fetch a row and write the column names (!) out to the file -> first line of CSV
$row = pg_fetch_assoc($result);
$line = "";
$comma = "";
foreach($row as $name => $value) {
	$line .= strtoupper($comma . str_replace('"', '""', $name));	//letters to uppercase and ',' and ' ' are "deleted"
    $comma = ",";
}
$line .= "\n";
fputs($fp, $line);

// remove the result pointer back to the start
pg_result_seek($result, 0);

// and loop through the actual data
while($row = pg_fetch_assoc($result)) {

    $line = "";
    $comma = "";
	$replace = array(","," ");
	
    foreach($row as $value) {
		$line .= $comma . str_replace($replace,'', $value);
        $comma = ",";
    }
	echo $line . "<br />";
	
    $line .= "\n";
	
    fputs($fp, $line);

}

fclose($fp);

// free memory

pg_free_result($result);

// end of Raumluft!

// DEU2_adm_statistics = counties:
// execute query:
$sql = "SELECT gid, id_2, name_2, avg_mw_bl, avg_mw_odl, avg_mw_rl, count_bl, count_odl, count_rl FROM public.deu_adm2_counties_statistics";
$result = pg_query($dbh, $sql);

if (!$result) {

    die("Error in SQL query: " . pg_last_error());

}

$filename = 'DEU_counties_statistics_php.csv';
$fp = fopen($filename, "w+");

// fetch a row and write the column names (!) out to the file -> first line of CSV
$row = pg_fetch_assoc($result);
$line = "";
$comma = "";
foreach($row as $name => $value) {
	$line .= strtoupper($comma . str_replace('"', '""', $name));	//letters to uppercase and ',' and ' ' are "deleted"
    $comma = ",";
}
$line .= "\n";
fputs($fp, $line);

// remove the result pointer back to the start
pg_result_seek($result, 0);

// and loop through the actual data
while($row = pg_fetch_assoc($result)) {

    $line = "";
    $comma = "";
	$replace = array(","," ");
	
    foreach($row as $value) {
		$line .= $comma . str_replace($replace,'', $value);
        $comma = ",";
    }
	
    $line .= "\n";
	
    fputs($fp, $line);

}

fclose($fp);

// free memory

pg_free_result($result);

// end of DEU2_adm_statistics = counties!

// Raumluft - Petrograph
// execute query:
//$sql = "SELECT COUNT(DISTINCT geo), geo, petrograph, messw_ke AS rl_ke, messw_eg AS rl_eg, messw_1g AS rl_1G FROM public.raumluft_4326 GROUP BY geo, petrograph HAVING COUNT(DISTINCT geo) >= 20 ORDER BY geo";
$sql = "SELECT geo, petrograph, AVG(avg_mw) AS rl_avg, MIN(min_mw) AS rl_min, MAX(max_mw) AS rl_max, AVG(messw_ke) AS rl_avg_ke, AVG(messw_eg) AS rl_avg_eg, AVG(messw_1g) AS rl_avg_1g, COUNT(*) AS rl_max FROM public.raumluft_4326 GROUP BY geo, petrograph  HAVING COUNT(*) >= 25 ORDER BY GEO";
$result = pg_query($dbh, $sql);

if (!$result) {

    die("Error in SQL query: " . pg_last_error());

}

$filename = 'Raumluft_4326_statistics_petrograph_php.csv';
$fp = fopen($filename, "w+");

// fetch a row and write the column names (!) out to the file -> first line of CSV
$row = pg_fetch_assoc($result);
$line = "";
$comma = "";
foreach($row as $name => $value) {
	$line .= strtoupper($comma . str_replace('"', '""', $name));	//letters to uppercase and ',' and ' ' are "deleted"
    $comma = ",";
}
$line .= "\n";
fputs($fp, $line);

// remove the result pointer back to the start
pg_result_seek($result, 0);

// and loop through the actual data
while($row = pg_fetch_assoc($result)) {

    $line = "";
    $comma = "";
	$replace = array(","," ");
	
    foreach($row as $value) {
		$line .= $comma . str_replace($replace,'', $value);
        $comma = ",";
    }
	echo $line . "<br />";
	
    $line .= "\n";
	
    fputs($fp, $line);

}

fclose($fp);

// free memory

pg_free_result($result);

// end of Raumluft - Petrograph!

// close connection

pg_close($dbh);

?>

  </body>

</html>