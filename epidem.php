<?php 
include 'config.php';
$dbi = new mysqli(HOST,USER,PASS,DB);
if($dbi->connect_errno){
    echo $dbi->connect_errno;
}
$dbi->query("SET NAMES UTF8");

if(empty($_SESSION['sIdname'])){

    ini_set('session.gc_maxlifetime', 60*60*24);
    $idname = $dbi->real_escape_string($_GET['idname']);
    $sql = "SELECT * FROM `inputm` WHERE `idname` = '$idname' AND `status` = 'y'";
    $q = $dbi->query($sql);
    if($q->num_rows > 0){ 
        $item = $q->fetch_assoc();
        $_SESSION['sIdname'] = $item['idname'];
        $_SESSION['sPword'] = $item['pword'];
        $_SESSION['smenucode'] = $item['menucode'];
        $_SESSION['sOfficer'] = $item['name'];
        $_SESSION['sRowid'] = $item['row_id'];
        $_SESSION['sLevel'] = $item['level'];
    }else{
        echo 'ไม่พบผู้ใช้งาน <a href="http://192.168.131.250/sm3/surasak3/login_page.php">กรุณาล็อคอินอีกครั้ง</a>';
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก EPI DEM</title>
</head>
<body>
    <style>
        *{
        font-family: "TH SarabunPSK";
        font-size: 18px;
    }
    #notify-ie{
        background-color: #ffff97;
        border: 2px solid #464600;
        padding: 4px;
        text-align: center;
    }
    </style>
    <div>
        <a href="epidem.php">ฟอร์ม EPIDEM ผู้ป่วยนอก</a> | <a href="epidem_ip.php">ฟอร์ม EPIDEM ผู้ป่วยใน</a>
    </div>
    <h3>ระบบส่งข้อมูลผู้มารับบริการ Covid-19 ผู้ป่วยนอก ผ่าน EPIDEM</h3>
    <form action="epidem_form.php" method="post" id="epidem_form">
        <div>
            <?php 
            $date_search = date('Y-m-d');
            ?>
            <b>เลือกวันที่ : </b><input type="text" name="date_search" id="date_search" value="<?=$date_search;?>"> 
            <br>
            <span>ตัวอย่างรูปแบบ ปี(ค.ศ.)-เดือน-วัน เช่น 2022-07-25</span>
        </div>
        <div>
            <button type="submit">ค้นหาข้อมูล</button>
        </div>
    </form>
    <script>
        if(/Trident\/|MSIE/.test(window.navigator.userAgent)){ 
            document.getElementById('epidem_form').appendChild(document.createElement("br"));
            const el = document.createElement("div");
            el.setAttribute("id","notify-ie");
            el.innerHTML = 'ไมโครซอฟหยุด Support Internet Explorer ตั้งแต่ 15 มิถุนายน 2022 เป็นต้นไป<br>ดาวโหลด/อัพเดท เป็น <a href="https://www.microsoft.com/th-th/edge?r=1">Microsoft Edge</a> ได้แล้ววันนี้';
            document.getElementById('epidem_form').appendChild(el);

        }
    </script>
</body>
</html>