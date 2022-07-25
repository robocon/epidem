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
    </style>
    <h3>ระบบส่งข้อมูลผู้มารับบริการ Covid-19 ผ่าน EPIDEM</h3>
    <form action="epidem_form.php" method="post">
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
</body>
</html>