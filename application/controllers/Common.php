<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library(array('utilcommon', 'user_agent', 'pagination','session'));


        if ($this->utilcommon->get_mobile_check() === true) {
            //  echo "<script>alert('mobile')</script>";
        } else {
            //   echo "<script>alert('PC')</script>";
        }

        //var_dump($this->agent->referrer());
        if(empty(get_cookie('tj_lang_type'))) {
            $this->set_lang();
        }
        $this->lang_type = get_cookie('tj_lang_type');
        $this->temp_uri = explode('&', $_SERVER['REQUEST_URI']);
        $this->view_uri = $_SERVER["HTTP_HOST"].$this->temp_uri[0];


    }

    public function index()
    {

    }

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
        $this->input->set_cookie($cookie);

        redirect($this->agent->referrer());
    }






}