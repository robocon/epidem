<?php 
include 'config.php';
$dbi = new mysqli(HOST,USER,PASS,DB);
if($dbi->connect_errno){
    echo $dbi->connect_errno;
}
$dbi->query("SET NAMES UTF8");

$idcard = $_POST['idcard'];
$main = $_POST[$idcard];

// single: yes
$epidem_id = $main['epidem_id'];
$opsi_id = $main['opsi_id'];
$cid = $main['cid'];
$hn = $main['hn'];
$passport_no = $main['passport_no'];
$prefix = $main['prefix'];
$first_name = $main['first_name'];
$last_name = $main['last_name'];
$nationality = $main['nationality'];
$gender = $main['gender'];
$birth_date = $main['birth_date'];
$age_y = $main['age_y'];
$age_m = $main['age_m'];
$age_d = $main['age_d'];
$marital_status_id = $main['marital_status_id'];
$address = $main['address'];
// $moo = $main['moo'];
// $road = $main['road'];
$moo = '';
$road = '';
$chw_code = $main['chw_code'];
$amp_code = $main['amp_code'];
$tmb_code = $main['tmb_code'];
$mobile_phone = $main['mobile_phone'];
// $occupation = $main['occupation'];
$occupation = '';

$epidem_report_guid = $main['epidem_report_guid'];
$epidem_report_group_id = $main['epidem_report_group_id'];
$treated_hospital_code = $main['treated_hospital_code'];
$report_datetime = $main['report_datetime'];
$onset_date = $main['onset_date'];
$treated_date = $main['treated_date'];
$diagnosis_date = $main['diagnosis_date'];
$informer_name = $main['informer_name'];
$principal_diagnosis_icd10 = $main['principal_diagnosis_icd10'];
$diagnosis_icd10_list = $main['diagnosis_icd10_list'];
$epidem_person_status_id = $main['epidem_person_status_id'];
$epidem_symptom_type_id = $main['epidem_symptom_type_id'];
$pregnant_status = $main['pregnant_status'];
$respirator_status = $main['respirator_status'];
// $epidem_accommodation_type_id = $main['epidem_accommodation_type_id'];
$epidem_accommodation_type_id = '';
$vaccinated_status = $main['vaccinated_status'];
$exposure_epidemic_area_status = $main['exposure_epidemic_area_status'];
$exposure_healthcare_worker_status = $main['exposure_healthcare_worker_status'];
$exposure_closed_contact_status = $main['exposure_closed_contact_status'];
$exposure_occupation_status = $main['exposure_occupation_status'];
$exposure_travel_status = $main['exposure_travel_status'];
$risk_history_type_id = $main['risk_history_type_id'];
// $epidem_address = $main['epidem_address'];
// $epidem_moo = $main['epidem_moo'];
// $epidem_road = $main['epidem_road'];
$epidem_address = '';
$epidem_moo = '';
$epidem_road = '';
$epidem_chw_code = $main['epidem_chw_code'];
$epidem_amp_code = $main['epidem_amp_code'];
$epidem_tmb_code = $main['epidem_tmb_code'];
// $location_gis_latitude = $main['location_gis_latitude'];
// $location_gis_longitude = $main['location_gis_longitude'];
$location_gis_latitude = 0;
$location_gis_longitude = 0;
$isolate_chw_code = $main['isolate_chw_code'];
$isolate_place_id = $main['isolate_place_id'];
$patient_type = $main['patient_type'];
// $epidem_covid_cluster_type_id = $main['epidem_covid_cluster_type_id'];
// $cluster_latitude = $main['cluster_latitude'];
// $cluster_longitude = $main['cluster_longitude'];
$epidem_covid_cluster_type_id = 0;
$cluster_latitude = 0;
$cluster_longitude = 0;

$epidem_lab_confirm_type_id = $main['epidem_lab_confirm_type_id'];
// $lab_report_date = $main['lab_report_date'];
// $lab_report_result = $main['lab_report_result'];
// $specimen_date = $main['specimen_date'];
// $specimen_place_id = $main['specimen_place_id'];
$lab_report_date = '';
$lab_report_result = '';
$specimen_date = '';
$specimen_place_id = 0;

