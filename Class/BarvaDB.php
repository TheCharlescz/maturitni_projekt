<?php
class BarvaDB {
    private $spojeni;

    public function __construct(){
        $this->spojeni = DB::vytvorSpojeni();
 }

    public function nactiBarvy($razeni = "id"){
        $moznosti_razeni = array("barvy","id");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = $moznosti_razeni[0];}
        $dotaz = "select * from barvy";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "barva");
        return $sql->fetchAll();
    }
    public function nactiProduktmaBarvy($id ,  $razeni = "id"){
        $moznosti_razeni = array("barvy","id");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = $moznosti_razeni[0];}
        $dotaz = "SELECT barvy.id, barvy.barva,produkt.id FROM barvy LEFT JOIN (SELECT * FROM produkt_ma_barvy WHERE produkt_id = :id) as ch ON ch.barvy_id = barvy.id LEFT JOIN produkt ON ch.produkt_id = produkt.id";
        $sql = $this->spojeni->prepare($dotaz);
				$sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "barva");
        return $sql->fetchall();
    }
    public function nactiBarvyProduktu($id) {
        $dotaz ="select distinct barvy.* from produkt_ma_barvy, produkt, barvy
        where produkt_ma_barvy.barvy_id=barvy.id and produkt_ma_barvy.produkt_id= :id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "barva");
        return $sql->fetchAll();

    }
    public function vlozBarvu($barva){
        $dotaz = "insert into barvy (id,barva) values (NULL,?)";
        $sql = $this->spojeni->prepare($dotaz);
        if($sql->execute(array($barva->barva))){return $this->spojeni->lastInsertid();}
        else {return false;}
    }
    public function vlozBarvuDoProduktu($produkt_id, $barva_id){
        $dotaz = "INSERT INTO `produkt_ma_barvy` (`produkt_id`, `barvy_id`) VALUES (:produkt_id, :barva_id)";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":produkt_id",$produkt_id);
        $sql->bindParam(":barva_id",$barva_id);
        if($sql->execute()){return $this->spojeni->lastInsertId();}
        else {return false;}
    }
    public function upravBarvuvProduktu($produkt_id, $barva_id){
        $dotaz = "UPDATE produkt_ma_barvy
        SET produkt_ma_barvy.barvy_id = :barva_id
        WHERE produkt_ma_barvy.produkt_id = :produkt_id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":produkt_id",$produkt_id);
        $sql->bindParam(":barva_id",$barva_id);
        if($sql->execute()){return $this->spojeni->lastInsertId();}
        else {return false;}
    }
    public function odeberBarvuProduktu($produkt_id ,$barva_id){
        $dotaz = "delete from `produkt_ma_barvy` where produkt_ma_barvy.barvy_id = :barva_id and produkt_ma_barvy.produkt_id = :produkt_id ";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":barva_id",$barva_id);
        $sql->bindParam(":produkt_id",$produkt_id);
        if($sql->execute()){return $this->spojeni->lastInsertId();}
        else {return false;}
    }
    public function nactiBarvu($id){
        $dotaz =" select * from barvy where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "barva");
        return $sql->fetch();
    }
    public function smazBarvu($id) {
        $dotaz = "delete from barvy where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql ->bindParam(":id",$id);
        return $sql->execute();

    }

}
?>