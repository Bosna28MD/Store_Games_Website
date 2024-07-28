<?php session_start();
    if( !isset($_SESSION['username'])){
        header("Location: ./log_in.php");
        exit();
    }

    require("mysql.php");
    if( isset($_SESSION['username'])){ $row=get_Money($conexiune); $_SESSION['money']=$row['sum_points']; } 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/_header.css">
    <script src="mobile.js"></script>
</head>

    <style>
        #men_log_in{
            display: none;
        }

        #info_user, #men_log_out{
            display: block;
        }

        #section_container{ 
            width: 90%;
            margin: auto;
            margin-top: 30px;
            background-color: rgba(93, 179, 133, 0.477);
            
        }

        #section_container h2{
            text-align: center;
            font-size: 40px;
            text-shadow: 0 0 3px #FF0000, 0 0 5px #0000FF;
            color: aliceblue;
            
        }

        #content_games{
            width: 100%;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            padding: 8px;
            /*display: none;*/
            
            
        }

        .box_section{
            height: 50vh;
            width: 32%;
            border: 3px solid gray;
            margin: 2px;
        }

        .img_box{
            border: 1px solid black;
            height: 85%;
        }
        .img_box img{
            height: 100%;
            width: 100%;
        }
        /*.buy_box{
            border: 1px solid #09e309;
            width: 50%;
            margin: auto;
            margin-top: 3px;
            height: 8%;
            background-color:#09e309 ;
            color: white;
            text-align: center;
            padding: 5px 0;
        }*/

        /*.buy_box{
            border: 1px solid #3e453e;
            color: black;
            background-color: greenyellow;
            width: 40%;
            height: 10%;
            margin: 3px 95px;
            font-weight: bold;
        }*/

        .sec_buy{
            display: flex;
            justify-content: space-between;
            width: 98%;
            
            margin: auto;
            margin-top: 3px;
        }

        .sec_buy .sec_price{
            font-weight: bold;
            font-size: 17px;
        }

        .sec_buy .buy_box{
            border: 1px solid #3e453e;
            background-color: greenyellow;
            font-weight: bold;
            width: 120px;
            height: 30px;
            font-size: 20px;
        }

        .buy_box a{
            text-decoration: none;
        }

        #empty_store{
            font-weight: bold;
            font-size: 50px;
            padding: 40vh 0;
            text-align: center ;
            
        }

        .box_section #insf_money{
            text-align: center;
            color: #FF0000;
            font-weight: bold;
        }


    </style>

