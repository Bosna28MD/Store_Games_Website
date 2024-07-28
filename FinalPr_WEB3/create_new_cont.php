<?php session_start();
    if( isset($_SESSION['username'])){
        header("Location: ./index.php");
        exit();
    }
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
        
        #newcont_section{
            
            width: 90%;
            margin: auto;
            margin-top: 80px;
            height: 80vh;
        }

        #newcont_menu{
            width: 70%;
            margin: auto;
            height: 60vh;
            margin-top: 70px;
            margin-bottom:30px ;
            /*background-color:rgba(55, 110, 129, 0.266);*/
            background-color: rgba(128, 128, 128, 0.404);
        }

        #newcont_menu h2{
            text-align: center;
            font-size: 35px;
            color: black;
            height: 10%;
            padding: 30px 0;
        }

        #newcont_menu form{
            text-align: center;
            
            
        }

        .input_div{
            margin: 15px 0;
        }

        .input_div label{
            font-weight: bold;
            font-size: 19px;
        }

        .submit input{
            font-weight: bold;
            font-size: 19px;
            margin-left: 70px;
        }

        #name_imp{
            margin-left: 36px;
        }

        #age_imp{
            margin-left: 49px;
        }

        .input_user{
            width:  165px;
        }

        #error_text{
            text-align: center;
            color: red;
            font-weight: bold;
            font-size: 25px;
            margin-left: 70px;
            margin-top: 10px;
            
        }

        #success_log{
            text-align: center;
            color: rgb(11, 159, 11);
            font-weight: bold;
            font-size: 25px;
            margin-left: 70px;
            margin-top: 10px;
            
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


        <?php
        require("mysql.php");

        $error="none";
            if(isset($_POST['submit'])){

                if( $_POST['email']=="" || $_POST['pwd']=="" || $_POST['name']=="" || $_POST['age']=="" ){
                    //echo"<div>Fill all the fields</div> ";
                    $error="empty_fields";
                }
                else{
                    //if($error=="none"){ echo "error = none <br>"; }
                     //
                    $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_SPECIAL_CHARS);//$email=$_POST['email'];
                    $name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS);//$name=$_POST['name'];
                    $age=filter_input(INPUT_POST,'age',FILTER_SANITIZE_SPECIAL_CHARS);//$age=$_POST['age']; 
                    $pwd=filter_input(INPUT_POST,'pwd',FILTER_SANITIZE_SPECIAL_CHARS);//$pwd=$_POST['pwd'];
                    $sum_points=50;

                    $result=check_user_exist($conexiune,$email);
                    if($result==1){
                        if(PWD_Condition($pwd)==1){
                         $pwd_hash=password_hash($pwd,PASSWORD_DEFAULT);
                         $query_insert="INSERT into user_table(email,pwd,name_user,age,sum_points) values('$email','$pwd_hash','$name','$age',$sum_points)";
                         $rez_query_insert=mysqli_query($conexiune, $query_insert) or die ('Eroare');   
                         
                         if($rez_query_insert){
                            $error="success";
                            echo "<meta http-equiv=\"refresh\" content=\"3; URL='log_in.php'\" >";
                         }
                         else{
                            $error="error";
                         }

                        }
                        else{
                            $error="pwd_length";
                        }

                    }
                    else{
                        $error="user_exist";
                    }



                }
            }

            //echo $error;

        ?>


        <section id="newcont_section">
            <div id="newcont_menu">
                <h2>Create New Cont:</h2>
                <form action="" method="post">

                    <div class="input_div">
                        <label for="email">UserName:</label>
                        <input type="email" class="input_user" name="email" placeholder="Email">
                    </div>
        
                    <div class="input_div">
                            <label for="name" id="name_imp">Name:</label>
                            <input  type="text" class="input_user" name="name" placeholder="Name">
                    </div>
        
                    <div class="input_div" id="age_imp">
                            <label for="age">Age:</label>
                            <input type="number" class="input_user" min="1" max="100"   name="age" placeholder="Age">
                    </div>
                    
                    <div class="input_div">
                        <label for="pwd">Password:</label>
                        <input class="input_user" type="password" name="pwd" placeholder="Password">
                    </div>
                    
                    <div class="submit">
                        <input type="submit" name='submit'>
                    </div>

                </form>

                <?php
                    if($error=="success"){
                        /* echo "<div class='green_div_connection'>";
                            echo" Successfully Conection ";
                        echo "</div>"; */
                        echo "<div id='success_log'>Success Connection</div>";

                    }
                    else if( !($error=="none")  ){
                       echo "<div id='error_text'>"; 
                        if($error=="empty_fields"){
                            echo" Fill all the fields ";
                        }
                        else if($error=="user_exist"){
                            echo "Already exist this user";
                        }
                        else if($error=="pwd_length"){
                            echo "Few Characters Password(Min-8)";
                        }
                        else if($error=="error"){
                            echo "Some Error Appeared";
                        }
                       echo "</div>"; 
                    }
                ?>

                <!-- <div id="error_text">Incorrect Password</div>
                <div id="success_log">Success Connection</div> -->

            </div>

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


    function check_str($str1,$str2){
        $str1=strtolower($str1);
        $str2=strtolower($str2);         
            
        if($str1==$str2){
            return true;
        }
            return false;
    }

    function check_user_exist($conexiune,$str_check){
        $query="SELECT * from user_table";
        $rezultat = mysqli_query($conexiune, $query) or die ('Eroare');
        $flag=1;
        if (mysqli_num_rows($rezultat) > 0){
            while( $row=mysqli_fetch_assoc($rezultat) ){
                if( check_str( $str_check , $row['email'] ) ){
                    $flag=0;
                    break;
                }
            }
        }

        return $flag;
    }


    function PWD_Condition($pwd){
        $flag=1;
        if(strlen($pwd)<8){
            //$error="pwd_length";
            $flag=0;
        }
        return $flag;
    }



?>