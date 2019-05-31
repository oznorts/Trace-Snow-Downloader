<?php
$time_start = microtime(true); 
// Enter an array of the visit IDs you want to download (you can find these in the dropdown at http://snow.traceup.com/settings/gpx)
$visits = array();
$count = 0;
foreach ($visits as $visit) {
    if ($count > 0) { // Set the 0 to however many visits you want to download at a time
        break;
    }
    if(!file_exists("$visit.gpx")) {
        $c = curl_init('http://snow.traceup.com/settings/gpx');
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, "selected_visit=$visit");
        curl_setopt($c, CURLOPT_VERBOSE, 1);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_AUTOREFERER, false);
        curl_setopt($c, CURLOPT_COOKIE, 'sid=; PHPSESSID='); // Login to Trace and find your the sid cookie as well as the PHPSESSID and enter them here
        curl_setopt($c, CURLOPT_HEADER, 0);
        $page = curl_exec($c);
        curl_close($c);
        $fp = fopen("$visit.gpx", 'w');
        fwrite($fp, $page);
        fclose($fp);
        $count++;
    }
}
$count2 = 0;
foreach ($visits as $visit) {
    if(!file_exists("$visit.gpx")) {
        $count2++;
        echo "$visit; ";
    }
}
echo "<br /><b>Left to download:</b> $count2";
echo '<br /><b>Total Execution Time:</b> '.(microtime(true) - $time_start).' Secs';
?>
<script>
    setTimeout(function () {
        location.reload();
    }, 1000);   
</script>
