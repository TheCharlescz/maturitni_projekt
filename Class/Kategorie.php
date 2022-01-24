<?php
class Kategorie {
    public $id;
    public $kategorie;

    public function nastavHodnoty($kategorie, $id = null){
      $this->id = $id;
      $this->zanr = $kategorie;
    }
public function vypisOptionkategorie() {
    echo "<option value='$this->id'>$this->kategorie</option>\n";
}
	public function vypisOptionkategorieFiltr()
	{
		echo "<option value='$this->kategorie'>$this->kategorie</option>\n";
	}

public function __toString(){
    return "<p>zanr: $this->id $this->kategorie</p>";
}
}
?>
