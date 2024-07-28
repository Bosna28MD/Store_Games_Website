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


        #tic_tac_toe_game{
            width: 70%;
            margin: auto;
            padding: 30px 0;
            text-align: center;
        }


        .cell{
            border: 1px solid black;
            width: 125px;
            height: 125px;
            font-size: 75px;
            cursor: pointer;
        }

        .cellContainer{
            display: grid;
            grid-template-columns: repeat(3,1fr);
            width: 375px;
            margin: auto;
            padding: 10px;
        }

        #turn_text{
            font-size: 24px;
            font-weight: bold;
        }

        #resetBt{
            font-size: 22px;
            font-weight: bold;
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

        <?php
        //echo select_game($conexiune)['link_game'];
        ?>

        <section id="section_game">
            <div id="title_game">Tic-Tac-Toe Game:</div>
            <div id="tic_tac_toe_game">
                <div class="cellContainer">
                    <div class="cell" cellIndex="0" ></div>
                    <div class="cell" cellIndex="1" ></div>
                    <div class="cell" cellIndex="2" ></div>
                    <div class="cell" cellIndex="3" ></div>
                    <div class="cell" cellIndex="4" ></div>
                    <div class="cell" cellIndex="5" ></div>
                    <div class="cell" cellIndex="6" ></div>
                    <div class="cell" cellIndex="7" ></div>
                    <div class="cell" cellIndex="8" ></div>
                </div>
                <div id="turn_text" ></div>
                <button id="resetBt">Reset</button>
            </div>
            
        </section>
        
    </div>


    <script>

        let turn_text=document.getElementById("turn_text");
        let bt_reset=document.getElementById("resetBt");
        let cells=document.querySelectorAll(".cell");

        let win_moments=[
        [0,1,2],
        [3,4,5],
        [6,7,8],
        [0,3,6],
        [1,4,7],
        [2,5,8],
        [0,4,8],
        [2,4,6]
        ];

        let curentPlayer="X";
        let running=false;
        let options=["","","","","","","","",""];


        //cells.forEach(cell=>cell.addEventListener("click",cell_Clicked));
        initialize_game();

        function initialize_game(){
            cells.forEach(cell=>cell.addEventListener("click",cell_Clicked));
            bt_reset.addEventListener("click",restartGame);
            turn_text.textContent=`${curentPlayer}'s Turn`;
            running=true; 
        }

        function cell_Clicked(){
            let cell_index=this.getAttribute("cellIndex");
            if(options[cell_index]!="" || !running){
                return;
            }
            updateCell(this,cell_index);
            //console.log(options);
            checkWinner();
            if(running){
                changePlayer();
            }
            
        }

        function updateCell(cell,index){
            options[index]=curentPlayer;
            cell.textContent=curentPlayer;
        }

        function changePlayer(){
            curentPlayer=(curentPlayer=="X") ? "O":"X";
            turn_text.textContent=`${curentPlayer}'s Turn`;
        }

        function checkWinner(){
            let roundWon=false;
            for(let i=0;i<win_moments.length;i++){
                let arr_options=win_moments[i];
                let A_cell=options[arr_options[0]];
                let B_cell=options[arr_options[1]];
                let C_cell=options[arr_options[2]];
                if(A_cell=="" || B_cell=="" | C_cell==""){
                    continue;
                }
                if(A_cell==B_cell && A_cell==C_cell){
                    roundWon=true;
                    break;
                }

            }

            if(roundWon){
                turn_text.textContent=`${curentPlayer} Wins!`;
                running=false;
            }
            else if(Check_Fill_Arr()){
                turn_text.textContent=" Draw ";
                running=false;
            }
        }

        function Check_Fill_Arr(){
            for(let i=0;i<options.length;i++){
                if(options[i]==""){
                    return 0;
                }
            }
            return 1;
        }

        function restartGame(){
            curentPlayer="X";
            turn_text.textContent=`${curentPlayer}'s Turn`;
            options=["","","","","","","","",""];
            running=true;
            cells.forEach(cell=>{cell.textContent="";});
        }





        //Menu Mobile:
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
            $address_file=$var[count($var)-1];
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