<?php
    session_start();
    require("../mysql.php");
    if( check_Empty_Table($conexiune) ){
        echo "<div id='empty_score'>Empty</div>";
    }
    else{
        $sql_select="SELECT * FROM final_project_web.tabel_snakegame order by points desc limit 10;";
        $tabel_leaderBoard=mysqli_query($conexiune, $sql_select) or die ('Eroare');
        if(mysqli_num_rows($tabel_leaderBoard)>0){
            $i=1;
            while($row=mysqli_fetch_assoc($tabel_leaderBoard)){
                echo "<div id='user_score'>Number-$i: Name:".$row['name_user']." Score:".$row['points']." </div>";
                $i++;
            }
        }

    }
    //$points=$_POST['points_sc'];
    //$sql_insert="insert into tabel_snakegame(user_email,name_user,points) values('".$_SESSION['username']."','".$_SESSION['name']."',$points);";
    //mysqli_query($conexiune, $sql_insert) or die ('Eroare');





    function check_Empty_Table($conexiune){
        $sql_select="SELECT * FROM final_project_web.tabel_snakegame";
        $table_snake=mysqli_query($conexiune, $sql_select) or die ('Eroare');
        if(mysqli_num_rows($table_snake)>0){
            return 0; //
        }
        return 1;

    }

?>



