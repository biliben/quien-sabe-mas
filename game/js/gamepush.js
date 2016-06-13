function cuentaAtras(num){
	if(num >= 0){
		$(".num_contador").text(num);
		num--;
		setTimeout('cuentaAtras('+num+')',1000);
	}
}
function tiempo(num,cont,porciento){
	widthdiv = $(".puntuacion").width();
	porcien = widthdiv/num;
	if(cont < num){
		porciento=porciento+porcien;
		cont++;
		$("#progressbar").width(porciento.toFixed(2));
		tiempos = setTimeout('tiempo('+num+','+cont+','+porciento.toFixed(2)+')',1000);
	}else{
		intentos=0;
		var t1 = $("#control").val();
		var t2 = $("#id_yo").val();
		var t3 = "presence-"+$("#partida").val();
		if (t1==t2) {
			setTimeout('peticionPregunta("'+t1+'","'+t2+'","'+t3+'")',3000);
		}
	}
}
function peticionPregunta(CONTROLADOR,myId,nombre_partida){
	var player1=false;
	var player2=false;
	incorrectos=0;
	$(".jugador .correct").hide();
	$(".jugador .incorrecto").hide();
	$(".enemigo .correct").hide();
	$(".enemigo .incorrecto").hide();
	if (CONTROLADOR==myId) {
		preguntas_numero--;
		if (preguntas_numero>0) {
			$.post('ajax/pedir_pregunta.php', {canal:nombre_partida});
		}else{
			$.post('ajax/fin_partida.php', {jugador1:myId, jugador2:$("#id_rival").val(),punt_jug1:player1_punt,punt_jug2:player2_punt,canal:nombre_partida});
		}
	}
}
function ocultarready(){
	$(".ready").hide("slow");
}
//Declarar Variables
var intentos;
var player1;
var player2;
var preguntas_numero=10;
var player1_punt=0;
var player2_punt=0;
var incorrectos=0;
$(document).ready(function(){
	var CONTROLADOR = $("#control").val();
	var myId = $("#id_yo").val();
	var partida = $("#partida").val();
	var nombre_partida = "presence-"+partida;
	var socket = new Pusher('2ded2143163474bf5f70', {authEndpoint:'auth/presence_auth.php'});
	var Pusher_Presence = socket.subscribe(nombre_partida);



	Pusher_Presence.bind('pusher:subscription_succeeded', function(members) {
		//Cuando los dos usuarios esten conectados
		if (Pusher_Presence.members.count==2) {
			$.post('ajax/connectados.php', {ready:"connectados",canal:nombre_partida});
		}
	});
	Pusher_Presence.bind('pusher:member_added', function(member){
	});
	Pusher_Presence.bind('pusher:member_removed', function(member){
		window.location = 'profile.php';
	});

	//Esperamos ha que se conecten los jugadores
	socket.bind('ready-evento',function(data){
		if (data.ready=="connectados") {
			$(".loading").hide("slow");
			$(".ready").show("slow");
		}
	});
	//Preparar a los jugadores
	socket.bind('jugador-ready',function(data){		
		if (data.player==myId) {
			$("#yo_ready").removeClass("no_ready");
			$("#yo_ready").addClass("si_ready");
		}else{
			$("#rival_ready").removeClass("no_ready");
			$("#rival_ready").addClass("si_ready");
		}

		if (data.player == CONTROLADOR ) {
			player1=true;
		}else{
			player2=true;
		}

		if (player1===true && player2===true) {
			cuentaAtras(3);
			setTimeout('ocultarready()',3000);
			setTimeout('peticionPregunta("'+CONTROLADOR+'","'+myId+'","'+nombre_partida+'")',3000);
		}

	});
	socket.bind('pregunta',function(data){
		intentos=1;
		var correcta = data.correcta;
		var imagen = data.imagen;
		var pregunta = data.pregunta;
		var resp1 = data.respuesta1;
		var resp2 = data.respuesta2;
		var resp3 = data.respuesta3;
		var resp4 = data.respuesta4;

		$("#correcta").val(correcta);
		$(".tablero").html("");
		$( ".tablero" ).append('<div class="col-xs-12 col-md-12 pregunta" id="preg"><span>'+pregunta+'</span></div>');

		$( ".tablero" ).append('<div class="col-xs-12 col-md-6 respuesta" id="res1"><span>'+resp1+'</span></div>');
		$( ".tablero" ).append('<div class="col-xs-12 col-md-6 respuesta" id="res2"><span>'+resp2+'</span></div>');
		$( ".tablero" ).append('<div class="col-xs-12 col-md-6 respuesta" id="res3"><span>'+resp3+'</span></div>');
		$( ".tablero" ).append('<div class="col-xs-12 col-md-6 respuesta" id="res4"><span>'+resp4+'</span></div>');

		tiempo(30,0,0);
		$(".respuesta").click(function(){
			var resp_correct = $(this).attr("id")
			var resp_cli = $(this).text();
			var res_corr = $("#correcta").val();
			if (intentos>0) {
				if (resp_cli==res_corr) {
					$(this).addClass("correcto");
					intentos--;
					$.post('ajax/respuesta_correcta.php', {jugador_correcto:myId,canal:nombre_partida,resp_correcta:resp_correct});
				}else{
					$(this).addClass("falso");
					intentos--;
					$.post('ajax/respuesta_incorrecta.php', {jugador_incorrecto:myId,canal:nombre_partida});
				}
			}
		});
	});
	socket.bind('respuestaCorrecta',function(data){
		intentos--;
		clearTimeout(tiempos);
		if (myId==CONTROLADOR) {
			if (data.jugadorCorrecto==myId) {
				player1_punt++;
				$("#my-punts").text(player1_punt);
				$(".jugador .correct").show("slow");
			}else{
				player2_punt++;
				$("#punt-enemi").text(player2_punt);
				$("#"+data.resp_correcta).addClass("correcto");
				$(".enemigo .correct").show("slow");
			}
		}else{
			if (data.jugadorCorrecto==myId) {
				player2_punt++;
				$("#my-punts").text(player2_punt);
				$(".jugador .correct").show("slow");
			}else{
				player1_punt++;
				$("#punt-enemi").text(player1_punt);
				$("#"+data.resp_correcta).addClass("correcto");
				$(".enemigo .correct").show("slow");
			}
		}
		setTimeout('peticionPregunta("'+CONTROLADOR+'","'+myId+'","'+nombre_partida+'")',3000);
	});

	socket.bind('respuestaIncorrecta',function(data){
		incorrectos++;
		if (myId==CONTROLADOR) {
			if (data.jugadorIncorrecto==myId) {

				$(".jugador .incorrecto").show("slow");
			}else{
				$(".enemigo .incorrecto").show("slow");
			}
		}else{
			if (data.jugadorIncorrecto==myId) {
				$(".jugador .incorrecto").show("slow");
			}else{
				$(".enemigo .incorrecto").show("slow");
			}
		}
		if (incorrectos>=2) {
			clearTimeout(tiempos);
			setTimeout('peticionPregunta("'+CONTROLADOR+'","'+myId+'","'+nombre_partida+'")',3000);
		}
	});

	socket.bind('finpartida',function(data){
		$("#tablero").html("");
		$(".final").show("slow");
		if (data.jugador1==myId) {
			if (data.punt_jug1==data.punt_jug2) {
				$("#ganador span").text("Igual de tontos");
				$("#ganador").addClass("gan");
			}else if (data.punt_jug1>data.punt_jug2) {
				$("#ganador span").text("Eres el mas listo");
				$("#ganador").addClass("gan");
			}else{
				$("#ganador span").text("Que berguenza!!");
				$("#ganador").addClass("per");
			}
		}else{
			if (data.punt_jug1==data.punt_jug2) {
				$("#ganador span").text("Igual de tontos");
				$("#ganador").addClass("gan");
			}else if (data.punt_jug1<data.punt_jug2) {
				$("#ganador span").text("Eres el mas listo");
				$("#ganador").addClass("gan");
			}else{
				$("#ganador span").text("Que berguenza!!");
				$("#ganador").addClass("per");
			}
		}
	});
	$(".salir").click(function(){
		window.location.replace("profile.php");
	});
	$("#yo_ready").click(function(){		
		$.post('ajax/playerReady.php', {canal:nombre_partida, id:myId});
	});
});