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
    "dir_alias" => "Itt aliasként szám is használható a könyvtár megadásakor",
    "more_info" => "Több információ",
    
    //commands    
    "db:s" => "Adatbázis kapcsolat beállítása",
    "db:t" => "Adatbázis kapcsolat tesztelése",
    "db:l" => "Adatbázisban szereplő táblák listázása",
    "c:b" => "Backup fájlok törlése",
    "c:c" => "Cache ürítése",
    "c:l" => "Log fájlok törlése",
    "g:c" => "Controller generálása",
    "g:ct" => "Controller Template generálása",
    "g:v" => "Nézet generálása",
    "g:t" => "Template generálása",
    "g:vl" => "Lista nézet generálása",
    "g:vs" => "Show nézet generálása",
    "g:vf" => "Form generálása",
    "g:vd" => "Törlés nézet generálása",
    "g:o" => "Orm generálása adatbázisból",
    "g:m" => "Üres Model generálása",
    "g:l" => "Nyelvi fájl generálása adatbázisból",
    "g:cr" => "Crud vezérlők és nézeteinek a generálása adatbázisból",
    "g:b" => "Backup generálása",
    "g:au" => "Auth vezérlő és a hozzávaló nézet generálása",
    "g:as" => "Assets generálása (internet kapcsolat kell)",
);
?>