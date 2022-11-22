<!DOCTYPE html>
<html lang="cs">
<?php
session_start();
require("Urlzkrasnovac.php");
if (!isset($_SESSION["id_uzivatele"]) || !isset($_SESSION["prava"])) {
	header("Location: Uzivatel-prihlaseni.php ");
}

if ($_SESSION["prava"] < 1) {
	header("Location: Uzivatel-profil.php");
}
?>

<head>
	<meta charset="UTF-8">
	<meta name="author" content="Karel Valenta">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="Css/cssHamenu.css">
	<link rel="stylesheet" href="Css/cssFormulare.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="img/logo.ico">
	<title>Infiltrated - Přidat nový produkt</title>
</head>

<body>
	<header id="Myheader">
		<div>
			<h2>Přidat Nový produkt</h2>
		</div>
		<div style="text-align:center;">
			<?php
			spl_autoload_register(function ($trida) {
				include_once "Class/$trida.php";
			});
			//Při potvzení formuláře se spustí tato kod v této závotce
			if (isset($_POST["ulozit"])) {
				spl_autoload_register(function ($trida) {
					include_once "Class/$trida.php";
				});

				$produkt = new Produkt();
				//využití proměnných $_POST při ptvobě objektu produkt
				if ($produkt->nastavHodnoty($_POST["akce_id"], $_POST["kategorie_id"], $_POST["materialy_id"], $_POST["znacky_id"], $_SESSION["id_uzivatele"], $_POST["typy_id"], $_POST["nazev"], $_POST["popis"], $_POST["pohlavi"], $_POST["cena"], $_POST["sleva"], 1)) {
					$db = new ProduktDB();
					//a následné vložení prodkutu do databáze
					$produkt_id = $db->vlozProdukt($produkt);
					if ($produkt_id > 0) {
						echo  "<h2 class='spravne'>Produkt byl vytvořen</h2>\n";
						extract($_POST);
						$koncovky = array("jpeg", "jpg", "png", "gif");
						$pocet = 1;
						$slozka = $produkt_id;
						//vytvoření složky projednotlivý produkt s nastavením opravnění...
						mkdir("img_produkt/$slozka", 0777);
						//Výčet všech souborů z formuláře, které se nachazejí v tempu webu.
						foreach ($_FILES["files"]["tmp_name"] as $key => $tmp_name) {
							//Přiřazení jedno daného z pole files[] obrázku k promněné $obrazek
							$obrazek = $_FILES["files"]["name"][$key];
							$tmp_slozka = $_FILES["files"]["tmp_name"][$key];
							//funkce zjistí typ složky.
							$ext = pathinfo($obrazek, PATHINFO_EXTENSION);
							$obrazek = $produkt_id . "." . $pocet . "." . $ext;
							//zkotrluje zda se jedná o povojený soubor
							if (in_array($ext, $koncovky)) {
								//Ověří jestli se už ve složce nenachazí sobour se stejným názvem (potřeba spíše u editace).
								if (!file_exists("img_produkt/" . $slozka . "/" . $obrazek)) {
									//Funkce přesune právě nahrané obrázky do složky na webový server
									move_uploaded_file($tmp_slozka, "img_produkt/" . $slozka . "/" . $obrazek);
								} else {
									$nazevsouborou = basename($obrazek, $ext);
									$cas = new DateTime(time());
									$novyNazevObrazku = $nazevsouborou . date('H:i:s-d/m/y') . "." . $ext;
									move_uploaded_file($tmp_slozka, "img_produkt/" . $slozka . "/" . $novyNazevObrazku);
								}
							}
							$pocet++;
						}
						$barva = new Barva();
						$db = new BarvaDB();
						$barvy = $db->nactiBarvy();
						foreach ($barvy as $barva) {
							$barva->vypisFunkceBarvy($produkt_id);
						}

						$velikost = new Velikost();
						if ($velikost->nastavHodnoty("XS", $_POST["XS"])) {
							$db = new VelikostDB();
							$velikost_id = $db->vlozVelikost($velikost);
							$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
							if ($velikost_id > 0) {
							} else {
								echo "<p class='chyba'>Velikost S se nepodařlo vytvořit</p>\n";
							}
						}

						$velikost = new Velikost();
						if ($velikost->nastavHodnoty("S", $_POST["S"])) {
							$db = new VelikostDB();
							$velikost_id = $db->vlozVelikost($velikost);
							$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
							if ($velikost_id > 0) {
							} else {
								echo "<p class='chyba'>Velikost S se nepodařlo vytvořit</p>\n";
							}
						}

						$velikost = new Velikost();
						if ($velikost->nastavHodnoty("M", $_POST["M"])) {
							$db = new VelikostDB();
							$velikost_id = $db->vlozVelikost($velikost);
							$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
							if ($velikost_id > 0) {
							} else {
								echo "<p class='chyba'>Velikost M se nepodařlo vytvořit</p>\n";
							}
						}

						$velikost = new Velikost();
						if ($velikost->nastavHodnoty("L", $_POST["L"])) {
							$db = new VelikostDB();
							$velikost_id = $db->vlozVelikost($velikost);
							$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
							if ($velikost_id > 0) {
							} else {
								echo "<p class='chyba'>Velikost L se nepodařlo vytvořit</p>\n";
							}
						}
						$velikost = new Velikost();
						if ($velikost->nastavHodnoty("XL", $_POST["XL"])) {
							$db = new VelikostDB();
							$velikost_id = $db->vlozVelikost($velikost);
							$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
							if ($velikost_id > 0) {
							} else {
								echo "<p class='chyba'>Velikost XL se nepodařlo vytvořit</p>\n";
							}
						}
					} else {
						echo "<h2 class='chyba'>Produkt se nepodařilo vytvořit</h2>\n";
						echo "<p class='chyba'>Podívejte se jestli nezadáváte název prodkutu, který už byl vytvořen</p>\n";
					}
				}
			}

			?>
			<a class='input' href='Produkt-administrace.php'>Zpět na administraci produktu</a>
		</div>
	</header>
	<main>
		<div class="blok">
			<!-- HTML formulář s metodou post -->
			<form method="post" enctype="multipart/form-data">
				<div class="flex">
					<label>
						<h2>Napiš základní informace o produktu</h2>
						<div class="reg">
							<!-- Jednotlivé inputy, do který se vyplnují data -->
							<input type="text" name="nazev" placeholder="Nazev produktu" required> <br>
							<input type="number" name="cena" placeholder="Cena" required><br>
							<input type="number" name="sleva" placeholder="Sleva (vyplnte v procentech)"><br>
							<select name="pohlavi" class="input">
								<option value="">Vyberte jednu z pohlaví</option>
								<option value="Muz">Pánské</option>
								<option value="Zena">Dámské</option>
								<option value="Dite">Děti</option>
								<option value="Unisex">Unisex</option>
							</select><br>
							<textarea name="popis" id="" cols="21.5" rows="5" placeholder="Popis produktu" required></textarea><br>
						</div>
					</label>
					<label>
						<h2>Vyber kategorie produktů</h2>
						<div class="reg">
							<select name="akce_id" class="input" required>
								<option value="">Vyberte jednu z akci</option>
								<?php
								spl_autoload_register(function ($trida) {
									include_once "Class/$trida.php";
								});
								$db = new AkceDB();
								$akce = new Akce();
								$akce = $db->nactiAkce();
								foreach ($akce as $akci) {
									$akci->vypisOptionAkce();
								}
								?>
							</select><br>
							<select name="kategorie_id" class="input" required>
								<option value="">Vyberte jednu z katehorií</option>
								<?php
								spl_autoload_register(function ($trida) {
									include_once "Class/$trida.php";
								});
								$db = new KategorieDB();
								$kategorie = new Kategorie();
								$kategorie = $db->nactiKategorie();
								foreach ($kategorie as $kategorii) {
									$kategorii->vypisOptionkategorie();
								}
								?>
							</select><br>
							<select name="materialy_id" class="input" required>
								<option value="">Vyberte jeden z materiálů</option>
								<?php
								spl_autoload_register(function ($trida) {
									include_once "Class/$trida.php";
								});
								$db = new MaterialDB();
								$material = new Material();
								$materialy = $db->nactiMaterialy();
								foreach ($materialy as $material) {
									$material->vypisOptionmaterial();
								}
								?>
							</select><br>

							<select name="znacky_id" class="input" required>
								<option value="">Vyberte jednu ze značek</option>
								<?php
								spl_autoload_register(function ($trida) {
									include_once "Class/$trida.php";
								});
								$db = new ZnackaDB();
								$znacka = new Znacka();
								$znacky = $db->nactiZnacky();
								foreach ($znacky as $znacka) {
									$znacka->vypisOptionznacka();
								}
								?>
							</select><br>
							<select name="typy_id" class="input" required>
								<option value="">Vyberte jednu z typů</option>
								<?php
								spl_autoload_register(function ($trida) {
									include_once "Class/$trida.php";
								});
								$db = new TypDB();
								$typ = new Typ();
								$typy = $db->nactiTypy();
								foreach ($typy as $typ) {
									$typ->vypisOptiontyp();
								}
								?>
							</select>
						</div>
				</div>
				</label>

				<div class="flex">
					<label>
						<h2>Napiš počet kusů dané velikosti</h2>
						<div class="reg">
							<label for="XS">Velikost XS</label> <input type="number" name="XS" placeholder="Počet kusů XS"><br>
							<label for="S">Velikost S</label> <input type="number" name="S" placeholder="Počet kusů S"><br>
							<label for="M">Velikost M</label> <input type="number" name="M" placeholder="Počet kusů M"><br>
							<label for="L">Velikost L</label> <input type="number" name="L" placeholder="Počet kusů L"><br>
							<label for="XL">Velikost XL</label> <input type="number" name="XL" placeholder="Počet kusů XL"><br>
						</div>
					</label>
					<label>
						<h2>Zaškrtni barvy produktu</h2>
						<div class="reg">
							<?php
							spl_autoload_register(function ($trida) {
								include_once "Class/$trida.php";
							});
							$barva = new Barva();
							$db = new BarvaDB();
							$barvy = $db->nactiBarvy();
							foreach ($barvy as $barva) {
								$barva->vypisCheckboxBarvy();
							}
							?>
					</label>
				</div>

		</div>
		<table width="100%">
			<tr>
				<td> Vyberte fotky (jednu nebo více):</td>
				<td><input type="file" name="files[]" multiple /></td>
			</tr>
			<tr>
				<td colspan="2">Poznámka: Podporované formáty: .jpeg, .jpg, .png, .gif</td>
			</tr>
		</table>
		</label>
		<p>*Pro správné fungovaní je potřeba vyplnit alespon jednu velikost a barvu.</p>
		<!-- Input neboli tlačítko, které potvrdí  formulář a vytvoří super golobalní promněné $_POST-->
		<input type="submit" name="ulozit" value="Přidat produkt">
		</form>
		</div>
		</div>
	</main>
</body>

</html>