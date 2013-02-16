<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Database_Orm {

    private $db_table;

    public function __construct(Generator_Database_Table $db_table) 
    {
        $this->db_table = $db_table;
    }

    public static function factory(Generator_Database_Table $db_table) 
    {
        return new Generator_Database_Orm($db_table);
    }

    public function get_relation_ships() 
    {
        $has_many = $this->db_table->get_has_many();
        $has_one = $this->db_table->get_has_one();
        $belongs_to = $this->db_table->get_belongs_to();
        $string = "";

        if (!empty($has_many)) 
        {
            $string .= Generator_Util_Text::space(4) . "protected \$_has_many = array(".PHP_EOL;

            foreach ($has_many as $array) {
                $string .= Generator_Util_Text::space(8) . "'" . $array["name"] . "'" . "=> array('model' => '" . Generator_Util_Text::name($array["name"]) . "', 'foreign_key' => '" . $array["foreign_key"] . "'),".PHP_EOL;
            }

            $string .= Generator_Util_Text::space(4) . ");".PHP_EOL.PHP_EOL;
        }

        if (!empty($has_one)) 
        {
            $string .= Generator_Util_Text::space(4) . "protected \$_has_one = array(".PHP_EOL;

            foreach ($has_one as $array) {
                $string .= Generator_Util_Text::space(8) . "'" . $array["name"] . "'" . "=> array('model' => '" . Generator_Util_Text::name($array["name"]) . "', 'foreign_key' => '" . $array["foreign_key"] . "'),".PHP_EOL;
            }

            $string .= Generator_Util_Text::space(4) . ");".PHP_EOL.PHP_EOL;
        }

        if (!empty($belongs_to))
        {
            $string .= Generator_Util_Text::space(4) . "protected \$_belongs_to = array(".PHP_EOL;

            foreach ($belongs_to as $array) {
                $string .= Generator_Util_Text::space(8) . "'" . $array["name"] . "'" . "=> array('model' => '" . Generator_Util_Text::name($array["name"]) . "', 'foreign_key' => '" . $array["foreign_key"] . "'),".PHP_EOL;
            }

            $string .= Generator_Util_Text::space(4) . ");".PHP_EOL.PHP_EOL;
        }

        return $string;
    }

    public function get_rules() 
    {
        $fields = $this->db_table->get_table_fields();
        $string = Generator_Util_Text::space(4) . "public function rules()".PHP_EOL;
        $string .= Generator_Util_Text::space(4) . "{".PHP_EOL;
        $string .= Generator_Util_Text::space(8) . "return array(".PHP_EOL;

        foreach ($fields as $field) {
            if (!$field->is_primary_key()) 
            {
                $string .= Generator_Util_Text::space(12) . "'" . $field->get_name() . "' => array(" . $this->field_rule($field);
                $string .= Generator_Util_Text::space(12) . "),".PHP_EOL;
            }
        }

        $string .= Generator_Util_Text::space(8) . ");".PHP_EOL;
        $string .= Generator_Util_Text::space(4) . "}".PHP_EOL;

        return $string;
    }

    public function get_filters() 
    {
        $fields = $this->db_table->get_table_fields();
        $string = Generator_Util_Text::space(4) . "public function filters()".PHP_EOL;
        $string .= Generator_Util_Text::space(4) . "{".PHP_EOL;
        $string .= Generator_Util_Text::space(8) . "return array(".PHP_EOL;
                
        foreach ($fields as $field) {
            if (!$field->is_primary_key() && !$field->is_foreign_key() && in_array($field->get_type(), array("varchar", "text"))) 
            {
                $string .= Generator_Util_Text::space(12) . "'" . $field->get_name() . "' => array(".PHP_EOL . Generator_Util_Text::space(16) . "array('UTF8::trim'),".PHP_EOL;
                $string .= Generator_Util_Text::space(12) . "),".PHP_EOL;
            }
        }

        $string .= Generator_Util_Text::space(8) . ");".PHP_EOL;
        $string .= Generator_Util_Text::space(4) . "}".PHP_EOL;

        return $string;
    }

    public function get_labels() 
    {
        $string = Generator_Util_Text::space(4) . "public function labels()".PHP_EOL;
        $string .= Generator_Util_Text::space(4) . "{".PHP_EOL;
        $string .= $this->field_labels();
        $string .= Generator_Util_Text::space(8) . ");".PHP_EOL;
        $string .= Generator_Util_Text::space(4) . "}".PHP_EOL;

        return $string;
    }

    private function field_rule(Generator_Database_Field $field) 
    {
        $min = $field->get_min();
        $max = $field->get_max();
        $key = $field->get_key();

        $config = Generator_Util_ConfigReader::get_config();

        $validation = PHP_EOL . Generator_Util_Text::space(16) . "array('not_empty'),".PHP_EOL;

        switch ($field->get_type()) {
            case "datetime": $validation .= Generator_Util_Text::space(16) . "array('date',array(':value', '" . $config->datetime_format . "')),".PHP_EOL;
                break;
            case "date" : $validation .= Generator_Util_Text::space(16) . "array('date',array(':value', '" . $config->date_format . "')),".PHP_EOL;
                break;
            case "year" : $validation .= Generator_Util_Text::space(16) . "array('date',array(':value', 'Y')),".PHP_EOL;
                break;
            case "smallint" : $validation .= Generator_Util_Text::space(16) . "array('digit'),".PHP_EOL;
                break;
            case "smallint unsigned" : $validation .= Generator_Util_Text::space(16) . "array('digit'),".PHP_EOL;
                break;
            case "int" : $validation .= Generator_Util_Text::space(16) . "array('digit'),".PHP_EOL;
                break;
            case "int unsigned" : $validation .= Generator_Util_Text::space(16) . "array('digit'),".PHP_EOL;
                break;
            case "bigint" : $validation .= Generator_Util_Text::space(16) . "array('digit'),".PHP_EOL;
                break;
            case "bigint unsigned" : $validation .= Generator_Util_Text::space(16) . "array('digit'),".PHP_EOL;
                break;
            case "float" : $validation .= Generator_Util_Text::space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "float unsigned" : $validation .= Generator_Util_Text::space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "double" : $validation .= Generator_Util_Text::space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "double unsigned" : $validation .= Generator_Util_Text::space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "decimal" : $validation .= Generator_Util_Text::space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "decimal unsigned" : $validation .= Generator_Util_Text::space(16) . "array('numeric'),".PHP_EOL;
                break;
            case "" : $validation .= "";
                break;
        }

        if (!empty($min) && !empty($max)) 
        {
            $validation .= Generator_Util_Text::space(16) . "array('min_length',array(':value', $min)),".PHP_EOL;
            $validation .= Generator_Util_Text::space(16) . "array('max_length',array(':value', $max)),".PHP_EOL;
        }

        if (empty($min) && !empty($max)) 
        {
            $validation .= Generator_Util_Text::space(16) . "array('max_length',array(':value', $max)),".PHP_EOL;
        }

        if (!empty($key) && $key == "UNI") 
        {
            $validation .= Generator_Util_Text::space(16) . "array(array(\$this, 'unique'), array('" . $field->get_name() . "', ':value')),".PHP_EOL;
        }

        return $validation;
    }

    private function field_labels() 
    {
        $fields = $this->db_table->list_table_fields();
        $labels = "";

        $labels .= Generator_Util_Text::space(8) . "return array(".PHP_EOL;

        foreach ($fields as $key => $value) {
            $labels .= Generator_Util_Text::space(12) . "'$key' => __('" . $this->db_table->get_name() . ".$key'),".PHP_EOL;
        }

        $labels .= Generator_Util_Text::space(12) . "'submit' => __('" . $this->db_table->get_name() . ".submit'),".PHP_EOL;
           
        return $labels;
    }

}

?>
