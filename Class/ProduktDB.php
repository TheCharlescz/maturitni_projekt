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
        $dotaz = "SELECT DISTINCT
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
        group by produkt.nazev";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS,"produkt");
        return $sql->fetchAll();
    }
	public function nactiproduktypohlavi($pohlavi,$razeni = "datum_vydani DESC")
	{
		$moznosti_razeni = array("id", "nazev", "text", "popis", "datum DESC");
		if (!in_array(strtolower($razeni), $moznosti_razeni)) {
			$razeni = "vytvoreno_v DESC";
		}
		$dotaz = "SELECT DISTINCT
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
		where produkt.pohlavi = :pohlavi
        group by produkt.nazev";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":pohlavi", $pohlavi);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
		return $sql->fetchAll();
	}
	public function nactiTopProdukty($razeni = "datum_vydani DESC")
	{
		$moznosti_razeni = array("id", "nazev", "text", "popis", "datum DESC");
		if (!in_array(strtolower($razeni), $moznosti_razeni)) {
			$razeni = "vytvoreno_v DESC";
		}
		$dotaz = "SELECT DISTINCT
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
    JOIN akce ON produkt.akce_id = 1
    JOIN typy ON produkt.typy_id = typy.id
    JOIN kategorie ON produkt.kategorie_id = kategorie.id
    JOIN znacky ON produkt.znacky_id = znacky.id
    JOIN materialy ON produkt.materialy_id = materialy.id
        group by produkt.nazev
				LIMIT 4";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
		return $sql->fetchAll();
	}
	public function nactiZlevneneProdukty($razeni = "datum_vydani DESC")
	{
		$moznosti_razeni = array("id", "nazev", "text", "popis", "datum DESC");
		if (!in_array(strtolower($razeni), $moznosti_razeni)) {
			$razeni = "vytvoreno_v DESC";
		}
		$dotaz = "SELECT DISTINCT
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
    JOIN akce ON produkt.akce_id = 2
    JOIN typy ON produkt.typy_id = typy.id
    JOIN kategorie ON produkt.kategorie_id = kategorie.id
    JOIN znacky ON produkt.znacky_id = znacky.id
    JOIN materialy ON produkt.materialy_id = materialy.id
    group by produkt.nazev
		LIMIT 4";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
		return $sql->fetchAll();
	}
	public function nactiproduktykategorie($id, $razeni = "datum_vydani DESC")
	{
		$moznosti_razeni = array("id", "nazev", "text", "popis", "datum DESC");
		if (!in_array(strtolower($razeni), $moznosti_razeni)) {
			$razeni = "vytvoreno_v DESC";
		}
		$dotaz = "SELECT DISTINCT
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
    JOIN kategorie ON produkt.kategorie_id = :id
    JOIN znacky ON produkt.znacky_id = znacky.id
    JOIN materialy ON produkt.materialy_id = materialy.id
        group by produkt.nazev";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":id", $id);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
		return $sql->fetchAll();
	}

	public function filtraceProdkutu($pohlavi, $kategorie, $typ, $akce, $material, $znacka,$hledany_text)
	{
			$dotaz = "SELECT DISTINCT materialy.*, kategorie.*, akce.*, znacky.* , typy.* , produkt.* FROM produkt
			JOIN znacky ON produkt.znacky_id= znacky.id
			JOIN typy ON produkt.typy_id= typy.id
			JOIN materialy ON produkt.materialy_id = materialy.id
			JOIN akce ON produkt.akce_id = akce.id
			JOIN kategorie ON produkt.kategorie_id = kategorie.id";
			//$joiny = array();
			$where = array();
		//	if (!empty($kategorie)) {
		//		$joiny[] = "JOIN kategorie ON produkt.kategorie_id = $kategorie";
		//	}
		//	if (!empty($akce)) {
		//		$joiny[] = "JOIN akce ON produkt.akce_id = akce.id = $akce";
		//	}
		//if (!empty($material)) {
		//	$joiny[] = "JOIN materialy ON produkt.materialy_id = $material";
		//}
		//$joiny[] = "JOIN znacky ON produkt.znacky_id= znacky.id";
		//$joiny[] = "JOIN typy ON produkt.typy_id= typy.id";
		//if (!empty($barva)) {
		//		$joiny[] = "barva='$barva'";
		//	}
		//	if (!empty($velikost)) {
		//		$joiny[] = "$velikost='$velikost'";
		//	}
		//foreach ($joiny as $join) {
		//	$dotaz .=  " $join";
		//}
		if (!empty($pohlavi)) {
			$where[] = "produkt.pohlavi = '$pohlavi'";
		}
		if (!empty($znacka)) {
			$where[] = "znacky.znacka = '$znacka'";
		}
		if (!empty($typ)) {
			$where[] = "typy.typ = '$typ'";
		}
		if (!empty($material)) {
			$where[] = "materialy.material = '$material'";
		}
		if (!empty($kategorie)) {
			$where[] = "kategorie.kategorie = '$kategorie'";
		}
		if (!empty($akce)) {
			$where[] = "akce.akce = '$akce'";
		}
		if (!empty($hledany_text)) {
			$text = "%" . mb_strtolower($hledany_text, "UTF-8") . "%";
			$where[] = " lower(produkt.nazev) like :text";
		}
		if (count($where) > 0) {
			$dotaz .= " WHERE " . implode(' AND ', $where);
		}
		//$dotaz .= " group by produkt.nazev;";
		//$moznosti_razeni = array("id", "nazev", "text", "popis", "datum DESC");
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":text", $text);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
		return $sql->fetchAll();
	}
	public function filtraceOblibenychProdkutu($pohlavi, $kategorie, $typ, $akce, $material, $znacka, $hledany_text, $id)
	{
		$dotaz = "SELECT DISTINCT materialy.*, kategorie.*, akce.*, znacky.* , typy.* , produkt.* FROM produkt
			JOIN znacky ON produkt.znacky_id= znacky.id
			JOIN typy ON produkt.typy_id= typy.id
			JOIN materialy ON produkt.materialy_id = materialy.id
			JOIN akce ON produkt.akce_id = akce.id
			JOIN kategorie ON produkt.kategorie_id = kategorie.id
			join oblibene on oblibene.produkt_id = produkt.id";
		//$joiny = array();
		$where = array();
		//	if (!empty($kategorie)) {
		//		$joiny[] = "JOIN kategorie ON produkt.kategorie_id = $kategorie";
		//	}
		//	if (!empty($akce)) {
		//		$joiny[] = "JOIN akce ON produkt.akce_id = akce.id = $akce";
		//	}
		//if (!empty($material)) {
		//	$joiny[] = "JOIN materialy ON produkt.materialy_id = $material";
		//}
		//$joiny[] = "JOIN znacky ON produkt.znacky_id= znacky.id";
		//$joiny[] = "JOIN typy ON produkt.typy_id= typy.id";
		//if (!empty($barva)) {
		//		$joiny[] = "barva='$barva'";
		//	}
		//	if (!empty($velikost)) {
		//		$joiny[] = "$velikost='$velikost'";
		//	}
		//foreach ($joiny as $join) {
		//	$dotaz .=  " $join";
		//}
		if (!empty($pohlavi)) {
			$where[] = "produkt.pohlavi = '$pohlavi'";
		}
		if (!empty($znacka)) {
			$where[] = "znacky.znacka = '$znacka'";
		}
		if (!empty($typ)) {
			$where[] = "typy.typ = '$typ'";
		}
		if (!empty($material)) {
			$where[] = "materialy.material = '$material'";
		}
		if (!empty($kategorie)) {
			$where[] = "kategorie.kategorie = '$kategorie'";
		}
		if (!empty($akce)) {
			$where[] = "akce.akce = '$akce'";
		}

		if (!empty($hledany_text)) {
			$text = "%" . mb_strtolower($hledany_text, "UTF-8") . "%";
			$where[] = " lower(produkt.nazev) like :text";
		}
		if (count($where) > 0) {
			$dotaz .= " WHERE " . implode(' AND ', $where);
		}
		$dotaz .= " AND oblibene.uzivatel_id = :id";
		//$dotaz .= " group by produkt.nazev;";
		//$moznosti_razeni = array("id", "nazev", "text", "popis", "datum DESC");
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":text", $text);
		$sql->bindParam(":id", $id);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
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
	public function nactiOblibeneProduktyUzivatele($uzivatel_id, $razeni = "datum DESC")
	{
		$moznosti_razeni = array("id", "nadpis", "datum", "datum DESC");
		if (!in_array(strtolower($razeni), $moznosti_razeni)) {
			$razeni = "vytvoreno_v DESC";
		}
		$dotaz = "select DISTINCT
        produkt.id,
        akce.akce,
        kategorie.kategorie,
        materialy.material,
        znacky.znacka,
        typy.typ,
        produkt.nazev,
        produkt.popis,
        produkt.pohlavi,
        produkt.cena,
        produkt.sleva,
        produkt.dostupnost,
        produkt.vytvoreno_v,
        oblibene.*
        from  produkt
        join akce on produkt.akce_id = akce.id
        join typy on produkt.typy_id = typy.id
        join kategorie on produkt.kategorie_id = kategorie.id
        join znacky on produkt.znacky_id = znacky.id
        join materialy on produkt.materialy_id = materialy.id
        join oblibene on oblibene.produkt_id = produkt.id
        where oblibene.uzivatel_id = :id
        order by $razeni";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":id", $uzivatel_id);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
		return $sql->fetchAll();
	}
	public function nactiPocetOblibenychProduktuUzivatele($uzivatel_id, $razeni = "datum DESC")
	{
		$moznosti_razeni = array("id", "nadpis", "datum", "datum DESC");
		if (!in_array(strtolower($razeni), $moznosti_razeni)) {
			$razeni = "vytvoreno_v DESC";
		}
		$dotaz = "
	select DISTINCT
				COUNT(*) as 'pocet',
        oblibene.*
        from  produkt
        join oblibene on oblibene.produkt_id = produkt.id
        where oblibene.uzivatel_id = :id";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":id", $uzivatel_id);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
		return $sql->fetch();
	}
	public function ulozOblibenyProduktUzivatele($uzivatel_id, $produkt_id)
	{
		$dotaz = "INSERT INTO `oblibene` (`produkt_id`, `uzivatel_id`) VALUES (:produkt_id, :uzivatel_id);";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":produkt_id", $produkt_id);
		$sql->bindParam(":uzivatel_id", $uzivatel_id);
		if ($sql->execute()) {
			return $this->spojeni->lastInsertId();
		} else {
			return false;
		}
	}
	public function smazOblibeneProduktyUzivatele($id_uzivatel, $id_produkt)
	{
		$dotaz = "DELETE FROM oblibene
     WHERE oblibene.uzivatel_id = :id_uzivatel and oblibene.produkt_id = :id_produkt";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":id_uzivatel", $id_uzivatel);
		$sql->bindParam(":id_produkt", $id_produkt);
		return $sql->execute();
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
        where
				lower(nazev) like :text OR
				lower(znacka) like :text OR
				lower(pohlavi) like :text OR
				lower(material) like :text OR
				lower(kategorie) like :text OR
				lower(typ) like :text OR
				lower(akce) like :text";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":text", $text);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS,"produkt");
        return $sql->fetchAll();
    }
	public function najdiOblibenyProdukt($text, $id, $razeni = "datum DESC")
	{
		$moznosti_razeni = array("id", "nazev", "datum", "datum DESC");
		if (!in_array(strtolower($razeni), $moznosti_razeni)) {
			$razeni = "vytvoreno_v DESC";
		}
		$text = "%" . mb_strtolower($text, "UTF-8") . "%";
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
				join oblibene on oblibene.produkt_id = produkt.id
        where oblibene.uzivatel_id = :id AND
				lower(nazev) like :text OR
				lower(znacka) like :text OR
				lower(pohlavi) like :text OR
				lower(material) like :text OR
				lower(kategorie) like :text OR
				lower(typ) like :text OR
				lower(akce) like :text";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":text", $text);
		$sql->bindParam(":id", $id);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
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
    WHERE produkt.id = :id";
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