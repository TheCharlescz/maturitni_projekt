<?php 
class VelikostDB {
    private $spojeni;

    public function __construct(){
        $this->spojeni = DB::vytvorSpojeni();
 }
 
    public function nactiVelikosti($razeni = "id"){
        $moznosti_razeni = array("velikosti","id");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = $moznosti_razeni[0];}
        $dotaz = "select * from velikosti order by $razeni";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "velikost");
        return $sql->fetchAll();
    }
    public function nactiVelikostiProduktu($id) {
        $dotaz ="select distinct velikosti.* from produkt_ma_velikosti, velikosti
        where produkt_ma_velikosti.velikosti_id=velikosti.id and produkt_ma_velikosti.produkt_id=:id and velikosti.pocet_kusu != 0 ";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "velikost");
        return $sql->fetchAll();

    }
    public function nactiVelikostiProduktuEditace($id) {
        $dotaz ="select distinct velikosti.* from produkt_ma_velikosti, velikosti
        where produkt_ma_velikosti.velikosti_id=velikosti.id and produkt_ma_velikosti.produkt_id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "velikost");
        return $sql->fetchAll();

    }
    public function nactiVelikostiProduktuu() {
        $dotaz ="select distinct velikosti.* from produkt_ma_velikosti, velikosti, produkt
        where produkt_ma_velikosti.velikosti_id=velikosti.id and produkt_ma_velikosti.produkt_id=produkt.id and velikosti.pocet_kusu != 0 ";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "velikost");
        return $sql->fetchAll();

    }
    public function vlozVelikostDoProduktu($produkt_id, $velikost_id) {
        $dotaz = "INSERT INTO `produkt_ma_velikosti` (`produkt_id`, `velikosti_id`) VALUES (:produkt_id, :velikost_id);";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":produkt_id",$produkt_id);
        $sql->bindParam(":velikost_id",$velikost_id);
        if($sql->execute()){return $this->spojeni->lastInsertId();}
        else {return false;}
    }

    public function vlozVelikosti($velikosti){
        $dotaz = "insert into velikosti (id,velikost,pocet_kusu) values (NULL,:velikost,:pocet_kusu)";
        $sql = $this->spojeni->prepare($dotaz);
        foreach($velikosti as $velikost) {
            $sql->bindParam(":velikost", $velikost['velikost']);
            $sql->bindParam(":pocet_kusu", $velikost['pocet_kusu']);
            if($sql->execute(array($velikost->velikost))){return $this->spojeni->lastInsertid();}
            else {return false;}
        }
       
    }
    public function vlozVelikost($velikost){
        $dotaz = "insert into velikosti (id,velikost,pocet_kusu) values (NULL,:velikost,:pocet_kusu)";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":velikost",$velikost->velikost);
        $sql->bindParam(":pocet_kusu",$velikost->pocet_kusu);
        if($sql->execute()){return $this->spojeni->lastInsertId();}
        else {return false;}
    }
    public function ulozVelikost($velikost){
        $dotaz = "update velikosti set velikost = :velikost, pocet_kusu = :pocet_kusu where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":velikost",$velikost->velikost);
        $sql->bindParam(":pocet_kusu",$velikost->pocet_kusu);
        $sql->bindParam(":id",$velikost->id);
        if($sql->execute()){return $this->spojeni->lastInsertId();}
        else {return false;}
    }
    public function nactiVelikost($id){
        $dotaz =" select * from velikosti where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "velikost");
        return $sql->fetch();
    }
    public function smazVelikost($id) {
        $dotaz = "delete from velikosti where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql ->bindParam(":id",$id);
        return $sql->execute();
    
    }
    
}
?>
