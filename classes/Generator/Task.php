<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
abstract class Generator_Task extends Minion_Task {
    
    private $template_class;
    
    protected function __construct() {
        parent::__construct();
    }
      
    protected function _execute(array $params) {
        if(!empty($params) && isset($params[1]))
        {
            $command = $params[1];
            $class = Generator_Register::get_class($command);
            $callback = Generator_Register::get_callback($command);
            $callback_params = Generator_Register::get_callback_params($command);
            
            if($class !== false)
            {
                $this->template_class = new $class;
                if(isset($this->template_class))
                {
                    $this->prompt();
                }
            }
            
            if($callback !== false)
            {
                call_user_func($callback, $callback_params);
            }
        }
        else
        {
            Cli_Help::print_commands();
        }
    }
        
    protected function prompt(){
        if($this->template_class instanceof Cli_Generator_Interface_Template)
        {
            $this->_options = $this->template_class
                        ->get_options_obj()
                        ->get_options();
            $read = true;
            $value = array();
            $prompt = $this->template_class->get_prompt_obj();

            foreach ($prompt->get_options() as $key => $param){
                $more = $prompt->get_more($key);
                
                if(!$this->template_class->get_options_obj()->is_skip($key)){
                    if($more)
                    {
                        $line = read_generator_line($prompt->get_prompt($key).": ");
                        if(0 < strlen($line)){ $value[] = $line; }

                        while($read){
                            $line = read_generator_line($prompt->get_prompt($key).": ");

                            if(0 < strlen($line)){
                                $value[] = $line;
                            }

                            if(!empty($value) && 0 == strlen($line))
                            {
                                $this->template_class->get_options_obj()->{$key} = array_filter(array_unique($value));
                                $value = array();
                                $read = false;
                            }
                        }

                    }
                    else
                    {
                        $line = read_generator_line($prompt->get_prompt($key).": ");
                        $accepted = $prompt->get_accepted($key);
                        if(0 < strlen($line))
                        {
                            if(!empty($accepted))
                            {
                                if(in_array($line, $accepted))
                                {
                                    $this->template_class->get_options_obj()->{$key} = $line;    
                                }
                            }
                            else
                            {
                                $this->template_class->get_options_obj()->{$key} = $line;
                            }
                        }
                    }

                }

            }

            try{
                Cli_Generator_Executor::factory($this->template_class)
                        ->execute()
                        ->print_result();
            }catch(Exception $e){
                println_error($e->getMessage());
            }
            
        }
        elseif ($this->template_class instanceof Cli_Generator_Interface_Service) 
        {
            $prompt = $this->template_class->get_prompt_obj();

            foreach ($prompt->get_options() as $key => $param){
                if(!$this->template_class->get_options_obj()->is_skip($key)){
                    
                    $line = read_generator_line($prompt->get_prompt($key).": ");
                    if(0 < strlen($line))
                    {
                        $this->template_class->get_options_obj()->{$key} = $line;
                    }
                }
            }
            
            try{
                $this->template_class->run();
            }catch(Exception $e){
                println_error($e->getMessage());
            }
            
        }
    }
     
}

?>
