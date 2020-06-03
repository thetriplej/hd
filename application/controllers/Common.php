<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library(array('utilcommon', 'user_agent', 'pagination','session'));
        $this->load->model(array('member_model','board_model','visit_model'));

        if($this->agent->is_mobile()){
            $agent_mode = "2";  //mobile
        }else{
            $agent_mode = "1";
        }
        $this->agent_mode = $agent_mode;
        $this->lang_type = get_cookie('tj_lang_type');

        if(empty($this->lang_type)) {
            $this->utilcommon->set_lang();
            $this->lang_type = get_cookie('tj_lang_type');
        }

        if(empty(get_cookie('tj_visit_log'))) {
            $this->visit_log($agent_mode);
        }
        $this->visit_log = get_cookie('tj_visit_log');

        $this->temp_uri = explode('&', $_SERVER['REQUEST_URI']);
        $this->view_uri = $_SERVER["HTTP_HOST"].$this->temp_uri[0];



        if ($this->agent->is_referral()){

            $referrer = $this->agent->referrer();

            $this->set_referrer($referrer,$agent_mode);
        }


        if(empty($this->session->userdata('userid'))) {
            if (!$this->input->is_ajax_request()) {
                $this->page_log($this->lang_type, $agent_mode);
            }
        }


    }
    public function set_referrer($referrer,$agent_mode){

        $temp_uri = explode('/', $referrer);
        if(!empty($referrer) && $temp_uri[2] != $_SERVER['SERVER_NAME']) {
            $send_data = array(
                'domain' => $temp_uri[2],
                'url'       => $referrer,
                'agent_type'    => $agent_mode,

            );

            $result = $this->visit_model->set_referrer($send_data);
        }
    }
    public function visit_log($agent_mode){
        $send_data = array(
            'user_ip'       => $_SERVER['REMOTE_ADDR'],
            'agent_mode'    => $agent_mode,
        );
        $result = $this->visit_model->set_visit_log($send_data);
        if($result) {
            $this->utilcommon->set_visit();
        }
    }
    public function page_log($lang_type,$agent_mode){

        $uri = $_SERVER['REQUEST_URI'];

        if($lang_type == "ko"){
            $lang_name = "";
            $add_uri = "";
        }else if($lang_type == "en"){
            $lang_name = " (Eng)";
            $add_uri = "/eng";
        }else{
            $lang_type = "";
            $lang_name = "";
            $add_uri = "";
        }

        $send_data = array(
            'url'           => $uri.$add_uri,
            'agent_mode'    => $agent_mode,
            'lang_type'    => $lang_type,
        );
        $result = $this->visit_model->get_log_check($send_data);

        if($agent_mode == "2"){
            $agent_name = "(M) ";
        }else{
            $agent_name = "";
        }

        if(empty($result)) {
            $uri_array = array(
                "/" => "<font color='blue'>".$agent_name."메인</font>".$lang_name,
                "/about/company" => "<font color='blue'>".$agent_name."회사소개</font> - 회사소개".$lang_name,
                "/about/brand" => "<font color='blue'>".$agent_name."회사소개</font> - 브랜드스토리".$lang_name,
                "/about/ceo" => "<font color='blue'>".$agent_name."회사소개</font> - 인사말".$lang_name,
                "/about/shop_info" => "<font color='blue'>".$agent_name."회사소개</font>  - 매장정보".$lang_name,
                "/ecsaine/material" => "<font color='blue'>".$agent_name."소재</font> - 엑센느 소재".$lang_name,
                "/ecsaine/strongpoint" => "<font color='blue'>".$agent_name."소재</font> - 엑센느 특장점".$lang_name,
                "/ecsaine/maintain" => "<font color='blue'>".$agent_name."소재</font> - 엑센느 관리".$lang_name,
                "/product" => "<font color='blue'>".$agent_name."제품랜딩페이지</font> ".$lang_name,
                "/product/detail_view?code=becky" => "<font color='blue'>".$agent_name."제품소개</font> - BECKY".$lang_name,
                "/product/detail_view?code=arriba" => "<font color='blue'>".$agent_name."제품소개</font> - FLORIA".$lang_name,
                "/product/detail_view?code=calix" => "<font color='blue'>".$agent_name."제품소개</font> - CALIX".$lang_name,
                "/product/detail_view?code=ailish" => "<font color='blue'>".$agent_name."제품소개</font> - AILISH".$lang_name,
                "/product/detail_view?code=whistle" => "<font color='blue'>".$agent_name."제품소개</font> - WHISTLE".$lang_name,
                "/product/detail_view?code=besso" => "<font color='blue'>".$agent_name."제품소개</font> - BESSO".$lang_name,
                "/product/detail_view?code=floria" => "<font color='blue'>".$agent_name."제품소개</font> - ARRIBA".$lang_name,
                "/product/detail_view?code=francis" => "<font color='blue'>".$agent_name."제품소개</font> - FRANCIS".$lang_name,
                "/product/detail_view?code=bambi" => "<font color='blue'>".$agent_name."제품소개</font> - BAMBI".$lang_name,
                "/product/detail_view?code=adela" => "<font color='blue'>".$agent_name."제품소개</font> - ADELA".$lang_name,
                "/product/detail_view?code=esther" => "<font color='blue'>".$agent_name."제품소개</font> - ESTHER".$lang_name,
                "/product/detail_view?code=provence" => "<font color='blue'>".$agent_name."제품소개</font> - PROVENCE".$lang_name,
                "/product/detail_view?code=crane" => "<font color='blue'>".$agent_name."제품소개</font> - CRANE".$lang_name,
                "/product/detail_view?code=amore" => "<font color='blue'>".$agent_name."제품소개</font> - AMORE".$lang_name,
                "/product/detail_view?code=twinsofa" => "<font color='blue'>".$agent_name."제품소개</font> - TWINSOFA".$lang_name,
                "/product/detail_view?code=swingchair" => "<font color='blue'>".$agent_name."제품소개</font> - SWINGCHAIR".$lang_name,
                "/product/detail_view?code=mors" => "<font color='blue'>".$agent_name."제품소개</font> - Mors".$lang_name,
                "/product/detail_view?code=settle2" => "<font color='blue'>".$agent_name."제품소개</font> - Settle2".$lang_name,
                "/product/detail_view?code=settle3" => "<font color='blue'>".$agent_name."제품소개</font> - Settle3".$lang_name,
                "/product/detail_view?code=adams" => "<font color='blue'>".$agent_name."제품소개</font> - Adams".$lang_name,
                "/product/detail_view?code=anjoo_sofa" => "<font color='blue'>".$agent_name."제품소개</font> - Anjoo_sofa".$lang_name,
                "/product/detail_view?code=veronica" => "<font color='blue'>".$agent_name."제품소개</font> - Veronica".$lang_name,
                "/product/detail_view?code=peradi" => "<font color='blue'>".$agent_name."제품소개</font> - Peradi".$lang_name,
                "/product/detail_view?code=anjoo_bed" => "<font color='blue'>".$agent_name."제품소개</font> - Anjoo_bed".$lang_name,
                "/product/detail_view?code=amier" => "<font color='blue'>".$agent_name."제품소개</font> - Amier".$lang_name,
                "/product/detail_view?code=nubeca" => "<font color='blue'>".$agent_name."제품소개</font> - Nubeca".$lang_name,
                "/product/detail_view?code=arponio" => "<font color='blue'>".$agent_name."제품소개</font> - Arponio".$lang_name,
                "/product/detail_view?code=miner" => "<font color='blue'>".$agent_name."제품소개</font> - Miner".$lang_name,
                "/product/detail_view?code=peanut" => "<font color='blue'>".$agent_name."제품소개</font> - Peanut".$lang_name,
                "/product/detail_view?code=offe" => "<font color='blue'>".$agent_name."제품소개</font> - Offe".$lang_name,
                "/product/detail_view?code=feecore" => "<font color='blue'>".$agent_name."제품소개</font> - Feecore".$lang_name,
                "/product/detail_view?code=cozzy" => "<font color='blue'>".$agent_name."제품소개</font> - Cozzy".$lang_name,
                "/product/detail_view?code=haesta" => "<font color='blue'>".$agent_name."제품소개</font> - Haesta".$lang_name,
                "/product/detail_view?code=pippi" => "<font color='blue'>".$agent_name."제품소개</font> - Pippi".$lang_name,
                "/product/detail_view?code=fliche" => "<font color='blue'>".$agent_name."제품소개</font> - Fliche".$lang_name,
                "/product/detail_view?code=brise" => "<font color='blue'>".$agent_name."제품소개</font> - Brise".$lang_name,
                "/product/detail_view?code=august" => "<font color='blue'>".$agent_name."제품소개</font> - August".$lang_name,
                "/product/detail_view?code=olo" => "<font color='blue'>".$agent_name."제품소개</font> - Olo".$lang_name,
                "/product/detail_view?code=mobilian" => "<font color='blue'>".$agent_name."제품소개</font> - Mobilian".$lang_name,
                "/product/detail_view?code=lavien" => "<font color='blue'>".$agent_name."제품소개</font> - Lavien".$lang_name,
                "/product/detail_view?code=boheme" => "<font color='blue'>".$agent_name."제품소개</font> - BOHEME".$lang_name,
                "/gallery/customer" => "<font color='blue'>".$agent_name."갤러리</font> - 고객후기".$lang_name,
                "/gallery/hmagajine" => "<font color='blue'>".$agent_name."갤러리</font> - H_매거진".$lang_name,
                "/notice/notice" => "<font color='blue'>".$agent_name."notice</font> - 공지사항".$lang_name,
                "/notice/faq" => "<font color='blue'>".$agent_name."notice</font> - FAQ".$lang_name,
                "/notice/qna" => "<font color='blue'>".$agent_name."notice</font> - Q&A".$lang_name,
                "/other/b2b" => "<font color='blue'>".$agent_name."B2B</font>".$lang_name,
                "/other/recruit" => "<font color='blue'>".$agent_name."채용</font>".$lang_name,
                "/other/law" => "<font color='blue'>".$agent_name."법률성명</font>".$lang_name,
                "/other/privacy" => "<font color='blue'>".$agent_name."개인정보보호정책</font>".$lang_name,
            );
            if(array_key_exists($uri, $uri_array)) {
                $send_data['l_title'] = $uri_array[$uri];
            }else{
                return;
            }
            $send_data['type'] = "insert";

        }else{
            $send_data['type'] = "update";
        }
        $result = $this->visit_model->set_log($send_data);
    }

    public function index()
    {

    }








}