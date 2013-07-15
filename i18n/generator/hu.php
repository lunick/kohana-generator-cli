<?php defined("SYSPATH") or die("No direct script access.") ?>
<?php
/**
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
return array(
    
    "skip" => "(enterrel átléphető)",
    "yn" => "(y|n)",
    "force" => "Felülírja ha a fájl létezik",
    "backup" => "Backup fájl létrehozása amennyiben létezik",
    "generated_backup" => "Generált backup fájlok",
    "generated_files" => "Generált fájlok",
    "tables_in_database" => "Az adatbázisban található táblák",
    "model_name" => "Egy az adatbázisban szereplő tábla neve",
    "controller_name" => "Controller neve",
    "action_name" => "Action neve",
    "filename" => "Fájlnév",
    "dir" => "Könyvtár",
    "database" => "Adatbázis neve",
    "password" => "Adatbázishoz tartozó jelszó",
    "username" => "Adatbázishoz tartozó felhasználónév",
    "add_route" => "Hozzáadja az útvonalat a bootstrap fájlhoz\n(kockázatos művelet használd a backup funkciót)",
    "all_backup_delete" => "Törölje az összes backup fájlt a projektből",
    "generate_all_backup" => "Minden fájlról backup generálása",
    "all_orm" => "Összes ORM model generálása az adatbázisból",
    "all_model" => "Összes Model generálása az adatbázisból",
    "all_show" => "Összes nézet fájl generálása az adatbázisból",
    "all_list" => "Összes lista fájl generálása az adatbázisból",
    "all_form" => "Összes form generálása az adatbázisból",
    "all_delete" => "Összes törlés nézet fájl generálása az adatbázisból",
    "all_crud" => "Összes Crud vezérlő és a hozzá tartozó nézetek generálása az adatbázisból",
    "use" => "Használható parancs",
    
    //commands    
    "db:s" => "DataBase Setup",
    "db:t" => "DataBase Test connection",
    "db:l" => "DataBase List tables",
    "c:b" => "Clear Backups",
    "c:c" => "Clear Cache",
    "c:l" => "Clear Logs",
    "g:c" => "Generate Controller",
    "g:ct" => "Generate Controller Template",
    "g:v" => "Generate View",
    "g:t" => "Generate Template",
    "g:vl" => "Generate View List file",
    "g:vs" => "Generate View Show file",
    "g:vf" => "Generate View Form file",
    "g:vd" => "Generate View Delete file",
    "g:o" => "Generate Orm classes",
    "g:m" => "Generate Model classes",
    "g:l" => "Generate Language file",
    "g:cr" => "Generate CRud classes with views",
    "g:b" => "Generate Backups",
    "g:au" => "Generate AUth controller with view",
    "g:as" => "Generate ASsets",
    "h" => "Help",
    "help" => "Help",
);
?>