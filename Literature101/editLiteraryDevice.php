<?php 
//editLiteraryDevice.php

require_once 'includes/global.inc.php';

//Initialize php variables used in the form if a device is selected
$deviceTools = new DeviceTools();


    $row = $deviceTools->getDevice($_SESSION['currentDevice']);
    $name = $row[0];
    $category = $deviceTools->getCategory($name);
    $article = htmlspecialchars_decode($row[1]);
    $error = "";
    $newDevice = false;

    //Don't allow editing 'home'-articles. Re-direct.
    if($category == "home")
    {
        header("Location: index.php");
    }

//else
//{
//    $error = "No device selected. Return to home.";
//    $name = "None Selected";
//    $category = "—";
//    $article = "";
//}



//Check to see that the form has been submitted
if(isset($_POST['device-form']) && isset($_SESSION['currentDevice'])) { 

	//Retrieve the $_POST variables
	$article = $_POST['article'];
    //$article = htmlspecialchars($article);

	//Initialize variables for form validation
	$success = true;
	
    //Double-check that the user is logged in and has editing-rights.
    $user = unserialize($_SESSION['user']);
    
    if($user->editor == false)
	{
	    $error = "You don't have the rights to edit/add content.<br/> \n\r";
	    $success = false;
	}
    

    $find = array("<div","/div>");
    
    //Check for special characters in the name
    if (preg_match("/<div/", $article) || preg_match("/div>/", $article)) {
        $error = "Sorry, prohibited HTML tags was found in your article.<br/> \n\r";
	    $success = false;
    }


	if($success)
	{
        //$article = htmlspecialchars($article);
        //$article = str_replace("'", "&#39;", "$category");
        
	    //Prep the data for saving in a new device object
	    $data['name'] = str_replace(" ", "_", "$name");
	    $data['category'] = $category;//str_replace("_", " ", "$category");
	    $data['article'] = html_entity_decode(htmlspecialchars_decode(str_replace("'", "''", $article)));
        $data['author'] = $user->username;
        
	    //mysql_real_escape_string($article);
	    //Create the new device object
	    $newDevice = new Device($data);
	
	    //Save the new device to the database
	    $newDevice->save(false);
	
	    //Redirect them to a main page
	    header("Location: index.php");
	}

}


if(isset($_POST['delete-form'])) { 
    
    //Initialize variables for form validation
	$success = true;
    
    //Double-check that the user is logged in and has editing-rights.
    if($user->editor == false)
	{
	    $error = "You don't have the rights to edit/add content.<br/> \n\r";
	    $success = false;
	}
    

	if($success)
	{
    //Delete the selected device
    $deviceTools->delete($name, $category);
    unset($_SESSION["currentDevice"]);
    
    //Redirect them to a main page
    header("Location: index.php");
    }
}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?>


<html>
<head>
	<title>Edit Device</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/formPageStyle.css">
</head>
<body>
    <div class=userFormContainer id="deviceFormContainer">
        <h2 class="formHeader">Edit Device</h2>
        <h3 class="formMsg"> <?php echo ($error != "") ? $error : ""; ?> </h3>
        <form action="editLiteraryDevice.php" method="post" class="userForm">
            Device Name: <input type="text" value="<?php echo $name; ?>" name="name" disabled/><br/>
            Category: <input type="text" value="<?php echo  ucfirst(str_replace("_", " ", $category)); ?>" category="category" disabled/><br/>
            Article: <textarea name="article" rows="20" cols="100"><?php echo $article;?></textarea>
            <input type="submit" value="Save" name="device-form" />
	   </form>
       <form action="editLiteraryDevice.php" method="post" class="deleteForm">
            <input type="hidden" id=currentArticle name="selectedName" value="<?php echo $name; ?>">
            <input type="submit" value="Delete Device" name="delete-form" />
	   </form>
       <a href="index.php" id="homeLink">Home</a>
    </div>
</body>
</html>