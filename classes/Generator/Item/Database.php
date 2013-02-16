<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Item_Database extends Generator_Abstract_Item {
    
    private $in; 
    protected $filename = "database"; 
    private $search_username = "'username'   => FALSE";
    private $search_password = "'password'   => FALSE";
    private $search_database = "'database'   => 'kohana'";
        
    private $username;
    private $password;
    private $database;
    
    public function __construct() {
        parent::__construct($this->filename, null);
        $this->in = file_get_contents(MODPATH."database".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."database.php");
        Session::instance()->delete("table_names_plural");
    }
    
    public function init() {
        $new_username = "'username'   => '$this->username'";
        $new_password = "'password'   => '$this->password'";
        $new_database = "'database'   => '$this->database'";
        
        $text = Generator_Service_Content::factory()
                ->set_text($this->in)
                ->search_string($this->search_username)
                ->new_string($new_username)
                ->change()
                ->search_string($this->search_password)
                ->new_string($new_password)
                ->change()
                ->search_string($this->search_database)
                ->new_string($new_database)
                ->change()
                ->get_text();
                    
        $this->get_file_builder()
                ->setup(Generator_Util_Kohana::$CONFIG, true)
                ->add_row($text);
    }    
    
    public function set_username($username) {
        $this->username = $username;
        return $this;
    }

    public function set_password($password) {
        $this->password = $password;
        return $this;
    }

    public function set_database($database) {
        $this->database = $database;
        return $this;
    }


}

?>
