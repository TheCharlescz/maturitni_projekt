<?php
class Barva {
    public $id;
    public $barva;

    public function nastavHodnoty($barva, $id = null){
      $this->id = $id;
      $this->barva = $barva;
    }
public function vypisOptionBarvy() {
    echo "<option value='$this->id'>$this->barva</option>\n";
}
public function vypisBarvy(){
    echo " $this->barva ";
}
public function nazevBezDiakritiky($nazev_pripona){
    if (mb_strrpos($nazev_pripona,".") == 0) {
        $nazev= $nazev_pripona;
    }else {$nazev = mb_substr($nazev_pripona,0,mb_strrpos($nazev_pripona,"."));}
    return $this->bezDiakritiky($nazev);
    }
    
    public function bezDiakritiky($nazev) {
    $coNahradit=array("á","é","í","ó","ú","ů","ý","ž","š","č","ř","ď","ť","ň","ě","Á","É","Í","Ó","Ú","Ů","Ž","Š","Č","Ř",
    "Ď","Ť","Ň","É","Ý");
    $cimNahradit=array("a","e","i","o","u","u","y","z","s","c","r","d","t","n","e","A","E","I","O","U","U","Z","S","C","R",
    "D","T","N","E","Y");
    return str_replace($coNahradit,$cimNahradit,$nazev);
    
    }
public function vypisCheckboxBarvy() {
    echo "<label class=label_checkbox for='$this->barva'>$this->barva<input type='checkbox' name='$this->barva'></label><br>";
}
public function vypisFunkceBarvy($produkt_id) {
    if (isset($_POST[$this->barva])) {
        spl_autoload_register(function ($trida) {
            include_once "Class/$trida.php";
        });
        $db = new BarvaDB();
        $id = $db->upravBarvuvProduktu($produkt_id, $this->id);
        //if ($id === '0') {
        //    echo  "<p class='spravne'>Barvu $this->barva se podařilo přidat</p>\n";
        //}
        //echo  "<p class='chyba'>Barvu $this->barva se nepodařilo přidat</p>\n";
    }
}
public function vypisFunkceOdstranitBarvy($produkt_id) {
    if (!isset($_POST[$this->barva])) {
        spl_autoload_register(function ($trida) {
            include_once "Class/$trida.php";
        });
        $db = new BarvaDB();
        $id = $db->odeberBarvuProduktu($produkt_id, $this->id);
        //if ($id === '0') {
        //    echo  "<p class='spravne'>Barvu $this->barva se podařilo přidat</p>\n";
        //}
        //echo  "<p class='chyba'>Barvu $this->barva se nepodařilo přidat</p>\n";
    }
}
public function __toString(){
    return "<p> $this->id $this->barva</p>";
}
}
?>
