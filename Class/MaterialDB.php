<?php 
class MaterialDB {
    private $spojeni;

    public function __construct(){
        $this->spojeni = DB::vytvorSpojeni();
 }
 
    public function nactiMaterialy($razeni = "id"){
        $moznosti_razeni = array("material","id");
        if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = $moznosti_razeni[0];}
        $dotaz = "select * from materialy order by $razeni";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "material");
        return $sql->fetchAll();
    }
    
    public function vlozMaterialy($material){
        $dotaz = "insert into materialy (id,material) values (NULL,?)";
        $sql = $this->spojeni->prepare($dotaz);
        if($sql->execute(array($material->material))){return $this->spojeni->lastInsertid();}
        else {return false;}
    }
    public function nactiMaterial($id){
        $dotaz =" select * from materialy where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_CLASS, "material");
        return $sql->fetch();
    }
    public function smazMaterial($id) {
        $dotaz = "delete from materialy where id=:id";
        $sql = $this->spojeni->prepare($dotaz);
        $sql ->bindParam(":id",$id);
        return $sql->execute();
    
    }
    
}
?>
