<?php
session_start();
if (!isset($_SESSION["id_uzivatele"]) || !isset($_SESSION["prava"])) {
	header("Location: Uzivatel-prihlaseni.php ");
}

if ($_SESSION["prava"] < 1) {
	header("Location: Uzivatel-profil.php");
}
		spl_autoload_register(function ($trida) {
			include_once "Class/$trida.php";
		});
		$produkt = new Produkt();
		$db = new ProduktDB();
		$produkt = $db->nactiProdukt($_GET["id"]);
		$dir = "/wamp64/www/maturitni_projekt/img_produkt/$produkt->nazev/";
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh))) {
					if ($file === '.' || $file === '..') continue;
					unlink("img_produkt/$produkt->nazev/$file");
				}
				closedir($dh);
			}
		}
		rmdir("img_produkt/$produkt->nazev");
		$db_velikost = new VelikostDB();
		$vysledek_velikost =  $db_velikost->smazVelikostProduktu($_GET["id"]);
		$db_velikost = new BarvaDB();
		$vysledek_barva =  $db_velikost->smazBarvyProduktu($_GET["id"]);
		$vysledek = $db->smazProdukt($_GET["id"]);
		if ($vysledek && $vysledek_barva &&  $vysledek_velikost == true) {
			echo "<h2 class= 'spravne'>Produkt byl smazán</h2>
			<a href='Produkt-administrace.php'>Zpět na admministraci produktu</a>";
			header("Location: Produkt-administrace.php ");
		} else {
			echo "<h2 class= 'chyba'>Produkt nebyl smazán</h2>
            <a href='Produkt-administrace.php'>Zpět na admministraci produktu</a>";
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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="Css/cssHamenu.css">
	<link rel="shortcut icon" href="img/logo.ico" />
	<title>Infiltrated</title>
</head>

<body>
	<main>
		<?php
		?>
	</main>
	<footer>
		<p>This website is used only for study purposes and not for commerce. Web created by <span
				style="color:green">Charles</span>.</p>
	</footer>

</body>