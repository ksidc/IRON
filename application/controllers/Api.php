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
        $this->load->library('PHPExcel');
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
    public function memberList($start,$end)
    {

        // $start = ($start-1)*$end;
        $total = $this->api_model->countMember();
        $list = $this->api_model->fetchMember($start,$end);
        $result = [
            "total" => $total,
            "list" => $list
        ];

        echo json_encode($result);
    }

    // 회원 리스트 paging no - get
    public function memberSearchList()
    {

        // $start = ($start-1)*$end;
        $list = $this->api_model->fetchSearchMember();

        echo json_encode($list);
    }

    // 회원 상세 - get
    public function memberView($mb_seq)
    {
        $info = $this->api_model->selectMember($mb_seq);
        echo json_encode($info);
    }

    // 회원 수정 - post
    public function memberUpdate($mb_seq)
    {
        $result = $this->api_model->memberUpdate($mb_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 회원 삭제 - get
    public function memberDelete()
    {
        $mb_seq = $this->input->get("mb_seq");
        $mb_seq_array = explode(",",$mb_seq);

        $result = $this->api_model->memberDelete($mb_seq_array);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    //회원 excel
    public function memberExport(){
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('회원');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '아이디');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '회원구분');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '상호명');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '사업자등록번호/생년월일');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '대표자');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '우편번호');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '주소');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '상세주소');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '전화번호');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '휴대폰번호');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '팩스');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '업태');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '종목');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', '계약 담당자명');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', '계약 이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', '계약 전화번호');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', '계약 휴대폰번호');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', '요금 담당자명');
        $objPHPExcel->getActiveSheet()->setCellValue('T1', '요금 이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('U1', '요금 전화번호');
        $objPHPExcel->getActiveSheet()->setCellValue('V1', '요금 휴대폰번호');
        $objPHPExcel->getActiveSheet()->setCellValue('W1', '회원 계좌 은행명');
        $objPHPExcel->getActiveSheet()->setCellValue('X1', '회원 계좌 번호');
        $objPHPExcel->getActiveSheet()->setCellValue('Y1', '회원 계좌 예금주');
        $objPHPExcel->getActiveSheet()->setCellValue('Z1', '회원 계좌 관계');
        $objPHPExcel->getActiveSheet()->setCellValue('AA1', '회원 계좌 사업자번호/생년월일');
        $objPHPExcel->getActiveSheet()->setCellValue('AB1', '청구 기준');
        $objPHPExcel->getActiveSheet()->setCellValue('AC1', '자동 청구일');
        $objPHPExcel->getActiveSheet()->setCellValue('AD1', '계산서 발행');
        $objPHPExcel->getActiveSheet()->setCellValue('AE1', '결제일');


        $member_list = $this->api_model->memberExport();

        for($i = 0;$i<count($member_list);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2), $member_list[$i]['mb_id']);

            if($member_list[$i]['mb_type'] == "0"){
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2), "사업자");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2), "개인");
            }
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2), $member_list[$i]['mb_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2), $member_list[$i]['mb_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2), $member_list[$i]['mb_ceo']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2), $member_list[$i]['mb_zipcode']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2), $member_list[$i]['mb_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2), $member_list[$i]['mb_detail_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($i+2), $member_list[$i]['mb_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($i+2), $member_list[$i]['mb_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($i+2), $member_list[$i]['mb_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($i+2), $member_list[$i]['mb_fax']);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.($i+2), $member_list[$i]['mb_business_conditions']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.($i+2), $member_list[$i]['mb_business_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.($i+2), $member_list[$i]['mb_contract_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.($i+2), $member_list[$i]['mb_contract_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.($i+2), $member_list[$i]['mb_contract_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.($i+2), $member_list[$i]['mb_contract_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('S'.($i+2), $member_list[$i]['mb_payment_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('T'.($i+2), $member_list[$i]['mb_payment_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('U'.($i+2), $member_list[$i]['mb_payment_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('V'.($i+2), $member_list[$i]['mb_payment_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.($i+2), $member_list[$i]['mb_bank']);
            $objPHPExcel->getActiveSheet()->setCellValue('X'.($i+2), $member_list[$i]['mb_bank_input_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.($i+2), $member_list[$i]['mb_bank_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.($i+2), $member_list[$i]['mb_bank_name_relationship']);
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.($i+2), $member_list[$i]['mb_bank_number']);
            if($member_list[$i]['mb_payment_type'] == "0"){
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.($i+2), "전월");
            }else if($member_list[$i]['mb_payment_type'] == "1"){
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.($i+2), "당월");
            }else if($member_list[$i]['mb_payment_type'] == "2"){
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.($i+2), "익월");
            }
            if($member_list[$i]['mb_auto_payment'] == "32"){
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.($i+2), "말일");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.($i+2), $member_list[$i]['mb_auto_payment']."일");
            }

            if($member_list[$i]['mb_payment_publish'] == "0"){
                $mb_payment_publish = "발행";
            }else if($member_list[$i]['mb_payment_publish'] == "1"){
                $mb_payment_publish = "미발행";
            }

            if($member_list[$i]['mb_payment_publish_type'] == "0"){
                $mb_payment_publish_type = "영수 발행";
            }else if($member_list[$i]['mb_payment_publish_type'] == "1"){
                $mb_payment_publish_type = "청구 발행";
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AD'.($i+2), $mb_payment_publish.$mb_payment_publish_type);
            $objPHPExcel->getActiveSheet()->setCellValue('AE'.($i+2), $member_list[$i]['mb_payment_day']."일");
        }

        $filename='회원_'.date('Y_m_d').'.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.iconv("UTF-8","EUC-KR//IGNORE",$filename).'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
    }

    // 견적 입력 - post
    public function estimateAdd()
    {
        $result = $this->api_model->estimateAdd();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 견적 리스트 - get
    public function estimateList($start,$end)
    {

        // $start = ($start-1)*$end;
        $total = $this->api_model->countEstimate();
        $list = $this->api_model->fetchEstimate($start,$end);
        $result = [
            "total" => $total,
            "list" => $list
        ];

        echo json_encode($result);
    }

    // 견적 상세 - get
    public function estimateView($es_seq)
    {
        $info = $this->api_model->selectEstimate($es_seq);
        $files = $this->api_model->fetchEstimateFiles($es_seq);
        $basicfiles = $this->api_model->fetchEstimateBasicFile();
        $addfiles = $this->api_model->estimateEmailFileList($es_seq);
        $result = array(
            "info" => $info,
            "files" => $files,
            "basicfiles" => $basicfiles,
            "addfiles" => $addfiles
        );
        echo json_encode($result);
    }

    // 견적 수정 - post
    public function estimateUpdate($es_seq)
    {
        $result = $this->api_model->estimateUpdate($es_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 견적 삭제 - get
    public function estimateDelete()
    {
        $es_seq = $this->input->get("es_seq");
        $es_seq_array = explode(",",$es_seq);

        $result = $this->api_model->estimateDelete($es_seq_array);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 견적 상태 변경 - post
    public function estimateStatus($es_seq){
        $result = $this->api_model->estimateStatus($es_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 견적 복사 - post
    public function estimateCopy(){
        $result = $this->api_model->estimateCopy();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 재견적 복사 - post
    public function estimateReCopy(){
        $result = $this->api_model->estimateReCopy();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 신청성공등록 - post
    public function estimateSuccess(){
        $result = $this->api_model->estimateSuccess();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    //견적 excel
    public function estimateExport(){
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('견적');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '견적번호');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '부서');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '등록자');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '상태');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '상호/이름');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '담당자');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '전화번호');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '휴대폰번호');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '팩스');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '신규/기존');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '업체 분류');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '견적요약');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'END User');



        $estimate_list = $this->api_model->estimateExport();

        for($i = 0;$i<count($estimate_list);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2), $estimate_list[$i]['es_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2), $estimate_list[$i]['es_part']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2), $estimate_list[$i]['es_register']);
            if($estimate_list[$i]['es_status'] == "0"){
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2), "등록");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2), "신청완료");
            }

            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2), $estimate_list[$i]['es_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2), $estimate_list[$i]['es_charger']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2), $estimate_list[$i]['es_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2), $estimate_list[$i]['es_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($i+2), $estimate_list[$i]['es_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($i+2), $estimate_list[$i]['es_fax']);
            if($estimate_list[$i]['es_type'] == "0"){
                $objPHPExcel->getActiveSheet()->setCellValue('K'.($i+2), "신규");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('K'.($i+2), "기존");
            }

            $objPHPExcel->getActiveSheet()->setCellValue('L'.($i+2), $estimate_list[$i]['es_company_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.($i+2), $estimate_list[$i]['es_shot']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.($i+2), $estimate_list[$i]['es_end_user']);
        }

        $filename='견적_'.date('Y_m_d').'.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.iconv("UTF-8","EUC-KR//IGNORE",$filename).'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
    }

    public function estimateNextCode(){
        $last_code = explode("-",$this->api_model->estimateNextCode());

        $code_first = substr($last_code[0],0,1);
        $code_number = substr($last_code[0],1,4);

        $next_number = str_pad(++$code_number,4,"0",STR_PAD_LEFT);
        if($next_number == "0000"){
            $next_first = ++$code_first;
        }else{
            $next_first = $code_first;
        }
        $result = $next_first.$next_number."-".$last_code[1];
        echo json_encode($result);
    }

    // 기본 첨부파일 입력 & 수정 - post
    public function estimateBasicFileAdd()
    {
        $result = $this->api_model->estimateBasicFileAdd();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 기본 첨부파일 리스트 - get
    public function estimateBasicFileList()
    {

        // $start = ($start-1)*$end;
        // $total = $this->api_model->countEstimate();
        $list = $this->api_model->fetchEstimateBasicFile();
        $result = [
            "list" => $list
        ];

        echo json_encode($result);
    }

    // 기본 첨부파일 삭제 - get
    public function estimateBasicFileDelete($bf_seq)
    {
        $result = $this->api_model->estimateBasicFileDelete($bf_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 업체 분류 파일 입력 - post
    public function companyTypeAdd()
    {

        $result = $this->api_model->companyTypeAdd();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 업체 분류 리스트 - get
    public function companyTypeList()
    {

        // $start = ($start-1)*$end;
        // $total = $this->api_model->countEstimate();
        $nextCode = $this->api_model->selectNextCompanyCode();
        $list = $this->api_model->fetchCompanyType();
        $result = [
            "nextCode" => $nextCode,
            "list" => $list
        ];

        echo json_encode($result);
    }

    // 업체 분류 수정 - post
    public function companyTypeUpdate($ct_seq)
    {
        $result = $this->api_model->companyTypeUpdate($ct_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 업체 분류 삭제 - get
    public function companyTypeDelete($ct_seq){
        $result = $this->api_model->companyTypeDelete($ct_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // End user 입력 - post
    public function endUserAdd()
    {
        $result = $this->api_model->endUserAdd();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // End user 리스트 - get
    public function endUserList()
    {

        $list = $this->api_model->fetchEndUser();
        $result = [
            "list" => $list
        ];

        echo json_encode($result);
    }

    // End user Next Code - get
    public function endUserNextCode()
    {
        $last_code = $this->api_model->endUserNextCode();

        $code_first = substr($last_code,0,1);
        $code_number = substr($last_code,1,4);

        $next_number = str_pad(++$code_number,4,"0",STR_PAD_LEFT);
        if($next_number == "0000"){
            $next_first = ++$code_first;
        }else{
            $next_first = $code_first;
        }
        $result = $next_first.$next_number;
        echo json_encode($result);
    }

    // End user 수정 - post
    public function endUserUpdate($eu_seq)
    {
        $result = $this->api_model->endUserUpdate($eu_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // End user 삭제 - get
    public function endUserDelete($eu_seq){
        $result = $this->api_model->endUserDelete($eu_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    public function sendEmail(){
        // 견적서 파일
        $ef_file = $this->input->post("ef_file_seq");

        //기본 첨부파일
        $basic_file = $this->input->post("file");

        //추가 파일
        $add_file = $this->input->post("add_file");

        $this->load->library('email');


        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from($this->input->post("from"), 'Eyeon');
        $this->email->to($this->input->post("to"));
        // $this->email->cc('another@another-example.com');
        // $this->email->bcc('them@their-example.com');

        for($i = 0; $i < count($ef_file);$i++){
            $fileinfo = explode("|",$ef_file[$i]);
            $this->email->attach($_SERVER["DOCUMENT_ROOT"]."/uploads/estimate_file/".$fileinfo[2], 'attachment', $fileinfo[1]);
        }

        for($i = 0; $i < count($basic_file);$i++){
            $fileinfo = explode("|",$basic_file[$i]);
            $this->email->attach($_SERVER["DOCUMENT_ROOT"]."/uploads/basic_file/".$fileinfo[2], 'attachment', $fileinfo[1]);
        }

        for($i = 0; $i < count($add_file);$i++){
            $fileinfo = explode("|",$add_file[$i]);
            $this->email->attach($_SERVER["DOCUMENT_ROOT"]."/uploads/estimate_email_file/".$fileinfo[2], 'attachment', $fileinfo[1]);
        }

        $this->email->subject($this->input->post("subject"));
        $this->email->message($this->input->post("content"));

        $this->email->send();

        $result = true;
        $arr = array('result'=>$result);
        echo json_encode($arr);

    }

    public function estimateFilesTmp(){
        $result = $this->api_model->estimateFilesTmp();
        $list = $this->api_model->estimateFilesTmpList();
        $arr = array('result'=>$result,"list"=>$list);
        echo json_encode($arr);
    }

    public function estimateFilesTmpDelete($ef_seq){
        $result = $this->api_model->estimateFilesTmpDelete($ef_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    public function estimateEmailFile(){
        $result = $this->api_model->estimateEmailFile();
        $list = $this->api_model->estimateEmailFileList($this->input->post("em_es_seq"));
        $arr = array('result'=>$result,"list"=>$list);
        echo json_encode($arr);
    }

    // 추가 첨부파일 삭제 - get
    public function estimateEmailFileDelete()
    {
        $result = $this->api_model->estimateEmailFileDelete();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    public function estimateFilesDelete($ef_seq){
        $result = $this->api_model->estimateFilesDelete($ef_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 탭리스트
    public function productCategoryList(){
        $result = $this->api_model->productCategoryList();
        echo json_encode($result);
    }

    // 상품 등록 - 탭 등록
    public function productCategoryRegister(){
        $sort = $this->api_model->productCategoryMaxSort();

        $result = $this->api_model->productCategoryRegister($sort["max_sort"]+1);
        echo json_encode($result);
    }

    // 상품 등록 - 탭 업데이트
    public function productCategoryUpdate($pc_seq){
        $result = $this->api_model->productCategoryUpdate($pc_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 탭 삭제
    public function productCategoryDelete($pc_seq){
        $result = $this->api_model->productCategoryDelete($pc_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 탭 순서변
    public function productCategorySort(){
        $result = $this->api_model->productCategorySort();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 분류 리스트
    public function productDivList($pc_seq){
        $result = $this->api_model->productDivList($pc_seq);
        echo json_encode($result);
    }

    // 상품 등록 - 분류 등록
    public function productDivRegister($pc_seq){
        $sort = $this->api_model->productDivMaxSort($pc_seq);

        $result = $this->api_model->productDivRegister($pc_seq,$sort["max_sort"]+1);
        $arr = array("result"=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 분류 업데이트
    public function productDivUpdate($pd_seq){
        $result = $this->api_model->productDivUpdate($pd_seq);
        $arr = array("result"=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 분류 삭제
    public function productDivDelete($pd_seq){
        $result = $this->api_model->productDivDelete($pd_seq);
        $arr = array("result"=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 분류 서브 리스트
    public function productDivSubList($pd_seq){
        $result = $this->api_model->productDivSubList($pd_seq);
        echo json_encode($result);
    }

    // 상품 등록 - 분류 서브 등록
    public function productDivSubRegister(){
        $pd_seq = $this->input->post("add_ps_pd_seq");
        if($pd_seq == ""){
            $pd_seq = [];
        }
        $ps_name = $this->input->post("add_ps_name");
        $parent_pd_seq = $this->input->post("pd_seq");
        for($i = 0; $i < count($pd_seq);$i++){
            // $sort = $this->api_model->productDivSubMaxSort($pd_seq[$i]);

            $this->api_model->productDivSubRegister($pd_seq[$i],$ps_name[$i]);
        }

        $this->api_model->productDivSort($parent_pd_seq);

        $result = array("result"=>true);
        echo json_encode($result);
    }

    // 상품 등록 - 분류 서브 업데이트
    public function productDivSubUpdate($ps_seq){
        $result = $this->api_model->productDivSubUpdate($ps_seq);
        $arr = array("result"=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 분류 서브 삭제
    public function productDivSubDelete($ps_seq){
        $result = $this->api_model->productDivSubDelete($ps_seq);
        $arr = array("result"=>$result);
        echo json_encode($arr);
    }

    public function productItemList($pc_seq,$start,$end)
    {

        // $start = ($start-1)*$end;
        $total = $this->api_model->countProductItem($pc_seq);
        $list = $this->api_model->fetchProductItem($pc_seq,$start,$end);
        $html = "";
        foreach($list as $key => $row){
            $sub = $this->api_model->fetchProductItemSub($row["pi_seq"]);
            $subItemHtml = "";
            $subItemClientHtml = "";
            foreach($sub as $row2){
                $subItemHtml .= '<div class="subItem_'.$row["pi_seq"].'" data-name="'.$row2["pis_name"].'" data-pisseq="'.$row2["pis_seq"].'">'.$row2["pis_name"].'</div>';
                $subItemClientHtml .= '<div class="subItem_'.$row["pi_seq"].'" data-name="'.$row2["c_name"].'" data-pisseq="'.$row2["pis_seq"].'">'.$row2["c_name"].'</div>';
            }

            $html .= '<tr>
                        <td>'.($key+1).'</td>
                        <td class="item_'.$row["pi_seq"].'" data-name="'.$row["pi_name"].'" data-piseq="'.$row["pi_seq"].'">'.$row["pi_name"].'</td>
                        <td style="line-height:28px">'.$subItemHtml.'</td>
                        <td style="line-height:28px">'.$subItemClientHtml.'</td>
                        <td><i class="fas fa-plus addSubItem" data-piseq="'.$row["pi_seq"].'"></i></td>
                        <td class="btn-modify" data-seq="'.$row["pi_seq"].'" style="cursor:pointer"><i class="fas fa-edit"></i></td>
                        <td class="btn-delete" data-seq="'.$row["pi_seq"].'" style="cursor:pointer"><i class="fas fa-trash"></i></td>
                    </tr>';
        }
        $result = [
            "total" => $total,
            "list" => $html
        ];

        echo json_encode($result);
    }

    public function productItemSearch($pc_seq)
    {

        // $start = ($start-1)*$end;

        $result = $this->api_model->fetchProductSearch($pc_seq);
        echo json_encode($result);
    }

    // 상품 등록 - 제품군 등록
    public function productItemRegister($pc_seq){
        $sort = $this->api_model->productItemMaxSort($pc_seq);

        $result = $this->api_model->productItemRegister($pc_seq,$sort["max_sort"]+1);
        $arr = array("result"=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 제품군 업데이트
    public function productItemUpdate(){
        $result = $this->api_model->productItemUpdate($_POST);
        $arr = array("result"=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 제품군 삭제
    public function productItemDelete($pi_seq){
        $result = $this->api_model->productItemDelete($pi_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 상품 등록 - 제품 서브 등록
    public function productItemSubRegister(){
        $pi_seq = $this->input->post("add_pis_pi_seq");
        $pis_name = $this->input->post("add_pis_name");
        $pis_c_seq = $this->input->post("add_pis_c_seq");
        for($i = 0; $i < count($pis_name);$i++){

            $this->api_model->productItemSubRegister($pi_seq[$i],$pis_name[$i],$pis_c_seq[$i]);
        }
        $result = array("result"=>true);
        echo json_encode($result);
    }

    public function productItemSubList($pi_seq){
        $result = $this->api_model->productItemSubList($pi_seq);
        echo json_encode($result);
    }

    // 매입처 아이디 중복체크 - get
    public function clientIdCheck()
    {
        $result = $this->api_model->clientIdCheck();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 매입처 사업자 중복체크 - get
    public function clientNumberCheck()
    {
        $result = $this->api_model->clientNumberCheck();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 매입처 입력 - post
    public function clientAdd()
    {
        $result = $this->api_model->clientAdd();
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 매입처 리스트 - get
    public function clientList($start,$end)
    {

        // $start = ($start-1)*$end;
        $total = $this->api_model->countClient();
        $list = $this->api_model->fetchClient($start,$end);
        $result = [
            "total" => $total,
            "list" => $list
        ];

        echo json_encode($result);
    }

    // 매입처 리스트 paging no - get
    public function clientSearchList()
    {

        // $start = ($start-1)*$end;
        $list = $this->api_model->fetchSearchClient();

        echo json_encode($list);
    }

    // 매입처 상세 - get
    public function clientView($c_seq)
    {
        $info = $this->api_model->selectClient($c_seq);
        echo json_encode($info);
    }

    // 매입처 수정 - post
    public function clientUpdate($c_seq)
    {
        $result = $this->api_model->clientUpdate($c_seq);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 매입처 삭제 - get
    public function clientDelete()
    {
        $c_seq = $this->input->get("c_seq");
        $c_seq_array = explode(",",$c_seq);

        $result = $this->api_model->clientDelete($c_seq_array);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    //매입처 excel
    public function clientExport(){
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('매입처');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '아이디');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '상호명');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '대표품목');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '사업자등록번호');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '대표자');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '우편번호');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '주소');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '상세주소');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '팩스');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '업태');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '종목');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '기본 담당자명');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '기본 이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', '기본 전화번호');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', '기본 휴대폰번호');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', '요금 담당자명');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', '요금 이메일');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', '요금 전화번호');
        $objPHPExcel->getActiveSheet()->setCellValue('T1', '요금 휴대폰번호');
        $objPHPExcel->getActiveSheet()->setCellValue('U1', '매입처 계좌 은행명');
        $objPHPExcel->getActiveSheet()->setCellValue('V1', '매입처 계좌 번호');
        $objPHPExcel->getActiveSheet()->setCellValue('W1', '매입처 계좌 예금주');
        $objPHPExcel->getActiveSheet()->setCellValue('X1', '매입처 계좌 관계');
        $objPHPExcel->getActiveSheet()->setCellValue('Y1', '매입처 계좌 사업자번호/생년월일');
        $objPHPExcel->getActiveSheet()->setCellValue('Z1', '지급 기준');


        $client_list = $this->api_model->clientExport();

        for($i = 0;$i<count($client_list);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2), $client_list[$i]['c_id']);

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2), $client_list[$i]['c_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2), $client_list[$i]['c_item']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2), $client_list[$i]['c_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2), $client_list[$i]['c_ceo']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2), $client_list[$i]['c_zipcode']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2), $client_list[$i]['c_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2), $client_list[$i]['c_detail_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($i+2), $client_list[$i]['c_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($i+2), $client_list[$i]['c_fax']);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($i+2), $client_list[$i]['c_business_conditions']);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($i+2), $client_list[$i]['c_business_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.($i+2), $client_list[$i]['c_contract_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.($i+2), $client_list[$i]['c_contract_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.($i+2), $client_list[$i]['c_contract_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.($i+2), $client_list[$i]['c_contract_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.($i+2), $client_list[$i]['c_payment_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.($i+2), $client_list[$i]['c_payment_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('S'.($i+2), $client_list[$i]['c_payment_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('T'.($i+2), $client_list[$i]['c_payment_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('U'.($i+2), $client_list[$i]['c_bank']);
            $objPHPExcel->getActiveSheet()->setCellValue('V'.($i+2), $client_list[$i]['c_bank_input_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.($i+2), $client_list[$i]['c_bank_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('X'.($i+2), $client_list[$i]['c_bank_name_relationship']);
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.($i+2), $client_list[$i]['c_bank_number']);
            if($client_list[$i]['c_payment_type'] == "1"){
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.($i+2), "당월");
            }else if($client_list[$i]['c_payment_type'] == "2"){
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.($i+2), "익월");
            }else if($client_list[$i]['c_payment_type'] == "3"){
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.($i+2), "익익월");
            }else if($client_list[$i]['c_payment_type'] == "4"){
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.($i+2), "기타");
            }

        }

        $filename='매입처_'.date('Y_m_d').'.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.iconv("UTF-8","EUC-KR//IGNORE",$filename).'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
    }

    public function clientFileDelete($c_seq,$type){
        $result = $this->api_model->clientFileDelete($c_seq,$type);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 상품 입력 - post
    public function productAdd()
    {
        $pr_seq = $this->api_model->productAdd();

        $prs_pd_seq = $this->input->post("prs_pd_seq");
        $prs_ps_seq = $this->input->post("prs_ps_seq");
        $prs_price = $this->input->post("prs_price");
        $prs_div = $this->input->post("prs_div");
        $prs_one_price = $this->input->post("prs_one_price");
        $prs_month_price = $this->input->post("prs_month_price");
        $prs_use_type = $this->input->post("prs_use_type");
        $prs_msg = $this->input->post("prs_msg");
        for($i = 0 ; $i < count($prs_pd_seq);$i++){
            $result = $this->api_model->productSubAdd($pr_seq,$prs_pd_seq[$i],$prs_ps_seq[$i],$prs_price[$i],$prs_div[$i],$prs_one_price[$i],$prs_month_price[$i],$prs_use_type[$i],$prs_msg[$i]);
        }
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 상품 리스트 - get
    public function productList($pc_seq,$start,$end)
    {

        // $start = ($start-1)*$end;
        $total = $this->api_model->countProduct($pc_seq);
        $list = $this->api_model->fetchProduct($pc_seq,$start,$end);
        $i = 0;
        $html = "";

        foreach($list as $row){
            $num = $total - (($start-1)*$end) - $i;
            $sub = $this->api_model->fetchProductSub($row["pr_seq"]);
            $b_pr_seq = "";
            $html .= '<tr>
                        <td><input type="checkbox" class="listCheck" name="pr_seq[]" value="'.$row["pr_seq"].'"></td>
                        <td>'.$num.'</td>
                        <td>'.$row["pr_code"].'</td>
                        <td>'.$row["pi_name"].'</td>
                        <td>'.$row["pr_name"].'</td>
                        <td colspan="6">
                            <table class="table">';
                        foreach($sub as $row2){
                            $html .= '<tr style="border-bottom:0px;height:28px">
                                    <td style="width:16%">'.$row2["pd_name"].'</td>
                                    <td style="width:16%">'.$row2["ps_name"].'</td>';
                                    if($b_pr_seq != $row["pr_seq"]){
                                        $html .= '<td rowspan="'.(count($sub)).'" style="width:16%">'.$row["c_name"].'</td>';
                                    }
                                    $html .= '<td style="width:16%">'.number_format($row2["prs_price"]).'원</td>
                                    <td style="width:16%">'.number_format($row2["prs_one_price"]).'원</td>
                                    <td style="width:16%">'.number_format($row2["prs_month_price"]).'원</td>
                                </tr>';
                            $b_pr_seq = $row["pr_seq"];
                        }
                        $html .= '</table>
                        </td>
                        <td class="btn-modify" data-seq="'.$row["pr_seq"].'" style="cursor:pointer"><i class="fas fa-edit"></i></td>
                        <td class="btn-delete" data-seq="'.$row["pr_seq"].'" style="cursor:pointer"><i class="fas fa-trash"></i></td>
                    </tr>';
            $i++;
        }
        $result = [
            "total" => $total,
            "list" => $html
        ];

        echo json_encode($result);
    }

    // 상품 상세 - get
    public function productView($pr_seq)
    {
        $info = $this->api_model->selectProduct($pr_seq);
        echo json_encode($info);
    }

    // 상품 수정 - post
    public function productUpdate($pr_seq)
    {
        $this->api_model->productUpdate($pr_seq);

        $prs_pd_seq = $this->input->post("prs_pd_seq");
        $prs_ps_seq = $this->input->post("prs_ps_seq");
        $prs_price = $this->input->post("prs_price");
        $prs_div = $this->input->post("prs_div");
        $prs_one_price = $this->input->post("prs_one_price");
        $prs_month_price = $this->input->post("prs_month_price");
        $prs_use_type = $this->input->post("prs_use_type");
        $prs_msg = $this->input->post("prs_msg");
        $prs_seq = $this->input->post("prs_seq");
        for($i = 0 ; $i < count($prs_seq);$i++){
            if($prs_seq[$i] == ""){
                $result = $this->api_model->productSubAdd($pr_seq,$prs_pd_seq[$i],$prs_ps_seq[$i],$prs_price[$i],$prs_div[$i],$prs_one_price[$i],$prs_month_price[$i],$prs_use_type[$i],$prs_msg[$i]);
            }else{
                $result = $this->api_model->productSubUpdate($prs_seq[$i],$prs_pd_seq[$i],$prs_ps_seq[$i],$prs_price[$i],$prs_div[$i],$prs_one_price[$i],$prs_month_price[$i],$prs_use_type[$i],$prs_msg[$i]);
            }
        }
        // $result = $this->api_model->productSubUpdate($prs_seq,$prs_pd_seq,$prs_ps_seq,$prs_price,$prs_div,$prs_one_price,$prs_month_price,$prs_use_type,$prs_msg);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    // 상품 삭제 - get
    public function productDelete()
    {
        $pr_seq = $this->input->get("pr_seq");
        $pr_seq_array = explode(",",$pr_seq);

        $result = $this->api_model->productDelete($pr_seq_array);
        $arr = array('result'=>$result);
        echo json_encode($arr);
    }

    public function fileDownload($folder)
    {
        $this->load->helper('download');
        $path = $_SERVER["DOCUMENT_ROOT"]."/uploads/".$folder;
        $file = $path."/".$this->input->get("filename");
        $data = file_get_contents($file);

        $file_name = $this->input->get("originname");
        force_download($file_name,$data);
    }

    public function productCopy(){
        $pr_seq_array = $this->input->post("pr_seq");
        for($i = 0; $i < count($pr_seq_array);$i++){
            $product = $this->api_model->selectProduct($pr_seq_array[$i]);
            $max_code = $this->api_model->selectMaxCodeProduct($product["pr_pc_seq"]);

            $pr_code = substr($max_code["pr_code"],-4);
            $code = substr($max_code["pr_code"],0,-4);
            $new_prcode = (int)$pr_code+1;
            $product["pr_code"] = $code.sprintf("%04d",$new_prcode);
            $new_pr_seq = $this->api_model->productCopy($product);
            $product_sub = $this->api_model->fetchProductSub($pr_seq_array[$i]);
            foreach($product_sub as $row){
                $data = array(
                    "prs_pr_seq" => $new_pr_seq,
                    "prs_pd_seq" => $row["prs_pd_seq"],
                    "prs_ps_seq" => $row["prs_ps_seq"],
                    "prs_price" => $row["prs_price"],
                    "prs_div" => $row["prs_div"],
                    "prs_one_price" => $row["prs_one_price"],
                    "prs_month_price" => $row["prs_month_price"],
                    "prs_use_type" => $row["prs_use_type"],
                    "prs_msg" => $row["prs_msg"]
                );
                $this->api_model->productSubCopy($data);
            }
        }
        $arr = array('result'=>true);
        echo json_encode($arr);
    }

    //상품 excel
    public function productExport(){
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('상품');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '상품코드');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '제품군');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '상품명');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '대분류');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '소분류');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '기본매입처');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '기본매입가');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '일회성요금');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '월요금');


        $product_list = $this->api_model->productExport();

        for($i = 0;$i<count($product_list);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2), $product_list[$i]['pr_code']);

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2), $product_list[$i]['pi_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2), $product_list[$i]['pr_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2), $product_list[$i]['pd_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2), $product_list[$i]['ps_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2), $product_list[$i]['c_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2), $product_list[$i]['prs_price']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2), $product_list[$i]['prs_one_price']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($i+2), $product_list[$i]['prs_month_price']);

        }

        $filename='상품_'.date('Y_m_d').'.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.iconv("UTF-8","EUC-KR//IGNORE",$filename).'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
    }
}
