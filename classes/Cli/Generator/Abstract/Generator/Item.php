<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
abstract class Cli_Generator_Abstract_Generator_Item {

    protected $table;
    private $rows = array();
    private $error;
    private $generated_file;
    private $generated_backup;
    private $filename;
    private $ext;
    private $directory;
    private $subdirectory;
    private $upper_first = false;

    public function __construct($filename = null, $table = null) {
        $this->filename = $filename;
        $this->table = $table;
    }

    public function setup($num, $disable_head = false) {
        $this->ext = Cli_Util_System::extension($num);
        $this->upper_first = Cli_Util_System::upper_first($num);
        if ($this->ext == "php" && $disable_head === false) 
        {
            $this->add_row(Cli_Util_ConfigReader::get_key("start_php_file"));
            $this->add_row("<?php");
            $this->add_row("/**");
            $this->add_row(" * @package");
            $this->add_row(" * @author " . Cli_Util_ConfigReader::get_key("author"));
            $this->add_row(" * @license " . Cli_Util_ConfigReader::get_key("license"));
            $this->add_row(" * @copyright (c) " . date("Y") . " " . Cli_Util_ConfigReader::get_key("author"));
            $this->add_row(" *");
            $this->add_row(" */");
        }

        $this->directory = Cli_Util_System::paths($num);
        return $this;
    }

    public function get_error() {
        return $this->error;
    }

    public function set_error($error) {
        $this->error = $error;
        return $this;
    }

    public function get_generated_file() {
        return $this->generated_file;
    }

    public function set_generated_file($generated_file) {
        $this->generated_file = $generated_file;
        return $this;
    }

    public function get_generated_backup() {
        return $this->generated_backup;
    }

    public function set_generated_backup($generated_backup) {
        $this->generated_backup = $generated_backup;
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
        foreach ($this->rows as $row) {
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

    public function get_directory() {
        return $this->directory;
    }

    public function set_subdirectory($subdirectory) {
        $this->subdirectory = $subdirectory;
        return $this;
    }

    public function get_subdirectory() {
        return $this->upper_first() ? Cli_Util_Text::dir_separator_normalize_upperfirst($this->subdirectory) : Cli_Util_Text::dir_separator_normalize_lowercase($this->subdirectory);
    }

    public function add_row($row = "", $space_num = 0) {
        $this->rows[] = Cli_Util_Text::space($space_num) . $row . PHP_EOL;
        return $this;
    }

    public function get_file() {
        return $this->get_filename() . "." . $this->get_ext();
    }

    public function get_dir_path() {
        if ($this->get_subdirectory() != null) {
            return $this->get_directory() . $this->get_subdirectory() . DIRECTORY_SEPARATOR;
        }
        return $this->get_directory();
    }

    public function get_file_path() {
        return $this->get_dir_path() . $this->get_file();
    }

    public function directory_exists() {
        return file_exists($this->get_dir_path());
    }

    public function file_exists() {
        return file_exists($this->get_file_path());
    }

    public function init_name() {
        if (!empty($this->filename)) 
        {
            $name = $this->upper_first() ? Cli_Util_Text::upper_first_file_name($this->filename) : Cli_Util_Text::lower_file_name($this->filename);
            $this->set_filename($name);
        }
        else if (empty($this->filename) && !empty($this->table)) 
        {
            $driver = Cli_Database_Mysql_Driver::factory();
            $name = $this->upper_first() ? Cli_Util_Text::upper_first_file_name($driver->name($this->table)) : Cli_Util_Text::lower_file_name($driver->name($this->table));
            $this->set_filename($name);
        } 
        else 
        {
            throw new Exception("Empty filename and table name!");
        }
    }

    public function write($force = false, $backup = false) {
        $this->init();
        $this->init_name();
        $content = $this->get_rows_as_string();
        if (!empty($content)) {
            if (!$this->directory_exists())
            {
                Cli_Service_Dir::factory()
                        ->mkdir($this->get_dir_path());
            }

            if (is_writable($this->get_dir_path())) 
            {
                if ($this->file_exists() && $backup) 
                {
                    $backup = Cli_Service_Backup::backup($this->get_file_path());
                    $this->set_generated_backup($backup);
                }

                if (!$this->file_exists() || $force) 
                {
                    file_put_contents($this->get_file_path(), $content);
                    $this->set_generated_file($this->get_file_path());
                } 
                elseif ($this->file_exists() && !$force) 
                {
                    $this->set_error("File exists: " . $this->get_file_path());
                }
            } 
            else 
            {
                $this->set_error("Directory not writable: " . $this->get_dir_path());
            }
        }
        return $this;
    }

    public abstract function init();
}

?>
