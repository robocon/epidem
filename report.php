<?php 
session_start();
include 'config.php';

$dbi = new mysqli(HOST,USER,PASS,DB);
$dbi->query("SET NAMES UTF8");


?>
<style>
    *{
        font-family: "TH SarabunPSK";
        font-size: 18px;
    }
    body{
        margin: 0;
        padding: 0;
    }
    .req{
        background-color: #fffca7;
    }
    .chk_table{
        border-collapse: collapse;
    }
    .chk_table th,
    .chk_table td{
        padding: 3px;
        border: 1px solid black;
    }
    .headcol {
        position:absolute; 
        width:75px; 
        left:0;
        top:auto;
        /* border-right: 0px none black;  */
        /*border-top-width:3px;*/ /*only relevant for first row*/
        /*margin-top:-3px;*/ /*compensate for top border*/
    }
    #noti-alert{
        background-color: #ffc6c6;
        border: 2px solid #464600;
        text-align: center;
        width: 600px;
        position: absolute;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        top: 50%;
    }
    #noti-btn{
        background-color: #bbbbbb;
    }
    #noti-btn:hover{
        cursor:pointer;
    }
    #noti-content{
        padding: 4px;
        font-weight: bold;
    }
</style>

<h3 style="margin:0;">รายงานการส่งข้อมูล EPIDEM</h3>
<div style="height:90%;overflow-y:scroll;">
<table class="chk_table">
    <tr>
        <th colspan="20">ข้อมูลทั่วไปของผู้ติดเชื้อ</th>
        <th colspan="36">ข้อมูลรายละเอียดของการรายงานโรค</th>
        <th colspan="9">ข้อมูลการตรวจ LAB</th>
    </tr>
    <tr>
        <!-- ข้อมูลทั่วไปของผู้ติดเชื้อ -->
        <th class="req">cid</th>
        <th class="req">prefix</th>
        <th class="req">first_name</th>
        <th class="req">last_name</th>
        <th>passport_no</th>

        <th>nationality</th>
        <th class="req">gender</th>
        <th class="req">birth_date</th>
        <th class="req">age_y</th>
        <th class="req">age_m</th>

        <th class="req">age_d</th>
        <th>marital_status_id</th>
        <th class="req">address</th>
        <th>moo</th>
        <th>road</th>

        <th class="req">chw_code</th>
        <th class="req">amp_code</th>
        <th class="req">tmb_code</th>
        <th>mobile_phone</th>
        <th>occupation</th>

        <!-- ข้อมูลรายละเอียดของการรายงานโรค -->
        <th class="req">epidem_report_guid</th>
        <th class="req">epidem_report_group_id</th>
        <th class="req">treated_hospital_code</th>
        <th class="req">report_datetime</th>
        <th>onset_date</th>

        <th>treated_date</th>
        <th>diagnosis_date</th>
        <th>informer_name</th>
        <th class="req">principal_diagnosis_icd10</th>
        <th class="req">diagnosis_icd10_list</th>
        
        <th>epidem_person_status_id</th>
        <th>epidem_symptom_type_id</th>
        <th>pregnant_status</th>
        <th class="req">respirator_status</th>
        <th>epidem_accommodation_type_id</th>

        <th class="req">vaccinated_status</th>
        <th>exposure_epidemic_area_status</th>
        <th class="req">exposure_healthcare_worker_status</th>
        <th>exposure_closed_contact_status</th>
        <th>exposure_occupation_status</th>

        <th>exposure_travel_status</th>
        <th class="req">risk_history_type_id</th>
        <th>epidem_address</th>
        <th>epidem_moo</th>
        <th>epidem_road</th>

        <th class="req">epidem_chw_code</th>
        <th>epidem_amp_code</th>
        <th>epidem_tmb_code</th>
        <th>location_gis_latitude</th>
        <th>location_gis_longitude</th>

        <th class="req">isolate_chw_code</th>
        <th class="req">isolate_place_id</th>
        <th>patient_type</th>

        <th>epidem_covid_cluster_type_id</th>
        <th>cluster_latitude</th>
        <th>cluster_longitude</th>

        <!-- ข้อมูลการตรวจ LAB -->
        <th  class="req">epidem_lab_confirm_type_id</th>
        <th>lab_report_date</th>
        <th>lab_report_result</th>
        <th>specimen_date</th>
        <th>specimen_place_id</th>
        <th class="req">tests_reason_type_id</th>
        <th>lab_his_ref_code</th>
        <th>lab_his_ref_name</th>
        <th>tmlt_code</th>
    </tr>
    <tr>
        <!-- ข้อมูลทั่วไปของผู้ติดเชื้อ -->
        <th class="req">เลขบัตรประจำตัวประชาชน</th>
        <th class="req">คำนำหน้าชื่อ</th>
        <th class="req">ชื่อผู้ป่วย</th>
        <th class="req">นามสกุลผู้ป่วย</th>
        <th>เลขที่หนังสือเดินทาง</th>

        <th>รหัสสัญชาติ</th>
        <th class="req">เพศ</th>
        <th class="req">วันเกิด ปี ค.ศ.</th>
        <th class="req">อายุ (ปี)</th>
        <th class="req">อายุ (เดือน)</th>

        <th  class="req">อายุ (วัน)</th>
        <th>สถานะภาพสมรส</th>
        <th  class="req">ที่อยู่ปัจจุบัน</th>
        <th>ที่อยู่ปัจจุบัน</th>
        <th>ถนน</th>

        <th class="req">รหัสจังหวัด</th>
        <th class="req">รหัสอำเภอ</th>
        <th class="req">รหัสตำบล</th>
        <th>เบอร์โทรศัพท์</th>
        <th>รหัสอาชีพ</th>

        <!-- ข้อมูลรายละเอียดของการรายงานโรค -->
        <th class="req">UID</th>
        <th class="req">รหัสกลุ่มโรคทางระบาดวิทยา</th>
        <th class="req">รหัสโรงพยาบาลที่กำลังรักษาตัว</th>
        <th class="req">วันที่/เวลา ที่รายงานโรค</th>
        <th>วันที่เริ่มมีอาการ (ค.ศ.)</th>

        <th>วันที่เริ่มรักษา (ค.ศ.)</th>
        <th>วันที่วินิจฉัยโรค  (ค.ศ.)</th>
        <th>ชื่อผู้รายงาน</th>
        <th class="req">รหัส ICD10 หลัก</th>
        <th class="req">รหัส ICD10 ผลการวินิจอื่นๆ</th>
        
        <th>สถานะผู้ป่วย ณ ตอนรายงาน</th>
        <th>อาการที่แสดง</th>
        <th>สถานะการตั้งครรภ์</th>
        <th  class="req">ใส่เครื่องช่วยหายใจ</th>
        <th>ลักษณะที่อยู่อาศัย</th>

        <th class="req">มีประวัติการได้รับวัคซีน</th>
        <th>เคยอาศัยอยู่หรือเดินทางมาจากพื้นที่มีการระบาด</th>
        <th class="req">เป็นบุคลากรทางการแพทย์ ที่เกี่ยวข้องกับการรักษา</th>
        <th>ได้อยู่ใกล้ชิดกับผู้ที่ยืนยันว่าเป็นโรค Covid-19 หรือไม่</th>
        <th>ทำงานในอาชีพที่สัมผัสใกล้ชิดกับนัก ท่องเที่ยวต่างชาติหรือกลุ่มเสี่ยงสูง</th>

        <th>ได้เดินทางหรือทำกิจกรรม ในสถานที่ๆ มีคนอยู่หนาแน่น</th>
        <th class="req">ประวัติเสี่ยง 14 วัน</th>
        <th>ที่อยู่ บ้านเลขที่</th>
        <th>ที่อยู่ หมู่</th>
        <th>ที่อยู่ ถนน</th>

        <th class="req">ที่อยู่ รหัสจังหวัด</th>
        <th>ที่อยู่ รหัสอำเภอ</th>
        <th>ที่อยู่ รหัสตำบล</th>
        <th>พิกัด Latitude </th>
        <th>พิกัด Longitude</th>

        <th class="req">รหัสจังหวัดที่ isolate</th>
        <th class="req">สถานที่ isolate</th>
        <th>ประเภทผู้ป่วย</th>

        <th>รหัสของกลุ่ม cluster</th>
        <th>พิกัด Latitude ของcluster</th>
        <th>พิกัด Longitude ของcluster</th>

        <!-- ข้อมูลการตรวจ LAB -->
        <th class="req">ผลการตรวจที่ยืนยันการติดเชื้อ</th>
        <th>วันที่รายงานผล LAB</th>
        <th>ผล lab</th>
        <th>วันที่เก็บตัวอย่าง specimen</th>
        <th>รหัสสถานที่เก็บตัวอย่าง</th>
        <th class="req">เหตุผลการตรวจ</th>
        <th>รหัสอ้างอิงฝั่ง HIS</th>
        <th>ชื่อรายการ Lab ฝั่ง HIS</th>
        <th>รหัส TMLT</th>
    </tr>
    <?php 
    $sql = "SELECT * FROM `epidem` ORDER BY `id` DESC LIMIT 50";
    $q = $dbi->query($sql);
    while ($a = $q->fetch_assoc()) { 
        ?>
        <tr>
            <!-- ข้อมูลทั่วไปของผู้ติดเชื้อ -->
            <td>
                <!-- cid -->
                <?=$a['cid'];?>
            </td>
            <td>
                <!-- prefix -->
                <?=$a['prefix'];?>
            </td>
            <td>
                <!-- first_name -->
                <?=$a['first_name'];?>
            </td>
            <td>
                <!-- last_name -->
                <?=$a['last_name'];?>
            </td>
            <td>
                <!-- passport_no -->
                <?=$a['passport_no'];?>
            </td>

            <td>
                <!-- nationality -->
                <?=$a['nationality'];?>
            </td>
            <td>
                <!-- gender -->
                <?=$a['gender'];?>
            </td>
            <td>
                <!-- birth_date -->
                <?=$a['birth_date'];?>
            </td>
            <td>
                <!-- age_y -->
                <?=$a['age_y'];?>
            </td>
            <td>
                <!-- age_m -->
                <?=$a['age_m'];?>
            </td>
            <td>
                <?=$a['age_d'];?>
            </td>
            <td>
                <?=$a['marital_status_id'];?>
            </td>
            <td>
                <?=$a['address'];?>
            </td>
            <td><!-- moo --></td>
            <td><!-- road --></td>
            <td>
                <?=$a['chw_code'];?>
            </td>
            <td>
                <?=$a['amp_code'];?>
            </td>
            <td>
                <?=$a['tmb_code'];?>
            </td>
            <td>
                <?=$a['mobile_phone'];?>
            </td>
            <td></td><!-- occupation -->

            <!-- ข้อมูลรายละเอียดของการรายงานโรค -->
            <td>
                <!-- epidem_report_guid -->
                <?=$a['epidem_report_guid'];?>
            </td>
            <td>
                <!-- epidem_report_group_id -->
                <?=$a['epidem_report_group_id'];?>
            </td>
            <td>
                <!-- treated_hospital_code -->
                <?=$a['treated_hospital_code'];?>
            </td>
            <td>
                <!-- report_datetime -->
                <?php
                echo $a['report_datetime'];
                ?>
            </td>
            <td>
                <!-- onset_date -->
                <?php 
                echo $a['onset_date'];
                ?>
            </td>

            <td>
                <!-- treated_date -->
                <?php 
                echo $a['treated_date'];
                ?>
            </td>
            <td>
                <!-- diagnosis_date -->
                <?php 
                echo $a['diagnosis_date'];
                ?>
            </td>
            <td>
                <?php 
                echo $a['informer_name'];
                ?>
            </td>
            <td>
                <!-- principal_diagnosis_icd10 -->
                <?=$a['principal_diagnosis_icd10'];?>
            </td>
            <td>
                <!-- diagnosis_icd10_list -->
                <?=$a['diagnosis_icd10_list'];?>
            </td>
            <td>
                <?php 
                $p_status = array(1 => 'กำลังรักษา' , 2 => 'หายจากโรคแล้ว' , 3 => 'เสียชีวิต', 4 => 'ไม่ทราบ');
                echo $p_status[$a['epidem_person_status_id']];
                ?>
            </td>
            <td>
                <?php 
                $symp_list = array(1 => 'ไม่มีอาการ ' , 2 => 'มีอาการที่ ไม่เกี่ยวข้องกับระบบทางเดินหายใจ' , 3 => 'มีอาการที่เกี่ยวกับระบบทาง เดินหายใจ เช่น ปอดบวม');
                ?>
                <select name="<?=$idcard;?>[epidem_symptom_type_id]" id="<?=$idcard;?>[epidem_symptom_type_id]" class="<?=$idcard;?>" >
                    <?php 
                    foreach ($symp_list as $key => $s) { 

                        $checked = $epidem_symptom_type_id==$key ? 'checked="checked"' : '';
                        // if($a['typerisk2']=='โรคระบบทางเดินหายใจ' && $key == 3){
                        //     $checked = 'checked="checked"';
                        // }
                        ?><option value="<?=$key;?>" <?=$checked;?> ><?=$s;?></option><?php
                    }
                    ?>
                </select>
            </td>
            <td>
            <!-- pregnant_status -->
                <?php 
                $preg_list = array('N' => 'ไม่ตั้งครรภ์', 'Y' => 'ตั้งครรภ์');
                ?>
                <select name="<?=$idcard;?>[pregnant_status]" id="<?=$idcard;?>[pregnant_status]" class="<?=$idcard;?>" >
                    <?php 
                    foreach ($preg_list as $key => $s) { 
                        $checked = ( $pregnant_status == $key ) ? 'checked="checked"' : '' ;
                        ?><option value="<?=$key;?>" <?=$checked;?> ><?=$s;?></option><?php
                    }
                    ?>
                </select>
            </td>
            <td>
            <!-- respirator_status -->
                <?php 
                $preg_list = array('N' => 'ไม่ใส่', 'Y' => 'ใส่');
                ?>
                <select name="<?=$idcard;?>[respirator_status]" id="<?=$idcard;?>[respirator_status]" class="<?=$idcard;?>" >
                    <?php 
                    foreach ($preg_list as $key => $s) { 
                        $selected = ($respirator_status==$key) ? 'selected="selected"' : '';
                        ?><option value="<?=$key;?>" <?=$selected;?> ><?=$s;?></option><?php
                    }
                    ?>
                </select>
            </td>
            <td><!-- epidem_accommodation_type_id --></td>
            <td>
            <!-- vaccinated_status -->
                <?php 
                $vacc_stat = 'N';
                if(!empty($a['patient_vaccine'])){
                    $vacc_stat = 'Y';
                }
                echo $vacc_stat;
                ?>
                <input type="hidden" name="<?=$idcard;?>[vaccinated_status]" id="<?=$idcard;?>[vaccinated_status]" class="<?=$idcard;?>" value="<?=$vacc_stat;?>">
            </td>
            <td>
            <!-- exposure_epidemic_area_status -->
                <?php 
                $area_status_list = array('N','Y');
                ?>
                <select name="<?=$idcard;?>[exposure_epidemic_area_status]" id="<?=$idcard;?>[exposure_epidemic_area_status]" class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($area_status_list as $s) { 
                        ?><option value="<?=$s;?>"><?=$s;?></option><?php
                    }
                    ?>
                </select>
            </td>
            <td>
            <!-- exposure_healthcare_worker_status -->
                <?php 
                $heal_worker_list = array('N','Y'); 
                // default เป็น N
                if(empty($exposure_healthcare_worker_status)){
                    $exposure_healthcare_worker_status = 'N';
                }
                ?>
                <select name="<?=$idcard;?>[exposure_healthcare_worker_status]" id="<?=$idcard;?>[exposure_healthcare_worker_status]"class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($heal_worker_list as $s) { 

                        $selected = ($s==$exposure_healthcare_worker_status) ? 'selected="selected"' : '';

                        ?><option value="<?=$s;?>" <?=$selected;?> ><?=$s;?></option><?php
                    }
                    ?>
                </select>
            </td>
            <td>
            <!-- exposure_closed_contact_status -->
                <?php 
                $closed_contact_list = array('N','Y');
                ?>
                <select name="<?=$idcard;?>[exposure_closed_contact_status]" id="<?=$idcard;?>[exposure_closed_contact_status]"class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($closed_contact_list as $s) { 
                        $selected = ($s == $exposure_closed_contact_status) ? 'selected="selected"' : '';
                        ?><option value="<?=$s;?>" <?=$selected;?> ><?=$s;?></option><?php
                    }
                    ?>
                </select>
            </td>
            <td>
            <!-- exposure_occupation_status -->
                <?php 
                $occupation_status_list = array('N','Y');
                ?>
                <select name="<?=$idcard;?>[exposure_occupation_status]" id="<?=$idcard;?>[exposure_occupation_status]"class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($occupation_status_list as $s) { 
                        
                        $selected = ($s == $exposure_occupation_status) ? 'selected="selected"' : '';
                        ?><option value="<?=$s;?>" <?=$selected;?> ><?=$s;?></option><?php
                    }
                    ?>
                </select>
            </td>

            <td>
            <!-- exposure_travel_status -->
                <?php 
                $travel_status_list = array('N','Y');
                ?>
                <select name="<?=$idcard;?>[exposure_travel_status]" id="<?=$idcard;?>[exposure_travel_status]" class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($travel_status_list as $s) { 
                        
                        $selected = ($s == $exposure_travel_status) ? 'selected="selected"' : '';
                        ?><option value="<?=$s;?>" <?=$selected;?> ><?=$s;?></option><?php
                    }
                    ?>
                </select>
            </td>
            <td>
            <!-- risk_history_type_id -->
                <select name="<?=$idcard;?>[risk_history_type_id]" id="<?=$idcard;?>[risk_history_type_id]" class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                <?php 
                $risk_type_list = json_decode('[{"epidem_risk_history_type_id":1,"epidem_risk_history_type_name":"ทำงานในโรงพยาบาล/คลินิก"},{"epidem_risk_history_type_id":2,"epidem_risk_history_type_name":"ทำงานในโรงงาน/สถานประกอบการ/ประมง/การเกษตร ที่มีพนักงานตั้งแต่ 50 คนขึ้นไป"},{"epidem_risk_history_type_id":3,"epidem_risk_history_type_name":"ทำงานในตลาด/ไปตลาดเป็นประจำ"},{"epidem_risk_history_type_id":4,"epidem_risk_history_type_name":"ทำงานในแคมป์ก่อสร้าง"},{"epidem_risk_history_type_id":5,"epidem_risk_history_type_name":"ผู้ต้องขังในเรือนจำ/ทัณฑสถาน"},{"epidem_risk_history_type_id":6,"epidem_risk_history_type_name":"อยู่ในศูนย์พักพิงชั่วคราว/ศูนย์กักกัน"},{"epidem_risk_history_type_id":7,"epidem_risk_history_type_name":"มาจากต่างประเทศ (เข้าประเทศอย่างถูกกฎหมาย)"},{"epidem_risk_history_type_id":8,"epidem_risk_history_type_name":"มาจากต่างประเทศ (ลักลอบเข้าประเทศ)"},{"epidem_risk_history_type_id":9,"epidem_risk_history_type_name":"อยู่ในชุมชนแออัด"},{"epidem_risk_history_type_id":10,"epidem_risk_history_type_name":"ทำงานในหน่วยงานราชการ/ สำนักงาน/ บริษัท ที่มีพนักงานตั้งแต่ 50 คนขึ้นไป"},{"epidem_risk_history_type_id":11,"epidem_risk_history_type_name":"อยู่อาศัย หรือทำงานในศูนย์ดูแลผู้สูงอายุ/ สถานสงเคราะห์คนชราหรือดูแลผู้ป่วยโรคเรื้อรัง/ long-tern ca"},{"epidem_risk_history_type_id":12,"epidem_risk_history_type_name":"ไปหรือทำงานที่โรงเรียน/ สถาบันศึกษา/ ศูนย์เด็กเล็ก"},{"epidem_risk_history_type_id":13,"epidem_risk_history_type_name":"ประกอบอาชีพเสี่ยง (กลุ่มอาชีพที่ไม่สามารถทำงานจากที่บ้านได้ เช่น ค้าขาย รับจ้าง ขับรถสาธารณะ เป็นต้น"},{"epidem_risk_history_type_id":14,"epidem_risk_history_type_name":"ไม่มีประวัติตามข้อ 1-13 ข้างต้น"}]');
                foreach ($risk_type_list as $rt) { 

                    $selected = ($risk_history_type_id==$rt->epidem_risk_history_type_id) ? 'selected="selected"' : '';
                    
                    ?><option value="<?=$rt->epidem_risk_history_type_id;?>" <?=$selected;?> ><?=$rt->epidem_risk_history_type_name;?></option><?php
                }
                ?>
                </select>
            </td>
            <td><!-- epidem_address --></td>
            <td><!-- epidem_moo --></td>
            <td><!-- epidem_road --></td>

            <td><!-- epidem_chw_code -->
                <?=$pv_code;?>
                <input type="hidden" name="<?=$idcard;?>[epidem_chw_code]" id="<?=$idcard;?>[epidem_chw_code]" class="<?=$idcard;?>" value="<?=$pv_code;?>">
            </td>
            <td><!-- epidem_amp_code -->
                <?=$ap_code;?>
                <input type="hidden" name="<?=$idcard;?>[epidem_amp_code]" id="<?=$idcard;?>[epidem_amp_code]" class="<?=$idcard;?>" value="<?=$ap_code;?>">
            </td>
            <td><!-- epidem_tmb_code -->
                <?=$tb_code;?>
                <input type="hidden" name="<?=$idcard;?>[epidem_tmb_code]" id="<?=$idcard;?>[epidem_tmb_code]" class="<?=$idcard;?>" value="<?=$tb_code;?>">
            </td>
            <td><!-- location_gis_latitude --></td>
            <td><!-- location_gis_longitude --></td>

            <td><!-- isolate_chw_code -->
                <?=$pv_code;?>
                <input type="hidden" name="<?=$idcard;?>[isolate_chw_code]" id="<?=$idcard;?>[isolate_chw_code]" class="<?=$idcard;?>" value="<?=$pv_code;?>">
            </td>
            <td>
                <!-- isolate_place_id -->
                <select name="<?=$idcard;?>[isolate_place_id]" id="<?=$idcard;?>[isolate_place_id]" class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                <?php 
                // default เป็น 5
                if(empty($isolate_place_id)){
                    $isolate_place_id = 5;
                }

                $isolate_place_list = json_decode('[{"epidem_covid_isolate_place_id":1,"epidem_covid_isolate_place_name":"โรงพยาบาล"},{"epidem_covid_isolate_place_id":2,"epidem_covid_isolate_place_name":"โรงพยาบาลสนาม"},{"epidem_covid_isolate_place_id":3,"epidem_covid_isolate_place_name":"Hospitel"},{"epidem_covid_isolate_place_id":4,"epidem_covid_isolate_place_name":"แยกกักในชุมชน (CI)"},{"epidem_covid_isolate_place_id":5,"epidem_covid_isolate_place_name":"ที่พักอาศัย (HI)"},{"epidem_covid_isolate_place_id":6,"epidem_covid_isolate_place_name":"อื่นๆ"}]');
                foreach ($isolate_place_list as $pl) { 

                    $selected = ($pl->epidem_covid_isolate_place_id==$isolate_place_id) ? 'selected="selected"' : '';


                    ?><option value="<?=$pl->epidem_covid_isolate_place_id;?>" <?=$selected;?> ><?=$pl->epidem_covid_isolate_place_name;?></option><?php
                }
                ?>
                </select>
            </td>
            <td>
                <!-- patient_type -->
                OPD
                <input type="hidden" name="<?=$idcard;?>[patient_type]" id="<?=$idcard;?>[patient_type]" class="<?=$idcard;?>" value="OPD">
            </td>

            <td><!-- epidem_covid_cluster_type_id --></td>
            <td><!-- cluster_latitude --></td>
            <td><!-- cluster_longitude --></td>

            <!-- ข้อมูลการตรวจ LAB -->
            <td align="center">
            <!-- epidem_lab_confirm_type_id -->
                <?php 
                // ผลการตรวจที่ยืนยันการติดเชื้อ (1 = RT-PCR, 2 = Antigen , 3 = Antibody)
                $confirm_type_list = array(1 => 'RT-PCR', 2 => 'Antigen' , 3 => 'Antibody');
                ?>
                <select name="<?=$idcard;?>[epidem_lab_confirm_type_id]" id="<?=$idcard;?>[epidem_lab_confirm_type_id]" class="<?=$idcard;?>" >
                    <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($confirm_type_list as $k => $c) { 

                        $selected = '';
                        if( ($a['atk']==1 || !empty($a['atkdate'])) && $k == 2 ){
                            $selected = 'selected="selected"';
                        }elseif ( $a['rtpcr']==1 && $k == 1 ) {
                            $selected = 'selected="selected"';
                        }

                        ?><option value="<?=$k;?>" <?=$selected;?> ><?=$c;?></option><?php
                    }
                    ?>
                </select>
            </td>
            <td><!-- lab_report_date --></td>
            <td><!-- lab_report_result --></td>
            <td><!-- specimen_date --></td>
            <td><!-- specimen_place_id --></td>
            <td>
                <!-- tests_reason_type_id -->
                <select name="<?=$idcard;?>[tests_reason_type_id]" id="<?=$idcard;?>[tests_reason_type_id]" class="<?=$idcard;?>" >
                    <option value="">เลือกข้อมูล</option>
                <?php 
                $reason_type_list = json_decode('[{"epidem_covid_reason_type_id":1,"epidem_covid_reason_type_name":"เข้าเกณฑ์ PUI (ยกเว้นกรณีสัมผัสผู้ติดเชื้อยืนยัน)"},{"epidem_covid_reason_type_id":2,"epidem_covid_reason_type_name":"มาตรวจด้วยประวัติสัมผัสผู้ติดเชื้อในครอบครัว/ร่วมบ้าน"},{"epidem_covid_reason_type_id":3,"epidem_covid_reason_type_name":"มาตรวจด้วยประวัติสัมผัสผู้ติดเชื้อนอกครอบครัว/ที่ทำงาน/ชุมชน"},{"epidem_covid_reason_type_id":4,"epidem_covid_reason_type_name":"ขอตรวจเอง (เข้าทำงาน/ผลตรวจ ATK / เดินทางไปต่างประเทศ / กังวัล)"},{"epidem_covid_reason_type_id":5,"epidem_covid_reason_type_name":"Active case finding /Contact tracing (ค้นหาผู้สัมผัสในครอบครัว/ที่ทำงาน/ชุมชน)"},{"epidem_covid_reason_type_id":6,"epidem_covid_reason_type_name":"สุ่มตรวจเชิงรุก/คัดกรอง ในพื้นที่ที่ไม่เคยมีรายงานการติดเชื้อ/สถานที่เสี่ยง นอกสถานพยาบาล"},{"epidem_covid_reason_type_id":7,"epidem_covid_reason_type_name":"Sentinel surveillance"},{"epidem_covid_reason_type_id":8,"epidem_covid_reason_type_name":"ตรวจก่อนทำหัตการ / Admit"},{"epidem_covid_reason_type_id":9,"epidem_covid_reason_type_name":"ให้ตรวจเพิ่มเติมโดยสถานพยาบาล (เจ้าหน้าที่/พนักงาน/ญาติผู้ป่วย)"},{"epidem_covid_reason_type_id":10,"epidem_covid_reason_type_name":"อื่นๆ"}]');
                foreach ($reason_type_list as $trt) {

                    $selected = ($trt->epidem_covid_reason_type_id==$tests_reason_type_id) ? 'selected="selected"' : '' ;

                    ?><option value="<?=$trt->epidem_covid_reason_type_id;?>" <?=$selected;?> ><?=$trt->epidem_covid_reason_type_name;?></option><?php
                }
                ?>
                </select>
            </td>
            <td><!-- lab_his_ref_code --></td>
            <td><!-- lab_his_ref_name --></td>
            <td><!-- tmlt_code --></td>
        </tr>
        <?php
    }
    ?>

</div>