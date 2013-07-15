<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Executor {
    
    private $template = null;
    private $options_obj = null;
    private $result = null;
    
    public function __construct(Cli_Generator_Interface_Template $template) {
        $this->template = $template;
        $this->options_obj = $template->get_options_obj();
        $this->result = Cli_Generator_Result::factory();
    }
    
    public static function factory(Cli_Generator_Interface_Template $template){
        return new Cli_Generator_Executor($template);
    }

    private function run_writer($name=null, $dir=null, $force=false, $backup=false, $views=false, $actions=array()){
        $this->template->set_name($name);
        $this->template->set_subdir($dir);

        if($this->template instanceof Cli_Generator_Interface_Controller)
        {
            $this->template->set_actions($actions);
            if($views){ $this->template->with_views(); }
        }

        $this->template->init();
        $writers = $this->template->get_writers();
        if(!empty($writers))
        {
            foreach ($writers as $writer){
                if($writer instanceof Cli_Generator_Writer)
                {
                    gmkdirs($writer->get_dir());
                    $writer->write($force, $backup);
                    $this->result->add($writer);
                }
            }
        }        
    }
            
    public function execute(){
        $this->result->set_params($this->options_obj->get_options());
        if($this->options_obj->all)
        {
            $tables = Database::instance()->list_tables();
            $disabled = Cli_Util_ConfigReader::get_key("disabled_tables");
            foreach($tables as $table){
                $orm = Cli_Database_Orm::factory($table);
                if(!$orm->is_switch_table() && !in_array($orm->get_table_name(), $disabled))
                {
                    $this->run_writer($table, 
                            $this->options_obj->dir, 
                            $this->options_obj->force, 
                            $this->options_obj->backup, 
                            $this->options_obj->views, 
                            $this->options_obj->action);
                }
            }
        }
        else
        {
            if(isset($this->options_obj->name) && is_array($this->options_obj->name)){
                foreach ($this->options_obj->name as $name){
                    if(!empty($name)){
                        $this->run_writer($name, 
                                $this->options_obj->dir, 
                                    $this->options_obj->force, 
                                    $this->options_obj->backup, 
                                    $this->options_obj->views, 
                                    $this->options_obj->action);
                    }
                }
            }
            else
            {
                $this->run_writer(null, 
                        $this->options_obj->dir, 
                        $this->options_obj->force, 
                        $this->options_obj->backup, 
                        $this->options_obj->views, 
                        $this->options_obj->action);
            }
        }
        return $this;
    }
    
    public function print_result(){
        $this->result->print_result();
    }
}

?>
