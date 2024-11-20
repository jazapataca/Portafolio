<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_COOKIE["logged"])){
        echo $_COOKIE["logged"]."<br>";
    }else {
        //echo "You are not logged in";
        echo "no hay cookie";
    }
    if(!$_COOKIE["lenguage"]){
        header("location:pagina_inicio.html");
    }else if($_COOKIE["lenguage"]=="English"){
        header("location:begining_page.html");
    }

        
    ?>
</body>
</html>