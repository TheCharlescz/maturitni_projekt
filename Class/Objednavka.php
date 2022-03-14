<?php

class Objednavka
{
	public $id;
	public $celkova_cena;
	public $zaplaceno;
	public $zpracovano;
	public $odeslano;
	public $vytvoreno_v;
	public $uzivatel_id;

	public function nastavHodnoty($celkova_cena, $zaplaceno, $zpracovano, $odeslano, $vytvoreno_v, $uzivatel_id, $id = NULL)
	{
		$this->id = $id;
		$this->celkova_cena = $celkova_cena;
		$this->zaplaceno = $zaplaceno;
		$this->zpracovano = $zpracovano;
		$this->odeslano = $odeslano;
		$this->vytvoreno_v = $vytvoreno_v;
		$this->uzivatel_id = $uzivatel_id;
	}
	public function vypisHistorieUzivatele()
	{

		if (isset($_POST["zaplatit$this->id"])) {
			$db_objednavka = new ObjednavkaDB();
			$db_objednavka->zaplatObjednavku($this->id);
?>
			<script>
				location.replace("Uzivatel-profil.php");
			</script>
		<?php
		}
		if (isset($_POST["storno$this->id"])) {
			$db_objednavka = new ObjednavkaDB();
			$db_polozka = new PolozkaDB();
			$polozky = $db_polozka->nactiPolozkyObjednavky($this->id);
			foreach ($polozky as $polozka) {
				$db_polozka->odstranitPolozkuzObjednavky($this->id);
			}
			$db_objednavka->stornoObjednavky($this->id);
		?>
			<script>
				location.replace("Uzivatel-profil.php");
			</script>
		<?php

		}
		echo "
	<section class='blok' id='podsebe'>
			<div>
				<h2>Objednávka č. $this->id</h2>";

		spl_autoload_register(function ($trida) {
			include_once "Class/$trida.php";
		});
		$polozka = new Polozka();
		$db = new PolozkaDB();
		$polozky = $db->nactiPolozkyObjednavky($this->id);
		foreach ($polozky as $polozka) {
			$polozka->vypisProduktuvObjednavce();
		}
		echo "
			</div>
			<div>
			";
		spl_autoload_register(function ($trida) {
			include_once "Class/$trida.php";
		});
		echo "<span class='flex' id='borer_top'>";
		echo "<h3>Celkem</h3>";
		echo "<h3> $this->celkova_cena Kč</h3>";
		echo "</span>";
		echo "<h3>Způsob doručení:  $this->doprava </h3>";
		$date = new DateTime($this->zaplaceno);
		echo "" . (empty($this->zaplaceno) ? "<h3 style='color:red'> Objednávka zatím nebyla zapalcena</h3> " : "<h3 style='color:green'> Zaplaceno v: " . $date->format('H:i:s  d/m/y') . "</h3>") . "";
		$date = new DateTime($this->zpracovano);
		echo "" . (empty($this->zpracovano) ? "<h3 style='color:red'> Zatím nebylo zpracováno</h3>" : "<h3 style='color:green'> Zpracovano v: " . $date->format('H:i:s  d/m/y') . "</h3>") . "";
		$date = new DateTime($this->odeslano);
		echo "" . (empty($this->odeslano) ? "<h3 style='color:red'>Zatím nebylo odesláno</h3>" : "<h3 style='color:green'> Odeslano v: " . $date->format('H:i:s  d/m/y') . "</h3>") . "";
		if (empty($this->zaplaceno)) {
			echo "<form method='post'>
			<input class='input' type='submit' value='Zaplatit objednávku' name='zaplatit$this->id'>
			<input class='input' type='submit' value='Stornovat objednávku' name='storno$this->id'>
			</form>";
		}
		echo "
			</div>
		</section>";
	}
	public function vypisSpravyObjednavek()
	{
		spl_autoload_register(function ($trida) {
			include_once "Class/$trida.php";
		});

		if (isset($_POST["zpracovat$this->id"])) {
			$db_objednavka = new ObjednavkaDB();
			$db_objednavka->zabalObjednavku($this->id);
		?>
			<script>
				location.replace("Produkt-sprava.php");
			</script>
		<?php
		}

		if (isset($_POST["odeslat$this->id"])) {
			$db_objednavka = new ObjednavkaDB();
			$db_objednavka->odesliObjednavku($this->id);
		?>
			<script>
				location.replace("Produkt-sprava.php");
			</script>
		<?php
		}
		echo "
	<section class='blok' id='podsebe'>
			<div>
				<h2>Objednávka č. $this->id</h2>";
		$polozka = new Polozka();
		$db = new PolozkaDB();
		$polozky = $db->nactiPolozkyObjednavky($this->id);
		foreach ($polozky as $polozka) {
			$polozka->vypisProduktuvObjednavce();
		}
		echo "
			</div>
			<div>
			";
		spl_autoload_register(function ($trida) {
			include_once "Class/$trida.php";
		});
		echo "<span class='flex' id='borer_top'>";
		echo "<h3>Celkem</h3>";
		echo "<h3> $this->celkova_cena Kč</h3>";
		echo "</span>";
		echo "<h3>Způsob doručení:  $this->doprava </h3>";
		$uzivatel = new Uzivatel();
		$db = new UzivatelDB();
		$uzivatel = $db->nactiUzivatel($this->uzivatel_id);
		$uzivatel->vypisUzivateleVKosiku();
		$date = new DateTime($this->zaplaceno);
		echo "" . (empty($this->zaplaceno) ? "<h3 style='color:red'> Objednávka zatím nebyla zapalcena</h3> " : "<h3 style='color:green'> Zaplaceno v: " . $date->format('H:i:s  d/m/y') . "</h3>") . "";
		$date = new DateTime($this->zpracovano);
		echo "" . (empty($this->zpracovano) ? "<h3 style='color:red'> Zatím nebylo zpracováno</h3>" : "<h3 style='color:green'> Zpracovano v: " . $date->format('H:i:s  d/m/y') . "</h3>") . "";
		$date = new DateTime($this->odeslano);
		echo "" . (empty($this->odeslano) ? "<h3 style='color:red'>Zatím nebylo odesláno</h3>" : "<h3 style='color:green'> Odeslano v: " . $date->format('H:i:s  d/m/y') . "</h3>") . "";
		if (!empty($this->zaplaceno) && empty($this->zpracovano)) {
			echo "<form method='post'>
			<input class='input' type='submit' value='Zpracovat objednávku' name='zpracovat$this->id'>
			</form>";
		}
		if (!empty($this->zpracovano) && empty($this->odeslano)) {
			echo "<form method='post'>
			<input class='input' type='submit' value='Odeslat objednávku' name='odeslat$this->id'>
			</form>";
		}
		echo "
			</div>
		</section>";
	}
}
