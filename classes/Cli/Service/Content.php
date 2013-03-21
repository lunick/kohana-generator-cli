<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Service_Content {
    
    private $text;
    private $search_string;
    private $new_string;
    
    public static function factory(){
        return new Cli_Service_Content();
    }
    
    public function set_text($text){
        $this->text = $text;
        return $this;
    }
    
    public function get_text() {
        return $this->text;
    }
    
    public function search_string($search_string) {
        $this->search_string = $search_string;
        return $this;
    }

    public function new_string($new_string) {
        $this->new_string = $new_string;
        return $this;
    }
    
    public function change(){
        $length = $this->strpos();
        $text_first = substr($this->text, 0, $length);
        $text_last = substr($this->text, $length+$this->search_string_length(), strlen($this->text));
        $this->text = $text_first.$this->new_string.$text_last;
        return $this;
    }
    
    public function cut_before(){
        $length = $this->strpos();
        if($length !== false){
            $text_first = substr($this->text, 0, $length);
            $this->text = $text_first;
        }
        return $this;
    }
    
    public function cut_after(){
        $length = $this->strpos();
        if($length !== false){
            $text_last = substr($this->text, $length+$this->search_string_length(), strlen($this->text));
            $this->text = $text_last;
        }
        return $this;
    }
    
    public function find(){
        if($this->strpos() !== false){
            return true;
        }else{
            return false;
        }
    }
    
    public function strpos(){
        return strpos($this->text, $this->search_string);
    }
    
    public function search_string_length(){
        return strlen($this->search_string);
    }

}

?>
