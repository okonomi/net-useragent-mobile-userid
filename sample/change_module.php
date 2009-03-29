<?php

require_once 'Net/UserAgent/Mobile/UserID.php';
require_once 'Net/UserAgent/Mobile/UserID/Abstract.php';


// ?id=aa-12345みたいなの
class Hoge extends Net_UserAgent_Mobile_UserID_Abstract
{
    public function getID()
    {
        if (array_key_exists('id', $_REQUEST)) {
            return $_REQUEST['id'];
        } else {
            return null;
        }
    }

    public function validateID($id)
    {
        return preg_match('/^[a-z}{2}\-[0-9]{5}$/', $id);
    }

    protected function _parseID($id)
    {
        return array(
            substr($id, 0, 2),
            substr($id, 3),
        );
    }
}

Net_UserAgent_Mobile_UserID::setUserIDModules('DoCoMo', new Hoge());
