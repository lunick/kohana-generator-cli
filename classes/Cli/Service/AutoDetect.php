<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Service_AutoDetect {

    public static function table_names_plural() {
        $tables = Database::instance()->list_tables();
        $disabled = array("users", "user_tokens", "roles", "roles_users");
        
        foreach ($tables as $table) {
            if (!in_array($table, $disabled)) 
            {
                if ($table === Inflector::singular($table)) 
                {
                    return false;
                }
            }
        }

        return true;
    }

}

?>
