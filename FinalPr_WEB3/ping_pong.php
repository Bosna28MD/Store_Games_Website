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
            
        }

        #section_game #title_game{
            width: 50%;
            margin: auto;
            
            text-align: center;
            font-size: 33px;
            font-weight: bold;

        }

        #ping_pong{
            width: 85%;
            margin: auto;
            
            margin-top: 20px;
            text-align: center;
        }

        #gameBoard{
            border: 3px solid black;
            margin: 3px;
        }

        #scoreText{
            font-size: 40px;
        }

        #btn_{
            
            width: 60%;
            margin: auto;
            padding-right: 50px;
        }
        
        #btn_ button{
            font-size: 25px;
            font-weight: bold;
            cursor: pointer;

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
            <div id="title_game">Ping Pong:</div>
            <div id="ping_pong">
                <canvas id="gameBoard" width="500" height="500"></canvas>
                <div id="scoreText">0:0</div>
                <div id="btn_">
                    <button  id="start_btn">Start/Pause</button>
                    <button  id="resetBtn">Reset</button>
                </div>
                
            </div>

        </section>



        <script>
            window.onkeydown = function(event){ //when i click space to not click the buttons
                if(event.keyCode === 32 || event.keyCode === 38 || event.keyCode === 40 ) {
                    event.preventDefault();
                }
                //console.log(event.keyCode);
            };

            
            
            let gameBoard=document.getElementById("gameBoard");
            let ctx=gameBoard.getContext("2d");
            let scoreText=document.getElementById("scoreText");
            let resetBtn=document.getElementById("resetBtn");
            let startBtn=document.getElementById("start_btn");
            
            let gameWidth=gameBoard.width;
            let gameHeight=gameBoard.height;
            
            let boardBackground="forestgreen";
            let paddle1Color="lightblue";
            let paddle2Color="red";
            let paddleBorder="black";
            let ballColor="yellow";
            let ballBorderColor="black";
            let ballRadius=12.5;
            let paddleSpeed=50;
            let intervalID=null;
            let ballSpeed=1;
            let ballX=gameWidth/2;
            let ballY=gameHeight/2;
            let ballXDirection=0;
            let ballYDirection=0;
            let player1Score=0;
            let player2Score=0;
            
            let paddle1={
                width:25,
                height:100,
                x:0,
                y:0
    
            }
    
    
            let paddle2={
                width:25,
                height:100,
                x:gameWidth-25,
                y:gameHeight-100
    
            }
    
            let running=true;
    
    
            //window.addEventListener("keydown",changeDirection);
            resetBtn.addEventListener("click",resetGame);
            startBtn.addEventListener("click",gameStart);
    
            //gameStart();
            let action="start";
    
            let ballcreated=false;
    
            function gameStart(){
                console.log(running);
                if(running==true){
                    window.addEventListener("keydown",changeDirection);
                    if(action=="start"){
                        if(intervalID!=null){ clearInterval(intervalID); intervalID=null;  }
                        action="pause";
                        running=true;
                        if(!ballcreated){ createBall();  }
                        //createBall();
                        nextTick();
                    }
                    else if(action=="pause"){
                        if(intervalID!=null){ clearInterval(intervalID); intervalID=null;  }
                        action="start";
                        running=true;
                        nextTick();
                    }
                }
                
                
            }
    
            function nextTick(){
                if(running && action=="pause"){
                    intervalID=setTimeout(()=>{
                        clearBoard();
                        drawPaddles();
                        moveBall();
                        drawBall(); //ballX,ballY
                        checkColision();
                        final_Game();
                        nextTick();
                    },10);
                }
                else if(running && action=="start"){
                    clearBoard();
                    drawPaddles();
                    drawBall();
                    display_Pause();
                }
                
            }
    
    
            function display_Pause(){
                ctx.font="50px MV Boli";
                ctx.fillStyle="black";
                ctx.textAlign="center";
                ctx.fillText("Pause", gameWidth/2,gameHeight/2);
            };
    
    
            function clearBoard(){
                ctx.fillStyle=boardBackground;
                ctx.fillRect(0,0,gameWidth,gameHeight);
            }
    
    
            function drawPaddles(){
                ctx.strokeStyle=paddleBorder;
    
                //Paddle1:
                ctx.fillStyle=paddle1Color;
                ctx.fillRect(paddle1.x,paddle1.y,paddle1.width,paddle1.height);
                ctx.strokeRect(paddle1.x,paddle1.y,paddle1.width,paddle1.height);
    
                //Paddle2:
                ctx.fillStyle=paddle2Color;
                ctx.fillRect(paddle2.x,paddle2.y,paddle2.width,paddle2.height);
                ctx.strokeRect(paddle2.x,paddle2.y,paddle2.width,paddle2.height);
            }
    
    
    
    
    
            function createBall(){
                ballSpeed=1;
                if(Math.round(Math.random())){ // =1 ->right else left
                    ballXDirection=1; //Right
                }
                else{
                    ballXDirection=-1; //Left
                }
    
                if(Math.round(Math.random())){ 
                    ballYDirection=1; //Down
                }
                else{
                    ballYDirection=-1; //Up
                }
    
                ballcreated=true;
                ballX=gameWidth/2;
                ballY=gameHeight/2;
                drawBall();
                
    
            }
    
    
            function moveBall(){
                ballX+=(ballSpeed*ballXDirection);
                ballY+=(ballSpeed*ballYDirection);
            }
    
            function drawBall(){ //ballX,ballY
                ctx.fillStyle=ballColor;
                ctx.strokeStyle=ballBorderColor;
                ctx.lineWidth=2; 
                ctx.beginPath();
                ctx.arc(ballX,ballY,ballRadius,0,2*Math.PI);
                ctx.stroke();
                ctx.fill();
            }
    
            function checkColision(){
                if(ballY-ballRadius <= 0 ){ //Top
                    ballYDirection*=-1;
                }
                if(ballY+ballRadius >= gameHeight){ //Down
                    ballYDirection*=-1;
                }
    
                if(ballX<=0){
                    player2Score+=1;
                    updateScore();
                    createBall();
                }
    
                if(ballX>=gameWidth){
                    player1Score+=1;
                    updateScore();
                    createBall();
                }
    
                
    
    
                if(ballX <= (paddle1.x + paddle1.width + ballRadius)){  //check colision player1
                    if(ballY > paddle1.y && ballY < paddle1.y + paddle1.height){
                        ballX = (paddle1.x + paddle1.width) + ballRadius; // if ball gets stuck
                        ballXDirection *= -1;
                        ballSpeed += 1;
                    }
                }
                if(ballX >= (paddle2.x - ballRadius)){ //check colision player2
                    if(ballY > paddle2.y && ballY < paddle2.y + paddle2.height){
                        ballX = paddle2.x - ballRadius; // if ball gets stuck
                        ballXDirection *= -1;
                        ballSpeed += 1;
                    }
                }
    
    
            }
    
            function changeDirection(event){
                let keyPressed=event.keyCode;
                let paddle1Up=87;
                let paddle1Down=83;
                let paddle2Up=38;
                let paddle2Down=40;
                //console.log(keyPressed);
                switch(keyPressed){
                    case(paddle1Up): if(paddle1.y>0){ paddle1.y-=paddleSpeed;}  break;
                    case(paddle1Down): if(paddle1.y+paddle1.height<gameHeight){ paddle1.y+=paddleSpeed; }  break;
                    case(paddle2Up): if(paddle2.y>0){ paddle2.y-=paddleSpeed; } break;
                    case(paddle2Down): if(paddle2.y+paddle2.height<gameHeight){ paddle2.y+=paddleSpeed; }  break;
                }
    
            }
    
            function updateScore(){
                scoreText.textContent=`${player1Score}:${player2Score}`;
            }
    
            function final_Game(){
                if(player1Score==3 || player2Score==3 ){
                    if(player1Score==3){
                        scoreText.textContent=`${player1Score}:${player2Score} (player-1 Win)`;
                    }
                    else if(player2Score==3){
                        scoreText.textContent=`${player1Score}:${player2Score} (player-2 Win)`;
    
                    }
                    ballcreated=false;
                    running=false;
                    clearBoard();
                    drawBall();
                    drawPaddles();
                    
    
                }
            }
    
            function resetGame(){
                action="start";
                running=true;
                ballcreated=false;
                player1Score=0;
                player2Score=0;
    
                paddle1={
                    width:25,
                    height:100,
                    x:0,
                    y:0
        
                }
        
        
                paddle2={
                    width:25,
                    height:100,
                    x:gameWidth-25,
                    y:gameHeight-100
        
                }
    
                ballSpeed = 1;
                ballX = gameWidth/2;
                ballY = gameHeight/2;
                ballXDirection=0;
                ballYDirection=0;
                updateScore();
                if(intervalID!=null){ clearInterval(intervalID);  }
                intervalID=null;
                gameStart();
    
    
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
?>