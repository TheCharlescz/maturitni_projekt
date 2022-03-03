<?php

class Polozka
{
    public $id;
    public $objednavka_id;
    public $pocet_kusu;
    public $velikost;
		public $produkt_id;
		public $cena;
		public $nazev;
		public $sleva;

    public function nastavHodnoty($produkt_id, $objednavka_id, $pocet_kusu, $velikost, $id = null)
    {
        $this->id = $id;
        $this->produkt_id = $produkt_id;
        $this->objednavka_id = $objednavka_id;
        $this->pocet_kusu = $pocet_kusu;
        $this->velikost = $velikost;
    }

    public function vypisProduktuvObjednavce()
    {
        $sleva = $this->cena / 100 * $this->sleva;
        $zlevnena_cena = $this->cena - $sleva;
        echo "<section id='kosik_produkt'>
		<div id='img'>
			";
        $obrazky = scandir("img_produkt/$this->id/");
        foreach ($obrazky as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($file == "$this->id.1.$ext") {
                echo "<a href='Produkt.php?id=$this->produkt_id' class='noMargin'><img src='img_produkt/$this->produkt_id/$file'></a>";
            }
        }
        echo "
		</div>
		<div id='kosik_info'>
			<div id='flexit'>
				<h2>$this->nazev</h2>"
				. (!empty($this->sleva) ? "<span id='zlevnena_cena'> $zlevnena_cena Kč </span>" : " $this->cena Kč") . "
				<h3>Počet kusů: $this->pocet_kusu</h3>
				<h3>Velikost: $this->velikost</h3>
			</div>
		</div>
	</section>";
    }
	public function vypisLegendyKosiku($pocet_kusu = 1)
	{
		$sleva = $this->cena  / 100 * $this->sleva;
		$zlevnena_cena = ($this->cena - $sleva) * $pocet_kusu;
		$cena = $this->cena * $pocet_kusu;
		echo "
		<span class='flex'>
					<h3> $pocet_kusu x $this->nazev</h3>
				<span class='flex'>
					" . (!empty($this->sleva) ? "<h3 id='puvodni_cena'> $cena Kč </h3>" : "") . "
				" . (!empty($this->sleva) ? "<h3 id='zlevnena_cena'> $zlevnena_cena Kč </h3>" : " <h3>$this->cena Kč</h3>") . "</p>
				</span>
				</span>";
	}
	}