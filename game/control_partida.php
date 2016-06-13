<?php 

class Control_partida
{
	private $partida;
	private $jugador1;
	private $jugador2;

	function __construct($partida,$jugador1,$jugador2){
		$this->partida=$partida;
		$this->jugador1=$jugador1;
		$this->jugador2=$jugador2;
	}


}
?>