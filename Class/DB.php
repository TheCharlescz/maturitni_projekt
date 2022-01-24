<?php

class DB {
    private const DSN ="mysql:host=localhost;dbname=infiltrated;charset=utf8";
    private const UZIVATEL = "root";
    private const HESLO = "";
    private static $spojeni;
		
    public static function vytvorSpojeni() {

    if(!isset(self::$spojeni)){
        self::$spojeni = new PDO(self::DSN, self::UZIVATEL, self::HESLO);
    }
    return self::$spojeni;
}
}
?>