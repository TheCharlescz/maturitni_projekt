<?php
class Velikost {
    public $id;
    public $velikost;
    public $pocet_kusu;

    public function nastavHodnoty($velikost, $pocet_kusu, $id = null){
      $this->id = $id;
      $this->velikost = $velikost;
      $this->pocet_kusu = $pocet_kusu;
      return true;
    }
public function vypisOptionVelikost() {
    echo "<option value='$this->id'>$this->velikost</option>\n";
}
	public function vypisOptionVelikostFiltr() {
		echo "<option value='$this->velikost'>$this->velikost</option>\n";
	}
public function vypisVelikosti(){
    echo "<span class='showSize'>".$this->velikost."</span>";
}
public function vypisVelikostiaPoctuKusu() {
    echo "<p >".$this->velikost." ".$this->pocet_kusu."</p>";
}


public function __toString(){
    return " $this->id $this->velikost";
}
}
?>
