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
            if($this->input->get("memberSearchType") == "mb_phone"){
                $this->db->where(" (mb_tel LIKE '%".$this->input->get("memberSearchWord")."%' or mb_phone LIKE '%".$this->input->get("memberSearchWord")."%' ) ");
                // $this->db->like("mb_tel",$this->input->get("memberSearchWord"),'both');
            }else{
                $this->db->like($this->input->get("memberSearchType"),$this->input->get("memberSearchWord"),'both');
            }

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
        if($this->input->post("b_mb_type") != $this->input->post("mb_type")){
            $this->logInsert(1,$mb_seq,'회원 정보','회원 구분',$this->input->post("b_mb_type"),$this->input->post("mb_type"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_name") != $this->input->post("mb_name")){
            $this->logInsert(1,$mb_seq,'회원 정보','상호/이름',$this->input->post("b_mb_name"),$this->input->post("mb_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_number") != $this->input->post("mb_number")){
            $this->logInsert(1,$mb_seq,'회원 정보','사업자번호/생년월일',$this->input->post("b_mb_number"),$this->input->post("mb_number"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_ceo") != $this->input->post("mb_ceo")){
            $this->logInsert(1,$mb_seq,'회원 정보','대표자',$this->input->post("b_mb_ceo"),$this->input->post("mb_ceo"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_address") != $this->input->post("mb_address") || $this->input->post("b_mb_zipcode") != $this->input->post("mb_zipcode") || $this->input->post("b_mb_detail_address") != $this->input->post("mb_detail_address")){
            $this->logInsert(1,$mb_seq,'회원 정보','주소(한글)',$this->input->post("b_mb_zipcode")." ".$this->input->post("b_mb_address")." ".$this->input->post("b_mb_detail_address"),$this->input->post("mb_zipcode")." ".$this->input->post("mb_address")." ".$this->input->post("mb_detail_address"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_business_conditions") != $this->input->post("mb_business_conditions")){
            $this->logInsert(1,$mb_seq,'회원 정보','업태',$this->input->post("b_mb_business_conditions"),$this->input->post("mb_business_conditions"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_business_type") != $this->input->post("mb_business_type")){
            $this->logInsert(1,$mb_seq,'회원 정보','종목',$this->input->post("b_mb_business_type"),$this->input->post("mb_business_type"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_tel") != $this->input->post("mb_tel")){
            $this->logInsert(1,$mb_seq,'회원 정보','전화번호',$this->input->post("b_mb_tel"),$this->input->post("mb_tel"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_phone") != $this->input->post("mb_phone")){
            $this->logInsert(1,$mb_seq,'회원 정보','휴대폰번호',$this->input->post("b_mb_phone"),$this->input->post("mb_phone"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_email") != $this->input->post("mb_email")){
            $this->logInsert(1,$mb_seq,'회원 정보','이메일',$this->input->post("b_mb_email"),$this->input->post("mb_email"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_fax") != $this->input->post("mb_fax")){
            $this->logInsert(1,$mb_seq,'회원 정보','팩스',$this->input->post("b_mb_fax"),$this->input->post("mb_fax"),1,'',$_SERVER["REMOTE_ADDR"]);
        }

        if($this->input->post("b_mb_contract_name") != $this->input->post("mb_contract_name")){
            $this->logInsert(1,$mb_seq,'계약 담당자','이름',$this->input->post("b_mb_contract_name"),$this->input->post("mb_contract_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_contract_email") != $this->input->post("mb_contract_email")){
            $this->logInsert(1,$mb_seq,'계약 담당자','이메일',$this->input->post("b_mb_contract_email"),$this->input->post("mb_contract_email"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_contract_phone") != $this->input->post("mb_contract_phone")){
            $this->logInsert(1,$mb_seq,'계약 담당자','휴대폰번호',$this->input->post("b_mb_contract_phone"),$this->input->post("mb_contract_phone"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_contract_tel") != $this->input->post("mb_contract_tel")){
            $this->logInsert(1,$mb_seq,'계약 담당자','전화번호',$this->input->post("b_mb_contract_tel"),$this->input->post("mb_contract_tel"),1,'',$_SERVER["REMOTE_ADDR"]);
        }

        // if($this->input->post("b_mb_service_name") != $this->input->post("mb_service_name")){
        //     // $this->logInsert(1,$mb_seq,'운영 담당자','이름',$this->input->post("b_mb_service_name"),$this->input->post("mb_service_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }
        // if($this->input->post("b_mb_service_email") != $this->input->post("mb_service_email")){
        //     // $this->logInsert(1,$mb_seq,'운영 담당자','이메일',$this->input->post("b_mb_service_email"),$this->input->post("mb_service_email"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }
        // if($this->input->post("b_mb_service_phone") != $this->input->post("mb_service_phone")){
        //     // $this->logInsert(1,$mb_seq,'운영 담당자','휴대폰번호',$this->input->post("b_mb_service_phone"),$this->input->post("mb_service_phone"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }
        // if($this->input->post("b_mb_service_tel") != $this->input->post("mb_service_tel")){
        //     // $this->logInsert(1,$mb_seq,'운영 담당자','전화번호',$this->input->post("b_mb_service_tel"),$this->input->post("mb_service_tel"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }

        if($this->input->post("b_mb_payment_name") != $this->input->post("mb_payment_name")){
            $this->logInsert(1,$mb_seq,'요금 담당자','이름',$this->input->post("b_mb_payment_name"),$this->input->post("mb_payment_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_payment_email") != $this->input->post("mb_payment_email")){
            $this->logInsert(1,$mb_seq,'요금 담당자','이메일',$this->input->post("b_mb_payment_email"),$this->input->post("mb_payment_email"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_payment_phone") != $this->input->post("mb_payment_phone")){
            $this->logInsert(1,$mb_seq,'요금 담당자','휴대폰번호',$this->input->post("b_mb_payment_phone"),$this->input->post("mb_payment_phone"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_payment_tel") != $this->input->post("mb_payment_tel")){
            $this->logInsert(1,$mb_seq,'요금 담당자','전화번호',$this->input->post("b_mb_payment_tel"),$this->input->post("mb_service_tel"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
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
        // echo $query->num_rows();
        if($query->num_rows() == 0){
            return "AW100000-01";
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

    public function emailFile(){
        $data_insert_array = array();

        for($i = 0; $i < count($_FILES["mf_file"]["name"]);$i++){
            if($_FILES["mf_file"]["size"][$i] > 0){

                $ext = substr(strrchr(basename($_FILES['mf_file']["name"][$i]), '.'), 1);
                $file_name = time()."_".rand(1111,9999).".".$ext;
                move_uploaded_file($_FILES["mf_file"]['tmp_name'][$i],$_SERVER["DOCUMENT_ROOT"].'/uploads/email_file/'.$file_name);
                $data = array(
                    "mf_file" => $file_name,
                    "mf_origin_file" => $_FILES['mf_file']["name"][$i],
                    "mf_file_size" => $_FILES['mf_file']["size"][$i],
                    "mf_session_id" => session_id()
                );

                array_push($data_insert_array,$data);


            }
        }

        if(count($data_insert_array) > 0){
            $this->db->insert_batch("email_files",$data_insert_array);
        }

        return true;
    }

    public function emailFileList(){
        $this->db->select("*");
        $this->db->from("email_files");
        $this->db->where("mf_session_id",session_id());

        $this->db->order_by("mf_seq");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function emailFileDelete(){
        $mf_seq = explode(",",$this->input->get("checkSeq"));
        $this->db->select("*");
        $this->db->from("email_files");
        $this->db->where_in("mf_seq",$mf_seq);

        $query = $this->db->get();

        foreach($query->result_array() as $row){
            @unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/email_file/".$row["mf_file"]);
        }

        $this->db->where_in("mf_seq",$mf_seq);

        $this->db->delete("email_files");

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

    public function productItemSortUpdate(){
        $pi_seq = $this->input->post("pi_seq");
        for($i = 0; $i < count($pi_seq);$i++){
            $sql = "update product_items set pi_sort = '".($i+1)."' where pi_seq = '".$pi_seq[$i]."' ";
            $this->db->query($sql);
        }
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
    public function fetchProductItem($pc_seq){
        // $start = ($start - 1)*$limit;
        $this->db->select("*");
        $this->db->from("product_items a ");
        $this->db->where("pi_pc_seq",$pc_seq);

        $this->db->order_by("pi_sort asc");
        // $this->db->limit($limit,$start);

        // $sql = "select * from (select * from product_items order by pi_sort limit $start,$limit) a left join product_item_sub b on a.pi_seq = b.pis_pi_seq order by a.pi_sort";

        // $query = $this->db->query($sql);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
    }

    public function fetchProductItemSub($pi_seq){
        $this->db->select("a.*,b.c_name,c.pi_name,c_seq");
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
                $this->db->where(" (c_email LIKE '%".$this->input->get("searchWord")."%' or c_contract_email LIKE '%".$this->input->get("searchWord")."%' or c_payment_email LIKE '%".$this->input->get("searchWord")."%' )");
            }else if($this->input->get("searchType") == "c_contract_tel"){
                $this->db->where(" (c_contract_tel LIKE '%".$this->input->get("searchWord")."%' or c_payment_tel LIKE '%".$this->input->get("searchWord")."%'  )");
            }else if($this->input->get("searchType") == "c_contract_phone"){
                $this->db->where(" (c_contract_phone LIKE '%".$this->input->get("searchWord")."%' or c_payment_phone LIKE '%".$this->input->get("searchWord")."%'  )");
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
            if($this->input->get("searchType") == "c_email"){
                $this->db->where(" (c_email LIKE '%".$this->input->get("searchWord")."%' or c_contract_email LIKE '%".$this->input->get("searchWord")."%' or c_payment_email LIKE '%".$this->input->get("searchWord")."%' )");
            }else if($this->input->get("searchType") == "c_contract_tel"){
                $this->db->where(" (c_contract_tel LIKE '%".$this->input->get("searchWord")."%' or c_payment_tel LIKE '%".$this->input->get("searchWord")."%'  )");
            }else if($this->input->get("searchType") == "c_contract_phone"){
                $this->db->where(" (c_contract_phone LIKE '%".$this->input->get("searchWord")."%' or c_payment_phone LIKE '%".$this->input->get("searchWord")."%'  )");
            }else{
                $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
            }
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

    public function productSubAdd($pr_seq,$prs_pd_seq,$prs_ps_seq,$prs_price,$prs_div,$prs_one_price,$prs_one_type,$prs_one_percent,$prs_one_dis_price,$prs_one_after_price,$prs_month_price,$prs_month_type,$prs_month_percent,$prs_month_dis_price,$prs_month_after_price,$prs_use_type,$prs_msg){

        $data_sub = array(
            "prs_pr_seq" => $pr_seq,
            "prs_pd_seq" => $prs_pd_seq,
            "prs_ps_seq" => $prs_ps_seq,
            "prs_price" => str_replace(",","",$prs_price),
            "prs_div" => $prs_div,
            "prs_one_price" => str_replace(",","",$prs_one_price),
            "prs_one_type" => $prs_one_type,
            "prs_one_percent" => $prs_one_percent,
            "prs_one_dis_price" => str_replace(",","",$prs_one_dis_price),
            "prs_one_after_price" => str_replace(",","",$prs_one_after_price),
            "prs_month_price" => str_replace(",","",$prs_month_price),
            "prs_month_type" => $prs_month_type,
            "prs_month_percent" => $prs_month_percent,
            "prs_month_dis_price" => str_replace(",","",$prs_month_dis_price),
            "prs_month_after_price" => str_replace(",","",$prs_month_after_price),
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
        $this->db->select("a.pr_name , a.pr_seq ,a.pr_name as name,pr_c_seq,c_name");
        $this->db->from("product a");
        $this->db->join("clients c","a.pr_c_seq = c.c_seq","left");
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

    public function productSearchItem($pi_seq){
        $this->db->select("*");
        $this->db->from("product a");

        $this->db->where("pr_pi_seq",$pi_seq);

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

    public function productSubUpdate($prs_seq,$prs_pd_seq,$prs_ps_seq,$prs_price,$prs_div,$prs_one_price,$prs_one_type,$prs_one_percent,$prs_one_dis_price,$prs_one_after_price,$prs_month_price,$prs_month_type,$prs_month_percent,$prs_month_dis_price,$prs_month_after_price,$prs_use_type,$prs_msg){

        $data_sub = array(
            "prs_pd_seq" => $prs_pd_seq,
            "prs_ps_seq" => $prs_ps_seq,
            "prs_price" => str_replace(",","",$prs_price),
            "prs_div" => $prs_div,
            "prs_one_price" => str_replace(",","",$prs_one_price),
            "prs_one_type" => $prs_one_type,
            "prs_one_percent" => $prs_one_percent,
            "prs_one_dis_price" => str_replace(",","",$prs_one_dis_price),
            "prs_one_after_price" => str_replace(",","",$prs_one_after_price),
            "prs_month_price" => str_replace(",","",$prs_month_price),
            "prs_month_type" => $prs_month_type,
            "prs_month_percent" => $prs_month_percent,
            "prs_month_dis_price" => str_replace(",","",$prs_month_dis_price),
            "prs_month_after_price" => str_replace(",","",$prs_month_after_price),
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
            "sr_register_discount" => str_replace(",","",$this->input->post("sr_register_discount")),
            "sr_payment_type" => $this->input->post("sr_payment_type"),
            "sr_payment_period" => str_replace(",","",$this->input->post("sr_payment_period")),
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
            "sr_once_price" => str_replace(",","",$this->input->post("sr_once_price")),
            "sr_month_price" => str_replace(",","",$this->input->post("sr_month_price")),
            "sr_c_seq" => $this->input->post("sr_c_seq"),
            "sr_input_price" => str_replace(",","",$this->input->post("sr_input_price")),
            "sr_rental_type" => $this->input->post("sr_rental_type"),
            "sr_rental_date" => $this->input->post("sr_rental_date"),
            "sr_after_price" => str_replace(",","",$this->input->post("sr_after_price"))
        );

        $this->db->insert("service_register",$data);

        $sr_seq = $this->db->insert_id();

        $data_price = array(
            "sp_sr_seq" => $sr_seq,
            "sp_ps_seq" => $this->input->post("sr_ps_seq"),
            "sp_once_price" => str_replace(",","",$this->input->post("sr_once_price")),
            "sp_once_dis_price" => str_replace(",","",$this->input->post("sp_once_dis_price")),
            "sp_once_dis_msg" => $this->input->post("sp_once_dis_msg"),
            "sp_month_price" => str_replace(",","",$this->input->post("sp_month_price")),
            "sp_month_dis_price" => str_replace(",","",$this->input->post("sp_month_dis_price")),
            "sp_month_dis_msg" => $this->input->post("sp_month_dis_msg"),
            "sp_discount_yn" => $this->input->post("sp_discount_yn"),
            "sp_discount_price" => str_replace(",","",$this->input->post("sp_discount_price")),
            "sp_first_day_price" => str_replace(",","",$this->input->post("sp_first_price")),
            "sp_first_day_start" => $this->input->post("sp_first_start"),
            "sp_first_day_end" => $this->input->post("sp_first_end"),
            "sp_first_month_price" => str_replace(",","",$this->input->post("sp_first_month_price")),
            "sp_first_month_start" => $this->input->post("sp_first_month_start"),
            "sp_first_month_end" => $this->input->post("sp_first_month_end")
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
        if($this->input->post("pis_yn") != "")
            $pis_yn = $this->input->post("pis_yn");
        else
            $pis_yn = array();

        if($this->input->post("etc_yn_v") != "")
            $etc_yn = $this->input->post("etc_yn_v");
        else
            $etc_yn = array();
        $sa_pis_seq = $this->input->post("sa_pis_seq");

        for($i = 0; $i < count($pis_yn); $i++){
            // if($pis_yn[$i] == "Y"){
            $data_addoption = array(
                "sa_name" => $sa_name[$i],
                "sa_sr_seq" => $sr_seq,
                "sa_pr_seq" => $this->input->post("sr_pr_seq"),
                "sa_pis_seq" => $pis_yn[$i],
                "sa_c_seq" => $sa_c_seq[$i],
                "sa_input_price" => str_replace(",","",$sa_input_price[$i]),
                "sa_input_unit" => $sa_input_unit[$i],
                "sa_input_date" => $sa_input_date[$i],
                "sa_claim_name" => $sa_claim_name[$i],
                "sa_bill_name" => $sa_bill_name[$i],
                "sa_once_price" => str_replace(",","",$sa_once_price[$i]),
                "sa_month_price" => str_replace(",","",$sa_month_price[$i]),
                "sa_pay_day" => $sa_pay_day[$i]
            );

            $this->db->insert("service_register_addoption",$data_addoption);

            $sa_seq = $this->db->insert_id();
            // if($etc_yn[$i] == "Y"){

            // }
            // }
        }
        if($this->input->post("sp_once_price_add") != ""){
            // $etc_yn_v = $this->input->post("etc_yn_v");
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
            $sap_first_price_add = $this->input->post("sap_first_price_add");
            $sap_first_start_add = $this->input->post("sap_first_start_add");
            $sap_first_end_add = $this->input->post("sap_first_end_add");
            $sap_first_month_price_add = $this->input->post("sap_first_month_price_add");
            $sap_first_month_start_add = $this->input->post("sap_first_month_start_add");
            $sap_first_month_end_add = $this->input->post("sap_first_month_end_add");
            for($i = 0; $i < count($sp_once_price_add);$i++){


                $this->db->select("*");
                $this->db->from("service_register_addoption");
                $this->db->where("sa_pis_seq",$pis_seq_add[$i]);
                $this->db->order_by("sa_seq desc");
                $this->db->limit(1);
                $query = $this->db->get();
                $row = $query->row_array();

                $data_addoption_price = array(
                    "sap_sa_seq" => $row["sa_seq"],
                    "sap_sr_seq" => $sr_seq,
                    "sap_once_price" => str_replace(",","",$sp_once_price_add[$i]),
                    "sap_once_dis_price" => str_replace(",","",$sp_once_dis_price_add[$i]),
                    "sap_once_dis_msg" => $sp_once_dis_msg_add[$i],
                    "sap_month_price" => str_replace(",","",$sp_month_price_add[$i]),
                    "sap_month_dis_price" => str_replace(",","",$sp_month_dis_price_add[$i]),
                    "sap_month_dis_msg" => $sp_month_dis_msg_add[$i],
                    "sap_discount_yn" => $sp_discount_yn_add[$i],
                    "sap_discount_price" => str_replace(",","",$sp_discount_price_add[$i]),
                    "sap_register_discount" => str_replace(",","",$sp_register_discount_add[$i]),
                    "sap_first_day_price" => str_replace(",","",$sap_first_price_add[$i]),
                    "sap_first_day_start" => $sap_first_start_add[$i],
                    "sap_first_day_end" => $sap_first_end_add[$i],
                    "sap_first_month_price" => str_replace(",","",$sap_first_month_price_add[$i]),
                    "sap_first_month_start" => $sap_first_month_start_add[$i],
                    "sap_first_month_end" => $sap_first_month_end_add[$i]
                );

                $this->db->insert("service_register_addoption_price",$data_addoption_price);

                $addupdate["sa_claim_type"] = "0";
                $this->db->where("sa_seq" , $row["sa_seq"]);
                $this->db->update("service_register_addoption",$addupdate);

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
            "sr_once_price" => str_replace(",","",$this->input->post("sr_once_price")),
            "sr_month_price" => str_replace(",","",$this->input->post("sr_month_price")),
            "sr_c_seq" => $this->input->post("sr_c_seq"),
            "sr_input_price" => str_replace(",","",$this->input->post("sr_input_price")),
            "sr_rental_type" => $this->input->post("sr_rental_type"),
            "sr_rental_date" => $this->input->post("sr_rental_date"),
            "sr_after_price" => str_replace(",","",$this->input->post("sr_after_price"))
        );

        $this->db->where("sr_seq",$sr_seq);
        $this->db->update("service_register",$data);

        $data_price = array(
            "sp_ps_seq" => $this->input->post("sr_ps_seq"),
            "sp_once_price" => str_replace(",","",$this->input->post("sr_once_price")),
            "sp_once_dis_price" => str_replace(",","",$this->input->post("sp_once_dis_price")),
            "sp_once_dis_msg" => $this->input->post("sp_once_dis_msg"),
            "sp_month_price" => str_replace(",","",$this->input->post("sp_month_price"))/$this->input->post("sr_payment_period"),
            "sp_month_dis_price" => str_replace(",","",$this->input->post("sp_month_dis_price")),
            "sp_month_dis_msg" => $this->input->post("sp_month_dis_msg"),
            "sp_discount_yn" => $this->input->post("sp_discount_yn"),
            "sp_discount_price" => str_replace(",","",$this->input->post("sp_discount_price")),
            "sp_first_day_price" => str_replace(",","",$this->input->post("sp_first_price")),
            "sp_first_day_start" => $this->input->post("sp_first_start"),
            "sp_first_day_end" => $this->input->post("sp_first_end"),
            "sp_first_month_price" => str_replace(",","",$this->input->post("sp_first_month_price")),
            "sp_first_month_start" => $this->input->post("sp_first_month_start"),
            "sp_first_month_end" => $this->input->post("sp_first_month_end")
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
        if($this->input->post("pis_yn") != "")
            $pis_yn = $this->input->post("pis_yn");
        else
            $pis_yn = array();

        if($this->input->post("etc_yn") != "")
            $etc_yn = $this->input->post("etc_yn");
        else
            $etc_yn = array();

        $sa_pis_seq = $this->input->post("sa_pis_seq");

        for($i = 0; $i < count($pis_yn); $i++){
            if($sa_seq[$i] == ""){
                $data_addoption = array(
                    "sa_name" => $sa_name[$i],
                    "sa_sr_seq" => $sr_seq,
                    "sa_pr_seq" => $this->input->post("sr_pr_seq"),
                    "sa_pis_seq" => $pis_yn[$i],
                    "sa_c_seq" => $sa_c_seq[$i],
                    "sa_input_price" => str_replace(",","",$sa_input_price[$i]),
                    "sa_input_unit" => $sa_input_unit[$i],
                    "sa_input_date" => $sa_input_date[$i],
                    "sa_claim_name" => $sa_claim_name[$i],
                    "sa_bill_name" => $sa_bill_name[$i],
                    "sa_once_price" => str_replace(",","",$sa_once_price[$i]),
                    "sa_month_price" => str_replace(",","",$sa_month_price[$i]),
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
                    "sa_input_price" => str_replace(",","",$sa_input_price[$i]),
                    "sa_input_unit" => $sa_input_unit[$i],
                    "sa_input_date" => $sa_input_date[$i],
                    "sa_claim_name" => $sa_claim_name[$i],
                    "sa_bill_name" => $sa_bill_name[$i],
                    "sa_once_price" => str_replace(",","",$sa_once_price[$i]),
                    "sa_month_price" => str_replace(",","",$sa_month_price[$i]),
                    "sa_pay_day" => $sa_pay_day[$i],
                    "sa_claim_type" => "1",
                    "insert_yn" => "Y"
                );
                $this->db->where("sa_seq",$sa_seq[$i]);
                $this->db->update("service_register_addoption",$data_addoption);
            }
        }

        $this->db->where("sa_sr_seq",$sr_seq);
        $this->db->where("insert_yn","N");
        $this->db->delete("service_register_addoption");

        $data_insertyn["insert_yn"] = "N";
        $this->db->where("sap_sr_seq",$sr_seq);
        $this->db->update("service_register_addoption_price",$data_insertyn);
        if($this->input->post("sp_once_price_add") != ""){
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
            $sap_first_price_add = $this->input->post("sap_first_price_add");
            $sap_first_start_add = $this->input->post("sap_first_start_add");
            $sap_first_end_add = $this->input->post("sap_first_end_add");
            $sap_first_month_price_add = $this->input->post("sap_first_month_price_add");
            $sap_first_month_start_add = $this->input->post("sap_first_month_start_add");
            $sap_first_month_end_add = $this->input->post("sap_first_month_end_add");

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
                        "sap_once_price" => str_replace(",","",$sp_once_price_add[$i]),
                        "sap_once_dis_price" => str_replace(",","",$sp_once_dis_price_add[$i]),
                        "sap_once_dis_msg" => $sp_once_dis_msg_add[$i],
                        "sap_month_price" => str_replace(",","",$sp_month_price_add[$i]),
                        "sap_month_dis_price" => str_replace(",","",$sp_month_dis_price_add[$i]),
                        "sap_month_dis_msg" => $sp_month_dis_msg_add[$i],
                        "sap_discount_yn" => $sp_discount_yn_add[$i],
                        "sap_discount_price" => str_replace(",","",$sp_discount_price_add[$i]),
                        "sap_register_discount" => $sp_register_discount_add[$i],
                        "sap_first_day_price" => str_replace(",","",$sap_first_price_add[$i]),
                        "sap_first_day_start" => $sap_first_start_add[$i],
                        "sap_first_day_end" => $sap_first_end_add[$i],
                        "sap_first_month_price" => str_replace(",","",$sap_first_month_price_add[$i]),
                        "sap_first_month_start" => $sap_first_month_start_add[$i],
                        "sap_first_month_end" => $sap_first_month_end_add[$i],
                        "insert_yn" => "Y"
                    );

                    $this->db->insert("service_register_addoption_price",$data_addoption_price);
                    $addupdate["sa_claim_type"] = "0";
                    $this->db->where("sa_seq" , $row["sa_seq"]);
                    $this->db->update("service_register_addoption",$addupdate);
                }else{
                    $data_addoption_price = array(
                        "sap_once_price" => str_replace(",","",$sp_once_price_add[$i]),
                        "sap_once_dis_price" => str_replace(",","",$sp_once_dis_price_add[$i]),
                        "sap_once_dis_msg" => $sp_once_dis_msg_add[$i],
                        "sap_month_price" => str_replace(",","",$sp_month_price_add[$i]),
                        "sap_month_dis_price" => str_replace(",","",$sp_month_dis_price_add[$i]),
                        "sap_month_dis_msg" => $sp_month_dis_msg_add[$i],
                        "sap_discount_yn" => $sp_discount_yn_add[$i],
                        "sap_discount_price" => str_replace(",","",$sp_discount_price_add[$i]),
                        "sap_register_discount" => str_replace(",","",$sp_register_discount_add[$i]),
                        "sap_first_day_price" => str_replace(",","",$sap_first_price_add[$i]),
                        "sap_first_day_start" => $sap_first_start_add[$i],
                        "sap_first_day_end" => $sap_first_end_add[$i],
                        "sap_first_month_price" => str_replace(",","",$sap_first_month_price_add[$i]),
                        "sap_first_month_start" => $sap_first_month_start_add[$i],
                        "sap_first_month_end" => $sap_first_month_end_add[$i],
                        "insert_yn" => "Y"
                    );
                    $this->db->where("sap_seq",$sap_seq[$i]);
                    $this->db->update("service_register_addoption_price",$data_addoption_price);

                    $this->db->select("*");
                    $this->db->from("service_register_addoption_price");
                    $this->db->where("sap_seq",$sap_seq[$i]);
                    // $this->db->where("sa_sr_seq",$sr_seq);
                    $query = $this->db->get();
                    $row = $query->row_array();

                    $addupdate["sa_claim_type"] = "0";
                    $this->db->where("sa_seq" , $row["sap_sa_seq"]);
                    $this->db->update("service_register_addoption",$addupdate);
                }
            }

        }
        $this->db->where("sap_sr_seq",$sr_seq);
        $this->db->where("insert_yn","N");
        $this->db->delete("service_register_addoption_price");
        return true;
    }

    public function serviceRegisterDelete($sr_seq){
        $this->db->where("sap_sr_seq",$sr_seq);
        $this->db->delete("service_register_addoption_price");
        $this->db->where("sa_sr_seq",$sr_seq);
        $this->db->delete("service_register_addoption");
        $this->db->where("sp_sr_seq",$sr_seq);
        $this->db->delete("service_register_price");

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

    public function serviceRegisterCopy($data,$sr_seq){
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

        $this->db->insert("service_register",$new_data);

        $new_sr_seq = $this->db->insert_id();

        $this->db->select("*");
        $this->db->from("service_register_price");
        $this->db->where("sp_sr_seq",$sr_seq);
        $query = $this->db->get();
        $price_row = $query->row_array();
        $data_price = array(
            "sp_sr_seq" => $new_sr_seq,
            "sp_ps_seq" => $price_row["sp_ps_seq"],
            "sp_once_price" => $price_row["sp_once_price"],
            "sp_once_dis_price" => $price_row["sp_once_dis_price"],
            "sp_once_dis_msg" => $price_row["sp_once_dis_msg"],
            "sp_month_price" => $price_row["sp_month_price"],
            "sp_month_dis_price" => $price_row["sp_month_dis_price"],
            "sp_month_dis_msg" => $price_row["sp_month_dis_msg"],
            "sp_discount_yn" => $price_row["sp_discount_yn"],
            "sp_discount_price" => $price_row["sp_discount_price"],
            "sp_first_day_price" => $price_row["sp_first_day_price"],
            "sp_first_day_start" => $price_row["sp_first_day_start"],
            "sp_first_day_end" => $price_row["sp_first_day_end"],
            "sp_first_month_price" => $price_row["sp_first_month_price"],
            "sp_first_month_start" => $price_row["sp_first_month_start"],
            "sp_first_month_end" => $price_row["sp_first_month_end"]
        );
        $this->db->insert("service_register_price",$data_price);
        $this->db->select("*");
        $this->db->from("service_register_addoption");
        $this->db->where("sa_sr_seq",$sr_seq);
        $this->db->order_by("sa_seq");
        $query = $this->db->get();

        foreach($query->result_array() as $row){
            $data_addoption = array(
                "sa_name" => $row["sa_name"],
                "sa_sr_seq" => $new_sr_seq,
                "sa_pr_seq" => $row["sa_pr_seq"],
                "sa_pis_seq" => $row["sa_pis_seq"],
                "sa_c_seq" => $row["sa_c_seq"],
                "sa_input_price" => $row["sa_input_price"],
                "sa_input_unit" => $row["sa_input_unit"],
                "sa_input_date" => $row["sa_input_date"],
                "sa_claim_name" => $row["sa_claim_name"],
                "sa_bill_name" => $row["sa_bill_name"],
                "sa_once_price" => $row["sa_once_price"],
                "sa_month_price" => $row["sa_month_price"],
                "sa_pay_day" => $row["sa_pay_day"]
            );

            $this->db->insert("service_register_addoption",$data_addoption);

            $new_sa_seq = $this->db->insert_id();

            $this->db->select("*");
            $this->db->from("service_register_addoption_price");
            $this->db->where("sap_sa_seq",$row["sa_seq"]);

            $query2 = $this->db->get();
            if($query2->num_rows() > 0){
                $row2 = $query2->row_array();

                $data_addoption_price = array(
                    "sap_sa_seq" => $new_sa_seq,
                    "sap_sr_seq" => $new_sr_seq,
                    "sap_once_price" => $row2["sap_once_price"],
                    "sap_once_dis_price" => $row2["sap_once_dis_price"],
                    "sap_once_dis_msg" => $row2["sap_once_dis_msg"],
                    "sap_month_price" => $row2["sap_month_price"],
                    "sap_month_dis_price" => $row2["sap_month_dis_price"],
                    "sap_month_dis_msg" => $row2["sap_month_dis_msg"],
                    "sap_discount_yn" => $row2["sap_discount_yn"],
                    "sap_discount_price" => $row2["sap_discount_price"],
                    "sap_register_discount" => $row2["sap_register_discount"],
                    "sap_first_day_price" => $row2["sap_first_day_price"],
                    "sap_first_day_start" => $row2["sap_first_day_start"],
                    "sap_first_day_end" => $row2["sap_first_day_end"],
                    "sap_first_month_price" => $row2["sap_first_month_price"],
                    "sap_first_month_start" => $row2["sap_first_month_start"],
                    "sap_first_month_end" => $row2["sap_first_month_end"]
                );

                $this->db->insert("service_register_addoption_price",$data_addoption_price);
            }
        }

        return true;


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
        $this->db->order_by("a.sr_seq desc");
        $this->db->limit($end,$start);
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
        if($this->input->post("b_mb_type") != $this->input->post("mb_type")){
            $this->logInsert(1,$mb_seq,'회원 정보','회원 구분',$this->input->post("b_mb_type"),$this->input->post("mb_type"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_name") != $this->input->post("mb_name")){
            $this->logInsert(1,$mb_seq,'회원 정보','상호/이름',$this->input->post("b_mb_name"),$this->input->post("mb_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_number") != $this->input->post("mb_number")){
            $this->logInsert(1,$mb_seq,'회원 정보','사업자번호/생년월일',$this->input->post("b_mb_number"),$this->input->post("mb_number"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_ceo") != $this->input->post("mb_ceo")){
            $this->logInsert(1,$mb_seq,'회원 정보','대표자',$this->input->post("b_mb_ceo"),$this->input->post("mb_ceo"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_address") != $this->input->post("mb_address") || $this->input->post("b_mb_zipcode") != $this->input->post("mb_zipcode") || $this->input->post("b_mb_detail_address") != $this->input->post("mb_detail_address")){
            $this->logInsert(1,$mb_seq,'회원 정보','주소(한글)',$this->input->post("b_mb_zipcode")." ".$this->input->post("b_mb_address")." ".$this->input->post("b_mb_detail_address"),$this->input->post("mb_zipcode")." ".$this->input->post("mb_address")." ".$this->input->post("mb_detail_address"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        // if($this->input->post("b_mb_business_conditions") != $this->input->post("mb_business_conditions")){
        //     $this->logInsert(1,$mb_seq,'회원 정보','업태',$this->input->post("b_mb_business_conditions"),$this->input->post("mb_business_conditions"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }
        // if($this->input->post("b_mb_business_type") != $this->input->post("mb_business_type")){
        //     $this->logInsert(1,$mb_seq,'회원 정보','종목',$this->input->post("b_mb_business_type"),$this->input->post("mb_business_type"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }
        if($this->input->post("b_mb_tel") != $this->input->post("mb_tel")){
            $this->logInsert(1,$mb_seq,'회원 정보','전화번호',$this->input->post("b_mb_tel"),$this->input->post("mb_tel"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_phone") != $this->input->post("mb_phone")){
            $this->logInsert(1,$mb_seq,'회원 정보','휴대폰번호',$this->input->post("b_mb_phone"),$this->input->post("mb_phone"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_email") != $this->input->post("mb_email")){
            $this->logInsert(1,$mb_seq,'회원 정보','이메일',$this->input->post("b_mb_email"),$this->input->post("mb_email"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_fax") != $this->input->post("mb_fax")){
            $this->logInsert(1,$mb_seq,'회원 정보','팩스',$this->input->post("b_mb_fax"),$this->input->post("mb_fax"),1,'',$_SERVER["REMOTE_ADDR"]);
        }

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
        // if($this->input->post("b_mb_contract_name") != $this->input->post("mb_contract_name")){
        //     $this->logInsert(1,$mb_seq,'계약 담당자','이름',$this->input->post("b_mb_contract_name"),$this->input->post("mb_contract_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }
        // if($this->input->post("b_mb_contract_email") != $this->input->post("mb_contract_email")){
        //     $this->logInsert(1,$mb_seq,'계약 담당자','이메일',$this->input->post("b_mb_contract_email"),$this->input->post("mb_contract_email"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }
        // if($this->input->post("b_mb_contract_phone") != $this->input->post("mb_contract_phone")){
        //     $this->logInsert(1,$mb_seq,'계약 담당자','휴대폰번호',$this->input->post("b_mb_contract_phone"),$this->input->post("mb_contract_phone"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }
        // if($this->input->post("b_mb_contract_tel") != $this->input->post("mb_contract_tel")){
        //     $this->logInsert(1,$mb_seq,'계약 담당자','전화번호',$this->input->post("b_mb_contract_tel"),$this->input->post("mb_contract_tel"),1,'',$_SERVER["REMOTE_ADDR"]);
        // }
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
        if($this->input->post("b_mb_service_name") != $this->input->post("mb_service_name")){
            $this->logInsert(1,$mb_seq,'운영 담당자','이름',$this->input->post("b_mb_service_name"),$this->input->post("mb_service_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_service_email") != $this->input->post("mb_service_email")){
            $this->logInsert(1,$mb_seq,'운영 담당자','이메일',$this->input->post("b_mb_service_email"),$this->input->post("mb_service_email"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_service_phone") != $this->input->post("mb_service_phone")){
            $this->logInsert(1,$mb_seq,'운영 담당자','휴대폰번호',$this->input->post("b_mb_service_phone"),$this->input->post("mb_service_phone"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_service_tel") != $this->input->post("mb_service_tel")){
            $this->logInsert(1,$mb_seq,'운영 담당자','전화번호',$this->input->post("b_mb_service_tel"),$this->input->post("mb_service_tel"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        $data = array(
            "mb_service_name"=>$this->input->post("mb_service_name"),
            "mb_service_email" => $this->input->post("mb_service_email"),
            "mb_service_team" => $this->input->post("mb_service_team"),
            "mb_service_position" => $this->input->post("mb_service_position"),
            "mb_service_phone" => $this->input->post("mb_service_phone"),
            "mb_service_tel" => $this->input->post("mb_service_tel")
        );

        $this->db->where("mb_seq",$mb_seq);

        return $this->db->update("members",$data);
    }

    public function memberUpdate6($mb_seq)
    {
        if($this->input->post("b_mb_payment_name") != $this->input->post("mb_payment_name")){
            $this->logInsert(1,$mb_seq,'요금 담당자','이름',$this->input->post("b_mb_payment_name"),$this->input->post("mb_payment_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_payment_email") != $this->input->post("mb_payment_email")){
            $this->logInsert(1,$mb_seq,'요금 담당자','이메일',$this->input->post("b_mb_payment_email"),$this->input->post("mb_payment_email"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_payment_phone") != $this->input->post("mb_payment_phone")){
            $this->logInsert(1,$mb_seq,'요금 담당자','휴대폰번호',$this->input->post("b_mb_payment_phone"),$this->input->post("mb_payment_phone"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_mb_payment_tel") != $this->input->post("mb_payment_tel")){
            $this->logInsert(1,$mb_seq,'요금 담당자','전화번호',$this->input->post("b_mb_payment_tel"),$this->input->post("mb_service_tel"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        $data = array(
            "mb_payment_name"=>$this->input->post("mb_payment_name"),
            "mb_payment_email" => $this->input->post("mb_payment_email"),
            "mb_payment_team" => $this->input->post("mb_payment_team"),
            "mb_payment_position" => $this->input->post("mb_payment_position"),
            "mb_payment_phone" => $this->input->post("mb_payment_phone"),
            "mb_payment_tel" => $this->input->post("mb_payment_tel")
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

        $this->db->select("sv_number");
        $this->db->from("service");
        $this->db->order_by("sv_seq","desc");
        $this->db->limit(1);
        $query2 = $this->db->get();

        if($query2->num_rows() == 0){
            $sv_number = "SVCES0000001";
        }else{
            $max_row = $query2->row_array();
            $max_row1 = substr($max_row["sv_number"],0,5);
            $max_row2 = (int)substr($max_row["sv_number"],5,7);
            $max_row2 = $max_row2+1;

            $sv_number = $max_row1.sprintf("%07d",$max_row2);
        }

        $this->db->select("prs_div");
        $this->db->from("product_sub");
        $this->db->where("prs_pr_seq",$row["sr_pr_seq"]);
        $this->db->where("prs_pd_seq",$row["sr_pd_seq"]);
        $this->db->where("prs_ps_seq",$row["sr_ps_seq"]);
        $this->db->limit(1);
        $query_ps = $this->db->get();

        $ps_row = $query_ps->row_array();

        // $old_num = $max_row["sv_number"];

        $new_data = array(
            "sv_sr_seq" => $sr_seq,
            "sv_mb_seq" => $row["sr_mb_seq"],
            "sv_eu_seq" => $row["sr_eu_seq"],
            "sv_ct_seq" => $row["sr_ct_seq"],
            "sv_code" => $row["sr_code"],
            "sv_number" => $sv_number,
            "sv_part" => $row["sr_part"],
            "sv_charger" => $row["sr_charger"],
            "sv_contract_type" => $row["sr_contract_type"],
            "sv_contract_start" => $row["sr_contract_start"],
            "sv_contract_end" => $row["sr_contract_end"],
            "sv_contract_extension_end" => $row["sr_contract_end"],
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
            "sv_account_policy" => $row["sr_account_policy"],
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
            "sv_after_price" => $row["sr_after_price"],
            "sv_input_unit" => $ps_row["prs_div"],
            "sv_input_start" => $row["sr_account_start"]
        );

        $this->db->insert("service",$new_data);

        $sv_seq = $this->db->insert_id();

        $this->db->select("*");
        $this->db->from("service_register_price");
        $this->db->where("sp_sr_seq",$sr_seq);
        $query = $this->db->get();

        $row2 = $query->row_array();

        $data_price = array(
            "svp_sv_seq" => $sv_seq,
            "svp_ps_seq" => $row2["sp_ps_seq"],
            "svp_once_price" => $row2["sp_once_price"],
            "svp_once_dis_price" => $row2["sp_once_dis_price"],
            "svp_once_dis_msg" => $row2["sp_once_dis_msg"],
            "svp_month_price" => $row2["sp_month_price"],
            "svp_month_dis_price" => $row2["sp_month_dis_price"],
            "svp_month_dis_msg" => $row2["sp_month_dis_msg"],
            "svp_discount_yn" => $row2["sp_discount_yn"],
            "svp_discount_price" => $row2["sp_discount_price"],
            "svp_register_discount" => $row["sr_register_discount"],
            "svp_first_day_price" => $row2["sp_first_day_price"],
            "svp_first_day_start" => $row2["sp_first_day_start"],
            "svp_first_day_end" => $row2["sp_first_day_end"],
            "svp_first_month_price" => $row2["sp_first_month_price"],
            "svp_first_month_start" => $row2["sp_first_month_start"],
            "svp_first_month_end" => $row2["sp_first_month_end"],
            "svp_payment_period" => $row["sr_payment_period"]
        );

        $this->db->insert("service_price",$data_price);

        $data_history = array(
            "sh_sv_code" => $row["sr_code"],
            "sh_type" => 0,
            "sh_date" => date("Y-m-d"),
            "sh_service_start"=>$row["sr_contract_start"],
            "sh_service_end" => $row["sr_contract_end"],
            "sh_auto_extension" => $row["sr_auto_extension"],
            "sh_auto_extension_month" => $row["sr_auto_extension_month"]
        );

        $this->db->insert("service_history",$data_history);

        $pay_day = $row["sr_pay_day"];
        if($row["sr_pay_type"] == "0"){ // 전월
            // $standard_day = substr($row["sr_account_start"],8,2);
            // if($pay_day > $standard_day){
            //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sr_account_start"],5,2)-1,substr($row["sr_account_start"],8,2),substr($row["sr_account_start"],0,4)));
            // }else{
            //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sr_account_start"],5,2),substr($row["sr_account_start"],8,2),substr($row["sr_account_start"],0,4)));
            // }
            $claim_date = date("Y-m-d");
        }else if($row["sr_pay_type"] == "1"){ // 당월
            $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sr_account_start"],5,2),substr($row["sr_account_start"],8,2),substr($row["sr_account_start"],0,4)));
        }else if($row["sr_pay_type"] == "2"){ // 익월
            $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sr_account_start"],5,2)+1,substr($row["sr_account_start"],8,2),substr($row["sr_account_start"],0,4)));
        }

        $end_date = date("Y-m-d",mktime(0,0,0,substr($claim_date,5,2),substr($claim_date,8,2)+$row["sr_payment_day"],substr($claim_date,0,4)));

        $this->db->select("pm_ca_seq");
        $this->db->from("payment");
        $this->db->where("pm_mb_seq",$row["sr_mb_seq"]);
        $this->db->where("pm_date",$claim_date);
        $this->db->where("pm_payment_publish_type",$row["sr_pay_publish_type"]);
        $this->db->where("pm_end_date",$end_date);
        $this->db->limit(1);
        $query_claim = $this->db->get();
        if($query_claim->num_rows() > 0){
            $row_claim = $query_claim->row_array();
            $pm_ca_seq = $row_claim["pm_ca_seq"];
        }else{
            $pm_ca_seq = "";
        }

        $this->db->select("pm_code");
        $this->db->from("payment");
        $this->db->order_by("pm_seq","desc");
        $this->db->limit(1);
        $query_code = $this->db->get();

        if($query_code->num_rows() == 0){
            $pm_code = "CHA0000001";
        }else{
            $max_row = $query_code->row_array();
            $max_row1 = substr($max_row["pm_code"],0,3);
            $max_row2 = (int)substr($max_row["pm_code"],3,7);
            $max_row2 = $max_row2+1;

            $pm_code = $max_row1.sprintf("%07d",$max_row2);
        }
        $total_price = $row2["sp_once_price"]-$row2["sp_once_dis_price"]+$row2["sp_month_price"]-$row2["sp_month_dis_price"]-$row2["sp_discount_price"]+$row2["sp_first_day_price"];
        $payment_data = array(
            "pm_type" => "1",
            "pm_mb_seq" => $row["sr_mb_seq"],
            "pm_sv_seq" => $sv_seq,
            "pm_code" => $pm_code,
            "pm_date" => $claim_date,
            "pm_service_start" => $row["sr_account_start"],
            "pm_service_end" =>  $row["sr_account_end"],
            "pm_pay_type" => $row["sr_pay_type"],
            "pm_pay_period" => $row["sr_payment_period"],
            "pm_once_price" => $row2["sp_once_price"],
            "pm_once_dis_price" => $row2["sp_once_dis_price"],
            "pm_once_dis_msg" => $row2["sp_once_dis_msg"],
            "pm_service_price" => $row2["sp_month_price"],
            "pm_service_dis_price" => $row2["sp_month_dis_price"],
            "pm_service_dis_msg" => $row2["sp_month_dis_msg"],
            "pm_payment_dis_price" => $row2["sp_discount_price"],
            "pm_delay_price" => 0,
            "pm_total_price" => $total_price,
            "pm_surtax_price" => $total_price*0.1,
            "pm_end_date" => $end_date,
            "pm_status" => 0,
            "pm_first_day_price" => $row2["sp_first_day_price"],
            "pm_first_day_start" => $row2["sp_first_day_start"],
            "pm_first_day_end" => $row2["sp_first_day_end"],
            "pm_first_month_price" => $row2["sp_first_month_price"],
            "pm_first_month_start" => $row2["sp_first_month_start"],
            "pm_first_month_end" => $row2["sp_first_month_end"],
            "pm_payment_publish_type" => $row["sr_pay_publish_type"],
            "pm_ca_seq" => $pm_ca_seq,
            "pm_claim_type" => "0"
        );
        $this->db->insert("payment",$payment_data);

        $pm_seq = $this->db->insert_id();

        if($pm_ca_seq != ""){
            $this->db->select("*");
            $this->db->from("payment_claim_list");
            $this->db->where("cl_ca_seq",$pm_ca_seq);
            $this->db->where("ca_sort",1);
            $query_c = $this->db->get();


            if($query_c->num_rows() > 0){
                $row_cl = $query_c->row_array();
                $ca_item_price = $row_cl["ca_item_price"]+$total_price;
                $ca_item_surtax = $row_cl["ca_item_surtax"]+$total_price*0.1;
                if($row_cl["ca_m_sv_num"] < $sv_number){
                    $ca_m_sv_num = $sv_number;
                    $ca_item_name = $row["sr_bill_name"];
                }else{
                    $ca_m_sv_num = $row_cl["ca_m_sv_num"];
                    $ca_item_name = $row_cl["ca_item_name"];
                }
                $data_claim_detail = array(
                    "ca_item_name" => $ca_item_name,
                    "ca_item_price" => $ca_item_price,
                    "ca_item_surtax" => $ca_item_surtax,
                    "ca_m_sv_num" => $ca_m_sv_num
                );
                $this->db->where("cl_seq",$row_cl["cl_seq"]);
                $this->db->update("payment_claim_list",$data_claim_detail);
            }else{
                $data_claim_detail = array(
                    "cl_ca_seq" => $pm_ca_seq,
                    "ca_item_name" => $row["sr_bill_name"],
                    "ca_item_price" => $total_price,
                    "ca_item_surtax" => floor($total_price*0.1),
                    "ca_sort" => 1,
                    "ca_m_sv_num" => $sv_number
                );
                $this->db->insert("payment_claim_list",$data_claim_detail);
            }


            $this->db->select("*");
            $this->db->from("payment_claim");
            $this->db->where("ca_seq",$pm_ca_seq);
            $claim_query = $this->db->get();
            $row_c = $claim_query->row_array();
            $total_claim_price = $row_c["ca_price"]+$total_price;
            $total_claim_surtax = $row_c["ca_surtax"]+floor($total_price*0.1);
            $total_claim_total_price = $total_claim_price+$total_claim_surtax;
            $ca_empty_size = 11 - strlen($total_claim_total_price);
            $ca_price_info1 = $total_claim_total_price;
            $ca_price_info2 = $total_claim_total_price;

            $data_update = array(
                "ca_price" => $total_claim_price,
                "ca_surtax" => $total_claim_surtax,
                "ca_total_price" => $total_claim_total_price,
                "ca_empty_size" => $ca_empty_size,
                "ca_price_info1" => $ca_price_info1,
                "ca_price_info2" => $ca_price_info2
            );
            $this->db->where("ca_seq",$pm_ca_seq);
            $this->db->update("payment_claim",$data_update);
        }else{
            $this->db->select("*");
            $this->db->from("members");
            $this->db->where("mb_seq",$row["sr_mb_seq"]);
            $query_member = $this->db->get();

            $row_member = $query_member->row_array();

            $data_claim = array(
                "ca_from_number" => "215-87-70318",
                "ca_to_number" => $row_member["mb_number"],
                "ca_from_name" => "아이온 시큐리티",
                "ca_to_name" => $row_member["mb_name"],
                "ca_from_ceo" => "김성혁",
                "ca_to_ceo" => $row_member["mb_ceo"],
                "ca_from_address" => "서울특별시 서초구 서초대로 255",
                "ca_to_address"=> $row_member["mb_address"],
                "ca_from_condition" => "서비스 외",
                "ca_to_condition" => $row_member["mb_business_conditions"],
                "ca_from_type" => "보안서비스 및 용역제공",
                "ca_to_type" => $row_member["mb_business_type"],
                "ca_from_team" => "영업2팀",
                "ca_to_team" => $row_member["mb_payment_team"],
                "ca_from_charger" => "전이준",
                "ca_to_charger" => $row_member["mb_payment_name"],
                "ca_from_tel" => "",
                "ca_to_tel" => $row_member["mb_payment_tel"],
                "ca_from_email" => "ijjun@eyeonsec.co.kr",
                "ca_to_email" => $row_member["mb_payment_email"],
                "ca_date" => $claim_date,
                "ca_price" => $total_price,
                "ca_surtax" => floor($total_price*0.1),
                "ca_total_price" => floor($total_price*1.1),
                "ca_empty_size" => 11-strlen(floor($total_price*1.1)),
                "ca_price_info1" => floor($total_price*1.1),
                "ca_price_info2" => floor($total_price*1.1),
                "ca_price_info3" => 0,
                "ca_price_info4" => 0,
                "ca_price_info5" => 0,
                "ca_payment_type" => $row["sr_pay_publish_type"],
                "ca_mb_seq" => $row["sr_mb_seq"]
            );
            $this->db->insert("payment_claim",$data_claim);

            $cl_ca_seq = $this->db->insert_id();
            $data_claim_d = array(
                "cl_ca_seq" => $cl_ca_seq,
                "ca_item_name" => $row["sr_bill_name"],
                "ca_item_price" => $total_price,
                "ca_item_surtax" => floor($total_price*0.1),
                "ca_sort" => 1,
                "ca_m_sv_num" => $sv_number
            );
            $this->db->insert("payment_claim_list",$data_claim_d);

            $data_pm_ca_seq["pm_ca_seq"] = $cl_ca_seq;
            $this->db->where("pm_seq",$pm_seq);
            $this->db->update("payment",$data_pm_ca_seq);
        }
        // $this->db->select("*");
        // $this->db->from("payment_claim");
        // $this->db->where("ca_mb_seq",$row["sr_mb_seq"]);
        // $this->db->where("ca_date",)
        // $claim_data = array(

        // );


        return $sv_seq;
    }

    public function selectInsertServiceOption($sv_seq,$sr_seq){
        $this->db->select("*");
        $this->db->from("service_register");

        $this->db->where("sr_seq",$sr_seq);

        $query = $this->db->get();
        $row_sr = $query->row_array();

        $this->db->select("*");
        $this->db->from("service_register_addoption");
        $this->db->where("sa_sr_seq",$sr_seq);
        $query = $this->db->get();



        foreach($query->result_array() as $row){
            $this->db->select("sva_number");
            $this->db->from("service_addoption");
            $this->db->order_by("sva_seq","desc");
            $this->db->limit(1);
            $query2 = $this->db->get();

            if($query2->num_rows() == 0){
                $sva_number = "OSS000001";
            }else{
                $max_row = $query2->row_array();
                $max_row1 = substr($max_row["sva_number"],0,3);
                $max_row2 = (int)substr($max_row["sva_number"],3,6);
                $max_row2 = $max_row2+1;

                $sva_number = $max_row1.sprintf("%06d",$max_row2);
            }
            $data_addoption = array(
                "sva_name" => $row["sa_name"],
                "sva_number" => $sva_number,
                "sva_sv_seq" => $sv_seq,
                "sva_pr_seq" => $row["sa_pr_seq"],
                "sva_pis_seq" => $row["sa_pis_seq"],
                "sva_c_seq" => $row["sa_c_seq"],
                "sva_input_price" => $row["sa_input_price"],
                "sva_input_unit" => $row["sa_input_unit"],
                "sva_input_date" => $row["sa_input_date"],
                "sva_claim_name" => $row["sa_claim_name"],
                "sva_bill_name" => $row["sa_bill_name"],
                "sva_once_price" => $row["sa_once_price"],
                "sva_month_price" => $row["sa_month_price"],
                "sva_pay_day" => $row["sa_pay_day"],
                "sva_claim_type" => $row["sa_claim_type"]
            );
            // print_r($data_addoption);
            $this->db->insert("service_addoption",$data_addoption);
            // echo $this->db->last_query();
            $sva_seq = $this->db->insert_id();

            // $price_data = array(
            //     "ap_sv_seq" => $sv_seq,
            //     "ap_sva_seq" => $sva_seq
            // );

            $this->db->select("*");
            $this->db->from("service_register_addoption_price");
            $this->db->where("sap_sr_seq",$sr_seq);
            $this->db->where("sap_sa_seq",$row["sa_seq"]);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                foreach($query->result_array() as $row2){
                    $data_addoption_price = array(
                        "svp_sv_seq" => $sv_seq,
                        "svp_sva_seq" => $sva_seq,
                        "svp_once_price" => $row2["sap_once_price"],
                        "svp_once_dis_price" => $row2["sap_once_dis_price"],
                        "svp_once_dis_msg" => $row2["sap_once_dis_msg"],
                        "svp_month_price" => $row2["sap_month_price"]/$row["sa_pay_day"],
                        "svp_month_dis_price" => $row2["sap_month_dis_price"],
                        "svp_month_dis_msg" => $row2["sap_month_dis_msg"],
                        "svp_discount_yn" => $row2["sap_discount_yn"],
                        "svp_discount_price" => $row2["sap_discount_price"],
                        "svp_register_discount" => $row2["sap_register_discount"],
                        "svp_first_day_price" => $row2["sap_first_day_price"],
                        "svp_first_day_start" => $row2["sap_first_day_start"],
                        "svp_first_day_end" => $row2["sap_first_day_end"],
                        "svp_first_month_price" => $row2["sap_first_month_price"],
                        "svp_first_month_start" => $row2["sap_first_month_start"],
                        "svp_first_month_end" => $row2["sap_first_month_end"],
                        "svp_payment_period" => $row["sa_pay_day"]
                    );

                    $this->db->insert("service_price",$data_addoption_price);

                    // $price_data["ap_once_price"] = $row2["sap_once_price"];
                    // $price_data["ap_once_dis_price"] = $row2["sap_once_dis_price"];
                    // $price_data["ap_price"] = $row2["sap_month_price"];
                    // $price_data["ap_dis_price"] = $row2["sap_month_dis_price"];
                    // $price_data["ap_type_dis_price"] = $row2["sap_discount_price"];
                    // $price_data["ap_first_price"] = $row2["sap_first_price"];

                    $pay_day = $row_sr["sr_pay_day"];
                    if($row_sr["sr_pay_type"] == "0"){ // 전월
                        // $standard_day = substr($row_sr["sr_account_start"],8,2);
                        // if($pay_day > $standard_day){
                        //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row_sr["sr_account_start"],5,2)-1,substr($row_sr["sr_account_start"],8,2),substr($row_sr["sr_account_start"],0,4)));
                        // }else{
                        //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row_sr["sr_account_start"],5,2),substr($row_sr["sr_account_start"],8,2),substr($row_sr["sr_account_start"],0,4)));
                        // }
                        $claim_date = date("Y-m-d");
                    }else if($row_sr["sr_pay_type"] == "1"){ // 당월
                        $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row_sr["sr_account_start"],5,2),substr($row_sr["sr_account_start"],8,2),substr($row_sr["sr_account_start"],0,4)));
                    }else if($row_sr["sr_pay_type"] == "2"){ // 익월
                        $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row_sr["sr_account_start"],5,2)+1,substr($row_sr["sr_account_start"],8,2),substr($row_sr["sr_account_start"],0,4)));
                    }
                    $end_date = date("Y-m-d",mktime(0,0,0,substr($claim_date,5,2),substr($claim_date,8,2)+$row_sr["sr_payment_day"],substr($claim_date,0,4)));

                    $this->db->select("pm_ca_seq");
                    $this->db->from("payment");
                    $this->db->where("pm_mb_seq",$row_sr["sr_mb_seq"]);
                    $this->db->where("pm_date",$claim_date);
                    $this->db->where("pm_payment_publish_type",$row_sr["sr_pay_publish_type"]);
                    $this->db->where("pm_end_date",$end_date);
                    $this->db->limit(1);
                    $query_claim = $this->db->get();
                    if($query_claim->num_rows() > 0){
                        $row_claim = $query_claim->row_array();
                        $pm_ca_seq = $row_claim["pm_ca_seq"];
                    }else{
                        $pm_ca_seq = "";
                    }

                    $this->db->select("pm_code");
                    $this->db->from("payment");
                    $this->db->order_by("pm_seq","desc");
                    $this->db->limit(1);
                    $query_code = $this->db->get();

                    if($query_code->num_rows() == 0){
                        $pm_code = "CHA0000001";
                    }else{
                        $max_row = $query_code->row_array();
                        $max_row1 = substr($max_row["pm_code"],0,3);
                        $max_row2 = (int)substr($max_row["pm_code"],3,7);
                        $max_row2 = $max_row2+1;

                        $pm_code = $max_row1.sprintf("%07d",$max_row2);
                    }
                    $total_price = $row2["sap_once_price"]-$row2["sap_once_dis_price"]+$row2["sap_month_price"]-$row2["sap_month_dis_price"]-$row2["sap_discount_price"]+$row2["sap_first_day_price"];
                    $pm_service_end = date("Y-m-d",mktime(0,0,0,substr($row_sr["sr_account_start"],5,2)+$row["sa_pay_day"],substr($row_sr["sr_account_start"],8,2)-1,substr($row_sr["sr_account_start"],0,4)));
                    $payment_data = array(
                        "pm_type" => "1",
                        "pm_mb_seq" => $row_sr["sr_mb_seq"],
                        "pm_sv_seq" => $sv_seq,
                        "pm_sva_seq" => $sva_seq,
                        "pm_code" => $pm_code,
                        "pm_date" => $claim_date,
                        "pm_service_start" => $row_sr["sr_account_start"],
                        "pm_service_end" =>  $pm_service_end,
                        "pm_pay_type" => $row_sr["sr_pay_type"],
                        "pm_pay_period" => $row["sa_pay_day"],
                        "pm_once_price" => $row2["sap_once_price"],
                        "pm_once_dis_price" => $row2["sap_once_dis_price"],
                        "pm_service_price" => $row2["sap_month_price"]/$row["sa_pay_day"],
                        "pm_service_dis_price" => $row2["sap_month_dis_price"],
                        "pm_payment_dis_price" => $row2["sap_discount_price"],
                        "pm_delay_price" => 0,
                        "pm_total_price" => $total_price,
                        "pm_surtax_price" => floor($total_price*0.1),
                        "pm_end_date" => $end_date,
                        "pm_status" => 0,
                        "pm_first_day_price" => $row2["sap_first_day_price"],
                        "pm_first_day_start" => $row2["sap_first_day_start"],
                        "pm_first_day_end" => $row2["sap_first_day_end"],
                        "pm_first_month_price" => $row2["sap_first_month_price"],
                        "pm_first_month_start" => $row2["sap_first_month_start"],
                        "pm_first_month_end" => $row2["sap_first_month_end"],
                        "pm_payment_publish_type" => $row_sr["sr_pay_publish_type"],
                        "pm_ca_seq" => $pm_ca_seq,
                        "pm_claim_type" => "0"
                    );
                    $this->db->insert("payment",$payment_data);

                    $pm_seq = $this->db->insert_id();

                    if($pm_ca_seq != ""){
                        $this->db->select("*");
                        $this->db->from("payment_claim_list");
                        $this->db->where("cl_ca_seq",$pm_ca_seq);
                        $this->db->where("ca_sort",1);
                        $query_c = $this->db->get();


                        if($query_c->num_rows() > 0){
                            $row_cl = $query_c->row_array();
                            $ca_item_price = $row_cl["ca_item_price"]+$total_price;
                            $ca_item_surtax = $row_cl["ca_item_surtax"]+$total_price*0.1;

                            $data_claim_detail = array(
                                "ca_item_price" => $ca_item_price,
                                "ca_item_surtax" => $ca_item_surtax
                            );
                            $this->db->where("cl_seq",$row_cl["cl_seq"]);
                            $this->db->update("payment_claim_list",$data_claim_detail);
                        }else{
                            $data_claim_detail = array(
                                "cl_ca_seq" => $pm_ca_seq,
                                "ca_item_name" => $row_sr["sv_bill_name"],
                                "ca_item_price" => $total_price,
                                "ca_item_surtax" => floor($total_price*0.1),
                                "ca_sort" => 1,
                                "ca_m_sv_num" => $row_sr["sv_number"]
                            );
                            $this->db->insert("payment_claim_list",$data_claim_detail);
                        }


                        $this->db->select("*");
                        $this->db->from("payment_claim");
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $claim_query = $this->db->get();
                        $row_c = $claim_query->row_array();
                        $total_claim_price = $row_c["ca_price"]+$total_price;
                        $total_claim_surtax = $row_c["ca_surtax"]+floor($total_price*0.1);
                        $total_claim_total_price = $total_claim_price+$total_claim_surtax;
                        $ca_empty_size = 11 - strlen($total_claim_total_price);
                        $ca_price_info1 = $total_claim_total_price;
                        $ca_price_info2 = $total_claim_total_price;

                        $data_update = array(
                            "ca_price" => $total_claim_price,
                            "ca_surtax" => $total_claim_surtax,
                            "ca_total_price" => $total_claim_total_price,
                            "ca_empty_size" => $ca_empty_size,
                            "ca_price_info1" => $ca_price_info1,
                            "ca_price_info2" => $ca_price_info2
                        );
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $this->db->update("payment_claim",$data_update);
                    }else{
                        $this->db->select("*");
                        $this->db->from("members");
                        $this->db->where("mb_seq",$row["sr_mb_seq"]);
                        $query_member = $this->db->get();

                        $row_member = $query_member->row_array();

                        $data_claim = array(
                            "ca_from_number" => "215-87-70318",
                            "ca_to_number" => $row_member["mb_number"],
                            "ca_from_name" => "아이온 시큐리티",
                            "ca_to_name" => $row_member["mb_name"],
                            "ca_from_ceo" => "김성혁",
                            "ca_to_ceo" => $row_member["mb_ceo"],
                            "ca_from_address" => "서울특별시 서초구 서초대로 255",
                            "ca_to_address"=> $row_member["mb_address"],
                            "ca_from_condition" => "서비스 외",
                            "ca_to_condition" => $row_member["mb_business_conditions"],
                            "ca_from_type" => "보안서비스 및 용역제공",
                            "ca_to_type" => $row_member["mb_business_type"],
                            "ca_from_team" => "영업2팀",
                            "ca_to_team" => $row_member["mb_payment_team"],
                            "ca_from_charger" => "전이준",
                            "ca_to_charger" => $row_member["mb_payment_name"],
                            "ca_from_tel" => "",
                            "ca_to_tel" => $row_member["mb_payment_tel"],
                            "ca_from_email" => "ijjun@eyeonsec.co.kr",
                            "ca_to_email" => $row_member["mb_payment_email"],
                            "ca_date" => $claim_date,
                            "ca_price" => $total_price,
                            "ca_surtax" => floor($total_price*0.1),
                            "ca_total_price" => floor($total_price*1.1),
                            "ca_empty_size" => 11-strlen(floor($total_price*1.1)),
                            "ca_price_info1" => floor($total_price*1.1),
                            "ca_price_info2" => floor($total_price*1.1),
                            "ca_price_info3" => 0,
                            "ca_price_info4" => 0,
                            "ca_price_info5" => 0,
                            "ca_payment_type" => $row_sr["sr_pay_publish_type"],
                            "ca_mb_seq" => $row_sr["sr_mb_seq"]
                        );
                        $this->db->insert("payment_claim",$data_claim);

                        $cl_ca_seq = $this->db->insert_id();
                        $data_claim_d = array(
                            "cl_ca_seq" => $cl_ca_seq,
                            "ca_item_name" => $row["sa_bill_name"],
                            "ca_item_price" => $total_price,
                            "ca_item_surtax" => floor($total_price*0.1),
                            "ca_sort" => 1,
                            "ca_m_sv_num" => $row_sr["sv_number"]
                        );
                        $this->db->insert("payment_claim_list",$data_claim_d);

                        $data_pm_ca_seq["pm_ca_seq"] = $cl_ca_seq;
                        $this->db->where("pm_seq",$pm_seq);
                        $this->db->update("payment",$data_pm_ca_seq);
                    }
                }
            }else{
                $data_addoption_price = array(
                    "svp_sv_seq" => $sv_seq,
                    "svp_sva_seq" => $sva_seq,
                    "svp_once_price" => 0,
                    "svp_once_dis_price" => 0,
                    "svp_once_dis_msg" => '',
                    "svp_month_price" => 0,
                    "svp_month_dis_price" => 0,
                    "svp_month_dis_msg" => '',
                    "svp_discount_yn" => 'N',
                    "svp_discount_price" => 0,
                    "svp_register_discount" => 0,
                    "svp_first_day_price" => 0,
                    "svp_first_day_start" => '',
                    "svp_first_day_end" => '',
                    "svp_first_month_price" => 0,
                    "svp_first_month_start" => '',
                    "svp_first_month_end" => '',
                    "svp_payment_period" => 0,
                    "svp_display_yn" => 'N'
                );

                $this->db->insert("service_price",$data_addoption_price);
            }

            // $this->db->insert("service_all_price",$price_data);
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

        if($this->input->get("sv_date") != ""){
            $sv_date = $this->input->get("sv_date");
            for($i = 0; $i < count($sv_date);$i++){
                if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
                    $this->db->where("date_format(".$sv_date[$i].",'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(".$sv_date[$i].",'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
                }
            }
        }

        // if($this->input->get("searchWord") != ""){
        //     $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        // }

        if($this->input->get("sv_status") != ""){

            $this->db->where_in("sv_status",$this->input->get("sv_status"));
        }

        if($this->input->get("pc_seq") != ""){
            $this->db->where_in("sv_pc_seq",$this->input->get("pc_seq"));
        }

        if($this->input->get("pi_seq") != ""){
            $this->db->where_in("sv_pi_seq",$this->input->get("pi_seq"));
        }

        if($this->input->get("pd_seq") != ""){
            $this->db->where_in("sv_pd_seq",$this->input->get("pd_seq"));
        }

        if($this->input->get("ps_seq") != ""){
            $this->db->where_in("sv_ps_seq",$this->input->get("ps_seq"));
        }

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    public function fetchService($start,$end){
        $this->db->select("*,(select concat(ifnull(sum(svp_once_price),0),'|',ifnull(sum(svp_once_dis_price),0),'|',ifnull(sum(svp_month_price),0),'|',ifnull(sum(svp_month_dis_price),0),'|',ifnull(sum(svp_discount_price/svp_payment_period),0)) from service_price where a.sv_seq = svp_sv_seq ) as priceinfo,(select concat(pm_status,'|',pm_pay_period,'|',pm_date,'|',pm_end_date,'|',ifnull(pm_input_date,'')) from payment where pm_sv_seq = a.sv_seq order by pm_seq desc limit 1) as paymentinfo,(select count(*) from service_addoption where sva_sv_seq = a.sv_seq) as addoptionTotal,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 1 limit 1),'') as file1,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 2 limit 1),'') as file2,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 3 limit 1),'') as file3,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 4 limit 1),'') as file4,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 5 limit 1),'') as file5,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 6 limit 1),'') as file6,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 7 limit 1),'') as file7,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 8 limit 1),'') as file8",true);
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

        if($this->input->get("sv_date") != ""){
            $sv_date = $this->input->get("sv_date");
            for($i = 0; $i < count($sv_date);$i++){
                if($this->input->get("startDate") != "" && $this->input->get("endDate") != ""){
                    $this->db->where("date_format(".$sv_date[$i].",'%Y-%m-%d') >= '".$this->input->get("startDate")."' and date_format(".$sv_date[$i].",'%Y-%m-%d') <= '".$this->input->get("endDate")."' ");
                }
            }
        }


        // if($this->input->get("searchWord") != ""){
        //     $this->db->like($this->input->get("searchType"),$this->input->get("searchWord"),'both');
        // }

        if($this->input->get("sv_status") != ""){

            $this->db->where_in("sv_status",$this->input->get("sv_status"));
        }

        if($this->input->get("pc_seq") != ""){
            $this->db->where_in("sv_pc_seq",$this->input->get("pc_seq"));
        }

        if($this->input->get("pi_seq") != ""){
            $this->db->where_in("sv_pi_seq",$this->input->get("pi_seq"));
        }

        if($this->input->get("pd_seq") != ""){
            $this->db->where_in("sv_pd_seq",$this->input->get("pd_seq"));
        }

        if($this->input->get("ps_seq") != ""){
            $this->db->where_in("sv_ps_seq",$this->input->get("ps_seq"));
        }

        $this->db->group_by("sv_seq");
        $this->db->order_by("sv_seq desc");
        $this->db->limit($end,$start);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchServiceAdd($sv_seq){
        $this->db->select("*,(select concat(pm_status,'|',pm_pay_period,'|',pm_date,'|',pm_end_date,'|',ifnull(pm_input_date,'')) from payment where pm_sv_seq = sv.sv_seq order by pm_seq desc limit 1) as paymentinfo",true);
        $this->db->from("service_addoption a");
        $this->db->join("service sv","a.sva_sv_seq = sv.sv_seq","inner");
        $this->db->join("service_price b","a.sva_seq = b.svp_sva_seq","left");
        $this->db->join("clients cl","a.sva_c_seq = cl.c_seq","left");
        $this->db->where("sva_sv_seq",$sv_seq);
        $this->db->where("svp_display_yn","Y");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchMemberService($mb_seq){
        $this->db->select("*,(select concat(ifnull(sum(svp_once_price),0),'|',ifnull(sum(svp_once_dis_price),0),'|',ifnull(sum(svp_month_price),0),'|',ifnull(sum(svp_month_dis_price),0),'|',ifnull(sum(svp_discount_price/svp_payment_period),0)) from service_price where a.sv_seq = svp_sv_seq ) as priceinfo,(select concat(pm_status,'|',pm_pay_period,'|',pm_date,'|',pm_end_date,'|',ifnull(pm_input_date,'')) from payment where pm_sv_seq = a.sv_seq order by pm_seq desc limit 1) as paymentinfo ,(select count(*) from service_addoption where sva_sv_seq = a.sv_seq) as addoptionTotal,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 1 limit 1),'') as file1,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 2 limit 1),'') as file2,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 3 limit 1),'') as file3,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 4 limit 1),'') as file4,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 5 limit 1),'') as file5,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 6 limit 1),'') as file6,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 7 limit 1),'') as file7,ifnull((select sf_origin_file from service_files where a.sv_seq = sf_sv_seq and sf_type = 8 limit 1),'') as file8",true);
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


        $this->db->where("mb_seq",$mb_seq);
        $this->db->group_by("sv_seq");
        $this->db->order_by("sv_seq desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchMemberPayment($mb_seq){
        $this->db->select("*");
        $this->db->from("service_price a");
        $this->db->join("service sv","a.svp_sv_seq=sv.sv_seq","left" );
        $this->db->join("members b","sv.sv_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","sv.sv_eu_seq = c.eu_seq","left");
        $this->db->join("product d","sv.sv_pr_seq = d.pr_seq","left");
        $this->db->join("product_category e","sv.sv_pc_seq = e.pc_seq","left");
        $this->db->join("product_items ei","sv.sv_pi_seq = ei.pi_seq","left");
        $this->db->join("product_div pd","sv.sv_pd_seq = pd.pd_seq","left");
        $this->db->join("product_sub_div f","sv.sv_ps_seq = f.ps_seq","left");
        $this->db->join("clients cl","sv.sv_c_seq = cl.c_seq","left");
        $this->db->join("service_addoption sa","a.svp_sva_seq = sa.sva_seq","left");


        $this->db->where("mb_seq",$mb_seq);
        $this->db->order_by("sv_seq desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchMemberPaymentClaim($mb_seq){
        $this->db->select("*");
        $this->db->from("service_price a");
        $this->db->join("claims aa","aa.cl_seq = a.svp_cl_seq","left");
        $this->db->join("service sv","a.svp_sv_seq=sv.sv_seq","left" );
        $this->db->join("members b","sv.sv_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","sv.sv_eu_seq = c.eu_seq","left");
        $this->db->join("product d","sv.sv_pr_seq = d.pr_seq","left");
        $this->db->join("product_category e","sv.sv_pc_seq = e.pc_seq","left");
        $this->db->join("product_items ei","sv.sv_pi_seq = ei.pi_seq","left");
        $this->db->join("product_div pd","sv.sv_pd_seq = pd.pd_seq","left");
        $this->db->join("product_sub_div f","sv.sv_ps_seq = f.ps_seq","left");
        $this->db->join("clients cl","sv.sv_c_seq = cl.c_seq","left");
        $this->db->join("service_addoption sa","a.svp_sva_seq = sa.sva_seq","left");


        $this->db->where("mb_seq",$mb_seq);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchClaimDetail(){
        $this->db->select("*");
        $this->db->from("claim_detail a");
        $this->db->join("claims aa","aa.cl_seq = a.cd_cl_seq","left");
        $this->db->join("service_price svp","a.cd_svp_seq = svp.svp_seq","left");
        $this->db->join("service sv","svp.svp_sv_seq=sv.sv_seq","left" );
        $this->db->join("members b","sv.sv_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","sv.sv_eu_seq = c.eu_seq","left");
        $this->db->join("product d","sv.sv_pr_seq = d.pr_seq","left");
        $this->db->join("product_category e","sv.sv_pc_seq = e.pc_seq","left");
        $this->db->join("product_items ei","sv.sv_pi_seq = ei.pi_seq","left");
        $this->db->join("product_div pd","sv.sv_pd_seq = pd.pd_seq","left");
        $this->db->join("product_sub_div f","sv.sv_ps_seq = f.ps_seq","left");
        $this->db->join("clients cl","sv.sv_c_seq = cl.c_seq","left");
        $this->db->join("service_addoption sa","svp.svp_sva_seq = sa.sva_seq","left");


    
        $this->db->where("cl_seq",$this->input->get("cl_seq"));

        $query = $this->db->get();

        return $query->result_array();
    }

    public function memberPaymentView($svp_seq){
        $this->db->select("*");
        $this->db->from("service_price a");
        $this->db->join("service sv","a.svp_sv_seq=sv.sv_seq","left" );
        $this->db->join("members b","sv.sv_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","sv.sv_eu_seq = c.eu_seq","left");
        $this->db->join("product d","sv.sv_pr_seq = d.pr_seq","left");
        $this->db->join("product_category e","sv.sv_pc_seq = e.pc_seq","left");
        $this->db->join("product_items ei","sv.sv_pi_seq = ei.pi_seq","left");
        $this->db->join("product_div pd","sv.sv_pd_seq = pd.pd_seq","left");
        $this->db->join("product_sub_div f","sv.sv_ps_seq = f.ps_seq","left");
        $this->db->join("clients cl","sv.sv_c_seq = cl.c_seq","left");
        $this->db->join("service_addoption sa","a.svp_sva_seq = sa.sva_seq","left");


        $this->db->where("svp_seq",$svp_seq);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function paymentView($pm_seq){
        $this->db->select("*");
        $this->db->from("payment a");
        $this->db->join("service sv","a.pm_sv_seq=sv.sv_seq","left" );
        $this->db->join("service_price svp","sv.sv_seq=svp.svp_sv_seq","left" );
        $this->db->join("service_addoption sva","a.pm_sva_seq=sva.sva_seq","left" );
        $this->db->join("members b","sv.sv_mb_seq = b.mb_seq","left");
        $this->db->join("end_users c","sv.sv_eu_seq = c.eu_seq","left");
        $this->db->join("product d","sv.sv_pr_seq = d.pr_seq","left");
        $this->db->join("product_category e","sv.sv_pc_seq = e.pc_seq","left");
        $this->db->join("product_items ei","sv.sv_pi_seq = ei.pi_seq","left");
        $this->db->join("product_div pd","sv.sv_pd_seq = pd.pd_seq","left");
        $this->db->join("product_sub_div f","sv.sv_ps_seq = f.ps_seq","left");
        $this->db->join("clients cl","sv.sv_c_seq = cl.c_seq","left");


        $this->db->where("pm_seq",$pm_seq);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function paymentMemoAdd(){
        $data = array(
            "po_mb_seq" => $this->input->post("po_mb_seq"),
            "po_input_date" => $this->input->post("po_input_date"),
            "po_memo" => $this->input->post("po_memo"),
            "po_regdate" => date("Y-m-d H:i:s")
        );

        return $this->db->insert("payment_memo",$data);
    }

    public function fetchPaymentMemo($po_mb_seq){
        $this->db->select("*");
        $this->db->from("payment_memo");
        $this->db->where("po_mb_seq",$po_mb_seq);
        $this->db->order_by("po_seq desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function paymentMemoUpdate(){
        $data = array(
            "po_input_date" => $this->input->post("po_input_date"),
            "po_memo" => $this->input->post("po_memo")
        );
        $this->db->where("po_seq",$this->input->post("po_seq"));
        return $this->db->update("payment_memo",$data);
    }

    public function paymentMemoDelete(){

        $this->db->where("po_seq",$this->input->get("po_seq"));
        return $this->db->delete("payment_memo");
    }

    public function paymentAdd(){
        $data = array(
            "pm_mb_seq" => $this->input->post("pm_mb_seq"),
            "pm_sv_seq" => $this->input->post("pm_sv_seq"),
            "pm_code" => $this->input->post("pm_code"),
            "pm_date" => $this->input->post("pm_date"),
            "pm_service_start" => $this->input->post("pm_service_start"),
            "pm_service_end" => $this->input->post("pm_service_end"),
            "pm_pay_type" => $this->input->post("pm_pay_type"),
            "pm_pay_period" => $this->input->post("pm_pay_period"),
            "pm_once_price" => str_replace(",","",$this->input->post("pm_once_price")),
            "pm_once_dis_price" => str_replace(",","",$this->input->post("pm_once_dis_price")),
            "pm_first_price" => str_replace(",","",$this->input->post("pm_first_price")),
            "pm_service_price" => str_replace(",","",$this->input->post("pm_service_price")),
            "pm_service_dis_price" => str_replace(",","",$this->input->post("pm_service_dis_price")),
            "pm_payment_dis_price" => str_replace(",","",$this->input->post("pm_payment_dis_price")),
            "pm_delay_price" => str_replace(",","",$this->input->post("pm_delay_price")),
            "pm_total_price" => str_replace(",","",$this->input->post("pm_total_price")),
            "pm_surtax_price" => str_replace(",","",$this->input->post("pm_surtax_price")),
            "pm_end_date" => $this->input->post("pm_end_date"),
            "pm_status" => $this->input->post("pm_status")
        );

        return $this->db->insert("payment",$data);
    }

    public function paymentUpdate(){
        $data = array(
            "pm_date" => $this->input->post("pm_date"),
            "pm_service_start" => $this->input->post("pm_service_start"),
            "pm_service_end" => $this->input->post("pm_service_end"),
            "pm_pay_type" => $this->input->post("pm_pay_type"),
            "pm_once_price" => str_replace(",","",$this->input->post("pm_once_price")),
            "pm_once_dis_price" => str_replace(",","",$this->input->post("pm_once_dis_price")),
            "pm_once_dis_msg" => $this->input->post("pm_once_dis_msg"),
            "pm_service_price" => str_replace(",","",$this->input->post("pm_service_price")),
            "pm_service_dis_price" => str_replace(",","",$this->input->post("pm_service_dis_price")),
            "pm_service_dis_msg" => $this->input->post("pm_service_dis_msg"),
            "pm_payment_dis_price" => str_replace(",","",$this->input->post("pm_payment_dis_price")),
            "pm_total_price" => str_replace(",","",$this->input->post("pm_total_price")),
            "pm_surtax_price" => str_replace(",","",$this->input->post("pm_surtax_price")),
            "pm_memo" => $this->input->post("pm_memo"),
            "pm_end_date" => $this->input->post("pm_end_date")
        );
        $this->db->where("pm_seq",$this->input->post("pm_seq"));
        return $this->db->update("payment",$data);
    }

    public function fetchPayment($pm_mb_seq){
        $this->db->select("*,(select count(*) from payment aa where aa.pm_ca_seq = a.pm_ca_seq ) as pm_ca_total",true);
        $this->db->from("payment a");
        $this->db->join("service b","a.pm_sv_seq = b.sv_seq","left");
        $this->db->join("service_addoption bb","a.pm_sva_seq = bb.sva_seq","left");
        $this->db->join("product_category c","b.sv_pc_seq=c.pc_seq","left");
        $this->db->join("product_sub_div d","b.sv_ps_seq = d.ps_seq","left");
        $this->db->join("product e","b.sv_pr_seq = e.pr_seq","left");

        $this->db->where("pm_mb_seq",$pm_mb_seq);
        $this->db->where("pm_status != '1'");

        $this->db->order_by("pm_type desc, pm_ca_seq desc, sv_seq desc, pm_seq desc ");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function fetchPaymentPaycom($pm_mb_seq){
        $this->db->select("*,(select count(*) from payment aa where aa.pm_ca_seq = a.pm_ca_seq ) as pm_ca_total",true);
        $this->db->from("payment a");
        $this->db->join("service b","a.pm_sv_seq = b.sv_seq","left");
        $this->db->join("product_category c","b.sv_pc_seq=c.pc_seq","left");
        $this->db->join("product_sub_div d","b.sv_ps_seq = d.ps_seq","left");
        $this->db->join("product e","b.sv_pr_seq = e.pr_seq","left");

        $this->db->where("pm_mb_seq",$pm_mb_seq);
        $this->db->where("pm_status = '1'");

        $this->db->order_by("pm_ca_seq desc, pm_seq desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function paymentOnceAdd(){
        $this->db->select("pm_code");
        $this->db->from("payment");
        $this->db->order_by("pm_seq","desc");
        $this->db->limit(1);
        $query_code = $this->db->get();

        if($query_code->num_rows() == 0){
            $pm_code = "CHA0000001";
        }else{
            $max_row = $query_code->row_array();
            $max_row1 = substr($max_row["pm_code"],0,3);
            $max_row2 = (int)substr($max_row["pm_code"],3,7);
            $max_row2 = $max_row2+1;

            $pm_code = $max_row1.sprintf("%07d",$max_row2);
        }

        $this->db->select("*");
        $this->db->from("members");
        $this->db->where("mb_seq",$this->input->post("pm_mb_seq"));
        $query = $this->db->get();
        $row_member = $query->row_array();

        if($this->input->post("pm_surtax_type") == "0"){
            $total_price = str_replace(",","",$this->input->post("pm_service_price")) - str_replace(",","",$this->input->post("pm_service_dis_price"));
            $total_surtax = floor($total_price*0.1);
            $total_price2 = floor($total_price*1.1);
        }else{
            $total_price = str_replace(",","",$this->input->post("pm_service_price")) - str_replace(",","",$this->input->post("pm_service_dis_price"));
            $total_surtax = 0;
            $total_price2 = $total_price;
        }
        $data_claim = array(
            "ca_from_number" => "215-87-70318",
            "ca_to_number" => $row_member["mb_number"],
            "ca_from_name" => "아이온 시큐리티",
            "ca_to_name" => $row_member["mb_name"],
            "ca_from_ceo" => "김성혁",
            "ca_to_ceo" => $row_member["mb_ceo"],
            "ca_from_address" => "서울특별시 서초구 서초대로 255",
            "ca_to_address"=> $row_member["mb_address"],
            "ca_from_condition" => "서비스 외",
            "ca_to_condition" => $row_member["mb_business_conditions"],
            "ca_from_type" => "보안서비스 및 용역제공",
            "ca_to_type" => $row_member["mb_business_type"],
            "ca_from_team" => "영업2팀",
            "ca_to_team" => $row_member["mb_payment_team"],
            "ca_from_charger" => "전이준",
            "ca_to_charger" => $row_member["mb_payment_name"],
            "ca_from_tel" => "",
            "ca_to_tel" => $row_member["mb_payment_tel"],
            "ca_from_email" => "ijjun@eyeonsec.co.kr",
            "ca_to_email" => $row_member["mb_payment_email"],
            "ca_date" => date("Y-m-d"),
            "ca_price" => $total_price,
            "ca_surtax" => $total_surtax,
            "ca_total_price" => $total_price2,
            "ca_empty_size" => 11-strlen($total_price2),
            "ca_price_info1" => $total_price2,
            "ca_price_info2" => $total_price2,
            "ca_price_info3" => 0,
            "ca_price_info4" => 0,
            "ca_price_info5" => 0,
            "ca_payment_type" => $this->input->post("pm_payment_publish_type"),
            "ca_mb_seq" => $this->input->post("pm_mb_seq")
        );
        $this->db->insert("payment_claim",$data_claim);
        $pm_ca_seq = $this->db->insert_id();

        $data_claim_d = array(
            "cl_ca_seq" => $pm_ca_seq,
            "ca_item_name" => $this->input->post("pm_bill_name"),
            "ca_item_price" => $total_price,
            "ca_item_surtax" => $total_surtax,
            "ca_sort" => 1,
            "ca_m_sv_num" => ""
        );
        $this->db->insert("payment_claim_list",$data_claim_d);

        $data = array(
            "pm_type" => $this->input->post("pm_type"),
            "pm_code" => $pm_code,
            "pm_mb_seq" => $this->input->post("pm_mb_seq"),
            "pm_sv_seq" => $this->input->post("pm_sv_seq"),
            "pm_claim_name" => $this->input->post("pm_claim_name"),
            "pm_bill_name" => $this->input->post("pm_bill_name"),
            "pm_payment_publish" => $this->input->post("pm_payment_publish"),
            "pm_payment_publish_type" => $this->input->post("pm_payment_publish_type"),
            "pm_once_price" => str_replace(",","",$this->input->post("pm_service_price")),
            "pm_once_dis_price" => str_replace(",","",$this->input->post("pm_service_dis_price")),
            "pm_service_price" => 0,
            "pm_service_dis_price" => 0,
            "pm_payment_dis_price" => 0,
            "pm_surtax_type" => $this->input->post("pm_surtax_type"),
            "pm_once_dis_msg" => $this->input->post("pm_dis_msg"),
            "pm_date" => date("Y-m-d"),
            "pm_end_date" => $this->input->post("pm_end_date"),
            "pm_com_type" => $this->input->post("pm_com_type"),
            "pm_status" => 0,
            "pm_ca_seq"=>$pm_ca_seq
        );

        return $this->db->insert("payment",$data);
    }

    public function paymentOnceUpdate($pm_seq){
        $data = array(
            "pm_claim_name" => $this->input->post("pm_claim_name"),
            "pm_bill_name" => $this->input->post("pm_bill_name"),
            "pm_payment_publish" => $this->input->post("pm_payment_publish"),
            "pm_payment_publish_type" => $this->input->post("pm_payment_publish_type"),
            "pm_once_price" => $this->input->post("pm_service_price"),
            "pm_once_dis_price" => $this->input->post("pm_service_dis_price"),
            "pm_surtax_type" => $this->input->post("pm_surtax_type"),
            "pm_once_dis_msg" => $this->input->post("pm_dis_msg"),
            "pm_date" => $this->input->post("pm_date"),
            "pm_end_date" => $this->input->post("pm_end_date"),
            "pm_com_type" => $this->input->post("pm_com_type")
        );

        $this->db->where("pm_seq",$pm_seq);

        return $this->db->update("payment",$data);
    }

    public function selectPaymentOnce($pm_seq){
        $this->db->select("*");
        $this->db->from("payment a");
        $this->db->join("service b","a.pm_sv_seq = b.sv_seq","left");
        $this->db->join("product_category c","b.sv_pc_seq = c.pc_seq","left");
        $this->db->join("product d","b.sv_pr_seq = d.pr_seq","left");
        $this->db->join("product_sub_div e","b.sv_ps_seq = e.ps_seq","left");

        $this->db->where("pm_seq",$pm_seq);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function inputDateUpdate($pm_seq){
        $data = array(
            "input_date" => $this->input->post("input_date")
        );

        $this->db->where("pm_seq",$pm_seq);

        return $this->db->update("payment",$data);
    }

    public function inputClaimAdd($mb_seq){
        $data = array(
            "cl_code" => $this->input->post("cl_code"),
            "cl_mb_seq" => $mb_seq
        );

        $this->db->insert("claims",$data);

        $cl_seq = $this->db->insert_id();

        $cd_num = $this->input->post("cd_num");
        $cd_main = $this->input->post("cd_main");
        $cd_name = $this->input->post("cd_name");
        $cd_svp_seq = $this->input->post("cd_svp_seq");
        for($i =0;$i < count($cd_num);$i++){
            $data_detail = array(
                "cd_cl_seq" => $cl_seq,
                "cd_num" => $cd_num[$i],
                "cd_main" => $cd_main[$i],
                "cd_name" => $cd_name[$i],
                "cd_svp_seq" => $cd_svp_seq[$i]
            );

            $this->db->insert("claim_detail",$data_detail);

            $data_svp["svp_cl_seq"] = $cl_seq;
            $this->db->where("svp_seq",$cd_svp_seq[$i]);
            $this->db->update("service_price",$data_svp);
        }
        return true;
    }

    public function updateClaimAdd($cl_seq){
        
        $cd_seq = $this->input->post("cd_seq");
        $cd_num = $this->input->post("cd_num");
        $cd_main = $this->input->post("cd_main");
        $cd_name = $this->input->post("cd_name");
        $cd_svp_seq = $this->input->post("cd_svp_seq");

        $data_svp["svp_cl_seq"] = "";
        $this->db->where("svp_cl_seq",$cl_seq);
        $this->db->update("service_price",$data_svp);

        $data_yn["insert_yn"] = "N";
        $this->db->where("cd_cl_seq",$cl_seq);
        $this->db->update("claim_detail",$data_yn);

        for($i =0;$i < count($cd_seq);$i++){
            if($cd_seq[$i] == ""){ // insert
                $this->db->select("*");
                $this->db->from("claim_detail");
                $this->db->where("cd_cl_seq",$cl_seq);
                $this->db->where("cd_svp_seq",$cd_svp_seq[$i]);
                $query2 = $this->db->get();
                if($query2->num_rows() > 0){
                    $cd_seq2 = $query2->row_array();
                    $data_detail = array(
                        "cd_num" => $cd_num[$i],
                        "cd_main" => $cd_main[$i],
                        "cd_name" => $cd_name[$i],
                        "insert_yn" => "Y"
                    );
                    $this->db->where("cd_seq",$cd_seq2["cd_seq"]);
                    $this->db->update("claim_detail",$data_detail);
                }else{
                    $data_detail = array(
                        "cd_cl_seq" => $cl_seq,
                        "cd_num" => $cd_num[$i],
                        "cd_main" => $cd_main[$i],
                        "cd_name" => $cd_name[$i],
                        "cd_svp_seq" => $cd_svp_seq[$i],
                        "insert_yn" => "Y"
                    );

                    $this->db->insert("claim_detail",$data_detail);
                }
                
            }else{
                $data_detail = array(
                    "cd_num" => $cd_num[$i],
                    "cd_main" => $cd_main[$i],
                    "cd_name" => $cd_name[$i],
                    "insert_yn" => "Y"
                );
                $this->db->where("cd_seq",$cd_seq[$i]);
                $this->db->update("claim_detail",$data_detail);
            }
            

            $data_svp["svp_cl_seq"] = $cl_seq;
            $this->db->where("svp_seq",$cd_svp_seq[$i]);
            $this->db->update("service_price",$data_svp);
        }
        $this->db->where("insert_yn","N");
        $this->db->where("cd_cl_seq",$cl_seq);
        $this->db->delete("claim_detail");
        return true;
    }

    public function deleteClaimDel($seq){
        $this->db->where("cd_cl_seq",$seq);
        $this->db->delete("claim_detail");
        $this->db->where("cl_seq",$seq);

        return $this->db->delete("claims");
    }
    public function serviceUpdate(){
        if($this->input->post("sv_rental_type") == "1"){
            $sv_rental_date = "";
        }else{
            $sv_rental_date = $this->input->post("sv_rental_date");
        }
        $new_data = array(
            "sv_payment_type" => $this->input->post("sv_payment_type"),
            "sv_payment_period" => $this->input->post("sv_payment_period"),
            "sv_pay_type" => $this->input->post("sv_pay_type"),
            "sv_pay_day" => $this->input->post("sv_pay_day"),
            "sv_pay_publish" => $this->input->post("sv_pay_publish"),
            "sv_pay_publish_type" => $this->input->post("sv_pay_publish_type"),
            "sv_payment_day" => $this->input->post("sv_payment_day"),
            "sv_account_start" => $this->input->post("sv_account_start"),
            "sv_account_end" => $this->input->post("sv_account_end"),
            "sv_account_type" => $this->input->post("sv_account_type"),
            "sv_account_policy" => $this->input->post("sv_account_policy"),
            "sv_account_start_day" => $this->input->post("sv_account_start_day"),
            "sv_account_format" => $this->input->post("sv_account_format"),
            "sv_account_format_policy" => $this->input->post("sv_account_format_policy"),
            "sv_claim_name" => $this->input->post("sv_claim_name"),
            "sv_bill_name" => $this->input->post("sv_bill_name"),
            "sv_once_price" => str_replace(",","",$this->input->post("svp_once_price")),
            "sv_month_price" => str_replace(",","",$this->input->post("svp_month_price")),
            "sv_c_seq" => $this->input->post("sv_c_seq"),
            "sv_input_price" => str_replace(",","",$this->input->post("sv_input_price")),
            "sv_input_start" => $this->input->post("sv_input_start"),
            "sv_input_unit" => $this->input->post("sv_input_unit"),
            "sv_rental_type" => $this->input->post("sv_rental_type"),
            "sv_rental_date" => $sv_rental_date
        );
        $this->db->where("sv_seq",$this->input->post("sv_seq"));
        $this->db->update("service",$new_data);

        // $data_price = array(
        //     "ap_once_price" => $this->input->post("svp_once_price"),
        //     "ap_once_dis_price" => $this->input->post("svp_once_dis_price"),
        //     "ap_price" => $this->input->post("svp_month_price"),
        //     "ap_dis_price" => $this->input->post("svp_month_dis_price"),
        //     "ap_type_dis_price" => $this->input->post("svp_discount_price"),
        //     "ap_first_price" => $this->input->post("svp_first_price")
        // );
        // $this->db->where("ap_sv_seq",$this->input->post("sv_seq"));
        // $this->db->update("service_all_price",$data_price);

        $data_price = array(
            "svp_once_price" => str_replace(",","",$this->input->post("svp_once_price")),
            "svp_once_dis_price" => str_replace(",","",$this->input->post("svp_once_dis_price")),
            "svp_once_dis_msg" => $this->input->post("svp_once_dis_msg"),
            "svp_month_price" => str_replace(",","",$this->input->post("svp_month_price")),
            "svp_month_dis_price" => str_replace(",","",$this->input->post("svp_month_dis_price")),
            "svp_month_dis_msg" => $this->input->post("svp_month_dis_msg"),
            "svp_discount_yn" => $this->input->post("svp_discount_yn"),
            "svp_discount_price" => str_replace(",","",$this->input->post("svp_discount_price")),
            "svp_register_discount" => str_replace(",","",$this->input->post("svp_register_discount")),
            "svp_first_claim_name" => $this->input->post("svp_first_claim_name"),
            "svp_first_day_price" => str_replace(",","",$this->input->post("sp_first_price")),
            "svp_first_day_start" => $this->input->post("sp_first_start"),
            "svp_first_day_end" => $this->input->post("sp_first_end"),
            "svp_first_month_price" => str_replace(",","",$this->input->post("sp_first_month_price")),
            "svp_first_month_start" => $this->input->post("sp_first_month_start"),
            "svp_first_month_end" => $this->input->post("sp_first_month_end"),
            "svp_memo" => $this->input->post("svp_memo")
        );
        $this->db->where("svp_seq",$this->input->post("svp_seq"));

        if($this->input->post("b_sv_claim_name") != $this->input->post("sv_claim_name")){
            // $this->logInsert(1,$mb_seq,'서비스 기본 정보','청구명',$this->input->post("b_sv_claim_name"),$this->input->post("sv_claim_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        }

        if($this->input->post("b_sv_bill_name") != $this->input->post("sv_bill_name")){
            // $this->logInsert(1,$mb_seq,'서비스 기본 정보','계산서 품목명',$this->input->post("b_sv_bill_name"),$this->input->post("sv_bill_name"),1,'',$_SERVER["REMOTE_ADDR"]);
        }

        if($this->input->post("b_sv_payment_type") != $this->input->post("sv_payment_type")){
            // $this->logInsert(1,$mb_seq,'서비스 결제 조건','요금 납부 방법',$this->input->post("b_sv_payment_type"),$this->input->post("sv_payment_type"),1,'',$_SERVER["REMOTE_ADDR"]);
        }

        if($this->input->post("b_sv_payment_period") != $this->input->post("sv_payment_period")){
            // $this->logInsert(1,$mb_seq,'서비스 결제 조건','결제 주기',$this->input->post("b_sv_payment_period"),$this->input->post("sv_payment_period"),1,'',$_SERVER["REMOTE_ADDR"]);
        }
        if($this->input->post("b_sv_pay_type") != $this->input->post("sv_pay_type")){
            // $this->logInsert(1,$mb_seq,'서비스 결제 조건','청구 기준',$this->input->post("b_sv_pay_type"),$this->input->post("sv_pay_type"),1,'',$_SERVER["REMOTE_ADDR"]);
        }

        if($this->input->post("b_sv_pay_day") != $this->input->post("sv_pay_day")){
            // $this->logInsert(1,$mb_seq,'서비스 결제 조건','자동 청구일',$this->input->post("b_sv_pay_day"),$this->input->post("sv_pay_day"),1,'',$_SERVER["REMOTE_ADDR"]);
        }

        if($this->input->post("b_sv_pay_publish") != $this->input->post("sv_pay_publish") || $this->input->post("b_sv_pay_publish_type") != $this->input->post("sv_pay_publish_type")){
            // $this->logInsert(1,$mb_seq,'서비스 결제 조건','계산서 발행',$this->input->post("b_sv_pay_publish"),$this->input->post("sv_pay_publish"),1,'',$_SERVER["REMOTE_ADDR"]);
        }





        return $this->db->update("service_price",$data_price);
    }

    public function serviceViewUpdate(){
        $new_data = array(
            "sv_eu_seq" => $this->input->post("sv_eu_seq"),
            "sv_ct_seq" => $this->input->post("sv_ct_seq"),
            "sv_code" => $this->input->post("sv_code1")."-".$this->input->post("sv_code2"),
            "sv_part" => $this->input->post("sv_part"),
            "sv_charger" => $this->input->post("sv_charger"),
            "sv_contract_type" => $this->input->post("sv_contract_type"),
            "sv_contract_start" => $this->input->post("sv_contract_start"),
            "sv_contract_end" => $this->input->post("sv_contract_end"),
            "sv_auto_extension" => $this->input->post("sv_auto_extension"),
            "sv_auto_extension_month" => $this->input->post("sv_auto_extension_month"),
            "sv_claim_name" => $this->input->post("sv_claim_name"),
            "sv_rental_type" => $this->input->post("sv_rental_type"),
            "sv_rental_date" => $this->input->post("sv_rental_date")
        );
        $this->db->where("sv_seq",$this->input->post("sv_seq"));
        return $this->db->update("service",$new_data);
    }

    public function serviceAddUpdate(){
        // $new_data = array(
        //     "sv_payment_type" => $this->input->post("sv_payment_type"),
        //     "sv_payment_period" => $this->input->post("sv_payment_period"),
        //     "sv_pay_type" => $this->input->post("sv_pay_type"),
        //     "sv_pay_day" => $this->input->post("sv_pay_day"),
        //     "sv_pay_publish" => $this->input->post("sv_pay_publish"),
        //     "sv_pay_publish_type" => $this->input->post("sv_pay_publish_type"),
        //     "sv_payment_day" => $this->input->post("sv_payment_day"),
        //     "sv_account_start" => $this->input->post("sv_account_start"),
        //     "sv_account_end" => $this->input->post("sv_account_end"),
        //     "sv_account_type" => $this->input->post("sv_account_type"),
        //     "sv_account_policy" => $this->input->post("sv_account_policy"),
        //     "sv_account_start_day" => $this->input->post("sv_account_start_day"),
        //     "sv_account_format" => $this->input->post("sv_account_format"),
        //     "sv_account_format_policy" => $this->input->post("sv_account_format_policy"),
        //     "sv_claim_name" => $this->input->post("sv_claim_name"),
        //     "sv_bill_name" => $this->input->post("sv_bill_name"),
        //     "sv_once_price" => $this->input->post("svp_once_price"),
        //     "sv_month_price" => $this->input->post("svp_month_price"),
        //     "sv_c_seq" => $this->input->post("sv_c_seq"),
        //     "sv_input_price" => $this->input->post("sv_input_price"),
        //     "sv_input_start" => $this->input->post("sv_input_start"),
        //     "sv_input_unit" => $this->input->post("sv_input_unit")
        // );
        // $this->db->where("sv_seq",$this->input->post("sv_seq"));
        // $this->db->update("service",$new_data);
        $new_data = array(
            "sva_claim_name" => $this->input->post("sva_claim_name"),
            "sva_bill_name" => $this->input->post("sva_bill_name"),
            "sva_claim_type" => $this->input->post("sva_claim_type"),
            "sva_pay_day" => $this->input->post("sva_pay_day"),
            "sva_c_seq" =>$this->input->post("sva_c_seq"),
            "sva_input_price"=>str_replace(",","",$this->input->post("sva_input_price")),
            "sva_input_date"=>$this->input->post("sva_input_date"),
            "sva_input_unit"=>$this->input->post("sva_input_unit")
        );
        $this->db->where("sva_seq",$this->input->post("sva_seq"));
        $this->db->update("service_addoption",$new_data);
        
        if($this->input->post("sva_claim_type") == "0"){
            $data_price = array(
                "svp_once_price" => str_replace(",","",$this->input->post("svp_once_price")),
                "svp_once_dis_price" => str_replace(",","",$this->input->post("svp_once_dis_price")),
                "svp_once_dis_msg" => $this->input->post("svp_once_dis_msg"),
                "svp_month_price" => str_replace(",","",$this->input->post("svp_month_price")),
                "svp_month_dis_price" => str_replace(",","",$this->input->post("svp_month_dis_price")),
                "svp_month_dis_msg" => $this->input->post("svp_month_dis_msg"),
                "svp_discount_yn" => $this->input->post("svp_discount_yn"),
                "svp_discount_price" => str_replace(",","",$this->input->post("svp_discount_price")),
                "svp_register_discount" => $this->input->post("svp_register_discount"),
                "svp_first_claim_name" => $this->input->post("svp_first_claim_name"),
                "svp_first_day_price" => $this->input->post("svp_first_day_name"),
                "svp_first_day_start" => $this->input->post("svp_first_day_start"),
                "svp_first_day_end" => $this->input->post("svp_first_day_end"),
                "svp_first_month_price" => $this->input->post("svp_first_month_name"),
                "svp_first_month_start" => $this->input->post("svp_first_month_start"),
                "svp_first_month_end" => $this->input->post("svp_first_month_end"),
                "svp_payment_period" => $this->input->post("svp_payment_period")
            );
            $data_price["svp_display_yn"] = "Y";
        }else{
            $data_price = array(
                "svp_once_price" => 0,
                "svp_once_dis_price" => 0,
                "svp_once_dis_msg" => "",
                "svp_month_price" => 0,
                "svp_month_dis_price" => 0,
                "svp_month_dis_msg" => "",
                "svp_discount_yn" => "N",
                "svp_discount_price" => 0,
                "svp_register_discount" => 0,
                "svp_first_claim_name" => "",
                "svp_first_day_price" => 0,
                "svp_first_day_start" => $this->input->post("svp_first_day_start"),
                "svp_first_day_end" => $this->input->post("svp_first_day_end"),
                "svp_first_month_price" => "",
                "svp_first_month_start" => $this->input->post("svp_first_month_start"),
                "svp_first_month_end" => $this->input->post("svp_first_month_end"),
                "svp_payment_period" => 0
            );
            $data_price["svp_display_yn"] = "N";
        }
        $this->db->where("svp_seq",$this->input->post("svp_seq"));
        return $this->db->update("service_price",$data_price);
    }

    public function fetchClaim($mb_seq){
        $this->db->select("*");
        $this->db->from("claims");
        $this->db->where("cl_mb_seq",$mb_seq);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function paymentDelete($pm_seq_array){
        $this->db->where_in("pm_seq",$pm_seq_array);
        return $this->db->delete("payment");
    }

    public function paymentClaimAdd(){
        $data = array(
            "ca_pm_seq" => $this->input->post("ca_pm_seq"),
            "ca_from_number" => $this->input->post("ca_from_number"),
            "ca_to_number" => $this->input->post("ca_to_number"),
            "ca_from_name" => $this->input->post("ca_from_name"),
            "ca_to_name" => $this->input->post("ca_to_name"),
            "ca_from_ceo" => $this->input->post("ca_from_ceo"),
            "ca_to_ceo" => $this->input->post("ca_to_ceo"),
            "ca_from_address" => $this->input->post("ca_from_address"),
            "ca_to_address" => $this->input->post("ca_to_address"),
            "ca_from_condition" => $this->input->post("ca_from_condition"),
            "ca_to_condition" => $this->input->post("ca_to_condition"),
            "ca_from_type" => $this->input->post("ca_from_type"),
            "ca_to_type" => $this->input->post("ca_to_type"),
            "ca_from_team" => $this->input->post("ca_from_team"),
            "ca_to_team" => $this->input->post("ca_to_team"),
            "ca_from_charger" => $this->input->post("ca_from_charger"),
            "ca_to_charger" => $this->input->post("ca_to_charger"),
            "ca_from_tel" => $this->input->post("ca_from_tel"),
            "ca_to_tel" => $this->input->post("ca_to_tel"),
            "ca_from_email" => $this->input->post("ca_from_email"),
            "ca_to_email" => $this->input->post("ca_to_email"),
            "ca_date" => $this->input->post("ca_date"),
            "ca_price" => $this->input->post("ca_price"),
            "ca_surtax" => $this->input->post("ca_surtax"),
            "ca_total_price" => $this->input->post("ca_total_price")
        );

        $this->db->insert("payment_claim",$data);
        $ca_seq = $this->db->insert_id();

        if($this->input->post("ca_item_name1") != ""){
            $data_list = array(
                "cl_ca_seq" => $ca_seq,
                "ca_item_name" => $this->input->post("ca_item_name1"),
                "ca_item_price" => $this->input->post("ca_item_price1"),
                "ca_item_surtax" => $this->input->post("ca_item_surtax1"),
                "ca_item_msg" => $this->input->post("ca_item_msg1"),
                "ca_sort" => 1
            );
            $this->db->insert("payment_claim_list",$data_list);
        }

        if($this->input->post("ca_item_name2") != ""){
            $data_list = array(
                "cl_ca_seq" => $ca_seq,
                "ca_item_name" => $this->input->post("ca_item_name2"),
                "ca_item_price" => $this->input->post("ca_item_price2"),
                "ca_item_surtax" => $this->input->post("ca_item_surtax2"),
                "ca_item_msg" => $this->input->post("ca_item_msg2"),
                "ca_sort" => 2
            );
            $this->db->insert("payment_claim_list",$data_list);
        }

        if($this->input->post("ca_item_name3") != ""){
            $data_list = array(
                "cl_ca_seq" => $ca_seq,
                "ca_item_name" => $this->input->post("ca_item_name3"),
                "ca_item_price" => $this->input->post("ca_item_price3"),
                "ca_item_surtax" => $this->input->post("ca_item_surtax3"),
                "ca_item_msg" => $this->input->post("ca_item_msg3"),
                "ca_sort" => 3
            );
            $this->db->insert("payment_claim_list",$data_list);
        }

        if($this->input->post("ca_item_name4") != ""){
            $data_list = array(
                "cl_ca_seq" => $ca_seq,
                "ca_item_name" => $this->input->post("ca_item_name4"),
                "ca_item_price" => $this->input->post("ca_item_price4"),
                "ca_item_surtax" => $this->input->post("ca_item_surtax4"),
                "ca_item_msg" => $this->input->post("ca_item_msg4"),
                "ca_sort" => 4
            );
            $this->db->insert("payment_claim_list",$data_list);
        }

        return true;
    }

    public function paymentClaimUpdate(){
        $data = array(
            "ca_from_number" => $this->input->post("ca_from_number"),
            "ca_to_number" => $this->input->post("ca_to_number"),
            "ca_from_name" => $this->input->post("ca_from_name"),
            "ca_to_name" => $this->input->post("ca_to_name"),
            "ca_from_ceo" => $this->input->post("ca_from_ceo"),
            "ca_to_ceo" => $this->input->post("ca_to_ceo"),
            "ca_from_address" => $this->input->post("ca_from_address"),
            "ca_to_address" => $this->input->post("ca_to_address"),
            "ca_from_condition" => $this->input->post("ca_from_condition"),
            "ca_to_condition" => $this->input->post("ca_to_condition"),
            "ca_from_type" => $this->input->post("ca_from_type"),
            "ca_to_type" => $this->input->post("ca_to_type"),
            "ca_from_team" => $this->input->post("ca_from_team"),
            "ca_to_team" => $this->input->post("ca_to_team"),
            "ca_from_charger" => $this->input->post("ca_from_charger"),
            "ca_to_charger" => $this->input->post("ca_to_charger"),
            "ca_from_tel" => $this->input->post("ca_from_tel"),
            "ca_to_tel" => $this->input->post("ca_to_tel"),
            "ca_from_email" => $this->input->post("ca_from_email"),
            "ca_to_email" => $this->input->post("ca_to_email"),
            "ca_date" => $this->input->post("ca_date"),
            "ca_price" => $this->input->post("ca_price"),
            "ca_surtax" => $this->input->post("ca_surtax"),
            "ca_total_price" => $this->input->post("ca_total_price"),
            "ca_empty_size" => $this->input->post("ca_empty_size"),
            "ca_price_info1" => $this->input->post("ca_price_info1"),
            "ca_price_info2" => $this->input->post("ca_price_info2"),
            "ca_price_info3" => $this->input->post("ca_price_info3"),
            "ca_price_info4" => $this->input->post("ca_price_info4"),
            "ca_price_info5" => $this->input->post("ca_price_info5")
        );
        $this->db->where("ca_seq",$this->input->post("ca_seq"));
        $this->db->update("payment_claim",$data);

        if($this->input->post("cl_seq1") != ""){
            $data_list = array(
                "ca_item_name" => $this->input->post("ca_item_name1"),
                "ca_item_price" => $this->input->post("ca_item_price1"),
                "ca_item_surtax" => $this->input->post("ca_item_surtax1"),
                "ca_item_msg" => $this->input->post("ca_item_msg1")
            );
            $this->db->where("cl_seq",$this->input->post("cl_seq1"));
            $this->db->update("payment_claim_list",$data_list);
        }

        if($this->input->post("cl_seq2") != ""){
            $data_list = array(
                "ca_item_name" => $this->input->post("ca_item_name2"),
                "ca_item_price" => $this->input->post("ca_item_price2"),
                "ca_item_surtax" => $this->input->post("ca_item_surtax2"),
                "ca_item_msg" => $this->input->post("ca_item_msg2")
            );
            $this->db->where("cl_seq",$this->input->post("cl_seq2"));
            $this->db->update("payment_claim_list",$data_list);
        }

        if($this->input->post("cl_seq3") != ""){
            $data_list = array(
                "ca_item_name" => $this->input->post("ca_item_name3"),
                "ca_item_price" => $this->input->post("ca_item_price3"),
                "ca_item_surtax" => $this->input->post("ca_item_surtax3"),
                "ca_item_msg" => $this->input->post("ca_item_msg3")
            );
            $this->db->where("cl_seq",$this->input->post("cl_seq3"));
            $this->db->update("payment_claim_list",$data_list);
        }

        if($this->input->post("cl_seq4") != ""){
            $data_list = array(
                "ca_item_name" => $this->input->post("ca_item_name4"),
                "ca_item_price" => $this->input->post("ca_item_price4"),
                "ca_item_surtax" => $this->input->post("ca_item_surtax4"),
                "ca_item_msg" => $this->input->post("ca_item_msg4")
            );
            $this->db->where("cl_seq",$this->input->post("cl_seq4"));
            $this->db->update("payment_claim_list",$data_list);
        }

        return true;
    }

    public function paymentClaim($pm_seq){
        $this->db->select("*");
        $this->db->from("payment_claim");
        $this->db->where("ca_pm_seq",$pm_seq);

        $query = $this->db->get();

        $row = $query->row_array();

        $this->db->select("*");
        $this->db->from("payment_claim_list");
        $this->db->where("cl_ca_seq",$row["ca_seq"]);

        $this->db->order_by("ca_sort");
        $query2 = $this->db->get();

        $row["sub_list"] = $query2->result_array();

        return $row;
    }

    public function paymentInput(){
        $data = array(
            "pm_status" => 9,
            "pm_input_date" => $this->input->post("pm_input_date")
        );

        $seq = explode(",",$this->input->post("pm_seq"));
        $this->db->where_in("pm_seq",$seq);
        $this->db->update("payment",$data);


        $this->db->select("*");
        $this->db->from("payment a");
        $this->db->join("service b","a.pm_sv_seq = b.sv_seq","inner");
        $this->db->where("pm_seq",$this->input->post("pm_seq"));

        $query = $this->db->get();

        $row = $query->row_array();
        if($row["sv_status"] == "0"){
            $data_status["sv_status"] = "1";
            $this->db->where("sv_seq",$row["sv_seq"]);
            $this->db->update("service",$data_status);
        }
        return true;
    }

    public function updateServiceOutInfo(){
        $data = array(
            "sv_out_date" => $this->input->post("sv_out_date"),
            "sv_out_type" => $this->input->post("sv_out_type"),
            "sv_out_serial" => $this->input->post("sv_out_serial"),
            "sv_out_memo" => $this->input->post("sv_out_memo")
        );

        $this->db->where("sv_seq",$this->input->post("sv_seq"));

        return $this->db->update("service",$data);
    }

    public function updateServiceCharger(){
        $data = array(
            "sv_engineer_part" => $this->input->post("sv_engineer_part"),
            "sv_engineer_charger" => $this->input->post("sv_engineer_charger")
        );

        if($this->input->post("sv_status") != ""){
            $data["sv_status"] = $this->input->post("sv_status");
        }

        $this->db->where("sv_seq",$this->input->post("sv_seq"));

        return $this->db->update("service",$data);
    }

    public function updateServiceOpen(){
        $data["sv_status"] = 3;
        $data["sv_service_start"] = date("Y-m-d H:i:s");
        $this->db->where("sv_seq",$this->input->post("sv_seq"));

        return $this->db->update("service",$data);
    }

    public function updateServiceOpenTime(){
        $data["sv_service_start"] = $this->input->post("service_open");
        $this->db->where("sv_seq",$this->input->post("sv_seq"));

        return $this->db->update("service",$data);
    }

    public function updateServiceStop(){
        $data["sv_service_stop"] = $this->input->post("sv_service_stop");
        $data["sv_service_restart"] = $this->input->post("sv_service_restart");
        $data["sv_service_stop_msg"] = $this->input->post("sv_service_stop_msg");
        $data["sv_status"] = 4;
        $this->db->where("sv_seq",$this->input->post("sv_seq"));

        return $this->db->update("service",$data);
    }

    public function updateServiceEnd(){
        $data["sv_service_end"] = $this->input->post("sv_service_stop");
        // $data["sv_service_restart"] = $this->input->post("sv_service_restart")
        if($this->input->post("sv_service_end_msg") == "기타"){
            $data["sv_service_end_msg"] = $this->input->post("sv_service_end_msg_etc");
        }else{
            $data["sv_service_end_msg"] = $this->input->post("sv_service_stop_msg");
        }

        $data["sv_status"] = 5;
        $this->db->where("sv_seq",$this->input->post("sv_seq"));

        return $this->db->update("service",$data);
    }

    public function updateServiceForceStop(){
        $data["sv_status"] = 6;
        $data["sv_service_stop"] = date("Y-m-d H:i:s");

        $this->db->where("sv_seq",$this->input->post("sv_seq"));

        return $this->db->update("service",$data);
    }

    public function updateServiceForceEnd(){
        $data["sv_status"] = 7;
        $data["sv_service_end"] = date("Y-m-d H:i:s");

        $this->db->where("sv_seq",$this->input->post("sv_seq"));

        return $this->db->update("service",$data);
    }

    public function updateServiceRestart(){
        $data["sv_status"] = 3;
        $data["sv_service_restart"] = date("Y-m-d H:i:s");
        $this->db->where("sv_seq",$this->input->post("sv_seq"));

        return $this->db->update("service",$data);
    }

    public function serviceFileAdd(){
        $data_insert_array = [];
        if(isset($_FILES["file"])){
            for($i = 0; $i < count($_FILES["file"]["name"]);$i++){
                if($_FILES["file"]["size"][$i] > 0){

                    $ext = substr(strrchr(basename($_FILES['file']["name"][$i]), '.'), 1);
                    $file_name = time()."_".rand(1111,9999).".".$ext;
                    move_uploaded_file($_FILES["file"]['tmp_name'][$i],$_SERVER["DOCUMENT_ROOT"].'/uploads/service_file/'.$file_name);
                    $data = array(
                        "sf_file" => $file_name,
                        "sf_sv_seq" => $this->input->post("sv_seq"),
                        "sf_origin_file" => $_FILES['file']["name"][$i],
                        "sf_file_size" => $_FILES['file']["size"][$i],
                        "sf_type" => $this->input->post("sf_type")
                    );

                    array_push($data_insert_array,$data);


                }
            }
        }
        if(count($data_insert_array) > 0){
            $this->db->insert_batch("service_files",$data_insert_array);
        }
        return true;
    }

    public function serviceFileFetch($sv_seq,$type){
        $this->db->select("*");
        $this->db->from("service_files");
        $this->db->where("sf_sv_seq",$sv_seq);
        $this->db->where("sf_type",$type);

        $query = $this->db->get();

        return $query->result_array();

    }

    public function serviceFileDelete($sf_seq){
        // data array
        $this->db->select("*");
        $this->db->from("service_files");
        $this->db->where("sf_seq",$sf_seq);
        $query = $this->db->get();

        $row = $query->row_array();
        $sf_file = $row["sf_file"];

        unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/service_file/".$sf_file);

        $this->db->where("sf_seq",$sf_seq);

        return $this->db->delete("service_files");
    }

    public function serviceMemoAdd(){
        $data = array(
            "sm_sv_seq" => $this->input->post("sv_seq"),
            "sm_charger" => $this->input->post("sm_chager"),
            "sm_regdate" => date("Y-m-d H:i:s"),
            "sm_msg" => $this->input->post("sm_msg")
        );

        return $this->db->insert("service_memo",$data);
    }

    public function serviceMemoModify(){
        $data = array(
            "sm_charger" => $this->input->post("sm_chager"),
            "sm_msg" => $this->input->post("sm_msg")
        );
        $this->db->where("sm_seq",$this->input->post("sm_seq"));
        return $this->db->update("service_memo",$data);
    }

    public function serviceMemoDelete(){
        $this->db->where("sm_seq",$this->input->post("sm_seq"));
        return $this->db->delete("service_memo");
    }

    public function countServiceMemo(){
        $this->db->select("count(*) as total");
        $this->db->from("service_memo");
        $this->db->where("sm_sv_seq",$this->input->get("sv_seq"));

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    public function serviceMemoFetch(){
        $this->db->select("*");
        $this->db->from("service_memo");
        $this->db->where("sm_sv_seq",$this->input->get("sv_seq"));

        $this->db->limit($this->input->get("end"),$this->input->get("start"));
        $query = $this->db->get();

        return $query->result_array();

        // return $row["total"];
    }

    public function serviceHistoryAdd(){
        $this->db->select("*");
        $this->db->from("service");
        $this->db->where("sv_code",$this->input->post("sh_sv_code")."-01");
        $query = $this->db->get();

        $row = $query->row_array();

        if($this->input->post("sh_type") == "1" || $this->input->post("sh_type") == "2"){
            $sh_service_start = $this->input->post("sh_service_start");
            $sh_service_end = $this->input->post("sh_service_end");
            $data_update["sv_contract_extension_end"] = $this->input->post("sh_service_end");
            $this->db->where("sv_code LIKE '".$this->input->post("sh_sv_code")."-"."%' ");
            $this->db->update("service",$data_update);
        }else{
            $sh_service_start = "";
            $sh_service_end = "";
            $data_update["sv_contract_extension_end"] = $sh_service_end;
            $this->db->where("sv_code LIKE '".$this->input->post("sh_sv_code")."-"."%' ");
            $this->db->update("service",$data_update);
        }
        $data = array(
            "sh_sv_code" => $this->input->post("sh_sv_code")."-01",
            "sh_type" => $this->input->post("sh_type"),
            "sh_date" => date("Y-m-d H:i:s"),
            "sh_service_start" => $sh_service_start,
            "sh_service_end" => $sh_service_end,
            "sh_auto_extension" => $row["sv_auto_extension"],
            "sh_auto_extension_month" => $row["sv_auto_extension_month"],
            "sh_link" => $this->input->post("sh_link")
        );

        return $this->db->insert("service_history",$data);
    }

    public function serviceHistoryEdit(){
        if($this->input->post("sh_type") == "1" || $this->input->post("sh_type") == "2"){
            $data_update["sv_contract_extension_end"] = $this->input->post("sh_service_end");
            $this->db->where("sv_code LIKE '".$this->input->post("sh_sv_code")."-"."%' ");
            $this->db->update("service",$data_update);
        }
        $data = array(
            "sh_type" => $this->input->post("sh_type"),
            "sh_service_start" => $this->input->post("sh_service_start"),
            "sh_service_end" => $this->input->post("sh_service_end"),
            "sh_link" => $this->input->post("sh_link")
        );
        $this->db->where("sh_seq",$this->input->post("sh_seq"));
        return $this->db->update("service_history",$data);
    }

    public function serviceHistoryDel(){
        $this->db->select("*");
        $this->db->from("service_history");
        $this->db->where("sh_seq",$this->input->post("sh_seq"));
        $query = $this->db->get();
        $row = $query->row_array();

        $this->db->where("sh_seq",$this->input->post("sh_seq"));
        $this->db->delete("service_history");

        $this->db->select("*");
        $this->db->from("service_history");
        $this->db->where("sh_sv_code = '".$row["sh_sv_code"]."' ");
        $this->db->order_by("sh_seq desc");
        $this->db->limit(1);

        $query = $this->db->get();
        $row2 = $query->row_array();

        if($row2["sh_type"] == "0" || $row2["sh_type"] == "1" || $row2["sh_type"] == "2"){
            $data_update["sv_contract_extension_end"] = $row2["sh_service_end"];
            $sh_sv_code = explode("-",$row2["sh_sv_code"]);
            $this->db->where("sv_code LIKE '".$sh_sv_code[0]."-"."%' ");
            $this->db->update("service",$data_update);
        }
        return true;
    }

    public function claimView($pm_ca_seq){
        $this->db->select("*,date_format(ca_date,'%m-%d') as ca_monthday",true);
        $this->db->from("payment_claim cc");
        $this->db->where("ca_seq",$pm_ca_seq);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function claimViewList($ca_seq){
        $this->db->select("*");
        $this->db->from("payment_claim_list");
        $this->db->where("cl_ca_seq",$ca_seq);
        $this->db->group_by("ca_sort");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function paymentComPay(){
        // $data = json_decode($this->input->post("data"));
        $data = explode(",",$this->input->post("data"));
        for($i = 0; $i < count($data);$i++){
            $data_array = array(
                "pm_status" => "1",
                "pm_com_date" => date("Y-m-d H:i:s")
            );

            $this->db->where("pm_seq" , $data[$i]);
            $this->db->update("payment",$data_array);

            $this->db->select("*");
            $this->db->from("payment");
            $this->db->where("pm_seq",$data[$i]);
            $query = $this->db->get();

            $row = $query->row_array();

            $this->db->select("*");
            $this->db->from("service");
            $this->db->where("sv_seq",$row["pm_sv_seq"]);

            $query = $this->db->get();
            $row2 = $query->row_array();
            if($row2["sv_status"] == 0){
                $data_service["sv_status"] = 1;
                $this->db->where("sv_seq" , $row2["sv_seq"]);
                $this->db->update("service",$data_service);
            }
        }
        return true;
    }

    public function paymentComPayPost(){
        $data = explode(",",$this->input->post("data"));
        if($this->input->post("pm_total") == count($data)){
            for($i = 0; $i < count($data);$i++){
                $data_array = array(
                    "pm_status" => "1",
                    "pm_com_date" => date("Y-m-d H:i:s")
                );

                $this->db->where("pm_seq" , $data[$i]);
                $this->db->update("payment",$data_array);
            }
            // return true;
        }else{
            // 기존 내용이 뭔지 가져오기
            $claim_date = "";
            $total_price = 0;
            $sv_pay_publish_type = "";
            $sv_bill_name = "";

            $this->db->select("*");
            $this->db->from("payment a");
            $this->db->join("service b","a.pm_sv_seq=b.sv_seq","left");
            $this->db->where_in("pm_seq",$data);
            // 작은 서비스 번호가 M이 되므로 순차적으로 넣어서 작은게 젤 마지막에 들어가게 만즘
            $this->db->order_by("sv_number desc");
            $query = $this->db->get();

            foreach($query->result_array() as $row){
                $old_ca_seq = $row["pm_ca_seq"];
                $mb_seq = $row["pm_mb_seq"];
                $claim_date = $row["pm_date"];
                $sv_bill_name = $row["sv_bill_name"];
                $total_price = $total_price+$row["pm_total_price"];
                $sv_number = $row["sv_number"];
                $sv_pay_publish_type = $row["sv_pay_publish_type"];
            }

            // 영수발행 부분 완납일 경우
            $this->db->select("*");
            $this->db->from("members");
            $this->db->where("mb_seq",$mb_seq);
            $query_member = $this->db->get();

            $row_member = $query_member->row_array();

            $data_claim = array(
                "ca_from_number" => "215-87-70318",
                "ca_to_number" => $row_member["mb_number"],
                "ca_from_name" => "아이온 시큐리티",
                "ca_to_name" => $row_member["mb_name"],
                "ca_from_ceo" => "김성혁",
                "ca_to_ceo" => $row_member["mb_ceo"],
                "ca_from_address" => "서울특별시 서초구 서초대로 255",
                "ca_to_address"=> $row_member["mb_address"],
                "ca_from_condition" => "서비스 외",
                "ca_to_condition" => $row_member["mb_business_conditions"],
                "ca_from_type" => "보안서비스 및 용역제공",
                "ca_to_type" => $row_member["mb_business_type"],
                "ca_from_team" => "영업2팀",
                "ca_to_team" => $row_member["mb_payment_team"],
                "ca_from_charger" => "전이준",
                "ca_to_charger" => $row_member["mb_payment_name"],
                "ca_from_tel" => "",
                "ca_to_tel" => $row_member["mb_payment_tel"],
                "ca_from_email" => "ijjun@eyeonsec.co.kr",
                "ca_to_email" => $row_member["mb_payment_email"],
                "ca_date" => $claim_date,
                "ca_price" => $total_price,
                "ca_surtax" => floor($total_price*0.1),
                "ca_total_price" => floor($total_price*1.1),
                "ca_empty_size" => 11-strlen(floor($total_price*1.1)),
                "ca_price_info1" => floor($total_price*1.1),
                "ca_price_info2" => floor($total_price*1.1),
                "ca_price_info3" => 0,
                "ca_price_info4" => 0,
                "ca_price_info5" => 0,
                "ca_payment_type" => $sv_pay_publish_type,
                "ca_mb_seq" => $mb_seq
            );
            $this->db->insert("payment_claim",$data_claim);

            $cl_ca_seq = $this->db->insert_id();

            $data_claim_d = array(
                "cl_ca_seq" => $cl_ca_seq,
                "ca_item_name" => $sv_bill_name,
                "ca_item_price" => $total_price,
                "ca_item_surtax" => floor($total_price*0.1),
                "ca_sort" => 1,
                "ca_m_sv_num" => $sv_number
            );
            $this->db->insert("payment_claim_list",$data_claim_d);

            for($i =0;$i < count($data);$i++){
                $data_pm_ca_seq["pm_ca_seq"] = $cl_ca_seq;
                $this->db->where("pm_seq",$data[$i]);
                $this->db->update("payment",$data_pm_ca_seq);
            }


            // 그전꺼 지워줌
            $this->db->select("*");
            $this->db->from("payment a");
            $this->db->join("service b","a.pm_sv_seq = b.sv_seq","left");
            $this->db->where("pm_ca_seq",$old_ca_seq);
            $query = $this->db->get();

            foreach($query->result_array as $row2){
                $sv_bill_name = $row2["sv_bill_name"];
                $total_price = $total_price+$row2["pm_total_price"];
                $sv_number = $row2["sv_number"];
            }

            $data_claim_d = array(
                "ca_item_name" => $sv_bill_name,
                "ca_item_price" => $total_price,
                "ca_item_surtax" => floor($total_price*0.1),
                "ca_sort" => 1,
                "ca_m_sv_num" => $sv_number
            );
            $this->db->where("cl_ca_seq",$old_ca_seq);
            $this->db->update("payment_claim_list",$data_claim_d);
            // return true;
        }
        //서비스 상태 변경
        for($i = 0; $i < count($data);$i++){
            $this->db->select("*");
            $this->db->from("payment a");
            $this->db->join("service b","a.pm_sv_seq = b.sv_seq","inner");
            $this->db->where("pm_seq",$data[$i]);

            $query = $this->db->get();

            $row = $query->row_array();
            if($row["sv_status"] == "0"){
                $data_status["sv_status"] = "1";
                $this->db->where("sv_seq",$row["sv_seq"]);
                $this->db->update("service",$data_status);
            }
        }
        return true;
    }

    public function claimMake($mb_seq){
        // 마지막 청구 가져오기
        $pm_sv_seq_arr = explode(",",$this->input->post("pm_sv_seq"));
        $pm_sv_seq_arr = array_reverse($pm_sv_seq_arr);
        for($i = 0; $i < count($pm_sv_seq_arr);$i++){
            $sv_seq_array = explode("|",$pm_sv_seq_arr[$i]);
            $pm_sv_seq = $sv_seq_array[0];
            $pm_sva_seq = $sv_seq_array[1];
            if($pm_sva_seq == ""){
                $this->db->select("*");
                $this->db->from("payment a");
                $this->db->join("service b","a.pm_sv_seq = b.sv_seq","inner");
                $this->db->join("service_price c","b.sv_seq = c.svp_sv_seq","inner");
                $this->db->where("pm_sv_seq",$pm_sv_seq);
                $this->db->where("pm_sva_seq is null");

                $this->db->order_by("pm_service_end desc");
                $this->db->limit(1);

                $query = $this->db->get();
                //최초결제 없음

                if($query->num_rows() == 0){
                    $this->db->select("*");
                    $this->db->from("service a");
                    $this->db->join("service_price b","a.sv_seq = b.svp_sv_seq","left");
                    $this->db->where("sv_seq",$pm_sv_seq);
                    $query = $this->db->get();
                    $row = $query->row_array();
                    $pay_day = $row["sv_pay_day"];
                    // if($row["sv_pay_type"] == "0"){ // 전월
                    //     $standard_day = substr($row["sv_account_start"],8,2);
                    //     if($pay_day > $standard_day){
                    //         $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sv_account_start"],5,2)-1,substr($row["sv_account_start"],8,2),substr($row["sv_account_start"],0,4)));
                    //     }else{
                    //         $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sv_account_start"],5,2),substr($row["sv_account_start"],8,2),substr($row["sv_account_start"],0,4)));
                    //     }
                    // }else if($row["sv_pay_type"] == "1"){ // 당월
                    //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sv_account_start"],5,2),substr($row["sv_account_start"],8,2),substr($row["sv_account_start"],0,4)));
                    // }else if($row["sv_pay_type"] == "2"){ // 익월
                    //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sv_account_start"],5,2)+1,substr($row["sv_account_start"],8,2),substr($row["sv_account_start"],0,4)));
                    // }else{
                    //     $claim_date = date("Y-m-".$pay_day);
                    // }
                    $claim_date = date("Y-m-d");
                    $end_date = date("Y-m-d",mktime(0,0,0,substr($claim_date,5,2),substr($claim_date,8,2)+$row["sv_payment_day"],substr($claim_date,0,4)));
                    if($row["svp_cl_seq"] == ""){
                        $this->db->select("pm_ca_seq");
                        $this->db->from("payment");
                        $this->db->where("pm_mb_seq",$row["sv_mb_seq"]);
                        $this->db->where("pm_date",$claim_date);
                        $this->db->where("pm_payment_publish_type",$row["sv_pay_publish_type"]);
                        $this->db->where("pm_end_date",$end_date);
                        $this->db->where("pm_status = '0'");
                        $this->db->limit(1);
                        $query_claim = $this->db->get();
                        if($query_claim->num_rows() > 0){
                            $row_claim = $query_claim->row_array();
                            $pm_ca_seq = $row_claim["pm_ca_seq"];
                        }else{
                            $pm_ca_seq = "";
                        }
                    }else{
                        // 여기 수정해야함
                        $this->db->select("*");
                        $this->db->from("payment_claim");
                        $this->db->where("ca_cl_seq",$row["svp_cl_seq"]);
                        $this->db->where("ca_date",$claim_date);
                        $this->db->limit(1);
                        $query_claim = $this->db->get();
                        if($query_claim->num_rows() > 0){
                            $row_claim = $query_claim->row_array();
                            $pm_ca_seq = $row_claim["pm_ca_seq"];
                        }else{
                            $pm_ca_seq = "";
                        }
                    }


                    $this->db->select("pm_code");
                    $this->db->from("payment");
                    $this->db->order_by("pm_seq","desc");
                    $this->db->limit(1);
                    $query_code = $this->db->get();

                    if($query_code->num_rows() == 0){
                        $pm_code = "CHA0000001";
                    }else{
                        $max_row = $query_code->row_array();
                        $max_row1 = substr($max_row["pm_code"],0,3);
                        $max_row2 = (int)substr($max_row["pm_code"],3,7);
                        $max_row2 = $max_row2+1;

                        $pm_code = $max_row1.sprintf("%07d",$max_row2);
                    }
                    $total_price = $row["svp_once_price"]-$row["svp_once_dis_price"]+$row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"];
                    $payment_data = array(
                        "pm_type" => "1",
                        "pm_mb_seq" => $row["sv_mb_seq"],
                        "pm_sv_seq" => $pm_sv_seq,
                        "pm_sva_seq" => $pm_sva_seq,
                        "pm_code" => $pm_code,
                        "pm_date" => $claim_date,
                        "pm_service_start" => $row["sv_account_start"],
                        "pm_service_end" =>  $row["sv_account_end"],
                        "pm_pay_type" => $row["sv_pay_type"],
                        "pm_pay_period" => $row["sv_payment_period"],
                        "pm_once_price" => $row["svp_once_price"],
                        "pm_once_dis_price" => $row["svp_once_dis_price"],
                        "pm_once_dis_msg" => $row["svp_once_dis_msg"],
                        "pm_service_price" => $row["svp_month_price"],
                        "pm_service_dis_price" => $row["svp_month_dis_price"],
                        "pm_service_dis_msg" => $row["svp_month_dis_msg"],
                        "pm_payment_dis_price" => $row["svp_discount_price"],
                        "pm_delay_price" => 0,
                        "pm_total_price" => $total_price,
                        "pm_surtax_price" => $total_price*0.1,
                        "pm_end_date" => $end_date,
                        "pm_status" => 0,
                        "pm_first_day_price" => $row["svp_first_day_price"],
                        "pm_first_day_start" => $row["svp_first_day_start"],
                        "pm_first_day_end" => $row["svp_first_day_end"],
                        "pm_first_month_price" => $row["svp_first_month_price"],
                        "pm_first_month_start" => $row["svp_first_month_start"],
                        "pm_first_month_end" => $row["svp_first_month_end"],
                        "pm_payment_publish_type" => $row["sv_pay_publish_type"],
                        "pm_ca_seq" => $pm_ca_seq,
                        "pm_claim_type" => "0"
                    );
                    $this->db->insert("payment",$payment_data);

                    $pm_seq = $this->db->insert_id();

                    if($pm_ca_seq != ""){
                        if($row["svp_cl_seq"] == ""){
                            $this->db->select("*");
                            $this->db->from("payment_claim_list");
                            $this->db->where("cl_ca_seq",$pm_ca_seq);
                            $this->db->where("ca_sort",1);
                            $query_c = $this->db->get();
                            $main = "";
                        }else{
                            $this->db->select("*");
                            $this->db->from("claim_detail");
                            $this->db->where("cd_svp_seq",$row["svp_seq"]);
                            $query = $this->db->get();
                            $row_cd = $query->row_array();
                            $main = $row_cd["cd_main"];
                            $this->db->select("*");
                            $this->db->from("payment_claim_list");
                            $this->db->where("cl_ca_seq",$pm_ca_seq);
                            $this->db->where("ca_sort",$row_cd["cd_num"]);
                            $query_c = $this->db->get();
                        }


                        if($query_c->num_rows() > 0){
                            $row_cl = $query_c->row_array();
                            $ca_item_price = $row_cl["ca_item_price"]+$total_price;
                            $ca_item_surtax = $row_cl["ca_item_surtax"]+$total_price*0.1;
                            if($row_cl["ca_m_sv_num"] < $row["sv_number"]){
                                $ca_m_sv_num = $row["sv_number"];
                                $ca_item_name = $row["sv_bill_name"];
                            }else{
                                $ca_m_sv_num = $row_cl["ca_m_sv_num"];
                                $ca_item_name = $row_cl["ca_item_name"];
                            }
                            $data_claim_detail = array(
                                "ca_item_name" => $ca_item_name,
                                "ca_item_price" => $ca_item_price,
                                "ca_item_surtax" => $ca_item_surtax,
                                "ca_m_sv_num" => $ca_m_sv_num
                            );
                            $this->db->where("cl_seq",$row_cl["cl_seq"]);
                            $this->db->update("payment_claim_list",$data_claim_detail);
                        }else{
                            $data_claim_detail = array(
                                "cl_ca_seq" => $pm_ca_seq,
                                "ca_item_name" => $row["sv_bill_name"],
                                "ca_item_price" => $total_price,
                                "ca_item_surtax" => floor($total_price*0.1),
                                "ca_sort" => 1,
                                "ca_m_sv_num" => $row["sv_number"]
                            );
                            $this->db->insert("payment_claim_list",$data_claim_detail);
                        }


                        $this->db->select("*");
                        $this->db->from("payment_claim");
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $claim_query = $this->db->get();
                        $row_c = $claim_query->row_array();
                        $total_claim_price = $row_c["ca_price"]+$total_price;
                        $total_claim_surtax = $row_c["ca_surtax"]+floor($total_price*0.1);
                        $total_claim_total_price = $total_claim_price+$total_claim_surtax;
                        $ca_empty_size = 11 - strlen($total_claim_total_price);
                        $ca_price_info1 = $total_claim_total_price;
                        $ca_price_info2 = $total_claim_total_price;

                        $data_update = array(
                            "ca_price" => $total_claim_price,
                            "ca_surtax" => $total_claim_surtax,
                            "ca_total_price" => $total_claim_total_price,
                            "ca_empty_size" => $ca_empty_size,
                            "ca_price_info1" => $ca_price_info1,
                            "ca_price_info2" => $ca_price_info2
                        );
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $this->db->update("payment_claim",$data_update);
                    }else{
                        $this->db->select("*");
                        $this->db->from("members");
                        $this->db->where("mb_seq",$row["sv_mb_seq"]);
                        $query_member = $this->db->get();

                        $row_member = $query_member->row_array();

                        $data_claim = array(
                            "ca_from_number" => "215-87-70318",
                            "ca_to_number" => $row_member["mb_number"],
                            "ca_from_name" => "아이온 시큐리티",
                            "ca_to_name" => $row_member["mb_name"],
                            "ca_from_ceo" => "김성혁",
                            "ca_to_ceo" => $row_member["mb_ceo"],
                            "ca_from_address" => "서울특별시 서초구 서초대로 255",
                            "ca_to_address"=> $row_member["mb_address"],
                            "ca_from_condition" => "서비스 외",
                            "ca_to_condition" => $row_member["mb_business_conditions"],
                            "ca_from_type" => "보안서비스 및 용역제공",
                            "ca_to_type" => $row_member["mb_business_type"],
                            "ca_from_team" => "영업2팀",
                            "ca_to_team" => $row_member["mb_payment_team"],
                            "ca_from_charger" => "전이준",
                            "ca_to_charger" => $row_member["mb_payment_name"],
                            "ca_from_tel" => "",
                            "ca_to_tel" => $row_member["mb_payment_tel"],
                            "ca_from_email" => "ijjun@eyeonsec.co.kr",
                            "ca_to_email" => $row_member["mb_payment_email"],
                            "ca_date" => $claim_date,
                            "ca_price" => $total_price,
                            "ca_surtax" => floor($total_price*0.1),
                            "ca_total_price" => floor($total_price*1.1),
                            "ca_empty_size" => 11-strlen(floor($total_price*1.1)),
                            "ca_price_info1" => floor($total_price*1.1),
                            "ca_price_info2" => floor($total_price*1.1),
                            "ca_price_info3" => 0,
                            "ca_price_info4" => 0,
                            "ca_price_info5" => 0,
                            "ca_payment_type" => $row["sv_pay_publish_type"],
                            "ca_mb_seq" => $row["sv_mb_seq"],
                            "ca_cl_seq" => $row["svp_cl_seq"]
                        );
                        $this->db->insert("payment_claim",$data_claim);

                        $cl_ca_seq = $this->db->insert_id();
                        if($row["svp_cl_seq"] == ""){

                            $num = 1;
                        }else{
                            $this->db->select("*");
                            $this->db->from("claim_detail");
                            $this->db->where("cd_svp_seq",$row["svp_seq"]);
                            $query = $this->db->get();
                            $row_cd = $query->row_array();
                            $num = $row_cd["cd_num"];
                        }

                        $data_claim_d = array(
                            "cl_ca_seq" => $cl_ca_seq,
                            "ca_item_name" => $row["sv_bill_name"],
                            "ca_item_price" => $total_price,
                            "ca_item_surtax" => floor($total_price*0.1),
                            "ca_sort" => $num,
                            "ca_m_sv_num" => $row["sv_number"]
                        );
                        $this->db->insert("payment_claim_list",$data_claim_d);

                        $data_pm_ca_seq["pm_ca_seq"] = $cl_ca_seq;
                        $this->db->where("pm_seq",$pm_seq);
                        $this->db->update("payment",$data_pm_ca_seq);
                    }
                }else{
                    $row = $query->row_array();
                    $pm_service_start = date("Y-m-d",mktime(0,0,0,substr($row["pm_service_end"],5,2),substr($row["pm_service_end"],8,2)+1,substr($row["pm_service_end"],0,4)));
                    $pm_service_end = date("Y-m-d",mktime(0,0,0,substr($row["pm_service_end"],5,2)+1,substr($row["pm_service_end"],8,2),substr($row["pm_service_end"],0,4)));

                    $pay_day = $row["sv_pay_day"];
                    // if($row["sv_pay_type"] == "0"){ // 전월
                    //     $standard_day = substr($pm_service_start,8,2);
                    //     if($pay_day > $standard_day){
                    //         $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($pm_service_start,5,2)-1,substr($pm_service_start,8,2),substr($pm_service_start,0,4)));
                    //     }else{
                    //         $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($pm_service_start,5,2),substr($pm_service_start,8,2),substr($pm_service_start,0,4)));
                    //     }
                    // }else if($row["sv_pay_type"] == "1"){ // 당월
                    //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($pm_service_start,5,2),substr($pm_service_start,8,2),substr($pm_service_start,0,4)));
                    // }else if($row["sv_pay_type"] == "2"){ // 익월
                    //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($pm_service_start,5,2)+1,substr($pm_service_start,8,2),substr($pm_service_start,0,4)));
                    // }
                    $claim_date = date("Y-m-d");

                    $end_date = date("Y-m-d",mktime(0,0,0,substr($claim_date,5,2),substr($claim_date,8,2)+$row["sv_payment_day"],substr($claim_date,0,4)));

                    if($row["svp_cl_seq"] == ""){
                        $this->db->select("pm_ca_seq");
                        $this->db->from("payment");
                        $this->db->where("pm_mb_seq",$row["sv_mb_seq"]);
                        $this->db->where("pm_date",$claim_date);
                        $this->db->where("pm_payment_publish_type",$row["sv_pay_publish_type"]);
                        $this->db->where("pm_end_date",$end_date);
                        $this->db->where("pm_status = '0'");
                        $this->db->limit(1);
                        $query_claim = $this->db->get();
                        if($query_claim->num_rows() > 0){
                            $row_claim = $query_claim->row_array();
                            $pm_ca_seq = $row_claim["pm_ca_seq"];
                        }else{
                            $pm_ca_seq = "";
                        }
                    }else{
                        // 여기 수정해야함
                        $this->db->select("*");
                        $this->db->from("payment_claim");
                        $this->db->where("ca_cl_seq",$row["svp_cl_seq"]);
                        $this->db->where("ca_date",$claim_date);
                        $this->db->limit(1);
                        $query_claim = $this->db->get();
                        if($query_claim->num_rows() > 0){
                            $row_claim = $query_claim->row_array();
                            $pm_ca_seq = $row_claim["pm_ca_seq"];
                        }else{
                            $pm_ca_seq = "";
                        }
                    }

                    $this->db->select("pm_code");
                    $this->db->from("payment");
                    $this->db->order_by("pm_seq","desc");
                    $this->db->limit(1);
                    $query_code = $this->db->get();

                    if($query_code->num_rows() == 0){
                        $pm_code = "CHA0000001";
                    }else{
                        $max_row = $query_code->row_array();
                        $max_row1 = substr($max_row["pm_code"],0,3);
                        $max_row2 = (int)substr($max_row["pm_code"],3,7);
                        $max_row2 = $max_row2+1;

                        $pm_code = $max_row1.sprintf("%07d",$max_row2);
                    }
                    $total_price = $row["svp_once_price"]-$row["svp_once_dis_price"]+$row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"]+$row["svp_first_day_price"];
                    $payment_data = array(
                        "pm_type" => "1",
                        "pm_mb_seq" => $row["sv_mb_seq"],
                        "pm_sv_seq" => $pm_sv_seq,
                        "pm_sva_seq" => $pm_sva_seq,
                        "pm_code" => $pm_code,
                        "pm_date" => $claim_date,
                        "pm_service_start" => $pm_service_start,
                        "pm_service_end" =>  $pm_service_end,
                        "pm_pay_type" => $row["sv_pay_type"],
                        "pm_pay_period" => $row["sv_payment_period"],
                        "pm_once_price" => $row["svp_once_price"],
                        "pm_once_dis_price" => $row["svp_once_dis_price"],
                        "pm_once_dis_msg" => $row["svp_once_dis_msg"],
                        "pm_service_price" => $row["svp_month_price"],
                        "pm_service_dis_price" => $row["svp_month_dis_price"],
                        "pm_service_dis_msg" => $row["svp_month_dis_msg"],
                        "pm_payment_dis_price" => $row["svp_discount_price"],
                        "pm_delay_price" => 0,
                        "pm_total_price" => $total_price,
                        "pm_surtax_price" => $total_price*0.1,
                        "pm_end_date" => $end_date,
                        "pm_status" => 0,
                        "pm_payment_publish_type" => $row["sv_pay_publish_type"],
                        "pm_ca_seq" => $pm_ca_seq,
                        "pm_first_month_start" => $pm_service_start,
                        "pm_first_month_end" => $pm_service_end
                    );

                    // $payment_data = array(
                    //     "pm_type" => "1",
                    //     "pm_mb_seq" => $row["sv_mb_seq"],
                    //     "pm_sv_seq" => $pm_sv_seq,
                    //     "pm_sva_seq" => $pm_sva_seq,
                    //     "pm_code" => $pm_code,
                    //     "pm_date" => $claim_date,
                    //     "pm_service_start" => $row["sv_account_start"],
                    //     "pm_service_end" =>  $row["sv_account_end"],
                    //     "pm_pay_type" => $row["sv_pay_type"],
                    //     "pm_pay_period" => $row["sv_payment_period"],
                    //     "pm_once_price" => $row["svp_once_price"],
                    //     "pm_once_dis_price" => $row["svp_once_dis_price"],
                    //     "pm_once_dis_msg" => $row["svp_once_dis_msg"],
                    //     "pm_service_price" => $row["svp_month_price"],
                    //     "pm_service_dis_price" => $row["svp_month_dis_price"],
                    //     "pm_service_dis_msg" => $row["svp_month_dis_msg"],
                    //     "pm_payment_dis_price" => $row["svp_discount_price"],
                    //     "pm_delay_price" => 0,
                    //     "pm_total_price" => $total_price,
                    //     "pm_surtax_price" => $total_price*0.1,
                    //     "pm_end_date" => $end_date,
                    //     "pm_status" => 0,
                    //     "pm_first_day_price" => $row["svp_first_day_price"],
                    //     "pm_first_day_start" => $row["svp_first_day_start"],
                    //     "pm_first_day_end" => $row["svp_first_day_end"],
                    //     "pm_first_month_price" => $row["svp_first_month_price"],
                    //     "pm_first_month_start" => $row["svp_first_month_start"],
                    //     "pm_first_month_end" => $row["svp_first_month_end"],
                    //     "pm_payment_publish_type" => $row["sv_pay_publish_type"],
                    //     "pm_ca_seq" => $pm_ca_seq,
                    //     "pm_claim_type" => "0"
                    // );
                    $this->db->insert("payment",$payment_data);

                    $pm_seq = $this->db->insert_id();

                    if($pm_ca_seq != ""){
                        if($row["svp_cl_seq"] == ""){
                            $this->db->select("*");
                            $this->db->from("payment_claim_list");
                            $this->db->where("cl_ca_seq",$pm_ca_seq);
                            $this->db->where("ca_sort",1);
                            $query_c = $this->db->get();
                            $main = "";
                        }else{
                            $this->db->select("*");
                            $this->db->from("claim_detail");
                            $this->db->where("cd_svp_seq",$row["svp_seq"]);
                            $query = $this->db->get();
                            $row_cd = $query->row_array();
                            $main = $row_cd["cd_main"];
                            $this->db->select("*");
                            $this->db->from("payment_claim_list");
                            $this->db->where("cl_ca_seq",$pm_ca_seq);
                            $this->db->where("ca_sort",$row_cd["cd_num"]);
                            $query_c = $this->db->get();
                        }


                        if($query_c->num_rows() > 0){
                            $row_cl = $query_c->row_array();
                            $ca_item_price = $row_cl["ca_item_price"]+$total_price;
                            $ca_item_surtax = $row_cl["ca_item_surtax"]+$total_price*0.1;
                            if($row_cl["ca_m_sv_num"] < $row["sv_number"]){
                                $ca_m_sv_num = $row["sv_number"];
                                $ca_item_name = $row["sv_bill_name"];
                            }else{
                                $ca_m_sv_num = $row_cl["ca_m_sv_num"];
                                $ca_item_name = $row_cl["ca_item_name"];
                            }
                            $data_claim_detail = array(
                                "ca_item_name" => $ca_item_name,
                                "ca_item_price" => $ca_item_price,
                                "ca_item_surtax" => $ca_item_surtax,
                                "ca_m_sv_num" => $ca_m_sv_num
                            );
                            $this->db->where("cl_seq",$row_cl["cl_seq"]);
                            $this->db->update("payment_claim_list",$data_claim_detail);
                        }else{
                            $data_claim_detail = array(
                                "cl_ca_seq" => $pm_ca_seq,
                                "ca_item_name" => $row["sv_bill_name"],
                                "ca_item_price" => $total_price,
                                "ca_item_surtax" => floor($total_price*0.1),
                                "ca_sort" => 1,
                                "ca_m_sv_num" => $row["sv_number"]
                            );
                            $this->db->insert("payment_claim_list",$data_claim_detail);
                        }


                        $this->db->select("*");
                        $this->db->from("payment_claim");
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $claim_query = $this->db->get();
                        $row_c = $claim_query->row_array();
                        $total_claim_price = $row_c["ca_price"]+$total_price;
                        $total_claim_surtax = $row_c["ca_surtax"]+floor($total_price*0.1);
                        $total_claim_total_price = $total_claim_price+$total_claim_surtax;
                        $ca_empty_size = 11 - strlen($total_claim_total_price);
                        $ca_price_info1 = $total_claim_total_price;
                        $ca_price_info2 = $total_claim_total_price;

                        $data_update = array(
                            "ca_price" => $total_claim_price,
                            "ca_surtax" => $total_claim_surtax,
                            "ca_total_price" => $total_claim_total_price,
                            "ca_empty_size" => $ca_empty_size,
                            "ca_price_info1" => $ca_price_info1,
                            "ca_price_info2" => $ca_price_info2
                        );
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $this->db->update("payment_claim",$data_update);
                    }else{
                        $this->db->select("*");
                        $this->db->from("members");
                        $this->db->where("mb_seq",$row["sv_mb_seq"]);
                        $query_member = $this->db->get();

                        $row_member = $query_member->row_array();

                        $data_claim = array(
                            "ca_from_number" => "215-87-70318",
                            "ca_to_number" => $row_member["mb_number"],
                            "ca_from_name" => "아이온 시큐리티",
                            "ca_to_name" => $row_member["mb_name"],
                            "ca_from_ceo" => "김성혁",
                            "ca_to_ceo" => $row_member["mb_ceo"],
                            "ca_from_address" => "서울특별시 서초구 서초대로 255",
                            "ca_to_address"=> $row_member["mb_address"],
                            "ca_from_condition" => "서비스 외",
                            "ca_to_condition" => $row_member["mb_business_conditions"],
                            "ca_from_type" => "보안서비스 및 용역제공",
                            "ca_to_type" => $row_member["mb_business_type"],
                            "ca_from_team" => "영업2팀",
                            "ca_to_team" => $row_member["mb_payment_team"],
                            "ca_from_charger" => "전이준",
                            "ca_to_charger" => $row_member["mb_payment_name"],
                            "ca_from_tel" => "",
                            "ca_to_tel" => $row_member["mb_payment_tel"],
                            "ca_from_email" => "ijjun@eyeonsec.co.kr",
                            "ca_to_email" => $row_member["mb_payment_email"],
                            "ca_date" => $claim_date,
                            "ca_price" => $total_price,
                            "ca_surtax" => floor($total_price*0.1),
                            "ca_total_price" => floor($total_price*1.1),
                            "ca_empty_size" => 11-strlen(floor($total_price*1.1)),
                            "ca_price_info1" => floor($total_price*1.1),
                            "ca_price_info2" => floor($total_price*1.1),
                            "ca_price_info3" => 0,
                            "ca_price_info4" => 0,
                            "ca_price_info5" => 0,
                            "ca_payment_type" => $row["sv_pay_publish_type"],
                            "ca_mb_seq" => $row["sv_mb_seq"],
                            "ca_cl_seq" => $row["svp_cl_seq"]
                        );
                        $this->db->insert("payment_claim",$data_claim);

                        $cl_ca_seq = $this->db->insert_id();
                        if($row["svp_cl_seq"] == ""){

                            $num = 1;
                        }else{
                            $this->db->select("*");
                            $this->db->from("claim_detail");
                            $this->db->where("cd_svp_seq",$row["svp_seq"]);
                            $query = $this->db->get();
                            $row_cd = $query->row_array();
                            $num = $row_cd["cd_num"];
                        }
                        $data_claim_d = array(
                            "cl_ca_seq" => $cl_ca_seq,
                            "ca_item_name" => $row["sv_bill_name"],
                            "ca_item_price" => $total_price,
                            "ca_item_surtax" => floor($total_price*0.1),
                            "ca_sort" => 1,
                            "ca_m_sv_num" => $row["sv_number"]
                        );
                        $this->db->insert("payment_claim_list",$data_claim_d);

                        $data_pm_ca_seq["pm_ca_seq"] = $cl_ca_seq;
                        $this->db->where("pm_seq",$pm_seq);
                        $this->db->update("payment",$data_pm_ca_seq);
                    }
                }
            }else{ // 부가서비스 등록
                $this->db->select("*");
                $this->db->from("payment a");
                $this->db->join("service_addoption b","a.pm_sva_seq = b.sva_seq","inner");
                $this->db->join("service bb","b.sva_sv_seq = bb.sv_seq","left");
                $this->db->join("service_price c","b.sva_seq = c.svp_sva_seq","inner");
                $this->db->where("pm_sva_seq",$pm_sva_seq);

                $this->db->order_by("pm_service_end desc");
                $this->db->limit(1);

                $query = $this->db->get();
                //최초결제 없음

                if($query->num_rows() == 0){
                    $this->db->select("*");
                    $this->db->from("service_addoption a");
                    $this->db->join("service aa","a.sva_sv_seq = aa.sv_seq","left");
                    $this->db->join("service_price b","a.sva_seq = b.svp_sva_seq","left");
                    $this->db->where("sva_seq",$pm_sva_seq);
                    $query = $this->db->get();
                    $row = $query->row_array();
                    // $pay_day = $row["sv_pay_day"];
                    // if($row["sv_pay_type"] == "0"){ // 전월
                    //     $standard_day = substr($row["sv_account_start"],8,2);
                    //     if($pay_day > $standard_day){
                    //         $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sv_account_start"],5,2)-1,substr($row["sv_account_start"],8,2),substr($row["sv_account_start"],0,4)));
                    //     }else{
                    //         $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sv_account_start"],5,2),substr($row["sv_account_start"],8,2),substr($row["sv_account_start"],0,4)));
                    //     }
                    // }else if($row["sv_pay_type"] == "1"){ // 당월
                    //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sv_account_start"],5,2),substr($row["sv_account_start"],8,2),substr($row["sv_account_start"],0,4)));
                    // }else if($row["sv_pay_type"] == "2"){ // 익월
                    //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($row["sv_account_start"],5,2)+1,substr($row["sv_account_start"],8,2),substr($row["sv_account_start"],0,4)));
                    // }else{
                    //     $claim_date = date("Y-m-".$pay_day);
                    // }
                    $claim_date = date("Y-m-d");
                    $end_date = date("Y-m-d",mktime(0,0,0,substr($claim_date,5,2),substr($claim_date,8,2)+$row["sv_payment_day"],substr($claim_date,0,4)));
                    if($row["svp_cl_seq"] == ""){
                        $this->db->select("pm_ca_seq");
                        $this->db->from("payment");
                        $this->db->where("pm_mb_seq",$row["sv_mb_seq"]);
                        $this->db->where("pm_date",$claim_date);
                        $this->db->where("pm_payment_publish_type",$row["sv_pay_publish_type"]);
                        $this->db->where("pm_end_date",$end_date);
                        $this->db->where("pm_status = '0'");
                        $this->db->limit(1);
                        $query_claim = $this->db->get();
                        if($query_claim->num_rows() > 0){
                            $row_claim = $query_claim->row_array();
                            $pm_ca_seq = $row_claim["pm_ca_seq"];
                        }else{
                            $pm_ca_seq = "";
                        }
                    }else{
                        // 여기 수정해야함
                        $this->db->select("*");
                        $this->db->from("payment_claim");
                        $this->db->where("ca_cl_seq",$row["svp_cl_seq"]);
                        $this->db->where("ca_date",$claim_date);
                        $this->db->limit(1);
                        $query_claim = $this->db->get();
                        if($query_claim->num_rows() > 0){
                            $row_claim = $query_claim->row_array();
                            $pm_ca_seq = $row_claim["pm_ca_seq"];
                        }else{
                            $pm_ca_seq = "";
                        }
                    }


                    $this->db->select("pm_code");
                    $this->db->from("payment");
                    $this->db->order_by("pm_seq","desc");
                    $this->db->limit(1);
                    $query_code = $this->db->get();

                    if($query_code->num_rows() == 0){
                        $pm_code = "CHA0000001";
                    }else{
                        $max_row = $query_code->row_array();
                        $max_row1 = substr($max_row["pm_code"],0,3);
                        $max_row2 = (int)substr($max_row["pm_code"],3,7);
                        $max_row2 = $max_row2+1;

                        $pm_code = $max_row1.sprintf("%07d",$max_row2);
                    }
                    $total_price = $row["svp_once_price"]-$row["svp_once_dis_price"]+$row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"];
                    $payment_data = array(
                        "pm_type" => "1",
                        "pm_mb_seq" => $row["sv_mb_seq"],
                        "pm_sv_seq" => $pm_sv_seq,
                        "pm_sva_seq" => $pm_sva_seq,
                        "pm_code" => $pm_code,
                        "pm_date" => $claim_date,
                        "pm_service_start" => $row["sv_account_start"],
                        "pm_service_end" =>  $row["sv_account_end"],
                        "pm_pay_type" => $row["sv_pay_type"],
                        "pm_pay_period" => $row["sva_pay_day"],
                        "pm_once_price" => $row["svp_once_price"],
                        "pm_once_dis_price" => $row["svp_once_dis_price"],
                        "pm_once_dis_msg" => $row["svp_once_dis_msg"],
                        "pm_service_price" => $row["svp_month_price"],
                        "pm_service_dis_price" => $row["svp_month_dis_price"],
                        "pm_service_dis_msg" => $row["svp_month_dis_msg"],
                        "pm_payment_dis_price" => $row["svp_discount_price"],
                        "pm_delay_price" => 0,
                        "pm_total_price" => $total_price,
                        "pm_surtax_price" => $total_price*0.1,
                        "pm_end_date" => $end_date,
                        "pm_status" => 0,
                        "pm_first_day_price" => $row["svp_first_day_price"],
                        "pm_first_day_start" => $row["svp_first_day_start"],
                        "pm_first_day_end" => $row["svp_first_day_end"],
                        "pm_first_month_price" => $row["svp_first_month_price"],
                        "pm_first_month_start" => $row["svp_first_month_start"],
                        "pm_first_month_end" => $row["svp_first_month_end"],
                        "pm_payment_publish_type" => $row["sv_pay_publish_type"],
                        "pm_ca_seq" => $pm_ca_seq,
                        "pm_claim_type" => "0"
                    );
                    $this->db->insert("payment",$payment_data);

                    $pm_seq = $this->db->insert_id();

                    if($pm_ca_seq != ""){
                        if($row["svp_cl_seq"] == ""){
                            $this->db->select("*");
                            $this->db->from("payment_claim_list");
                            $this->db->where("cl_ca_seq",$pm_ca_seq);
                            $this->db->where("ca_sort",1);
                            $query_c = $this->db->get();
                            $main = "";
                        }else{
                            $this->db->select("*");
                            $this->db->from("claim_detail");
                            $this->db->where("cd_svp_seq",$row["svp_seq"]);
                            $query = $this->db->get();
                            $row_cd = $query->row_array();
                            $main = $row_cd["cd_main"];
                            $this->db->select("*");
                            $this->db->from("payment_claim_list");
                            $this->db->where("cl_ca_seq",$pm_ca_seq);
                            $this->db->where("ca_sort",$row_cd["cd_num"]);
                            $query_c = $this->db->get();
                        }


                        if($query_c->num_rows() > 0){
                            $row_cl = $query_c->row_array();
                            $ca_item_price = $row_cl["ca_item_price"]+$total_price;
                            $ca_item_surtax = $row_cl["ca_item_surtax"]+$total_price*0.1;
                            if($row_cl["ca_m_sv_num"] < $row["sv_number"]){
                                $ca_m_sv_num = $row["sv_number"];
                                $ca_item_name = $row["sva_bill_name"];
                            }else{
                                $ca_m_sv_num = $row_cl["ca_m_sv_num"];
                                $ca_item_name = $row_cl["ca_item_name"];
                            }
                            $data_claim_detail = array(
                                "ca_item_name" => $ca_item_name,
                                "ca_item_price" => $ca_item_price,
                                "ca_item_surtax" => $ca_item_surtax,
                                "ca_m_sv_num" => $ca_m_sv_num
                            );
                            $this->db->where("cl_seq",$row_cl["cl_seq"]);
                            $this->db->update("payment_claim_list",$data_claim_detail);
                        }else{
                            $data_claim_detail = array(
                                "cl_ca_seq" => $pm_ca_seq,
                                "ca_item_name" => $row["sva_bill_name"],
                                "ca_item_price" => $total_price,
                                "ca_item_surtax" => floor($total_price*0.1),
                                "ca_sort" => 1,
                                "ca_m_sv_num" => $row["sv_number"]
                            );
                            $this->db->insert("payment_claim_list",$data_claim_detail);
                        }


                        $this->db->select("*");
                        $this->db->from("payment_claim");
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $claim_query = $this->db->get();
                        $row_c = $claim_query->row_array();
                        $total_claim_price = $row_c["ca_price"]+$total_price;
                        $total_claim_surtax = $row_c["ca_surtax"]+floor($total_price*0.1);
                        $total_claim_total_price = $total_claim_price+$total_claim_surtax;
                        $ca_empty_size = 11 - strlen($total_claim_total_price);
                        $ca_price_info1 = $total_claim_total_price;
                        $ca_price_info2 = $total_claim_total_price;

                        $data_update = array(
                            "ca_price" => $total_claim_price,
                            "ca_surtax" => $total_claim_surtax,
                            "ca_total_price" => $total_claim_total_price,
                            "ca_empty_size" => $ca_empty_size,
                            "ca_price_info1" => $ca_price_info1,
                            "ca_price_info2" => $ca_price_info2
                        );
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $this->db->update("payment_claim",$data_update);
                    }else{
                        $this->db->select("*");
                        $this->db->from("members");
                        $this->db->where("mb_seq",$row["sv_mb_seq"]);
                        $query_member = $this->db->get();

                        $row_member = $query_member->row_array();

                        $data_claim = array(
                            "ca_from_number" => "215-87-70318",
                            "ca_to_number" => $row_member["mb_number"],
                            "ca_from_name" => "아이온 시큐리티",
                            "ca_to_name" => $row_member["mb_name"],
                            "ca_from_ceo" => "김성혁",
                            "ca_to_ceo" => $row_member["mb_ceo"],
                            "ca_from_address" => "서울특별시 서초구 서초대로 255",
                            "ca_to_address"=> $row_member["mb_address"],
                            "ca_from_condition" => "서비스 외",
                            "ca_to_condition" => $row_member["mb_business_conditions"],
                            "ca_from_type" => "보안서비스 및 용역제공",
                            "ca_to_type" => $row_member["mb_business_type"],
                            "ca_from_team" => "영업2팀",
                            "ca_to_team" => $row_member["mb_payment_team"],
                            "ca_from_charger" => "전이준",
                            "ca_to_charger" => $row_member["mb_payment_name"],
                            "ca_from_tel" => "",
                            "ca_to_tel" => $row_member["mb_payment_tel"],
                            "ca_from_email" => "ijjun@eyeonsec.co.kr",
                            "ca_to_email" => $row_member["mb_payment_email"],
                            "ca_date" => $claim_date,
                            "ca_price" => $total_price,
                            "ca_surtax" => floor($total_price*0.1),
                            "ca_total_price" => floor($total_price*1.1),
                            "ca_empty_size" => 11-strlen(floor($total_price*1.1)),
                            "ca_price_info1" => floor($total_price*1.1),
                            "ca_price_info2" => floor($total_price*1.1),
                            "ca_price_info3" => 0,
                            "ca_price_info4" => 0,
                            "ca_price_info5" => 0,
                            "ca_payment_type" => $row["sv_pay_publish_type"],
                            "ca_mb_seq" => $row["sv_mb_seq"],
                            "ca_cl_seq" => $row["svp_cl_seq"]
                        );
                        $this->db->insert("payment_claim",$data_claim);

                        $cl_ca_seq = $this->db->insert_id();
                        if($row["svp_cl_seq"] == ""){

                            $num = 1;
                        }else{
                            $this->db->select("*");
                            $this->db->from("claim_detail");
                            $this->db->where("cd_svp_seq",$row["svp_seq"]);
                            $query = $this->db->get();
                            $row_cd = $query->row_array();
                            $num = $row_cd["cd_num"];
                        }

                        $data_claim_d = array(
                            "cl_ca_seq" => $cl_ca_seq,
                            "ca_item_name" => $row["sva_bill_name"],
                            "ca_item_price" => $total_price,
                            "ca_item_surtax" => floor($total_price*0.1),
                            "ca_sort" => $num,
                            "ca_m_sv_num" => $row["sv_number"]
                        );
                        $this->db->insert("payment_claim_list",$data_claim_d);

                        $data_pm_ca_seq["pm_ca_seq"] = $cl_ca_seq;
                        $this->db->where("pm_seq",$pm_seq);
                        $this->db->update("payment",$data_pm_ca_seq);
                    }
                }else{
                    $row = $query->row_array();
                    $pm_service_start = date("Y-m-d",mktime(0,0,0,substr($row["pm_service_end"],5,2),substr($row["pm_service_end"],8,2)+1,substr($row["pm_service_end"],0,4)));
                    $pm_service_end = date("Y-m-d",mktime(0,0,0,substr($row["pm_service_end"],5,2)+1,substr($row["pm_service_end"],8,2),substr($row["pm_service_end"],0,4)));

                    // $pay_day = $row["sv_pay_day"];
                    // if($row["sv_pay_type"] == "0"){ // 전월
                    //     $standard_day = substr($pm_service_start,8,2);
                    //     if($pay_day > $standard_day){
                    //         $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($pm_service_start,5,2)-1,substr($pm_service_start,8,2),substr($pm_service_start,0,4)));
                    //     }else{
                    //         $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($pm_service_start,5,2),substr($pm_service_start,8,2),substr($pm_service_start,0,4)));
                    //     }
                    // }else if($row["sv_pay_type"] == "1"){ // 당월
                    //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($pm_service_start,5,2),substr($pm_service_start,8,2),substr($pm_service_start,0,4)));
                    // }else if($row["sv_pay_type"] == "2"){ // 익월
                    //     $claim_date = date("Y-m-".$pay_day,mktime(0,0,0,substr($pm_service_start,5,2)+1,substr($pm_service_start,8,2),substr($pm_service_start,0,4)));
                    // }
                    $claim_date = date("Y-m-d");

                    $end_date = date("Y-m-d",mktime(0,0,0,substr($claim_date,5,2),substr($claim_date,8,2)+$row["sv_payment_day"],substr($claim_date,0,4)));

                    if($row["svp_cl_seq"] == ""){
                        $this->db->select("pm_ca_seq");
                        $this->db->from("payment");
                        $this->db->where("pm_mb_seq",$row["sv_mb_seq"]);
                        $this->db->where("pm_date",$claim_date);
                        $this->db->where("pm_payment_publish_type",$row["sv_pay_publish_type"]);
                        $this->db->where("pm_end_date",$end_date);
                        $this->db->where("pm_status = '0'");
                        $this->db->limit(1);
                        $query_claim = $this->db->get();
                        if($query_claim->num_rows() > 0){
                            $row_claim = $query_claim->row_array();
                            $pm_ca_seq = $row_claim["pm_ca_seq"];
                        }else{
                            $pm_ca_seq = "";
                        }
                    }else{
                        // 여기 수정해야함
                        $this->db->select("*");
                        $this->db->from("payment_claim");
                        $this->db->where("ca_cl_seq",$row["svp_cl_seq"]);
                        $this->db->where("ca_date",$claim_date);
                        $this->db->limit(1);
                        $query_claim = $this->db->get();
                        if($query_claim->num_rows() > 0){
                            $row_claim = $query_claim->row_array();
                            $pm_ca_seq = $row_claim["pm_ca_seq"];
                        }else{
                            $pm_ca_seq = "";
                        }
                    }

                    $this->db->select("pm_code");
                    $this->db->from("payment");
                    $this->db->order_by("pm_seq","desc");
                    $this->db->limit(1);
                    $query_code = $this->db->get();

                    if($query_code->num_rows() == 0){
                        $pm_code = "CHA0000001";
                    }else{
                        $max_row = $query_code->row_array();
                        $max_row1 = substr($max_row["pm_code"],0,3);
                        $max_row2 = (int)substr($max_row["pm_code"],3,7);
                        $max_row2 = $max_row2+1;

                        $pm_code = $max_row1.sprintf("%07d",$max_row2);
                    }
                    $total_price = $row["svp_once_price"]-$row["svp_once_dis_price"]+$row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"]+$row["svp_first_day_price"];
                    $payment_data = array(
                        "pm_type" => "1",
                        "pm_mb_seq" => $row["sv_mb_seq"],
                        "pm_sv_seq" => $pm_sv_seq,
                        "pm_sva_seq" => $pm_sva_seq,
                        "pm_code" => $pm_code,
                        "pm_date" => $claim_date,
                        "pm_service_start" => $pm_service_start,
                        "pm_service_end" =>  $pm_service_end,
                        "pm_pay_type" => $row["sv_pay_type"],
                        "pm_pay_period" => $row["sva_pay_day"],
                        "pm_once_price" => $row["svp_once_price"],
                        "pm_once_dis_price" => $row["svp_once_dis_price"],
                        "pm_once_dis_msg" => $row["svp_once_dis_msg"],
                        "pm_service_price" => $row["svp_month_price"],
                        "pm_service_dis_price" => $row["svp_month_dis_price"],
                        "pm_service_dis_msg" => $row["svp_month_dis_msg"],
                        "pm_payment_dis_price" => $row["svp_discount_price"],
                        "pm_delay_price" => 0,
                        "pm_total_price" => $total_price,
                        "pm_surtax_price" => $total_price*0.1,
                        "pm_end_date" => $end_date,
                        "pm_status" => 0,
                        "pm_payment_publish_type" => $row["sv_pay_publish_type"],
                        "pm_ca_seq" => $pm_ca_seq
                    );
                    $this->db->insert("payment",$payment_data);

                    $pm_seq = $this->db->insert_id();

                    if($pm_ca_seq != ""){
                        if($row["svp_cl_seq"] == ""){
                            $this->db->select("*");
                            $this->db->from("payment_claim_list");
                            $this->db->where("cl_ca_seq",$pm_ca_seq);
                            $this->db->where("ca_sort",1);
                            $query_c = $this->db->get();
                            $main = "";
                        }else{
                            $this->db->select("*");
                            $this->db->from("claim_detail");
                            $this->db->where("cd_svp_seq",$row["svp_seq"]);
                            $query = $this->db->get();
                            $row_cd = $query->row_array();
                            $main = $row_cd["cd_main"];
                            $this->db->select("*");
                            $this->db->from("payment_claim_list");
                            $this->db->where("cl_ca_seq",$pm_ca_seq);
                            $this->db->where("ca_sort",$row_cd["cd_num"]);
                            $query_c = $this->db->get();
                        }


                        if($query_c->num_rows() > 0){
                            $row_cl = $query_c->row_array();
                            $ca_item_price = $row_cl["ca_item_price"]+$total_price;
                            $ca_item_surtax = $row_cl["ca_item_surtax"]+$total_price*0.1;
                            if($row_cl["ca_m_sv_num"] < $row["sv_number"]){
                                $ca_m_sv_num = $row["sv_number"];
                                $ca_item_name = $row["sva_bill_name"];
                            }else{
                                $ca_m_sv_num = $row_cl["ca_m_sv_num"];
                                $ca_item_name = $row_cl["ca_item_name"];
                            }
                            $data_claim_detail = array(
                                "ca_item_name" => $ca_item_name,
                                "ca_item_price" => $ca_item_price,
                                "ca_item_surtax" => $ca_item_surtax,
                                "ca_m_sv_num" => $ca_m_sv_num
                            );
                            $this->db->where("cl_seq",$row_cl["cl_seq"]);
                            $this->db->update("payment_claim_list",$data_claim_detail);
                        }else{
                            $data_claim_detail = array(
                                "cl_ca_seq" => $pm_ca_seq,
                                "ca_item_name" => $row["sva_bill_name"],
                                "ca_item_price" => $total_price,
                                "ca_item_surtax" => floor($total_price*0.1),
                                "ca_sort" => 1,
                                "ca_m_sv_num" => $row["sv_number"]
                            );
                            $this->db->insert("payment_claim_list",$data_claim_detail);
                        }


                        $this->db->select("*");
                        $this->db->from("payment_claim");
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $claim_query = $this->db->get();
                        $row_c = $claim_query->row_array();
                        $total_claim_price = $row_c["ca_price"]+$total_price;
                        $total_claim_surtax = $row_c["ca_surtax"]+floor($total_price*0.1);
                        $total_claim_total_price = $total_claim_price+$total_claim_surtax;
                        $ca_empty_size = 11 - strlen($total_claim_total_price);
                        $ca_price_info1 = $total_claim_total_price;
                        $ca_price_info2 = $total_claim_total_price;

                        $data_update = array(
                            "ca_price" => $total_claim_price,
                            "ca_surtax" => $total_claim_surtax,
                            "ca_total_price" => $total_claim_total_price,
                            "ca_empty_size" => $ca_empty_size,
                            "ca_price_info1" => $ca_price_info1,
                            "ca_price_info2" => $ca_price_info2
                        );
                        $this->db->where("ca_seq",$pm_ca_seq);
                        $this->db->update("payment_claim",$data_update);
                    }else{
                        $this->db->select("*");
                        $this->db->from("members");
                        $this->db->where("mb_seq",$row["sv_mb_seq"]);
                        $query_member = $this->db->get();

                        $row_member = $query_member->row_array();

                        $data_claim = array(
                            "ca_from_number" => "215-87-70318",
                            "ca_to_number" => $row_member["mb_number"],
                            "ca_from_name" => "아이온 시큐리티",
                            "ca_to_name" => $row_member["mb_name"],
                            "ca_from_ceo" => "김성혁",
                            "ca_to_ceo" => $row_member["mb_ceo"],
                            "ca_from_address" => "서울특별시 서초구 서초대로 255",
                            "ca_to_address"=> $row_member["mb_address"],
                            "ca_from_condition" => "서비스 외",
                            "ca_to_condition" => $row_member["mb_business_conditions"],
                            "ca_from_type" => "보안서비스 및 용역제공",
                            "ca_to_type" => $row_member["mb_business_type"],
                            "ca_from_team" => "영업2팀",
                            "ca_to_team" => $row_member["mb_payment_team"],
                            "ca_from_charger" => "전이준",
                            "ca_to_charger" => $row_member["mb_payment_name"],
                            "ca_from_tel" => "",
                            "ca_to_tel" => $row_member["mb_payment_tel"],
                            "ca_from_email" => "ijjun@eyeonsec.co.kr",
                            "ca_to_email" => $row_member["mb_payment_email"],
                            "ca_date" => $claim_date,
                            "ca_price" => $total_price,
                            "ca_surtax" => floor($total_price*0.1),
                            "ca_total_price" => floor($total_price*1.1),
                            "ca_empty_size" => 11-strlen(floor($total_price*1.1)),
                            "ca_price_info1" => floor($total_price*1.1),
                            "ca_price_info2" => floor($total_price*1.1),
                            "ca_price_info3" => 0,
                            "ca_price_info4" => 0,
                            "ca_price_info5" => 0,
                            "ca_payment_type" => $row["sv_pay_publish_type"],
                            "ca_mb_seq" => $row["sv_mb_seq"],
                            "ca_cl_seq" => $row["svp_cl_seq"]
                        );
                        $this->db->insert("payment_claim",$data_claim);

                        $cl_ca_seq = $this->db->insert_id();
                        if($row["svp_cl_seq"] == ""){

                            $num = 1;
                        }else{
                            $this->db->select("*");
                            $this->db->from("claim_detail");
                            $this->db->where("cd_svp_seq",$row["svp_seq"]);
                            $query = $this->db->get();
                            $row_cd = $query->row_array();
                            $num = $row_cd["cd_num"];
                        }
                        $data_claim_d = array(
                            "cl_ca_seq" => $cl_ca_seq,
                            "ca_item_name" => $row["sva_bill_name"],
                            "ca_item_price" => $total_price,
                            "ca_item_surtax" => floor($total_price*0.1),
                            "ca_sort" => 1,
                            "ca_m_sv_num" => $row["sv_number"]
                        );
                        $this->db->insert("payment_claim_list",$data_claim_d);

                        $data_pm_ca_seq["pm_ca_seq"] = $cl_ca_seq;
                        $this->db->where("pm_seq",$pm_seq);
                        $this->db->update("payment",$data_pm_ca_seq);
                    }
                }
            }
        }
        return true;
    }

    public function memberAutoClaim(){
        $data = array(
            "mb_auto_claim_yn" => $this->input->post("mb_auto_claim_yn")
        );
        $this->db->where("mb_seq",$this->input->post("mb_seq"));
        return $this->db->update("members",$data);
    }

    public function memberAutoEmail(){
        $data = array(
            "mb_auto_email_yn" => $this->input->post("mb_auto_email_yn")
        );
        $this->db->where("mb_seq",$this->input->post("mb_seq"));
        return $this->db->update("members",$data);
    }

    public function memberOverPay(){
        $data = array(
            "mb_over_pay_yn" => $this->input->post("mb_over_pay_yn")
        );
        $this->db->where("mb_seq",$this->input->post("mb_seq"));
        return $this->db->update("members",$data);
    }

    public function serviceDelete(){
        $this->db->where("sva_sv_seq",$this->input->post("sv_seq"));
        $this->db->delete("service_addoption");

        $this->db->where("svp_sv_seq",$this->input->post("sv_seq"));
        $this->db->delete("service_price");

        $this->db->where("sv_seq",$this->input->post("sv_seq"));
        return $this->db->delete("service");

    }

    public function serviceInstallEdit(){

        $data = array(
            "sv_position" => $this->input->post("sv_position"),
            "sv_serial_number" => $this->input->post("sv_serial_number"),
            "sv_firmware" => $this->input->post("sv_firmware"),
            "sv_install_charger" => $this->input->post("sv_install_charger"),
            "sv_install_date" => $this->input->post("sv_install_date"),
            "sv_security_level" => $this->input->post("sv_security_level")
        );

        $this->db->where("sv_seq",$this->input->post("sv_seq"));
        return $this->db->update("service_install",$data);

    }

    public function serviceInstallIpAdd(){
        $data = array(
            "sii_sv_seq" => $this->input->post("sii_sv_seq"),
            "sii_ip" => $this->input->post("sii_ip")
        );

        return $this->db->insert("service_install_ip",$data);
    }

    public function serviceInstallIpEdit(){
        $data = array(
            "sii_ip" => $this->input->post("sii_ip")
        );
        $this->db->where("sii_seq",$this->input->post("sii_seq"));
        return $this->db->update("service_install_ip",$data);
    }

    public function serviceInstallIpDel(){
        $this->db->where("sii_seq",$this->input->get("sii_seq"));
        return $this->db->delete("service_install_ip");
    }

    public function serviceLicenseAdd(){
        $data = array(
            "sl_sv_seq" => $this->input->post("sv_seq"),
            "sl_license_name" => $this->input->post("sl_license_name"),
            "sl_start_date" => $this->input->post("sl_start_date"),
            "sl_end_date" => $this->input->post("sl_end_date"),
            "sl_contract_number" => $this->input->post("sl_contract_number")
        );

        return $this->db->insert("service_license",$data);
    }

    public function serviceLicenseEdit(){
        $data = array(
            "sl_license_name" => $this->input->post("sl_license_name"),
            "sl_start_date" => $this->input->post("sl_start_date"),
            "sl_end_date" => $this->input->post("sl_end_date"),
            "sl_contract_number" => $this->input->post("sl_contract_number")
        );
        $this->db->where("sl_seq",$this->input->post("sl_seq"));
        return $this->db->update("service_license",$data);
    }

    public function serviceLicenseDel(){
        $this->db->where("sl_seq",$this->input->get("sl_seq"));
        return $this->db->delete("service_license");
    }

    public function serviceModuleAdd(){
        $data = array(
            "sm_sv_seq" => $this->input->post("sv_seq"),
            "sm_name" => $this->input->post("sm_name"),
            "sm_cnt" => $this->input->post("sm_cnt"),
            "sm_div" => $this->input->post("sm_div"),
            "sm_date" => $this->input->post("sm_date")
        );

        return $this->db->insert("service_module",$data);
    }

    public function serviceModuleEdit(){
        $data = array(
            "sm_name" => $this->input->post("sm_name"),
            "sm_cnt" => $this->input->post("sm_cnt"),
            "sm_div" => $this->input->post("sm_div"),
            "sm_date" => $this->input->post("sm_date")
        );
        $this->db->where("sm_seq",$this->input->post("sm_seq"));
        return $this->db->update("service_module",$data);
    }

    public function serviceModuleDel(){
        $this->db->where("sm_seq",$this->input->get("sm_seq"));
        return $this->db->delete("service_module");
    }

    public function serviceInstallIpList(){
        $this->db->select("*");
        $this->db->from("service_install_ip");
        $this->db->where("sii_sv_seq",$this->input->get("sii_sv_seq"));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function serviceLicenseList(){
        $this->db->select("*");
        $this->db->from("service_license");
        $this->db->where("sl_sv_seq",$this->input->get("sv_seq"));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function serviceModuleList(){
        $this->db->select("*");
        $this->db->from("service_module");
        $this->db->where("sm_sv_seq",$this->input->get("sv_seq"));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function productItemSubDelete($pis_seq){
        $this->db->where("pis_seq",$pis_seq);
        return $this->db->delete("product_item_sub");
    }

    public function logInsert($lo_div,$lo_relation_seq,$lo_type,$lo_item,$lo_origin,$lo_after,$lo_user,$lo_charger_seq,$lo_ip){
        $data = array(
            "lo_div" => $lo_div,
            "lo_relation_seq" => $lo_relation_seq,
            "lo_type" => $lo_type,
            "lo_item" => $lo_item,
            "lo_origin" => $lo_origin,
            "lo_after" => $lo_after,
            "lo_user" => $lo_user,
            "lo_charger_seq" => $lo_charger_seq,
            "lo_ip" => $lo_ip,
            "lo_regdate" => date("Y-m-d H:i:s")
        );

        $this->db->insert("logs",$data);

    }

    public function fetchLogs($lo_div,$lo_relation_seq){
        $this->db->select("*");
        $this->db->from("logs a");
        $this->db->where("lo_relation_seq",$lo_relation_seq);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function groupServiceEdit(){
        $sv_seq = explode(",",$this->input->post("sg_sv_seq"));

        $data = array(
            "sv_auto_extension_month" => $this->input->post("sv_auto_extension_month"),
            "sv_auto_extension" => $this->input->post("sv_auto_extension")
        );

        $this->db->where_in("sv_seq",$sv_seq);

        return $this->db->update("service",$data);
    }

    public function serviceGroupMemoAdd(){
        $data = array(
            "sg_sv_code" => $this->input->post("sg_sv_code"),
            "sg_charger" => $this->input->post("sg_chager"),
            "sg_regdate" => date("Y-m-d H:i:s"),
            "sg_msg" => $this->input->post("sg_msg")
        );

        return $this->db->insert("service_group_memo",$data);
    }

    public function serviceGroupMemoModify(){
        $data = array(
            "sg_charger" => $this->input->post("sg_chager"),
            "sg_msg" => $this->input->post("sg_msg")
        );
        $this->db->where("sg_seq",$this->input->post("sg_seq"));
        return $this->db->update("service_group_memo",$data);
    }

    public function serviceGroupMemoDelete(){
        $this->db->where("sg_seq",$this->input->post("sg_seq"));
        return $this->db->delete("service_group_memo");
    }

    public function countServiceGroupMemo(){
        $this->db->select("count(*) as total");
        $this->db->from("service_group_memo");
        $this->db->where("sg_sv_code",$this->input->get("sg_sv_code"));

        $query = $this->db->get();

        $row = $query->row_array();

        return $row["total"];
    }

    public function serviceGroupMemoFetch(){
        $this->db->select("*");
        $this->db->from("service_group_memo");
        $this->db->where("sg_sv_code",$this->input->get("sg_sv_code"));

        $this->db->limit($this->input->get("end"),$this->input->get("start"));
        $query = $this->db->get();

        return $query->result_array();

        // return $row["total"];
    }

    public function insertEmailHistory(){
        $data = array(
            "eh_to"=>$this->input->post("to"),
            "eh_from" => $this->input->post("from"),
            "eh_phone"=>$this->input->post("phone"),
            "eh_subject" => $this->input->post("subject"),
            "eh_message" => $this->input->post("message"),
            "eh_regdate" => date("Y-m-d H:i:s")
        );

        $this->db->insert("email_history",$data);

        $eh_seq = $this->db->insert_id();
        $add_file = $this->input->post("add_file");
        for($i = 0; $i < count($add_file);$i++){
            $fileinfo = explode("|",$add_file[$i]);
            

            $data1["mf_eh_seq"] = $eh_seq;
            $data1["mf_session_id"] = "";

            $this->db->where("mf_seq",$fileinfo[0]);
            $this->db->update("email_files",$data1);
        }
        return true;
    }

    public function paymentListUpdate(){
        $pm_seq = $this->input->post("pm_seq");
        $pm_date = $this->input->post("pm_date");
        $pm_service_start = $this->input->post("pm_service_start");
        $pm_service_end = $this->input->post("pm_service_end");
        for($i = 0;$i < count($pm_seq);$i++){
            $data = array(
                "pm_date" => $pm_date[$i],
                "pm_service_start" => $pm_service_start[$i],
                "pm_service_end" => $pm_service_end[$i]
            );
            $this->db->where("pm_seq",$pm_seq[$i]);
            $this->db->update("payment",$data);
        }

        return true;
    }
}

?>