$tests_reason_type_id = $main['tests_reason_type_id'];
// $lab_his_ref_code = $main['lab_his_ref_code'];
// $lab_his_ref_name = $main['lab_his_ref_name'];
// $tmlt_code = $main['tmlt_code'];
$lab_his_ref_code = '';
$lab_his_ref_name = '';
$tmlt_code = '';
$date_add = $main['date_add'];
$date_update = $main['date_update'];
$officer = $main['officer'];
$send_data = $main['send_data'];


// $sm3_prefix = iconv('UTF-8', 'TIS-620', $prefix);
// $sm3_first_name = iconv('UTF-8', 'TIS-620', $first_name);
// $sm3_last_name = iconv('UTF-8', 'TIS-620', $last_name);
// $sm3_address = iconv('UTF-8', 'TIS-620', $address);
// $sm3_informer_name = iconv('UTF-8', 'TIS-620', $informer_name);
$sm3_prefix = $prefix;
$sm3_first_name = $first_name;
$sm3_last_name = $last_name;
$sm3_address = $address;
$sm3_informer_name = $informer_name;

$send_back_apidem_id = 0;
if(empty($epidem_id)){
    $sql = "INSERT INTO `epidem` ( 
        `id`, `opsi_id`, `cid`, `hn`, `passport_no`, `prefix`, 
        `first_name`, `last_name`, `nationality`, `gender`, `birth_date`, `age_y`, 
        `age_m`, `age_d`, `marital_status_id`, `address`, `moo`, `road`, 
        `chw_code`, `amp_code`, `tmb_code`, `mobile_phone`, `occupation`, `epidem_report_guid`, 
        `epidem_report_group_id`, `treated_hospital_code`, `report_datetime`, `onset_date`, `treated_date`, `diagnosis_date`, 
        `informer_name`, `principal_diagnosis_icd10`, `diagnosis_icd10_list`, `epidem_person_status_id`, `epidem_symptom_type_id`, `pregnant_status`, 
        `respirator_status`, `epidem_accommodation_type_id`, `vaccinated_status`, `exposure_epidemic_area_status`, `exposure_healthcare_worker_status`, `exposure_closed_contact_status`, 
        `exposure_occupation_status`, `exposure_travel_status`, `risk_history_type_id`, `epidem_address`, `epidem_moo`, `epidem_road`, 
        `epidem_chw_code`, `epidem_amp_code`, `epidem_tmb_code`, `location_gis_latitude`, `location_gis_longitude`, `isolate_chw_code`, 
        `isolate_place_id`, `patient_type`, `epidem_covid_cluster_type_id`, `cluster_latitude`, `cluster_longitude`, `epidem_lab_confirm_type_id`, 
        `lab_report_date`, `lab_report_result`, `specimen_date`, `specimen_place_id`, `tests_reason_type_id`, `lab_his_ref_code`, 
        `lab_his_ref_name`, `tmlt_code`, `date_add`, `date_update`, `officer`, `send_data` 
    ) VALUES (
        NULL, '$opsi_id', '$cid', '$hn', '$passport_no', '$sm3_prefix', 
        '$sm3_first_name', '$sm3_last_name', '$nationality', '$gender', '$birth_date', '$age_y', 
        '$age_m', '$age_d', '$marital_status_id', '$sm3_address', '$moo', '$road', 
        '$chw_code', '$amp_code', '$tmb_code', '$mobile_phone', '$occupation', '$epidem_report_guid', 
        '$epidem_report_group_id', '$treated_hospital_code', '$report_datetime', '$onset_date', '$treated_date', '$diagnosis_date', 
        '$sm3_informer_name', '$principal_diagnosis_icd10', '$diagnosis_icd10_list', '$epidem_person_status_id', '$epidem_symptom_type_id', '$pregnant_status', 
        '$respirator_status', '$epidem_accommodation_type_id', '$vaccinated_status', '$exposure_epidemic_area_status', '$exposure_healthcare_worker_status', '$exposure_closed_contact_status', 
        '$exposure_occupation_status', '$exposure_travel_status', '$risk_history_type_id', '$epidem_address', '$epidem_moo', '$epidem_road', 
        '$epidem_chw_code', '$epidem_amp_code', '$epidem_tmb_code', '$location_gis_latitude', '$location_gis_longitude', '$isolate_chw_code', 
        '$isolate_place_id', '$patient_type', '$epidem_covid_cluster_type_id', '$cluster_latitude', '$cluster_longitude', '$epidem_lab_confirm_type_id', 
        '$lab_report_date', '$lab_report_result', '$specimen_date', '$specimen_place_id', '$tests_reason_type_id', '$lab_his_ref_code', 
        '$lab_his_ref_name', '$tmlt_code', '$date_add', '$date_update', '$officer', '$send_data'
    );";
    $q = $dbi->query($sql);
    $send_back_apidem_id = $dbi->insert_id;
}else{
    $sql = "UPDATE `epidem` SET `opsi_id`='$opsi_id', `cid`='$cid', `hn`='$hn', `passport_no`='$passport_no', `prefix`='$sm3_prefix', 
    `first_name`='$sm3_first_name', `last_name`='$sm3_last_name', `nationality`='$nationality', `gender`='$gender', `birth_date`='$birth_date', 
    `age_y`='$age_y', `age_m`='$age_m', `age_d`='$age_d', `marital_status_id`='$marital_status_id', `address`='$sm3_address', 
    `moo`='$moo', `road`='$road', `chw_code`='$chw_code', `amp_code`='$amp_code', `tmb_code`='$tmb_code', 
    `mobile_phone`='$mobile_phone', `occupation`='$occupation', `epidem_report_guid`='$epidem_report_guid', `epidem_report_group_id`='$epidem_report_group_id', `treated_hospital_code`='$treated_hospital_code', 
    `report_datetime`='$report_datetime', `onset_date`='$onset_date', `treated_date`='$treated_date', `diagnosis_date`='$diagnosis_date', `informer_name`='$sm3_informer_name', 
    `principal_diagnosis_icd10`='$principal_diagnosis_icd10', `diagnosis_icd10_list`='$diagnosis_icd10_list', `epidem_person_status_id`='$epidem_person_status_id', `epidem_symptom_type_id`='$epidem_symptom_type_id', `pregnant_status`='$pregnant_status', 
    `respirator_status`='$respirator_status', `epidem_accommodation_type_id`='$epidem_accommodation_type_id', `vaccinated_status`='$vaccinated_status', `exposure_epidemic_area_status`='$exposure_epidemic_area_status', `exposure_healthcare_worker_status`='$exposure_healthcare_worker_status', 
    `exposure_closed_contact_status`='$exposure_closed_contact_status', `exposure_occupation_status`='$exposure_occupation_status', `exposure_travel_status`='$exposure_travel_status', `risk_history_type_id`='$risk_history_type_id', `epidem_address`='$epidem_address', 
    `epidem_moo`='$epidem_moo', `epidem_road`='', `epidem_chw_code`='$epidem_chw_code', `epidem_amp_code`='$epidem_amp_code', `epidem_tmb_code`='$epidem_tmb_code', 
    `location_gis_latitude`='$location_gis_latitude', `location_gis_longitude`='$location_gis_longitude', `isolate_chw_code`='$isolate_chw_code', `isolate_place_id`='$isolate_place_id', `patient_type`='$patient_type', 
    `epidem_covid_cluster_type_id`='$epidem_covid_cluster_type_id', `cluster_latitude`='$cluster_latitude', `cluster_longitude`='$cluster_longitude', `epidem_lab_confirm_type_id`='$epidem_lab_confirm_type_id', `lab_report_date`='$lab_report_date', 
    `lab_report_result`='$lab_report_result', `specimen_date`='$specimen_date', `specimen_place_id`='$specimen_place_id', `tests_reason_type_id`='$tests_reason_type_id', `lab_his_ref_code`='$lab_his_ref_code', 
    `lab_his_ref_name`='$lab_his_ref_name', `tmlt_code`='$tmlt_code', `date_add`='$date_add', `date_update`='$date_update', `officer`='$officer', 
    `send_data`='$send_data' 
    WHERE `id`= '$epidem_id';";
    $q = $dbi->query($sql);

    $send_back_apidem_id = $epidem_id;
}

