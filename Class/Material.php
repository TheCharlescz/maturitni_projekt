<?php
class Material {
    public $id;
    public $material;

    public function nastavHodnoty($material, $id = null){
      $this->id = $id;
      $this->material = $material;
    }
public function vypisOptionmaterial() {
    echo "<option value='$this->id'>$this->material</option>\n";
}

public function __toString(){
    return "<p>zanr: $this->id $this->material</p>";
}
}
?>
