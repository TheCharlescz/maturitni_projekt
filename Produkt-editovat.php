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
	<title>Infiltrated - Editace produktu</title>
</head>

<body>
	<header id="Myheader">
		<div>
			<h2>Editace produktu</h2>
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
				if ($produkt->nastavHodnoty($_POST["akce_id"], $_POST["kategorie_id"], $_POST["materialy_id"], $_POST["znacky_id"], $_SESSION["id_uzivatele"], $_POST["typy_id"], $_POST["nazev"], $_POST["popis"], $_POST["pohlavi"], $_POST["cena"], $_POST["sleva"], "0", $_GET["id"])) {
					$db = new ProduktDB();
					$produkt_id = $db->ulozProdukt($produkt);
					if ($produkt_id > 0) {
						//header("Location: Produkt-pridat.php?id_produkt=$velikost_id");
						echo  "<h2 class='spravne'>Produkt byl upraven</h2>\n";
					} else {
						echo "<h2 class='chyba'>Produkt se nepodařilo vytvořit</h2>\n";
						echo "<p class='chyba'>Podívejte se jestli nezadáváte název prodkutu, který už byl vytvořen</p>\n";
					}
				}

				extract($_POST);
				$error = array();
				$extension = array("jpeg", "jpg", "png", "gif");
				$pocet = 1;
				$txtGalleryName = $_POST["nazev"];
				foreach ($_FILES["files"]["tmp_name"] as $key => $tmp_name) {
					$file_name = $_FILES["files"]["name"][$key];
					$file_tmp = $_FILES["files"]["tmp_name"][$key];
					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					$file_name = $produkt_id . "." . $pocet . "." . $ext;
					if (in_array($ext, $extension)) {
						if (!file_exists("img/" . $txtGalleryName . "/" . $file_name)) {
							move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], "img/" . $txtGalleryName . "/" . $file_name);
						} else {
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
				//$barva = new Barva();
				//$db = new BarvaDB();
				//$barvy = $db->nactiBarvy();
				//foreach ($barvy as $barva) {
				//    $barva->vypisFunkceOdstranitBarvy($produkt_id);
				//}

				spl_autoload_register(function ($trida) {
					include_once "Class/$trida.php";
				});
				$db = new VelikostDB();
				$velikost = new Velikost();
				$velikosti = $db->nactiVelikostiProduktuEditace($_GET["id"]);
				foreach ($velikosti as $velikost) {
					$ulozena_velikost = new Velikost();
					if ($ulozena_velikost->nastavHodnoty("$velikost->velikost", $_POST["$velikost->velikost"], $velikost->id)) {
					}
				}
			} else {
				$db = new ProduktDB();
				$produkt = $db->nactiProdukt($_GET["id"]);
				$db_velikost = new VelikostDB();
				$db_velikost = $db_velikost->nactiVelikostiProduktu($_GET["id"]);
				$db_barva = new BarvaDB();
				$db_barva = $db_barva->nactiBarvyProduktu($_GET["id"]);
			}
			?>
			<a class='input' href='Produkt-administrace.php'>Zpět na administraci produktů</a>
		</div>
	</header>
	<main>
		<div class="blok">
			<form method="post" enctype="multipart/form-data">
				<div id="flex">
					<label>
						<h2>řidej počet kusů dané velikosti</h2>
						<div class="reg">
							<input type="text" name="nazev" placeholder="Nazev produktu" value=<?php echo " $produkt->nazev" ?>
								required> <br>
							<input type="number" name="cena" placeholder="Cena" value=<?php echo " $produkt->cena" ?> required><br>
							<input type="number" name="sleva" placeholder="Sleva" value=<?php echo " $produkt->sleva" ?> required><br>
							<select name="pohlavi" class="input">
								<option value="">Vyberte jednu z možností</option>
								<?php
								echo "<option value='Muz'" . ('Muz' == $produkt->pohlavi ? 'selected' : '') . " >Pánské</option>";
								echo "<option value='Zena'" . ('Zena' == $produkt->pohlavi ? 'selected' : '') . " >Zenské</option>";
								echo "<option value='Dite' " . ('Dite' == $produkt->pohlavi ? 'selected' : '') . ">Dětské</option>";
								echo "<option value='Unisex' " . ('Unisex' == $produkt->pohlavi ? 'selected' : '') . ">Unisex</option>";
								?>
							</select><br>
							<textarea name="popis" id="" cols="21.5" rows="5" placeholder="Popis produktu"
								required><?php echo " $produkt->popis" ?></textarea><br>
						</div>
					</label>
					<label>
						<h2>Přidej počet kusů dané velikosti</h2>
						<div class="reg">

							<select name="akce_id" class="input" required>
								<option value="">Vyberte jednu z akci</option>
								<?php
								spl_autoload_register(function ($trida) {
									include_once "Class/$trida.php";
								});
								$db = new AkceDB();
								$akci = new Akce();
								$akce = $db->nactiAkce();
								foreach ($akce as $akci) {
									echo "<option value='$akci->id'" . ($akci->id == $produkt->akce_id ? "selected" : "") . "> $akci->akce</option>";
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
									echo "<option value='$kategorii->id'" . ($kategorii->id == $produkt->kategorie_id ? "selected" : "") . "> $kategorii->kategorie</option>";
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
									echo "<option value='$material->id'" . ($material->id == $produkt->materialy_id ? "selected" : "") . "> $material->material</option>";
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
									echo "<option value='$znacka->id'" . ($znacka->id == $produkt->znacky_id ? "selected" : "") . "> $znacka->znacka</option>";
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
									echo "<option value='$typ->id'" . ($typ->id == $produkt->typy_id ? "selected" : "") . "> $typ->typ</option>";
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
							<?php
							spl_autoload_register(function ($trida) {
								include_once "Class/$trida.php";
							});
							$db = new VelikostDB();
							$velikost = new Velikost();
							$velikosti = $db->nactiVelikostiProduktuEditace($_GET["id"]);
							foreach ($velikosti as $velikost) {
								echo "<label for=$velikost->velikost>Velikost $velikost->velikost</label> <input type='number' name=$velikost->velikost
                                    placeholder='Počet kusů XS' value= $velikost->pocet_kusu><br>";
							}
							?>
						</div>
					</label>
					<label>
						<h2>řidej počet kusů dané velikostiwwrgqrg</h2>
						<div class="reg">
							<?php
							spl_autoload_register(function ($trida) {
								include_once "Class/$trida.php";
							});
							$barva = new Barva();
							$db = new BarvaDB();
							//$barvy = $db->nactiBarvy();
							$barvy = $db->nactiProduktmaBarvy();
							foreach ($barvy as $barva) {
								echo "<label class=label_checkbox for='$barva->barva'>$barva->barva<input type='checkbox' name='$barva->barva' " . ($barva->barvy_id === $barva->id  ? "checked" : "") . "></label><br>";
							}
							?>
					</label>
				</div>

		</div>
		<table width="100%">
			<tr>
				<td>Select Photo (one or multiple):</td>
				<td><input type="file" name="files[]" multiple /></td>
			</tr>
			<tr>
				<td colspan="2" align="center">Note: Supported image format: .jpeg, .jpg, .png, .gif</td>
			</tr>
		</table>
		</label>
		<p>*Pro správné fungovaní je potřeba vyplnit alespon jednu velikost a barvu.</p>
		<input type="submit" name="ulozit" value="Přidat velikosti produktu">
		</form>
		</div>
		</div>
	</main>
</body>

</html>