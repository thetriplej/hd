<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Product extends Common {


    public function  __construct() {
        parent::__construct();

    }

    function _remap($method) {

        if($this->agent_mode == "1") {
            $this->type ="";
            if ($this->lang_type == 'en') {
                $this->load->view('e_frame_top.phtml');
                $this->{$method}();
                $this->load->view('e_frame_bottom.phtml');
            } else {
                $this->load->view('frame_top.phtml');
                $this->{$method}();
                $this->load->view('frame_bottom.phtml');
            }

        }else{
            $this->type ="m/";
            $this->load->view('m_frame_top.phtml');
            $this->{$method}();
            $this->load->view('m_frame_bottom.phtml');

        }
    }

    public function index()
    {
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_productmain.phtml');
        }else{
            $this->load->view($this->type.'product/productmain.phtml');
        }
    }
    public function detail_view()
    {
        if($this->lang_type == 'en') {
            $lang_type = 'e_';
        }else{
            $lang_type='';
        }
        $type = $this->input->get('code');
        switch ($type) {
            case 'becky' :
                $this->load->view($this->type.'product/'.$lang_type.'becky.phtml');
                break;
            case 'arriba' :
                $this->load->view($this->type.'product/'.$lang_type.'arriba.phtml');
                break;
            case 'calix' :
                $this->load->view($this->type.'product/'.$lang_type.'calix.phtml');
                break;
            case 'ailish' :
                $this->load->view($this->type.'product/'.$lang_type.'ailish.phtml');
                break;
            case 'whistle' :
                $this->load->view($this->type.'product/'.$lang_type.'whistle.phtml');
                break;
            case 'besso' :
                $this->load->view($this->type.'product/'.$lang_type.'besso.phtml');
                break;
            case 'floria' :
                $this->load->view($this->type.'product/'.$lang_type.'floria.phtml');
                break;
            case 'francis' :
                $this->load->view($this->type.'product/'.$lang_type.'francis.phtml');
                break;
            case 'bambi' :
                $this->load->view($this->type.'product/'.$lang_type.'bambi.phtml');
                break;
            case 'adela' :
                $this->load->view($this->type.'product/'.$lang_type.'adela.phtml');
                break;
            case 'esther' :
                $this->load->view($this->type.'product/'.$lang_type.'esther.phtml');
                break;
            case 'provence' :
                $this->load->view($this->type.'product/'.$lang_type.'provence.phtml');
                break;
            case 'crane' :
                $this->load->view($this->type.'product/'.$lang_type.'crane.phtml');
                break;
            case 'amore' :
                $this->load->view($this->type.'product/'.$lang_type.'amore.phtml');
                break;
            case 'twinsofa' :
                $this->load->view($this->type.'product/'.$lang_type.'twinsofa.phtml');
                break;
            case 'swingchair' :
                $this->load->view($this->type.'product/'.$lang_type.'swingchair.phtml');
            break;
            case 'mors' :
                $this->load->view($this->type.'product/'.$lang_type.'mors.phtml');
                break;
            case 'settle2' :
                $this->load->view($this->type.'product/'.$lang_type.'settle2.phtml');
                break;
            case 'settle3' :
                $this->load->view($this->type.'product/'.$lang_type.'settle3.phtml');
                break;
            case 'adams' :
                $this->load->view($this->type.'product/'.$lang_type.'adams.phtml');
                break;
            case 'anjoo_sofa' :
                $this->load->view($this->type.'product/'.$lang_type.'anjoo_sofa.phtml');
                break;
            case 'veronica' :
                $this->load->view($this->type.'product/'.$lang_type.'veronica.phtml');
                break;
            case 'peradi' :
                $this->load->view($this->type.'product/'.$lang_type.'peradi.phtml');
                break;
            case 'anjoo_bed' :
                $this->load->view($this->type.'product/'.$lang_type.'anjoo_bed.phtml');
                break;
            case 'amier' :
                $this->load->view($this->type.'product/'.$lang_type.'amier.phtml');
                break;
            case 'nubeca' :
                $this->load->view($this->type.'product/'.$lang_type.'nubeca.phtml');
                break;
            case 'arponio' :
                $this->load->view($this->type.'product/'.$lang_type.'arponio.phtml');
                break;
            case 'miner' :
                $this->load->view($this->type.'product/'.$lang_type.'miner.phtml');
                break;
            case 'peanut' :
                $this->load->view($this->type.'product/'.$lang_type.'peanut.phtml');
                break;
            case 'offe' :
                $this->load->view($this->type.'product/'.$lang_type.'offe.phtml');
                break;
            case 'feecore' :
                $this->load->view($this->type.'product/'.$lang_type.'feecore.phtml');
                break;
            case 'cozzy' :
                $this->load->view($this->type.'product/'.$lang_type.'cozzy.phtml');
                break;
            case 'haesta' :
                $this->load->view($this->type.'product/'.$lang_type.'haesta.phtml');
                break;
            case 'pippi' :
                $this->load->view($this->type.'product/'.$lang_type.'pippi.phtml');
                break;
            case 'fliche' :
                $this->load->view($this->type.'product/'.$lang_type.'fliche.phtml');
                break;
            case 'brise' :
                $this->load->view($this->type.'product/'.$lang_type.'brise.phtml');
                break;
            case 'august' :
                $this->load->view($this->type.'product/'.$lang_type.'august.phtml');
                break;
            case 'olo' :
                $this->load->view($this->type.'product/'.$lang_type.'olo.phtml');
                break;
            case 'mobilian' :
                $this->load->view($this->type.'product/'.$lang_type.'mobilian.phtml');
                break;
            case 'lavien' :
                $this->load->view($this->type.'product/'.$lang_type.'lavien.phtml');
                break;
            case 'boheme' :
                $this->load->view($this->type.'product/'.$lang_type.'boheme.phtml');
                break;
//            case 'becky' :
//                $this->load->view($this->type.'product/'.$lang_type.'becky.phtml');
//                break;
//            case 'becky' :
//                $this->load->view($this->type.'product/'.$lang_type.'becky.phtml');
//                break;
//            case 'becky' :
//                $this->load->view($this->type.'product/'.$lang_type.'becky.phtml');
//                break;
//            case 'becky' :
//                $this->load->view($this->type.'product/'.$lang_type.'becky.phtml');
//                break;
//            case 'becky' :
//                $this->load->view($this->type.'product/'.$lang_type.'becky.phtml');
//                break;

        }
    }

    public function noname01(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname01.phtml');
        }else{
            $this->load->view($this->type.'product/noname01.phtml');
        }
    }

    public function noname02(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname02.phtml');
        }else{
            $this->load->view($this->type.'product/noname02.phtml');
        }
    }

    public function noname03(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname03.phtml');
        }else{
            $this->load->view($this->type.'product/noname03.phtml');
        }
    }

    public function noname04(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname04.phtml');
        }else{
            $this->load->view($this->type.'product/noname04.phtml');
        }
    }

    public function noname05(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname05.phtml');
        }else{
            $this->load->view($this->type.'product/noname05.phtml');
        }
    }

    public function noname06(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname06.phtml');
        }else{
            $this->load->view($this->type.'product/noname06.phtml');
        }
    }

    public function noname07(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname07.phtml');
        }else{
            $this->load->view($this->type.'product/noname07.phtml');
        }
    }

    public function noname08(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname08.phtml');
        }else{
            $this->load->view($this->type.'product/noname08.phtml');
        }
    }

    public function noname09(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname09.phtml');
        }else{
            $this->load->view($this->type.'product/noname09.phtml');
        }
    }

    public function noname10(){
        if($this->lang_type == 'en') {
            $this->load->view($this->type.'product/e_noname10.phtml');
        }else{
            $this->load->view($this->type.'product/noname10.phtml');
        }
    }

}
