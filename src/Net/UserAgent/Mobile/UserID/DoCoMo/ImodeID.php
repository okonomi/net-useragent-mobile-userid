<?php
require_once 'Net/UserAgent/Mobile/UserID/Abstract.php';


class Net_UserAgent_Mobile_UserID_DoCoMo_ImodeID extends Net_UserAgent_Mobile_UserID_Abstract
{
    public function getID()
    {
        if (array_key_exists('HTTP_X_DCMGUID', $_SERVER)) {
            $id = $_SERVER['HTTP_X_DCMGUID'];
        } else {
            $id = null;
        }

        return $id;
    }

    public function validateID($id)
    {
        if (preg_match('/^[a-z0-9]{7}$/i', $id)) {
            return true;
        } else {
            return false;
        }
    }

    protected function _parseID($id)
    {
        return array('', $id);
    }
}
