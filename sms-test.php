<?php
/**
 * Created by PhpStorm.
 * User: Javier Orlando Ramirez Martinez
 * Date: 2016-11-16
 * Time: 1:17 PM
 */

chdir("../../");
include_once("./include/auth.php");
include_once($config['base_path'] . '/plugins/thold/thold_functions.php');

global $config;
print "<html><head>";
print '<link type="text/css" href="../../include/main.css" rel="stylesheet">';
print "</head><body>";
$message =  "This is a test message generated from Cacti.  This message was sent to test the configuration of your SMS Options.";

print "Checking Configuration...<br>";

$sms_api_key = read_config_option("thold_sms_api_key");
$sms_api_secret = read_config_option("thold_sms_api_secret");
$sms_from = read_config_option("thold_sms_from");
$sms_to = read_config_option("thold_sms_to");
$sms_provider = read_config_option("thold_sms_provider");

if (($sms_to == '') || ($sms_api_key == '') || ($sms_api_secret == '') || ($sms_from == '') || ($sms_provider == '')) {
    thold_cacti_log("Threshold SMS Settings is not configured properly");
    $errors = 'Threshold SMS Settings is not configured properly. Try saving the settings first.';
} else {
    $url = create_sms_url($sms_to, $message);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
}

print "Creating Message Text...<br><br>";
print "<center><table width='95%' cellpadding=1 cellspacing=0 bgcolor=black><tr><td>";
print "<table width='100%' bgcolor=white><tr>$message<br></td><tr></table></table></center><br>";
print "Sending Message...<br><br>";

if ($errors == '') {
    if ($response == '') {
        $errors = "Success!";
    } else {
        $errors = $response;
    }
}

print "<center><table width='95%' cellpadding=1 cellspacing=0 bgcolor=black><tr><td>";
print "<table width='100%' bgcolor=white><tr><td>$errors</td><tr></table></table></center>";

print "</body></html>";