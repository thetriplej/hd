<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('utilcommon');
        $this->load->helper('cookie');
        $this->load->library('user_agent');


    }

    public function index()
    {

    }
    public function get_lang()
    {
        $lang_type = get_cookie('tj_lang_type');
        return $lang_type;
    }

    public function set_lang(){
        $domain = $this->config->item('base_url');
        $lang_type = get_cookie('tj_lang_type');
        $cookie = array(
            'name'   => 'lang_type',
            'value'  => 'ko',
            'expire' => 86000,
            'domain' => $domain,
            'path'   => '/',
            'prefix' => 'tj_'

        );

        if(empty($lang_type)) {
            $cookie = array(
                'name'   => 'lang_type',
                'value'  => 'ko',
                'expire' => 86000,
                'domain' => $domain,
                'path'   => '/',
                'prefix' => 'tj_'
            );
        }else{
            delete_cookie("tj_lang_type");
            if($lang_type == "ko"){
                $cookie['value'] = 'en';
            }else if($lang_type == 'en'){
                $cookie['value'] = 'ko';
            }

        }
        $this->input->set_cookie($cookie);
        //var_dump($cookie);
        redirect($this->agent->referrer());
    }



}