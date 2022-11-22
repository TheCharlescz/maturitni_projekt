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
	<title>Infiltrated - Přidat zaměstnance</title>
</head>

<body>
	<header id="Myheader">
		<div>
			<h2>Přidat zaměstnance</h2>
		</div>
		<div style="text-align:center;">
			<?php
			if (isset($_POST["ulozit"])) {
				spl_autoload_register(function ($trida) {
					include_once "Class/$trida.php";
				});

				if ($_POST["heslo"] != $_POST["heslo-opakovani"]) {
					echo "<h2 class='chyba'> Hesla se neshoduji</h2>";
				} else {
					$uzivatel = new Uzivatel();
					if ($uzivatel->nastavHodnoty($_POST["jmeno"], $_POST["prijmeni"], $_POST["email"], $_POST["login"], $_POST["heslo"], $_POST["ulice"], $_POST["mesto"], $_POST["telkontakt"], $_POST["cislo_popisne"], $_POST["PSC"], $_POST["prava"])) {
						if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
							echo "<p class='chyba'> Špatně zadaná e-mail</p>";;
						}
						$db = new UzivatelDB();
						$id = $db->pridatUzivatele($uzivatel);
						if ($id > 0) {
							echo  "<h2 class='spravne'>Registrace nového uživatele byla provedena</h2>\n";
						} else {
							echo "<h2 class='chyba'>Registrace nebyla provedena</h2>\n";
						}
					}
				}
			}
			?>
			<a class='input' href='Uzivatel-administrace.php'>Zpět na administraci uživatelů</a>
		</div>
	</header>
	<main>
		<div class="blok">
			<form method="post">
				<div class="flex">
					<label> Osobní údaje
						<div>
							<input type="text" name="jmeno" placeholder="Jméno" required> <br>
							<input type="text" name="prijmeni" placeholder="Příjmení" required><br>
							<input type="email" name="email" placeholder="E-mail" required><br>
							<input type="tel" name="telkontakt" placeholder="Telefonní číslo" required><br>
							<input type="text" name="ulice" placeholder="Ulice" required><br>
							<input type="number" name="cislo_popisne" placeholder="Císlo popisné" required><br>
							<input type="text" name="mesto" placeholder="Město" required><br>
							<input type="number" name="PSC" placeholder="PSC" required><br>
						</div>
					</label>
					<label> Přihlašovací údaje
						<div>
							<input type="text" name="login" placeholder="Přihlašovací login" required> <br>
							<select class="select" name="prava" required>
								<option value="">Zvolte práva zaměstnance</option>
								<option value="-1">BAN(Bez Oprávnění)</option>
								<option value="0">Nepřihlášen</option>
								<option value="1">Uživatel</option>
								<option value="2">Správce administrace produktů</option>
								<option value="3">Admin</option>
							</select><br>
							<input type="password" name="heslo" placeholder="Heslo" required><br>
							<input type="password" name="heslo-opakovani" placeholder="Heslo znovu" required><br>
						</div>
				</div>
				</label>
				<input id="ulozit" type="submit" name="ulozit" value="Přidat zaměstnance">
			</form>
		</div>
	</main>
</body>

</html>