if(empty($dbi->error)){

    $post_field = array(
        'hospital' => array(
            "hospital_code" => "11512",
            "hospital_name" => "โรงพยาบาลค่ายสุรศักดิ์มนตรี",
            "his_identifier" => "Surasakmontri Hospital Software Version 3.0"
        ),
        'person' => array(
            "cid" =>  $cid,
            "passport_no" =>  $cid,
            "prefix" =>  $prefix,
            "first_name" =>  $first_name,
            "last_name" =>  $last_name,
            "nationality" =>  $nationality,
            "gender" =>  $gender,
            "birth_date" =>  $birth_date,
            "age_y" =>  $age_y,
            "age_m" =>  $age_m,
            "age_d" =>  $age_d,
            "marital_status_id" =>  $marital_status_id,
            "address" =>  $address,
            "moo" =>  $moo,
            "road" =>  $road,
            "chw_code" => $chw_code,
            "amp_code" => $amp_code,
            "tmb_code" => $tmb_code,
            "mobile_phone" =>  $mobile_phone,
            "occupation" =>  $occupation
        ),
        'epidem_report' => array(
            "epidem_report_guid" => "{".$epidem_report_guid."}",
            "epidem_report_group_id" => $epidem_report_group_id,
            "treated_hospital_code" => $treated_hospital_code,
            "report_datetime" => $report_datetime, 
            "onset_date" => $onset_date,
            "treated_date" => $treated_date,
            "diagnosis_date" => $diagnosis_date,
            "informer_name" => $informer_name,
            "principal_diagnosis_icd10" => $principal_diagnosis_icd10,
            "diagnosis_icd10_list" => $diagnosis_icd10_list,  
            "epidem_person_status_id" => $epidem_person_status_id,
            "epidem_symptom_type_id" => $epidem_symptom_type_id,
            "pregnant_status" => $pregnant_status,
            "respirator_status" => $respirator_status,
            "epidem_accommodation_type_id" => $epidem_accommodation_type_id,
            "vaccinated_status" => $vaccinated_status,
            "exposure_epidemic_area_status" => $exposure_epidemic_area_status,
            "exposure_healthcare_worker_status" => $exposure_healthcare_worker_status,
            "exposure_closed_contact_status" => $exposure_closed_contact_status,
            "exposure_occupation_status" => $exposure_occupation_status,
            "exposure_travel_status" => $exposure_travel_status,
            "risk_history_type_id" => $risk_history_type_id,
            "epidem_address" => $epidem_address,
            "epidem_moo" => $epidem_moo,
            "epidem_road" => $epidem_road,
            "epidem_chw_code" => $epidem_chw_code,
            "epidem_amp_code" => $epidem_amp_code,
            "epidem_tmb_code" => $epidem_tmb_code,
            "location_gis_latitude" => $location_gis_latitude,
            "location_gis_longitude" => $location_gis_longitude, 
            "isolate_chw_code" => $isolate_chw_code,
            "isolate_place_id" => $isolate_place_id,
            "patient_type" => $patient_type,
            "epidem_covid_cluster_type_id" => $epidem_covid_cluster_type_id,
            "cluster_latitude" => $cluster_latitude,
            "cluster_longitude" => $cluster_longitude
        ),
        'lab_report' => array(
            "epidem_lab_confirm_type_id" => $epidem_lab_confirm_type_id,
            "lab_report_date" => $lab_report_date,
            "lab_report_result" => $lab_report_result,
            "specimen_date" => $specimen_date,
            "specimen_place_id" => $specimen_place_id,
            "tests_reason_type_id" => $tests_reason_type_id,
            "lab_his_ref_code" => $lab_his_ref_code,
            "lab_his_ref_name" => $lab_his_ref_name,
            "tmlt_code" => $tmlt_code
        )
    );
    
    $data_postfields = json_encode($post_field);
    
    // get basic info
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, EPIDEM_HOST."SendEPIDEM");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_postfields);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".PUBLIC_KEY));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);

    // $output = '{"result":{"hospital_code":"11512","cid":"'.$idcard.'"},"MessageCode":200,"Message":"OK","RequestTime":"2022-07-27T11:06:14.459Z","EndpointPort":21005,"process_ms":62,"processing_ms":50,"req_rate":1}';
    $pt = json_decode($output, true);
    $pt['apidem_id'] = $send_back_apidem_id;
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($pt);

}