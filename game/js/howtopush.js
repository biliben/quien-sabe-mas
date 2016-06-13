function invitar(id){
	var myId = $("#myId").val();
	var myName = $("#myName").val();
	$.post('ajax/send.php', { invitado:id, petidor:myId ,nombrePetidor:myName},function(data){
		if (data==1) {
			$("#dialog-enviado").dialog({
				resizable: true,
				height:140,
				modal: true,
				show: {
					effect: "blind",
					duration: 500
				},
				hide: {
					effect: "clip",
					duration: 500
				}
			});
		}
	});
}
function subscription_member(id,info){
	$( "#online" ).append( "<div class='player' id="+id+"><div class='row'><div class='col-md-9 col-xs-9 nameplayer'>"+info.name+"</div><div class='col-md-3 col-xs-3 click' onclick='invitar(\""+id+"\")'>Invitar</div></div></div>");
}
function add_member(id,info){
	$( "#online" ).append( "<div class='player' id="+id+"><div class='row'><div class='col-md-9 col-xs-9 nameplayer'>"+info.name+"</div><div class='col-md-3 col-xs-3 click' onclick='invitar(\""+id+"\")'>Invitar</div></div></div>");
}
function remove_member(id){
	$( "#"+id ).remove();
}
function uniqid(){
	var ts=String(new Date().getTime()), i = 0, out = '';
	for(i=0;i<ts.length;i+=2) {        
		out+=Number(ts.substr(i, 2)).toString(36);    
	}
	return ('d'+out);
}
$(document).ready(function(){
	var socket = new Pusher('2ded2143163474bf5f70', {authEndpoint:'auth/presence_auth.php'});
	var Pusher_Presence = socket.subscribe('presence-quien');

	Pusher_Presence.bind('pusher:subscription_succeeded', function(members) {
		members.each(function(member) {
			//Mostrar todos los usuarios menos tu
			if (member.id!=$("#myId").val()){
				subscription_member(member.id, member.info);
			}
		});
	});
	Pusher_Presence.bind('pusher:member_added', function(member){
		console.log("Added: " + member.info.name);
		subscription_member(member.id, member.info);
	});
	Pusher_Presence.bind('pusher:member_removed', function(member){
		console.log("Removed: " + member.info.name);
		remove_member(member.id);
	});
	
	socket.bind('peticion_juego',function(data){
		var myId = $("#myId").val();
		if (data.invitado==myId) {
			//alert("Peticion de partida de "+data.nombrePetidor);
			$("#dialog-confirm").text("Peticion de partida de "+data.nombrePetidor);
			$("#dialog-confirm").dialog({
				resizable: true,
				height:140,
				modal: true,
				show: {
					effect: "blind",
					duration: 500
				},
				hide: {
					effect: "clip",
					duration: 500
				},
				buttons: {
					"Acceptar": function() {
						$.post('ajax/aceptar_partida.php', {jugador1:data.petidor,jugador2:myId});
					},
					"Rechazar": function() {
						$.post('ajax/denegar_partida.php', {petidor:data.petidor});
						$( this ).dialog("close");
					}
				}
			});
		}
	});

	socket.bind('peticion_juego_denegada',function(data){
		var myId = $("#myId").val();
		if (data.petidor==myId) {
			$("#dialog-enviado").dialog("close");
			$("#dialog-denegado").dialog({
				resizable: true,
				height:140,
				modal: true,
				show: {
					effect: "blind",
					duration: 500
				},
				hide: {
					effect: "clip",
					duration: 500
				}
			});
		}
	});

	socket.bind('peticion_juego_aceptada',function(data){
		var myId = $("#myId").val();
		if (myId==data.jugador1 || myId==data.jugador2) {
			//El jugador que invita a la partida es quien controlara las peticiones
		var jugador_cont = data.jugador1;
		var partida = data.partida;

		if (data.jugador1==myId) {
			var yo=data.jugador1;
			var rival=data.jugador2;
		}else{
			var yo=data.jugador2;
			var rival=data.jugador1;
		}
		var url = 'create_game.php';
		var form = $('<form action="' + url + '" method="post">' +
			'<input type="text" name="jugador_cont" value="' + jugador_cont + '" />' +
			'<input type="text" name="yo" value="' + yo + '" />' +
			'<input type="text" name="rival" value="' + rival + '" />' +
			'<input type="text" name="partida" value="' + partida + '" />' +
			'</form>');
		$('body').append(form);
		form.submit();
		};

	});
	
});