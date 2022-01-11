<?php
class Soubor {
public $slozka;
public $nazev;
public $typ;
public $velikost;
public $zdroj;


const TYPY = array("png" => "image/png", "jpg" => "image/jpeg", "gif" => "image/gif", "pdf" => "application/pdf");


const MAX_VELIKOST = 1000000;


public function nastavHodnoty($slozka, $zdroj, $typ, $velikost, $nazev = NULL, $id = NULL){

    $this->slozka = $slozka;

if (substr($this->slozka,-1,1) != "/") {
    $this->slozka .= "/";
}
$this->zdroj = $zdroj;

 $this->typ = $typ;

 $this->velikost = $velikost;

if (!is_null($nazev) && !is_null($id)) {
    $this->nazev = $id."_".$this->nazevBezDiakritiky($nazev).".".array_search($this->typ,self::TYPY);
}
elseif(!is_null($id)){
$this->nazev = $id.".".array_search($this->typ,self::TYPY);
}elseif(!is_null($nazev)){$this->nazev =$this->nazevBezDiakritiky($nazev).".".array_search($this->typ,self::TYPY); } 
else {return false;}

return true;
}

public function priponaSouboru($nazev_pripona){
    if (mb_strrpos($nazev_pripona,".") == 0) {
        return false;
    }
    return mb_substr($nazev_pripona,mb_strrpos($nazev_pripona,".")+1);
}
    

public function nazevBezDiakritiky($nazev_pripona){
if (mb_strrpos($nazev_pripona,".") == 0) {
    $nazev= $nazev_pripona;
}else {$nazev = mb_substr($nazev_pripona,0,mb_strrpos($nazev_pripona,"."));}
return $this->bezDiakritiky($nazev);
}

public function bezDiakritiky($nazev) {
$coNahradit=array("á","é","í","ó","ú","ů","ý","ž","š","č","ř","ď","ť","ň","ě","Á","É","Í","Ó","Ú","Ů","Ž","Š","Č","Ř",
"Ď","Ť","Ň","É","Ý");
$cimNahradit=array("a","e","i","o","u","u","y","z","s","c","r","d","t","n","e","A","E","I","O","U","U","Z","S","C","R",
"D","T","N","E","Y");
return str_replace($coNahradit,$cimNahradit,$nazev);

}

public function zobraz() {
    if (!is_null($this->typ)) {
        if ($this->typ == "image/png" || $this->typ == "image/jpeg" || $this->typ == "image/gif") {
        echo "<img src='$this->slozka$this->nazev' alt='$this->nazev' title= '$this->nazev>\n'";
        }else {
            echo "<a href='$this->slozka$this->nazev' target='_blank' title='$this->typ'>$this->nazev</a>";
        }
    }
}


public function zjistiHodnoty($slozka,$nazev){
 
        $this->slozka = $slozka;
   
        $this->nazev = $nazev;
  
    $pripona = $this->priponaSouboru($nazev);

    if (!array_key_exists($pripona,self::TYPY)) {
        return false;
    }else {
        $this->typ = self::TYPY[$pripona];
    }
    if (file_exists($this->slozka.$nazev)) {
        $this->nazev = $nazev;
    }else{return false;}
    return true;
}

public function smazSoubor(){
if (unlink($this->slozka.$this->nazev)) {
    return $this->nazev;
}else {return false;}

}

public function ulozSoubor(){
if (move_uploaded_file($this->zdroj,$this->slozka.$this->nazev)) {
    return $this->slozka.$this->nazev;
}else {return false;}

}

public function ulozObrazek($novaVyska = 400){
switch ($this->typ) {
    case 'image/jpeg':
        $zdroj = imagecreatefromjpeg($this->zdroj);
        break;
    case 'image/png':
        $zdroj = imagecreatefrompng($this->zdroj);
        break;
    case 'image/gif':
        $zdroj = imagecreatefromgif($this->zdroj);        
        break;
    
    default:
        # code...
        break;
}
$puvodniSirka = imagesx($zdroj);
$puvodnivyska = imagesy($zdroj);
if ($novaVyska < $puvodnivyska) {
    $novaSirka = round($puvodniSirka/$puvodniSirka*$novaVyska);
}else{
    $novaVyska = $puvodnivyska; $novaSirka = $puvodniSirka;
}
$cil = imagecreatetruecolor($novaSirka,$novaVyska);
imagecopyresampled($cil, $zdroj, 0,0,0,0, $novaSirka, $novaVyska, $puvodniSirka, $puvodnivyska);

switch ($this->typ) {
    case 'image/jpeg':
        $vysledek = imagejpeg($cil,$this->slozka.$this->nazev);
        break;
        case 'image/png':
        $vysledek = imagepng($cil,$this->slozka.$this->nazev);
            break;
            case 'image/gif':
        $vysledek = imagegif($cil,$this->slozka.$this->nazev);
                break;
    
    default:
        # code...
        break;
}
imagedestroy($cil);
imagedestroy($zdroj);
unlink($this->zdroj);
if ($vysledek) {
    return $this->nazev;
}else{
    return false;
}


}

}
