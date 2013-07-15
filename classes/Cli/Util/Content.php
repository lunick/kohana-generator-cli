<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Util_Content {
    
    private $text;
    private $search_string;
    private $new_string;
    
    public static function factory(){
        return new Cli_Util_Content();
    }
    
    /**
     * 
     * @return Cli_Util_Content
     * @param string $text
     */
    public function set_text($text){
        $this->text = $text;
        return $this;
    }
    
    /**
     * 
     * @return string
     * Description return new string
     */
    public function get_text() {
        return $this->text;
    }
    
    /**
     * 
     * @return Cli_Util_Content
     * @param string $search_string
     */
    public function search_string($search_string) {
        $this->search_string = $search_string;
        return $this;
    }

    /**
     * 
     * @return Cli_Util_Content
     * @param string $name
     */
    public function new_string($new_string) {
        $this->new_string = $new_string;
        return $this;
    }
    
    /**
     * 
     * @return Cli_Util_Content
     */
    public function change(){
        $length = $this->strpos();
        $text_first = $this->substr($this->text, 0, $length);
        $text_last = $this->substr($this->text, $length+$this->search_string_length(), $this->strlen($this->text));
        $this->text = $text_first.$this->new_string.$text_last;
        return $this;
    }
    
    /**
     * 
     * @return Cli_Util_Content
     */
    public function cut_before(){
        $length = $this->strpos();
        if($length !== false){
            $text_first = $this->substr($this->text, 0, $length);
            $this->text = $text_first;
        }
        return $this;
    }
    
    /**
     * 
     * @return Cli_Util_Content
     */
    public function cut_after(){
        $length = $this->strpos();
        if($length !== false){
            $text_last = $this->substr($this->text, $length+$this->search_string_length(), $this->strlen($this->text));
            $this->text = $text_last;
        }
        return $this;
    }
    
    /**
     * 
     * @return boolean
     */
    public function find(){
        if($this->strpos() !== false){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 
     * @return array
     */
    public function get_text_as_array(){
        $rows = array();
        $array = explode("\n", $this->text);
        foreach ($array as $item){
            $line = trim($item);
            if(0 < $this->strlen($line))
            {
                $rows[] = $line;
            }
        }
        return $rows;
    }
    
    /**
     * 
     * @return Cli_Util_Content
     */
    public function append(){
        $this->text = $this->text.$this->new_string;
        return $this;
    }

    /**
     * 
     * @return int or false
     */
    public function strpos(){
        return mb_strpos($this->text, $this->search_string);
    }
    
    /**
     * 
     * @return int
     */
    public function search_string_length(){
        return $this->strlen($this->search_string);
    }

    /**
     * 
     * @param string $string
     * @return int
     */
    private function strlen($string){
        return mb_strlen($string);
    }
    
    /**
     * 
     * @param string $string
     * @param int $start
     * @param int $length
     * @return string
     */
    private function substr($string, $start, $length){
        return mb_substr($string, $start, $length);
    }
}

?>
