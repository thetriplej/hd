<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilcommon{

//    public function get_mobile_check() {
//        if ( preg_match('/(iPhone|Android|iPod|iPad|BlackBerry|IEMobile|HTC|Server_KO_SKT|SonyEricssonX1|SKT)/',$_SERVER['HTTP_USER_AGENT']) )
//        {
//            return TRUE;
//        }else{
//            return FALSE;
//        }
//    }

    public function get_lang()
    {
        $lang_type = get_cookie('tj_lang_type');
        return $lang_type;
    }
    public function set_lang()
    {
        $domain = $_SERVER["HTTP_HOST"];
        $lang_type = get_cookie('tj_lang_type');
        $cookie = array(
            'name' => 'lang_type',
            'value' => 'ko',
            'expire' => 86000,
            'domain' => $domain,
            'path' => '/',
            'prefix' => 'tj_'

        );

        if (empty($lang_type)) {
            $cookie = array(
                'name' => 'lang_type',
                'value' => 'ko',
                'expire' => 86000,
                'domain' => $domain,
                'path' => '/',
                'prefix' => 'tj_'
            );
        } else {
            delete_cookie("tj_lang_type");
            if ($lang_type == "ko") {
                $cookie['value'] = 'en';
            } else if ($lang_type == 'en') {
                $cookie['value'] = 'ko';
            }

        }

        set_cookie($cookie);
        $lang_type = get_cookie('tj_lang_type');
        if($lang_type != $cookie['value']){
            $result = "OK";
        }else{
            $result = "fail";
        }
        return $result;

    }

    public function set_visit()
    {
        $domain = $_SERVER["HTTP_HOST"];
        $visit_type = get_cookie('tj_visit_log');
        $cookie = array(
            'name' => 'visit_log',
            'value' => 'true',
            'expire' => 86000,
            'domain' => $domain,
            'path' => '/',
            'prefix' => 'tj_'

        );

        set_cookie('tj_visit_log','true',86000);
        $visit_type = get_cookie('tj_visit_log');
        if($visit_type){
            $result = "OK";
        }else{
            $result = "fail";
        }
        return $result;

    }

    public function masking($_type, $_data){
        $_data = str_replace('-','',$_data);
        $strlen = mb_strlen($_data, 'utf-8');
        $maskingValue = "";

        $useHyphen = "-";

        if($_type == 'N'){
            switch($strlen){
//                case 2:
//                    $maskingValue = mb_strcut($_data, 0, 3, "UTF-8").' * ';
//                    break;
//                case 3:
//                    $maskingValue = mb_strcut($_data, 0, 3, "UTF-8").' * '.mb_strcut($_data, 8, 11, "UTF-8");
//                    break;
//                case 4:
//                    $maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'**'.mb_strcut($_data, 12, 15, "UTF-8");
//                    break;
//                default:
//                    $maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'**'.mb_strcut($_data, 12, 15, "UTF-8");
//                    break;
                case 2:
                    $maskingValue = mb_substr($_data, 0, 1, "UTF-8").' * ';
                    break;
                case 3:
                    $maskingValue = mb_substr($_data, 0, 1, "UTF-8").' * '.mb_substr($_data, 2, 11, "UTF-8");
                    break;
                case 4:
                    $maskingValue = mb_substr($_data, 0, 1, "UTF-8").' * '.mb_substr($_data, 2, 15, "UTF-8");
                    break;
                default:
                    $maskingValue = mb_substr($_data, 0, 1, "UTF-8").' * '.mb_substr($_data, 2, 15, "UTF-8");;
                    break;
            }
        }else if($_type == 'P'){
            switch($strlen){
                case 10:
                    $maskingValue = mb_substr($_data, 0, 3)."{$useHyphen}***{$useHyphen}".mb_substr($_data, 6, 4);
                    break;
                case 11:
                    $maskingValue = mb_substr($_data, 0, 3)."{$useHyphen}****{$useHyphen}".mb_substr($_data, 7, 4);
                    break;
                default:
                    trigger_error('Not a known format parametter in function', E_USER_NOTICE);
                    break;
            }
        }else{
            trigger_error('Masking Function Parameter Error', E_USER_NOTICE);
        }
        return $maskingValue;
    }





}