<?php
require_once 'Net/UserAgent/Mobile/UserID/Exception.php';


class Net_UserAgent_Mobile_UserID
{
    protected $prefix;

    protected $id;

    protected $rawdata;


    static protected $modules = array(
        'DoCoMo' => array(
            'ImodeID',
            'SerialNumber_FomaCard',
            'SerialNumber_Device',
        ),
        'SoftBank' => array(
            'UID',
            'SerialNumber',
        ),
        'EZweb' => array(
            'SubscriberID',
        ),
        'Emobile' => array(
            'UID',
        ),
        'Willcom' => array(
        ),
        'NonMobile' => array(
            null,
        ),
    );


    function __construct()
    {
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getRawData()
    {
        return $this->rawdata;
    }


    static public function factory(&$agent = null)
    {
        if (is_null($agent)) {
            include_once 'Net/UserAgent/Mobile.php';
            $agent =& Net_UserAgent_Mobile::singleton();
        }

        switch (true) {
        case $agent->isDoCoMo():
            $carrier = 'DoCoMo';
            break;
        case $agent->isSoftBank():
            $carrier = 'SoftBank';
            break;
        case $agent->isEZweb():
            $carrier = 'EZweb';
            break;
//      case $agent->isEmobile():
//          $carrier = 'Emobile';
//          break;
        case $agent->isWillcom():
            $carrier = 'Willcom';
            break;
        case $agent->isNonMobile():
            $carrier = 'NonMobile';
            break;
        default:
            throw new Net_UserAgent_Mobile_UserID_Exception();
            break;
        }

        $userid = new Net_UserAgent_Mobile_UserID();

        foreach (self::$modules[$carrier] as $module) {
            try {
                if ($module instanceof Net_UserAgent_Mobile_UserID_Abstract) {
                    $instance = $module;
                } else {
                    $class = 'Net_UserAgent_Mobile_UserID_'.$carrier;
                    if ($module !== null) {
                        $class .= '_'.$module;
                    }
                    $filename = str_replace('_', '/', $class).'.php';

                    require_once $filename;

                    $instance = new $class();
                }


                list($userid->prefix, $userid->id, $userid->rawdata) = $instance->parseID();
                break;
            } catch (Net_UserAgent_Mobile_UserID_Exception $e) {
                continue;
            }
        }

        return $userid;
    }

    static public function setUserIDModules($carrier, $modules)
    {
        if (!is_array($modules)) {
            $modules = array($modules);
        }

        self::$modules[$carrier] = $modules;
    }
}
