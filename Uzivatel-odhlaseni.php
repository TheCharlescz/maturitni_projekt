<?php

session_start();require("Urlzkrasnovac.php");
if (!isset($_SESSION["id_uzivatele"]) || !isset($_SESSION["prava"])) {
    header("Location: Uzivatel-prihlaseni.php ");
}

if ($_SESSION["prava"] < 2) {
    header("Location: Uzivatel-profil.php");
}

unset($_SESSION["id_uzivatele"]);
unset($_SESSION["login"]);
unset($_SESSION["prava"]);
header("Location:Uzivatel-prihlaseni.php");
