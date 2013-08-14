
<?php
// Create two timezone objects, one for Taipei (Taiwan) and one for
// Tokyo (Japan)
$dateTimeZoneTaipei = new DateTimeZone("Asia/Taipei");
$dateTimeZoneJapan = new DateTimeZone("Asia/Tokyo");

// Create two DateTime objects that will contain the same Unix timestamp, but
// have different timezones attached to them.
$dateTimeTaipei = new DateTime("now", $dateTimeZoneTaipei);
$dateTimeJapan = new DateTime("now", $dateTimeZoneJapan);

// Calculate the GMT offset for the date/time contained in the $dateTimeTaipei
// object, but using the timezone rules as defined for Tokyo
// ($dateTimeZoneJapan).
$timeOffset = $dateTimeZoneJapan->getOffset($dateTimeTaipei);

// Should show int(32400) (for dates after Sat Sep 8 01:00:00 1951 JST).
var_dump($timeOffset);


if(date_default_timezone_get() == 'UTC') {
    $offsetString = 'Z'; // No need to calculate offset, as default timezone is already UTC
} else {
    $phpTime = '2002-05-30 09:30:10';
    $millis = strtotime($phpTime); // Convert time to milliseconds since 1970, using default timezone
    $timezone = new DateTimeZone(date_default_timezone_get()); // Get default system timezone to create a new DateTimeZone object
    $offset = $timezone->getOffset(new DateTime($phpTime)); // Offset in seconds to UTC
    $offsetHours = round(abs($offset)/3600);
    $offsetMinutes = round((abs($offset) - $offsetHours * 3600) / 60);
    $offsetString = ($offset < 0 ? '-' : '+')
                . ($offsetHours < 10 ? '0' : '') . $offsetHours
                . ':'
                . ($offsetMinutes < 10 ? '0' : '') . $offsetMinutes;
}
echo('<startdate>' . date('Y-m-d\TH:i:s', $millis) . $offsetString . '</startdate>'); // This is the correct XML format

?>
