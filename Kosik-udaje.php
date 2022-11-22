<!DOCTYPE html>
<html lang="cz">
<?php
session_start();
if (!isset($_COOKIE["produkt_id"])) {
	header("Location: Uzivatel-kosik.php ");
}
require("Urlzkrasnovac.php");
require("cookies.php");
?>

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
	<link rel="stylesheet" href="Css/cssKosik.css">
	<link rel="shortcut icon" href="img/logo.ico" />
	<title>Infiltrated</title>
</head>

<body>
	<header id="Myheader">
		<a href="index.php" id=aLogo>
			<svg version="1.1" id="Vrstva_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
				<g transform="translate(0.000000,1640.000000) scale(0.100000,-0.100000)">
					<path class="st0" d="M30.9,16343.7l-7.3-0.2l0.1-6.3l0.1-6.3l3.2-0.2c5.5-0.2,16.8-1.8,19.9-2.7c9.3-2.7,13.3-8,15.6-20
          c0.7-3.7,0.8-13,1-74.7l0.2-70.5H42H20.2l-1.2-1.4c-3-3.4-2.5-11.5,0.8-14.1c1-0.8,3.9-0.9,22.3-0.9c20.5,0,21.2-0.1,21.5-1.1
          c0.2-0.6,0.2-33.6,0.1-73.4c-0.2-65.6-0.3-72.6-1.1-76.7c-1.8-9.6-4.1-14-8.7-17.1c-4.7-3.2-12.3-4.7-27.2-5.4l-2.7-0.1v-6.5v-6.5
          l61.4-0.2l61.4-0.1l-0.1,6.6l-0.1,6.7l-7.4,0.4c-22.7,1.3-28.7,5.8-31.7,23.7c-0.8,4.9-0.9,10.5-0.9,77.3v72.1l42.1,0.2
          c37,0.1,42.2,0,42.7-0.7c0.8-1.1,1.5-1.1,1.2,0c-0.2,0.7,0.2,0.8,2.4,0.8c2.7,0,2.8-0.1,4.4-2.7c0.9-1.5,1.9-3.1,2.1-3.6
          c0.3-0.5,1.5-2.5,2.7-4.5c1.2-1.9,2.5-4.1,2.9-4.9c0.3-0.7,0.8-1.4,1.1-1.4c0.2,0,0.4-0.3,0.4-0.6c0-0.3,0.9-2,2-3.6
          c1.1-1.6,2-3.2,2-3.6c0-0.3,0.4-1,1-1.6c0.5-0.6,1-1.2,1-1.5c0-0.5,2.1-3.7,4.9-7.6c0.3-0.4,0.5-1,0.5-1.3c0-0.3,0.4-1.1,0.9-1.6
          c1.6-2.1,2.1-2.8,2.1-3.4c0-0.3,0.2-0.6,0.5-0.6c0.3,0,0.5-0.3,0.5-0.6c0-0.3,0.4-1.1,1-1.8c0.5-0.7,1-1.5,1-1.9
          c0-0.3,0.3-0.8,0.7-1c0.4-0.2,0.7-0.6,0.7-0.9c0-0.3,1.2-2.4,2.6-4.7c1.5-2.2,3.1-5,3.6-6c0.5-1.1,1-2.1,1.2-2.3c0.9-1,4-5.6,4-6
          c0-0.3,0.7-1.4,1.5-2.5c0.8-1.1,1.5-2.1,1.5-2.4c0-0.3,1-1.9,2.2-3.6c1.2-1.7,2.2-3.4,2.2-3.7c0-0.3,0.7-1.6,1.5-2.8
          c0.8-1.2,1.5-2.3,1.5-2.5s0.4-0.8,0.9-1.4c0.5-0.5,2.2-3.2,3.9-6c1.6-2.8,3.8-6.3,4.7-7.9c1-1.5,1.9-3.1,1.9-3.4
          c0-0.3,0.4-1.1,1-1.6c0.5-0.6,1-1.4,1-1.8c0-0.4,0.4-1,0.9-1.4c0.5-0.3,1.1-1.1,1.3-1.8c0.2-0.7,0.4-1.4,0.6-1.6
          c0.5-0.5,4.3-6.4,4.6-7.3c0.2-0.5,1-1.8,1.7-2.9c1.9-2.9,8-13,8-13.3c0-0.2,0.8-1.5,1.9-3c1-1.5,2.2-3.4,2.7-4.4
          c0.5-0.9,1.6-2.8,2.6-4.2c0.9-1.4,1.9-3.1,2.2-3.7c0.2-0.7,0.8-1.5,1.2-1.9c0.4-0.4,0.8-1,0.8-1.2c0-0.2,1.2-2.3,2.7-4.6
          c1.5-2.3,2.7-4.4,2.7-4.6c0-0.2,0.6-1.3,1.4-2.3c0.7-1,2.1-3.2,3.1-4.7c0.9-1.6,2-3.3,2.3-3.9c0.5-0.8,0.6-0.8,0.9,0.6
          c0.2,0.8,0.1,21.2-0.1,45.2l-0.4,43.7l-1.7,2.5c-3.4,5.1-4.3,6.6-5.2,8.5c-0.5,1.1-1.1,2.1-1.2,2.3c-0.6,0.7-5.4,7.9-5.4,8.3
          c0,0.2-0.7,1.6-1.7,3c-0.9,1.4-3,4.7-4.5,7.3c-1.6,2.7-3,4.9-3.2,5c-0.2,0.1-0.4,0.6-0.4,1s-0.3,0.8-0.7,1.1
          c-0.4,0.2-1,0.9-1.3,1.6c-0.8,2.1-1.7,3.8-2.8,5.1c-0.5,0.7-1.5,2.3-2.3,3.5c-0.7,1.2-2.2,3.7-3.3,5.4c-2.1,3.2-3.9,6.2-7.4,12.1
          c-1.1,1.9-2.1,3.5-2.3,3.7c-0.5,0.5-1.5,2.3-2.1,3.9c-0.2,0.7-0.7,1.2-0.9,1.2c-0.3,0-0.9,0.8-1.3,1.9c-0.4,1-1.5,2.7-2.2,3.8
          c-0.8,1.1-1.4,2.4-1.4,2.7c0,0.5,8.2,0.6,30,0.5l30-0.2l0.1-19.2c0.1-10.6,0-36.6-0.3-57.9s-0.3-55.1-0.2-75l0.2-36.3l40.3,0.3
          l40.4,0.3l0.1,6.3l0.1,6.3l-9,0.6c-10.5,0.7-15.3,1.8-19.3,4.2c-7.1,4.4-9.6,11-10.7,28.7c-0.2,3.9-0.5,37.4-0.5,74.5v67.4h13.2
          c7.3,0,14.6-0.3,16.4-0.6c6.8-1.2,12.2-3.5,16.7-7.2c7.8-6.3,11.9-16.6,15.1-37.8l1.1-6.8l6.5-0.2l6.5-0.2l0.1,30.1
          c0.1,16.6,0.1,44.3,0,61.7l-0.1,31.5h-6.4c-4.7,0-6.5-0.2-6.6-0.7c-0.1-0.4-0.5-3.7-1-7.2c-3.1-24.4-9.2-35.3-22.8-40.8
          c-4.9-2-12.9-3.3-22.4-3.9c-9.3-0.5-13.9-0.7-15.4-0.6c-0.8,0.1-0.9,4.4-0.9,81.5v81.4l1.3,0.3c0.7,0.2,12.7,0.2,26.8,0.1
          c19-0.2,26.9-0.5,30.8-1.1c34.7-5.7,48.3-23.2,57.4-73.9l0.6-3.7l4.4,0.2c2.5,0.1,5.7,0.3,7.3,0.5l2.8,0.3v3.2
          c0,1.8-0.2,6.4-0.5,10.3c-0.2,3.9-0.7,11.1-1,16.1c-1.5,26.6-1.9,34-2.7,46.9c-0.9,17.4-1,17.6-2.3,18.1
          c-1.1,0.4-207-0.3-207.6-0.7c-0.2-0.1-0.4-2.9-0.4-6.1c0-6.8-0.9-6,7.9-7.1c19.3-2.3,28.4-9.7,31.6-25.6
          c2.2-10.8,2.3-15.1,2.3-79.5v-61.3l-35.5-0.2c-34.6-0.1-35.5-0.1-36.3,1c-1.1,1.6-4.4,6.9-5.1,8.3c-0.5,1.2-5.5,9.1-8.7,14.1
          c-0.8,1.3-1.8,3.1-2.2,4.1c-0.4,0.9-1.1,1.9-1.5,2c-0.4,0.2-0.7,0.7-0.7,1.2c0,0.5-0.2,0.8-0.4,0.8c-0.2,0-0.7,0.6-1,1.3
          c-0.3,0.7-1.3,2.4-2.3,3.8c-0.9,1.4-1.7,2.7-1.7,2.9c0,0.5-3,5-4.6,7.3c-0.6,0.8-1.5,2.3-2,3.4c-0.5,1.1-1.8,3.1-2.9,4.5
          c-1,1.5-1.9,3.1-1.9,3.6s-0.2,0.9-0.4,0.9c-0.2,0-1.5,1.8-2.8,3.9c-1.3,2.2-2.6,4.2-3,4.6c-0.4,0.3-0.7,1.1-0.7,1.7s-0.4,1.4-1,1.8
          c-0.5,0.4-1,1-1,1.2c0,0.3-0.8,1.6-1.9,3.1c-1,1.5-2,3.1-2.2,3.5c-0.6,1.6-1.5,3.2-3.3,5.7c-1,1.4-2.8,4.2-4,6.2
          c-1.1,2-2.9,4.7-3.8,6.1c-0.9,1.4-1.6,2.8-1.6,3.3s-0.3,0.8-0.7,0.8c-0.3,0-0.8,0.5-1,1c-0.1,0.5-1.3,2.5-2.5,4.4
          c-1.2,1.9-2.4,3.8-2.6,4.2c-0.3,0.7-1.7,2.9-5.1,8c-0.5,0.8-1,1.8-1,2.1s-0.2,0.6-0.5,0.6c-0.3,0-0.8,0.7-1.1,1.6
          c-0.3,0.8-1,1.9-1.5,2.4c-0.5,0.5-0.9,1.2-0.9,1.6c0,0.3-0.1,0.6-0.4,0.6c-0.2,0-0.6,0.5-0.8,1.1c-1,2.2-4.9,8.5-5.2,8.5
          c-0.1,0-0.8,1.1-1.5,2.4c-0.6,1.3-1.9,3.4-2.8,4.7c-0.9,1.3-1.6,2.5-1.6,2.8c0,1.4-5.5,7.1-8.3,8.5c-3,1.6-8,1.8-11.5,0.6
          c-8.1-2.8-15.8-13.1-18-24c-1.1-5.4-0.6-7.9,2.4-13.1c1.4-2.4,2.6-4.5,2.8-4.6c0.7-0.7,4.4-7.2,4.4-7.8c0-0.4,0.1-0.7,0.4-0.7
          c0.3-0.1,2.5-3.4,4.5-7.1c0.5-0.9,2.4-4.1,4.2-7c1.8-2.9,3.2-5.4,3.2-5.7c0-0.2,0.5-1.1,1.3-2c1.3-1.7,5.6-8.7,5.6-9.2
          c0-0.2,0.7-1.3,1.5-2.4c2.4-3.2,2.5-3.4,2.5-4c0-0.3,0.7-1.3,1.5-2.3c0.8-1,1.5-2.1,1.5-2.4c0-0.3,0.8-1.8,1.9-3.2
          c1-1.4,2.1-3.3,2.5-4.1c0.3-0.9,0.8-1.6,1.1-1.6c0.2,0,0.5-0.3,0.5-0.6c0-0.3,0.2-0.9,0.5-1.3c1.7-2.4,2.9-4.4,4-6.3
          c1.1-2.1,4.6-7.7,5.7-9.1c0.3-0.4,1.1-1.8,1.8-3.1c2.1-3.9,2.6-4.6,3.5-5.8c0.4-0.6,0.8-1.3,0.8-1.6c0-0.4,2.7-4.8,4.1-6.7
          c0.3-0.5,1.5-2.3,2.5-4c1-1.7,2.7-4.5,3.8-6.2c1.1-1.7,2.7-4.5,3.5-6c0.8-1.6,1.8-3,2-3s0.4-0.4,0.4-0.8c0-0.7-0.6-0.8-2.7-0.8
          c-1.5,0-2.7,0.3-2.7,0.6c0,0.3-0.3,0.6-0.7,0.6s-0.7-0.3-0.7-0.7c0-0.6-7.7-0.7-36.7-0.7h-36.7l-0.3,61.2
          c-0.2,33.6-0.5,63-0.6,65.1c-0.6,7.5,1.2,17.2,4.5,23.7c2.5,4.9,8.1,11.2,11.5,13.1c4.1,2.2,10.9,3.8,17.3,4.2
          c8.7,0.5,7.9-0.2,7.9,7v6.1l-20.9,0.3C106.1,16344.1,46.7,16344,30.9,16343.7z" />
				</g>
			</svg>
		</a>
		<?php
		spl_autoload_register(function ($trida) {
			include_once "Class/$trida.php";
		});
		if (isset($_POST["prihlasit"])) {
			//echo password_hash($_POST["heslo"],PASSWORD_DEFAULT);
			if (empty($_POST["login"] || empty($_POST["heslo"]))) {
				echo "<div class='chyba'>Nezadán e-mail a heslo.</div>";
			} else {
				$db = new UzivatelDB();
				$uzivatel = new Uzivatel();
				if ($uzivatel = $db->overUzivatele($_POST["login"], $_POST["heslo"])) {
					$_SESSION["id_uzivatele"] = $uzivatel->id;
					$_SESSION["uzivatel_id"] = $uzivatel->id;
					//$_SESSION["login"] = $uzivatel->login;
					$_SESSION["prava"] = $uzivatel->prava;
					echo "<h2 class='spravne'>Byl jste přihlášen</h2>";
				} else {
					echo "<h2 class='chyba'>Zadány nesprávné údaje</h2>";
				}
			}
		}
		if (isset($_POST["ulozit"])) {
			if ($_POST["heslo"] != $_POST["heslo-opakovani"]) {
				echo "<p class='chyba'> Hesla se neshoduji</p>";
			} else {
				$uzivatel = new Uzivatel();
				$uzivatel->nastavHodnoty($_POST["jmeno"], $_POST["prijmeni"], $_POST["email"], $_POST["login"], $_POST["heslo"], $_POST["ulice"], $_POST["mesto"], $_POST["telkontakt"], $_POST["cislo_popisne"], $_POST["PSC"], $_SESSION["prava"], $_GET["id"]);
				if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
					echo "<p class='chyba'> Špatně zadaná e-mail</p>";;
				}
				$db = new UzivatelDB();
				$id = $db->ulozUzivatele($uzivatel);
				if ($id > 0) {
					echo "<h2 class='spravne'>Data byla změněna</h2>\n";
				}
			}
		} else {
			if (isset($_SESSION["id_uzivatele"])) {
				$db = new UzivatelDB();
				$uzivatel = new Uzivatel();
				$uzivatel = $db->nactiUzivatel($_SESSION["id_uzivatele"]);
			} else {
				$db = new UzivatelDB();
				$uzivatel = new Uzivatel();
			}
		}
		if (isset($_POST["potvrdit_objednavku"])) {
			spl_autoload_register(function ($trida) {
				include_once "Class/$trida.php";
			});
			$objednavka = new Objednavka();
			$uzivatel = new Uzivatel();
			$produkt = new Produkt();
			$db_uzivatel = new UzivatelDB();
			$db_objednavka = new ObjednavkaDB();
			$db_produkt = new ProduktDB();
			$celkova_cena = 0;
			if (!isset($_SESSION["id_uzivatele"])) {
				$true = $uzivatel->nastavneRegistraci($_POST["jmeno"], $_POST["prijmeni"], $_POST["email"], $_POST["ulice"], $_POST["mesto"], $_POST["telkontakt"], $_POST["cislo_popisne"], $_POST["PSC"], 0, $id = null);
				if ($true == true) {
					$db_uzivatel = new UzivatelDB();
					$id = $db_uzivatel->pridatUzivatele($uzivatel);
					$_SESSION["id_uzivatele_neprihlasen"] = $id;
					$id_objednavky = $db_objednavka->vytvorObjednavku($id, $_POST["zpusob_doruceni"]);
					if (!empty($_COOKIE["produkt_id"])) {
						foreach ($_COOKIE["produkt_id"] as $index => $value) {
							if ($db_produkt->nactiProdukt($_COOKIE['produkt_id'][$index])) {
								$polozka = $db_objednavka->vlozPolozkuDoObjednavky($id_objednavky, $_COOKIE['produkt_id'][$index], $_COOKIE['pocet_produktu'][$index], $_COOKIE['velikost'][$index]);
								$produkt = $db_produkt->nactiProdukt($_COOKIE['produkt_id'][$index]);
								$sleva = $produkt->cena  / 100 * $produkt->sleva;
								$zlevnena_a_vynasobena_cena = ($produkt->cena - $sleva) * $_COOKIE['pocet_produktu'][$index];
								$celkova_cena += $zlevnena_a_vynasobena_cena;
								if (!isset($_SESSION["id_uzivatele"])) {
									$celkova_cena += 40;
								}
							}
						}
					}
					$db_objednavka->doplnCenuObjednavky($celkova_cena, $id_objednavky);
					$_SESSION["id_objednavky"] = $id_objednavky;
		?>
					<script>
						location.replace("Kosik-platba.php");
					</script>
				<?php
					//header("Location: Kosik-platba.php ");
				}
			} else {
				if (isset($_POST['ulozit_informace'])) {
					$uzivatel->nastavneRegistraci($_POST["jmeno"], $_POST["prijmeni"], $_POST["email"], $_POST["ulice"], $_POST["mesto"], $_POST["telkontakt"], $_POST["cislo_popisne"], $_POST["PSC"], 1, $_SESSION["id_uzivatele"]);
					$db_uzivatel->ulozUzivatelebezhesla($uzivatel);
				}
				$id_objednavky = $db_objednavka->vytvorObjednavku($_SESSION["id_uzivatele"], $_POST["zpusob_doruceni"]);
				if (!empty($_COOKIE["produkt_id"])) {
					foreach ($_COOKIE["produkt_id"] as $index => $value) {
						if ($db_produkt->nactiProdukt($_COOKIE['produkt_id'][$index])) {
							$polozka = $db_objednavka->vlozPolozkuDoObjednavky($id_objednavky, $_COOKIE['produkt_id'][$index], $_COOKIE['pocet_produktu'][$index], $_COOKIE['velikost'][$index]);
							$produkt = $db_produkt->nactiProdukt($_COOKIE['produkt_id'][$index]);
							$sleva = $produkt->cena  / 100 * $produkt->sleva;
							$zlevnena_a_vynasobena_cena = ($produkt->cena - $sleva) * $_COOKIE['pocet_produktu'][$index];
							$celkova_cena += $zlevnena_a_vynasobena_cena;
							if (!isset($_SESSION["id_uzivatele"])) {
								$celkova_cena += 40;
							}
						}
					}
				}
				$db_objednavka->doplnCenuObjednavky($celkova_cena, $id_objednavky);
				$_SESSION["id_objednavky"] = $id_objednavky;
				?>
				<script>
					location.replace("Kosik-platba.php");
				</script>
		<?php
				//	header("Location: Kosik-platba.php ");
			}
		}
		?>
		<div id="SaN">
			<div id="search">
				<form action="Produkty.php" method="get">
					<input id="hledat" type="search" name="hledany_text" placeholder="search...">
					<button type="submit" id="noBorder"><span class="material-icons">search</span></button>
				</form>
			</div>
			<nav>
				<?php
				if (isset($_SESSION["id_uzivatele"]) && isset($_SESSION["prava"]) && $_SESSION["prava"] == 3) {
					echo "<a href='Uzivatel-administrace.php' title='Oprávnění, kontakty, hesla'>
        <span class='material-icons'>
        manage_accounts
        </span>
        </a>";
				} else {
					echo "<a href='Uzivatel-profil.php'>
      <span class='material-icons'>
       person
      </span>
      </a>";
				}
				if (isset($_SESSION["id_uzivatele"]) && isset($_SESSION["prava"]) && $_SESSION["prava"] >= 2) {
					echo "<a href='Produkt-administrace.php' title='Správa a administrace produktů'>
    <span class='material-icons'>
    inventory
    </span>
    </a>";
				} else {
					echo "<a href='Uzivatel-oblibene.php' title='Oblíbené produkty'>
        <span class='material-icons'>
        favorite_border
        </span>";
					spl_autoload_register(function ($trida) {
						include_once "Class/$trida.php";
					});
					if (isset($_SESSION["id_uzivatele"])) {
						$db = new ProduktDB();
						$produkt = new Produkt();
						$a = $db->nactiPocetOblibenychProduktuUzivatele($_SESSION["id_uzivatele"]);
						echo "<span class='badge badge-warning' id='lblCartCount'> $a->pocet </span>";
					}
					echo "</a>";
				}

				if (isset($_SESSION["id_uzivatele"]) && isset($_SESSION["prava"]) && $_SESSION["prava"] >= 2) {
					echo "<a href='Produkt-sprava.php' title='Správa a administrace produktů'>
    <span class='material-icons'>
    settings
    </span>
    </a>";
				} else {
					echo
					"<a href='Uzivatel-kosik.php'  title='Košík'><i class='material-icons'>shopping_cart</i>
					<span class='badge badge-warning' id='lblCartCount'>";
					spl_autoload_register(function ($trida) {
						include_once "Class/$trida.php";
					});
					$db = new ProduktDB();
					$produkt = new Produkt();
					$pocet = 0;
					if (isset($_COOKIE['produkt_id'])) {
						if (isset($_COOKIE['produkt_id'])) {
							foreach ($_COOKIE['produkt_id'] as $i => $val) {
								if ($db->nactiProdukt($_COOKIE['produkt_id'][$i])) {
									$pocet++;
								}
							}
						}
					}
					echo "$pocet </span></a>";
				}

				if (isset($_SESSION["id_uzivatele"]) && isset($_SESSION["prava"])) {
					echo "<a href='Uzivatel-odhlaseni.php' title='Odhlášení'><i class='material-icons'>logout</i></a>";
				} else {
					echo "<a href='Uzivatel-prihlaseni.php' title='Přihlášení'><i class='material-icons'>login</i></a>";
				}
				?>
			</nav>
		</div>
	</header>
	<main>
		<section id="flex_big">
			<div class="blok">
				<form method="post">
					<label>
						<h1>INFORMACE O DORUČENÍ</h1>
						<div>
							<div class="flex1">
								<input id="input" type="text" name="jmeno" placeholder="Jméno" value="<?php echo "$uzivatel->jmeno" ?>" required>
								<input id="input" type="text" name="prijmeni" placeholder="Příjmení" echo" value="<?php echo "$uzivatel->prijmeni" ?>" required>
							</div>
							<div class="flex1">
								<input id="input" type="text" name="ulice" placeholder="Ulice" value="<?php echo "$uzivatel->ulice" ?>" required>
								<input id="input" type="number" name="cislo_popisne" placeholder="Císlo popisné" value="<?php echo "$uzivatel->cislo_popisne" ?>" required>
							</div>
							<div class="flex1">
								<input id="input" type="text" name="mesto" placeholder="Město" value="<?php echo "$uzivatel->mesto" ?>" required>
								<input id="input" type="number" name="PSC" placeholder="PSC" value="<?php echo "$uzivatel->PSC" ?>" required>
							</div>
						</div>
					</label>
			</div>
			<div class="blok">
				<label>
					<h2>Kontaktní údaje</h2>
					<div>
						<p>Prostřednictvím těchto údajů tě budeme informovat o doručení objednávky (Teda vlatně ne).</p>
						<input id="input" type="email" name="email" class="sirka" placeholder="E-mail" echo" value="<?php echo "$uzivatel->email" ?>" required><br>
						<input id="input" type="tel" name="telkontakt" class="sirka" placeholder="Telefonní číslo" value="<?php echo "$uzivatel->telkontakt" ?>" required><br>
						<?php
						if (isset($_SESSION["id_uzivatele"])) {
							echo "<label class='container'> Máte zájem o uložení nebo úpravu svých informací k tomuto účtu pro snažší budoucí nákup?
							<input class='input_doruceni' type='checkbox' name='ulozit_informace'>
							<span class='mark'></span>
						</label>";
						}
						?>
					</div>
			</div>

			<div class="blok">
				<h1> Způsob doručení</h1>
				<label class="container">Česká pošta - 40Kč
					<input class="input_doruceni" type="radio" name="zpusob_doruceni" Value="Česká pošta" required>
					<span class="mark"></span>
				</label>
				<label class="container">PPL - 60kč
					<input class="input_doruceni" type="radio" name="zpusob_doruceni" Value="PPL" required>
					<span class="mark"></span>
				</label>
				<label class="container">DPP - 80kč
					<input class="input_doruceni" type="radio" name="zpusob_doruceni" Value="DPP" required>
					<span class="mark"></span>
				</label>
			</div>
		</section>
		<section id="flex_small">
			<button id="order3" class="next" type="submit" name="potvrdit_objednavku" value="">Pokračovat k Platbě</button>
			<?php
			//if(!isset($_SESSION["id_uzivatele"]))
			//{
			//	echo "
			//	<div class='blok'>
			//				<label class='container'> Chcete provést registraci?
			//		<input class='input_doruceni' type='checkbox' name='registrace' Value='0' required>
			//		<span class='mark'></span>
			//	</label>
			//	</div>";
			//}
			?>
			</form>
			<div id="order1" class="blok">
				<form method="post">
					<label>
						<h1>Přihlaš se</h1>
						<input id="input" type="text" name="login" required placeholder="E-mail"> <br>
						<input id="input" type="password" name="heslo" required placeholder="Heslo"><br>
						<input id="input" class="ulozit" type="submit" name="prihlasit" value="Přihlásit">
					</label>
					<div class="prihlaseni-blok">
						<p>STAŇ&nbsp;SE&nbsp;ČLENEM&nbsp;KLUBU.&nbsp;ZÍSKEJ&nbsp;ODMĚNY. <a class="input" id=registr href="Uzivatel-registrace.php">Zaregistruj&nbsp;se&nbsp;zde</a> </p>
					</div>
				</form>
			</div>
			<div class="blok" id="infoAndBuy">
				<h1>Shrnutí objednávky</h1>
				<?php
				if (isset($_COOKIE['produkt_id'])) {
					$produkt = new Produkt();
					$db = new ProduktDB();
					foreach ($_COOKIE['produkt_id'] as $i => $val) {
						if ($db->nactiProdukt($_COOKIE['produkt_id'][$i])) {
							//var_dump($_COOKIE['produkt_id'][$i], $_COOKIE['pocet_produktu'][$i], $_COOKIE['velikost'][$i]);
							$produkt = $db->nactiProdukt($_COOKIE['produkt_id'][$i]);
							$produkt->vypisLegendyKosiku($_COOKIE['pocet_produktu'][$i]);
						}
					}
				} else {
					echo "<p>Košík je zatím prázdný</p>";
				}
				?>
				<!-- Write your comments here
				<! ––<span class="flex">
					<p>Doručení</p>-->
				<?php  //if (isset($_SESSION["id_uzivatele"])) {
				//	echo "<p>Zdarma</p>";
				//} else {
				//	echo "<p>40 Kč</p>";
				//}
				//
				?>
				<!-- </span>-->
				<span class="flex" id='borer_top'>
					<?php
					$celkova_cena = 0;
					$DPH = 0;
					if (isset($_COOKIE['produkt_id'])) {
						foreach ($_COOKIE['produkt_id'] as $i => $val) {
							if ($db->nactiProdukt($_COOKIE['produkt_id'][$i])) {
								//var_dump($_COOKIE['produkt_id'][$i], $_COOKIE['pocet_produktu'][$i], $_COOKIE['velikost'][$i]);
								$produkt = $db->nactiProdukt($_COOKIE['produkt_id'][$i]);
								$sleva = $produkt->cena  / 100 * $produkt->sleva;
								$DHP_vypocet =  ($produkt->cena / 100 * 21) * $_COOKIE['pocet_produktu'][$i];
								//var_dump($DHP_vypocet);
								$zlevnena_a_vynasobena_cena = ($produkt->cena - $sleva) * $_COOKIE['pocet_produktu'][$i];
								$celkova_cena += $zlevnena_a_vynasobena_cena;
								$DPH += $DHP_vypocet;
								if (!isset($_SESSION["id_uzivatele"])) {
									$celkova_cena += 40;
								}
							}
							//var_dump($DPH);
						}
					}
					echo "<h3>Celkem (včetně DPH(21%) $DPH Kč )</h3>";
					echo "<p> $celkova_cena Kč</p>";
					?>
				</span>
			</div>
			</span>
		</section>
	</main>
	<footer>
		<p>Karel Valenta © 2022</p>
	</footer>
</body>

</html>