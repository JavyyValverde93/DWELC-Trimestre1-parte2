<?php
session_start();
if(isset($_POST['enviar'])){
    header('Location:indefx.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form name="cm" method="POST" enctype="multipart/form-data" action='<?php echo $_SERVER['PHP_SELF']."?usuario=$usuario"."?contrasenia=$constrasenia" ?>'>
        <input name="usuario" type="text" placeholder="User" size=20 max=20>
        <input name="contrasenia" type="password" placeholder="Passwd" size=20 max=20>
    </form>
    <button type="submit" value="enviar">Entrar</button>

    
</body>
</html>