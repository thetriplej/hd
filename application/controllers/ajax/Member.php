<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/Common.php';
class Member extends Common {


    public function  __construct() {
        parent::__construct();

        $this->load->model(array('member_model'));
    }

    function _remap($method) {
        // ajax call아니면 차단
        if(!$this->input->is_ajax_request()){
            exit;
        }
        $this->{"{$method}"}();

    }

    public function login(){

        $post = $this->input->post(null, true);

        $send_date = array(
            'id'   =>  $post['id'],
            'password'   =>  $post['password'],
        );

        $result1 =  $this->member_model->id_check($send_date);

        if($result1){
            $result2 =  $this->member_model->login($send_date);
            if($result2){
                $newdata = array(
                    'userid'   => $result2->m_id,
                    'level'    => $result2->m_level,
                    'username' => $result2->m_name,
                );
                $this->session->set_userdata($newdata);

                $cookie = array(
                    'name'   => 'admin_mode',
                    'value'  => 'admin',
                    'expire' => '86500',
                    'path'   => '/',
                );

                set_cookie($cookie);
                echo "0";
            }else{
                echo "2";
            }
        }else{
            echo "1";
            return;
        }
    }


    public function get_permission_check(){
        $post = $this->input->post(null, true);
        $send_date = array(
            'b_index'   =>  $post['b_index']
        );

        $result =  $this->board_model->get_permission_check($send_date);
        $send_data = array();
        if($result->b_locked == 'Y'){
            $send_data['lock'] = 'Y';
        }else{
            $send_data['lock'] = 'N';
        }

        echo json_encode($send_data);
    }

    public function check_pass(){
        $post = $this->input->post(null, true);

        $send_date = array(
            'b_index'   =>  $post['b_index'],
            'b_password'   =>  $post['pass'],
        );

        $result =  $this->board_model->get_password_check($send_date);
        if($result->cnt == '1'){
            $send_result = 'success';
            $ss_data = array(
                'b_index'      	=> $post['b_index'],
                'result'       	=> 1,
                'pass'       	=> $post['pass'],

            );
            $this->session->set_userdata($ss_data);
        }else{
            $send_result = 'fail';
        }

        echo json_encode($send_result);
    }

