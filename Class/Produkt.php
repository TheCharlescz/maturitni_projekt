<?php

class Produkt {
    public $id;
    public $nazev;
    public $popis;
    public $pohlavi;
    public $cena;
    public $sleva;
    public int $dostupnost;
		public $vytvoreno_v;
		public $upraveno_v;
		public $publikovano_v;
    public $velikosti;
    public $velikost;
    public $typy_id;
    public $akce_id;
    public $uzivatel_id;
    public $kategorie_id;
    public $materialy_id;
    public $znacky_id;

public function nastavHodnoty($akce_id,$kategorie_id,$materialy_id,$znacky_id,
$uzivatel_id,$typy_id,$nazev,$popis,$pohlavi,$cena,$sleva = NULL, $dostupnost, $id = NULL)
 {
$this->id = $id;
$this->typy_id = $typy_id;
$this->akce_id = $akce_id;
$this->uzivatel_id = $uzivatel_id;
$this->kategorie_id = $kategorie_id;
$this->materialy_id = $materialy_id;
$this->znacky_id = $znacky_id;

$this->nazev = htmlSpecialChars($nazev, ENT_QUOTES);
$this->popis = htmlSpecialChars($popis, ENT_QUOTES);
$this->pohlavi = $pohlavi;
$redexp = "/[0-9]+$/";
        if (preg_match($redexp, $cena)) {
            $this->cena = $cena;
        } else {
            echo " <h2 class='chyba'>Špatně zadaná cena</h2>
            <p class='chyba'>Cena musí obsahovat číslo<p>";
            return false;
        }
            $this->sleva = $sleva;
        if (preg_match($redexp, $dostupnost)) {
            $this->dostupnost = $dostupnost;
        } else {
            echo " <h2 class='chyba'>Špatně zadané množství</h2>
            <p class='chyba'>Množtví musí obsahovat číslo<p>";
            return false;
}
return true;
}
public function vypisVelikosti($id) {
  $db = new VelikostDB();
  $velikost = new Velikost();
      $velikosti = $db->nactiVelikostiProduktu($id);
      foreach ($velikosti as $velikost) {
          $velikost->vypisVelikosti();
      }
  }
	public function vypisVelikostivKosiku($id , $velikost1)
	{
		$db = new VelikostDB();
		$velikost = new Velikost();
		$velikosti = $db->nactiVelikostiProduktu($id);
		foreach ($velikosti as $velikost) {
			$velikost->vypisVelikostiKosik($velikost1);
		}
	}
  public function vypisVelikostiaPoctuKusu() {
    $db = new VelikostDB();
    $velikost = new Velikost();
        $velikosti = $db->nactiVelikostiProduktu($this->id);
        foreach ($velikosti as $velikost) {
            $velikost->vypisVelikostiaPoctuKusu($velikost);
        }
    }
  public function vypisBarev($id) {
    $db = new BarvaDB();
    $barva = new Barva();
        $barvy = $db->nactiBarvyProduktu($id);
        foreach ($barvy as $barva) {
            $barva->vypisBarvy($barva);
        }
    }
    public function vypisBarev1() {
      $db = new BarvaDB();
      $barva = new Barva();
          $barvy = $db->nactiBarvyProduktu($this->id);
          foreach ($barvy as $barva) {
              $barva->vypisBarvy($barva);
          }
      }
		public function vypocetSlevy() {
			$zlevnena_cena = $this->cena / 100 * $this->sleva;
			var_dump($zlevnena_cena);
			return $zlevnena_cena;
		}
public function vypisBaneruProduktu() {
		$sleva = $this->cena / 100 * $this->sleva;
		$zlevnena_cena = $this->cena - $sleva;
		$url = $_SERVER['SCRIPT_NAME'];
  echo "
  <div class=showProduct>
          <div class='sPtextInImg'>
          ";
									$obrazky = scandir("img_produkt/$this->id");
									foreach ($obrazky as $obrazek) {
                  if ($obrazek === '.' || $obrazek === '..') continue;
                  $ext=pathinfo($obrazek, PATHINFO_EXTENSION);
                  if ( $obrazek == "$this->id.1.$ext") {
                  echo "<a href='Produkt.php?id=$this->id' class='noMargin'><img src='img_produkt/$this->id/$obrazek' alt='$this->nazev' style = 'width: 100%'></a>";
                }
								}
          echo "
            <div class='sPbottom-left'>
					" . (!empty($this->sleva) ? "<span class='puvodni_cena'> $this->cena Kč   </span>" : "") ."
					 	   " . (!empty($this->sleva) ? "<span > $zlevnena_cena Kč </span>" : " $this->cena Kč") . "
            </div>
						" . (!empty($this->sleva) ? "	<div class='top-right'>-$this->sleva %</div>" : "") . "
          </div>
          <div class='sPflex'>
            <div>
              <h3> $this->typ $this->nazev</h3>
              <p>$this->znacka</p>
            </div>
            <div class='flex'>
							<form method='post'  >
              <button class='button' type='submit' name='pridat-do-kosiku' value='$this->id'>
					 					<span class='material-icons'>
                  shopping_cart
                </span></button>
							</form>
              <a href='$url?pridat-oblibene=$this->id'><span class='material-icons'>
                  favorite_border
                </span></a>
            </div>
          </div>
        </div>";
}

