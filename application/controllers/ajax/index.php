<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }


    function _remap($method) {

        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()) exit;
        $this->{$method}();
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
        $this->input->set_cookie($cookie);
        $lang_type = get_cookie('tj_lang_type');
        if($lang_type != $cookie['value']){
            $result = "OK";
        }else{
            $result = "fail";
        }
        echo $result;

    }



}