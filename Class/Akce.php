<?php
class Akce {
    public $id;
    public $akce;

    public function nastavHodnoty($akce, $id = null){
      $this->id = $id;
      $this->zanr = $akce;
    }
public function vypisOptionAkce() {
    echo "<option value='$this->id'>$this->akce</option>\n";
}
	public function vypisOptionAkceFiltr() {
		echo "<option value='$this->akce'>$this->akce</option>\n";
	}


public function __toString(){
    return "<p> $this->id $this->akce</p>";
}
}
?>
