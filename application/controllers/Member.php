<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Seoul');
class Member extends CI_Controller {

    /**
     * 회원 컨트롤러
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("api_model");

    }
    public function index(){
        header("Location: /member/lists");
    }

    public function lists()
    {
        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);
        $layout["content"] = $this->load->view("member/list", '',true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }

    public function setting()
    {
        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);
        $layout["content"] = $this->load->view("member/setting", '',true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }

    public function view($mb_seq)
    {
        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);

        $data["info"] = $this->api_model->selectMember($mb_seq);
        $data["service_list"] = $this->api_model->fetchMemberService($mb_seq);
        $data["payment_list"] = $this->api_model->fetchMemberPayment($mb_seq);
        $data["claim_list"] = $this->api_model->fetchPayment($mb_seq);
        // $data["basic_policy"] = $this->api_model->fetchPolicy();
        $layout["content"] = $this->load->view("member/view", $data,true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }

    public function payment_setting($mb_seq){
        $data["payment_list"] = $this->api_model->fetchMemberPayment($mb_seq);
        $data["member_view"] = $this->api_model->selectMember($mb_seq);
        $data["claim_list"] = $this->api_model->fetchClaim($mb_seq);
        $data["mb_seq"] = $mb_seq;
        $layout["content"] = $this->load->view("member/payment_setting", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }
}
