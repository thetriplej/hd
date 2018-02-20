<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilcommon {

    public function get_mobile_check() {
        if ( preg_match('/(iPhone|Android|iPod|iPad|BlackBerry|IEMobile|HTC|Server_KO_SKT|SonyEricssonX1|SKT)/',$_SERVER['HTTP_USER_AGENT']) )
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }



}