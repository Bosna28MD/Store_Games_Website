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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
        crossorigin="anonymous"></script>
        <script src="mobile.js"></script>

    <style>

        #section_game{
            width: 90%;
            margin: auto;
            padding: 30px 0;
            
            margin-top: 20px;
        }

        #section_game #title_game{
            width: 50%;
            margin: auto;
            
            text-align: center;
            font-size: 33px;
            font-weight: bold;

        }


        #snake_game{
            width: 70%;
            margin: auto;
            
            
            margin-top: 20px;
            text-align: center;
        }

        #canvas_snake{
            border: 2px solid black;
            margin: 20px 0;
        }

        #score{
            font-weight: bold;
            font-size: 25px;
        }

        #reset_btn{
            font-weight: bold;
            font-size: 22px;
            margin-top: 5px;
        }

        #btn_start{
            font-weight: bold;
            font-size: 22px;
        }


        #men_log_in{ 
            display: <?php if( isset($_SESSION['username'])){ echo "none"; } else{ echo "flex"; } ?>;
        }

        #info_user, #men_log_out{
            display: <?php if( isset($_SESSION['username'])){ echo "block"; } else{ echo "none"; } ?>;
        }


        #top_score{
            width: 40%;
            
            margin:70px auto;
            
        }

        #top_score_title{
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
            

        }

        #section_score{
            width: 90%;
            margin: 30px auto;
            border: 1px solid black;
            height: 54vh;
        }

        #user_score{
            text-align: center;
            width: 80%;
            margin: 11px auto;
            padding: 3px;
            font-size: 18px;
            font-weight: bold;
            font-style: italic;
        }

        #empty_score{
            text-align: center;
            /*border: 1px solid black;*/
            margin: 40% 0;
            font-size: 40px;
            font-weight: bold;

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
            <div id="title_game">Snake Game:</div>
            <div id="snake_game">
                <canvas width="400" height="400" id="canvas_snake"></canvas>
                <div id="score">0</div>
                <button id="reset_btn">Reset</button>
                <button id="btn_start" onclick="btn_start_pause_fnc()">Start/Pause</button>

            </div>

        </section> 


        <section id="top_score">
            <div id="top_score_title">Top 10 Users High Score:</div>
            <div id="section_score">
                <!-- <div id="user_score">Number-1: Lorem ipsum dolor sit. </div>
                <div id="user_score">Number-1: Lorem ipsum dolor sit. </div>
                <div id="user_score">Number-1: Lorem ipsum dolor sit. </div> -->
                <!-- <div id="empty_score">Empty</div> --> 
                <?php
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


                ?>


            </div>

        </section>

        <div id="exp_load" ></div>


        <script>
            window.onkeydown = function(event){ //when i click space to not click the buttons
                if(event.keyCode === 32 || event.keyCode === 38 || event.keyCode === 40 ) {
                    event.preventDefault();
                }
                //console.log(event.keyCode);
            };



            let gameBoard=document.getElementById("canvas_snake");
            let ctx=gameBoard.getContext("2d");
            let score_text=document.getElementById("score");
            let reset_btn=document.getElementById("reset_btn");
            let btn_start=document.getElementById("btn_start");

            let gameWidth=gameBoard.width;
            let gameHeight=gameBoard.height;
            let boardBackGround="white";
            let snakeColor="lightgreen";
            let snakeBorder="black";
            let foodColor="red";
            let unitSize=25;
            let running=false;
            let xVelocity=unitSize;
            let yVelocity=0;
            let foodX;
            let foodY;
            let score=0;
            //console.log(gameWidth,gameHeight); 400 400
            

            /*let snake=[
                        {x:unitSize*4,y:0},
                        {x:unitSize*3,y:0},
                        {x:unitSize*2,y:0},
                        {x:unitSize*1,y:0},
                        {x:0,y:0}  
                    ];*/


            let snake = [
            /*{x:unitSize * 15, y:0},
            {x:unitSize * 14, y:0},
            {x:unitSize * 13, y:0},
            {x:unitSize * 12, y:0},
            {x:unitSize * 11, y:0},
            {x:unitSize * 10, y:0},
            {x:unitSize * 9, y:0},
            {x:unitSize * 8, y:0},
            {x:unitSize * 7, y:0},
            {x:unitSize * 6, y:0},
                    {x:unitSize * 5, y:0},
                    {x:unitSize * 4, y:0},
                    {x:unitSize * 3, y:0},
                    {x:unitSize * 2, y:0},*/
                    {x:unitSize, y:0},
                    {x:0, y:0}
                ];        

            let action="start";

            //window.addEventListener("keydown",changeDirection_fnc);
            reset_btn.addEventListener("click",reset_Game_fnc);
            
            //gameStart();
            let check_var=1; //For the first call of the function gameStart() until it's a loose
            let loose=false;



            function btn_start_pause_fnc(){
                gameStart();
            }


            function gameStart(){
                if(action=="start" && !loose){
                    action="pause";
                    running=true;
                    score_text.textContent=score;
                    //createFood();
                    if(check_var){createFood(); check_var=0; }
                    drawFood(); 
                    nextTick();
                }else if(action=="pause" && !loose){
                    action="start";
                    //running=true;
                    score_text.textContent=score;
                    nextTick();
                }
                    
            };
            obj={
                a:null
            };
            
            function nextTick(){
                window.addEventListener("keydown",changeDirection_fnc);
                if(running && action=="pause"){  //start game
                    let t=setTimeout(()=>{
                        if(snake.length==(16*16) ){ finishGame(); running=false;   return;}
                        clearBoard();
                        drawFood();
                        moveSnake();
                        drawSnake();
                        checkGameOver();
                        nextTick();
                    },125);
                    obj.a=t; 
                    //console.log("start tick");
                }else if(running && action=="start"){ //pause game
                    drawFood();
                    drawSnake();
                    display_Pause();
                    //console.log("pause tick");
                }
                else{
                    displayGameOver();
                    Insert_Result_DB();
                    Update_LeaderBoard();
                }
            };

            function finishGame(){
                ctx.font="50px MV Boli";
                ctx.fillStyle="black";
                ctx.textAlign="center";
                ctx.fillText("You have passed GoD Level",gameWidth/2,gameHeight/2);
            }

            function clearBoard(){
                ctx.fillStyle=boardBackGround;
                ctx.fillRect(0,0,gameWidth,gameHeight);
            };
            function createFood(){
                function randomFood(min, max){
                    const randNum = Math.round((Math.random() * (max - min) + min) / unitSize) * unitSize;
                    return randNum;
                }
                foodX = randomFood(0, gameWidth - unitSize);
                foodY = randomFood(0, gameWidth - unitSize);

            };
            function drawFood(){
                ctx.fillStyle=foodColor;
                ctx.fillRect(foodX,foodY,unitSize,unitSize);
            };
            function moveSnake(){
                const head={x:snake[0].x+xVelocity,
                    y:snake[0].y+yVelocity}
                snake.unshift(head); 

                if(snake[0].x==foodX && snake[0].y==foodY){
                    score++;
                    score_text.textContent=score;
                    createFood();
                }else{
                    snake.pop();
                }
            };
            function drawSnake(){
                ctx.fillStyle=snakeColor;
                ctx.strokeStyle=snakeBorder; //used for border of the snake
                snake.forEach(snakePart=>{
                    ctx.fillRect(snakePart.x,snakePart.y,unitSize,unitSize);
                    ctx.strokeRect(snakePart.x,snakePart.y,unitSize,unitSize);
                });
            };
            function changeDirection_fnc(event){
                const keyPressed=event.keyCode;
                //console.log(keyPressed);
                const LEFT=37;
                const RIGHT=39;
                const UP=38;
                const DOWN=40;

                const goingUp=(yVelocity==-unitSize);
                const goingDown=(yVelocity==unitSize);
                const goingRight=(xVelocity==unitSize);
                const goingLeft=(xVelocity==-unitSize);

                switch(true){
                    case(keyPressed==LEFT && !goingRight):
                        xVelocity=-unitSize;
                        yVelocity=0;
                    break;

                    case(keyPressed==UP && !goingDown):
                        xVelocity=0;
                        yVelocity=-unitSize;
                    break;

                    case(keyPressed==RIGHT && !goingLeft):
                        xVelocity=unitSize;
                        yVelocity=0;
                    break;

                    case(keyPressed==DOWN && !goingUp):
                        xVelocity=0;
                        yVelocity=unitSize;
                    break;
                }
            };
            function checkGameOver(){
                switch(true){
                    case( (snake[0].x) <0): //left
                    running=false;
                    loose=true;
                    break;

                    case( (snake[0].x) >=gameWidth): //right
                    running=false;
                    loose=true;
                    break;

                    case( (snake[0].y) <0): //up
                    running=false;
                    loose=true;
                    break;

                    case( (snake[0].y) >=gameHeight): //down
                    running=false;
                    loose=true;
                    break;


                }

                for(let i=1;i<snake.length;i++){
                    if(snake[i].x==snake[0].x && snake[i].y==snake[0].y ){
                        running=false;
                        loose=true;
                    }
                }
                
            };
            function displayGameOver(){
                ctx.font="50px MV Boli";
                ctx.fillStyle="black";
                ctx.textAlign="center";
                ctx.fillText("Game Over",gameWidth/2,gameHeight/2);
                //console.log("Scorul este:",score);
                //setCookie("score_points",score,5);
                //document.cookie = "score_points=";
                <?php //if(isset($_COOKIE["score_points"])){ echo"console.log('Exists ".$_COOKIE["score_points"]."');"; } else{ echo "console.log('Not exists cookie');"; } ?>
                
                <?php //if(isset($_COOKIE['score_points'])){ echo "console.log('exists cookie');" }   ?>
                //setCookie("score_points",null,null); //delete a cookie
                //delete_cookie("score_points");
                
                
                <?php
                    //$score=echo"score;";
                    //echo "console.log($score)";
                    //$insert_db="Insert into tabel_snakegame(user_email,name_user,points) values('".$_SESSION['username']."','$_SESSION['name']',)"; 
                ?>

            };


            function Insert_Result_DB(){
                let score_points=score;
                //console.log(score_points);
                $(document).ready(function(){
                    $("#exp_load").load("ajax/insert.php",{
                        points_sc:score_points
                    });
                });
            }


            function Update_LeaderBoard(){
                //let score_points=score;
                //console.log(score_points);
                $(document).ready(function(){
                    $("#section_score").load("ajax/LeaderBoardSnake.php");
                });
            }




            function delete_cookie(name){
                document.cookie = name+'=; Max-Age=-99999999;';
            }


            /* function delete_cookie( name, path, domain ) {
            if( get_cookie( name ) ) {
                document.cookie = name + "=" +
                ((path) ? ";path="+path:"")+
                ((domain)?";domain="+domain:"") +
                ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
            }
            }


            function get_cookie(name){
                return document.cookie.split(';').some(c => {
                    return c.trim().startsWith(name + '=');
                });
            } */

            function display_Pause(){
                ctx.font="50px MV Boli";
                ctx.fillStyle="black";
                ctx.textAlign="center";
                ctx.fillText("Pause",gameWidth/2,gameHeight/2);
            };
            function reset_Game_fnc(){
                if(obj.a!=null){ clearTimeout(obj.a); }//clearInterval(obj.a); 
                //console.log(obj.a,"Restart");
                score=0;
                xVelocity=unitSize;
                yVelocity=0;
                snake = [
                    /*{x:unitSize * 4, y:0},
                    {x:unitSize * 3, y:0},
                    {x:unitSize * 2, y:0},*/
                    {x:unitSize, y:0},
                    {x:0, y:0}
                ];   
                action="start";
                check_var=1;
                loose=false;
                gameStart();
            };



            //Mobile Menu
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


       /*  function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        } */
    




            //console.log(gameWidth,gameHeight);

            //var1.style.width='';

        </script>

    </div>
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




    function check_Empty_Table($conexiune){
        $sql_select="SELECT * FROM final_project_web.tabel_snakegame";
        $table_snake=mysqli_query($conexiune, $sql_select) or die ('Eroare');
        if(mysqli_num_rows($table_snake)>0){
            return 0; //
        }
        return 1;

    }
?>