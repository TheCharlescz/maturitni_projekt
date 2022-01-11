<?php 
class ZnackaDB {
    private $spojeni;

    public function __construct(){
        $this->spojeni = DB::vytvorSpojeni();
 }
 
    public function nactiZnacky($razeni = "znacka"){
        $moznosti_razeni = array("znacka","id");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = $moznosti_razeni[0];}
        $dotaz = "select * from znacky order by $razeni";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "znacka");
        return $sql->fetchAll();
    }
    
    public function vlozZnacky($znacka){
        $dotaz = "insert into znacky (id,znacka) values (NULL,?)";
        $sql = $this->spojeni->prepare($dotaz);
        if($sql->execute(array($znacka->znacka))){return $this->spojeni->lastInsertid();}
        else {return false;}
    }
    public function nactiZnacku($id){
        $dotaz =" select * from znacky where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "znacka");
        return $sql->fetch();
    }
    public function smazZnacku($id) {
        $dotaz = "delete from znacky where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql ->bindParam(":id",$id);
        return $sql->execute();
    
    }
    
}
?>
