<?php
    session_start();
    require("../mysql.php");
    $points=$_POST['points_sc'];
    $sql_insert="insert into tabel_snakegame(user_email,name_user,points) values('".$_SESSION['username']."','".$_SESSION['name']."',$points);";
    mysqli_query($conexiune, $sql_insert) or die ('Eroare');
?>

