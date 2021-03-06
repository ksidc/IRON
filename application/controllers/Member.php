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
        $data["category_list"] = $this->api_model->productCategoryList();
        $layout["content"] = $this->load->view("member/list", $data,true);
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
        $data["eosec_view"] = $this->api_model->selectMember(21);
        // $data["service_list"] = $this->api_model->fetchMemberService($mb_seq);
        // $data["payment_list"] = $this->api_model->fetchMemberPayment($mb_seq);
        // $data["claim_list"] = $this->api_model->fetchPayment($mb_seq);
        $data["paycom_list"] = $this->api_model->fetchPaymentPaycom($mb_seq);
        // $data["basic_policy"] = $this->api_model->fetchPolicy();
        $layout["content"] = $this->load->view("member/view", $data,true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }

    public function payment_setting($mb_seq){
        $data["payment_list"] = $this->api_model->fetchMemberPaymentClaim($mb_seq);
        $data["member_view"] = $this->api_model->selectMember($mb_seq);
        $data["eosec_view"] = $this->api_model->selectMember(21);
        $data["claim_list"] = $this->api_model->fetchClaim($mb_seq);
        // print_r($data["claim_list"]);
        $data["mb_seq"] = $mb_seq;
        $layout["content"] = $this->load->view("member/payment_setting", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }

    public function payment_view($svp_seq){
        $data["info"] = $this->api_model->memberPaymentView($svp_seq);
        if($data["info"]["svp_sva_seq"] != ""){

            $layout["content"] = $this->load->view("member/payment_view_add", $data,true);
        }else{
            $data["add_list"] = $this->api_model->memberPaymentViewAdd($data["info"]["svp_sv_seq"]);
            $layout["content"] = $this->load->view("member/payment_view", $data,true);
        }

        $this->load->view('layout/layout_popup',$layout);
    }

    public function claim_view($pm_seq,$sv_type){
        if($sv_type == "1"){
            $data["info"] = $this->api_model->paymentView($pm_seq);
        }else{
            $data["info"] = $this->api_model->paymentViewAdd($pm_seq);
        }

        if($data["info"]["pm_sva_seq"] != ""){
            $layout["content"] = $this->load->view("member/claim_view_add", $data,true);
        }else{
            $layout["content"] = $this->load->view("member/claim_view", $data,true);
        }
        $this->load->view('layout/layout_popup',$layout);
    }

    public function claim_view_once($pm_seq){
        $data["info"] = $this->api_model->paymentView($pm_seq);
        $layout["content"] = $this->load->view("member/claim_view_once", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }

    public function paycom_view($pm_seq){
        $data["info"] = $this->api_model->paymentView($pm_seq);
        $layout["content"] = $this->load->view("member/paycom_view", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }

    public function paycom_view_once($pm_seq){
        $data["info"] = $this->api_model->paymentView($pm_seq);
        $layout["content"] = $this->load->view("member/paycom_view_once", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }
}
