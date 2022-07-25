<?php 
session_start();
include 'config.php';
$dbi = new mysqli(HOST,USER,PASS,DB);

$idcard = $_POST['idcard'];
$main = $_POST[$idcard];
// single: yes

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
$moo = $main['moo'];
$road = $main['road'];
$chw_code = $main['chw_code'];
$amp_code = $main['amp_code'];
$tmb_code = $main['tmb_code'];
$mobile_phone = $main['mobile_phone'];
$occupation = $main['occupation'];
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
$epidem_accommodation_type_id = $main['epidem_accommodation_type_id'];
$vaccinated_status = $main['vaccinated_status'];
$exposure_epidemic_area_status = $main['exposure_epidemic_area_status'];
$exposure_healthcare_worker_status = $main['exposure_healthcare_worker_status'];
$exposure_closed_contact_status = $main['exposure_closed_contact_status'];
$exposure_occupation_status = $main['exposure_occupation_status'];
$exposure_travel_status = $main['exposure_travel_status'];
$risk_history_type_id = $main['risk_history_type_id'];
$epidem_address = $main['epidem_address'];
$epidem_moo = $main['epidem_moo'];
$epidem_road = $main['epidem_road'];
$epidem_chw_code = $main['epidem_chw_code'];
$epidem_amp_code = $main['epidem_amp_code'];
$epidem_tmb_code = $main['epidem_tmb_code'];
$location_gis_latitude = $main['location_gis_latitude'];
$location_gis_longitude = $main['location_gis_longitude'];
$isolate_chw_code = $main['isolate_chw_code'];
$isolate_place_id = $main['isolate_place_id'];
$patient_type = $main['patient_type'];
$epidem_covid_cluster_type_id = $main['epidem_covid_cluster_type_id'];
$cluster_latitude = $main['cluster_latitude'];
$cluster_longitude = $main['cluster_longitude'];
$epidem_lab_confirm_type_id = $main['epidem_lab_confirm_type_id'];
$lab_report_date = $main['lab_report_date'];
$lab_report_result = $main['lab_report_result'];
$specimen_date = $main['specimen_date'];
$specimen_place_id = $main['specimen_place_id'];
$tests_reason_type_id = $main['tests_reason_type_id'];
$lab_his_ref_code = $main['lab_his_ref_code'];
$lab_his_ref_name = $main['lab_his_ref_name'];
$tmlt_code = $main['tmlt_code'];
$date_add = $main['date_add'];
$date_update = $main['date_update'];
$officer = $main['officer'];
$send_data = $main['send_data'];

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
    NULL, '$opsi_id', '$cid', '$hn', '$passport_no', '$prefix', 
    '$first_name', '$last_name', '$nationality', '$gender', '$birth_date', '$age_y', 
    '$age_m', '$age_d', '$marital_status_id', '$address', '$moo', '$road', 
    '$chw_code', '$amp_code', '$tmb_code', '$mobile_phone', '$occupation', '$epidem_report_guid', 
    '$epidem_report_group_id', '$treated_hospital_code', '$report_datetime', '$onset_date', '$treated_date', '$diagnosis_date', 
    '$informer_name', '$principal_diagnosis_icd10', '$diagnosis_icd10_list', '$epidem_person_status_id', '$epidem_symptom_type_id', '$pregnant_status', 
    '$respirator_status', '$epidem_accommodation_type_id', '$vaccinated_status', '$exposure_epidemic_area_status', '$exposure_healthcare_worker_status', '$exposure_closed_contact_status', 
    '$exposure_occupation_status', '$exposure_travel_status', '$risk_history_type_id', '$epidem_address', '$epidem_moo', '$epidem_road', 
    '$epidem_chw_code', '$epidem_amp_code', '$epidem_tmb_code', '$location_gis_latitude', '$location_gis_longitude', '$isolate_chw_code', 
    '$isolate_place_id', '$patient_type', '$epidem_covid_cluster_type_id', '$cluster_latitude', '$cluster_longitude', '$epidem_lab_confirm_type_id', 
    '$lab_report_date', '$lab_report_result', '$specimen_date', '$specimen_place_id', '$tests_reason_type_id', '$lab_his_ref_code', 
    '$lab_his_ref_name', '$tmlt_code', '$date_add', '$date_update', '$officer', '$send_data'
);";
var_dump($sql);
$q = $dbi->query($sql);
var_dump($dbi->error);