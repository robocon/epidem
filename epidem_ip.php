<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <h3>ระบบส่งข้อมูลผู้มารับบริการ Covid-19 ผู้ป่วยใน ผ่าน EPIDEM</h3>
    <form action="epidem_ip_form.php" method="post" id="epidem_form">
        <div>
            <?php 
            $date_search = date('Y-m');
            ?>
            <b>เลือกเดือน : </b><input type="text" name="date_search" id="date_search" value="<?=$date_search;?>"> 
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