<?php 
session_start();
include 'config.php';
$dbi = new mysqli(HOST,USER,PASS,DB);

function dump($txt)
{
    echo "<pre>";
    var_dump($txt);
    echo "</pre>";
}

function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// $password_hash = strtoupper(hash_hmac('sha256', MOPH_USER, SECRET_KEY));
// dump($password_hash);

// 
// https://cvp1.moph.go.th/token?Action=get_moph_access_token&user=Surasak11512&password_hash=8072F6286DDDE4AF49085F680E4016AAFA0435DFD48EDA1C5FC6E1ACE5F5A6BD&hospital_code=11512

//
// https://epidemcenter.moph.go.th/epidem/api/LookupTable?table_name=epidem_risk_history_type

$date_search = $_POST['date_search'];
$sql = "SELECT * FROM `opselfisolation_detail` WHERE `registerdate` = '$date_search'";
$q = $dbi->query($sql);
if($q->num_rows == 0){
    echo "ไม่พบข้อมูล";
    exit;
}

?>
<style>
    *{
        font-family: "TH SarabunPSK";
        font-size: 16px;
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
</style>
<div>
    <a href="https://ddc.moph.go.th/viralpneumonia/file/g_surveillance/g_api_epidem_0165.pdf" target="_blank">รายละเอียดโครงสร้างข้อมูล</a>
</div>





<form action="epidem_send.php" method="post" id="epidem_form">


<script>
    var all_users = [];
</script>

<div style="height:90%;overflow-y:scroll;">
<table class="chk_table">
    <tr>
        <th colspan="20">ข้อมูลทั่วไปของผู้ติดเชื้อ</th>
        <th colspan="36">ข้อมูลรายละเอียดของการรายงานโรค</th>
        <th colspan="9">ข้อมูลการตรวจ LAB</th>
        <th rowspan="3">ส่งข้อมูลรายคน</th>
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
    while ($a = $q->fetch_assoc()) { 
        $idcard = $a['idcard'];
        $opsi_id = $a['row_id'];

        $bg_color = '';
        $q_epidem = $dbi->query("SELECT `id` FROM `epidem` WHERE `opsi_id` = '$opsi_id' ");
        if($q_epidem->num_rows > 0){
            $bg_color = 'style="background-color: #b6ffa8"';
        }


        $hn = $a['hn'];
        $qop = $dbi->query("SELECT `yot`,`name`,`surname`,`passport`,`nation`,`sex`,`dbirth`,`married`,`address`,`tambol`,`ampur`,`changwat`,
        `phone` 
        FROM `opcard` WHERE `hn` = '$hn' ");
        $op = $qop->fetch_assoc();

        $yot = iconv('TIS-620','UTF-8', $op['yot']);
        $name = iconv('TIS-620','UTF-8', $op['name']);
        $surname = iconv('TIS-620','UTF-8', $op['surname']);
        $passport = $op['passport'];
        $op_nation = $op['nation'];
        $phone = $op['phone'];

        $sex = iconv('TIS-620','UTF-8', $op['sex']);
        $sex = ($sex=='ช') ? '1': '2';

        $thYear = substr($op['dbirth'],0,4);
        $dbirth = ($thYear-543).substr($op['dbirth'],4);
        
        $birthday = new DateTime($dbirth);
        $diff = $birthday->diff(new DateTime());
        $testY = $diff->format('%y');
        $testM = $diff->format('%m');
        $testD = $diff->format('%d');

        $married = iconv('TIS-620','UTF-8', $op['married']);
        // (1=โสด, 2=คู่, 3=หย่าร้าง, 4=หม้าย)
        $married_code = '1';
        if($married=='สมรส'){ $married_code = 2; }
        elseif ($married=='หย่าร้าง') { $married_code = 3; }
        elseif ($married=='หม้าย') { $married_code = 4; }

        // `address`,`tambol`,`ampur`,`changwat`
        $address = iconv('TIS-620','UTF-8', $op['address']);
        $changwat = $op['changwat'];
        $tambon = $op['tambol'];

        $tb_statement = "SELECT `lgo_code` FROM `tambon` WHERE `province` = '$changwat' AND `lgo_name` = '$tambon'";
        $qtb = $dbi->query($tb_statement);
        if($qtb->num_rows > 0){
            $tb = $qtb->fetch_assoc();
            $pv_code = substr($tb['lgo_code'],0,2);
            $ap_code = substr($tb['lgo_code'],2,2);
            $tb_code = substr($tb['lgo_code'],4,2);
        }else{
            $tb_code = iconv('TIS-620','UTF-8', $op['tambol']);
            $ap_code = iconv('TIS-620','UTF-8', $op['ampur']);
            $pv_code = iconv('TIS-620','UTF-8', $op['changwat']);
        }
        

        $qna = $dbi->query("SELECT `code` FROM `nation` WHERE `detail` = '$op_nation' ");
        $na_item = $qna->fetch_assoc();
        $na_code = $na_item['code'];
        ?>
        <tr id="<?=$idcard;?>[row]" <?=$bg_color;?>>
            <!-- ข้อมูลทั่วไปของผู้ติดเชื้อ -->
            <td>
                <!-- cid -->
                <?=$idcard;?>
                <input type="hidden" name="<?=$idcard;?>[cid]" id="<?=$idcard;?>[cid]" class="<?=$idcard;?>" value="<?=$idcard;?>">
                <script>
                    all_users.push("<?=$idcard;?>");
                </script>
            </td>
            <td>
                <!-- prefix -->
                <?=$yot;?>
                <input type="hidden" name="<?=$idcard;?>[prefix]" id="<?=$idcard;?>[prefix]" class="<?=$idcard;?>" value="<?=$yot;?>">
            </td>
            <td>
                <!-- first_name -->
                <?=$name;?>
                <input type="hidden" name="<?=$idcard;?>[first_name]" id="<?=$idcard;?>[first_name]" class="<?=$idcard;?>" value="<?=$name;?>">
            </td>
            <td>
                <!-- last_name -->
                <?=$surname;?>
                <input type="hidden" name="<?=$idcard;?>[last_name]" id="<?=$idcard;?>[last_name]" class="<?=$idcard;?>" value="<?=$surname;?>">
            </td>
            <td>
                <!-- passport_no -->
                <?=$passport;?>
                <input type="hidden" name="<?=$idcard;?>[passport_no]" id="<?=$idcard;?>[passport_no]" class="<?=$idcard;?>" value="<?=$passport;?>">
            </td>

            <td>
                <!-- nationality -->
                <?=$na_code;?>
                <input type="hidden" name="<?=$idcard;?>[nationality]" id="<?=$idcard;?>[nationality]" class="<?=$idcard;?>" value="<?=$na_code;?>">
            </td>
            <td>
                <!-- gender -->
                <?=$sex;?>
                <input type="hidden" name="<?=$idcard;?>[gender]" id="<?=$idcard;?>[gender]" class="<?=$idcard;?>" value="<?=$sex;?>">
            </td>
            <td>
                <!-- birth_date -->
                <?=$dbirth;?>
                <input type="hidden" name="<?=$idcard;?>[birth_date]" id="<?=$idcard;?>[birth_date]" class="<?=$idcard;?>" value="<?=$dbirth;?>">
            </td>
            <td>
                <!-- age_y -->
                <?=$testY;?>
                <input type="hidden" name="<?=$idcard;?>[age_y]" id="<?=$idcard;?>[age_y]" class="<?=$idcard;?>" value="<?=$testY;?>">
            </td>
            <td>
                <!-- age_m -->
                <?=$testM;?>
                <input type="hidden" name="<?=$idcard;?>[age_m]" id="<?=$idcard;?>[age_m]" class="<?=$idcard;?>" value="<?=$testM;?>">
            </td>

            <td>
                <?=$testD;?>
                <input type="hidden" name="<?=$idcard;?>[age_d]" id="<?=$idcard;?>[age_d]" class="<?=$idcard;?>" value="<?=$testD;?>">
            </td>
            <td>
                <?=$married_code;?>
                <input type="hidden" name="<?=$idcard;?>[married_code]" id="<?=$idcard;?>[married_code]" class="<?=$idcard;?>" value="<?=$married_code;?>">
            </td>
            <td>
                <?=$address;?>
                <input type="hidden" name="<?=$idcard;?>[address]" id="<?=$idcard;?>[address]" class="<?=$idcard;?>" value="<?=$address;?>">
            </td>
            <td><!-- moo --></td>
            <td><!-- road --></td>

            <td>
                <?=$pv_code;?>
                <input type="hidden" name="<?=$idcard;?>[chw_code]" id="<?=$idcard;?>[chw_code]" class="<?=$idcard;?>" value="<?=$pv_code;?>">
            </td>
            <td>
                <?=$ap_code;?>
                <input type="hidden" name="<?=$idcard;?>[amp_code]" id="<?=$idcard;?>[amp_code]" class="<?=$idcard;?>" value="<?=$ap_code;?>">
            </td>
            <td>
                <?=$tb_code;?>
                <input type="hidden" name="<?=$idcard;?>[tmb_code]" id="<?=$idcard;?>[tmb_code]" class="<?=$idcard;?>" value="<?=$tb_code;?>">
            </td>
            <td>
                <?=$phone;?>
                <input type="hidden" name="<?=$idcard;?>[mobile_phone]" id="<?=$idcard;?>[mobile_phone]" class="<?=$idcard;?>" value="<?=$phone;?>">
            </td>
            <td></td><!-- occupation -->

            <!-- ข้อมูลรายละเอียดของการรายงานโรค -->
            <?php 
            $uuid = guidv4();
            ?>
            <td>
                <!-- epidem_report_guid -->
                <?php 
                echo $uuid;
                ?>
                <input type="hidden" name="<?=$idcard;?>[epidem_report_guid]" id="<?=$idcard;?>[epidem_report_guid]" class="<?=$idcard;?>" value="<?=$uuid;?>">
            </td>
            <td><!-- epidem_report_group_id -->92</td>
            <td><!-- treated_hospital_code -->11512</td>
            <td>
                <!-- report_datetime -->
                <?php
                $curr_date = date('Y-m-d\TH:i:s.v'); // Format YYYY-mm-ddTHH:ii:ss.000
                echo $curr_date;
                ?>
                <input type="hidden" name="<?=$idcard;?>[report_datetime]" id="<?=$idcard;?>[report_datetime]" class="<?=$idcard;?>" value="<?=$curr_date;?>">
            </td>
            <td>
                <!-- onset_date -->
                <?php 
                $symptom_date = $a['symptom_date'];
                echo $symptom_date;
                ?>
                <input type="hidden" name="<?=$idcard;?>[onset_date]" id="<?=$idcard;?>[onset_date]" class="<?=$idcard;?>" value="<?=$symptom_date;?>">
            </td>

            <td>
                <!-- treated_date -->
                <?php 
                $consent_date = $a['consent_date'];
                echo $consent_date;
                ?>
                <input type="hidden" name="<?=$idcard;?>[symptom_date]" id="<?=$idcard;?>[symptom_date]" class="<?=$idcard;?>" value="<?=$consent_date;?>">
            </td>
            <td>
                <!-- diagnosis_date -->
                <?php 
                $registerdate = $a['registerdate'];
                echo $registerdate;
                ?>
                <input type="hidden" name="<?=$idcard;?>[registerdate]" id="<?=$idcard;?>[registerdate]" class="<?=$idcard;?>" value="<?=$registerdate;?>">
            </td>
            <td>
                <?php 
                $officer = iconv('TIS-620', 'UTF-8', $a['officer']);
                echo $officer;
                ?>
                <input type="hidden" name="<?=$idcard;?>[informer_name]" id="<?=$idcard;?>[informer_name]" class="<?=$idcard;?>" value="<?=$officer;?>">
            </td>
            <td>
                <!-- principal_diagnosis_icd10 -->
                B342
                <input type="hidden" name="<?=$idcard;?>[principal_diagnosis_icd10]" id="<?=$idcard;?>[principal_diagnosis_icd10]" class="<?=$idcard;?>" value="B342">
            </td>
            <td>
                <!-- diagnosis_icd10_list -->
                B342
                <input type="hidden" name="<?=$idcard;?>[diagnosis_icd10_list]" id="<?=$idcard;?>[diagnosis_icd10_list]" class="<?=$idcard;?>" value="B342">
            </td>
            <td>
                <?php 
                $p_status = array(1 => 'กำลังรักษา' , 2 => 'หายจากโรคแล้ว' , 3 => 'เสียชีวิต', 4 => 'ไม่ทราบ');
                ?>
                <select name="<?=$idcard;?>[epidem_person_status_id]" id="<?=$idcard;?>[epidem_person_status_id]" class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($p_status as $key => $s) {
                        ?><option value="<?=$key;?>"><?=$s;?></option><?php
                    }
                    ?>
                </select>
            </td>
            <td>
                <?php 
                $symp_list = array(1 => 'ไม่มีอาการ ' , 2 => 'มีอาการที่ ไม่เกี่ยวข้องกับระบบทางเดินหายใจ' , 3 => 'มีอาการที่เกี่ยวกับระบบทาง เดินหายใจ เช่น ปอดบวม');
                ?>
                <select name="<?=$idcard;?>[epidem_symptom_type_id]" id="<?=$idcard;?>[epidem_symptom_type_id]" class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($symp_list as $key => $s) { 
                        $checked = '';
                        if($a['typerisk2']=='โรคระบบทางเดินหายใจ' && $key == 3){
                            $checked = 'checked="checked"';
                        }
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
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($preg_list as $key => $s) { 
                        $checked = '';
                        ?><option value="<?=$key;?>"><?=$s;?></option><?php
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
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($preg_list as $key => $s) { 
                        $selected = ($key=='N') ? 'selected="selected"' : '';
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
                ?>
                <select name="<?=$idcard;?>[exposure_healthcare_worker_status]" id="<?=$idcard;?>[exposure_healthcare_worker_status]"class="<?=$idcard;?>" >
                <option value="">เลือกข้อมูล</option>
                    <?php 
                    foreach ($heal_worker_list as $s) { 

                        $selected = ($s=='N') ? 'selected="selected"' : '';

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
                        ?><option value="<?=$s;?>"><?=$s;?></option><?php
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
                        ?><option value="<?=$s;?>"><?=$s;?></option><?php
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
                        ?><option value="<?=$s;?>"><?=$s;?></option><?php
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
                foreach ($risk_type_list as $key => $rt) {
                    ?><option value="<?=$rt->epidem_risk_history_type_id;?>"><?=$rt->epidem_risk_history_type_name;?></option><?php
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
                $isolate_place_list = json_decode('[{"epidem_covid_isolate_place_id":1,"epidem_covid_isolate_place_name":"โรงพยาบาล"},{"epidem_covid_isolate_place_id":2,"epidem_covid_isolate_place_name":"โรงพยาบาลสนาม"},{"epidem_covid_isolate_place_id":3,"epidem_covid_isolate_place_name":"Hospitel"},{"epidem_covid_isolate_place_id":4,"epidem_covid_isolate_place_name":"แยกกักในชุมชน (CI)"},{"epidem_covid_isolate_place_id":5,"epidem_covid_isolate_place_name":"ที่พักอาศัย (HI)"},{"epidem_covid_isolate_place_id":6,"epidem_covid_isolate_place_name":"อื่นๆ"}]');
                foreach ($isolate_place_list as $key => $pl) { 

                    $selected = ($pl->epidem_covid_isolate_place_id==5) ? 'selected="selected"' : '';

                    ?><option value="<?=$pl->epidem_covid_isolate_place_id;?>" <?=$selected;?> ><?=$pl->epidem_covid_isolate_place_name;?></option><?php
                }
                ?>
                </select>
            </td>
            <td><!-- patient_type -->OPD</td>

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

                    // $selected = ($trt->epidem_covid_reason_type_id==2) ? 'selected="selected"' : '' ;

                    ?><option value="<?=$trt->epidem_covid_reason_type_id;?>" <?=$selected;?> ><?=$trt->epidem_covid_reason_type_name;?></option><?php
                }
                ?>
                </select>
            </td>
            <td><!-- lab_his_ref_code --></td>
            <td><!-- lab_his_ref_name --></td>
            <td><!-- tmlt_code --></td>
            <td>
                <button onclick="send_api('<?=$idcard;?>')" type="button">ส่งข้อมูลรายคน</button>
                <input type="hidden" name="<?=$idcard;?>[opsi_id]" id="<?=$idcard;?>[opsi_id]" class="<?=$idcard;?>" value="<?=$opsi_id;?>">
                <input type="hidden" name="idcard[]" id="" value="<?=$idcard;?>">
            </td>
        </tr>
        <?php
    }
    ?>
</table>
</div>
<div>
    <button type="button" onclick="send_all_users();">ส่งข้อมูลทั้งหมด</button>
</div>
</form>

<script> 
    function newXmlHttp(){
        var xmlhttp = false;

        try{
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
            try{
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(e){
                xmlhttp = false;
            }
        }

        if(!xmlhttp && document.createElement){
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }
    
    function send_all_users(){
        
        var resTxt = '';

        for (let index = 0; index < all_users.length; index++) {
            const element = all_users[index];
            var reses = validate_form(element);

            if(reses.length >= 2){
                resTxt += reses[0]+"\n";
            }
        }

        if(resTxt!=""){
            alert(resTxt+"\nข้อมูลไม่ครบถ้วน กรุณาตรวจสอบข้อมูลอีกครั้ง");
        }else{
            document.getElementById("epidem_form").submit();
        }

    }

    function send_api(idcard){

        var reses = validate_form(idcard);
        if(reses.length >= 2){

            var resTxt = '';
            for (let index = 0; index < reses.length; index++) {
                const element = reses[index];
                if(index==0){
                    resTxt += element+" ขาดข้อมูล\n";
                }else{
                    resTxt += "- "+element+"\n";
                }
            }
            resTxt += "กรุณากรอกข้อมูลให้ครบถ้วน";
            alert(resTxt);
            
        }else{

            /**
             * [] show icon loading...
             * [] send post and save
             * [] close icon loading...
             * [] change color background
             */

            var items = document.getElementsByClassName(idcard);
            var test_str = [];
            for (let index = 0; index < items.length; index++) {
                const element = items[index];
                test_str.push(encodeURIComponent(element.id)+"="+encodeURIComponent(element.value));
            }
            test_str.push(encodeURIComponent("single")+"="+encodeURIComponent("yes"));
            test_str.push(encodeURIComponent("idcard")+"="+encodeURIComponent(idcard));
            var data = test_str.join("&");

            var req = newXmlHttp();
            req.open('POST', 'epidem_send.php', true);
            req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            // req.onreadystatechange = function() {
            //     if (this.readyState === 4) {
            //         if (this.status >= 200 && this.status < 400) { 


            //         } else {
            //             // Error :(
            //         }
            //     }
            // };
            req.send(data);


        }
        
    }

    function validate_form(idcard){

        /*
        document.getElementById(idcard+"[cid]").value;
        document.getElementById(idcard+"[prefix]").value;
        document.getElementById(idcard+"[first_name]").value;
        document.getElementById(idcard+"[last_name]").value;
        document.getElementById(idcard+"[gender]").value;
        document.getElementById(idcard+"[birth_date]").value;
        document.getElementById(idcard+"[age_y]").value;
        document.getElementById(idcard+"[age_m]").value;
        document.getElementById(idcard+"[age_d]").value;
        document.getElementById(idcard+"[address]").value;
        */
        var val_alert = [];
        var val_test = false;

        var chw_code = parseInt(document.getElementById(idcard+"[chw_code]").value.trim());
        if(isNaN(chw_code)){
            val_alert.push("ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบข้อมูล จังหวัด อำเภอ ตำบล อีกครั้ง")
        }
        

        // document.getElementById(idcard+"[amp_code]").value;
        // document.getElementById(idcard+"[tmb_code]").value;

        // ฟิกเอาไว้
        // document.getElementById(idcard+"[epidem_report_group_id]").value;
        // document.getElementById(idcard+"[treated_hospital_code]").value;
        // document.getElementById(idcard+"[report_datetime]").value;
        // document.getElementById(idcard+"[principal_diagnosis_icd10]").value;
        // document.getElementById(idcard+"[diagnosis_icd10_list]").value;

        var respirator_status = document.getElementById(idcard+"[respirator_status]").value.trim();
        if(respirator_status==""){ 
            // alert("กรุณาเลือกข้อมูล respirator_status(ใส่เครื่องช่วยหายใจ)");
            // return;
            val_alert.push("respirator_status(ใส่เครื่องช่วยหายใจ)");
        }
        
        // document.getElementById(idcard+"[vaccinated_status]").value;

        var healt_worker = document.getElementById(idcard+"[exposure_healthcare_worker_status]").value;
        if(healt_worker==""){ 
            // alert("กรุณาเลือกข้อมูล exposure_healthcare_worker_status(เป็นบุคลากรทางการแพทย์ ที่เกี่ยวข้องกับการรักษา)");
            // return;
            val_alert.push("exposure_healthcare_worker_status(เป็นบุคลากรทางการแพทย์ ที่เกี่ยวข้องกับการรักษา)");
        }

        var risk_history = document.getElementById(idcard+"[risk_history_type_id]").value;
        if(risk_history==""){ 
            // alert("กรุณาเลือกข้อมูล risk_history_type_id(ประวัติเสี่ยง 14 วัน)");
            // return;
            val_alert.push("risk_history_type_id(ประวัติเสี่ยง 14 วัน)");
        }

        // document.getElementById(idcard+"[epidem_chw_code]").value;
        // document.getElementById(idcard+"[isolate_chw_code]").value;

        var isolate_place = document.getElementById(idcard+"[isolate_place_id]").value;
        if(isolate_place==""){ 
            // alert("กรุณาเลือกข้อมูล isolate_place_id(สถานที่ isolate)");
            // return;
            val_alert.push("isolate_place_id(สถานที่ isolate)");
        }

        // document.getElementById(idcard+"[epidem_lab_confirm_type_id]").value;
        var reason_type = document.getElementById(idcard+"[tests_reason_type_id]").value;
        if(reason_type==""){ 
            // alert("กรุณาเลือกข้อมูล tests_reason_type_id(เหตุผลการตรวจ)");
            // return;
            val_alert.push("tests_reason_type_id(เหตุผลการตรวจ)");
        }

        var res_alert = [];
        if(val_alert.length > 0){
            // res_alert.push(idcard);
            // console.log(res_alert.concat(val_alert));
            var res_alert = [idcard].concat(val_alert);
            // [idcard].concat(val_alert);

        }
        
        return res_alert;


    }


</script>