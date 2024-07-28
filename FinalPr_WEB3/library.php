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
    
    <style>
        #men_log_in{
            display: none;
        }

        #info_user, #men_log_out{
            display: block;
        }

        #section_library{
            width: 90%;
            margin: auto;
            margin-top: 30px;
            background-color: rgba(93, 179, 133, 0.477);

        }



        #section_library h2{
            text-align: center;
            font-size: 40px;
            text-shadow: 0 0 3px #FF0000, 0 0 5px #0000FF;
            color: aliceblue;
        }

        #empty_lib{
            font-weight: bold;
            font-size: 50px;
            padding: 40vh 0;
            text-align: center ;
            
            
        }

        #library_boxes{
            border: 1px solid black;
            width: 100%;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            
        }

        .box_library{
            height: 50vh;
            width: 32.5%;
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

        .section_play{
            height: 8%;
            margin: 3px;
            display: flex;
            justify-content: space-between;
        }

        .btn_{
            width: 40%;
            height: 100%;
            color: white;
        }

        .btn_ a{
            text-decoration: none;
            color:black;
        }

        #btn_sell{
            background-color: #ff0000ba;
            font-weight: bold;
            font-size: 16px;
        }

        #btn_play{
            background-color: green;
            font-weight: bold;
            font-size: 16px;
        }

    </style>

</head>
<body>
    

        <?php
            if(isset($_GET['id_db'])){ //Sell Game
                $sql_select="Select * from tanzactie_table where id_game=".$_GET['id_db']." AND email='".$_SESSION['username']."' AND number_check=1";
                $tabel_tranz=mysqli_query($conexiune, $sql_select) or die ('Eroare');
                if(mysqli_num_rows($tabel_tranz)==1){
                    //$sql_table_games="Select * from games_table_store where id_game=".$_GET['id_db'];
                    //$tabel_rez=mysqli_query($conexiune, $sql_table_games) or die ('Eroare');
                    //$row_store=mysqli_fetch_assoc($tabel_rez);
                    $row=mysqli_fetch_assoc($tabel_tranz);
                    
                    $insert_sell="Insert into tanzactie_table(id_game,email,type_tranzac,sum_tranzac,number_check) values(".$_GET['id_db'].",'".$_SESSION['username']."','Game_Sell',".$row['sum_tranzac'].",-1)";
                    $tabel_rez=mysqli_query($conexiune, $insert_sell) or die ('Eroare');

                    $sql_update_money_user="update user_table set sum_points=".($_SESSION['money']+$row['sum_tranzac'])." where email='".$_SESSION['username']."'";
                    mysqli_query($conexiune,$sql_update_money_user) or die ('Eroare');

                    $_SESSION['money']=$_SESSION['money']+$row['sum_tranzac'];

                    $update_sell="update tanzactie_table set number_check=-1 where id_tranzactie=".$row['id_tranzactie'];
                    $tabel_rez=mysqli_query($conexiune, $update_sell) or die ('Eroare');

                    //echo "<meta http-equiv=\"refresh\" content=\"0.5; URL='library.php'\" >";
                }

            }


             /* function checkValidTransaction($id_game,$conexiune){
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
                        if(!checkValidTransaction($row['id_game'],$conexiune) ){ continue; }
                        else{ $flag=0; break; }
                    }
                }

                return $flag; //All are 

            } */



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

        <section id="section_library">
            <h2>Library</h2>
             <!-- <div id="library_boxes"> -->
                <?php
                    if(check_AllValidation($conexiune)){
                        echo "<div id='empty_lib'>You haven't bought any Games</div>";
                    }
                    else{

                    $sql_table_games="Select * from games_table_store";
                    $tabel_rez=mysqli_query($conexiune, $sql_table_games) or die ('Eroare');

                    if(mysqli_num_rows($tabel_rez)>0){
                        echo "<div id='library_boxes'>";
                        while($row=mysqli_fetch_assoc($tabel_rez)){
                            if(checkValidTransaction($row['id_game'],$conexiune)){ 
                            echo "<div class='box_library'>";
                            echo " <div class='img_box'> <img src='".$row['img_game']."' alt=''> </div>";
                            echo "<div class='section_play'>";
                                echo "<button class='btn_' id='btn_sell' ><a href='library.php?id_db=".$row['id_game']."'>Sell ".$row['price']."$</a></button>
                                <button class='btn_' id='btn_play'> <a href='".$row['link_game']."'>Play Game</a></button>";
                            echo "</div>";
                            echo "</div>";
                            }
                            
                        }
                        echo "</div>";
                    }
                        
                    }

                    

                ?>
                
                    
                <!-- <div class="box_library">
                    <div class="img_box"> <img src="./img/tic_tac_toe_img.png" alt=""> </div>
                    <div class="section_play">
                        <button class="btn_" id="btn_sell" >Sell 10$</button>
                        <button class="btn_" id="btn_play">Play Game</button>
                    </div>
                </div>
                    
                
                <div class="box_library">
                    <div class="img_box"></div>
                    <div class="section_play">
                        <button class="btn_" id="btn_sell" >Sell 10$</button>
                        <button class="btn_" id="btn_play">Play Game</button>
                    </div>
                </div>


                <div class="box_library">
                    <div class="img_box"></div>
                    <div class="section_play">
                        <button class="btn_" id="btn_sell" >Sell 10$</button>
                        <button class="btn_" id="btn_play">Play Game</button>
                    </div>
                </div>


                <div class="box_library">
                    <div class="img_box"></div>
                    <div class="section_play">
                        <button class="btn_" id="btn_sell" >Sell 10$</button>
                        <button class="btn_" id="btn_play">Play Game</button>
                    </div>
                </div>


                <div class="box_library">
                    <div class="img_box"></div>
                    <div class="section_play">
                        <button class="btn_" id="btn_sell" >Sell 10$</button>
                        <button class="btn_" id="btn_play">Play Game</button>
                    </div>
                </div> -->


            <!-- </div>  -->
            <!-- <div id="empty_lib">You haven't bought any Games</div> -->
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
                if(!checkValidTransaction($row['id_game'],$conexiune) ){ continue; }
                else{ $flag=0; break; }
            }
        }

        return $flag; //All are 

    }



?>