<body>

        <?php
            /*if(isset($_GET['id_db'])){ //delete games_table_store,insert games_table_library
                $sql_table_games="Select * from games_table_store where id_game=".$_GET['id_db'];
                $tabel_rez=mysqli_query($conexiune, $sql_table_games) or die ('Eroare');
        
                if(mysqli_num_rows($tabel_rez)==1){
                    $row_store=mysqli_fetch_assoc($tabel_rez);
                    
                    //Insert into games_table_library
                    $sql_insert="insert into games_table_library(name_game,price_sell,img_game) values('".$row_store['name_game']."',".$row_store['price'].",'".$row_store['img_game']."') ";
                    $insert_tabel_library=mysqli_query($conexiune, $sql_insert) or die ('Eroare');

                    //Delete row:
                    $sql_delete="Delete from games_table_store "

                }

        
            }*/

            if(isset($_GET['id_db'])){
                $sql_table_games="Select * from games_table_store where id_game=".$_GET['id_db']; ////check if game exist
                $tabel_rez=mysqli_query($conexiune, $sql_table_games) or die ('Eroare'); 

                

                if(mysqli_num_rows($tabel_rez)==1){
                    $row_store=mysqli_fetch_assoc($tabel_rez);
                    $result_buy=0;
                    if( ($_SESSION['money']-$row_store['price'] )>=0 ){ $result_buy=1; }
                    //echo ($_SESSION['money']-$row_store['price'] )>0 ;
                    if(!checkValidTransaction($_GET['id_db'],$conexiune) && ($_SESSION['money']-$row_store['price'] )>=0  ){
                        //echo "User already buyed this game";

                        $sql_update="update user_table set sum_points=".($_SESSION['money']-$row_store['price'])." where email='".$_SESSION['username']."'";
                        mysqli_query($conexiune,$sql_update) or die ('Eroare');
                        $_SESSION['money']=$_SESSION['money']-$row_store['price'];
                        //echo ($_SESSION['money']-$row_store['price'])." You can Buy..";
                        $sql_insert="Insert into tanzactie_table(id_game,email,type_tranzac,sum_tranzac) values(".$_GET['id_db'].",'".$_SESSION['username']."','Game_Buy',".$row_store['price'].")";
                        mysqli_query($conexiune, $sql_insert) or die ('Eroare');
                        echo "<meta http-equiv=\"refresh\" content=\"0.5; URL='store.php'\" >";
                    }
                     /* else{
                        echo ($_SESSION['money']-$row_store['price'])." You can't Buy..";
                    } */ 
                    /* else{
                        //checkValidTransaction($_GET['id_db'],$conexiune);



                        
                        //echo "Succes";
                    } */
                    //Insert:
                    /* $sql_insert_tranzac="Insert into tanzactie_table(email,type_tranzac,name_game,img) values('".$_SESSION['username']."','Buy_Game','".$row_store['name_game']."','".$row_store['img_game']."')"; */

                    

                }



            }


            



        ?>


    <div class="men_mobil" id="mob_id" >
        <button class="bt_icon" onclick="myFunction_2()"><i class="fa-solid fa-xmark"></i></button>
        <ul>
            <?php if( isset($_SESSION['username'])){ echo "<li id='men_mob_name'>Name:".$_SESSION['name']." Money: ".$_SESSION['money']."$ </li>";  }  ?>
            <li><a href="./index.php">Home</a> </li>
            <?php if( isset($_SESSION['username'])){ echo "<li><a href='library.php'>Library</a></li> "; } ?>
            <li><a href="./store.php">Store</a> </li>
            <li><a href="./info.php">Information</a> </li>
            <?php if( !isset($_SESSION['username'])){ echo "<li><a href='./log_in.php'>Log In</a></li>"; } ?> 
            <?php if( !isset($_SESSION['username'])){ echo "<li><a href='./create_new_cont.php'>Sign up</a></li>"; } ?>
            <?php if( isset($_SESSION['username'])){ echo "<li><a href='./log_out.php'>Log Out</a></li> "; } ?>
            
        </ul>

    </div>



    <div id="container">

    <header>
            
            <nav>
             <img src="./img/eb_logo.png"  alt="" id="img_phone" class="logo_images"> 
                <div class="men_div" id="div_men1">
                    <img src="./img/eb_logo.png" class="logo_images" id="img_logo" alt="">

                    <ul id="men_1">
                        <li><a href="./index.php">Home</a> </li>
                        <?php if( isset($_SESSION['username'])){ echo "<li><a href='library.php'>Library</a></li> "; } ?>
                         <!-- <li><a href="#">Library</a></li> -->
                        <li><a href="./store.php">Store</a></li> 
                        <li><a href="./info.php">Information</a></li>
                    </ul>

                </div>

                <div class="men_div" id="div_men2" >
                    <div id="info_user"  >
                        <div>Name: <?php if( isset($_SESSION['username'])){ echo $_SESSION['name']; }  ?></div>
                        <div>Money: <?php if(isset($_SESSION['money'])){ echo $_SESSION['money']; } ?>$ </div>
                        <div id="timer">01:00</div>
                        <button id="take_money">Take 1$</button>
                    </div>

                    <ul id="men_log_out"   >
                        <li> <a href="./log_out.php">Log Out</a> </li>
                    </ul>
    
                    <ul id="men_log_in">
                        <li> <a href="./log_in.php">Log In</a> </li>  <!-- <li>Log Out</li> --> 
                         <li><a href="./create_new_cont.php">Sign up</a> </li> 
                    </ul>

                </div>

                <button class="hmbg_button" id="btn_phone" onclick="myFunction_1()"><img src="./img/hamburger_logo.png" alt="" ></button>

                
            </nav>

            

        </header>


        <section id="section_container">
            <h2>Store</h2>
            
              <!-- <div id="content_games">  -->
                <?php

                    if(!check_AllValidation($conexiune)){
                        echo "<div id='content_games'>";
                        //echo "<div id='content_games>";
                        $sql_table_games="Select * from games_table_store";
                        $tabel_rez=mysqli_query($conexiune, $sql_table_games) or die ('Eroare');

                        if(mysqli_num_rows($tabel_rez)>0){
                            echo "<div id='content_games'>";
                            while($row=mysqli_fetch_assoc($tabel_rez)){
                                if( checkValidTransaction($row['id_game'],$conexiune) ){ continue; }

                                echo "<div class='box_section'>";
                                echo "<div class='img_box'><img src='".$row['img_game']."' alt=''></div>";
                                echo " <div class='sec_buy'>";
                                    echo "<div class='sec_price'>Name: ".$row['name_game']."</div>";
                                    echo "<button class='buy_box'><a href='store.php?id_db=".$row['id_game']."'>Buy ".$row['price']."$</a></button>";
                                echo "</div>";
                                if(($_SESSION['money']-$row['price'] )<0 && isset($_GET['id_db']) &&  $_GET['id_db']==$row['id_game'] ){ //
                                    echo "<div id='insf_money'>Not enough Money</div>"; 
                                }    
                                echo "</div>";
                            }
                            echo "</div>";
                            
                        }

                        //echo "</div> ";
                    }
                    else{
                        echo "<div id='empty_store'>You bought all games</div>";
                    }
                     
                ?>

                <!-- <div class="box_section">
                    <div class="img_box"><img src="./img/tic_tac_toe_img.png" alt=""></div>
                    <div class="sec_buy">
                        <div class="sec_price">Name: Tic-Tac-Toe</div>
                        <button class="buy_box"><a href="#">Buy 0$</a></button>
                    </div>
                    
                </div>

                <div class="box_section">
                    <div class="img_box"><img src="./img/rock_paper_scissors_img.jpg" alt=""></div>
                    <div class="sec_buy">
                        <div class="sec_price">Name: Rock-Paper-Scissors</div>
                        <button class="buy_box"><a href="#">Buy 0$</a></button>
                    </div>
                    
                </div>

                <div class="box_section">
                    <div class="img_box"><img src="./img/dinosaur_game.jpg" alt=""></div>
                    <div class="sec_buy">
                        <div class="sec_price">Name: Dinosaur</div>
                        <button class="buy_box"><a href="#">Buy 15$</a></button>
                    </div>
                    
                </div>

                <div class="box_section">
                    <div class="img_box"><img src="./img/snake_img_game.jpg" alt=""></div>
                    <div class="sec_buy">
                        <div class="sec_price">Name: Snake</div>
                        <button class="buy_box"><a href="#">Buy 50$</a></button>
                    </div>
                    
                </div>

                <div class="box_section">
                    <div class="img_box"><img src="./img/ping_pong_game_img.png" alt=""></div>
                    <div class="sec_buy">
                        <div class="sec_price">Name: Ping-Pong</div>
                        <button class="buy_box"><a href="#">Buy 45$</a></button>
                    </div>
                    
                </div> --> 



                

            <!-- </div> -->
             

        </section>


        <footer>
            <hr>
            <div id="footer_text">©2023. Design și implementare: Prenume Nume. Toate drepturile rezervate.</div>
        </footer>



    </div>



    <script>
        /*function myFunction_1(){
            //let y=document.getElementsByClassName("men_mobil");
            var x = document.getElementById("container"); 
            var y = document.getElementById("mob_id");
            //var elements = document.getElementsByTagName("*");
            x.style.display = "none";
            y.style.display = "block";
            
          }


          function myFunction_2(){
            var x = document.getElementById("container"); 
            var y = document.getElementById("mob_id");//bt_icon
            x.style.display = "block";
            y.style.display = "none";
          }*/
    </script>



