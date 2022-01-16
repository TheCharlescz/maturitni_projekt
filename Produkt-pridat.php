<?php
session_start();
if (!isset($_SESSION["id_uzivatele"]) || !isset($_SESSION["prava"])) {
	header("Location: Uzivatel-prihlaseni.php ");
}

if ($_SESSION["prava"] < 1) {
	header("Location: Uzivatel-profil.php");
}
?>
<!DOCTYPE html>
<html lang="en">

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
	<link rel="shortcut icon" href="img/logo.ico" />
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
			if (isset($_POST["ulozit"])) {
				spl_autoload_register(function ($trida) {
					include_once "Class/$trida.php";
				});
				$produkt = new Produkt();
				if ($produkt->nastavHodnoty($_POST["akce_id"], $_POST["kategorie_id"], $_POST["materialy_id"], $_POST["znacky_id"], $_SESSION["id_uzivatele"], $_POST["typy_id"], $_POST["nazev"], $_POST["popis"], $_POST["pohlavi"], $_POST["cena"], $_POST["sleva"], "1")) {
					$db = new ProduktDB();
					$produkt_id = $db->vlozProdukt($produkt);
					if ($produkt_id > 0) {
						//header("Location: Produkt-pridat.php?id_produkt=$velikost_id");
						echo  "<h2 class='spravne'>Produkt byl vytvořen</h2>\n";
					} else {
						echo "<h2 class='chyba'>Produkt se nepodařilo vytvořit</h2>\n";
						echo "<p class='chyba'>Podívejte se jestli nezadáváte název prodkutu, který už byl vytvořen</p>\n";
					}
				}

				//$soubor = new Soubor();
				//$nazev = $_POST['nazev'];
				// mkdir("img/$nazev$produkt_id");
				//$soubor->nastavHodnoty("img", $_FILES["obrazek"]["tmp_name"], $_FILES["obrazek"]["type"], $_FILES["obrazek"]["size"], $_FILES["obrazek"][], $produkt_id);
				//if ($soubor->ulozObrazek()) {
				//    echo "<h2>Obrázek byl uložen</h2>";
				//    $hra->obrazek = $soubor->nazev;
				//} else {
				//    echo "<h2>Obrazek nebyl uložen</h2>";
				//}
				extract($_POST);
				$error = array();
				$extension = array("jpeg", "jpg", "png", "gif");
				$pocet = 1;
				$txtGalleryName = $_POST["nazev"];
				mkdir("img/$txtGalleryName");
				foreach ($_FILES["files"]["tmp_name"] as $key => $tmp_name) {
					$file_name = $_FILES["files"]["name"][$key];
					$file_tmp = $_FILES["files"]["tmp_name"][$key];
					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					$file_name = $produkt_id . "." . $pocet . "." . $ext;
					if (in_array($ext, $extension)) {
						if (!file_exists("img/" . $txtGalleryName . "/" . $file_name)) {
							move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], "img/" . $txtGalleryName . "/" . $file_name);
						} else {
							header("Location: Produkt-pridat.php ");
							$filename = basename($file_name, $ext);
							$newFileName = $filename . time() . "." . $ext;
							move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], "img/" . $txtGalleryName . "/" . $newFileName);
						}
					} else {
						array_push($error, "$file_name, ");
					}
					$pocet++;
				}




				$barva = new Barva();
				$db = new BarvaDB();
				$barvy = $db->nactiBarvy();
				foreach ($barvy as $barva) {
					$barva->vypisFunkceBarvy($produkt_id);
				}



				spl_autoload_register(function ($trida) {
					include_once "Class/$trida.php";
				});
				$velikost = new Velikost();
				if ($velikost->nastavHodnoty("XS", $_POST["XS"])) {
					$db = new VelikostDB();
					$velikost_id = $db->vlozVelikost($velikost);
					$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
					if ($velikost_id > 0) {
						echo  "<p class='spravne'>Velikost XS byla vytvořena</p>\n";
					} else {
						echo "<p class='chyba'>Velikost S se nepodařlo vytvořit</p>\n";
					}
				}



				spl_autoload_register(function ($trida) {
					include_once "Class/$trida.php";
				});
				$velikost = new Velikost();
				if ($velikost->nastavHodnoty("S", $_POST["S"])) {
					$db = new VelikostDB();
					$velikost_id = $db->vlozVelikost($velikost);
					$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
					if ($velikost_id > 0) {
						echo  "<p class='spravne'>Velikost S byla vytvořena</p>\n";
					} else {
						echo "<p class='chyba'>Velikost S se nepodařlo vytvořit</p>\n";
					}
				}


				spl_autoload_register(function ($trida) {
					include_once "Class/$trida.php";
				});
				$velikost = new Velikost();
				if ($velikost->nastavHodnoty("M", $_POST["M"])) {
					$db = new VelikostDB();
					$velikost_id = $db->vlozVelikost($velikost);
					$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
					if ($velikost_id > 0) {
						echo  "<p class='spravne'>Velikost M byla vytvořena</p>\n";
					} else {
						echo "<p class='chyba'>Velikost M se nepodařlo vytvořit</p>\n";
					}
				}



				spl_autoload_register(function ($trida) {
					include_once "Class/$trida.php";
				});
				$velikost = new Velikost();
				if ($velikost->nastavHodnoty("L", $_POST["L"])) {
					$db = new VelikostDB();
					$velikost_id = $db->vlozVelikost($velikost);
					$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
					if ($velikost_id > 0) {
						echo  "<p class='spravne'>Velikost L byla vytvořena</p>\n";
					} else {
						echo "<p class='chyba'>Velikost L se nepodařlo vytvořit</p>\n";
					}
				}
				spl_autoload_register(function ($trida) {
					include_once "Class/$trida.php";
				});
				$velikost = new Velikost();
				if ($velikost->nastavHodnoty("XL", $_POST["XL"])) {
					$db = new VelikostDB();
					$velikost_id = $db->vlozVelikost($velikost);
					$db->vlozVelikostDoProduktu($produkt_id, $velikost_id);
					if ($velikost_id > 0) {
						echo  "<p class='spravne'>Velikost XL byla vytvořena</p>\n";
					} else {
						echo "<p class='chyba'>Velikost XL se nepodařlo vytvořit</p>\n";
					}
				}
			}
			if (!isset($_POST["XS"]) && isset($_POST["ulozit"])) {
				echo  "<p class='upozorneni'>Hodnota velikosti XS nebyla zadána</p>\n";
			}
			if (!isset($_POST["S"]) && isset($_POST["ulozit"])) {
				echo  "<p class='upozorneni'>Hodnota velikosti S nebyla zadána</p>\n";
			}
			if (!isset($_POST["M"]) && isset($_POST["ulozit"])) {
				echo  "<p class='upozorneni'>Hodnota velikosti M nebyla zadána</p>\n";
			}
			if (!isset($_POST["L"]) && isset($_POST["ulozit"])) {
				echo  "<p class='upozorneni'>Hodnota velikosti L nebyla zadána</p>\n";
			}
			if (!isset($_POST["XL"]) && isset($_POST["ulozit"])) {
				echo  "<p class='upozorneni'>Hodnota velikosti XL nebyla zadána</p>\n";
			}
			?>
			<a class='input' href='Produkt-administrace.php'>Zpět na administraci produktu</a>
		</div>
	</header>
	<main>
		<div class="blok">
			<form method="post" enctype="multipart/form-data">
				<div id="flex">
					<label>
						<h2>řidej počet kusů dané velikosti</h2>
						<div class="reg">
							<input type="text" name="nazev" placeholder="Nazev produktu" required> <br>
							<input type="number" name="cena" placeholder="Cena" required><br>
							<input type="number" name="sleva" placeholder="Sleva" required><br>
							<select name="pohlavi" class="input">
								<option value="">Vyberte jednu z možností</option>
								<option value="Muz">Pánské</option>
								<option value="Zena">Dámské</option>
								<option value="Dite">Děti</option>
								<option value="Unisex">Unisex</option>
							</select><br>
							<textarea name="popis" id="" cols="21.5" rows="5" placeholder="Popis produktu" required></textarea><br>
						</div>
					</label>
					<label>
						<h2>řidej počet kusů dané velikosti</h2>
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

				<div id="flex">
					<label>
						<h2>řidej počet kusů dané velikosti</h2>
						<div class="reg">
							<label for="XS">Velikost XS</label> <input type="number" name="XS" placeholder="Počet kusů XS"><br>
							<label for="S">Velikost S</label> <input type="number" name="S" placeholder="Počet kusů S"><br>
							<label for="M">Velikost M</label> <input type="number" name="M" placeholder="Počet kusů M"><br>
							<label for="L">Velikost L</label> <input type="number" name="L" placeholder="Počet kusů L"><br>
							<label for="XL">Velikost XL</label> <input type="number" name="XL" placeholder="Počet kusů XL"><br>
						</div>
					</label>
					<label>
						<h2>řidej počet kusů dané velikosti</h2>
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
				<td colspan="2" align="center">Poznámka: Podporované formáty: .jpeg, .jpg, .png, .gif</td>
			</tr>
		</table>
		</label>
		<p>*Pro správné fungovaní je potřeba vyplnit alespon jednu velikost a barvuano.</p>
		<input type="submit" name="ulozit" value="Přidat velikosti produktu">
		</form>
		</div>
		</div>
	</main>
</body>

</html>