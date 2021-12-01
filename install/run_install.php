<?php
require_once("../SCRIPT/apl_core_configuration.php");
require_once("../SCRIPT/apl_core_functions.php");
ini_set('max_execution_time', 300);

if (!isset($_POST['purchase_code']) || $_POST['purchase_code'] == "") {
    echo "Please Enter Purchase code";
} elseif (!isset($_POST['web_name']) || $_POST['web_name'] == "") {
    echo "Please Enter Website Name";
} else if (!isset($_POST['web_url']) || $_POST['web_url'] == "") {
    echo "Please Enter Website URL";
} else  if (!isset($_POST['database_host']) || $_POST['database_host'] == "") {
    echo "Please Enter Database Host";
} else  if (!isset($_POST['database_name']) || $_POST['database_name'] == "") {
    echo "Please Enter Database Name";
} else if (!isset($_POST['database_username']) || $_POST['database_username'] == "") {
    echo "Please Enter Database Username";
} else {

    $LICENSE_CODE = $_POST['purchase_code'];
    aplVerifyEnvatoPurchase($LICENSE_CODE);
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $license_notifications_array = aplInstallLicense($url, '', $LICENSE_CODE, '');

     if ($license_notifications_array['notification_case'] == "notification_license_ok") {
        // Name of the file
        $filename = 'database/database.sql';
        // MySQL host
        $mysql_host = $_POST['database_host'];
        // MySQL username
        $mysql_username = $_POST['database_username'];
        // MySQL password
        $mysql_password = $_POST['database_password'];
        // Database name
        $mysql_database =  $_POST['database_name'];

        //$purchase_code =  $_POST['p_code'];
        $website_url =  $_POST['web_url'];
        
       

        restoreDatabaseTables($mysql_host, $mysql_username, $mysql_password, $mysql_database, $filename);

        setEnvironmentIni();
        setEnvironmentValue('app.baseURL', 'url', $website_url);
        setEnvironmentValue('database.default.hostname', 'localhost', $mysql_host);
        setEnvironmentValue('database.default.database', 'database_name', $mysql_database);
        setEnvironmentValue('database.default.username', 'database_user', $mysql_username);
        setEnvironmentValue('database.default.password', 'database_pass', $mysql_password);
       // setUp($p1, $p3, $dtmr);
        echo "success";
        
    } else {
        echo $license_notifications_array['notification_text'];
    }
}


function setEnvironmentIni()
{
    $ctFile1 = 'initialize.txt';
    $ctFile = '../.env';
    $setupFIle = '../public/setup.txt';
    $str = file_get_contents($ctFile1);
    $fp = fopen($ctFile, 'w');
    fwrite($fp, $str);
    $fp1 = fopen($setupFIle, 'w');
    fwrite($fp1, $str);
}

function setEnvironmentValue($envKey, $oldValue, $envValue)
{
    $ctFile = '../.env';
    $str = file_get_contents($ctFile);
    $str = str_replace($envKey . "=" . $oldValue, $envKey . "=" . $envValue, $str);
    $fp = fopen($ctFile, 'w');
    fwrite($fp, $str);
}
function restoreDatabaseTables($dbHost, $dbUsername, $dbPassword, $dbName, $filePath)
{
    // Connect & select the database
    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Temporary variable, used to store current query
    $templine = '';

    // Read in entire file
    $lines = file($filePath);

    $error = '';

    // Loop through each line
    foreach ($lines as $line) {
        // Skip it if it's a comment
        if (substr($line, 0, 2) == '--' || $line == '') {
            continue;
        }

        // Add this line to the current segment
        $templine .= $line;

        // If it has a semicolon at the end, it's the end of the query
        if (substr(trim($line), -1, 1) == ';') {
            // Perform the query
            if (!$db->query($templine)) {
                $error .= 'Error performing query "<b>' . $templine . '</b>": ' . $db->error . '<br /><br />';
            }

            // Reset temp variable to empty
            $templine = '';
        }
    }
    return !empty($error) ? $error : true;
}
