<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
abstract class Generator_Task extends Minion_Task {
    
    protected $result;
    
    protected function __construct() {
        parent::__construct();
        $this->result = Generator_Result::factory();
    }
    
    protected function add(Cli_Generator_Abstract_Generator_Item $item){
        $this->result->add($item);
    }
    
    protected function _execute(array $params) {
        $this->before_execute($params);
        $this->_init($params);
        $this->after_execute($params);
        $this->result->set_params($params);
        $this->result->print_result();
    }
    
    protected function before_execute(array $params){}
    
    protected function after_execute(array $params){}
    
    protected abstract function _init(array $params);
}

?>
