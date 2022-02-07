<?php
if (isset($_GET["pridat-do-kosiku"])) {
	if (empty($_COOKIE["produkt_id"])) {
		setcookie("pocet", 1, time() + (86400 * 30));
		setcookie("produkt_id[1]", $_GET["pridat-do-kosiku"], time() + (86400 * 30));
		setcookie("pocet_produktu[1]", 1, time() + (86400 * 30));
	} elseif (!in_array($_GET["pridat-do-kosiku"], $_COOKIE["produkt_id"])) {
		$pocet = $_COOKIE["pocet"];
		$pocet++;
		setcookie("pocet", $pocet, time() + (86400 * 30));
		setcookie("produkt_id[$pocet]", $_GET["pridat-do-kosiku"], time() +  (86400 * 30));
		setcookie("pocet", $pocet, time() + (86400 * 30));
		setcookie("pocet_produktu[$pocet]", 1, time() + (86400 * 30));
		if(isset($_POST["velikost"])) {
			setcookie("velikost[$pocet]", $_POST["velikost"], time() + (86400 * 30));
		}
	} elseif (in_array($_GET["pridat-do-kosiku"], $_COOKIE["produkt_id"])) {
		foreach ($_COOKIE["pocet_produktu"] as $index => $value) {
			$key = array_search($_GET["pridat-do-kosiku"], $_COOKIE["produkt_id"]);
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
		$key = array_search($_GET["pridat-do-kosiku"], $_COOKIE["produkt_id"]);
		if ($key == $index) {
			setcookie("pocet_produktu[$index]", $_POST["pocet_kusu"], time() + (86400 * 30));
			header("Refresh:0");
		}
	}
}
if (isset($_GET["odebrat-z-kosiku"])) {
	if (!empty($_COOKIE["produkt_id"])) {
		foreach ($_COOKIE["produkt_id"] as $index => $value) {
			$key = array_search($_GET["odebrat-z-kosiku"], $_COOKIE["produkt_id"]);
			if ($key == $index) {
				setcookie("produkt_id[$index]", $_GET["odebrat-z-kosiku"], time() - 1);
				setcookie("pocet_produktu[$index]", 1, time() - 1);
				setcookie("velikost[$index]", "", time() - 1);
				header("Refresh:0");
			}
		}
	}
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