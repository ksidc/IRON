<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
description : 비동기 처리 로직들 insert , update , delete, select
참고 사이트 : http://www.ciboard.co.kr/user_guide/kr/
*/

class Api_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    // 회원 아이디 중복체크
    public function memberIdCheck(){
        $this->db->select("*");
        $this->db->where("mb_id" , $this->input->get("mb_id"));
        $this->db->from("members");

        $query = $this->db->get();
        // 회원아이디가 중복일경우 true
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    // 회원 사업자 or 생년월일 중복체크
    public function memberNumberCheck(){
        $this->db->select("*");
        $this->db->where("mb_number" , $this->input->get("mb_number"));
        $this->db->from("members");

        $query = $this->db->get();
        // 회원 사업자 or 생년월일이 중복일경우 true
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    // 회원 insert
    public function memberAdd(){
        // data array
        $data = array(
            "mb_id" => $this->input->post("mb_id"),
            "mb_type" => $this->input->post("mb_type"),
            "mb_name" => $this->input->post("mb_name"),
            "mb_number" => $this->input->post("mb_number"),
            "mb_ceo" => $this->input->post("mb_ceo"),
            "mb_zipcode" => $this->input->post("mb_zipcode"),
            "mb_address" => $this->input->post("mb_address"),
            "mb_detail_address" => $this->input->post("mb_detail_address"),
            "mb_tel" => $this->input->post("mb_tel"),
            "mb_phone" => $this->input->post("mb_phone"),
            "mb_email" => $this->input->post("mb_email"),
            "mb_fax" => $this->input->post("mb_fax"),
            "mb_business_conditions" => $this->input->post("mb_business_conditions"),
            "mb_business_type" => $this->input->post("mb_business_type"),
            "mb_contract_name" => $this->input->post("mb_contract_name"),
            "mb_contract_email" => $this->input->post("mb_contract_email"),
            "mb_contract_tel" => $this->input->post("mb_contract_tel"),
            "mb_contract_phone" => $this->input->post("mb_contract_phone"),
            "mb_payment_name" => $this->input->post("mb_payment_name"),
            "mb_payment_email" => $this->input->post("mb_payment_email"),
            "mb_payment_tel" => $this->input->post("mb_payment_tel"),
            "mb_payment_phone" => $this->input->post("mb_payment_phone"),
            "mb_bank" => $this->input->post("mb_bank"),
            "mb_bank_name" => $this->input->post("mb_bank_name"),
            "mb_bank_name_relationship" => $this->input->post("mb_bank_name_relationship"),
            "mb_bank_number" => $this->input->post("mb_bank_number"),
            "mb_bank_input_number" => $this->input->post("mb_bank_input_number"),
            "mb_payment_type" => $this->input->post("mb_payment_type"),
            "mb_auto_payment" => $this->input->post("mb_auto_payment"),
            "mb_payment_publish" => $this->input->post("mb_payment_publish"),
            "mb_payment_publish_type" => $this->input->post("mb_payment_publish_type"),
            "mb_payment_day" => $this->input->post("mb_payment_day")
        );

        // ci 이용 디비 인서트
        return $this->db->insert("members",$data);

    }

    // 회원 list count
    public function countMember(){
        $this->db->select("count(*) as total");
        $this->db->from("members");

        if($this->input->get("searchYn") == "Y"){
            $this->db->where("1=1");
        }

        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(mb_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(mb_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    // 회원 list select
    public function fetchMember($start,$limit){
        $start = ($start - 1)*$limit;
        $this->db->select("*");
        $this->db->from("members");

        if($this->input->get("searchYn") == "Y"){
            $this->db->where("1=1");
        }

        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(mb_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(mb_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }
        $this->db->order_by("mb_seq desc");
        $this->db->limit($limit,$start);

        $query = $this->db->get();

        return $query->result_array();
    }

    // 회원 list search select
    public function fetchSearchMember(){
        $this->db->select("*");
        $this->db->from("members");

        if($this->input->get("memberSearchWord") != ""){
            $this->db->like($this->input->get("memberSearchType"),$this->input->get("memberSearchWord"),'both');
        }
        $this->db->order_by("mb_seq desc");

        $query = $this->db->get();

        return $query->result_array();
    }

    // 회원 row
    public function selectMember($mb_seq){
        $this->db->select("*");
        $this->db->from("members");
        $this->db->where("mb_seq",$mb_seq);
        $query = $this->db->get();

        return $query->row_array();
    }

    // 회원 업데이트
    public function memberUpdate($mb_seq){
        // data array
        $data = array(
            // "mb_id" => $this->input->post("mb_id"),
            "mb_type" => $this->input->post("mb_type"),
            "mb_name" => $this->input->post("mb_name"),
            "mb_number" => $this->input->post("mb_number"),
            "mb_ceo" => $this->input->post("mb_ceo"),
            "mb_zipcode" => $this->input->post("mb_zipcode"),
            "mb_address" => $this->input->post("mb_address"),
            "mb_detail_address" => $this->input->post("mb_detail_address"),
            "mb_tel" => $this->input->post("mb_tel"),
            "mb_phone" => $this->input->post("mb_phone"),
            "mb_email" => $this->input->post("mb_email"),
            "mb_fax" => $this->input->post("mb_fax"),
            "mb_business_conditions" => $this->input->post("mb_business_conditions"),
            "mb_business_type" => $this->input->post("mb_business_type"),
            "mb_contract_name" => $this->input->post("mb_contract_name"),
            "mb_contract_email" => $this->input->post("mb_contract_email"),
            "mb_contract_tel" => $this->input->post("mb_contract_tel"),
            "mb_contract_phone" => $this->input->post("mb_contract_phone"),
            "mb_payment_name" => $this->input->post("mb_payment_name"),
            "mb_payment_email" => $this->input->post("mb_payment_email"),
            "mb_payment_tel" => $this->input->post("mb_payment_tel"),
            "mb_payment_phone" => $this->input->post("mb_payment_phone"),
            "mb_bank" => $this->input->post("mb_bank"),
            "mb_bank_name" => $this->input->post("mb_bank_name"),
            "mb_bank_name_relationship" => $this->input->post("mb_bank_name_relationship"),
            "mb_bank_number" => $this->input->post("mb_bank_number"),
            "mb_bank_input_number" => $this->input->post("mb_bank_input_number"),
            "mb_payment_type" => $this->input->post("mb_payment_type"),
            "mb_auto_payment" => $this->input->post("mb_auto_payment"),
            "mb_payment_publish" => $this->input->post("mb_payment_publish"),
            "mb_payment_publish_type" => $this->input->post("mb_payment_publish_type"),
            "mb_payment_day" => $this->input->post("mb_payment_day")
        );
        $this->db->where("mb_seq",$mb_seq);
        // ci 이용 디비 인서트
        return $this->db->update("members",$data);
    }

    // 회원 삭제
    public function memberDelete($mb_seq){

        $this->db->where_in("mb_seq",$mb_seq);

        return $this->db->delete("members");
        // echo $this->db->last_query();
    }

    public function memberExport(){
        $this->db->select("*");
        $this->db->from("members");
        $this->db->where_in("mb_seq",$this->input->post("mb_seq"));

        $query = $this->db->get();

        return $query->result_array();
    }

    // 견적 insert
    public function estimateAdd(){
        // data array
        $data = array(
            "es_number" => $this->input->post("es_number1")."-".$this->input->post("es_number2"),
            "es_mb_seq" => $this->input->post("es_mb_seq"),
            "es_name" => $this->input->post("es_name"),
            "es_charger" => $this->input->post("es_charger"),
            "es_tel" => $this->input->post("es_tel"),
            "es_phone" => $this->input->post("es_phone"),
            "es_email" => $this->input->post("es_email"),
            "es_fax" => $this->input->post("es_fax"),
            "es_type" => $this->input->post("es_type"),
            "es_shot" => $this->input->post("es_shot"),
            "es_memo" => $this->input->post("es_memo"),
            "es_part" => $this->input->post("es_part"),
            "es_register" => $this->input->post("es_register"),
            "es_status" => $this->input->post("es_status")
        );

        if($this->input->post("es_company_type") != ""){
            $data["es_company_type"] = $this->input->post("es_company_type");
        }

        if($this->input->post("es_end_user") != ""){
            $data["es_end_user"] = $this->input->post("es_end_user");
        }

        // ci 이용 디비 인서트
        $result = $this->db->insert("estimates",$data);

        $es_seq = $this->db->insert_id();

        $data_depth_array = array();
        $depth1 = $this->input->post("es_depth1");
        $depth2 = $this->input->post("es_depth2");
        for($i = 0; $i < count($depth1);$i++){
            if($depth1[$i] != ""){
                $data = array(
                    "ed_es_seq" => $es_seq,
                    "ed_depth1" => $depth1[$i],
                    "ed_depth2" => $depth2[$i]
                );

                array_push($data_depth_array,$data);
            }
        }

        if(count($data_depth_array) > 0){
            $result = $this->db->insert_batch("estimate_depth",$data_depth_array);
        }

        // $data_file_array = array();
        // $ef_sort = $this->input->post("ef_sort");
        // for($i = 0; $i < count($_FILES["es_file"]["name"]);$i++){
        //     $ext = substr(strrchr(basename($_FILES['es_file']["name"][$i]), '.'), 1);
        //     $file_name = time()."_".rand(1111,9999).".".$ext;
        //     move_uploaded_file($_FILES["es_file"]['tmp_name'][$i],$_SERVER["DOCUMENT_ROOT"].'/uploads/estimate_file/'.$file_name);
        //     $data = array(
        //         "ef_es_seq" => $es_seq,
        //         "ef_file" => $file_name,
        //         "ef_origin_file" => $_FILES['basic_file']["name"][$i],
        //         "ef_file_size" => $_FILES['basic_file']["size"][$i],
        //         "ef_sort" => $ef_sort[$i]
        //     );

        //     array_push($data_file_array,$data);
        // }

        // if(count($data_file_array) > 0){
        //     $result = $this->db->insert_batch($data_file_array);
        // }
        $data_file_array = array();
        $this->db->select("*");
        $this->db->from("estimate_files_tmp");
        $this->db->where("ef_es_code",$this->input->post("es_number1")."-".$this->input->post("es_number2"));

        $this->db->order_by("ef_seq");

        $query = $this->db->get();
        foreach($query->result_array() as $row){

            $data = array(
                "ef_es_seq" => $es_seq,
                "ef_file" => $row["ef_file"],
                "ef_origin_file" => $row["ef_origin_file"],
                "ef_file_size" => $row["ef_file_size"]
            );
            array_push($data_file_array,$data);
            // print_r($data_file_array);
        }
        // echo count($data_file_array);

        if(count($data_file_array) > 0){
            $result = $this->db->insert_batch("estimate_files",$data_file_array);
        }

        $this->db->where("ef_es_code",$this->input->post("es_number1")."-".$this->input->post("es_number2"));
        $this->db->delete("estimate_files_tmp");
        return $result;
    }

    // 견적 list count
    public function countEstimate(){
        $this->db->select("count(*) as total");
        $this->db->from("estimates ");

        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(es_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(es_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }
        if($this->input->get("es_status") != ""){
            if(count($this->input->get("es_status")) == 1){
                $this->db->where("es_status",$this->input->get("es_status")[0]);
            }else{
                $this->db->where_in("es_status",array("0","1"));
            }
        }else{
            $this->db->where_in("es_status",array("0","1"));
        }

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    // 견적 list select
    public function fetchEstimate($start,$limit){
        $start = ($start - 1)*$limit;
        $this->db->select("a.*,b.*, ifnull((select group_concat(concat(ef_seq,',',ef_file,',',ef_origin_file) separator '|') as file_seq from estimate_files where ef_es_seq = a.es_seq group by ef_es_seq),'') as file_seq ,c.mb_id ");
        $this->db->from("estimates a");
        $this->db->join("estimate_depth b","a.es_seq = b.ed_es_seq","left");
        $this->db->join("members c","a.es_mb_seq = c.mb_seq","left");


        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(es_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(es_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        if($this->input->get("es_status") != ""){
            if(count($this->input->get("es_status")) == 1){
                $this->db->where("es_status",$this->input->get("es_status")[0]);
            }else{
                $this->db->where_in("es_status",array("0","1"));
            }
        }else{
            $this->db->where_in("es_status",array("0","1"));
        }

        if($this->input->get("searchDepth1") != ""){
            $this->db->where("b.ed_depth1",$this->input->get("searchDepth1"));
        }

        if($this->input->get("searchDepth2") != ""){
            $this->db->where("b.ed_depth2",$this->input->get("searchDepth2"));
        }

        $this->db->limit($limit,$start);
        $this->db->order_by("es_seq desc");
        $this->db->group_by("es_seq");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchEstimateDepth($es_seq){
        $this->db->select("a.*,b.pc_name,c.pr_name");
        $this->db->from("estimate_depth a");
        $this->db->join("product_category b","a.ed_depth1 = b.pc_seq","left");
        $this->db->join("product c","a.ed_depth2 = c.pr_seq","left");
        $this->db->where("ed_es_seq",$es_seq);

        $query = $this->db->get();

        return $query->result_array();
    }
    // 견적 row
    public function selectEstimate($es_seq){
        $this->db->select("a.*,b.ct_name,c.eu_name");
        $this->db->from("estimates a");
        $this->db->join("company_type b","a.es_company_type = b.ct_seq","left");
        $this->db->join("end_users c","a.es_end_user = c.eu_seq","left");

        $this->db->where("es_seq",$es_seq);
        $query = $this->db->get();

        return $query->row_array();
    }

    // 견적 파일
    public function fetchEstimateFiles($es_seq){
        $this->db->select("*");
        $this->db->from("estimate_files");

        $this->db->where("ef_es_seq",$es_seq);
        $query = $this->db->get();

        return $query->result_array();
    }

    // 견적 업데이트
    public function estimateUpdate($es_seq){
        // data array
        $data_file_array = array();
        $this->db->select("*");
        $this->db->from("estimate_files_tmp");
        $this->db->where("ef_es_code",$this->input->post("es_number1")."-".$this->input->post("es_number2"));

        $this->db->order_by("ef_seq");

        $query = $this->db->get();
        foreach($query->result_array() as $row){

            $data = array(
                "ef_es_seq" => $es_seq,
                "ef_file" => $row["ef_file"],
                "ef_origin_file" => $row["ef_origin_file"],
                "ef_file_size" => $row["ef_file_size"]
            );
            array_push($data_file_array,$data);
            // print_r($data_file_array);
        }
        // echo count($data_file_array);

        if(count($data_file_array) > 0){
            $result = $this->db->insert_batch("estimate_files",$data_file_array);
        }

        $this->db->where("ef_es_code",$this->input->post("es_number1")."-".$this->input->post("es_number2"));
        $this->db->delete("estimate_files_tmp");

        $insert_data = array(
            "insert_yn" => "N"
        );
        $this->db->where("ed_es_seq",$es_seq);
        $this->db->update("estimate_depth",$insert_data);

        $data_depth_update = array();
        $data_depth_insert = array();

        $depth1 = $this->input->post("es_depth1");
        $depth2 = $this->input->post("es_depth2");
        $ed_seq = $this->input->post("ed_seq");
        for($i = 0; $i < count($depth1);$i++){
            if($depth1[$i] != ""){
                if($ed_seq[$i] == ""){
                    $data = array(
                        "ed_es_seq" => $es_seq,
                        "ed_depth1" => $depth1[$i],
                        "ed_depth2" => $depth2[$i]
                    );
                    array_push($data_depth_insert,$data);
                }else{
                    $udata = array(
                        "ed_seq" => $ed_seq[$i],
                        "ed_depth1" => $depth1[$i],
                        "ed_depth2" => $depth2[$i],
                        "insert_yn" => "Y"
                    );
                    array_push($data_depth_update,$udata);
                }


            }
        }

        if(count($data_depth_insert) > 0){
            $this->db->insert_batch("estimate_depth",$data_depth_insert);
        }

        if(count($data_depth_update) > 0){
            $this->db->update_batch("estimate_depth",$data_depth_update,"ed_seq");
        }

        $this->db->where("insert_yn","N");
        $this->db->where("ed_es_seq",$es_seq);
        $this->db->delete("estimate_depth");

        $data = array(
            "es_name" => $this->input->post("es_name"),
            "es_mb_seq"=>$this->input->post("es_mb_seq"),
            "es_charger" => $this->input->post("es_charger"),
            "es_tel" => $this->input->post("es_tel"),
            "es_phone" => $this->input->post("es_phone"),
            "es_email" => $this->input->post("es_email"),
            "es_fax" => $this->input->post("es_fax"),
            "es_type" => $this->input->post("es_type"),
            "es_shot" => $this->input->post("es_shot"),
            "es_memo" => $this->input->post("es_memo"),
            "es_part" => $this->input->post("es_part"),
            "es_register" => $this->input->post("es_register"),
            "es_status" => $this->input->post("es_status"),
            "es_regdate" => date('Y-m-d H:i:s')
        );

        if($this->input->post("es_company_type") != ""){
            $data["es_company_type"] = $this->input->post("es_company_type");
        }

        if($this->input->post("es_end_user") != ""){
            $data["es_end_user"] = $this->input->post("es_end_user");
        }

        $this->db->where("es_seq",$es_seq);
        // ci 이용 디비 인서트
        return $this->db->update("estimates",$data);
    }

    // 견적 삭제
    public function estimateDelete($es_seq){
        $this->db->select("*");
        $this->db->from("estimate_files");

        $this->db->where_in("ef_es_seq",$es_seq);
        $query = $this->db->get();

        foreach($query->result_array() as $row){
            $ef_file = $row["ef_file"];

            unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/estimate_file/".$ef_file);

            $this->db->where("ef_seq",$row["ef_seq"]);
            $this->db->delete("estimate_files");
        }

        $this->db->where_in("es_seq",$es_seq);
        return $this->db->delete("estimates");
    }

    // 견적 파일 삭제
    public function estimateFileDelete($ef_seq){
        // data array
        $this->db->select("*");
        $this->db->from("estimate_files");
        $this->db->where("ef_seq",$ef_seq);
        $query = $this->db->get();

        $row = $query->row_array();
        $ef_file = $row["ef_file"];

        unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/estimate_file/".$ef_file);

        $this->db->where("ef_seq",$ef_seq);

        return $this->db->delete("estimate_files");
    }

    public function estimateStatus($es_seq){
        $data = array(
            "es_status" => "1"
        );

        $this->db->where("es_seq",$es_seq);
        return $this->db->update("estimates",$data);
    }

    // 견적 copy
    public function estimateCopy(){
        $seq = explode(",",$this->input->post("checkSeq"));
        sort($seq);

        $this->db->select("es_number");
        $this->db->from("estimates");
        $this->db->limit(1);

        $this->db->order_by("es_number desc");

        $query = $this->db->get();
        $row = $query->row_array();

        $current_number = $row["es_number"];

        for($i =0; $i < count($seq);$i++){
            $code_first = substr($current_number,0,1);
            $code_number = substr($current_number,1,4);

            $next_number = str_pad(++$code_number,4,"0",STR_PAD_LEFT);
            if($next_number == "0000"){
                $next_first = ++$code_first;
            }else{
                $next_first = $code_first;
            }
            $current_number = $next_first.$next_number;
            $next_number_result = $next_first.$next_number."-01";

            $this->db->select("*");
            $this->db->from("estimates");
            $this->db->where("es_seq",$seq[$i]);
            $query = $this->db->get();

            $copy_row = $query->row_array();

            $data = array(
                "es_number" => $next_number_result,
                "es_mb_seq" => $copy_row["es_mb_seq"],
                "es_name" => $copy_row["es_name"],
                "es_charger" => $copy_row["es_charger"],
                "es_tel" => $copy_row["es_tel"],
                "es_phone" => $copy_row["es_phone"],
                "es_email" => $copy_row["es_email"],
                "es_fax" => $copy_row["es_fax"],
                "es_type" => $copy_row["es_type"],
                "es_company_type" => $copy_row["es_company_type"],
                "es_shot" => $copy_row["es_shot"],
                "es_end_user" => $copy_row["es_end_user"],
                "es_memo" => $copy_row["es_memo"]
            );

            $this->db->insert("estimates",$data);

            $es_seq = $this->db->insert_id();

            $data_depth_array = array();

            $this->db->select("*");
            $this->db->from("estimate_depth");
            $this->db->where("ed_es_seq",$seq[$i]);
            $depth_query = $this->db->get();

            foreach($depth_query->result_array as $depth_row){
                $data_depth = array(
                    "ed_es_seq" => $es_seq,
                    "ed_depth1" => $depth_row["ed_depth1"],
                    "ed_depth2" => $depth_row["ed_depth2"]
                );

                array_push($data_depth_array,$data_depth);
            }



            if(count($data_depth_array) > 0){
                $this->db->insert_batch("estimate_depth",$data_depth_array);
            }
        }

        return true;
    }

    public function estimateReCopy(){
        $seq = $this->input->post("checkSeq");

        $this->db->select("es_number");
        $this->db->from("estimates");
        $this->db->where("es_seq",$seq);

        // $this->db->order_by("es_number desc");

        $query = $this->db->get();
        $row = $query->row_array();

        $current_number = explode("-",$row["es_number"]);

        $this->db->select("es_number");
        $this->db->from("estimates");
        $this->db->where("es_number LIKE '".$current_number[0]."%' ");
        $this->db->order_by("es_number desc");
        $this->db->limit(1);

        $query = $this->db->get();
        $row = $query->row_array();
        $current_sub_number = explode("-",$row["es_number"]);

        $next_number = str_pad(++$current_sub_number[1],2,"0",STR_PAD_LEFT);

        $next_number_result = $current_sub_number[0]."-".$next_number;

        $this->db->select("*");
        $this->db->from("estimates");
        $this->db->where("es_seq",$seq);
        $query = $this->db->get();

        $copy_row = $query->row_array();

        $data = array(
            "es_number" => $next_number_result,
            "es_mb_seq" => $copy_row["es_mb_seq"],
            "es_name" => $copy_row["es_name"],
            "es_charger" => $copy_row["es_charger"],
            "es_tel" => $copy_row["es_tel"],
            "es_phone" => $copy_row["es_phone"],
            "es_email" => $copy_row["es_email"],
            "es_fax" => $copy_row["es_fax"],
            "es_type" => $copy_row["es_type"],
            "es_company_type" => $copy_row["es_company_type"],
            "es_shot" => $copy_row["es_shot"],
            "es_end_user" => $copy_row["es_end_user"],
            "es_memo" => $copy_row["es_memo"]
        );

        $this->db->insert("estimates",$data);

        $es_seq = $this->db->insert_id();

        $this->db->select("*");
        $this->db->from("estimate_depth");
        $this->db->where("ed_es_seq",$seq);
        $depth_query = $this->db->get();

        foreach($depth_query->result_array as $depth_row){
            $data_depth = array(
                "ed_es_seq" => $es_seq,
                "ed_depth1" => $depth_row["ed_depth1"],
                "ed_depth2" => $depth_row["ed_depth2"]
            );

            $this->db->insert("estimate_depth",$data_depth);
        }

        return true;
    }

    public function estimateSuccess(){
        $seq = explode(",",$this->input->post("checkSeq"));

        for($i = 0; $i < count($seq);$i++){
            $data = array(
                "es_status" => "1"
            );

            $this->db->where("es_seq",$seq[$i]);
            $this->db->update("estimates",$data);
        }

        return true;
    }

    public function estimateExport(){
        $this->db->select("a.*,b.eu_name,c.ct_name");
        $this->db->from("estimates a ");
        $this->db->join("end_users b","a.es_end_user = b.eu_seq","left");
        $this->db->join("company_type c","a.es_company_type = c.ct_seq","left");
        $this->db->where_in("es_seq",$this->input->post("es_seq"));
        $query = $this->db->get();

        return $query->result_array();
    }

    // 기본 첨부 파일 insert
    public function estimateBasicFileAdd(){
        // data array
        $data_insert_array = array();
        $data_update_array = array();

        $bf_seq = $this->input->post("bf_seq");
        $bf_sort = $this->input->post("bf_sort");
        if(isset($_FILES["basic_file"])){
            for($i = 0; $i < count($_FILES["basic_file"]["name"]);$i++){
                if($_FILES["basic_file"]["size"][$i] > 0){
                    if($bf_seq[$i] != ""){
                        $this->db->select("*");
                        $this->db->from("estimate_basic_files");
                        $this->db->where("bf_seq",$bf_seq[$i]);
                        $query = $this->db->get();

                        $row = $query->row_array();
                        $bf_file = $row["bf_file"];

                        unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/basic_file/".$bf_file);

                        $ext = substr(strrchr(basename($_FILES['basic_file']["name"][$i]), '.'), 1);
                        $file_name = time()."_".rand(1111,9999).".".$ext;
                        move_uploaded_file($_FILES["basic_file"]['tmp_name'][$i],$_SERVER["DOCUMENT_ROOT"].'/uploads/basic_file/'.$file_name);

                        $data = array(
                            "bf_seq" => $bf_seq[$i],
                            "bf_file" => $file_name,
                            "bf_origin_file" => $_FILES['basic_file']["name"][$i],
                            "bf_file_size" => $_FILES['basic_file']["size"][$i],
                            "bf_sort" => $bf_sort[$i]
                        );
                        // print_r($data);
                        array_push($data_update_array,$data);
                    }else{
                        $ext = substr(strrchr(basename($_FILES['basic_file']["name"][$i]), '.'), 1);
                        $file_name = time()."_".rand(1111,9999).".".$ext;
                        move_uploaded_file($_FILES["basic_file"]['tmp_name'][$i],$_SERVER["DOCUMENT_ROOT"].'/uploads/basic_file/'.$file_name);
                        $data = array(
                            "bf_file" => $file_name,
                            "bf_origin_file" => $_FILES['basic_file']["name"][$i],
                            "bf_file_size" => $_FILES['basic_file']["size"][$i],
                            "bf_sort" => $bf_sort[$i]
                        );

                        array_push($data_insert_array,$data);
                    }

                }
            }
        }
        if(count($data_insert_array) > 0){
            $this->db->insert_batch("estimate_basic_files",$data_insert_array);
        }

        if(count($data_update_array) > 0){
            $this->db->update_batch("estimate_basic_files",$data_update_array,'bf_seq');
        }
        return true;
    }

    // 기본 첨부 파일 list select
    public function fetchEstimateBasicFile(){
        $this->db->select("*");
        $this->db->from("estimate_basic_files");

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        $this->db->order_by("bf_sort");
        $query = $this->db->get();

        return $query->result_array();
    }

    // 기본 첨부 파일 delete
    public function estimateBasicFileDelete($bf_seq){
        // data array
        $this->db->select("*");
        $this->db->from("estimate_basic_files");
        $this->db->where("bf_seq",$bf_seq);
        $query = $this->db->get();

        $row = $query->row_array();
        $bf_file = $row["bf_file"];

        unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/basic_file/".$bf_file);

        $this->db->where("bf_seq",$bf_seq);

        return $this->db->delete("estimate_basic_files");

    }

    // 업체 구분 코드 생성
    public function selectNextCompanyCode(){
        $this->db->select("ifnull(MAX(ct_code),0) as code");
        $this->db->from("company_type");

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["code"]+1;

    }

    // 업체 구분 중복 체크
    public function selectCompanyType(){
        $this->db->select("*");
        $this->db->from("company_type");
        $this->db->where(" (ct_code = '".$this->input->post("addType")."' or ct_name = '".$this->input->post("ct_name")."') ");

        $query = $this->db->get();

        return $query->num_rows();
    }
    // 업체 구분 insert
    public function companyTypeAdd(){
        // data array
        $data = array(
            "ct_code" => $this->input->post("addType"),
            "ct_name" => $this->input->post("ct_name")
        );

        // ci 이용 디비 인서트
        return $this->db->insert("company_type",$data);

    }

    // 업체 구분 list select
    public function fetchCompanyType(){
        $this->db->select("*");
        $this->db->from("company_type");

        if($this->input->get("typeSearchWord") != ""){
            $this->db->like("ct_name",$this->input->get("typeSearchWord"),'both');
        }

        $this->db->order_by("ct_code");
        $query = $this->db->get();

        return $query->result_array();
    }

    // 업체 구분 update
    public function companyTypeUpdate($ct_seq){
        // data array
        $data = array(
            "ct_name" => $this->input->post("ct_name")
        );
        $this->db->where("ct_seq",$ct_seq);
        // ci 이용 디비 인서트
        return $this->db->update("company_type",$data);

    }

    // 업체 구분 delete
    public function companyTypeDelete($ct_seq){

        $this->db->where("ct_seq",$ct_seq);
        // ci 이용 디비 삭제
        return $this->db->delete("company_type");

    }

    // End User 중복 체크
    public function selectEndUser(){
        $this->db->select("*");
        $this->db->from("end_users");
        $this->db->where(" (eu_code = '".$this->input->post("addEnd")."' or eu_name = '".$this->input->post("eu_name")."') ");

        $query = $this->db->get();

        return $query->num_rows();
    }

    // End User insert
    public function endUserAdd(){
        // data array
        $data = array(
            "eu_code" => $this->input->post("addEnd"),
            "eu_name" => $this->input->post("eu_name")
        );

        // ci 이용 디비 인서트
        return $this->db->insert("end_users",$data);

    }

    // End User list select
    public function fetchEndUser(){
        $this->db->select("*");
        $this->db->from("end_users");

        if($this->input->get("endSearchWord") != ""){
            $this->db->like("eu_name",$this->input->get("endSearchWord"),'both');
        }

        $this->db->order_by("eu_code");
        $query = $this->db->get();

        return $query->result_array();
    }

    // End User update
    public function endUserUpdate($eu_seq){
        // data array
        $data = array(
            "eu_name" => $this->input->post("eu_name")
        );
        $this->db->where("eu_seq",$eu_seq);
        // ci 이용 디비 인서트
        return $this->db->update("end_users",$data);

    }

    // End User delete
    public function endUserDelete($eu_seq){
        $this->db->where("eu_seq",$eu_seq);
        // ci 이용 디비 인서트
        return $this->db->delete("end_users");

    }

    public function endUserNextCode(){
        $this->db->select("eu_code");
        $this->db->from("end_users");
        $this->db->limit(1);

        $this->db->order_by("eu_seq desc");

        $query = $this->db->get();
        if($query->num_rows() == 0){
            return "A0000";
        }else{
            $row = $query->row_array();
            return $row["eu_code"];
        }

    }

    public function estimateNextCode(){
        $this->db->select("es_number");
        $this->db->from("estimates");
        $this->db->limit(1);

        $this->db->order_by("es_number desc");

        $query = $this->db->get();
        if($query->num_rows() == 0){
            return "A0000-01";
        }else{
            $row = $query->row_array();
            // $es_number = explode("-",$row["es_number"]);

            return $row["es_number"];
        }

    }

    public function serviceNextCode(){
        $this->db->select("sr_code");
        $this->db->from("service_register");
        $this->db->limit(1);

        $this->db->order_by("sr_code desc");

        $query = $this->db->get();
        if($query->num_rows() == 0){
            return "AW100001-01";
        }else{
            $row = $query->row_array();
            // $es_number = explode("-",$row["es_number"]);

            return $row["sr_code"];
        }

    }

    public function estimateFilesTmp(){
        $data_insert_array = array();

        for($i = 0; $i < count($_FILES["es_file"]["name"]);$i++){
            if($_FILES["es_file"]["size"][$i] > 0){

                $ext = substr(strrchr(basename($_FILES['es_file']["name"][$i]), '.'), 1);
                $file_name = time()."_".rand(1111,9999).".".$ext;
                move_uploaded_file($_FILES["es_file"]['tmp_name'][$i],$_SERVER["DOCUMENT_ROOT"].'/uploads/estimate_file/'.$file_name);
                $data = array(
                    "ef_es_code" => $this->input->post("ef_es_code"),
                    "ef_file" => $file_name,
                    "ef_origin_file" => $_FILES['es_file']["name"][$i],
                    "ef_file_size" => $_FILES['es_file']["size"][$i],
                    "ef_sessionkey" => $this->input->post("ef_sessionkey")
                );

                array_push($data_insert_array,$data);


            }
        }

        if(count($data_insert_array) > 0){
            $this->db->insert_batch("estimate_files_tmp",$data_insert_array);
        }

        return true;
    }

    public function estimateFilesTmpList(){
        $this->db->select("*");
        $this->db->from("estimate_files_tmp");
        $this->db->where("ef_es_code",$this->input->post("ef_es_code"));
        $this->db->where("ef_sessionkey",$this->input->post("ef_sessionkey"));
        $this->db->order_by("ef_seq");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function estimateFilesTmpDeleteSession($ef_sessionkey){
        $this->db->select("*");
        $this->db->from("estimate_files_tmp");
        $this->db->where("ef_sessionkey",$ef_sessionkey);

        $query = $this->db->get();

        foreach($query->result_array() as $row){
            unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/estimate_file/".$row["ef_file"]);
        }

        $this->db->where("ef_sessionkey",$ef_sessionkey);

        return $this->db->delete("estimate_files_tmp");
    }

    public function estimateFilesTmpDelete($ef_seq){
        $this->db->select("*");
        $this->db->from("estimate_files_tmp");
        $this->db->where("ef_seq",$ef_seq);

        $query = $this->db->get();

        $row = $query->row_array();

        unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/estimate_file/".$row["ef_file"]);

        $this->db->where("ef_seq",$ef_seq);

        return $this->db->delete("estimate_files_tmp");
    }

    public function estimateFilesDelete($ef_seq){
        $this->db->select("*");
        $this->db->from("estimate_files");
        $this->db->where("ef_seq",$ef_seq);

        $query = $this->db->get();

        $row = $query->row_array();

        unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/estimate_file/".$row["ef_file"]);

        $this->db->where("ef_seq",$ef_seq);

        return $this->db->delete("estimate_files");
    }

    public function estimateEmailFile(){
        $data_insert_array = array();

        for($i = 0; $i < count($_FILES["em_file"]["name"]);$i++){
            if($_FILES["em_file"]["size"][$i] > 0){

                $ext = substr(strrchr(basename($_FILES['em_file']["name"][$i]), '.'), 1);
                $file_name = time()."_".rand(1111,9999).".".$ext;
                move_uploaded_file($_FILES["em_file"]['tmp_name'][$i],$_SERVER["DOCUMENT_ROOT"].'/uploads/estimate_email_file/'.$file_name);
                $data = array(
                    "em_es_seq" => $this->input->post("em_es_seq"),
                    "em_file" => $file_name,
                    "em_origin_file" => $_FILES['em_file']["name"][$i],
                    "em_file_size" => $_FILES['em_file']["size"][$i]
                );

                array_push($data_insert_array,$data);


            }
        }

        if(count($data_insert_array) > 0){
            $this->db->insert_batch("estimate_email_files",$data_insert_array);
        }

        return true;
    }

    public function estimateEmailFileList($es_seq){
        $this->db->select("*");
        $this->db->from("estimate_email_files");
        $this->db->where("em_es_seq",$es_seq);

        $this->db->order_by("em_seq");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function estimateEmailFileDelete(){
        $em_seq = explode(",",$this->input->get("checkSeq"));
        $this->db->select("*");
        $this->db->from("estimate_email_files");
        $this->db->where_in("em_seq",$em_seq);

        $query = $this->db->get();

        foreach($query->result_array() as $row){
            @unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/estimate_email_file/".$row["em_file"]);
        }

        $this->db->where_in("em_seq",$em_seq);

        $this->db->delete("estimate_email_files");

        return true;
    }

    public function productCategoryList(){
        $this->db->select("*");
        $this->db->from("product_category");
        $this->db->order_by("pc_sort");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function productCategoryMaxSort(){
        $this->db->select("MAX(pc_sort) as max_sort");
        $this->db->from("product_category");

        $query = $this->db->get();

        return $query->row_array();
    }

    public function productCategoryRegister($sort){
        $data = array(
            "pc_code" => $this->input->post("pc_code"),
            "pc_name" => $this->input->post("pc_name"),
            "pc_sort" => $sort
        );
        return $this->db->insert("product_category",$data);
    }

    public function dupleProductCategory(){
        $this->db->select("*");
        $this->db->from("product_category");

        $this->db->where("pc_code = '".$this->input->post("pc_code")."' or pc_name = '".$this->input->post("pc_name")."'  ");
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function productCategoryUpdate($pc_seq){
        $data = array(
            "pc_name" => $this->input->post("pc_name")
        );
        $this->db->where("pc_seq",$pc_seq);

        return $this->db->update("product_category",$data);
    }

    public function productCategoryDelete($pc_seq){
        $this->db->where("pc_seq",$pc_seq);

        return $this->db->delete("product_category");
    }

    public function productCategorySort(){
        $pc_seq = $this->input->post("pc_seq");
        for($i = 0; $i < count($pc_seq);$i++){
            $sql = "update product_category set pc_sort = ".($i+1)." where pc_seq = '".$pc_seq[$i]."' ";
            $this->db->query($sql);
        }
        if($this->input->post("m_pc_name") != ""){
            $m_pc_seq = $this->input->post("m_pc_seq");
            $m_pc_name = $this->input->post("m_pc_name");

            for($i = 0;$i < count($m_pc_seq);$i++){
                $sql = "update product_category set pc_name = '".$m_pc_name[$i]."' where pc_seq = '".$m_pc_seq[$i]."' ";
                $this->db->query($sql);
            }
        }
        return true;
    }

    public function productDivList($pc_seq){
        $this->db->select("*");
        $this->db->from("product_div");
        $this->db->where("pd_pc_seq",$pc_seq);
        $this->db->order_by("pd_sort");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function productDivMaxSort($pc_seq){
        $this->db->select("MAX(pd_sort) as max_sort");
        $this->db->from("product_div");
        $this->db->where("pd_pc_seq",$pc_seq);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function productDivRegister($pc_seq,$sort){
        $data = array(
            "pd_pc_seq" => $pc_seq,
            "pd_name" => $this->input->post("pd_name"),
            "pd_sort" => $sort
        );
        return $this->db->insert("product_div",$data);
    }

    public function dupleProductDiv($pc_seq){
        $this->db->select("*");
        $this->db->from("product_div");

        $this->db->where("pd_pc_seq = '".$pc_seq."' and pd_name = '".$this->input->post("pd_name")."'  ");
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function productDivUpdate($pd_seq,$pd_name){
        $data = array(
            "pd_name" => $pd_name
        );
        $this->db->where("pd_seq",$pd_seq);

        return $this->db->update("product_div",$data);
    }

    public function productDivDelete($pd_seq){
        $this->db->where("pd_seq",$pd_seq);

        return $this->db->delete("product_div");
    }

    public function productDivSubList($pd_seq){
        $this->db->select("*");
        $this->db->from("product_sub_div");
        $this->db->where("ps_pd_seq",$pd_seq);
        $this->db->order_by("ps_seq");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function productDivSubMaxSort($pd_seq){
        $this->db->select("MAX(ps_sort) as max_sort");
        $this->db->from("product_sub_div");
        $this->db->where("ps_pd_seq",$pd_seq);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function productDivSubRegister($pd_seq,$ps_name){
        $data = array(
            "ps_pd_seq" => $pd_seq,
            "ps_name" => $ps_name
        );
        return $this->db->insert("product_sub_div",$data);
    }

    public function productDivSort($pd_seq){
        for($i = 0; $i < count($pd_seq);$i++){
            $sql = "update product_div set pd_sort = '".($i+1)."' where pd_seq = '".$pd_seq[$i]."' ";
            $this->db->query($sql);
        }
    }
    public function productDivSubUpdate($ps_seq,$ps_name){
        $data = array(
            "ps_name" => $ps_name
        );
        $this->db->where("ps_seq",$ps_seq);

        return $this->db->update("product_sub_div",$data);
    }

    public function productDivSubDelete($ps_seq){
        $this->db->where("ps_seq",$ps_seq);

        return $this->db->delete("product_sub_div");
    }

    public function productItemMaxSort($pc_seq){
        $this->db->select("MAX(pi_sort) as max_sort");
        $this->db->from("product_items");
        $this->db->where("pi_pc_seq",$pc_seq);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function productItemRegister($pc_seq,$sort){
        $data = array(
            "pi_pc_seq" => $pc_seq,
            "pi_name" => $this->input->post("pi_name"),
            "pi_sort" => $sort
        );
        return $this->db->insert("product_items",$data);
    }

    public function productItemUpdate($pi_seq,$pi_name){

        // foreach($data["sub"] as $row){
        //     if($row["pis_seq"] != ""){
        //         $idata = array(
        //             "pis_name" => $row["pis_name"],
        //             "pis_c_seq" => $row["pis_c_seq"]
        //         );
        //         $this->db->where("pis_seq",$row["pis_seq"]);
        //         $this->db->update("product_item_sub",$idata);
        //     }else{
        //         $idata = array(
        //             "pis_name" => $row["pis_name"],
        //             "pis_c_seq" => $row["pis_c_seq"],
        //             "pis_pi_seq" => $data["pi_seq"]
        //         );
        //         $this->db->insert("product_item_sub",$idata);
        //     }
        // }
        $idata = array(
            "pi_name" => $pi_name
        );
        $this->db->where("pi_seq",$pi_seq);

        return $this->db->update("product_items",$idata);
    }

    public function productItemDelete($pi_seq){
        $this->db->where("pis_pi_seq",$pi_seq);
        $this->db->delete("product_item_sub");

        $this->db->where("pi_seq",$pi_seq);

        return $this->db->delete("product_items");
    }

    public function productItemSubRegister($pis_pi_seq,$pis_name,$pis_c_seq){
        $data = array(
            "pis_pi_seq" => $pis_pi_seq,
            "pis_name" => $pis_name,
            "pis_c_seq" => $pis_c_seq
        );
        return $this->db->insert("product_item_sub",$data);
    }

    public function productItemSubUpdate($pis_seq,$pis_name,$pis_c_seq){
        $data = array(
            "pis_name" => $pis_name,
            "pis_c_seq" => $pis_c_seq
        );

        $this->db->where("pis_seq",$pis_seq);
        return $this->db->update("product_item_sub",$data);
    }

    // 제품군 list count
    public function countProductItem($pc_seq){
        $this->db->select("count(*) as total");
        $this->db->from("product_items");

        $this->db->where("pi_pc_seq",$pc_seq);

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    // 제품군 list select
    public function fetchProductItem($pc_seq,$start,$limit){
        $start = ($start - 1)*$limit;
        $this->db->select("*");
        $this->db->from("product_items a ");
        $this->db->where("pi_pc_seq",$pc_seq);

        $this->db->order_by("pi_sort asc");
        $this->db->limit($limit,$start);

        // $sql = "select * from (select * from product_items order by pi_sort limit $start,$limit) a left join product_item_sub b on a.pi_seq = b.pis_pi_seq order by a.pi_sort";

        // $query = $this->db->query($sql);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
    }

    public function fetchProductItemSub($pi_seq){
        $this->db->select("a.*,b.c_name,c.pi_name");
        $this->db->from("product_item_sub a");
        $this->db->join("clients b","a.pis_c_seq = b.c_seq","left");
        $this->db->join("product_items c","a.pis_pi_seq = c.pi_seq","left");
        $this->db->where("pis_pi_seq",$pi_seq);

        $this->db->order_by("pis_seq");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchProductSearch($pc_seq){
        $this->db->select("*,pi_name as name");
        $this->db->from("product_items");
        $this->db->where("pi_pc_seq",$pc_seq);

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        $this->db->order_by("pi_sort asc");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function dupleProductItemName($pc_seq){
        $this->db->select("*");
        $this->db->from("product_items");
        $this->db->where("pi_pc_seq",$pc_seq);
        $this->db->where("pi_name" ,$this->input->post("pi_name"));


        $query = $this->db->get();

        return $query->num_rows();
    }

    // 매입처 아이디 중복체크
    public function clientIdCheck(){
        $this->db->select("*");
        $this->db->where("c_id" , $this->input->get("c_id"));
        $this->db->from("clients");

        $query = $this->db->get();
        // 매입처아이디가 중복일경우 true
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    // 매입처 사업자 중복체크
    public function clientNumberCheck(){
        $this->db->select("*");
        $this->db->where("c_number" , $this->input->get("c_number"));
        $this->db->from("clients");

        $query = $this->db->get();
        // 매입처 사업자 중복일경우 true
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    // 매입처 insert
    public function clientAdd(){
        // data array
        $data = array(
            "c_id" => $this->input->post("c_id"),
            "c_item" => $this->input->post("c_item"),
            "c_name" => $this->input->post("c_name"),
            "c_number" => $this->input->post("c_number"),
            "c_ceo" => $this->input->post("c_ceo"),
            "c_zipcode" => $this->input->post("c_zipcode"),
            "c_address" => $this->input->post("c_address"),
            "c_detail_address" => $this->input->post("c_detail_address"),
            "c_email" => $this->input->post("c_email"),
            "c_fax" => $this->input->post("c_fax"),
            "c_business_conditions" => $this->input->post("c_business_conditions"),
            "c_business_type" => $this->input->post("c_business_type"),
            "c_contract_name" => $this->input->post("c_contract_name"),
            "c_contract_email" => $this->input->post("c_contract_email"),
            "c_contract_tel" => $this->input->post("c_contract_tel"),
            "c_contract_phone" => $this->input->post("c_contract_phone"),
            "c_payment_name" => $this->input->post("c_payment_name"),
            "c_payment_email" => $this->input->post("c_payment_email"),
            "c_payment_tel" => $this->input->post("c_payment_tel"),
            "c_payment_phone" => $this->input->post("c_payment_phone"),
            "c_bank" => $this->input->post("c_bank"),
            "c_bank_name" => $this->input->post("c_bank_name"),
            "c_bank_name_relationship" => $this->input->post("c_bank_name_relationship"),
            "c_bank_number" => $this->input->post("c_bank_number"),
            "c_bank_input_number" => $this->input->post("c_bank_input_number"),
            "c_payment_type" => $this->input->post("c_payment_type")
        );
        if(isset($_FILES['file1'])){
            if($_FILES['file1']["size"] > 0){
                $ext = substr(strrchr(basename($_FILES['file1']["name"]), '.'), 1);
                $file_name = time()."_".rand(1111,9999).".".$ext;
                move_uploaded_file($_FILES["file1"]['tmp_name'],$_SERVER["DOCUMENT_ROOT"].'/uploads/client_file/'.$file_name);
                $data["c_file1"] = $file_name;
                $data["c_origin_file1"] = $_FILES['file1']["name"];
            }
        }

        if(isset($_FILES['file2'])){
            if($_FILES['file2']["size"] > 0){
                $ext = substr(strrchr(basename($_FILES['file2']["name"]), '.'), 1);
                $file_name = time()."_".rand(1111,9999).".".$ext;
                move_uploaded_file($_FILES["file2"]['tmp_name'],$_SERVER["DOCUMENT_ROOT"].'/uploads/client_file/'.$file_name);
                $data["c_file2"] = $file_name;
                $data["c_origin_file2"] = $_FILES['file2']["name"];
            }
        }
        // ci 이용 디비 인서트
        return $this->db->insert("clients",$data);

    }

    // 매입처 list count
    public function countClient(){
        $this->db->select("count(*) as total");
        $this->db->from("clients");

        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(c_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(c_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            if($this->input->get("searchType") == "c_email"){
                $tthis->db->where(" (c_email LIKE '%".$this->input->get("searchWord")."%' or c_contract_email LIKE '%".$this->input->get("searchWord")."%' or c_payment_email LIKE '%".$this->input->get("searchWord")."%' )");
            }else if($this->input->get("searchType") == "c_contract_tel"){
                $tthis->db->where(" (c_contract_tel LIKE '%".$this->input->get("searchWord")."%' or c_payment_tel LIKE '%".$this->input->get("searchWord")."%'  )");
            }else if($this->input->get("searchType") == "c_contract_phone"){
                $tthis->db->where(" (c_contract_phone LIKE '%".$this->input->get("searchWord")."%' or c_payment_phone LIKE '%".$this->input->get("searchWord")."%'  )");
            }else{
                $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
            }
        }

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    // 매입처 list select
    public function fetchClient($start,$limit){
        $start = ($start - 1)*$limit;
        $this->db->select("*");
        $this->db->from("clients");

        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(c_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(c_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }
        $this->db->order_by("c_seq desc");
        $this->db->limit($limit,$start);

        $query = $this->db->get();

        return $query->result_array();
    }

    // 매입처 list select no paging
    public function fetchSearchClient(){

        $this->db->select("c_seq, c_name,c_id, c_name as name");
        $this->db->from("clients");

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        $this->db->order_by("c_seq desc");

        $query = $this->db->get();

        return $query->result_array();
    }

    // 매입처 row
    public function selectClient($c_seq){
        $this->db->select("*");
        $this->db->from("clients");
        $this->db->where("c_seq",$c_seq);
        $query = $this->db->get();

        return $query->row_array();
    }

    // 매입처 업데이트
    public function clientUpdate($c_seq){
        // data array
        $data = array(
            // "mb_id" => $this->input->post("mb_id"),
            "c_item" => $this->input->post("c_item"),
            "c_name" => $this->input->post("c_name"),
            "c_number" => $this->input->post("c_number"),
            "c_ceo" => $this->input->post("c_ceo"),
            "c_zipcode" => $this->input->post("c_zipcode"),
            "c_address" => $this->input->post("c_address"),
            "c_detail_address" => $this->input->post("c_detail_address"),
            "c_email" => $this->input->post("c_email"),
            "c_fax" => $this->input->post("c_fax"),
            "c_business_conditions" => $this->input->post("c_business_conditions"),
            "c_business_type" => $this->input->post("c_business_type"),
            "c_contract_name" => $this->input->post("c_contract_name"),
            "c_contract_email" => $this->input->post("c_contract_email"),
            "c_contract_tel" => $this->input->post("c_contract_tel"),
            "c_contract_phone" => $this->input->post("c_contract_phone"),
            "c_payment_name" => $this->input->post("c_payment_name"),
            "c_payment_email" => $this->input->post("c_payment_email"),
            "c_payment_tel" => $this->input->post("c_payment_tel"),
            "c_payment_phone" => $this->input->post("c_payment_phone"),
            "c_bank" => $this->input->post("c_bank"),
            "c_bank_name" => $this->input->post("c_bank_name"),
            "c_bank_name_relationship" => $this->input->post("c_bank_name_relationship"),
            "c_bank_number" => $this->input->post("c_bank_number"),
            "c_bank_input_number" => $this->input->post("c_bank_input_number"),
            "c_payment_type" => $this->input->post("c_payment_type")
        );

        $this->db->select("c_file1,c_file2");
        $this->db->from("clients");
        $this->db->where("c_seq",$c_seq);

        $query = $this->db->get();
        $file = $query->row_array();
        if(isset($_FILES['file1'])){
            if($_FILES['file1']["size"] > 0){

                if($file["c_file1"] != ""){
                    unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/client_file/".$file["c_file1"]);
                }
                $ext = substr(strrchr(basename($_FILES['file1']["name"]), '.'), 1);
                $file_name = time()."_".rand(1111,9999).".".$ext;
                move_uploaded_file($_FILES["file1"]['tmp_name'],$_SERVER["DOCUMENT_ROOT"].'/uploads/client_file/'.$file_name);
                $data["c_file1"] = $file_name;
                $data["c_origin_file1"] = $_FILES['file1']["name"];
            }
        }

        if(isset($_FILES['file2'])){
            if($_FILES['file2']["size"] > 0){
                if($file["c_file2"] != ""){
                    unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/client_file/".$file["c_file2"]);
                }
                $ext = substr(strrchr(basename($_FILES['file2']["name"]), '.'), 1);
                $file_name = time()."_".rand(1111,9999).".".$ext;
                move_uploaded_file($_FILES["file2"]['tmp_name'],$_SERVER["DOCUMENT_ROOT"].'/uploads/client_file/'.$file_name);
                $data["c_file2"] = $file_name;
                $data["c_origin_file2"] = $_FILES['file2']["name"];
            }
        }

        $this->db->where("c_seq",$c_seq);
        // ci 이용 디비 인서트
        return $this->db->update("clients",$data);
    }

    // 매입처 삭제
    public function clientDelete($c_seq){

        $this->db->where_in("c_seq",$c_seq);

        return $this->db->delete("clients");
        // echo $this->db->last_query();
    }

    public function clientExport(){
        $this->db->select("*");
        $this->db->from("clients");
        $this->db->where_in("c_seq",$this->input->post("c_seq"));

        $query = $this->db->get();

        return $query->result_array();
    }

    public function clientFileDelete($c_seq,$type){
        $this->db->select("c_file1,c_file2");
        $this->db->from("clients");
        $this->db->where("c_seq",$c_seq);

        $query = $this->db->get();
        $file = $query->row_array();

        if($type == "1"){
            unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/client_file/".$file["c_file1"]);
            $data["c_file1"] = "";
            $data["c_origin_file1"] = "";
        }else if($type == "2"){
            unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/client_file/".$file["c_file2"]);
            $data["c_file2"] = "";
            $data["c_origin_file2"] = "";
        }

        $this->db->where("c_seq",$c_seq);

        return $this->db->update("clients",$data);
    }

    public function productAdd(){
        $data = array(
            "pr_code" => $this->input->post("pr_code"),
            "pr_pi_seq" => $this->input->post("pr_pi_seq"),
            "pr_c_seq" => $this->input->post("pr_c_seq"),
            "pr_pc_seq" => $this->input->post("pr_pc_seq"),
            "pr_name" => $this->input->post("pr_name")
        );
        $this->db->insert("product",$data);

        $pr_seq = $this->db->insert_id();
        return $pr_seq;
    }

    public function productCopy($product){
        $data = array(
            "pr_code" => $product["pr_code"],
            "pr_pi_seq" => $product["pr_pi_seq"],
            "pr_c_seq" => $product["pr_c_seq"],
            "pr_pc_seq" => $product["pr_pc_seq"],
            "pr_name" => $product["pr_name"]
        );
        $this->db->insert("product",$data);

        $pr_seq = $this->db->insert_id();
        return $pr_seq;
    }

    public function productSubAdd($pr_seq,$prs_pd_seq,$prs_ps_seq,$prs_price,$prs_div,$prs_one_price,$prs_month_price,$prs_use_type,$prs_msg){

        $data_sub = array(
            "prs_pr_seq" => $pr_seq,
            "prs_pd_seq" => $prs_pd_seq,
            "prs_ps_seq" => $prs_ps_seq,
            "prs_price" => str_replace(",","",$prs_price),
            "prs_div" => $prs_div,
            "prs_one_price" => str_replace(",","",$prs_one_price),
            "prs_month_price" => str_replace(",","",$prs_month_price),
            "prs_use_type" => $prs_use_type,
            "prs_msg" => $prs_msg
        );
        $result = $this->db->insert("product_sub",$data_sub);


        return $result;
    }
    // 매입처 list count
    public function countProduct($pc_seq){
        $this->db->select("count(*) as total");
        $this->db->from("product a");
        $this->db->join("product_items b","a.pr_pi_seq = b.pi_seq","left");
        $this->db->join("clients c", "a.pr_c_seq = c.c_seq","left");

        $this->db->where("pr_pc_seq",$pc_seq);

        if($this->input->get("pi_seq")){
            $pi_seq = implode(",",$this->input->get("pi_seq"));
            $this->db->where("pr_pi_seq in (".$pi_seq.")");
        }
        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    // 매입처 list select
    public function fetchProduct($pc_seq,$start,$limit){
        $start = ($start - 1)*$limit;
        $this->db->select("a.*, b.pi_name, c.c_name");
        $this->db->from("product a");
        $this->db->join("product_items b","a.pr_pi_seq = b.pi_seq","left");
        $this->db->join("clients c", "a.pr_c_seq = c.c_seq","left");

        $this->db->where("pr_pc_seq",$pc_seq);

        if($this->input->get("pi_seq")){
            $pi_seq = implode(",",$this->input->get("pi_seq"));
            $this->db->where("pr_pi_seq in (".$pi_seq.")");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }
        $this->db->order_by("pr_seq desc");
        $this->db->limit($limit,$start);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function productSearch($pc_seq){
        $this->db->select("a.pr_name , a.pr_seq ,a.pr_name as name");
        $this->db->from("product a");
        $this->db->where("pr_pc_seq" , $pc_seq);
        if($this->input->get("pi_seq") != ""){
            $this->db->where("pr_pi_seq",$this->input->get("pi_seq"));
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    public function selectProduct($pr_seq){
        $this->db->select("*");
        $this->db->from("product");
        $this->db->where("pr_seq",$pr_seq);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function productUpdate($pr_seq){
        $data = array(
            "pr_code" => $this->input->post("pr_code"),
            "pr_pi_seq" => $this->input->post("pr_pi_seq"),
            "pr_c_seq" => $this->input->post("pr_c_seq"),
            "pr_name" => $this->input->post("pr_name")
        );
        $this->db->where("pr_seq",$pr_seq);
        return $this->db->update("product",$data);
    }

    public function productSubUpdate($prs_seq,$prs_pd_seq,$prs_ps_seq,$prs_price,$prs_div,$prs_one_price,$prs_month_price,$prs_use_type,$prs_msg){

        $data_sub = array(
            "prs_pd_seq" => $prs_pd_seq,
            "prs_ps_seq" => $prs_ps_seq,
            "prs_price" => str_replace(",","",$prs_price),
            "prs_div" => $prs_div,
            "prs_one_price" => str_replace(",","",$prs_one_price),
            "prs_month_price" => str_replace(",","",$prs_month_price),
            "prs_use_type" => $prs_use_type,
            "prs_msg" => $prs_msg
        );

        $this->db->where("prs_seq",$prs_seq);
        $result = $this->db->update("product_sub",$data_sub);


        return $result;
    }

    public function productDelete($pr_seq){

        $this->db->where_in("pr_seq",$pr_seq);

        return $this->db->delete("product");
        // echo $this->db->last_query();
    }

    public function productItemSubList($pi_seq){
        $this->db->select("*");
        $this->db->from("product_item_sub");
        $this->db->where("pis_pi_seq",$pi_seq);
        $this->db->order_by("pis_seq");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchProductSub($pr_seq){
        $this->db->select("a.*,(select pd_name from product_div where prs_pd_seq = pd_seq) as pd_name, (select ps_name from product_sub_div where prs_ps_seq = ps_seq) as ps_name ");
        $this->db->from("product_sub a");
        $this->db->join("product_div b","a.prs_pd_seq = b.pd_seq","inner");
        $this->db->where("prs_pr_seq",$pr_seq);
        $this->db->where("prs_use_type","1");
        $this->db->order_by("b.pd_sort asc , a.prs_seq asc");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function productSubCopy($product_sub){
        $result = $this->db->insert("product_sub",$product_sub);

        return $result;
    }

    public function selectMaxCodeProduct($pr_pc_seq){
        $this->db->select("*");
        $this->db->from("product");
        $this->db->where("pr_pc_seq",$pr_pc_seq);
        $this->db->limit(1);
        $this->db->order_by("pr_code desc");

        $query = $this->db->get();

        return $query->row_array();
    }

    public function productExport(){
        $this->db->select("*");
        $this->db->from("product a");
        $this->db->join("product_items b","a.pr_pi_seq = b.pi_seq","left");
        $this->db->join("clients c", "a.pr_c_seq = c.c_seq","left");
        $this->db->join("product_sub d","a.pr_seq = d.prs_pr_seq","left");
        $this->db->join("product_div e","d.prs_pd_seq = e.pd_seq","left");
        $this->db->join("product_sub_div f","d.prs_ps_seq = f.ps_seq","left");

        $this->db->where_in("pr_seq",$this->input->post("pr_seq"));
        $this->db->where("d.prs_use_type = 1");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchPolicyBank(){
        $this->db->select("*,sb_discount as discount");
        $this->db->from("service_basic_bank");

        if($this->input->get("period") != ""){
            $this->db->where("sb_min_month <= '".$this->input->get("period")."' and sb_max_month > '".$this->input->get("period")."' ");
        }
        $this->db->order_by("sb_seq");

        $query = $this->db->get();

        if($this->input->get("period") != ""){
            return $query->row_array();
        }else{
            return $query->result_array();
        }
    }

    public function fetchPolicyCard(){
        $this->db->select("*,sc_discount as discount");
        $this->db->from("service_basic_card");

        if($this->input->get("period") != ""){
            $this->db->where("sc_min_month <= '".$this->input->get("period")."' and sc_max_month > '".$this->input->get("period")."' ");
        }

        $this->db->order_by("sc_seq");

        $query = $this->db->get();

        if($this->input->get("period") != ""){
            return $query->row_array();
        }else{
            return $query->result_array();
        }
    }

    public function fetchPolicyCms(){
        $this->db->select("*");
        $this->db->from("service_basic_cms");


        $query = $this->db->get();

        return $query->row_array();
    }

    public function fetchPolicy(){
        $this->db->select("*");
        $this->db->from("service_basic_policy");

        $query = $this->db->get();

        return $query->row_array();
    }

    public function estimateNumberCheck(){
        $this->db->select("*");
        $this->db->from("estimates");

        $this->db->where("es_number",$this->input->get("es_number"));
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function basicPolicyEdit(){
        $sb_seq = $this->input->post("sb_seq");
        $sb_min_month = $this->input->post("sb_min_month");
        $sb_max_month = $this->input->post("sb_max_month");
        $sb_discount = $this->input->post("sb_discount");

        $sb_data_insert = array();
        $sb_data_update = array();

        $sb_data["insert_yn"] = "N";
        $this->db->update("service_basic_bank",$sb_data);

        for($i = 0; $i < count($sb_seq);$i++){
            if($sb_seq[$i] == ""){
                $sb_insert = array(
                    "sb_min_month" => $sb_min_month[$i],
                    "sb_max_month" => $sb_max_month[$i],
                    "sb_discount" => $sb_discount[$i],
                    "insert_yn" => "Y"
                );
                array_push($sb_data_insert,$sb_insert);
            }else{
                $sb_update = array(
                    "sb_seq" => $sb_seq[$i],
                    "sb_min_month" => $sb_min_month[$i],
                    "sb_max_month" => $sb_max_month[$i],
                    "sb_discount" => $sb_discount[$i],
                    "insert_yn" => "Y"
                );
                array_push($sb_data_update,$sb_update);
            }
        }
        if(count($sb_data_insert) > 0){
            $this->db->insert_batch("service_basic_bank",$sb_data_insert);
        }
        if(count($sb_data_update) > 0){
            $this->db->update_batch("service_basic_bank",$sb_data_update,"sb_seq");
        }

        $this->db->where("insert_yn","N");
        $this->db->delete("service_basic_bank");

        $sc_seq = $this->input->post("sc_seq");
        $sc_min_month = $this->input->post("sc_min_month");
        $sc_max_month = $this->input->post("sc_max_month");
        $sc_discount = $this->input->post("sc_discount");

        $sc_data_insert = array();
        $sc_data_update = array();

        $sc_data["insert_yn"] = "N";
        $this->db->update("service_basic_card",$sc_data);

        for($i = 0; $i < count($sc_seq);$i++){
            if($sc_seq[$i] == ""){
                $sc_insert = array(
                    "sc_min_month" => $sc_min_month[$i],
                    "sc_max_month" => $sc_max_month[$i],
                    "sc_discount" => $sc_discount[$i],
                    "insert_yn" => "Y"
                );
                array_push($sc_data_insert,$sc_insert);
            }else{
                $sc_update = array(
                    "sc_seq" => $sc_seq[$i],
                    "sc_min_month" => $sc_min_month[$i],
                    "sc_max_month" => $sc_max_month[$i],
                    "sc_discount" => $sc_discount[$i],
                    "insert_yn" => "Y"
                );
                array_push($sc_data_update,$sc_update);
            }
        }
        if(count($sc_data_insert) > 0){
            $this->db->insert_batch("service_basic_card",$sc_data_insert);
        }
        if(count($sc_data_update) > 0){
            $this->db->update_batch("service_basic_card",$sc_data_update,"sc_seq");
        }

        $this->db->where("insert_yn","N");
        $this->db->delete("service_basic_card");

        $cms_data = array(
            "discount" => $this->input->post("discount")
        );
        $this->db->update("service_basic_cms",$cms_data);

        $basic_data = array(
            "sp_basic_type" => $this->input->post("sp_basic_type"),
            "sp_policy" => $this->input->post("sp_policy"),
            "sp_pay_start_day" => $this->input->post("sp_pay_start_day"),
            "sp_pay_format" => $this->input->post("sp_pay_format"),
            "sp_pay_format_policy" => $this->input->post("sp_pay_format_policy")
        );

        return $this->db->update("service_basic_policy",$basic_data);
    }

    public function serviceRegister(){
        $data = array(
            "sr_mb_seq" => $this->input->post("sr_mb_seq"),
            "sr_eu_seq" => $this->input->post("sr_eu_seq"),
            "sr_ct_seq" => $this->input->post("sr_ct_seq"),
            "sr_code" => $this->input->post("sr_code1")."-".$this->input->post("sr_code2"),
            "sr_part" => $this->input->post("sr_part"),
            "sr_charger" => $this->input->post("sr_charger"),
            "sr_contract_type" => $this->input->post("sr_contract_type"),
            "sr_contract_start" => $this->input->post("sr_contract_start"),
            "sr_contract_end" => $this->input->post("sr_contract_end"),
            "sr_auto_extension" => $this->input->post("sr_auto_extension"),
            "sr_auto_extension_month" => $this->input->post("sr_auto_extension_month"),
            "sr_register_discount" => $this->input->post("sr_register_discount"),
            "sr_payment_type" => $this->input->post("sr_payment_type"),
            "sr_payment_period" => $this->input->post("sr_payment_period"),
            "sr_pay_type" => $this->input->post("sr_pay_type"),
            "sr_pay_day" => $this->input->post("sr_pay_day"),
            "sr_pay_publish" => $this->input->post("sr_pay_publish"),
            "sr_pay_publish_type" => $this->input->post("sr_pay_publish_type"),
            "sr_payment_day" => $this->input->post("sr_payment_day"),
            "sr_account_policy" => $this->input->post("sr_account_policy"),
            "sr_account_start" => $this->input->post("sr_account_start"),
            "sr_account_end" => $this->input->post("sr_account_end"),
            "sr_account_type" => $this->input->post("sr_account_type"),
            "sr_account_start_day" => $this->input->post("sr_account_start_day"),
            "sr_account_format" => $this->input->post("sr_account_format"),
            "sr_account_format_policy" => $this->input->post("sr_account_format_policy"),
            "sr_pc_seq" => $this->input->post("sr_pc_seq"),
            "sr_pi_seq" => $this->input->post("sr_pi_seq"),
            "sr_pr_seq" => $this->input->post("sr_pr_seq"),
            "sr_pd_seq" => $this->input->post("sr_pd_seq"),
            "sr_ps_seq" => $this->input->post("sr_ps_seq"),
            "sr_claim_name" => $this->input->post("sr_claim_name"),
            "sr_rental" => $this->input->post("sr_rental"),
            "sr_bill_name" => $this->input->post("sr_bill_name"),
            "sr_once_price" => $this->input->post("sr_once_price"),
            "sr_month_price" => $this->input->post("sr_month_price"),
            "sr_c_seq" => $this->input->post("sr_c_seq"),
            "sr_input_price" => $this->input->post("sr_input_price"),
            "sr_rental_type" => $this->input->post("sr_rental_type"),
            "sr_rental_date" => $this->input->post("sr_rental_date"),
            "sr_after_price" => $this->input->post("sr_after_price")
        );

        $this->db->insert("service_register",$data);

        $sr_seq = $this->db->insert_id();

        $data_price = array(
            "sp_sr_seq" => $sr_seq,
            "sp_ps_seq" => $this->input->post("sr_ps_seq"),
            "sp_once_price" => $this->input->post("sr_once_price"),
            "sp_once_dis_price" => $this->input->post("sp_once_dis_price"),
            "sp_once_dis_msg" => $this->input->post("sp_once_dis_msg"),
            "sp_month_price" => $this->input->post("sp_month_price"),
            "sp_month_dis_price" => $this->input->post("sp_month_dis_price"),
            "sp_month_dis_msg" => $this->input->post("sp_month_dis_msg"),
            "sp_discount_yn" => $this->input->post("sp_discount_yn"),
            "sp_discount_price" => $this->input->post("sp_discount_price")
        );

        $this->db->insert("service_register_price",$data_price);

        $sa_name = $this->input->post("sa_name");
        $sa_c_seq = $this->input->post("sa_c_seq");
        $sa_input_price = $this->input->post("sa_input_price");
        $sa_input_unit = $this->input->post("sa_input_unit");
        $sa_input_date = $this->input->post("sa_input_date");
        $sa_claim_name = $this->input->post("sa_claim_name");
        $sa_bill_name = $this->input->post("sa_bill_name");
        $sa_once_price = $this->input->post("sa_once_price");
        $sa_month_price = $this->input->post("sa_month_price");
        $sa_pay_day = $this->input->post("sa_pay_day");
        $pis_yn = $this->input->post("pis_yn");
        $etc_yn = $this->input->post("etc_yn");
        $sa_pis_seq = $this->input->post("sa_pis_seq");

        for($i = 0; $i < count($pis_yn); $i++){
            // if($pis_yn[$i] == "Y"){
            $data_addoption = array(
                "sa_name" => $sa_name[$i],
                "sa_sr_seq" => $sr_seq,
                "sa_pr_seq" => $this->input->post("sr_pr_seq"),
                "sa_pis_seq" => $pis_yn[$i],
                "sa_c_seq" => $sa_c_seq[$i],
                "sa_input_price" => $sa_input_price[$i],
                "sa_input_unit" => $sa_input_unit[$i],
                "sa_input_date" => $sa_input_date[$i],
                "sa_claim_name" => $sa_claim_name[$i],
                "sa_bill_name" => $sa_bill_name[$i],
                "sa_once_price" => $sa_once_price[$i],
                "sa_month_price" => $sa_month_price[$i],
                "sa_pay_day" => $sa_pay_day[$i]
            );

            $this->db->insert("service_register_addoption",$data_addoption);
            // }
        }
        if($this->input->post("sp_once_price_add") != ""){
            $sp_once_price_add = $this->input->post("sp_once_price_add");
            $sp_once_dis_price_add = $this->input->post("sp_once_dis_price_add");
            $sp_once_dis_msg_add = $this->input->post("sp_once_dis_msg_add");
            $sp_discount_yn_add = $this->input->post("sp_discount_yn_add");
            $sp_month_price_add = $this->input->post("sp_month_price_add");
            $sp_month_dis_price_add = $this->input->post("sp_month_dis_price_add");
            $sp_month_dis_msg_add = $this->input->post("sp_month_dis_msg_add");
            $sp_discount_price_add = $this->input->post("sp_discount_price_add");
            $pis_seq_add = $this->input->post("pis_seq_add");
            $sp_register_discount_add = $this->input->post("sr_register_discount_add");
            for($i = 0; $i < count($sp_once_price_add);$i++){
                $this->db->select("*");
                $this->db->from("service_register_addoption");
                $this->db->where("sa_pis_seq",$pis_seq_add[$i]);
                $query = $this->db->get();
                $row = $query->row_array();

                $data_addoption_price = array(
                    "sap_sa_seq" => $row["sa_seq"],
                    "sap_once_price" => $sp_once_price_add[$i],
                    "sap_once_dis_price" => $sp_once_dis_price_add[$i],
                    "sap_once_dis_msg" => $sp_once_dis_msg_add[$i],
                    "sap_month_price" => $sp_month_price_add[$i],
                    "sap_month_dis_price" => $sp_month_dis_price_add[$i],
                    "sap_month_dis_msg" => $sp_month_dis_msg_add[$i],
                    "sap_discount_yn" => $sp_discount_yn_add[$i],
                    "sap_discount_price" => $sp_discount_price_add[$i],
                    "sap_register_discount" => $sp_register_discount_add[$i]
                );

                $this->db->insert("service_register_addoption_price",$data_addoption_price);
            }
        }

        return true;
    }

    public function serviceRegisterEdit($sr_seq){
        $data = array(
            "sr_mb_seq" => $this->input->post("sr_mb_seq"),
            "sr_eu_seq" => $this->input->post("sr_eu_seq"),
            "sr_ct_seq" => $this->input->post("sr_ct_seq"),
            "sr_code" => $this->input->post("sr_code1")."-".$this->input->post("sr_code2"),
            "sr_part" => $this->input->post("sr_part"),
            "sr_charger" => $this->input->post("sr_charger"),
            "sr_contract_type" => $this->input->post("sr_contract_type"),
            "sr_contract_start" => $this->input->post("sr_contract_start"),
            "sr_contract_end" => $this->input->post("sr_contract_end"),
            "sr_auto_extension" => $this->input->post("sr_auto_extension"),
            "sr_auto_extension_month" => $this->input->post("sr_auto_extension_month"),
            "sr_register_discount" => $this->input->post("sr_register_discount"),
            "sr_payment_type" => $this->input->post("sr_payment_type"),
            "sr_payment_period" => $this->input->post("sr_payment_period"),
            "sr_pay_type" => $this->input->post("sr_pay_type"),
            "sr_pay_day" => $this->input->post("sr_pay_day"),
            "sr_pay_publish" => $this->input->post("sr_pay_publish"),
            "sr_pay_publish_type" => $this->input->post("sr_pay_publish_type"),
            "sr_payment_day" => $this->input->post("sr_payment_day"),
            "sr_account_policy" => $this->input->post("sr_account_policy"),
            "sr_account_start" => $this->input->post("sr_account_start"),
            "sr_account_end" => $this->input->post("sr_account_end"),
            "sr_account_type" => $this->input->post("sr_account_type"),
            "sr_account_start_day" => $this->input->post("sr_account_start_day"),
            "sr_account_format" => $this->input->post("sr_account_format"),
            "sr_account_format_policy" => $this->input->post("sr_account_format_policy"),
            "sr_pc_seq" => $this->input->post("sr_pc_seq"),
            "sr_pi_seq" => $this->input->post("sr_pi_seq"),
            "sr_pr_seq" => $this->input->post("sr_pr_seq"),
            "sr_pd_seq" => $this->input->post("sr_pd_seq"),
            "sr_ps_seq" => $this->input->post("sr_ps_seq"),
            "sr_claim_name" => $this->input->post("sr_claim_name"),
            "sr_rental" => $this->input->post("sr_rental"),
            "sr_bill_name" => $this->input->post("sr_bill_name"),
            "sr_once_price" => $this->input->post("sr_once_price"),
            "sr_month_price" => $this->input->post("sr_month_price"),
            "sr_c_seq" => $this->input->post("sr_c_seq"),
            "sr_input_price" => $this->input->post("sr_input_price"),
            "sr_rental_type" => $this->input->post("sr_rental_type"),
            "sr_rental_date" => $this->input->post("sr_rental_date"),
            "sr_after_price" => $this->input->post("sr_after_price")
        );

        $this->db->where("sr_seq",$sr_seq);
        $this->db->update("service_register",$data);

        $data_price = array(
            "sp_ps_seq" => $this->input->post("sr_ps_seq"),
            "sp_once_price" => $this->input->post("sr_once_price"),
            "sp_once_dis_price" => $this->input->post("sp_once_dis_price"),
            "sp_once_dis_msg" => $this->input->post("sp_once_dis_msg"),
            "sp_month_price" => $this->input->post("sp_month_price"),
            "sp_month_dis_price" => $this->input->post("sp_month_dis_price"),
            "sp_month_dis_msg" => $this->input->post("sp_month_dis_msg"),
            "sp_discount_yn" => $this->input->post("sp_discount_yn"),
            "sp_discount_price" => $this->input->post("sp_discount_price")
        );
        $this->db->where("sp_sr_seq",$sr_seq);
        $this->db->update("service_register_price",$data_price);

        $data_insertyn["insert_yn"] = "N";
        $this->db->where("sa_sr_seq",$sr_seq);
        $this->db->update("service_register_addoption",$data_insertyn);

        $sa_seq = $this->input->post("sa_seq");
        $sa_name = $this->input->post("sa_name");
        $sa_c_seq = $this->input->post("sa_c_seq");
        $sa_input_price = $this->input->post("sa_input_price");
        $sa_input_unit = $this->input->post("sa_input_unit");
        $sa_input_date = $this->input->post("sa_input_date");
        $sa_claim_name = $this->input->post("sa_claim_name");
        $sa_bill_name = $this->input->post("sa_bill_name");
        $sa_once_price = $this->input->post("sa_once_price");
        $sa_month_price = $this->input->post("sa_month_price");
        $sa_pay_day = $this->input->post("sa_pay_day");
        $pis_yn = $this->input->post("pis_yn");
        $etc_yn = $this->input->post("etc_yn");
        $sa_pis_seq = $this->input->post("sa_pis_seq");

        for($i = 0; $i < count($pis_yn); $i++){
            if($sa_seq[$i] == ""){
                $data_addoption = array(
                    "sa_name" => $sa_name[$i],
                    "sa_sr_seq" => $sr_seq,
                    "sa_pr_seq" => $this->input->post("sr_pr_seq"),
                    "sa_pis_seq" => $pis_yn[$i],
                    "sa_c_seq" => $sa_c_seq[$i],
                    "sa_input_price" => $sa_input_price[$i],
                    "sa_input_unit" => $sa_input_unit[$i],
                    "sa_input_date" => $sa_input_date[$i],
                    "sa_claim_name" => $sa_claim_name[$i],
                    "sa_bill_name" => $sa_bill_name[$i],
                    "sa_once_price" => $sa_once_price[$i],
                    "sa_month_price" => $sa_month_price[$i],
                    "sa_pay_day" => $sa_pay_day[$i],
                    "insert_yn" => "Y"
                );

                $this->db->insert("service_register_addoption",$data_addoption);
            }else{
                $data_addoption = array(
                    "sa_name" => $sa_name[$i],
                    "sa_sr_seq" => $sr_seq,
                    "sa_pr_seq" => $this->input->post("sr_pr_seq"),
                    "sa_pis_seq" => $pis_yn[$i],
                    "sa_c_seq" => $sa_c_seq[$i],
                    "sa_input_price" => $sa_input_price[$i],
                    "sa_input_unit" => $sa_input_unit[$i],
                    "sa_input_date" => $sa_input_date[$i],
                    "sa_claim_name" => $sa_claim_name[$i],
                    "sa_bill_name" => $sa_bill_name[$i],
                    "sa_once_price" => $sa_once_price[$i],
                    "sa_month_price" => $sa_month_price[$i],
                    "sa_pay_day" => $sa_pay_day[$i],
                    "insert_yn" => "Y"
                );
                $this->db->where("sa_seq",$sa_seq[$i]);
                $this->db->update("service_register_addoption",$data_addoption);
            }
        }

        $this->db->where("sa_sr_seq",$sr_seq);
        $this->db->where("insert_yn","N");
        $this->db->delete("service_register_addoption");

        if($this->input->post("sp_once_price_add") != ""){

            $data_insertyn["insert_yn"] = "N";
            $this->db->where("sap_sr_seq",$sr_seq);
            $this->db->update("service_register_addoption_price",$data_insertyn);

            $sap_seq = $this->input->post("sap_seq");
            $sp_once_price_add = $this->input->post("sp_once_price_add");
            $sp_once_dis_price_add = $this->input->post("sp_once_dis_price_add");
            $sp_once_dis_msg_add = $this->input->post("sp_once_dis_msg_add");
            $sp_discount_yn_add = $this->input->post("sp_discount_yn_add");
            $sp_month_price_add = $this->input->post("sp_month_price_add");
            $sp_month_dis_price_add = $this->input->post("sp_month_dis_price_add");
            $sp_month_dis_msg_add = $this->input->post("sp_month_dis_msg_add");
            $sp_discount_price_add = $this->input->post("sp_discount_price_add");
            $pis_seq_add = $this->input->post("pis_seq_add");
            $sp_register_discount_add = $this->input->post("sr_register_discount_add");

            for($i = 0; $i < count($sp_once_price_add);$i++){
                if($sap_seq[$i] == ""){
                    $this->db->select("*");
                    $this->db->from("service_register_addoption");
                    $this->db->where("sa_pis_seq",$pis_seq_add[$i]);
                    $this->db->where("sa_sr_seq",$sr_seq);
                    $query = $this->db->get();
                    $row = $query->row_array();

                    $data_addoption_price = array(
                        "sap_sa_seq" => $row["sa_seq"],
                        "sap_sr_seq" => $sr_seq,
                        "sap_once_price" => $sp_once_price_add[$i],
                        "sap_once_dis_price" => $sp_once_dis_price_add[$i],
                        "sap_once_dis_msg" => $sp_once_dis_msg_add[$i],
                        "sap_month_price" => $sp_month_price_add[$i],
                        "sap_month_dis_price" => $sp_month_dis_price_add[$i],
                        "sap_month_dis_msg" => $sp_month_dis_msg_add[$i],
                        "sap_discount_yn" => $sp_discount_yn_add[$i],
                        "sap_discount_price" => $sp_discount_price_add[$i],
                        "sap_register_discount" => $sp_register_discount_add[$i],
                        "insert_yn" => "Y"
                    );

                    $this->db->insert("service_register_addoption_price",$data_addoption_price);
                }else{
                    $data_addoption_price = array(
                        "sap_once_price" => $sp_once_price_add[$i],
                        "sap_once_dis_price" => $sp_once_dis_price_add[$i],
                        "sap_once_dis_msg" => $sp_once_dis_msg_add[$i],
                        "sap_month_price" => $sp_month_price_add[$i],
                        "sap_month_dis_price" => $sp_month_dis_price_add[$i],
                        "sap_month_dis_msg" => $sp_month_dis_msg_add[$i],
                        "sap_discount_yn" => $sp_discount_yn_add[$i],
                        "sap_discount_price" => $sp_discount_price_add[$i],
                        "sap_register_discount" => $sp_register_discount_add[$i],
                        "insert_yn" => "Y"
                    );
                    $this->db->where("sap_seq",$sap_seq[$i]);
                    $this->db->update("service_register_addoption_price",$data_addoption_price);
                }
            }
            $this->db->where("sap_sr_seq",$sr_seq);
            $this->db->where("insert_yn","N");
            $this->db->delete("service_register_addoption_price");
        }

        return true;
    }

    public function serviceRegisterDelete($sr_seq){
        $this->db->where("sr_seq",$sr_seq);

        return $this->db->delete("service_register");
    }

    public function selectServiceRegister($sr_seq){
        $this->db->select("*");
        $this->db->from("service_register");
        $this->db->where("sr_seq",$sr_seq);

        $query = $this->db->get();

        return $query->row_array();

    }

    public function serviceRegisterCopy($data){
        $new_data = array(
            "sr_mb_seq" => $data["sr_mb_seq"],
            "sr_eu_seq" => $data["sr_eu_seq"],
            "sr_ct_seq" => $data["sr_ct_seq"],
            "sr_code" => $data["sr_code"],
            "sr_part" => $data["sr_part"],
            "sr_charger" => $data["sr_charger"],
            "sr_contract_type" => $data["sr_contract_type"],
            "sr_contract_start" => $data["sr_contract_start"],
            "sr_contract_end" => $data["sr_contract_end"],
            "sr_auto_extension" => $data["sr_auto_extension"],
            "sr_auto_extension_month" => $data["sr_auto_extension_month"],
            "sr_register_discount" => $data["sr_register_discount"],
            "sr_payment_type" => $data["sr_payment_type"],
            "sr_payment_period" => $data["sr_payment_period"],
            "sr_pay_type" => $data["sr_pay_type"],
            "sr_pay_day" => $data["sr_pay_day"],
            "sr_pay_publish" => $data["sr_pay_publish"],
            "sr_pay_publish_type" => $data["sr_pay_publish_type"],
            "sr_payment_day" => $data["sr_payment_day"],
            "sr_account_start" => $data["sr_account_start"],
            "sr_account_end" => $data["sr_account_end"],
            "sr_account_type" => $data["sr_account_type"],
            "sr_account_start_day" => $data["sr_account_start_day"],
            "sr_account_format" => $data["sr_account_format"],
            "sr_account_format_policy" => $data["sr_account_format_policy"],
            "sr_pc_seq" => $data["sr_pc_seq"],
            "sr_pi_seq" => $data["sr_pi_seq"],
            "sr_pr_seq" => $data["sr_pr_seq"],
            "sr_pd_seq" => $data["sr_pd_seq"],
            "sr_ps_seq" => $data["sr_ps_seq"],
            "sr_claim_name" => $data["sr_claim_name"],
            "sr_rental" => $data["sr_rental"],
            "sr_bill_name" => $data["sr_bill_name"],
            "sr_once_price" => $data["sr_once_price"],
            "sr_month_price" => $data["sr_month_price"],
            "sr_c_seq" => $data["sr_c_seq"],
            "sr_input_price" => $data["sr_input_price"],
            "sr_rental_type" => $data["sr_rental_type"],
            "sr_rental_date" => $data["sr_rental_date"],
            "sr_after_price" => $data["sr_after_price"]
        );

        return $this->db->insert("service_register",$new_data);
    }

    public function countServiceRegister(){
        $this->db->select("count(*) as total");
        $this->db->from("service_register a");
        $this->db->join("members b","a.sr_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","a.sr_eu_seq = c.eu_seq","left");
        $this->db->join("product d","a.sr_pr_seq = d.pr_seq","left");

        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(sr_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(sr_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        if($this->input->get("sr_status") != ""){
            if(count($this->input->get("sr_status")) == 1){
                $this->db->where("sr_status",$this->input->get("sr_status")[0]);
            }else{
                $this->db->where_in("sr_status",array("0","1"));
            }
        }else{
            $this->db->where_in("sr_status",array("0","1"));
        }

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    public function fetchServiceRegister($start,$end){
        $this->db->select("*");
        $this->db->from("service_register a");
        $this->db->join("members b","a.sr_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","a.sr_eu_seq = c.eu_seq","left");
        $this->db->join("product d","a.sr_pr_seq = d.pr_seq","left");
        $this->db->join("product_category e","a.sr_pc_seq = e.pc_seq","left");
        $this->db->join("product_sub_div f","a.sr_ps_seq = f.ps_seq","left");


        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(sr_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(sr_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        if($this->input->get("sr_status") != ""){
            if(count($this->input->get("sr_status")) == 1){
                $this->db->where("sr_status",$this->input->get("sr_status")[0]);
            }else{
                $this->db->where_in("sr_status",array("0","1"));
            }
        }else{
            $this->db->where_in("sr_status",array("0","1"));
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    public function productSubDepth1Search($pr_seq){
        $this->db->select("b.pd_seq, b.pd_name");
        $this->db->from("product_sub a");
        $this->db->join("product_div b","a.prs_pd_seq = b.pd_seq","inner");
        $this->db->where("prs_pr_seq",$pr_seq);
        $this->db->where("prs_use_type","1");
        $this->db->group_by("prs_pd_seq");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function productSubDepth2Search($pr_seq,$prs_pd_seq){
        $this->db->select("b.ps_seq, b.ps_name,a.*");
        $this->db->from("product_sub a");
        $this->db->join("product_sub_div b","a.prs_ps_seq = b.ps_seq","inner");
        $this->db->where("prs_pr_seq",$pr_seq);
        $this->db->where("prs_pd_seq",$prs_pd_seq);
        $this->db->where("prs_use_type","1");

        $query = $this->db->get();
        return $query->result_array();
    }

    // 계약번호 중복체크
    public function serviceNumberCheck(){
        $this->db->select("*");
        $this->db->where("sr_code" , $this->input->get("sr_code"));
        $this->db->from("service_register");

        $query = $this->db->get();
        // 회원 사업자 or 생년월일이 중복일경우 true
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function fetchProductDiv($pc_seq){
        $this->db->select("*");
        $this->db->where("pd_pc_seq",$pc_seq);
        $this->db->from("product_div");
        $this->db->order_by("pd_sort");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchProductDivSub($pd_seq)
    {
        $this->db->select("*");
        $this->db->where("ps_pd_seq",$pd_seq);
        $this->db->from("product_sub_div");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function memberUpdate1($mb_seq)
    {
        $data = array(
            "mb_type"=>$this->input->post("mb_type"),
            "mb_name" => $this->input->post("mb_name"),
            "mb_zipcode" => $this->input->post("mb_zipcode"),
            "mb_address" => $this->input->post("mb_address"),
            "mb_detail_address" => $this->input->post("mb_detail_address"),
            "mb_tel" => $this->input->post("mb_tel"),
            "mb_email" => $this->input->post("mb_email"),
            "mb_number" => $this->input->post("mb_number"),
            "mb_ceo" => $this->input->post("mb_ceo"),
            "mb_phone" => $this->input->post("mb_phone"),
            "mb_fax" => $this->input->post("mb_fax")
        );

        $this->db->where("mb_seq",$mb_seq);

        return $this->db->update("members",$data);
    }

    public function memberUpdate2($mb_seq)
    {
        $data = array(
            "mb_bank"=>$this->input->post("mb_bank"),
            "mb_bank_name" => $this->input->post("mb_bank_name"),
            "mb_bank_name_relationship" => $this->input->post("mb_bank_name_relationship"),
            "mb_bank_input_number" => $this->input->post("mb_bank_input_number"),
            "mb_bank_number" => $this->input->post("mb_bank_number")
        );

        $this->db->where("mb_seq",$mb_seq);

        return $this->db->update("members",$data);
    }

    public function memberUpdate4($mb_seq)
    {
        $data = array(
            "mb_contract_name"=>$this->input->post("mb_contract_name"),
            "mb_contract_email" => $this->input->post("mb_contract_email"),
            "mb_contract_team" => $this->input->post("mb_contract_team"),
            "mb_contract_position" => $this->input->post("mb_contract_position"),
            "mb_contract_phone" => $this->input->post("mb_contract_phone"),
            "mb_contract_tel" => $this->input->post("mb_contract_tel")
        );

        $this->db->where("mb_seq",$mb_seq);

        return $this->db->update("members",$data);
    }

    public function memberUpdate5($mb_seq)
    {
        $data = array(
            "mb_contract_name"=>$this->input->post("mb_service_name"),
            "mb_contract_email" => $this->input->post("mb_service_email"),
            "mb_contract_team" => $this->input->post("mb_service_team"),
            "mb_contract_position" => $this->input->post("mb_service_position"),
            "mb_contract_phone" => $this->input->post("mb_service_phone"),
            "mb_contract_tel" => $this->input->post("mb_service_tel")
        );

        $this->db->where("mb_seq",$mb_seq);

        return $this->db->update("members",$data);
    }

    public function memberUpdate6($mb_seq)
    {
        $data = array(
            "mb_contract_name"=>$this->input->post("mb_payment_name"),
            "mb_contract_email" => $this->input->post("mb_payment_email"),
            "mb_contract_team" => $this->input->post("mb_payment_team"),
            "mb_contract_position" => $this->input->post("mb_payment_position"),
            "mb_contract_phone" => $this->input->post("mb_payment_phone"),
            "mb_contract_tel" => $this->input->post("mb_payment_tel")
        );

        $this->db->where("mb_seq",$mb_seq);

        return $this->db->update("members",$data);
    }

    public function selectInsertService($sr_seq){
        $this->db->select("*");
        $this->db->from("service_register");

        $this->db->where("sr_seq",$sr_seq);

        $query = $this->db->get();
        $row = $query->row_array();

        $new_data = array(
            "sv_sr_seq" => $sr_seq,
            "sv_mb_seq" => $row["sr_mb_seq"],
            "sv_eu_seq" => $row["sr_eu_seq"],
            "sv_ct_seq" => $row["sr_ct_seq"],
            "sv_code" => $row["sr_code"],
            "sv_part" => $row["sr_part"],
            "sv_charger" => $row["sr_charger"],
            "sv_contract_type" => $row["sr_contract_type"],
            "sv_contract_start" => $row["sr_contract_start"],
            "sv_contract_end" => $row["sr_contract_end"],
            "sv_auto_extension" => $row["sr_auto_extension"],
            "sv_auto_extension_month" => $row["sr_auto_extension_month"],
            "sv_register_discount" => $row["sr_register_discount"],
            "sv_payment_type" => $row["sr_payment_type"],
            "sv_payment_period" => $row["sr_payment_period"],
            "sv_pay_type" => $row["sr_pay_type"],
            "sv_pay_day" => $row["sr_pay_day"],
            "sv_pay_publish" => $row["sr_pay_publish"],
            "sv_pay_publish_type" => $row["sr_pay_publish_type"],
            "sv_payment_day" => $row["sr_payment_day"],
            "sv_account_start" => $row["sr_account_start"],
            "sv_account_end" => $row["sr_account_end"],
            "sv_account_type" => $row["sr_account_type"],
            "sv_account_start_day" => $row["sr_account_start_day"],
            "sv_account_format" => $row["sr_account_format"],
            "sv_account_format_policy" => $row["sr_account_format_policy"],
            "sv_pc_seq" => $row["sr_pc_seq"],
            "sv_pi_seq" => $row["sr_pi_seq"],
            "sv_pr_seq" => $row["sr_pr_seq"],
            "sv_pd_seq" => $row["sr_pd_seq"],
            "sv_ps_seq" => $row["sr_ps_seq"],
            "sv_claim_name" => $row["sr_claim_name"],
            "sv_rental" => $row["sr_rental"],
            "sv_bill_name" => $row["sr_bill_name"],
            "sv_once_price" => $row["sr_once_price"],
            "sv_month_price" => $row["sr_month_price"],
            "sv_c_seq" => $row["sr_c_seq"],
            "sv_input_price" => $row["sr_input_price"],
            "sv_rental_type" => $row["sr_rental_type"],
            "sv_rental_date" => $row["sr_rental_date"],
            "sv_after_price" => $row["sr_after_price"]
        );

        $this->db->insert("service",$new_data);

        $sv_seq = $this->db->insert_id();

        return $sv_seq;
    }

    public function selectInsertServicePrice($sv_seq,$sr_seq){
        $this->db->select("*");
        $this->db->from("service_register_price");
        $this->db->where("sp_sr_seq",$sr_seq);
        $query = $this->db->get();

        $row = $query->row_array();

        $data_price = array(
            "svp_sv_seq" => $sv_seq,
            "svp_ps_seq" => $row["sp_ps_seq"],
            "svp_once_price" => $row["sp_once_price"],
            "svp_once_dis_price" => $row["sp_once_dis_price"],
            "svp_once_dis_msg" => $row["sp_once_dis_msg"],
            "svp_month_price" => $row["sp_month_price"],
            "svp_month_dis_price" => $row["sp_month_dis_price"],
            "svp_month_dis_msg" => $row["sp_month_dis_msg"],
            "svp_discount_yn" => $row["sp_discount_yn"],
            "svp_discount_price" => $row["sp_discount_price"]
        );

        $this->db->insert("service_price",$data_price);
    }

    public function selectInsertServiceOption($sv_seq,$sr_seq){
        $this->db->select("*");
        $this->db->from("service_register_addoption");
        $this->db->where("sa_sr_seq",$sr_seq);
        $query = $this->db->get();

        foreach($query->result_array() as $row){
            $data_addoption = array(
                "sva_name" => $row["sa_name"],
                "sva_sv_seq" => $sv_seq,
                "sva_pr_seq" => $row["sa_pr_seq"],
                "sva_pis_seq" => $row["sa_pis_seq"],
                "sva_c_seq" => $row["sa_c_seq"],
                "sva_input_price" => $row["sa_input_price"],
                "sva_input_unit" => $row["sa_input_date"],
                "sva_input_date" => $row["sa_input_date"],
                "sva_claim_name" => $row["sa_claim_name"],
                "sva_bill_name" => $row["sa_bill_name"],
                "sva_once_price" => $row["sa_once_price"],
                "sva_month_price" => $row["sa_month_price"],
                "sva_pay_day" => $row["sa_pay_day"]
            );
            // print_r($data_addoption);
            $this->db->insert("service_addoption",$data_addoption);
            // echo $this->db->last_query();
            $sva_seq = $this->db->insert_id();

            $this->db->select("*");
            $this->db->from("service_register_addoption_price");
            $this->db->where("sap_sr_seq",$sr_seq);
            $this->db->where("sap_sa_seq",$row["sa_seq"]);
            $query = $this->db->get();

            foreach($query->result_array() as $row2){
                $data_addoption_price = array(
                    "svp_sv_seq" => $sv_seq,
                    "svp_sva_seq" => $sva_seq,
                    "svp_once_price" => $row2["sap_once_price"],
                    "svp_once_dis_price" => $row2["sap_once_dis_price"],
                    "svp_once_dis_msg" => $row2["sap_once_dis_msg"],
                    "svp_month_price" => $row2["sap_month_price"],
                    "svp_month_dis_price" => $row2["sap_month_dis_price"],
                    "svp_month_dis_msg" => $row2["sap_month_dis_msg"],
                    "svp_discount_yn" => $row2["sap_discount_yn"],
                    "svp_discount_price" => $row2["sap_discount_price"],
                    "svp_register_discount" => $row2["sap_register_discount"]
                );

                $this->db->insert("service_addoption_price",$data_addoption_price);
            }
        }

        return true;
    }

    public function updateServiceStatus($sr_seq){
        $data["sr_status"] = "1";
        $this->db->where("sr_seq",$sr_seq);

        return $this->db->update("service_register",$data);
    }

    public function countService(){
        $this->db->select("count(*) as total");
        $this->db->from("service a");
        $this->db->join("members b","a.sv_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","a.sv_eu_seq = c.eu_seq","left");
        $this->db->join("product d","a.sv_pr_seq = d.pr_seq","left");

        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(sv_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(sv_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        if($this->input->get("sv_status") != ""){
            if(count($this->input->get("sv_status")) == 1){
                $this->db->where("sv_status",$this->input->get("sv_status")[0]);
            }else{
                $this->db->where_in("sv_status",array("0","1"));
            }
        }else{
            $this->db->where_in("sv_status",array("0","1"));
        }

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    public function fetchService($start,$end){
        $this->db->select("*");
        $this->db->from("service a");
        $this->db->join("service_price ap","a.sv_seq=ap.svp_sv_seq","left" );
        $this->db->join("members b","a.sv_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","a.sv_eu_seq = c.eu_seq","left");
        $this->db->join("product d","a.sv_pr_seq = d.pr_seq","left");
        $this->db->join("product_category e","a.sv_pc_seq = e.pc_seq","left");
        $this->db->join("product_items ei","a.sv_pi_seq = ei.pi_seq","left");
        $this->db->join("product_div pd","a.sv_pd_seq = pd.pd_seq","left");
        $this->db->join("product_sub_div f","a.sv_ps_seq = f.ps_seq","left");
        $this->db->join("clients cl","a.sv_c_seq = cl.c_seq","left");


        if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
            $this->db->where("date_format(sv_regdate,'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(sv_regdate,'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
        }

        if($this->input->get("searchWord") != ""){
            $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        }

        if($this->input->get("sv_status") != ""){
            if(count($this->input->get("sv_status")) == 1){
                $this->db->where("sv_status",$this->input->get("sv_status")[0]);
            }else{
                $this->db->where_in("sv_status",array("0","1"));
            }
        }else{
            $this->db->where_in("sv_status",array("0","1"));
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchServiceAdd($sv_seq){
        $this->db->select("*");
        $this->db->from("service_addoption a");
        $this->db->join("service_addoption_price b","a.sva_seq = b.svp_sva_seq","inner");
        $this->db->where("sva_sv_seq",$sv_seq);

        $query = $this->db->get();

        return $query->result_array();
    }
}

?>