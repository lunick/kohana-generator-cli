<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Cli_Help {

    public static function tables($table_name) {
        $tables = Database::instance()->list_tables();
        echo PHP_EOL;
        echo Generator_Cli_Text::text('Table: ' . $table_name . ' doesn\'t exists!', Generator_Cli_Text::$red) . PHP_EOL;
        echo Generator_Cli_Text::text('Choose one from this list:', Generator_Cli_Text::$green) . PHP_EOL;
        self::print_tables($tables);
    }
    
    public static function options(array $options){
        echo PHP_EOL;
        echo 'You can use this options:'.PHP_EOL;
        foreach ($options as $key => $val){
            echo '--'.$key.'=param'.PHP_EOL;
        }
        echo PHP_EOL;
    }
    
    public static function force(array $options){
        echo PHP_EOL;
        echo Generator_Cli_Text::text('Try --force=yes option.'.PHP_EOL,Generator_Cli_Text::$green);
        echo 'More options:'.PHP_EOL;
        foreach ($options as $key => $val){
            echo '--'.$key.'=param'.PHP_EOL;
        }
        echo PHP_EOL;
    }
    
    public static function nothing(){
        echo PHP_EOL;
        echo Generator_Cli_Text::text('We did nothing!', Generator_Cli_Text::$green).PHP_EOL;
        echo PHP_EOL;
    }

    public static function print_tables(array $tables){
        $head_string = 'Tables in your Database';
        $head_string_length = strlen($head_string);
        $num = $head_string_length;
        $space = 10;
        
        foreach ($tables as $table){
            $tnum = strlen($table);
            if($num <= $tnum){
                $num = $tnum;
            }
        }
        $max_space = (2 * $space) + $num;
        
        echo PHP_EOL;
        echo Generator_Util_Text::space(5);     
        echo Generator_Cli_Text::text($head_string.":", Generator_Cli_Text::$yellow).PHP_EOL;
        
        self::print_table_top($max_space);
        foreach ($tables as $table){
            $right = (($max_space - $space) - strlen($table));
            self::print_table_line($table, $space, $right);
        }
        self::print_table_bottom($max_space);
        
    }
    
    private static function print_table_line($text, $left, $right){
        $right = $right - 1;
        echo Generator_Util_Text::space(5);
        echo Generator_Cli_Text::text('|', Generator_Cli_Text::$yellow);
        echo Generator_Util_Text::space(($left)).$text.Generator_Util_Text::space(($right));
        echo Generator_Cli_Text::text('|', Generator_Cli_Text::$yellow).PHP_EOL;
    }
    
    private static function print_table_top($num){
        $num = ($num-2);
        echo Generator_Util_Text::space(5);
        echo Generator_Cli_Text::text('+', Generator_Cli_Text::$yellow);
        for($i = 0; $i <= $num; ++$i){
            echo Generator_Cli_Text::text('-', Generator_Cli_Text::$yellow);
        }
        echo Generator_Cli_Text::text('+', Generator_Cli_Text::$yellow).PHP_EOL;
    }
    
    private static function print_table_bottom($num){
        $num = ($num-2);
        echo Generator_Util_Text::space(5);
        echo Generator_Cli_Text::text('+', Generator_Cli_Text::$yellow);
        for($i = 0; $i <= $num; ++$i){
            echo Generator_Cli_Text::text('-', Generator_Cli_Text::$yellow);
        }
        echo Generator_Cli_Text::text('+', Generator_Cli_Text::$yellow).PHP_EOL;
    }
}

?>
