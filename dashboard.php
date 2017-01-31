<?php

// Get cURL resource
$curl = curl_init();

//$username = "a.moneeb3";
//$password = "Moneeb@098";

$username = $_GET["user"];
$password = $_GET["password"];

// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/endpointProfileBodyByGroupId?endpointGroupId=1&limit=20&offset=0',
    CURLOPT_USERPWD => "$username:$password"
));
// Send the request & save response to $resp
$resp = curl_exec($curl);

if (!curl_errno($curl))
{
    if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200)
    {
     header("Location: index.html");   
    }

}

$respDecoded = json_decode($resp,true);

echo "<table border=2>";

for ( $i = 0 ; $i < count($respDecoded["endpointProfilesBody"]) ; $i++)
{
$endpointData = $respDecoded["endpointProfilesBody"][$i];
//print_r($endpointData);

$epKey = $endpointData["endpointKeyHash"];
$clientSideProfile = $endpointData["clientSideProfile"];
$clientSideProfile = json_decode($clientSideProfile,true);
$serialNumber = $clientSideProfile["serial_num"];
$epType = $clientSideProfile["end_point_type"];

print <<<HTML
<tr>
    <td><img src="access_point.png" style="width:100;height:100;"></td>
    <td>
        <p>EndPoint KeyHash : $epKey</p>
        <p>EndPoint Serial Number : $serialNumber</p>
        <p>EndPoint Type : $epType</p>
    </td>
</tr>
HTML;

}

echo "</table>";

// Close request to clear up some resources
curl_close($curl);
?>
