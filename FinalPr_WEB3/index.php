<?php  session_start();
    //$_SESSION['money']
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
    
        .info_home_center{
            width: 90%;
            margin: auto;
            /*border: 1px solid black;*/
            /*height: 50vh;*/
            margin-top: 20px;
            
        }

        .title_info{
            /*border: 1px solid black;*/
            width: 60%;
            margin: auto;
            text-align: center;
            font-size: 35px;
            font-style: border;
            margin-top: 20px;
            text-shadow: 0 0 3px #FF0000, 0 0 5px #0000FF;
        }

        /* #section_info{
            border: 1px solid black;
            width: 90%;
            margin: auto;
            margin-top: 20px;
            height: 30vh;
        }

        #info_title{
            border: 1px solid black;
            width: 90%;
            margin: auto;
            margin-top: 10px;
        } */

        #info_div{
            border: 1px solid black;
            width: 90%;
            margin: auto;
            margin-top: 10px;
            padding: 25px;
        }

        .img_section{
            border:2px solid red;
            width: 85%;
            margin: auto;
            height: 80vh;
            background-image: url(./img/play_a_game.png);
            background-size: cover;
            margin-top: 10px;
            border-radius:10px;
            
            
        }

        #img_id{
            
        }

        /* footer{
            width: 90%;
            margin: auto;
            margin-top: 40px;
            padding-bottom: 20px;
            
        }

        footer hr{
            width: 95%;
            margin:auto;
        }

        #footer_text{
            text-align: center;
            font-size: 18px;
            font-style:oblique;
        } */

        


        #men_log_in{ 
            display: <?php if( isset($_SESSION['username'])){ echo "none"; } else{ echo "flex"; } ?>;
        }

        #info_user, #men_log_out{
            display: <?php if( isset($_SESSION['username'])){ echo "block"; } else{ echo "none"; } ?>;
        }


    </style>
</head>
<body>

 <!-- <div class="men_mobil" id="mob_id" >
        <button class="bt_icon" onclick="myFunction_2()"><i class="fa-solid fa-xmark"></i></button>
        <ul>
            <li>Home</li>
            <li>Library</li>
            <li>Store</li>
            <li>Information</li>
        </ul>

    </div>  -->

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

        

        <section class="info_home_center">
            <div class="title_info">Welcome on EBGaMeS</div>
                <div class="img_section">
                    <!-- <img  src="./img/play_a_game.png" alt="No IMG" id="img_id"> -->
                </div>
        </section>


        <footer>
            <hr>
            <div id="footer_text">©2023. Design și implementare: Prenume Nume. Toate drepturile rezervate.</div>
        </footer>

    </div>

    <script>
        /* function myFunction_1(){
            var x = document.getElementById("container"); 
            var y = document.getElementById("mob_id");
            x.style.display = "none";
            y.style.display = "block";
          }


          function myFunction_2(){
            var x = document.getElementById("container"); 
            var y = document.getElementById("mob_id");//bt_icon
            x.style.display = "block";
            y.style.display = "none";
          } */
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
?>