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
	<title>Infiltrated - Přidat zaměstnance</title>
</head>

<body>
	<header id="Myheader">
		<div>
			<?php
			spl_autoload_register(function ($trida) {
				include_once "Class/$trida.php";
			});
			$db = new UzivatelDB();
			$uzivatel = new Uzivatel();
			$uzivatel = $db->nactiUzivatel($_GET["id"]);

			?>
			<h2>Editace profilu zaměstnance: <?php echo "$uzivatel->jmeno " . " $uzivatel->prijmeni" ?></h2>
		</div>
		<div>
			<?php
			spl_autoload_register(function ($trida) {
				include_once "Class/$trida.php";
			});

			if (isset($_POST["ulozit"])) {
				if ($_POST["heslo"] != $_POST["heslo-opakovani"]) {
					echo "<p class='chyba'> Hesla se neshoduji</p>";
				} else {
					$uzivatel = new Uzivatel();
					$uzivatel->nastavHodnoty(
						$_POST["jmeno"],
						$_POST["prijmeni"],
						$_POST["email"],
						$_POST["login"],
						$_POST["heslo"],
						$_POST["ulice"],
						$_POST["mesto"],
						$_POST["telkontakt"],
						$_POST["cislo_popisne"],
						$_POST["PSC"],
						$_POST["prava"],
						$_GET["id"]
					);
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
				$db = new UzivatelDB();
				$uzivatel = new Uzivatel();
				$uzivatel = $db->nactiUzivatel($_GET["id"]);
			}
			?>
			<a class='input' href='Uzivatel-administrace.php'>Zpět na Administraci</a>
		</div>
	</header>

	<main>
		<div class="blok">
			<form method="post">
				<div id="flex">
					<label>
						<h2>Osobní údaje</h2>
						<div class="reg">
							<input type="text" name="jmeno" placeholder="Jméno" value="<?php echo "$uzivatel->jmeno" ?>" required>
							<br>
							<input type="text" name="prijmeni" placeholder="Příjmení" echo" value="<?php echo "$uzivatel->prijmeni" ?>" required><br>
							<input type="email" name="email" placeholder="E-mail" echo" value="<?php echo "$uzivatel->email" ?>" required><br>
							<input type="tel" name="telkontakt" placeholder="Telefonní číslo" value="<?php echo "$uzivatel->telkontakt" ?>" required><br>
							<input type="text" name="ulice" placeholder="Ulice" value="<?php echo "$uzivatel->ulice" ?>" required><br>
							<input type="number" name="cislo_popisne" placeholder="Císlo popisné" value="<?php echo "$uzivatel->cislo_popisne" ?>" required><br>
							<input type="text" name="mesto" placeholder="Město" value="<?php echo "$uzivatel->mesto" ?>" required><br>
							<input type="number" name="PSC" placeholder="PSC" value="<?php echo "$uzivatel->PSC" ?>" required><br>
						</div>
					</label>
					<label>
						<h2>Přihlašovací údaje</h2>
						<div class="reg">
							<input type="text" name="login" placeholder="Přihlašovací login" value="<?php echo "$uzivatel->login" ?>" required> <br>
							<select class="select" name="prava" required>
								<option value="">Zvolte práva zaměstnance</option>
								<?php
								echo "<option value='-1'" . (-1 == $uzivatel->prava ? 'selected' : '') . " >BAN(bez Opravnění)</option>";
								echo "<option value='0'" . (0 == $uzivatel->prava ? 'selected' : '') . " >Nepřihlášen</option>";
								echo "<option value='1' " . (1 == $uzivatel->prava ? 'selected' : '') . ">Uzivatel</option>";
								echo "<option value='2' " . (2 == $uzivatel->prava ? 'selected' : '') . ">Správce administrace produktů</option>";
								echo "<option value='3' " . (3 == $uzivatel->prava ? 'selected' : '') . ">Admin</option>";
								?>
							</select><br>
							<input type="password" name="heslo" placeholder="Heslo" required><br>
							<input type="password" name="heslo-opakovani" placeholder="Heslo znovu" required><br>
						</div>
				</div>
				</label>
				<input id="ulozit" type="submit" name="ulozit" value="Editovat profil">
			</form>
		</div>
	</main>
</body>

</html>