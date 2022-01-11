<?php 

class  ProduktDB {
   private $spojeni;

   public function __construct(){
       $this->spojeni = DB::vytvorSpojeni();
}
    public function vlozProdukt($produkt) {
        $dotaz= "INSERT INTO `produkt` (`id`, `nazev`, `popis`, `cena`, `sleva`, `pohlavi`, `dostupnost`, vytvoreno_v, upraveno_v, publikovano_v, `akce_id`, `kategorie_id`, `materialy_id`, `znacky_id`, `uzivatel_id`, `typy_id`) 
        VALUES ( NULL, :nazev, :popis , :cena , :sleva , :pohlavi , :dostupnost , CURRENT_TIMESTAMP , NULL , NULL , :akce_id , :kategorie_id , :materialy_id , :znacky_id , :uzivatel_id ,:typy_id )";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":nazev",$produkt->nazev);
        $sql->bindParam(":popis",$produkt->popis);
        $sql->bindParam(":cena",$produkt->cena);
        $sql->bindParam(":sleva",$produkt->sleva);
        $sql->bindParam(":pohlavi",$produkt->pohlavi);
        $sql->bindParam(":dostupnost",$produkt->dostupnost);
        $sql->bindParam(":typy_id",$produkt->typy_id);
        $sql->bindParam(":akce_id",$produkt->akce_id);
        $sql->bindParam(":uzivatel_id",$produkt->uzivatel_id);
        $sql->bindParam(":kategorie_id",$produkt->kategorie_id);
        $sql->bindParam(":materialy_id",$produkt->materialy_id);
        $sql->bindParam(":znacky_id",$produkt->znacky_id);
        if($sql->execute()){return $this->spojeni->lastInsertId();}
        else {return false;}
    }
    public function nactiprodukty($razeni = "datum_vydani DESC") {
        $moznosti_razeni = array("id","nazev","text","popis","datum DESC");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = "vytvoreno_v DESC";}
        $dotaz ="SELECT DISTINCT
        velikosti.velikost,
        barvy.barva ,
        akce.akce,
        kategorie.kategorie,
        materialy.material,
        znacky.znacka,
        produkt.uzivatel_id,
        typy.typ,
        produkt.id,
        produkt.nazev,
        produkt.popis,
        produkt.pohlavi,
        produkt.cena,
        produkt.sleva,
        produkt.dostupnost,
        produkt.vytvoreno_v
    FROM
        produkt_ma_barvy,
        produkt_ma_velikosti,
        barvy,
        velikosti,
        produkt
    JOIN akce ON produkt.akce_id = akce.id
    JOIN typy ON produkt.typy_id = typy.id
    JOIN kategorie ON produkt.kategorie_id = kategorie.id
    JOIN znacky ON produkt.znacky_id = znacky.id
    JOIN materialy ON produkt.materialy_id = materialy.id
    WHERE
        produkt_ma_velikosti.produkt_id = produkt.id AND
        produkt_ma_velikosti.velikosti_id = velikosti.id AND
        produkt_ma_barvy.produkt_id = produkt.id AND
        produkt_ma_barvy.barvy_id = barvy.id
        group by produkt.nazev";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS,"produkt");
        return $sql->fetchAll();
    }
    public function nactiProduktyUzivatele($uzivatel_id, $razeni = "datum DESC"){
        $moznosti_razeni = array("id", "nadpis", "datum", "datum DESC");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = "vytvoreno_v DESC";}
        $dotaz = "select 
        produkt.id,
        akce.akce,
        kategorie.kategorie,
        materialy.material,
        znacky.znacka,
        produkt.uzivatel_id,
        typy.typ,
        produkt.nazev,
        produkt.popis,
        produkt.pohlavi,
        produkt.cena,
        produkt.sleva,
        produkt.dostupnost,
        produkt.vytvoreno_v
        from produkt 
        join akce on produkt.akce_id = akce.id
        join typy on produkt.typy_id = typy.id
        join kategorie on produkt.kategorie_id = kategorie.id
        join znacky on produkt.znacky_id = znacky.id
        join materialy on produkt.materialy_id = materialy.id
        where uzivatel.id = produkt.uzivatel_id
        order by $razeni";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":uzivatel_id", $uzivatel_id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS,"produkt");
        return $sql->fetchAll();
    }
    public function najdiProdukt($text, $razeni = "datum DESC"){
        $moznosti_razeni = array("id", "nazev", "datum", "datum DESC");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = "vytvoreno_v DESC";}
        $text = "%".mb_strtolower($text, "UTF-8")."%";
        $dotaz = "select 
        produkt.id,
        akce.akce,
        kategorie.kategorie,
        materialy.material,
        znacky.znacka,
        produkt.uzivatel_id,
        typy.typ,
        produkt.nazev,
        produkt.popis,
        produkt.pohlavi,
        produkt.cena,
        produkt.sleva,
        produkt.dostupnost,
        produkt.vytvoreno_v
        from produkt 
        join akce on produkt.akce_id = akce.id
        join typy on produkt.typy_id = typy.id
        join kategorie on produkt.kategorie_id = kategorie.id
        join znacky on produkt.znacky_id = znacky.id
        join materialy on produkt.materialy_id = materialy.id
        where lower(nazev) like :text or lower(popis_bez_html) Like :text order by $razeni";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":text", $text);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS,"produkt");
        return $sql->fetchAll();

    }
    public function nactiProdukt($id) {
        $dotaz ="SELECT DISTINCT
        velikosti.velikost,
        barvy.barva ,
        akce.akce,
        kategorie.kategorie,
        materialy.material,
        znacky.znacka,
        typy.typ,
        produkt.id,
        produkt.nazev,
        produkt.popis,
        produkt.pohlavi,
        produkt.cena,
        produkt.sleva,
        produkt.uzivatel_id,
        produkt.akce_id,
        produkt.materialy_id,
        produkt.kategorie_id,
        produkt.typy_id,
        produkt.znacky_id,
        produkt.dostupnost,
        produkt.vytvoreno_v
    FROM
        produkt_ma_barvy,
        produkt_ma_velikosti,
        barvy,
        velikosti,
        produkt
    JOIN akce ON produkt.akce_id = akce.id
    JOIN typy ON produkt.typy_id = typy.id
    JOIN kategorie ON produkt.kategorie_id = kategorie.id
    JOIN znacky ON produkt.znacky_id = znacky.id
    JOIN materialy ON produkt.materialy_id = materialy.id
    WHERE
        produkt_ma_velikosti.produkt_id = produkt.id AND
        produkt_ma_velikosti.velikosti_id = velikosti.id AND
        produkt_ma_barvy.produkt_id = produkt.id AND
        produkt_ma_barvy.barvy_id = barvy.id AND
        produkt.id = :id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
        return $sql->fetch();

    }
    public function smazProdukt($id) {
        $dotaz = "delete from produkt where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql ->bindParam(":id",$id);
        return $sql->execute();

    }
    public function ulozProdukt($produkt) {
        $dotaz = "update produkt set typy_id=:typy_id,akce_id=:akce_id,uzivatel_id=:uzivatel_id, 
        kategorie_id=:kategorie_id, materialy_id=:materialy_id, znacky_id=:znacky_id,
        nazev=:nazev,cena=:cena,pohlavi=:pohlavi,popis=:popis, sleva=:sleva, dostupnost=:dostupnost
        where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":typy_id",$produkt->typy_id);
        $sql->bindParam(":akce_id",$produkt->akce_id);
        $sql->bindParam(":uzivatel_id",$produkt->uzivatel_id);
        $sql->bindParam(":kategorie_id",$produkt->kategorie_id);
        $sql->bindParam(":materialy_id",$produkt->materialy_id);
        $sql->bindParam(":znacky_id",$produkt->znacky_id);
        $sql->bindParam(":nazev",$produkt->nazev);
        $sql->bindParam(":cena",$produkt->cena);
        $sql->bindParam(":pohlavi",$produkt->pohlavi);
        $sql->bindParam(":popis",$produkt->popis);
        $sql->bindParam(":sleva",$produkt->sleva);
        $sql->bindParam(":id",$produkt->id);
        $sql->bindParam(":dostupnost",$produkt->dostupnost);
        if($sql->execute()){return $produkt->id;}
        else {return false;}
    }
    public function ulozObrazekdoDatabaze($nazev, $id, $produkt) {
        $dotaz = "update produkt set obrazek=:obrazek where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":obrazek",$produkt->nazev);
        $sql->bindParam(":id", $produkt->id);

        if($sql->execute()){return $produkt->id;}
        else {return false;}
    }
}
?>
