<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- https://github.com/earthchie/JQL.js -->
    <!-- https://github.com/earthchie/jquery.Thailand.js/blob/master/jquery.Thailand.js/dependencies/JQL.min.js -->
    <script type="text/javascript" src="jql.min.js"></script>
    <script type="text/javascript" src="thailand_raw_database.json"></script>

</head>
<body>
    <input type="text" name="search" id="search">
    <div id="res"></div>
    <script>
    var data = new JQL(data);

    document.getElementById('search').onkeyup = function(){ 

        if(this.value.length < 3){
            return;
        }

        var res1 = data.select('*').where('district').contains(this.value).fetch();
        var res2 = data.select('*').where('amphoe').contains(this.value).fetch();
        // var res12 = res1.concat(res2);
        var res3 = data.select('*').where('province').contains(this.value).fetch();
        var res123 = res1.concat(res2,res3);

        var resTxt = '';
        for (let index = 0; index < res123.length; index++) {
            const element = res123[index];
            resTxt += element.district+' >> '+element.amphoe+' >> '+element.province+'<br>';
        }

        document.getElementById("res").innerHTML = resTxt;
        
    }
    </script>
</body>
</html>