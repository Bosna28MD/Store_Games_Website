<?php
$hostname = "localhost";
$username = "root"; //Set your resprective username from DB(by default is root)
$password = "";     //Set Password from DB of respective user
$bd = "final_project_web"; 

$conexiune = mysqli_connect($hostname,$username,$password)
or die ("Eroare! Functia apelata da eroare, este posbil ca cei 3 parametrii sa fie completati eronat!");

$baza_date = mysqli_select_db($conexiune,$bd)
or die ("Eroare! Numele aceste baze de date nu exista!");
?>
