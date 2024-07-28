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

        #content_info{
            width: 80%;
            margin: auto;
            border: 1px solid black;
            margin-top: 30px;
            background-color: gainsboro;
            border-radius: 10px;
        }

        #content_info h2{
            text-align: center;
        }

        #info_div{
            padding: 15px;
        }

        #info_div ul li{
            margin-top: 10px;
            list-style-type: none;
        }

        #categories_games{
            width: 80%;
            margin: auto;
            
            margin-top: 30px;
            
        }

        #categories_games h2{
            text-align: center ;
            margin:15px 0px;
        }

        .categories_div{
            /*border: 1px solid black;*/
            
            margin: auto;
            display: flex;
            
        }

        .categories_div .box_categories{
            width: 34.3%;
            height: 30vh;
            border: 3px solid gray;
            margin: 0 2px;
            border-radius: 10px;
            background-color: ;
            
        }

        .img_box{
            width:60px;
            height:35px;
        }

        #box1_{
            background-color: rgba(0, 255, 0, 0.4);
        }

        #box2_{
            background-color: rgba(255,255,0, 0.4);
        }


        #box3_{
            background-color: rgba(255, 0, 0, 0.4);
        }

        .title_categ{
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            
        }

        .categ_list li{
            margin: 7px;
            list-style: none;
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

        <div id="content_info">
            <h2>Rules of the Website: </h2>
            <div id="info_div">
                <ul>
                    <li>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eligendi officia repellat enim ad in reprehenderit unde doloremque, fuga facilis. Dolores consequuntur unde, inventore exercitationem possimus temporibus distinctio quae assumenda quas fugiat eos harum repellat ducimus molestias maxime, eaque eveniet molestiae, accusantium id odio odit. Ea repudiandae eum minima sit consequatur!</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur accusantium exercitationem a eos necessitatibus, veniam laboriosam aspernatur in perspiciatis est optio deserunt, voluptates libero eaque sapiente at facere tenetur ipsum! Beatae, vero voluptatibus. At aspernatur atque ipsum veritatis illum! Molestiae error excepturi non pariatur est?</li>
                    <li>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Similique recusandae eius officiis libero quis laboriosam, in illo quas ad, voluptas porro consequatur assumenda, rem magni explicabo! Odio officia iure perspiciatis.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque animi at soluta. Ab animi commodi minima sit iusto provident assumenda aliquam dolorem delectus in! Saepe fugiat dicta ipsa, provident at accusamus voluptatum quidem voluptate nisi. Voluptate, modi!</li>
                    <li>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores saepe tenetur cumque veniam doloremque, sed velit vero? Reprehenderit debitis est aperiam maxime eligendi repellat labore distinctio maiores adipisci saepe, repudiandae dignissimos blanditiis temporibus inventore quod recusandae laborum dolores sunt. Hic?</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere dolorem, molestiae, in minima, voluptatibus vel optio nulla labore quia eveniet cum.</li>
                    <li>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non a reiciendis sed fugiat harum nulla pariatur? Inventore minus doloremque ducimus laboriosam vitae dicta tempora, voluptas magnam harum molestias suscipit veniam sequi quae cupiditate, in aperiam distinctio eos delectus quas eum eveniet temporibus dolore modi repudiandae. Incidunt itaque dolores deleniti magni.</li>
                </ul>
            </div>

        </div>


        <div id="categories_games">
            
            <h2>Type of Games:</h2>
            
            <div class="categories_div">
                
                <div class="box_categories" id="box1_">
                    <div class="title_categ" >Entry Games: <img src="./img/easy_img.png" class="img_box" alt=""></div>
                    <ul class="categ_list">
                        <li>Rock Paper Scissors</li>
                        <li>Tic-Tac-Toe</li>
                    </ul>
                </div>
                
                <div class="box_categories" id="box2_">
                    <div class="title_categ" >Medium Games: <img src="./img/medium_img.png" class="img_box" alt=""> </div>
                    
                    <ul class="categ_list">
                        <li>Dinosaur</li>
                        <!-- <li>Guess Game</li> -->
                    </ul>
                </div>
                
                <div class="box_categories" id="box3_" >
                    <div class="title_categ" >VIP Games: <img src="./img/hard_img.png" class="img_box" alt=""> </div>
                    
                    <ul class="categ_list">
                        <li>Snake</li>
                        <li>Ping Pong</li>
                    </ul>
                </div>

            </div>
            

        </div>

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
?>