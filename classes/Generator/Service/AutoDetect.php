<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Service_AutoDetect {

    public static function table_names_plural() {
        $table_names_plural = Session::instance()->get("table_names_plural");
        if($table_names_plural === null)
        {
            $table_names_plural = true;
            $tables = Database::instance()->list_tables();
            $disabled = array("users", "user_tokens", "roles", "roles_users");
            foreach ($tables as $table) {
                if (!in_array($table, $disabled)) 
                {
                    if ($table === Inflector::singular($table)) 
                    {
                        $table_names_plural = false;
                    }
                }
            }
            Session::instance()->set("table_names_plural", $table_names_plural);
        }
        return $table_names_plural;
    }

}

?>
