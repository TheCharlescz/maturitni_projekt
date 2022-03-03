<?php
if (isset($_POST["pridat-do-kosiku"])) {

	if (empty($_COOKIE["produkt_id"])) {
		setcookie("pocet", 0, time() + (86400 * 30));
		setcookie("produkt_id[0]", $_POST["pridat-do-kosiku"], time() + (86400 * 30));
		setcookie("pocet_produktu[0]", 1, time() + (86400 * 30));
		if (isset($_POST["velikost"])) {
			setcookie("velikost[0]", $_POST["velikost"], time() + (86400 * 30));
		} else {
				setcookie("velikost[0]", "M" , time() + (86400 * 30));
		}
	} elseif (!in_array($_POST["pridat-do-kosiku"], $_COOKIE["produkt_id"])) {
		$pocet = $_COOKIE["pocet"];
		$pocet++;
		setcookie("pocet", $pocet, time() + (86400 * 30));
		setcookie("produkt_id[$pocet]", $_POST["pridat-do-kosiku"], time() +  (86400 * 30));
		setcookie("pocet", $pocet, time() + (86400 * 30));
		setcookie("pocet_produktu[$pocet]", 1, time() + (86400 * 30));
		if(isset($_POST["velikost"])) {
			setcookie("velikost[$pocet]", $_POST["velikost"], time() + (86400 * 30));
		} else {
			setcookie("velikost[$pocet]", "M", time() + (86400 * 30));
		}
	} elseif (in_array($_POST["pridat-do-kosiku"], $_COOKIE["produkt_id"])) {
		foreach ($_COOKIE["pocet_produktu"] as $index => $value) {
			$key = array_search($_POST["pridat-do-kosiku"], $_COOKIE["produkt_id"]);
			if ($key == $index) {
				$value++;
				setcookie("pocet_produktu[$index]", $value, time() + (86400 * 30));
				if (isset($_POST["velikost"])) {
					setcookie("velikost[$index]", $_POST["velikost"], time() + (86400 * 30));
				}
			}
		}
	}
}
if (isset($_POST["pocet_kusu"])) {
	foreach ($_COOKIE["pocet_produktu"] as $index => $value) {
		$key = array_search($_GET["id_produktu"], $_COOKIE["produkt_id"]);
		if ($key == $index) {
			setcookie("pocet_produktu[$index]", $_POST["pocet_kusu"], time() + (86400 * 30));
			header("Refresh:0");
		}
	}
}
if (isset($_POST["velikost"])) {
	foreach ($_COOKIE["velikost"] as $index => $value) {
		$key = array_search($_GET["id_produktu"], $_COOKIE["produkt_id"]);
		if ($key == $index) {
				setcookie("velikost[$index]", $_POST["velikost"], time() + (86400 * 30));
			header("Refresh:0");
		}
	}
}
if (isset($_POST["velikost_v_produktu"])) {
	foreach ($_COOKIE["velikost"] as $index => $value) {
		$key = array_search($_POST["pridat-do-kosiku"], $_COOKIE["produkt_id"]);
		if ($key == $index) {
			setcookie("velikost[$index]", $_POST["velikost_v_produktu"], time() + (86400 * 30));
			header("Refresh:0");
		}
	}
}
if (isset($_POST["odebrat-z-kosiku"])) {
	if (!empty($_COOKIE["produkt_id"])) {
		foreach ($_COOKIE["produkt_id"] as $index => $value) {
			$key = array_search($_POST["odebrat-z-kosiku"], $_COOKIE["produkt_id"]);
			if ($key == $index) {
				setcookie("produkt_id[$index]", $_POST["odebrat-z-kosiku"], time() - 1);
				setcookie("pocet_produktu[$index]", 1, time() - 1);
				setcookie("velikost[$index]", "", time() - 1);
				header("Refresh:0");
			}
		}
	}
}
if (isset($_POST["potvrdit_objednavku"])) {
	spl_autoload_register(function ($trida) {
		include_once "Class/$trida.php";
	});
	$objednavka = new Objednavka();
	$uzivatel = new Uzivatel();
	$db_objednavka = new ObjednavkaDB();
	$db_produkt = new ProduktDB();
	$celkova_cena = 0;
    if (!isset($_SESSION["id_uzivatele"])) {
			$uzivatel->nastavneRegistraci($_POST["jmeno"], $_POST["prijmeni"], $_POST["email"], $_POST["ulice"], $_POST["mesto"], $_POST["telkontakt"], $_POST["cislo_popisne"], $_POST["PSC"], 0, $id = NULL);
		$db_uzivatel = new UzivatelDB();
		$id = $db_uzivatel->pridatUzivatele($uzivatel);
		$id_objednavky = $db_objednavka->vytvorObjednavku($id ,  $_POST["zpusob_doruceni"]);
        } else {
		$id_objednavky = $db_objednavka->vytvorObjednavku($_SESSION["id_uzivatele"] , $_POST["zpusob_doruceni"]);
				}
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
          setcookie("produkt_id[$index]", "", time() - 1);
          setcookie("pocet_produktu[$index]", 1, time() - 1);
          setcookie("velikost[$index]", "", time() - 1);

      }
		}
	}
	var_dump($celkova_cena);
	var_dump($id_objednavky);
	$db_objednavka->doplnCenuObjednavky($celkova_cena, $id_objednavky);
	$_SESSION['id_objednavky'] = $id_objednavky;
	header("Location: Kosik-platba.php ");
}
spl_autoload_register(function ($trida) {
	include_once "Class/$trida.php";
});
if (isset($_GET["pridat-oblibene"])) {
	if (!isset($_SESSION["id_uzivatele"]) || !isset($_SESSION["prava"])) {
		header("Location: Uzivatel-prihlaseni.php ");
	}
	$db = new ProduktDB();
	$db->ulozOblibenyProduktUzivatele($_SESSION["id_uzivatele"], $_GET["pridat-oblibene"]);
}