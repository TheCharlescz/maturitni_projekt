<?php

class Produkt {
    public $id;
    public $nazev;
    public $popis;
    public $pohlavi;
    public $cena;
    public $sleva;
    public $dostupnost;
    public $velikosti;
    public $velikost;
    public $typy_id;
    public $akce_id;
    public $uzivatel_id;
    public $kategorie_id;
    public $materialy_id;
    public $znacky_id;

public function nastavHodnoty($akce_id,$kategorie_id,$materialy_id,$znacky_id,
$uzivatel_id,$typy_id,$nazev,$popis,$pohlavi,$cena,$sleva, $dostupnost, $id = NULL)
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
        if (preg_match($redexp, $sleva)) {
            $this->sleva = $sleva;
        } else {
            echo " <h2 class='chyba'>Špatně zadaná sleva</h2>
            <p class='chyba'>Sleva musí obsahovat číslo<p>";
            return false;
        }
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
          $velikost->vypisVelikosti($velikost);
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

public function vypisBaneruProduktu() {
  echo "
  <div class=showProduct>
          <div class='sPtextInImg'>
          ";
          $dir = "/wamp64/www/maturitni_projekt/img_produkt/$this->nazev/";
            if (is_dir($dir)){
              if ($dh = opendir($dir)){
                while (($file = readdir($dh))){
                  if ($file === '.' || $file === '..') continue;
                  $ext=pathinfo($file, PATHINFO_EXTENSION);
                  if ( $file == "$this->id.1.$ext") {
                  echo "<a href='Produkt.php?id=$this->id' class='noMargin'><img src='img_produkt/$this->nazev/$file' style = 'width: 100%'></a>";
                }
								}
                closedir($dh);
              }
            }
          echo "
            <div class='sPbottom-left'>
              $this->cena Kč
            </div>
          </div>
          <div class='sPflex'>
            <div>
              <h3>$this->typ $this->nazev</h3>
              <p>$this->znacka</p>
            </div>
            <div>
              <a href=''><span class='material-icons'>
                  shopping_cart
                </span></a>
              <a href=''><span class='material-icons'>
                  favorite_border
                </span></a>
            </div>
          </div>
        </div>";
}
public function vypisBaneruProduktuAdministace() {
  echo "
  <div class='showProduct'>
  <div class=img>
  ";
  $dir = "/wamp64/www/maturitni_projekt/img_produkt/$this->nazev/";
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh))){
          if ($file === '.' || $file === '..') continue;
          $ext=pathinfo($file, PATHINFO_EXTENSION);
          if ( $file == "$this->id.1.$ext")
          echo "<a href='Produkt-administrace.php?id=$this->id' class='noMargin'><img src='img_produkt/$this->nazev/$file'></a>";
        }
        closedir($dh);
      }
    }
  echo "
      <div class='sPbottom-left'>
        $this->cena Kč
      </div>
  </div>
  <div class='sPflex'>
      <div>
      <h2>$this->nazev</h2>
      <p>$this->kategorie : $this->pohlavi : $this->typ</p>
      <p>"; $this->vypisBarev1();echo "</p>
      </div>
      <div class='velikosti'>";
      $this->vypisVelikostiaPoctuKusu();
      echo "
    </div>
    </div>
		<div>
	<button id='noBorder' onclick='openModalSmaz($this->id)' id='myBtn'><span class='material-icons'>delete</span></button>
    <a id='noBorder'  class='input'href='Produkt-smazani.php?id=$this->id'><span class='material-icons'>edit</span></a>
		</div>
</div>
 <div id='$this->id smaz' class='modal'>
    <div class='modal-content'>
        <span onclick='closeModalSmaz($this->id)' class='close'>&times;</span>
        <h2> Opravdu chcete smazat produkt: " . $this->id  . " " . $this->nazev . "</h2>
        <a class='input' href='Produkt-administrace.php?id=$this->id'>Ano chci smazat tento produkt</a>
        <button onclick='closeModalSmaz($this->id)' id='myBtn'>Nechci smazat tento profil</button>
    </div>
    </div>";
}
public function vypisProduktu() {
    echo "<section id='flex'>
    <div class='container'>";
    $dir = "/wamp64/www/maturitni_projekt/img_produkt/$this->nazev/";
    // Open a directory, and read its contents
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh))){
          if ($file === '.' || $file === '..') continue;
          echo "<div class='mySlides'>
          <img src='img_produkt/$this->nazev/$file' style='width:100%' >
      </div>";
        }
        closedir($dh);
      }
    }
echo "
<a class='prev' onclick='plusSlides(-1)'>&#10094;</a>
<a class='next' onclick='plusSlides(1)'>&#10095;</a>
<div class='row'>";
$dir = "/wamp64/www/maturitni_projekt/img_produkt/$this->nazev/";
    $i = 1;
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh))){
          if ($file === '.' || $file === '..') continue;
          echo "<div class='column'>
          <img class='demo cursor' src='img_produkt/$this->nazev/$file' style='width:100%' onclick='currentSlide($i)' >
        </div>";
        $i++;
        }
        closedir($dh);
      }
    }
echo "
</div>
</div>
    <div id='infoAndBuy'>
      <div id='info'> </div>
      <div id='flex'><p>".$this->kategorie." :  ".$this->znacka."  : ".$this->pohlavi."  </p></div>
      <div id='border'>
        <h1>".$this->nazev."</h1>
        <h3>".$this->cena." Kč</h3>
        </div>
        <div id='Sizes'>
        <h3>Dostupné velikosti:</h3>
        <div id='showSizes'>";
        $this->vypisVelikosti($_GET["id"]);
        echo "</div>
        </div>
        <div id='buy'>
           <input class='input'  type='button' value='Přidat do Košíku '>
           <span class='material-icons'>
                  favorite_border
                </span>
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
          $this->vypisBarev($_GET["id"]);
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