	public function vypisBaneruOblibenychProduktu()
	{
		$sleva = $this->cena / 100 * $this->sleva;
		$zlevnena_cena = $this->cena - $sleva;
		echo "
  <div class=showProduct>
          <div class='sPtextInImg'>
          ";
		$obrazky = scandir("img_produkt/$this->id/");
		foreach ($obrazky as $obrazek) {
			if ($obrazek === '.' || $obrazek === '..') continue;
			echo "<a href='Produkt.php?id=$this->id' class='noMargin'><img src='img_produkt/$this->id/$obrazek' style = 'width: 100%'></a>";
			break;
		}
		echo "
            <div class='sPbottom-left'>
					". (!empty($this->sleva) ? "<span class='puvodni_cena'> $this->cena Kč </span>" : "") . "
				" . (!empty($this->sleva) ? "<span > $zlevnena_cena Kč </span>" : " $this->cena Kč") . "
            </div>
						" . (!empty($this->sleva) ? "	<div class='top-right'>-$this->sleva %</div>" : "") . "
          </div>
          <div class='sPflex'>
            <div>
              <h3> $this->typ $this->nazev</h3>
              <p>$this->znacka</p>
            </div>
            <div>
              <a href=''><span class='material-icons'>
                  shopping_cart
                </span></a>
              <a href='Uzivatel-oblibene.php?odstran=$this->id'><span class='material-icons'>
                  heart_broken
                </span></a>
            </div>
          </div>
        </div>";
	}
public function vypisBaneruProduktuAdministace() {
		spl_autoload_register(function ($trida) {
			include_once "Class/$trida.php";
		});
		$sleva = $this->cena / 100 * $this->sleva;
		$zlevnena_cena = $this->cena - $sleva;
		if (isset($_POST["checkbox$this->id"]) && $this->dostupnost == 0) {
			$db = new ProduktDB();
			$db->upravDostupnostProduktu($this->id, 1);
		}

		if (isset($_POST["checkbox$this->id"]) && $this->dostupnost == 1){
			echo "dfdsfdsfdsf";
			$db = new ProduktDB();
			$db->upravDostupnostProduktu($this->id, 0);
		}
  echo "
  <div class='showProduct'>
  <div class=img>
  ";
		$obrazky = scandir("img_produkt/$this->id/");
		foreach ($obrazky as $obrazek) {
          if ($obrazek === '.' || $obrazek === '..') continue;
              echo "<a href='Produkt.php?id=$this->id' class='noMargin'><img src='img_produkt/$this->id/$obrazek'></a>";
							break;
          }
  echo "
      <div class='sPbottom-left'>
        $this->cena Kč -$this->sleva % <br>
				$zlevnena_cena Kč
      </div>
  </div>
  <div class='sPflex'>
      <div>
      <h2>$this->nazev</h2>
      <p>$this->kategorie : $this->pohlavi : $this->typ</p>
			<p>$this->material </p>
      <p>"; $this->vypisBarev1();
			echo "</p>
      </div>
      <div class='velikosti'>";
      $this->vypisVelikostiaPoctuKusu();
      echo "
    </div>
    </div>
		<div style='padding: 0 15px'>
			<p>Vytvořen v: ";
				$date = new DateTime($this->vytvoreno_v);
				echo $date->format('d/m/y H:i:s'); echo" </p>
			<p>Upraven v: ";
				$date = new DateTime($this->upraveno_v);
				echo $date->format('d/m/y H:i:s'); echo"</p>
		</div>
		<div id='flex-just'>
	<button class='noBorder' onclick='openModalSmaz($this->id)' id='myBtn'><span class='material-icons'>delete</span></button>
    <a class='noBorder' class='input'href='Produkt-editace.php?id=$this->id'><span class='material-icons'>edit</span></a>
		 <form method='post'>
<label class='switch'>
<input type='checkbox' name='checkbox$this->id' value='$this->dostupnost' ". ($this->dostupnost == 1 ? "checked" : "" ) ." onchange='submit();'>
  <span class='slider round'></span>
</label>
</form>
		</div>
</div>
 <div id='$this->id smaz' class='modal'>
    <div class='modal-content'>
        <span onclick='closeModalSmaz($this->id)' class='close'>&times;</span>
        <h2> Opravdu chcete smazat produkt: " . $this->id  . " " . $this->nazev . "</h2>
        <a class='input' id='black_background' href='Produkt-administrace.php?id_smaz=$this->id'>Ano chci smazat tento produkt</a>
        <button onclick='closeModalSmaz($this->id)' id='myBtn'>Nechci smazat tento profil</button>
    </div>
    </div>";
}
	public function vypisProduktuvKosiku($kusyvKosiku, $velikost)
	{
		$sleva = $this->cena / 100 * $this->sleva;
		$zlevnena_cena = $this->cena - $sleva;
		$db = new VelikostDB();
		$velikost_obj = new Velikost();
		$velikost_obj = $db->nactiVelikostProduktu($this->id, $velikost);
		echo "<section id='kosik_produkt'>
	<div id='img'>
		";
		$obrazky = scandir("img_produkt/$this->id/");
		foreach ($obrazky as $obrazek) {
			if ($obrazek === '.' || $obrazek === '..') continue;
			echo "<a href='Produkt.php?id=$this->id' class='noMargin'><img src='img_produkt/$this->id/$obrazek'></a>";
			break;
		}
		echo "
	</div>
	<div id='kosik_info'>
		<div id='flexit'>
			<h2>$this->nazev</h2><h3>$this->znacka</h3>" . (!empty($this->sleva) ? "<span > $zlevnena_cena Kč </span>" : " $this->cena Kč") . "
		</div>
		<form id='formin' method='post' action='Uzivatel-kosik.php?id_produktu=$this->id'>
			<input type='number' min='1' max='$velikost_obj->pocet_kusu'  name='pocet_kusu' name='pridat-do-kosiku' value='$kusyvKosiku' id='kosik_input'pattern='.{1,}' required  onchange='this.form.submit()' onkeydown='return false' >
			<div id='showSizes'>
			";
        $this->vypisVelikostivKosiku($this->id , $velikost);
        echo "
				</div>
		</form>
	</div>
	<form method='post'>
	<button class='noBorder' type='submit' name='odebrat-z-kosiku' value=$this->id><span class='close'> &times;</span></button>
	</form>
</section>";
	}
	public function vypisLegendyKosiku($pocet_kusu = 1)
	{
		$sleva = $this->cena  / 100 * $this->sleva;
		$zlevnena_cena = ($this->cena - $sleva) * $pocet_kusu;
		$cena = $this->cena * $pocet_kusu;
		echo "
		<span class='flex'>
					<h3> $pocet_kusu x $this->nazev</h3>
				<span class='flex'>
					" . (!empty($this->sleva) ? "<h3 class='puvodni_cena'> $cena Kč </h3>" : "") . "
				" . (!empty($this->sleva) ? "<h3 > $zlevnena_cena Kč </h3>" : " <h3>$this->cena Kč</h3>") . "</p>
				</span>
				</span>";
	}
public function vypisProduktu() {
		$sleva = $this->cena / 100 * $this->sleva;
		$zlevnena_cena = $this->cena - $sleva;
		//$url = $_SERVER['SCRIPT_NAME'];
    echo "<section class='flex'>
    <div class='container'>";
		$obrazky = scandir("img_produkt/$this->id");
		foreach ($obrazky as $obrazek) {
          if ($obrazek === '.' || $obrazek === '..') continue;
          echo "<div class='mySlides'>
          <img src='img_produkt/$this->id/$obrazek' alt='$this->nazev' style='width:100%' >
      </div>";
        }
echo "
<a class='prev' onclick='plusSlides(-1)'>&#10094;</a>
<a class='next' onclick='plusSlides(1)'>&#10095;</a>
<div class='row'>";
 $i =1;
		$obrazky = scandir("img_produkt/$this->id");
		foreach ($obrazky as $obrazek) {
          if ($obrazek === '.' || $obrazek === '..') continue;
          echo "<div class='column'>
          <img class='demo cursor' alt='$this->nazev' src='img_produkt/$this->id/$obrazek' style='width:100%' onclick='currentSlide($i)' >
        </div>";
        $i++;
        }
echo "
</div>
</div>
    <div id='infoAndBuy'>
      <div class='flex'><p>".$this->kategorie." :  ".$this->znacka."  : ".$this->pohlavi."  </p></div>
      <div id='border'>
        <h1>".$this->nazev."</h1>
				<div id='cena'>
				". (!empty($this->sleva) ? "<h3 class='puvodni_cena'> $this->cena Kč </h3>" : "") . "
				" . (!empty($this->sleva) ? "<h3 > $zlevnena_cena Kč </h3>" : " $this->cena Kč") . "
				</div>
        </div>
        <div id='Sizes'>
        <h3>Dostupné velikosti:</h3>
				<form method='post'>
        <div id='showSizes'>
				";
        $this->vypisVelikosti($this->id);
        echo "</div>
        </div>
				<div id='buy'>
           <button class='button' name='pridat-do-kosiku' value='$this->id'>
					 <span class='material-icons'>
                  shopping_cart
                </span></button></form>
                
              <a href='Produkt.php?id=$this->id&pridat-oblibene=$this->id'><span class='material-icons'>
                  favorite_border
                </span></a>
                </div>
</div>
    </section>
    <section id='moreInfo'>
        <div class='box'>
          <h3>Popis Produktu</h3>
          <p>".$this->popis." </p>
      </div>
      <div class='box'>
        <h3>Podrobné informace</h3>
        <ul>
          <li>Barvy:";
          $this->vypisBarev($this->id);
          echo "</li>
          <li>Materiál: ".$this->material." </li>
          <li>Id produktu: ".$this->id." </li>
        </ul>
      </div>
    </section>
    <script>
    var slideIndex = 1;
  showSlides(slideIndex);

  // Next/previous controls
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }

  // Thumbnail image controls
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

  function showSlides(n) {
    var i;
    if (n > document.getElementsByClassName('mySlides').length) {slideIndex = 1}
    if (n < 1) {slideIndex = document.getElementsByClassName('mySlides').length}
    for (i = 0; i < document.getElementsByClassName('mySlides').length; i++) {
      document.getElementsByClassName('mySlides')[i].style.display = 'none';
    }
    document.getElementsByClassName('mySlides')[slideIndex-1].style.display = 'block';
  }
  </script>"
  ;
}

}

?>