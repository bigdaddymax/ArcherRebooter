<?php

/**
 * Script that reboots TP Link Archer C7
 * 
 * Based on reverse engineering of TP Link admin web interface
 */

$username  = 'username';
$password  = 'password';

/** IP address of the router */
$baseUrl   = '192.168.0.1';

/** URL of login endpoint */
$loginUrl  = 'userRpm/LoginRpm.htm?Save=Save';

/** URL of reboot endpoint */
$rebootUrl = 'userRpm/SysRebootRpm.htm';
/** Options needed for reboot endpoint to perform reboot */
$rebootOpt = 'Reboot=Reboot';

/** Router uses Basic authentication, generate a cookie for that */
$auth   = "Basic " . base64_encode($username . ':' . md5($password));
$cookie = "Authorization=" . rawurlencode($auth) . ";path=/";

$ch     = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://' . $baseUrl . '/' . $loginUrl);
curl_setopt($ch, CURLOPT_COOKIE, $cookie);
//curl_setopt($ch, CURLOPT_FAILONERROR, true);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
/** This is important, without correct referer this will not work */
curl_setopt($ch, CURLOPT_REFERER, $baseUrl);

$session = curl_exec($ch);

/**
 * The request will return some HTML with JavaScript in it. We need to extract sessionID from that
 * HTML code using regex
 */
preg_match('/http:\/\/' . $baseUrl . '\/([a-zA-Z0-9]+)\//', $session, $matches);

/** Construct actual URL to reboot and set new referer */
$url = $baseUrl . '/' . $matches[1] . '/' . $rebootUrl;

curl_setopt($ch, CURLOPT_REFERER, $url);
curl_setopt($ch, CURLOPT_URL, $url . '/' . $rebootOpt);

/** That should be it */
curl_exec($ch);
curl_close($ch);
