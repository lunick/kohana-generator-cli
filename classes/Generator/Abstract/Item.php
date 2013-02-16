<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
abstract class Generator_Abstract_Item implements Generator_Abstract_Item_Interface {
    
    protected $file_builder;
    protected $db_table;
    protected $filename;
    protected $table;
    
    public function __construct($filename=null, $table=null) {
        $this->file_builder = Generator_File_Builder::factory();
        $this->db_table = !empty($table) ? Generator_Database_Table::factory($table) : null;
        $this->filename = $filename;
        $this->table = $table;
    }
    
    public function init_name() {
        if(!empty($this->filename))
        {
            $name = $this->get_file_builder()->upper_first() ? Generator_Util_Text::upper_first_file_name($this->filename) : Generator_Util_Text::lower_file_name($this->filename);
            $this->file_builder->set_filename($name);
        }
        else if(empty ($this->filename) && !empty ($this->table))
        {
            if($this->db_table instanceof Generator_Database_Table)
            {
                $name = $this->get_file_builder()->upper_first() ? Generator_Util_Text::upper_first_file_name($this->db_table->get_name()) : Generator_Util_Text::lower_file_name($this->db_table->get_name());
                $this->file_builder->set_filename($name);
                
            }
        } 
        else
        {
            throw new Exception("Empty filename and table name!");
        }
    }
    
    /**
     * 
     * @return Generator_File_Builder
     */
    public function get_file_builder(){
        return $this->file_builder;
    }
    
}

?>
