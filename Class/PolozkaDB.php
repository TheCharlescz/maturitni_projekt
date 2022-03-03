<?php

class PolozkaDB
{
    private $spojeni;
    public function __construct()
    {
        $this->spojeni = DB::vytvorSpojeni();
    }

	public function nactiPolozkyObjednavky($id, $razeni = "datum_vydani DESC")
	{
		$moznosti_razeni = array("id", "nazev", "text", "popis", "datum DESC");
		if (!in_array(strtolower($razeni), $moznosti_razeni)) {
			$razeni = "vytvoreno_v DESC";
		}
		$dotaz = "SELECT  polozka.* , produkt.id, produkt.sleva, produkt.nazev, produkt.cena FROM produkt, polozka
  	where polozka.objednavka_id=:id AND polozka.produkt_id = produkt.id";

		$sql = $this->spojeni->prepare($dotaz);
		$sql->bindParam(":id", $id);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_CLASS, "polozka");
		return $sql->fetchAll();
	}
}