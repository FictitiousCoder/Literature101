<?php
require_once 'DeviceTools.class.php';
require_once 'DB.class.php';


class Device {

	public $id;
	public $name;
	public $category;
	public $article;
	public $entry_date;
    public $author;

	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this->id = (isset($data['id'])) ? $data['id'] : "";
		$this->name = (isset($data['name'])) ? $data['name'] : "";
		$this->category = (isset($data['category'])) ? $data['category'] : "";
		$this->article = (isset($data['article'])) ? $data['article'] : "";
		$this->entry_date = (isset($data['entry_date'])) ? $data['entry_date'] : "";
        $this->author = (isset($data['author'])) ? $data['author'] : "";
	}

	public function save($isNewDevice = false) {
		//create a new database object.
		$db = new DB();

		//if the device is already registered and we're
		//just updating their info.
		if(!$isNewDevice) {
			//set the data array
			$data = array(
				//"name" => "'$this->name'",
				//"category" => "'$this->category'",
				"article" => "'$this->article'"
			);
			//$where = 'name = '.$this->name;
            //mysql_real_escape_string($this->article);
            //$sql = "UPDATE '$this->category' SET article='$this->article' WHERE name='$this->name'";
            //$sql = "UPDATE $table SET $column = $value WHERE $where";
                    //UPDATE `employees` SET `surname`="Kokiri" WHERE `first_name`="Link"
            //mysql_query($sql) or die(mysql_error());
			//update the row in the database
			$db->update($data, $this->category, "name = '$this->name'");
		}
        else {
		//if the device is being registered for the first time.
			$data = array(
				"name" => "'$this->name'",
				//"category" => "'$this->category'",
				"article" => "'$this->article'",
				"entry_date" => "'".date("Y-m-d H:i:s",time())."'",
                "author" => "'$this->author'"
			);
			//mysql_real_escape_string($data['article']);
			//$this->id = $db->insert($data, $this->category); //change second argument to $category
            $db->insert($data, $this->category);
			$this->entry_date = time();
            
            
            /*$sql = "INSERT INTO MyGuests (name_entry, category, article, entry_date)
VALUES ('Accumulation', 'Literary Techniques', 'Accumulation is derived from the latin word and this is a test god frickign damn it, please work already')";*/
		
		//return the ID of the user in the database.
		//return mysql_insert_id();
		}
		return true;
	}
    
//        public function delete($name, $category){
//            mysql_query("DELETE FROM `$category` WHERE name='$name'");
//        }
	
}

?>