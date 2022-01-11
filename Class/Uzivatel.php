<?php
class Uzivatel
{
    public $id;
    public $jmeno;
    public $prijmeni;
    public $login;
    public $heslo;
    public $telkontakt;
    public $email;
    public $mesto;
    public $ulice;
    public $cislo_popisne;
    public $PSC;
    public $prava;

    const PRAVA = array(
        -1 => "Bez oprávnění(BAN)" and "Nepřihlášený", 0 => "Nepřiděleno", 1 => "Zaměstnanec", 2 => "Prodejce", 3 => "Admin"
    );
    public function nastavRegistraci($email, $heslo, $prava = 0, $id = NULL)
    {

        $redexp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
        if (preg_match($redexp, $heslo)) {
            $this->heslo = password_hash($heslo, PASSWORD_DEFAULT);
        } else {
     echo " <h2 class='chyba'>Slabé heslo</h2>
            <p class='chyba'>Zadejte heslo tak aby obsahovalo 8 písmem a na začatku vrlké písmeno.<p>";
            return false;
        }
        $this->prava = $prava;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            return false;
        }
        if (is_null($id)) {
            $this->id = $id;
        } else {
            return false;
        }
        return true;
    }

    public function nastavHodnoty($jmeno, $prijmeni, $email, $login, $heslo, $ulice, $mesto, $telkontakt, $cislo_popisne, $PSC, $prava = 1, $id = NULL)
    {

        $redexp = "/^[A-Za-z0-9ĚŠČŘŽÝÁÍÉŇŤěščřžýáíéťň]+$/";
        if (preg_match($redexp, $jmeno)) {
            $this->jmeno = $jmeno;
        } else {
            echo " <h2 class='chyba'>Špatně zadané jméno</h2>
            <p class='chyba'>Podívejte se jestli neobsahuje mezery nebo nepovolené znaky<p>";
            return false;
        }
        $redexp = "/^[A-Za-z0-9ĚŠČŘŽÝÁÍÉŇŤěščřžýáíéťň]+$/";
        if (preg_match($redexp, $prijmeni)) {
            $this->prijmeni = $prijmeni;
        } else {
            echo " <h2 class='chyba'>Špatně zadané příjmené</h2>
            <p class='chyba'>Podívejte se jestli neobsahuje mezery nebo nepovolené znaky<p>";
            return false;
        }
        $redexp = "/^[A-Za-z0-9ĚŠČŘŽÝÁÍÉŇŤěščřžýáíéťň]+$/";
        if (preg_match($redexp, $login)) {
            $this->login = $login;
        } else {
            echo " <h2 class='chyba'>Špatně zadaný login</h2>
            <p class='chyba'>Podívejte se jestli neobsahuje mezery nebo nepovolené znaky<p>";
            return false;
        }
        $redexp = "/[A-Za-z0-9ĚŠČŘŽÝÁÍÉŇŤěščřžýáíéťň]+$/";
        if (preg_match($redexp, $mesto)) {
            $this->mesto = $mesto;
        } else {
            echo " <h2 class='chyba'>Špatně zadané město</h2>
            <p class='chyba'>Podívejte se jestli neobsahuje nepovolené znaky<p>";
            return false;
        }
        $redexp = "/^[A-Za-z0-9ĚŠČŘŽÝÁÍÉŇŤěščřžýáíéťň]+$/";
        if (preg_match($redexp, $ulice)) {
            $this->ulice = $ulice;
        } else {
            echo " <h2 class='chyba'>Špatně zadaná ulice</h2>
            <p class='chyba'>Podívejte se jestli neobsahuje mezery nebo nepovolené znaky<p>";
            return false;
        }
        //$redexp = "/+?([0-9]{2})-?([0-9]{3})-?([0-9]{6,7})/";
        //if (preg_match($redexp, $telkontakt)) {
        //    $this->telkontakt = $telkontakt;
        //} else {
        //    return false;
        //}

        $this->telkontakt = $telkontakt;

        $redexp = "/^[0-9]+$/";
        if (preg_match($redexp, $cislo_popisne)) {
            $this->cislo_popisne = $cislo_popisne;
        } else {
            echo " <h2 class='chyba'>Špatně zadané číslo popisné</h2>
            <p class='chyba'>Podívejte se jestli neobsahuje mezery nebo nepovolené znaky<p>";
            return false;
        }
        $redexp = "/[0-9]+$/";
        if (preg_match($redexp, $PSC)) {
            $this->PSC = $PSC;
        } else {
            echo " <h2 class='chyba'>Špatně zadaná PSČ</h2>
            <p class='chyba'>Podívejte se jestli neobsahuje nepovolené znaky<p>";
            return false;
        }
        $redexp = "/^[A-Za-z0-9\-\_\.]{8,}$/";
        if (preg_match($redexp, $heslo)) {
            $this->heslo = password_hash($heslo, PASSWORD_DEFAULT);
        } else {
            echo " <h2 class='chyba'>Slabé heslo</h2>
            <p class='chyba'>Zadejte heslo tak aby obsahovalo 8 písmem a na začatku vrlké písmeno.<p>";
            return false;
        }
        $redexp = "/^[-1]|[0-3]$/";
        if (preg_match($redexp, $prava)) {
            $this->prava = $prava;
        } else {
            return false;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            return false;
        }
        $this->id = $id;
        return true;
    }
    public function Pravakategorie()
    {
        switch ($this->prava) {
            case -1:
                return "Bez oprávnění(BAN)";
                break;
            case  0:
                return "Nezaregistrovaný uživatel";
                break;
            case  1;
                return "Uzivatel";
                break;
            case  2;
                return "Správce administrace produktů";
                break;
            case  3;
                return "Admin";
                break;
        }
    }
    public function vypisUzivatele()
    {
        echo "<div class='karta'>
        <h1> Profil uživatele: " . $this->jmeno . " " . $this->prijmeni . "</h1>
        <p> Zde se můžeš podívat na svoje soukromé informace a pořipadě je změnit</p>
        <div id='infoKarta'>
        <p> E-mail: " . $this->email . "</p>
        <p> Telefoní číslo: " . $this->telkontakt . "</p>
        <p> Bydliště: " . $this->ulice . " " . $this->cislo_popisne . "</p>
        <p> Město: " . $this->mesto . "</p>
        <p> PSC: " . $this->PSC . "</p>
        </div>
        <div id='navKarta'>
    <a href='Uzivatel-editace.php?id=$this->id'>Editovat</a>
    </div>
    </div>";
    }
    public function vypisUzivateleVlastniProfil()
    {
        echo "<div class='karta'>
    <h1> Profil uživatele: " . $this->jmeno . " " . $this->prijmeni . "</h1>
    <p> Zde se můžeš podívat na svoje soukromé informace a pořipadě je změnit</p>
    <div id='infoKarta'>
    <p> E-mail: " . $this->email . "</p>
    <p> Telefoní číslo: " . $this->telkontakt . "</p>
    <p> Bydliště: " . $this->ulice . " " . $this->cislo_popisne . "</p>
    <p> Město: " . $this->mesto . "</p>
    <p> PSC: " . $this->PSC . "</p>
    </div>
    <div id='navKarta'>
    <a  class='input' href='Uzivatel-editace.php?id=$this->id'>Editovat</a>
    <button onclick='openModalSmaz($this->id)' id='myBtn'>Smazat profil</button>
    </div>
    
    <div id='$this->id smaz' class='modal'>
    <div class='modal-content'>
        <span onclick='closeModalSmaz($this->id)' class='close'>&times;</span>
        <h2> Opravdu chcete smazat svůj účet: " . $this->jmeno . " " . $this->prijmeni . "?</h2>
        <p>Nebudete mít už nadále přístup ke svému košíku a oblíbeným produktům.</p>
        <a class='input' href='Uzivatel-administrace.php?id=$this->id'>Ano chci smazat tento profil</a>
        <button onclick='closeModalSmaz($this->id)' id='myBtn'>Nechci smazat tento profil</button>
    </div>
    </div>";
    }
    public function vypisUzivateleAdministrace()
    {
        echo "<div class='karta'>
    <h3>" . $this->jmeno . " " . $this->prijmeni . "</h3>
    <p>" . $this->prava . " = " . $this->Pravakategorie() . "</p>
    
    <div id='navKarta'>
    <button onclick='openModalInfo($this->id)' id='myBtn'>Info profilu</button>
    <a  class='input'href='Uzivatel-editace.php?id=$this->id'>Editovat profil</a>
    <button onclick='openModalSmaz($this->id)' id='myBtn'>Smazat profil</button>
    </div> </div>
  
    <div id='$this->id' class='modal'>

    <div class='modal-content'>
        <span onclick='closeModalInfo($this->id)' class='close'>&times;</span>
        <h1> Profil uživatele: " . $this->jmeno . " " . $this->prijmeni . "</h1>
        <p> Zde se můžeš podívat na soukromé informace</p>
        <div id='infoKarta'>
    <p> E-mail: " . $this->email . "</p>
    <p> Telefoní číslo: " . $this->telkontakt . "</p>
    <p> Bydliště: " . $this->ulice . " " . $this->cislo_popisne . "</p>
    <p> Město: " . $this->mesto . "</p>
    <p> PSC: " . $this->PSC . "</p>
    </div>
    </div>
    </div>

    <div id='$this->id smaz' class='modal'>
    <div class='modal-content'>
        <span onclick='closeModalSmaz($this->id)' class='close'>&times;</span>
        <h2> Opravdu chcete smazat účet: " . $this->Pravakategorie()  . " " . $this->jmeno . " " . $this->prijmeni . "</h2>
        <a class='input' href='Uzivatel-administrace.php?id=$this->id'>Ano chci smazat tento profil</a>
        <button onclick='closeModalSmaz($this->id)' id='myBtn'>Nechci smazat tento profil</button>
    </div>
    </div>
    ";
    }
    public function vypisUzivateleAdministraceBezSmazani()
    {
        echo "<div class='karta'>
        <h3>" . $this->jmeno . " " . $this->prijmeni . "</h3>
        <p>" . $this->prava . " = " . $this->Pravakategorie() . "</p>
        
        <div id='navKarta'>
        <button onclick='openModalInfo($this->id)' id='myBtn'>Info profilu</button>
        <a  class='input'href='Uzivatel-editace.php?id=$this->id'>Editovat profil</a>
        </div> </div>
      
        <div id='$this->id' class='modal'>
    
        <div class='modal-content'>
            <span onclick='closeModalInfo($this->id)' class='close'>&times;</span>
            <h1> Profil uživatele: " . $this->jmeno . " " . $this->prijmeni . "</h1>
        
            <p> Zde se můžeš podívat na soukromé informace</p>
            <div id='infoKarta'>
        <p> E-mail: " . $this->email . "</p>
        <p> Telefoní číslo: " . $this->telkontakt . "</p>
        <p> Bydliště: " . $this->ulice . " " . $this->cislo_popisne . "</p>
        <p> Město: " . $this->mesto . "</p>
        <p> PSC: " . $this->PSC . "</p>
        </div>
        </div>
        </div>
        </div>
        ";
    }
}
