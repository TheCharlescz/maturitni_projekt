<?php
class TypDB{
    private $spojeni;

    public function __construct(){
        $this->spojeni = DB::vytvorSpojeni();
 }
 
public function nactiTypy($razeni = "typ"){
    $moznosti_razeni = array("typ","id");
    if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = $moznosti_razeni[0];}
    $dotaz = "select id,typ from typy order by $razeni";
    $sql = $this->spojeni->prepare($dotaz);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_CLASS, "typ");
    return $sql->fetchAll();
}

public function vlozTyp($typ){
    $dotaz = "insert into typy (id,typ) values (NULL,?)";
    $sql = $this->spojeni->prepare($dotaz);
    if($sql->execute(array($typ->typ))){return $this->spojeni->lastInsertid();}
    else {return false;}
}
public function nactiTyp($id){
    $dotaz =" select * from typy where id=:id";
    $sql = $this->spojeni->prepare($dotaz);
    $sql->bindParam(":id", $id);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_CLASS, "typ");
    return $sql->fetch();
}
public function smazTyp($id) {
    $dotaz = "delete from typy where id=:id";
    $sql = $this->spojeni->prepare($dotaz);
    $sql ->bindParam(":id",$id);
    return $sql->execute();
}
}
?>
