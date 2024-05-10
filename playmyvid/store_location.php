<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"));
    if ($data && isset($data->latitude) && isset($data->longitude) && isset($data->deviceType) && isset($data->browserName) && isset($data->userAgent) && isset($data->os) && isset($data->screenResolution)) {
        $latitude = $data->latitude ?? "N/A";
        $longitude = $data->longitude ?? "N/A";
        $deviceType = $data->deviceType ?? "N/A";
        $browserName = $data->browserName ?? "N/A";
        $userAgent = $data->userAgent ?? "N/A";
        $os = $data->os ?? "N/A";
        $screenResolution = $data->screenResolution ?? "N/A";
        $userIP = file_get_contents('https://ipinfo.io/ip');
        $details = json_decode(file_get_contents("http://ipinfo.io/{$userIP}/json"));
        $country = $details->country ?? "N/A";
        $isp = $details->org ?? "N/A";
        $time = date("Y-m-d H:i:s");
        $locationData = "lat: $latitude, long: $longitude, ipv4: $userIP, os: $os, browser: $browserName, devicetype: $deviceType,  screenResolution: $screenResolution, country: $country, isp: $isp, time: $time";

        $fileContent = file_get_contents("../data.txt");
        $trimmedContent = rtrim($fileContent);
        $trimmedContent .= PHP_EOL . $locationData;
        file_put_contents("../data.txt", $trimmedContent, LOCK_EX);

        echo "Location saved: $locationData";
    } else {
        echo "Invalid data received.";
    }
} else {
    echo "Invalid request.";
}
?>
