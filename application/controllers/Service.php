<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Seoul');
class Service extends CI_Controller {

    /**
     * 회원 컨트롤러
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("api_model");
        $this->load->model("service_model");
    }

    public function estimate()
    {
        $data["category"] = $this->api_model->productCategoryList();
        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);
        $layout["content"] = $this->load->view("estimate/list", $data,true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }

    public function register()
    {
        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);
        $layout["content"] = $this->load->view("service/register", '',true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }

    public function list()
    {
        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);
        $layout["content"] = $this->load->view("service/list", '',true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }

    public function make()
    {
        $data["product_category"] = $this->api_model->productCategoryList();
        $data["basic_policy"] = $this->api_model->fetchPolicy();
        // print_r($data["basic_policy"]);

        $last_code = explode("-",$this->api_model->serviceNextCode());

        $code_first = substr($last_code[0],0,2);
        $code_number = substr($last_code[0],2,6);

        $next_number = str_pad(++$code_number,6,"0",STR_PAD_LEFT);
        // echo $next_number;
        // if($next_number == "0000"){
        //     $next_first = ++$code_first;
        // }else{
        $next_first = $code_first;
        // }

        $data["code1"] = $next_first.$next_number;
        $data["code2"] = $last_code[1];

        $layout["content"] = $this->load->view("service/make", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }

    public function edit($seq)
    {
        $data["product_category"] = $this->api_model->productCategoryList();
        // $data["basic_policy"] = $this->api_model->fetchPolicy();
        $data["service"] = $this->service_model->selectServiceRegister($seq);
        $data["service_price"] = $this->service_model->selectServiceRegisterPrice($seq);
        $data["service_option"] = $this->service_model->selectServiceRegisterOption($seq);
        // print_r($data["service_option"]);
        $layout["content"] = $this->load->view("service/edit", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }

    public function allCategory(){
        $category = $this->api_model->productCategoryList();
        $html = "";
        foreach($category as $row){
            $html .= '<div class="searchStep1" data-tag="'.$row["pc_name"].'" data-step="1">
                        <div style="width:100%"><input type="checkbox" name="pc_seq[]" value="'.$row["pc_seq"].'" class="pc_seq">'.$row["pc_name"].'</div>';
            $productItem = $this->api_model->fetchProductSearch($row["pc_seq"]);
            foreach($productItem as $pi_row){
                $html .= '<div class="searchStep2" data-tag="'.$row["pc_name"].'|'.$pi_row["pi_name"].'" data-step="2">
                            <input type="checkbox" name="pi_seq[]" value="'.$pi_row["pi_seq"].'" class="pc_seq_'.$row["pc_seq"].' pi_seq"> '.$pi_row["pi_name"];
                $productDiv = $this->api_model->fetchProductDiv($row["pc_seq"]);

                foreach($productDiv as $pd_row){
                    $html .= '<div class="searchStep3" data-tag="'.$row["pc_name"].'|'.$pi_row["pi_name"].'|'.$pd_row["pd_name"].'" data-step="3">
                                <input type="checkbox" name="pd_seq[]" value="'.$pd_row["pd_seq"].'" class="pi_seq_'.$pi_row["pi_seq"].' pd_seq"> '.$pd_row["pd_name"];
                    $productDivSub = $this->api_model->fetchProductDivSub($pd_row["pd_seq"]);

                    foreach($productDivSub as $ps_row){
                        $html .= '<div class="searchStep4" data-tag="'.$row["pc_name"].'|'.$pi_row["pi_name"].'|'.$pd_row["pd_name"].'|'.$ps_row["ps_name"].'" data-step="4">
                                    <input type="checkbox" name="ps_seq[]" value="'.$ps_row["ps_seq"].'" class="pd_seq_'.$pi_row["pi_seq"].'"> '.$ps_row["ps_name"].'
                                </div>';
                    }
                    $html .= '</div>';
                }
                $html .= "</div>";
            }
            $html .= '</div>';

        }

        echo $html;
    }
}
