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
		echo "<option value='$this->velikost' >$this->velikost</option>\n";
	}
public function vypisVelikosti(){
    echo "
		<label class='radio'>
					<input type='radio' name='velikost' value='$this->velikost' class='showSize' required ></input>
					<span class='checkmark'>$this->velikost</span>
				</label>";
}
public function vypisVelikostiKosik($velikost)
	{
                echo "
		<label class='radio'>
					<input type='radio' name='velikost' value='$this->velikost' class='showSize' ". ($velikost == $this->velikost ? "checked" : "")  ." required onchange='this.form.submit()' ></input>
					<span class='checkmark'>$this->velikost</span>
				</label>";
            }
public function vypisVelikostiaPoctuKusu() {
    echo "<p >".$this->velikost." ".$this->pocet_kusu."</p>";
}


public function __toString(){
    return " $this->id $this->velikost";
}
}
?>
