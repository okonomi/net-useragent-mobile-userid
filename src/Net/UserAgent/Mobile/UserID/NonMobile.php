<?php
require_once 'Net/UserAgent/Mobile/UserID/Abstract.php';


class Net_UserAgent_Mobile_UserID_NonMobile extends Net_UserAgent_Mobile_UserID_Abstract
{
    public function getID()
    {
        return '';
    }

    public function validateID($id)
    {
        return true;
    }

    protected function _parseID($id)
    {
        return array('', $id);
    }
}
