<?php

require_once 'Net/UserAgent/Mobile/DoCoMo/ImodeID.php';


if (Net_UserAgent_Mobile_ImodeID::validateID('xxxxxxx')) {
    echo "ok";
} else {
    echo "ng";
}
