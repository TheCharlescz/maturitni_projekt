<?php

class ObjednavkaDB
{
    private $spojeni;
    public function __construct()
    {
        $this->spojeni = DB::vytvorSpojeni();
    }
	public function vytvorObjednavku($uzivatel_id, $doprava)
	{
		$dotaz = "INSERT INTO `objednavka` (`id`, `celkova_cena`, doprava , `zaptaceno`, `zpracovano`, `odeslano`, `vytvoreno_v`, uzivatel_id) VALUES (NULL, NULL, :doprava , NULL, NULL, NULL, CURRENT_TIMESTAMP, :uzivatel_id)";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":uzivatel_id", $uzivatel_id);
		$sql->bindParam(":doprava", $doprava);
		if ($sql->execute()) {
			return $this->spojeni->lastInsertId();
		} else {
			return false;
		}
	}
	public function doplnCenuObjednavky($celkova_cena, $id)
	{
		$dotaz = "UPDATE `objednavka` SET `celkova_cena` = :celkova_cena WHERE `objednavka`.`id` = :id";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":celkova_cena", $celkova_cena);
		$sql->bindParam("id", $id);
		if ($sql->execute()) {
			return $this->spojeni->lastInsertId();
		} else {
			return false;
		}
	}
	public function zaplatObjednavku($zaplaceno , $id)
	{
		$dotaz = "UPDATE `objednavka` SET `zaplaceno` = :zaplaceno WHERE `objednavka`.`id` = :id;";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":zaplaceno", $zaplaceno);
		$sql->bindParam("id", $id);
		if ($sql->execute()) {
			return $this->spojeni->lastInsertId();
		} else {
			return false;
		}
	}
	public function zabalObjednavku($zpracovalo, $id)
	{
		$dotaz = "UPDATE `objednavka` SET `zpracovalo` = :zpracovalo WHERE `objednavka`.`id` = :id;";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":zpracovalo", $zpracovalo);
		$sql->bindParam("id", $id);
		if ($sql->execute()) {
			return $this->spojeni->lastInsertId();
		} else {
			return false;
		}
	}
	public function odesliObjednavku($odeslano, $id)
	{
		$dotaz = "UPDATE `objednavka` SET `odeslano` = :odeslano WHERE `objednavka`.`id` = :id;";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":odeslano", $odeslano);
		$sql->bindParam("id", $id);
		if ($sql->execute()) {
			return $this->spojeni->lastInsertId();
		} else {
			return false;
		}
	}
	public function vlozPolozkuDoObjednavky($objednavka_id, $produkt_id, $pocet_kusu, $velikost )
	{
		$dotaz = "	INSERT INTO `polozka` ( id, `objednavka_id`, `produkt_id`, `pocet_kusu`, `velikost`) VALUES (NULL, :objednavka_id, :produkt_id, :pocet_kusu, :velikost)";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":objednavka_id", $objednavka_id);
		$sql->bindParam(":produkt_id", $produkt_id);
		$sql->bindParam(":pocet_kusu", $pocet_kusu);
		$sql->bindParam(":velikost", $velikost);
		if ($sql->execute()) {
			return $this->spojeni->lastInsertId();
		} else {
			return false;
		}
	}
    public function nactiObjednavku($id, $razeni = "datum_vydani DESC")
    {
        $moznosti_razeni = array("id","nazev","text","popis","datum DESC");
        if (!in_array(strtolower($razeni), $moznosti_razeni)) {
            $razeni = "vytvoreno_v DESC";
        }
        $dotaz = "SELECT DISTINCT objednavka.* FROM objednavka where id=:id";
				$sql = $this->spojeni->prepare($dotaz);
				$sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "objednavka");
        return $sql->fetch();
    }
	public function nactiprodukty($razeni = "datum_vydani DESC")
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
        produkt.dostupnost
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
		where produkt.dostupnost = 1
        group by produkt.nazev
				";
		$sql = $this->spojeni->prepare($dotaz);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "produkt");
		return $sql->fetchAll();
	}
}
?>