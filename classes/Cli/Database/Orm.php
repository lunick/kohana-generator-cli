<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Database_Orm {
    
    private $driver;
    private $table;
    
    public function __construct($table) {
        $driver = upper_first(Kohana::$config->load("database.default.type"));
        $driver_class = "Cli_Database_".$driver."_Driver";
        $this->driver = new $driver_class;
        $real_table = $this->driver->real_table_name($table);
        if($real_table !== false){
            $this->table = $real_table;
        }
        else
        {
            throw new Exception("Table: ".$table." doesn't exists!");
        }
    }
    
    public static function factory($table){
        return new Cli_Database_Orm($table);
    }
    
    public function has_many(){
        return 0 < count($this->driver->references_result($this->table)) ? true : false;
    }
    
    public function has_one_and_belongs_to(){
        return 0 < count($this->driver->relationship_result($this->table)) ? true : false;
    }
    
    public function get_has_many(){
        $result = $this->driver->references_result($this->table);
        $string = space(4) . "protected \$_has_many = array(".PHP_EOL;
        
        foreach($result as $obj){            
            if($this->driver->is_switch_table($obj->get_table_name()))
            {
                $switch_table_relationships = $this->driver->relationship_result($obj->get_table_name());
                $far_key = null;
                $foreign_key = null;
                $model = null;
                
                foreach ($switch_table_relationships as $far){
                    if($far->get_referenced_table_name() === $this->table){
                        $foreign_key = $far->get_column_name();
                    }else{
                        $far_key = $far->get_column_name();
                        $model = $far->get_referenced_table_name();
                    }
                    
                }
                
                $string .= space(8) . "'" . $this->driver->name($model) . "'" . " => array(".PHP_EOL;
                $string .= space(12) ."'model' => '" . upper_first($this->driver->name($model)) . "',".PHP_EOL;
                $string .= space(12)."'through' => '".$obj->get_table_name()."',".PHP_EOL;
                $string .= space(12)."'foreign_key' => '" . $foreign_key . "',".PHP_EOL;
                $string .= space(12)."'far_key' => '".$far_key."'".PHP_EOL;
                $string .= space(8)."),".PHP_EOL;
            }
            else
            {
                $string .= space(8) . "'" . $this->driver->name($obj->get_table_name()) . "'" . " => array('model' => '" 
                        . upper_first($this->driver->name($obj->get_table_name())) 
                        . "', 'foreign_key' => '" . $obj->get_column_name() . "'),".PHP_EOL;
            }
        }
        
        $string .= space(4) . ");".PHP_EOL.PHP_EOL;
        return $string;
    }
    
    public function get_has_one(){
        $result = $this->driver->relationship_result($this->table);
        $string = space(4) . "protected \$_has_one = array(".PHP_EOL;

        foreach ($result as $obj) {
            $string .= space(8) . "'" . $this->driver->name($obj->get_referenced_table_name()) 
                    . "'" . " => array('model' => '" . upper_first($this->driver->name($obj->get_referenced_table_name()))
                    . "', 'foreign_key' => '" . $obj->get_column_name() . "'),".PHP_EOL;
        }

        $string .= space(4) . ");".PHP_EOL.PHP_EOL;
        return $string;
    }
    
    public function get_belongs_to(){
        $result = $this->driver->relationship_result($this->table);
        $string = space(4) . "protected \$_belongs_to = array(".PHP_EOL;

        foreach ($result as $obj) {
            $string .= space(8) . "'" . $this->driver->name($obj->get_referenced_table_name()) 
                    . "'" . " => array('model' => '" . upper_first($this->driver->name($obj->get_referenced_table_name())) 
                    . "', 'foreign_key' => '" . $obj->get_column_name() . "'),".PHP_EOL;
        }

        $string .= space(4) . ");".PHP_EOL.PHP_EOL;
        return $string;
    }
    
    public function get_rules(){
        $fields = $this->driver->columns_result($this->table);
        $string = space(4) . "public function rules()".PHP_EOL;
        $string .= space(4) . "{".PHP_EOL;
        $string .= space(8) . "return array(".PHP_EOL;

        foreach ($fields as $field) {
            if (!$field->is_primary_key()) 
            {
                $string .= space(12) . "'" . $field->get_name() . "' => array(" . $this->field_rule($field);
                $string .= space(12) . "),".PHP_EOL;
            }
        }

        $string .= space(8) . ");".PHP_EOL;
        $string .= space(4) . "}".PHP_EOL;

        return $string;
    }

    public function get_filters(){
        $fields = $this->driver->columns_result($this->table);
        $string = space(4) . "public function filters()".PHP_EOL;
        $string .= space(4) . "{".PHP_EOL;
        $string .= space(8) . "return array(".PHP_EOL;
                
        foreach ($fields as $field) {
            if (!$field->is_primary_key() && !$field->is_foreign_key() && in_array($field->get_type(), array("varchar", "text"))) 
            {
                $string .= space(12) . "'" . $field->get_name() . "' => array(".PHP_EOL . space(16) . "array('UTF8::trim'),".PHP_EOL;
                $string .= space(12) . "),".PHP_EOL;
            }
        }

        $string .= space(8) . ");".PHP_EOL;
        $string .= space(4) . "}".PHP_EOL;
        return $string;
    }

    public function get_labels(){
        $string = space(4) . "public function labels()".PHP_EOL;
        $string .= space(4) . "{".PHP_EOL;
        $string .= $this->field_labels();
        $string .= space(8) . ");".PHP_EOL;
        $string .= space(4) . "}".PHP_EOL;
        return $string;
    }

    private function field_rule(Cli_Database_Mysql_Result_Field $field){
        $min = $field->get_min();
        $max = $field->get_max();
        $key = $field->get_key();

        $config = Cli_Util_ConfigReader::get_config();

        $validation = PHP_EOL . space(16) . "array('not_empty'),".PHP_EOL;

        switch ($field->get_type()) {
            case "datetime": $validation .= space(16) . "array('date',array(':value', '" . $config->datetime_format . "')),".PHP_EOL;
                break;
            case "date" : $validation .= space(16) . "array('date',array(':value', '" . $config->date_format . "')),".PHP_EOL;
                break;
            case "year" : $validation .= space(16) . "array('date',array(':value', 'Y')),".PHP_EOL;
                break;
            case "smallint" : $validation .= space(16) . "array('digit'),".PHP_EOL;
                break;
            case "smallint unsigned" : $validation .= space(16) . "array('digit'),".PHP_EOL;
                break;
            case "int" : $validation .= space(16) . "array('digit'),".PHP_EOL;
                break;
            case "int unsigned" : $validation .= space(16) . "array('digit'),".PHP_EOL;
                break;
            case "bigint" : $validation .= space(16) . "array('digit'),".PHP_EOL;
                break;
            case "bigint unsigned" : $validation .= space(16) . "array('digit'),".PHP_EOL;
                break;
            case "float" : $validation .= space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "float unsigned" : $validation .= space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "double" : $validation .= space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "double unsigned" : $validation .= space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "decimal" : $validation .= space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "decimal unsigned" : $validation .= space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "" : $validation .= "";
                break;
        }

        if (!empty($min) && !empty($max)) 
        {
            $validation .= space(16) . "array('min_length',array(':value', $min)),".PHP_EOL;
            $validation .= space(16) . "array('max_length',array(':value', $max)),".PHP_EOL;
        }

        if (empty($min) && !empty($max)) 
        {
            $validation .= space(16) . "array('max_length',array(':value', $max)),".PHP_EOL;
        }

        if (!empty($key) && $key == "UNI") 
        {
            $validation .= space(16) . "array(array(\$this, 'unique'), array('" . $field->get_name() . "', ':value')),".PHP_EOL;
        }

        return $validation;
    }

    private function field_labels(){
        $fields = $this->driver->columns_result($this->table);
        $labels = space(8) . "return array(".PHP_EOL;

        foreach ($fields as $obj) {
            $labels .= space(12) . "'".$obj->get_name()."' => __('" . $this->get_name() . ".".$obj->get_name()."'),".PHP_EOL;
        }

        $labels .= space(12) . "'submit' => __('" . $this->get_name() . ".submit'),".PHP_EOL;
        return $labels;
    }
    
    public function get_name(){
        return $this->driver->name($this->table);
    }
    
    public function name($table){
        return $this->driver->name($table);
    }
    
    public function get_table_name(){
        return $this->table;
    }
        
    public function get_class_name(){
        return upper_first(str_replace("_", "", $this->get_name()));
    }
        
    public function table_exists(){
        return in_array($this->table, $this->driver->list_tables());
    }
    
    public function is_switch_table(){
        return $this->driver->is_switch_table($this->table);
    }
    
    public function columns_result(){
        return $this->driver->columns_result($this->table);
    }
    
    public function get_primary_key_names(){
        return $this->driver->get_primary_key_names($this->table);
    }
    
    public function get_foreign_key_names(){
        $this->driver->get_foreign_key_names($this->table);
    }
    
    public function get_referenced_table_name($key){
        return $this->driver->get_referenced_table_name($this->table, $key);
    }
        
    public function relationship_result(){
        return $this->driver->relationship_result($this->table);
    }
    
    

}

?>
