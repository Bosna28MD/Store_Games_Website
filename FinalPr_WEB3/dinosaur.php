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

        #title_game{
            font-weight: bold;
            font-size: 33px;
        }

        #dino_game{
            width: 95%;
            margin: auto;
            
            height: 60vh;
            margin-top: 20px;
        }

        #board_game_dino{
            background-color: lightgray;
            border: 1px solid black;
            margin: 30px 0;
        }

        #btn_div .btn_{
            font-weight: bold;
            font-size: 23px;
        }

        /*#btn_div .btn_:focus {
            outline: none;
        }*/


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
            

            <div id="dino_game">
                <div id="title_game">Dinosaur Game:</div>
                <canvas width="1000" height="300" id="board_game_dino"></canvas>
                <div id="btn_div">
                    <button class="btn_" onclick="Start_Game()">Start/Pause</button>
                    <button class="btn_" onclick="Restart_Game()">Restart</button>
                </div>
            </div>

        </section>


    </div>

    
    


    <script>

        window.onkeydown = function(event){ //when i click space to not click the buttons
            if(event.keyCode === 32) {
                event.preventDefault();
            }
        };

        let game_board=document.getElementById("board_game_dino");
        let ctx=game_board.getContext("2d");

        let widthBoard=game_board.width;
        let heightBoard=game_board.height;
        let boardBackGround="lightgray";

        let dinoWidth=90;
        let dinoHeight=100;
        let dinoX=30;
        let dinoY=heightBoard-dinoHeight;

        let dinoImgSrc1="./img/dino-run-0.png";
        let dinoImgSrc2="./img/dino-run-1.png";
        let dinoImgSrcLost="./img/dino-lose.png";


        let running=true;
        let action="start";
        let score=0;
        let GameOver=false;
        let imgRun=1;

        let cactusArray=[];
        let cactus1Width=34;
        let cactus2Width=50;
        let cactus3Width=85;
        let cactusHeight=60;

        let cactusX=900;
        let cactusY=heightBoard-cactusHeight;

        let cactusImgSrc1="./img/big-cactus1.png";
        let cactusImgSrc2="./img/big-cactus2.png";
        let cactusImgSrc3="./img/big-cactus3.png";




        obj={
            a:null,
            start_run:1
            
        };

        let var_k=null;

        dino={
            x:dinoX,
            y:dinoY,
            width: dinoWidth,
            height:dinoHeight,
            jump:0,
            numbersJump:10
        };

        document.addEventListener("keydown",moveDino);


        function Start_Game(){
            if(GameOver){
                return;
            }

            if(action=="start"){
                //running=true;
                action="pause";
                if(var_k==null){var_k=setInterval(Select_Cactus,1400); }
                nextTick(); 
            }
            else if(action=="pause"){
                if(var_k!=null){ clearInterval(var_k); var_k=null; }
                action="start";
                //running=true;
                nextTick(); 
            }

        }

        //let previous_jump=null;
        function nextTick(){

            if(running && action=="pause"){
                let t=setTimeout(()=>{
                    //if(checkColision()==true){ nextTick(); return;  }
                    ClearBoard();
                    display_Points();
                    score=score+2;
                    if(dino.jump==1){  changeVelocity_10frames(); }
                    Draw_Dino();
                    //console.log(dino.y);
                    //Select_Cactus();//drawCactus();
                    drawCactus();//Move_Cactus(); 
                    Move_Cactus();
                    checkColision();
                    nextTick();
                    
                },90);
                obj.a=t;


                //console.log("Start");
            }
            else if(running && action=="start"){
                display_Pause();
                //console.log("Pause",action);
            }
            else{
                //console.log("Call Game Over");
                ClearBoard();
                display_Points();
                Draw_Dino();
                drawCactus_previos();
                printGameOver();
            }


        }


        function Draw_Dino(){
            let dinoImg1=new Image();
            dinoImg1.src=dinoImgSrc1;
            let dinoImg2=new Image();
            dinoImg2.src=dinoImgSrc2;
            let dinoImgLost=new Image();
            dinoImgLost.src=dinoImgSrcLost;

            if(imgRun==1){
                ctx.drawImage(dinoImg1,dino.x,dino.y,dinoWidth,dinoHeight);
                ctx.strokeRect(dino.x,dino.y,dinoWidth,dinoHeight);
                imgRun=2;
            }
            else if(imgRun==2){
                ctx.drawImage(dinoImg2,dino.x,dino.y,dinoWidth,dinoHeight);
                ctx.strokeRect(dino.x,dino.y,dinoWidth,dinoHeight);
                imgRun=1;
            }
            else if(imgRun==3){
                ctx.drawImage(dinoImgLost,dino.x,dino.y,dinoWidth,dinoHeight);
                ctx.strokeRect(dino.x,dino.y,dinoWidth,dinoHeight);
            }

        }

        
        


        function ClearBoard(){
            ctx.clearRect(0,0,widthBoard,heightBoard);
        }


        function moveDino(e){
            if( (e.code=="Space" || e.code=="ArrowUp") && dino.y==dinoY ){ //jump
                dino.jump=1;
            }

        }

        function changeVelocity_10frames(){
            if(GameOver==true){ return; }
            if(dino.numbersJump==0){ dino.numbersJump=10; dino.jump=0; previous_jump=-1;  return;}
            if(dino.numbersJump>5){
                dino.y=dino.y-25;
                dino.numbersJump--;
            }
            else{
                dino.y=dino.y+25;
                dino.numbersJump--;
            }
            
        }


        function display_Pause(){
            ctx.font="50px MV Boli";
            ctx.fillStyle="black";
            ctx.textAlign="center";
            ctx.fillText("Pause", widthBoard/2,heightBoard/2);
        };


        function display_Points(){
            ctx.fillStyle="black";
            ctx.font="20px courier";
            ctx.fillText(score,20,20);
        }

        function drawCactus(){
            for(let i=0;i<cactusArray.length;i++){
                //cactusArray[i].x=cactusArray[i].x+velocityX;
                if(cactusArray[i].img!=null){
                    ctx.drawImage(cactusArray[i].img,cactusArray[i].x,cactusArray[i].y,cactusArray[i].width,cactusArray[i].height);
                    ctx.strokeRect(cactusArray[i].x,cactusArray[i].y,cactusArray[i].width,cactusArray[i].height);
                }
            }
        }


        function drawCactus_previos(){
            for(let i=0;i<cactusArray.length;i++){
                //cactusArray[i].x=cactusArray[i].x+velocityX;
                if(cactusArray[i].img!=null){
                    ctx.drawImage(cactusArray[i].img,cactusArray[i].x+30,cactusArray[i].y,cactusArray[i].width,cactusArray[i].height);
                    ctx.strokeRect(cactusArray[i].x+30,cactusArray[i].y,cactusArray[i].width,cactusArray[i].height);
                }
            }
        }


        function Move_Cactus(){
            
            if(running==false){
                return;
            }
            let velocityX=-30;

            for(let i=0;i<cactusArray.length;i++){
                if(cactusArray[i].img!=null){
                    cactusArray[i].x=cactusArray[i].x+velocityX;
                }
            }


        }


        function Select_Cactus(){
            let cactus_fnc={
                x:cactusX,
                y:cactusY,
                width:null,
                height:cactusHeight,
                img:null
            }

            let cactusImg1=new Image();
            let cactusImg2=new Image();
            let cactusImg3=new Image();
            cactusImg1.src=cactusImgSrc1;
            cactusImg2.src=cactusImgSrc2;
            cactusImg3.src=cactusImgSrc3;

            let placeCactusChance=Math.random();

            if(placeCactusChance>0.90){
                cactus_fnc.img=cactusImg3;
                cactus_fnc.width=cactus3Width;
                cactusArray.push(cactus_fnc);
            }
            else if(placeCactusChance>0.70){
                //cactusImg_main=cactusImg2;
                cactus_fnc.img=cactusImg2;
                cactus_fnc.width=cactus2Width;
                cactusArray.push(cactus_fnc);
            }
            else if(placeCactusChance>0.50){
                //cactusImg_main=cactusImg1;
                cactus_fnc.img=cactusImg2;
                cactus_fnc.width=cactus1Width;
                cactusArray.push(cactus_fnc);
            }

            if(cactusArray.length>5){
                cactusArray.shift();
            }

        } 


        function printGameOver(){
            ctx.font="50px MV Boli";
            ctx.fillStyle="black";
            ctx.textAlign="center";
            ctx.fillText("Game Over", widthBoard/2,heightBoard/2);
        }

        function checkColision(){
            let flag=0;
            for(let i=0;i<cactusArray.length;i++){
                if(cactusArray[i].img!=null){
                    if(dino.x<cactusArray[i].x+cactusArray[i].width && dino.x+dino.width>cactusArray[i].x
                    && dino.y<cactusArray[i].y+cactusArray[i].height && dino.y+dino.height>cactusArray[i].y ){ 
                        //a.x<b.x+b.width  a.x+a.width>b.x  a.y<b.y+b.height  a.y+a.height>b.y
                        running=false;
                        GameOver=true;
                        imgRun=3;
                        return true;
                }

                }
            }
            return false;
        }






        function Restart_Game(){
            if(obj.a!=null){ clearInterval(obj.a);  }
            ClearBoard();
            running=true;
            score=0;
            cactusArray=[];
            //cactusX=900;
            action="start";
            imgRun=1;
            dino={
                x:dinoX,
                y:dinoY,
                width: dinoWidth,
                height:dinoHeight,
                jump:0,
                numbersJump:10
            };
            GameOver=false;
            if(var_k!=null){ clearInterval(var_k); var_k=null; }
            Start_Game();

            
        }



        //For Mobile:
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