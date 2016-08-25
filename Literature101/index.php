<?php
require_once 'includes/global.inc.php';
$deviceTools = new DeviceTools();
?>

<html lang="en">
  <head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Literature 101</title>

<!-- Custom Stylesheets -->
<link rel="stylesheet" href="css/index_style.css">
<link rel="stylesheet" href="cssmenu/nav_style.css">
<!-- Fonts -->
<link href="http://fonts.googleapis.com/css?family=Crimson+Text" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Allerta" rel="stylesheet" type="text/css">
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<!-- Scripts -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="js/indexScript.js"></script>
<script src="cssmenu/nav_script.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <div class="banner">
      <div class="container">
          <h1>Literature 101</h1>
      </div>
    </div>
    <img class="SearchIcon" src="Images/search_glass.png" height="40">
    <div class="topBar">
        <div id='cssmenu'>
            <ul class="navTop">
                <li class="Search"><a href='#'>SE</a></li>
                <li class="Home"><a href='#'>Home</a></li>
                <li class="Techniques"><a  href="#">Literary Techniques</a></li>
                <li class="Elements"><a  href="#">Literary Elements</a></li>
                <li class="Punctuation"><a  href="#">Punctuation</a></li>
                <li class="Video"><a  href="#">Crash Course Literature</a></li>
                  
                <div>
                <!-- Display info/options depending on log-in status -->
                    <ul class="navUser">
                    <?php if(isset($_SESSION['logged_in'])) : ?>
                       <?php $user = unserialize($_SESSION['user']); ?>
                        Hello, <?php echo $user->username; ?> |<a href="logout.php">Logout</a> | <a href="settings.php">Settings</a>
                            <?php
                            if( ($user->editor) == true ){

                                echo '| <a href="addLiteraryDevice.php">Add Device</a>';
                                  if (isset($_POST['selectedName']) && $deviceTools->getCategory($_POST['selectedName'])!=="home")
                                  {
                                          echo '| <a href="editLiteraryDevice.php">Edit Device</a>';
                                  }
                                  else if (isset($_SESSION['currentDevice']) && $deviceTools->getCategory($_SESSION['currentDevice'])!=="home")
                                  { 
                                          echo '| <a href="editLiteraryDevice.php">Edit Device</a>';
                                  }
                            }
                            ?>
                    <?php else : ?>
                       You are not logged in. <a href="login.php" >Log In</a> | <a href="register.php">Register</a>
                    <?php endif; ?>
                    <!-- End of User Options -->
                    </ul>
                </div>
            </ul>
        </div>
    </div>
      


    <div class="navLeft" >

        <div class="subSearch hidden">
            <ul class="nav nav-pills nav-stacked" id="subMenu">
                <div class="searchField">
                    <form id="searchForm"  method="post">
                        <p>Search:</p><input type="text" name="searchTerm">
                        <input type="submit" value="Search" name="searchButton"/>
                    </form>
                </div>
                <!---LIST GENERATION--->
                <?php  
                if (isset($_POST['searchTerm']) ) {  
                    $menuList = $deviceTools->search($_POST['searchTerm']);

                    foreach ($menuList as $value){
                        echo "<li><a class='sub' id=$value href='#'>";
                        echo str_replace("_", " ", "$value</a></li>");
                    }
                }
                ?>
                <!---END OF LIST GENERATION--->
            </ul> 
        </div>  
        <div class="subHome hidden">
            <ul class="nav nav-pills nav-stacked home" id="subMenu">
                <br><br>
                <!---LIST GENERATION--->
                <?php   
                    $menuList = $deviceTools->getColumn("home");

                    foreach ($menuList as $value){
                        echo "<li><a class='sub' id=$value href='#'>$value</a></li>";
                    }
                ?>
                <!---END OF LIST GENERATION--->
            </ul> 
        </div>   

        <div class="subTechniques hidden">
            <ul class="nav nav-pills nav-stacked" id="subMenu">
                <!---LIST GENERATION--->
                <?php  
                    $menuList = $deviceTools->getColumn("literary_techniques");

                    foreach ($menuList as $value){
                       echo "<li><a class='sub' id=$value href='#'>$value</a></li>";
                    }
                ?>
              <!---END OF LIST GENERATION--->
            </ul>
        </div> 

        <div class="subElements hidden">
            <ul class="nav nav-pills nav-stacked">
                <!---LIST GENERATION--->
                <?php  
                    $menuList = $deviceTools->getColumn("literary_elements");

                    foreach ($menuList as $value){
                       echo "<li><a class='sub' id=$value href='#'>$value</a></li>";
                    }
                ?>
                <!---END OF LIST GENERATION--->
            </ul>
        </div>

        <div class="subPunctuation hidden">
            <ul class="nav nav-pills nav-stacked">
                <!---LIST GENERATION--->
                <?php  

                    $menuList = $deviceTools->getColumn("punctuation");

                    foreach ($menuList as $value){
                       echo "<li><a class='sub' id=$value href='#'>";
                       echo str_replace("_", " ", "$value</a></li>");
                    }
                ?>
                <!---END OF LIST GENERATION--->
            </ul>
        </div>

        <div class="subVideo hidden">
            <ul class="nav nav-pills nav-stacked">
                <!---LIST GENERATION--->
                <?php   
                    $menuList = $deviceTools->getColumn("videos");

                    foreach ($menuList as $value){
                       echo "<li><a class='sub' id=$value href='#'>";
                       echo str_replace("_", " ", "$value</a></li>");
                    }
                ?>
              <!---END OF LIST GENERATION--->
            </ul>
        </div>
    </div>
    <!---END OF LEFT NAV-BAR--->


    <div class="content">
        <div class="description">
            <!--- Article --->
            <p>
            <?php    
                //Set header and article depending on selected name.
                //If the page has refreshed and a device has not been
                //set trough the form, check if a former device was selected.
                if (isset($_POST['selectedName']) ) {
                    echo "<h1 id='articleHeader'><b>" ;
                    echo str_replace("_", " ", $_POST['selectedName'] . "</b></h1>");
                    echo "<bdi>".$deviceTools->getArticle($_POST['selectedName'])."</bdi>";
                    $_SESSION['currentDevice'] = $_POST['selectedName'];
                }
                else if (isset($_SESSION['currentDevice']) ) {
                    echo "<h1 id='articleHeader'><b>" ;
                    echo str_replace("_", " ", $_SESSION['currentDevice'] . "</b></h1>");
                    echo "<bdi>".$deviceTools->getArticle($_SESSION['currentDevice'])."</bdi>";
                }
            ?>
            </p>
            <!--- End of Article --->
        </div>

        <br><br> 

        <form id='articleQuery' method="post">
            <input type="hidden" id=currentArticle name="selectedName" value=""><br>
        </form>
    </div>

    <footer class="myFooter">
        <p>Posted by: This is my awe-inspiring footer<br>Footer inserted by Jonathan Ariga</p>
        <?php
            if (isset($_POST['selectedName']) && $deviceTools->getCategory($_POST['selectedName'])!=="home"){
                echo "<a href='test.xml' download>DOWNLOAD XML</a>";
                //echo "<p>Posted by: " . $deviceTools->getAuthor($_POST['selectedName']) . "<br>Footer inserted by Jonathan Ariga</p>";
            }
        ?>
    </footer>  


    <?php  
        if (isset($_POST['selectedName']) ) {
            /* create a dom document with encoding utf8 */


            // load the document
            // the root node is <info/> so we load it into $info
            $info = simplexml_load_file('test.xml');

            // update
            $info->device->subject = $_POST['selectedName'];
            $info->device->article = strip_tags($deviceTools->getArticle($_POST['selectedName']));


            //$info->user->name->firstname = "Jonathan";
            //$info->user->name->lastname = "Ariga";

            // save the updated document
            $info->asXML('test.xml');
            //readfile('test.xml');
        }
    ?>
    
</body> 
    
</html>