<?php
class Znacka {
    public $id;
    public $znacka;

    public function nastavHodnoty($znacka, $id = null){
      $this->id = $id;
      $this->znacka = $znacka;
    }
public function vypisOptionZnacka() {
    echo "<option value='$this->id'>$this->znacka</option>\n";
}
	public function vypisOptionZnackaFiltr()
	{
		echo "<option value='$this->znacka' onchange='document.getElementById('filtr_menu').submit()'>$this->znacka</option>\n";
	}

public function __toString(){
    return "<p>zanr: $this->id $this->znacka</p>";
}
}
?>
