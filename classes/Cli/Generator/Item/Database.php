<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Database extends Cli_Generator_Abstract_Generator_Item {
    
    private $in; 
    protected $filename = "database"; 
    private $search_username = "'username'   => FALSE";
    private $search_password = "'password'   => FALSE";
    private $search_database = "'database'   => 'kohana'";
        
    private $username;
    private $password;
    private $database;
    
    public function __construct($username = null, $password = null, $database = null) {
        parent::__construct($this->filename, null);
        $this->in = file_get_contents(MODPATH."database".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."database.php");
        $this->set_username($username);
        $this->set_password($password);
        $this->set_database($database);
    }
    
    public function init() {
        $new_username = "'username'   => '$this->username'";
        $new_password = "'password'   => '$this->password'";
        $new_database = "'database'   => '$this->database'";
        
        $text = Cli_Service_Content::factory()
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
                    
        $this->setup(Cli_Util_System::$CONFIG, true)
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

    public static function factory($username = null, $password = null, $database = null){
        return new Cli_Generator_Item_Database($username, $password, $database);
    }

}

?>
