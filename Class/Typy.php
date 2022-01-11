<?php
class Typy {
    public $id;
    public $Typ;

    public function nastavHodnoty($typ, $id = null){
      $this->id = $id;
      $this->typ = $typ;
    }
public function vypisOptionTyp() {
    echo "<option value='$this->id'>$this->typ</option>\n";
}

public function __toString(){
    return "<p>typ: $this->id $this->typ</p>";
}
}
?>
