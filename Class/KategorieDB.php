<?php 
class KategorieDB {
    private $spojeni;

    public function __construct(){
        $this->spojeni = DB::vytvorSpojeni();
 }
 
    public function nactiKategorie($razeni = "kategorie"){
        $moznosti_razeni = array("kategorie","id");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = $moznosti_razeni[0];}
        $dotaz = "select id,kategorie from kategorie order by $razeni";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "kategorie");
        return $sql->fetchAll();
    }
    
    public function vlozkategorie($kategorie){
        $dotaz = "insert into kategorie (id,kategorie) values (NULL,?)";
        $sql = $this->spojeni->prepare($dotaz);
        if($sql->execute(array($kategorie->kategorie))){return $this->spojeni->lastInsertid();}
        else {return false;}
    }
    public function nactiKategorii($id){
        $dotaz =" select * from kategorie where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "kategorie");
        return $sql->fetch();
    }
    public function smazKategorii($id) {
        $dotaz = "delete from kategorie where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql ->bindParam(":id",$id);
        return $sql->execute();
    
    }
    
}
?>
