<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Options implements Cli_Generator_Interface_Options {
    
    private $aviable_values = array(
        "y" => true,
        "yes" => true,
        "n" => false,
        "no" => false,
    );
    
    private $boolean_keys = array("all", "views","force","backup");
    private $options = array();
    private $skip = array();
        
    /**
     * 
     * @param string $name
     * @return var
     */
    public function __get($name) {
        if(array_key_exists($name, $this->options)){
            return $this->options[$name];
        }
    }
    
    /**
     * 
     * @param var $name
     * @param var $value
     * @throws Exception
     */
    public function __set($name, $value) {
        if (array_key_exists($name, $this->options))
        {
            if(in_array($name, $this->boolean_keys)){
                $value = $this->aviable_values[$value];
            }
            $this->options[$name] = $value;
        }
        else
        {
            throw new Exception("Illegal argument: $name !");
        }
    }
    
    /**
     * 
     * @param var $name
     * @return boolean
     */
    public function __isset($name) {
        return isset($this->options[$name]);
    }
    
    /**
     * 
     * @param array $options
     * @return Cli_Generator_Options
     */
    public function set_options(array $options){
        $this->options = $options;
        return $this;
    }
    
    /**
     * 
     * @return array
     */
    public function get_options(){
        return $this->options;
    }
    
    /**
     * 
     * @param string $skip_key
     * @return boolean
     */
    public function is_skip($skip_key) {
        if(array_key_exists($skip_key, $this->skip))
        {
            $array = $this->skip[$skip_key];
            foreach ($array as $key => $val){
                if(isset($this->options[$key]) && $this->options[$key] == $val)
                {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 
     * @param string $key
     * @param string $skip_key
     * @param var $value
     * @return Cli_Generator_Options 
     */
    public function add_skip($key, $skip_key, $value) {
        $this->skip[$skip_key] = array($key => $value);
        return $this;
    }
}

?>
