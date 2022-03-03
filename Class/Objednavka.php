<?php

class Objednavka {
    public $id;
		public $celkova_cena;
		public $zaplaceno;
		public $zpracovano;
		public $odeslano;
		public $vytvoreno_v;
		public $uzivatel_id;

public function nastavHodnoty($celkova_cena, $zaplaceno, $zpracovano, $odeslano, $vytvoreno_v, $uzivatel_id, $id = NULL ) {
	$this->id = $id;
	$this->celkova_cena = $celkova_cena;
	$this->zaplaceno = $zaplaceno;
	$this->zpracovano = $zpracovano;
	$this->odeslano = $odeslano;
	$this->vytvoreno_v = $vytvoreno_v;
	$this->uzivatel_id = $uzivatel_id;
 }
 
 }