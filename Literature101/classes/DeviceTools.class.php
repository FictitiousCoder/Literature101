<?php
require_once 'Device.class.php';
require_once 'DB.class.php';

class DeviceTools {

	//Get the literary device.
	public function getDevice($name)
	{
        $sql = 
            mysql_query("(select * from home WHERE name='$name')
            UNION
            (select * from literary_techniques WHERE name='$name')
            UNION
            (select * from literary_elements WHERE name='$name')
            UNION
            (select * from punctuation WHERE name='$name')
            UNION
            (select * from videos WHERE name='$name')");
        
        //$result = mysql_query($sql);
                $row = mysql_fetch_row($sql);



	   		return $row;
        
        if(mysql_num_rows($result) == 0)
    	{
			return "Element not found.";
	   	}else{
	   		return $result[0];
		}
	}
	

	//Check to see if a device exists.
	//This is called during registration to make sure all user names are unique.
	public function checkDeviceExists($name) {
        $sql = 
            "(select * from literary_techniques WHERE name='$name')
            UNION
            (select * from literary_elements WHERE name='$name')
            UNION
            (select * from punctuation WHERE name='$name')
            UNION
            (select * from videos WHERE name='$name')";
		//$result = mysql_query("select id from literary_devices where name='$name'");
        $result = mysql_query($sql);
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}else{
	   		return true;
		}
	}
	
   
	public function getArticle($name) {
        //$db = new DB();
        //$result = $db->select('literary_devices', "name = $name");
        
        //$result = mysql_query("select article from literary_devices where name='$name'");
        //$row = mysql_fetch_row($result);
        //$name = $row[0];
        $sql = 
            mysql_query("(select article from home WHERE name='$name')
            UNION
            (select article from literary_techniques WHERE name='$name')
            UNION
            (select article from literary_elements WHERE name='$name')
            UNION
            (select article from punctuation WHERE name='$name')
            UNION
            (select article from videos WHERE name='$name')");
        
        $row = mysql_fetch_row($sql);
                $result = $row[0];


	   		return $result;
		
	}
	
    
	//get a device
	//returns a Device object. Takes the users id as an input
	public function get($id)
	{
		$db = new DB();
		$result = $db->select('literary_devices', "id = $id");
		
		return new Device($result);
	}
    

    
    public function getName($id) {
        
		$sql = mysql_query("select name from literary_devices where id='$id'");
        $row = mysql_fetch_row($sql);
        $name = $row[0];
        
	    return $name;
		
	}
    
    public function search($searchTerm) {
        
		$sql = 
            "(select * from literary_techniques WHERE name LIKE '%".$searchTerm."%')
            UNION
            (select * from literary_elements WHERE name LIKE '%".$searchTerm."%')
            UNION
            (select * from punctuation WHERE name LIKE '%".$searchTerm."%')
            UNION
            (select * from videos WHERE name LIKE '%".$searchTerm."%')";
        $result = mysql_query($sql);
        

        
        $storeArray = Array();
        while($row = mysql_fetch_array($result)){
            $storeArray[] =  $row['name'];
        }

        return $storeArray;
		
	}
	
    //Gets a column based on device-category
    public function getColumn($category){
        
        //$result = mysql_query("select * from literary_devices where category='$category'");
        $result = mysql_query("SELECT * FROM `$category` ORDER BY name");
        
        $storeArray = Array();
        while($row = mysql_fetch_array($result)){
            $storeArray[] =  $row['name'];
        }

        return $storeArray;
    }
    
    //Takes a device-name and returns the category of the device.
    public function getCategory($name)
    {   
        $result = mysql_query("select * from literary_techniques WHERE name='$name'");
        if(mysql_num_rows($result) != 0)
        {
            return "literary_techniques";
        }
        
        
        $result = mysql_query("select * from literary_elements WHERE name='$name'");
        if(mysql_num_rows($result) != 0)
        {
            return "literary_elements";
        }
        
        $result = mysql_query("select * from punctuation WHERE name='$name'");
        if(mysql_num_rows($result) != 0)
        {
            return "punctuation";
        }
        
        $result = mysql_query("select * from videos WHERE name='$name'");
        if(mysql_num_rows($result) != 0)
        {
            return "videos";
        }
        
        $result = mysql_query("select * from home WHERE name='$name'");
        if(mysql_num_rows($result) != 0)
        {
            return "home";
        }
    }
    
    //Takes a device-name and returns the category of the device.
    public function getAuthor($name){ 
        $category = $this->getCategory($name);
        $result = mysql_query("SELECT author FROM '$category' WHERE name='$name'");
        return $result[0];
    }
    
    public function delete($name, $category){
            $sql = "DELETE FROM $category WHERE name='".$name."' ";
            mysql_query($sql);
        echo $sql;
    }
}

?>