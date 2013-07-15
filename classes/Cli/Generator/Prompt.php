<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Prompt implements Cli_Generator_Interface_InteractivePrompt {
    
    private $prompt = array();
    private $accepted = array();
    private $required = array();
    private $options = array();
    
    
    
    /**
     * @param string $key, string $prompt_string, string $accepted_string, var default
     * @return Cli_Generator_Prompt
     */
    public function add_prompt($key, $prompt_string, $accepted_string=null, $default=null) {
        $this->prompt[$key] = $prompt_string;
        if($accepted_string !== null)
        {
            $this->accepted[$key] = trim($accepted_string);
        }
        $this->options[$key] = $default;
        return $this;
    }

    /**
     * @param string $key
     * @return string
     */
    public function get_accepted($key) {
        if(isset($this->accepted[$key])){
            $pos = mb_strpos($this->accepted[$key], "|");
            if($pos !== false)
            {
                return explode("|", $this->accepted[$key]);
            }
            else
            {
                return array($this->accepted[$key]);
            }
        }
        return array();
    }

    /**
     * @param string $key
     * @return string
     */
    public function get_prompt($key) {
        if(isset($this->prompt[$key])){
            return $this->prompt[$key];
        }
        return "#";
    }

    /**
     * @param string $key
     * @return Cli_Generator_Prompt
     */
    public function add_more($key) {
        $this->required[$key] = true;
        return $this;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function get_more($key) {
        if(isset($this->required[$key])){
            return $this->required[$key];
        }
        return false;
    }

    /**
     * 
     * @return array
     */
    public function get_options() {
        return $this->options;
    }
    
}

?>