</body>
</html>

<?php
    function get_Money($conexiune){
        $sql_money="SELECT  * from user_table where email='".$_SESSION['username']."'";
        $rezult=mysqli_query($conexiune, $sql_money);

        if(mysqli_num_rows($rezult)==1){
            return $row=mysqli_fetch_assoc($rezult); 
        }
    }

    /* function buy_game($email,$name,$img,$conexiune){
        $sql_insert="Insert into tanzactie_table(email,type_tranzac,name_game,img) values($email,'Buy_Game','$name','$img')";
        $rezult_insert=mysqli_query($conexiune, $sql_insert)  or die ('Eroare');

    } */


    function checkValidTransaction($id_game,$conexiune){
        $sql_select="Select * from tanzactie_table where id_game=".$id_game." AND email='".$_SESSION['username']."' AND number_check=1";
        $table_tranzac=mysqli_query($conexiune, $sql_select) or die ('Eroare');
        //$flag=0; //
        if(mysqli_num_rows($table_tranzac)>0){
            return 1;
        }
        return 0;

    }

    function check_AllValidation($conexiune){
        
        $sql_table_games="Select * from games_table_store";
        $tabel_rez=mysqli_query($conexiune, $sql_table_games) or die ('Eroare');
        $flag=1; //All 1
        if(mysqli_num_rows($tabel_rez)>0){
            while($row=mysqli_fetch_assoc($tabel_rez)){
                if(checkValidTransaction($row['id_game'],$conexiune) ){ continue; }
                else{ $flag=0; break; }
            }
        }

        return $flag; //All are 

    }




?>