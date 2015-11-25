<?php
# Copyright (c) 2015 Jordan Turley, CSGO Win Big. All Rights Reserved.

function getDB() {
	$dbHost = 'vps220904.ovh.net';
	$db     = 'incom-shuffle';
	$dbUser = 'root';

	
		$dbPass = "Marseillai71";


	$db = new PDO("mysql:host=$dbHost;dbname=$db;charset=utf8", $dbUser, $dbPass);
	return $db;
}

function getSteamProfileInfoForSteamID($allUsersInfoStr, $steamIDToFind) {
	$allUsersInfo = json_decode($allUsersInfoStr, true);
	$players = $allUsersInfo['response']['players'];
	
	foreach ($players as $player) {
		$steamID = $player['steamid'];
		$player['personaname'] = htmlentities($player['personaname']);
		
		if ($steamIDToFind === $steamID) {
			return $player;
		}
	}

	# If the user is not found, then return false
	return false;
}

function jsonSuccess($data) {
	return json_encode(array('success' => 1, 'data' => $data));
}

function jsonErr($errMsg) {
	return json_encode(array('success' => 0, 'errMsg' => $errMsg));
}

function getSteamAPIKey() {
	
		$key = "5130B34C37EEC2882941FE7190A2D239";
		return $key;
	
}

function postVar($varName) {
	$var = isset($_POST[$varName]) ? $_POST[$varName] : null;

	if (is_null($var) || strlen($var) === 0) {
		return null;
	} else {
		return $var;
	}
}

function getVar($varName) {
	$var = isset($_GET[$varName]) ? $_GET[$varName] : null;

	if (is_null($var) || strlen($var) === 0) {
		return null;
	} else {
		return $var;
	}
}

# Thanks to TheAnthonyNL on Github for this function
function steamid32ToSteamid64($steamid32) {
    $iServer = "0";
    $iAuthID = "0";

    $szTmp = strtok($steamid32, ":");

    while(($szTmp = strtok(":")) !== false)
    {
        $szTmp2 = strtok(":");
        if($szTmp2 !== false)
        {
            $iServer = $szTmp;
            $iAuthID = $szTmp2;
        }
    }
    if($iAuthID == "0")
        return "0";

    $steamId64 = bcmul($iAuthID, "2");
    $steamId64 = bcadd($steamId64, bcadd("76561197960265728", $iServer)); 
    $part = explode('.',$steamId64);
    return $part[0];
}
?>