<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    /**
     * Api 컨트롤러
     * 데이터 셀렉트, 인서트, 업데이트, 삭제 등 쿼리
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("api_model");

    }

    // 회원 아이디 중복체크 - get
    public function memberIdCheck()
    {
        $result = $this->api_model->memberIdCheck();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 회원 사업자 or 생년월일 중복체크 - get
    public function memberNumberCheck()
    {
        $result = $this->api_model->memberNumberCheck();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 회원 입력 - post
    public function memberAdd()
    {
        $result = $this->api_model->memberAdd();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 회원 리스트 - get
    public function memberList(){

    }

    // 회원 상세 - get
    public function memberView($mb_seq)
    {

    }

    // 회원 수정 - post
    public function memberUpdate($mb_seq)
    {
        // $result = $this->api_model->memberUpdate();
        // $arr = array('result'=>$result);
        // echo json_encode($arr);
    }

    // 회원 삭제 - get
    public function memberDelete($mb_seq)
    {

    }
}
