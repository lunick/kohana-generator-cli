<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_File_Builder {
    
    private $rows = array();
    private $filename;
    private $ext;
    private $dir;
    private $upper_first = false;
    
    public function setup($num, $disable_head=false) {
        $this->set_extension($num, $disable_head);
        $this->dir = Generator_Util_Kohana::paths($num);
        return $this;
    }
        
    private function set_extension($num, $disable_head){
        $this->ext = Generator_Util_Kohana::extension($num);
        $this->upper_first = Generator_Util_Kohana::upper_first($num);
        if($this->ext == "php" && $disable_head === false)
        {
            $this->add_row(Generator_Util_ConfigReader::get_key("start_php_file"));
            $this->add_row("<?php");
            $this->add_row("/**");
            $this->add_row(" * @package");
            $this->add_row(" * @author " . Generator_Util_ConfigReader::get_key("author"));
            $this->add_row(" * @license " . Generator_Util_ConfigReader::get_key("license"));
            $this->add_row(" * @copyright (c) " . date("Y") . " " . Generator_Util_ConfigReader::get_key("author"));
            $this->add_row(" *");
            $this->add_row(" */");
        }
        
        return $this;
    }
    
    public function upper_first() {
        return $this->upper_first;
    }
    
    public function get_rows_as_array() {
        return $this->rows;
    }
    
    public function get_rows_as_string() {
        $string = "";
        foreach ($this->rows as $row){
            $string .= $row;
        }
        return $string;
    }

    public function get_filename() {
        return $this->filename;
    }

    public function set_filename($filename) {
        $this->filename = $filename;
        return $this;
    }

    public function get_ext() {
        return $this->ext;
    }
    
    public function get_dir() {
        return $this->dir;
    }
    
    public function add_row($row="", $space_num=0){
        $this->rows[] = Generator_Util_Text::space($space_num).$row.PHP_EOL;
        return $this;
    }

    
    public static function factory(){
        return new Generator_File_Builder();
    }
}

?>
