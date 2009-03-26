<?php

require_once 'Net/UserAgent/Mobile/UserID.php';


try {
    $userid = Net_UserAgent_Mobile_UserID::factory();
} catch (Net_UserAgent_Mobile_UserID_Exception $e) {
    var_dump($e->getMessage());
    exit;
}

echo $userid->getID();
// xxxxxxx
