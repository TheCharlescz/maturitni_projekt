<?php 
class AkceDB {
    private $spojeni;

    public function __construct(){
        $this->spojeni = DB::vytvorSpojeni();
 }
 
    public function nactiAkce($razeni = "akce"){
        $moznosti_razeni = array("akce","id");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = $moznosti_razeni[0];}
        $dotaz = "select id,akce from akce order by $razeni";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "akce");
        return $sql->fetchAll();
    }
    
    public function vlozAkce($akce){
        $dotaz = "insert into akce (id,akce) values (NULL,?)";
        $sql = $this->spojeni->prepare($dotaz);
        if($sql->execute(array($akce->akce))){return $this->spojeni->lastInsertid();}
        else {return false;}
    }
    public function nactiAkci($id){
        $dotaz =" select * from akce where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "akce");
        return $sql->fetch();
    }
    public function smazAkci($id) {
        $dotaz = "delete from akce where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql ->bindParam(":id",$id);
        return $sql->execute();
    
    }
    
}
?>
