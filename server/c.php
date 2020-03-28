<?php

// Check .. in path
function checkPath($path) {
    if(stripos($path, '..') !== false) {
        die("<span class=\"material-icons toast-icon\">sync_problem</span> Request blocked for security reasons!");
    }
}

// Read payload
if(isset($_GET["r"])) {
    // Check user agent's
    if(stristr($_SERVER['HTTP_USER_AGENT'], 'curl') === false) {
        die("User-agent validation failed!");
    }
    // Check path
    $payloadName = "payloads/" . $_GET["r"] . ".json";
    $client_ip = $_SERVER['REMOTE_ADDR'];
    checkPath($payloadName);
    // If not exists
    if(!file_exists($payloadName)) {
        die("Payload not found!");
    }
    // Get payload 
    $json = json_decode(file_get_contents($payloadName), true);
    // Add 1 view
    $json["views"] += 1;
    // Add ip in stats if not exists
    if(!in_array($client_ip, $json["ips"])) {
        array_push($json["ips"], $client_ip);
    }
    // Write payload
    file_put_contents($payloadName, json_encode($json, JSON_PRETTY_PRINT));
    // Reponse
    die($json["code"]);
}

// Commands
if(isset($_POST["command"])) {
    require_once("protection.php");
    $command = $_POST["command"];

    // Save payload
    if($command == "createPayload") {
        $payloadCode = json_decode($_POST["payloadCode"]);
        $payloadCmd  = $_POST["payloadCmd"];
        $payloadLang = $_POST["payloadLang"];
        $payloadName = "payloads/" . $_POST["payloadName"] . ".json";
        // Json
        $json = json_encode(array(
            "name"  => $payloadName,
            "lang"  => $payloadLang,
            "cmd"   => $payloadCmd,
            "code"  => $payloadCode,
            "views" => 0,
            "ips"   => array()
        ), JSON_PRETTY_PRINT);
        // Check path
        checkPath($payloadName);
        // Check if exists payloads/ dir
        if(!file_exists("payloads/")) {
            mkdir("payloads/", 0700);
        }
        // Write payload code
        if(file_put_contents($payloadName, $json)) {
            die("<span class=\"material-icons toast-icon\">done</span> Payload saved.");
        } else {
            die("<span class=\"material-icons toast-icon\">wifi_off</span> Something went wrong!");
        }
    }
    // Delete payload
    elseif($command == "removePayload") {
        $payloadName = "payloads/" . $_POST["payloadName"] . ".json";
        // Check path
        checkPath($payloadName);
        // If not exists
        if(!file_exists($payloadName)) {
            die("<span class=\"material-icons toast-icon\">disc_full</span>File not found!");
        }
        // Delete payload code
        if(unlink($payloadName)) {
            die("<span class=\"material-icons toast-icon\">delete_sweep</span> Payload removed from server.");
        } else {
            die("<span class=\"material-icons toast-icon\">wifi_off</span> Something went wrong!");
        }
    }
    // List of payloads
    elseif($command == "listPayload") {
        $list  = array();
        $files = array_diff(scandir("payloads/"), array('.', '..'));
        foreach($files as $key => $val) {
            $json = json_decode(file_get_contents("payloads/" . $val), true);
            $list[] = $json;
        }
        die(json_encode($list));
    }

    // Undefined command
    else {
        die("Undefined command!");
    }
}

// End
die("Nothing is here.");

?>