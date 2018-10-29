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

    public function view($sv_seq)
    {
        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);
        $data["info"] = $this->service_model->selectService($sv_seq);
        // 마지막 결제
        $data["payment"] = $this->service_model->selectPaymentLast($sv_seq);
        $data["memberInfo"] = $this->api_model->selectMember($data["info"]["sv_mb_seq"]);
        // $data["logList"] = $this->api_model->fetchLogs('2',$sv_seq);
        // echo $sv_seq;
        //첨부파일
        $data["files"] = $this->service_model->serviceFileAllFetch($sv_seq);
        $layout["content"] = $this->load->view("service/view", $data,true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }

    public function product_view($sv_seq)
    {
        $data["product_category"] = $this->api_model->productCategoryList();
        $data["info"] = $this->service_model->selectService($sv_seq);
        $layout["content"] = $this->load->view("service/product_view", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }

    public function numberGroupView($sv_code){
        $sv_code = explode("-",$sv_code);
        $data["sv_code"] = $sv_code[0];
        $data["list"] = $this->service_model->fetchServiceCode($sv_code[0]);
        $data["history_list"] = $this->service_model->fetchServiceHistory($sv_code[0]);
        $array1 = array(); // enduser
        $array2 = array(); // company type
        $array3 = array(); // team
        $array4 = array(); // charger
        $array5 = array(); // service start
        $array6 = array(); // service end
        $array7 = array(); // auto
        $array8 = array(); // auto day
        $sv_seq = array();
        foreach($data["list"] as $row){
            array_push($sv_seq,$row["sv_seq"]);
            array_push($array1,$row["sv_eu_seq"]);
            array_push($array2,$row["sv_ct_seq"]);
            array_push($array3,$row["sv_part"]);
            array_push($array4,$row["sv_charger"]);
            array_push($array5,$row["sv_contract_start"]);
            array_push($array6,$row["sv_contract_end"]);
            array_push($array7,$row["sv_auto_extension"]);
            array_push($array8,$row["sv_auto_extension_month"]);
        }
        $result1 = array_unique($array1);
        $result2 = array_unique($array2);
        $result3 = array_unique($array3);
        $result4 = array_unique($array4);
        $result5 = array_unique($array5);
        $result6 = array_unique($array6);
        $result7 = array_unique($array7);
        $result8 = array_unique($array8);
        $data["same1"] = true;
        $data["same2"] = true;
        $data["same3"] = true;
        $data["same4"] = true;
        $data["same5"] = true;

        if(count($result1) > 1){
            $data["same1"] = false;
        }
        if(count($result2) > 1){
            $data["same2"] = false;
        }
        if(count($result3) > 1){
            $data["same3"] = false;
        }
        if(count($result4) > 1){
            $data["same3"] = false;
        }
        if(count($result5) > 1){
            $data["same4"] = false;
        }
        if(count($result6) > 1){
            $data["same4"] = false;
        }
        if(count($result7) > 1){
            $data["same5"] = false;
        }else{
            if(count($result8) > 1){
                $data["same5"] = false;
            }
        }
        $data["sv_seq"] = implode(",",$sv_seq);
        $layout["content"] = $this->load->view("service/group_view", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }

    public function make()
    {
        $data["product_category"] = $this->api_model->productCategoryList();
        $data["basic_policy"] = $this->api_model->fetchPolicy();
        // print_r($data["basic_policy"]);

        $last_code = explode("-",$this->api_model->serviceNextCode());
        // print_r($last_code);
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
        $data["code2"] = "01";

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
        foreach($category as $key => $row){
            if($key%2 == 0){
                $background = "style='background:#f2f2f2'";
            }else{
                $background = "";
            }
            $html .= '<div class="searchStep1" data-tag="'.$row["pc_name"].'" data-step="1" '.$background.'>
                        <div style="width:100%;font-weight:900"><input type="checkbox" name="pc_seq[]" value="'.$row["pc_seq"].'" class="pc_seq">'.$row["pc_name"].'</div>';
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
                        $html .= '<div class="searchStep4" data-tag="'.$row["pc_name"].'|'.$pi_row["pi_name"].'|'.$pd_row["pd_name"].'|'.$ps_row["ps_name"].'" data-parent1="'.$row["pc_name"].'" data-parent2="'.$pi_row["pi_name"].'" data-parent3="'.$pd_row["pd_name"].'" data-parent4="'.$ps_row["ps_name"].'" data-step="4">
                                    <input type="checkbox" name="ps_seq[]" value="'.$ps_row["ps_seq"].'" class="pd_seq_'.$pi_row["pi_seq"].' ps_seq"> '.$ps_row["ps_name"].'
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

    public function allProduct(){
        $category = $this->api_model->productCategoryList();
        $html = "<table cellpadding=0 cellspacing=0 border=0 style='width:100%;'>";
        foreach($category as $key => $row){
            $html .= "<tr>";
                $html .= "<td style='width:145px;height:30px;border-bottom:1px solid #ddd'>&nbsp;&nbsp;&nbsp;&nbsp;".$row["pc_name"]."</td>";
                if(count($category) > ($key)){
                    $addborder= ";border-bottom:1px solid #ddd";
                }else{
                    $addborder= "";
                }
                $html .= "<td style='border-left:1px solid #ddd".$addborder."'>";
                $productItem = $this->api_model->fetchProductSearch($row["pc_seq"]);
                    $html .= "<table cellpadding=0 cellspacing=0 border=0 style='width:100%'>";
                    foreach($productItem as $key2 => $pi_row){
                        if(count($productItem) > ($key2+1)){
                            $addborder2= ";border-bottom:1px solid #ddd";
                        }else{
                            $addborder2= "";
                        }
                        $html .= "<tr>";
                            $html .= "<td style='width:197px".$addborder2.";height:30px;'>&nbsp;&nbsp;&nbsp;&nbsp;".$pi_row["pi_name"]."</td>";
                            $html .= "<td style='".$addborder2."'>";
                                $html .= "<table cellpadding=0 cellspacing=0 border=0 style='width:100%'>";
                                $product = $this->api_model->productSearchItem($pi_row["pi_seq"]);
                                foreach($product as $key3 => $pr_row){
                                    if(count($product) > ($key3+1)){
                                        $addborder3= ";border-bottom:1px solid #ddd";
                                    }else{
                                        $addborder3= "";
                                    }
                                    $html .= "<tr>";
                                        $html .= "<td style='width:250px;height:30px".$addborder3.";border-left:1px solid #ddd'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='all_pr_name' data-pcseq='".$row["pc_seq"]."' data-piseq='".$pi_row["pi_seq"]."' data-prseq='".$pr_row["pr_seq"]."' style='text-decoration:underline'>".$pr_row["pr_name"]."</a></td>";
                                    $html .= "</tr>";
                                }
                                $html .= "</table>";
                            $html .= "</td>";
                        $html .= "</tr>";
                    }
                    $html .= "</table>";
                $html .= "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        echo $html;
    }
}