    public function page_log(){
//            dicPath.Add "index.asp", "메인"
//			dicPath.Add "index_m.asp", "모바일메인"
//			dicPath.Add "hacom02.asp", "<font color=\""blue\"">회사소개 </font>: 회사소개 "
//			dicPath.Add "hacom03.asp", "<font color=\""blue\"">회사소개 </font>: 브랜드스토리"
//			dicPath.Add "hacom01.asp", "<font color=\""blue\"">회사소개 </font>: 인사말"
//			dicPath.Add "hacom04.asp", "<font color=\""blue\"">회사소개 </font>: 매장정보"
//			dicPath.Add "hamat01.asp", "<font color=\""blue\"">소재</font>: 엑센느 소재"
//			dicPath.Add "hamat02.asp", "<font color=\""blue\"">소재</font>: 엑센느 특장점"
//			dicPath.Add "hamat03.asp", "<font color=\""blue\"">소재</font>: 엑센느 관리"
//			dicPath.Add "hapro01.asp", "<font color=\""blue\"">제품소개</font>: BECKY"
//			dicPath.Add "hapro02.asp", "<font color=\""blue\"">제품소개</font>: FLORIA"
//			dicPath.Add "hapro03.asp", "<font color=\""blue\"">제품소개</font>: CALIX"
//			dicPath.Add "hapro04.asp", "<font color=\""blue\"">제품소개</font>: AILISH"
//			dicPath.Add "hapro05.asp", "<font color=\""blue\"">제품소개</font>: WHISTLE"
//			dicPath.Add "hapro06.asp", "<font color=\""blue\"">제품소개</font>: BESSO"
//			dicPath.Add "hapro07.asp", "<font color=\""blue\"">제품소개</font>: ARRIBA"
//			dicPath.Add "hapro08.asp", "<font color=\""blue\"">제품소개</font>: FRANCIS"
//			dicPath.Add "hapro09.asp", "<font color=\""blue\"">제품소개</font>: BAMBI"
//			dicPath.Add "hapro10.asp", "<font color=\""blue\"">제품소개</font>: ADELA"
//			dicPath.Add "hapro11.asp", "<font color=\""blue\"">제품소개</font>: ESTHER"
//			dicPath.Add "hapro12.asp", "<font color=\""blue\"">제품소개</font>: PROVENCE"
//			dicPath.Add "hapro13.asp", "<font color=\""blue\"">제품소개</font>: CRANE"
//			dicPath.Add "hapro14.asp", "<font color=\""blue\"">제품소개</font>: AMORE"
//			dicPath.Add "hapro15.asp", "<font color=\""blue\"">제품소개</font>: TWINSOFA"
//			dicPath.Add "hapro16.asp", "<font color=\""blue\"">제품소개</font>: SWINGCHAIR"
//			dicPath.Add "hapro17.asp", "<font color=\""blue\"">제품소개</font>: PRINCE"
//			dicPath.Add "haboard03.asp", "<font color=\""blue\"">갤러리</font>: 고객후기"
//			dicPath.Add "haboard01.asp", "<font color=\""blue\"">갤러리</font>: H_매거진"
//			dicPath.Add "haboard05.asp", "<font color=\""blue\"">갤러리</font>: 영상자료"
//			dicPath.Add "haboard02.asp", "<font color=\""blue\"">notice</font>: 공지사항"
//			dicPath.Add "haboard06.asp", "<font color=\""blue\"">notice</font>: FAQ"
//			dicPath.Add "haboard04.asp", "<font color=\""blue\"">notice</font>: Q&A"
//			dicPath.Add "hab2b.asp", "B2B"
//			dicPath.Add "harec.asp", "채용"
//			dicPath.Add "halaw.asp", "법률성명"
//			dicPath.Add "haPrivacy.asp", "개인정보보호정책"
//
//			dicPath.Add "ehacom02.asp", "<font color=\""blue\"">회사소개 </font>: 회사소개(Eng.) "
//			dicPath.Add "ehacom03.asp", "<font color=\""blue\"">회사소개 </font>: 브랜드스토리(Eng.)"
//			dicPath.Add "ehacom01.asp", "<font color=\""blue\"">회사소개 </font>: 인사말(Eng.)"
//			dicPath.Add "ehacom04.asp", "<font color=\""blue\"">회사소개 </font>: 매장정보(Eng.)"
//			dicPath.Add "ehamat01.asp", "<font color=\""blue\"">소재</font>: 엑센느 소재(Eng.)"
//			dicPath.Add "ehamat02.asp", "<font color=\""blue\"">소재</font>: 엑센느 특장점(Eng.)"
//			dicPath.Add "ehamat03.asp", "<font color=\""blue\"">소재</font>: 엑센느 관리(Eng.)"
//			dicPath.Add "ehapro01.asp", "<font color=\""blue\"">제품소개</font>: BECKY(Eng.)"
//			dicPath.Add "ehapro02.asp", "<font color=\""blue\"">제품소개</font>: FLORIA(Eng.)"
//			dicPath.Add "ehapro03.asp", "<font color=\""blue\"">제품소개</font>: CALIX(Eng.)"
//			dicPath.Add "ehapro04.asp", "<font color=\""blue\"">제품소개</font>: AILISH(Eng.)"
//			dicPath.Add "ehapro05.asp", "<font color=\""blue\"">제품소개</font>: WHISTLE(Eng.)"
//			dicPath.Add "ehapro06.asp", "<font color=\""blue\"">제품소개</font>: BESSO(Eng.)"
//			dicPath.Add "ehapro07.asp", "<font color=\""blue\"">제품소개</font>: ARRIBA(Eng.)"
//			dicPath.Add "ehapro08.asp", "<font color=\""blue\"">제품소개</font>: FRANCIS(Eng.)"
//			dicPath.Add "ehapro09.asp", "<font color=\""blue\"">제품소개</font>: BAMBI(Eng.)"
//			dicPath.Add "ehapro10.asp", "<font color=\""blue\"">제품소개</font>: ADELA(Eng.)"
//			dicPath.Add "ehapro11.asp", "<font color=\""blue\"">제품소개</font>: ESTHER(Eng.)"
//			dicPath.Add "ehapro12.asp", "<font color=\""blue\"">제품소개</font>: PROVENCE(Eng.)"
//			dicPath.Add "ehapro13.asp", "<font color=\""blue\"">제품소개</font>: CRANE(Eng.)"
//			dicPath.Add "ehapro14.asp", "<font color=\""blue\"">제품소개</font>: AMORE(Eng.)"
//			dicPath.Add "ehapro15.asp", "<font color=\""blue\"">제품소개</font>: TWINSOFA(Eng.)"
//			dicPath.Add "ehapro16.asp", "<font color=\""blue\"">제품소개</font>: SWINGCHAIR(Eng.)"
//			dicPath.Add "ehapro17.asp", "<font color=\""blue\"">제품소개</font>: PRINCE(Eng.)"
//			dicPath.Add "ehaboard03.asp", "<font color=\""blue\"">갤러리</font>: 고객후기(Eng.)"
//			dicPath.Add "ehaboard01.asp", "<font color=\""blue\"">갤러리</font>: H_매거진(Eng.)"
//			dicPath.Add "ehaboard05.asp", "<font color=\""blue\"">갤러리</font>: 영상자료(Eng.)"
//			dicPath.Add "ehaboard02.asp", "<font color=\""blue\"">notice</font>: 공지사항(Eng.)"
//			dicPath.Add "ehaboard06.asp", "<font color=\""blue\"">notice</font>: FAQ(Eng.)"
//			dicPath.Add "ehaboard04.asp", "<font color=\""blue\"">notice</font>: Q&A(Eng.)"
//			dicPath.Add "ehab2b.asp", "B2B(Eng.)"
//			dicPath.Add "eharec.asp", "채용(Eng.)"
//			dicPath.Add "ehalaw.asp", "법률성명(Eng.)"
//			dicPath.Add "ehaPrivacy.asp", "개인정보보호정책(Eng.)"
    }








}
