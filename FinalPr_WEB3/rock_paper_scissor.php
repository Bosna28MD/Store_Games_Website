<?php  session_start();
    //$_SESSION['money']
    
    if( !isset($_SESSION['username'])){
        header("Location: ./log_in.php");
        exit();
    }
    require("mysql.php");
    //select_game($conexiune)['link_game'];
    if(select_game($conexiune)==null){   //If this game doesn't have a link in database
        header("Location: ./store.php");
        exit();
    }
    else{
        $row=select_game($conexiune);
        //check if you buy this game
        
        if( !checkValidTransaction($row['id_game'],$conexiune)  ){  //This user didn't buy this game
            header("Location: ./store.php");
            exit();
        }
    }
    
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

        

        #section_game{
            width: 90%;
            margin: auto;
            padding: 30px 0;
            margin-top: 20px;
            text-align: center;
            
        }


        #section_game #title_game{
            width: 50%;
            margin: auto;
            text-align: center;
            font-size: 33px;
            font-weight: bold;
        }


        #rock_paper_scissor_gm{
            width: 500px;
            margin: auto;
            border: 1px solid black;
            border-radius: 10px;
            background-color: grey;
            text-align: center;
            margin-top: 30px;
            padding: 130px 0;
        }

        .bt_choose{
            width: 150px;
            height: 40px;
            cursor: pointer;
            font-weight: bold;
            font-size: 22px;
        }

        .choose{
            font-size: 30px;
            margin: 20px 0;
        }

        #pl_{
            color: blue;
        }

        #cp_{
            color: red;
        }

        #men_log_in{ 
            display: <?php if( isset($_SESSION['username'])){ echo "none"; } else{ echo "flex"; } ?>;
        }

        #info_user, #men_log_out{
            display: <?php if( isset($_SESSION['username'])){ echo "block"; } else{ echo "none"; } ?>;
        }



    </style>
</head>
<body>

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

        <section id="section_game">
            <div id="title_game">Rock-Paper-Scissor Game:</div>
            <div id="rock_paper_scissor_gm">
                <div id="pl_" class="choose">Player</div>
                <div id="cp_" class="choose">Robot</div>
                <div id="rs_" class="choose">Result</div>
                <button id="bt_Rock" class="bt_choose">Rock</button>
                <button id="bt_Paper" class="bt_choose">Paper</button>
                <button id="bt_Scissor" class="bt_choose">Scissor</button>
            </div>
        </section>



    </div>

    <script>
        let bt_rock=document.getElementById("bt_Rock");
        let bt_paper=document.getElementById("bt_Paper");
        let bt_scissor=document.getElementById("bt_Scissor");

        let text_pl=document.getElementById("pl_");
        let text_cp_=document.getElementById("cp_");
        let text_rs_=document.getElementById("rs_");

        let choose_user;

        bt_rock.addEventListener("click",()=>{ //1
            let robot_nr=Math.floor((Math.random() * 3) + 1);
            choose_user=1; 
            let res_game=Result_Game(robot_nr,choose_user); 
            Result(res_game,robot_nr,choose_user); 
            //console.log(robot_nr);
        });


        bt_paper.addEventListener("click",()=>{ //1
            let robot_nr=Math.floor((Math.random() * 3) + 1);
            choose_user=2; 
            let res_game=Result_Game(robot_nr,choose_user); 
            Result(res_game,robot_nr,choose_user);
            //console.log(robot_nr);
        });


        bt_scissor.addEventListener("click",()=>{ //1
            let robot_nr=Math.floor((Math.random() * 3) + 1);
            choose_user=3; 
            let res_game=Result_Game(robot_nr,choose_user); 
            Result(res_game,robot_nr,choose_user);
            //console.log(robot_nr);
        });


        //1-Rock 2-Paper 3-Scissor
        function Result_Game(a,b){  // a-robot , b-user  
            if( (a==1 && b==2) || (a==2 && b==3) || (a==3 && b==1) ){
                return 1;
            }
            else if(a==b){
                return 0;
            }
            return -1;
        }

        function Number_to_String(nr){
            if(nr==1){
                return "Rock";
            }
            else if(nr==2){
                return "Paper";
            }
            return "Scissor";
        }



        function Result(res_game,a,b){
            if(res_game==1){
                text_pl.textContent="Player: "+Number_to_String(b);
                text_cp_.textContent="Robot: "+Number_to_String(a);
                text_rs_.textContent="You Win!!!";
            }
            else if(res_game==0){
                text_pl.textContent="Player: "+Number_to_String(b);
                text_cp_.textContent="Robot: "+Number_to_String(a);
                text_rs_.textContent="Draw";
            }
            else{
                text_pl.textContent="Player: "+Number_to_String(b);
                text_cp_.textContent="Robot: "+Number_to_String(a);
                text_rs_.textContent="You Loose :(";
            } 

        }


        //Phone Menu:
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

        return -1;
    }

    function select_game($conexiune){  
            $url=$_SERVER['REQUEST_URI'];                
            $var=explode("/",$url);
            $address_file=$var[count($var)-1]; //Link of this page
            $sql_select="select * from games_table_store where link_game='".$address_file."'";
            $table_sel=mysqli_query($conexiune,$sql_select)or die ('Eroare');

            if(mysqli_num_rows($table_sel)==1){
                return $row=mysqli_fetch_assoc($table_sel);
                /* while($row=mysqli_fetch_assoc($table_sel)){
                    //echo $row['id_game']." ".$row['name_game']." ".$row['link_game'];  //
                    return ;
                } */
            }

            return null;
            //echo "Nothing found";

            
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
?>