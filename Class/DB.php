<?php

class DB {
    private const DSN ="mysql:host=db.mp.spse-net.cz;dbname=valentka18_1;charset=utf8";
    private const UZIVATEL = "valentka18";
    private const HESLO = "namitosafoji";
    private static $spojeni;

    
    public static function vytvorSpojeni() {
       
    if(!isset(self::$spojeni)){
        self::$spojeni = new PDO(self::DSN, self::UZIVATEL, self::HESLO);   
    }
    return self::$spojeni;
}
}

?>
