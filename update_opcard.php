<?php 
require_once 'config.php';

$dbi = new mysqli(HOST,USER,PASS,DB);
if($dbi->connect_errno){
    echo $dbi->connect_errno;
}
$dbi->query("SET NAMES UTF8");

$action = $_POST['action'];
if($action === 'save')
{
    $idcard = $_POST['idcard'];
    $sql = sprintf("UPDATE `opcard` SET `address`='%s', `tambol`='%s', `ampur`='%s', `changwat`='%s' WHERE `idcard` = '%s' ", 
        $dbi->escape_string($_POST['address']),
        $dbi->escape_string($_POST['tambol']),
        $dbi->escape_string($_POST['ampur']),
        $dbi->escape_string($_POST['changwat']),
        $dbi->escape_string($idcard)
    );
    $update = $dbi->query($sql);
    if(!empty($dbi->error)){
        echo $dbi->error;
        exit;
    }
    $_SESSION['x_msg'] = 'บันทึกข้อมูลเรียบร้อย';
    header("Location: update_opcard.php?idcard=".$idcard);
    exit;
}

$sql = sprintf("SELECT `idcard`,`address`,`tambol`,`ampur`,`changwat`,CONCAT(`yot`,`name`,' ',`surname`) AS `ptname` FROM `opcard` WHERE `idcard` = '%s' ", $dbi->escape_string($_REQUEST['idcard']));
$q = $dbi->query($sql);
if($q->num_rows > 0)
{
    $u = $q->fetch_assoc();
    $idcard = $u['idcard'];
    $ptname = $u['ptname'];
    $address = $u['address'];
    $tambol = $u['tambol'];
    $ampur = $u['ampur'];
    $changwat = $u['changwat'];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลที่อยู่</title>

    <script type="text/javascript" src="jql.min.js"></script>
    <script type="text/javascript" src="thailand_raw_database.json"></script>

</head>
<body>
    <style>
        *{
            font-family: "TH SarabunPSK";
            font-size: 18px;
        }
        li{
            list-style-type: none;
        }
        li:hover{
            background-color: #b8b8b8;
            cursor: pointer;
        }
        #res{
            width:400px;
        }
    </style>
    <?php 
    if(!empty($_SESSION['x_msg'])){
        ?>
        <p style="border: 2px solid #c7c700;padding: 4px 16px;width: fit-content;background-color: lightyellow;"><?=$_SESSION['x_msg'];?></p>
        <?php
        unset($_SESSION['x_msg']);
    }
    ?>
    <form action="update_opcard.php" method="POST">
        <div>
            <table>
                <tr>
                    <td colspan="2">
                        <b>แก้ไขที่อยู่ <?=$ptname;?> บัตรปชช <?=$idcard;?></b>
                    </td>
                </tr>
                <tr>
                    <td>เลขที่บ้าน</td>
                    <td><input type="text" name="address" id="address" value="<?=$address;?>"></td>
                </tr>
                <tr>
                    <td>ตำบล</td>
                    <td><input type="text" name="tambol" id="tambol" value="<?=$tambol;?>"></td>
                </tr>
                <tr>
                    <td>อำเภอ</td>
                    <td><input type="text" name="ampur" id="ampur" value="<?=$ampur;?>"></td>
                </tr>
                <tr>
                    <td>จังหวัด</td>
                    <td><input type="text" name="changwat" id="changwat" value="<?=$changwat;?>"></td>
                </tr>
            </table>
        </div>
        <div>
            <button type="submit">บันทึกข้อมูล</button>
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="idcard" value="<?=$idcard;?>">
        </div>
    </form>

    <div>
        <h3 style="font-size: 24px;">ค้นหาชื่อตำบล อำเภอ จังหวัด</h3>
        <input type="text" name="search" id="search">
        <div id="res"></div>
    </div>
    <script>
    var data = new JQL(data);
    document.getElementById('search').onkeyup = function(){ 

        if(this.value.length < 3){
            return;
        }

        document.getElementById('res').style.display = '';

        var res1 = data.select('*').where('district').contains(this.value).fetch();
        var res2 = data.select('*').where('amphoe').contains(this.value).fetch();
        var res3 = data.select('*').where('province').contains(this.value).fetch();
        var res123 = res1.concat(res2,res3);

        var resTxt = '<ul>';
        for (let index = 0; index < res123.length; index++) {
            const element = res123[index];
            resTxt += '<li onclick="setupData(\''+element.district+'\',\''+element.amphoe+'\',\''+element.province+'\')">ต.'+element.district+' >> อ.'+element.amphoe+' >> จ.'+element.province+'</li>';
        }
        resTxt += '</ul>';

        document.getElementById("res").innerHTML = resTxt;
        
    }

    function setupData(district,amphoe,province){
        document.getElementById('tambol').value=district;
        document.getElementById('ampur').value=amphoe;
        document.getElementById('changwat').value=province;

        document.getElementById('res').style.display = 'none';
        document.getElementById('search').value = '';
        
    }
    </script>
</body>
</html>
<?php 
}