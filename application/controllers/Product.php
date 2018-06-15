<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Seoul');
class Product extends CI_Controller {

    /**
     * 상품 컨트롤러
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("product_model");
    }
    public function register()
    {
        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);
        $layout["content"] = $this->load->view("product/list", '',true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }

    public function item($pc_seq)
    {
        $data["pc_seq"] = $pc_seq;
        $data["pc_name"] = $this->product_model->selectCategory($pc_seq);
        $layout["content"] = $this->load->view("product/item", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }


    public function clients()
    {
        $layout["header"] = $this->load->view("layout/header", '',true);
        $layout["left"] = $this->load->view("layout/left", '',true);
        $layout["content"] = $this->load->view("product/clients", '',true);
        $layout["footer"] = $this->load->view("layout/footer", '',true);
        $this->load->view('layout/layout',$layout);
    }



    public function make($pc_seq,$pr_seq=""){
        $data["pc_seq"] = $pc_seq;
        $pc_info = $this->product_model->selectCategory($pc_seq);
        $data["pc_name"] = $pc_info["pc_name"];

        if($pr_seq != ""){
            $data["info"] = $this->product_model->selectProduct($pr_seq);
        }else{
            $data["info"] = array(
                "pr_pi_seq" => "",
                "pr_c_seq" => "",
                "pr_code" => $pc_info["pc_code"].sprintf("%04d",$this->product_model->selectMaxProductCode($pc_seq)),
                "pi_name" => "",
                "c_name" => "",
                "pr_name"=>"",
                "pr_seq"=>""
            );
        }
        // print_r($data);
        $data["table_data"] = "";
        $divinfo = $this->product_model->fetchDiv($pc_seq);
        $i = 0;
        foreach($divinfo as $row){
            $html = '<tr style="background:#EBE9E4">
            <td>대분류</td>
            <td>'.$row["pd_name"].'</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
            ';
            $subdiv = $this->product_model->fetchSubDiv($row["pd_seq"],$pr_seq);
            foreach($subdiv as $row2){
                $html .= '<tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;ㄴ 소분류</td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;ㄴ '.$row2["ps_name"].'</td>
                <input type="hidden" name="prs_seq[]" value="'.$row2["prs_seq"].'">
                <input type="hidden" name="prs_use_type[]" class="prs_use_type" value="">
                <td><input type="text" name="prs_price[]" value="'.number_format($row2["prs_price"]).'" style="width:80px;ime-mode:disabled" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)">원</td>
                <td style="text-align:left;padding-left:5px"><input type="radio" name="prs_div['.$i.']" value="1" '.($row2["prs_div"] == "1" ? "checked":"").'>구매<br><input type="radio" name="prs_div['.$i.']" value="2" '.($row2["prs_div"] == "2" ? "checked":"").'>월</td>
                <td><input type="text" name="prs_one_price[]" value="'.number_format($row2["prs_one_price"]).'" style="width:80px;ime-mode:disabled" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)">원</td>
                <td><input type="text" name="prs_month_price[]" value="'.number_format($row2["prs_month_price"]).'" style="width:80px;ime-mode:disabled" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)">원</td>
                <td><input type="checkbox" name="prs_use_type_str[]" class="prs_use_type_str" value="1" '.($row2["prs_use_type"] == "1" ? "checked":"").'></td>
                <td><input type="text" name="prs_msg[]" value="'.$row2["prs_msg"].'" style="width:140px"></td>
                </tr>
                <input type="hidden" name="prs_pd_seq[]" value="'.$row["pd_seq"].'">
                <input type="hidden" name="prs_ps_seq[]" value="'.$row2["ps_seq"].'">
                ';
                $i++;
            }
            $data["table_data"] = $data["table_data"].$html;
        }
        $layout["content"] = $this->load->view("product/make", $data,true);
        $this->load->view('layout/layout_popup',$layout);
    }
}
