<?php 

class UzivatelDB {
    private $spojeni;

    public function __construct(){
        $this->spojeni = DB::vytvorSpojeni();
 }
 public function registraceUzivatele($uzivatel) {
    $dotaz= "INSERT INTO `uzivatel` (`id`, `heslo`, `email`, prava) VALUES (NULL, :heslo, :email, 1);";
    $sql = $this->spojeni->prepare($dotaz);
    $sql->bindParam(":email",$uzivatel->email);
    $sql->bindParam(":heslo",$uzivatel->heslo);
    if($sql->execute()){return $this->spojeni->lastInsertId();}
    else {return false;}
}

public function pridatUzivatele($uzivatel) {
    $dotaz= "INSERT INTO `uzivatel` (`id`, `jmeno`, `prijmeni`, `heslo`,`login`, `email`, `mesto`, `ulice`, `telkontakt`, `cislo_popisne`, `PSC`,`prava`,`registrovan_v`, `upraveno_v`) 
    VALUES (NULL, :jmeno, :prijmeni, :heslo, :login,:email, :mesto, :ulice, :telkontakt, :cislo_popisne, :PSC,:prava, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
    $sql = $this->spojeni->prepare($dotaz);
    $sql->bindParam(":jmeno",$uzivatel->jmeno);
    $sql->bindParam(":prijmeni",$uzivatel->prijmeni);
    $sql->bindParam(":heslo",$uzivatel->heslo);
    $sql->bindParam(":login",$uzivatel->login);
    $sql->bindParam(":email",$uzivatel->email);
    $sql->bindParam(":mesto",$uzivatel->mesto);
    $sql->bindParam(":ulice",$uzivatel->ulice);
    $sql->bindParam(":cislo_popisne",$uzivatel->cislo_popisne);
    $sql->bindParam(":PSC",$uzivatel->PSC);
    $sql->bindParam(":prava",$uzivatel->prava);
    $sql->bindParam(":telkontakt",$uzivatel->telkontakt);
    if($sql->execute()){return $this->spojeni->lastInsertId();}
    else {return false;}
}
public function overUzivatele($login,$heslo){
    $dotaz = "select *
    FROM uzivatel WHERE email=:email OR login=:login  LIMIT 1";
    $sql = $this->spojeni->prepare($dotaz);
    $sql->bindParam(":email",$login);
    $sql->bindParam(":login",$login);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_CLASS, "uzivatel");
    $uzivatel=$sql->fetch();
    //echo $uzivatel->heslo;
    if(password_verify($heslo,$uzivatel->heslo)){return $uzivatel;}
    //if($heslo==$uzivatel->heslo){return $uzivatel;}
    else {return false;}

}
public function nactiUzivatele($razeni = "prava DESC") {
    $moznosti_razeni = array("id","jmeno","prijmeni","login","heslo", "prava");
    if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = "prava DESC";}
    $dotaz = "select * from uzivatel 
    where uzivatel.prava <= 1
    order by $razeni";
    $sql = $this->spojeni->prepare($dotaz);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_CLASS,"uzivatel");
    return $sql->fetchAll();
}
public function nactiZamestnance($razeni = "prava DESC") {
    $moznosti_razeni = array("id","jmeno","prijmeni","login","heslo", "prava");
    if(!in_array(strtolower($razeni),$moznosti_razeni)){$razeni = "prava DESC";}
    $dotaz = "select * from uzivatel 
    where uzivatel.prava = 2
    order by $razeni";
    $sql = $this->spojeni->prepare($dotaz);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_CLASS,"uzivatel");
    return $sql->fetchAll();
}

public function nactiUzivatel($id) {
    $dotaz =" select * from uzivatel where id=:id";
    $sql = $this->spojeni->prepare($dotaz);
    $sql->bindParam(":id", $id);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_CLASS, "uzivatel");
    return $sql->fetch();

}

public function smazUzivatele($id) {
    $dotaz = "delete from uzivatel where id=:id";
    $sql = $this->spojeni->prepare($dotaz);
    $sql ->bindParam(":id",$id);
    return $sql->execute();

}

public function ulozUzivatele($uzivatel) {
    $dotaz = "update uzivatel set jmeno=:jmeno, prijmeni=:prijmeni,email=:email, login=:login, heslo=:heslo, prava=:prava, mesto=:mesto, ulice=:ulice, 
    cislo_popisne=:cislo_popisne, PSC=:PSC, telkontakt=:telkontakt where id=:id";
    $sql = $this->spojeni->prepare($dotaz);
    $sql->bindParam(":jmeno",$uzivatel->jmeno);
    $sql->bindParam(":prijmeni",$uzivatel->prijmeni);
    $sql->bindParam(":email",$uzivatel->email);
    $sql->bindParam(":login",$uzivatel->login);
    $sql->bindParam(":heslo",$uzivatel->heslo);
    $sql->bindParam(":prava",$uzivatel->prava);
    $sql->bindParam(":mesto",$uzivatel->mesto);
    $sql->bindParam(":ulice",$uzivatel->ulice);
    $sql->bindParam(":cislo_popisne",$uzivatel->cislo_popisne);
    $sql->bindParam(":PSC",$uzivatel->PSC);
    $sql->bindParam(":telkontakt",$uzivatel->telkontakt);
    $sql->bindParam(":id",$uzivatel->id);
    if($sql->execute()){return $uzivatel->id;}
    else {return false;}
}
}
?>
