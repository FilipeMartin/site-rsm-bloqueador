var url_atual = window.location.href;

if(url_atual == P_BASE_URL){
	document.getElementById("btn_menu_inicio").classList.add("active");

} else if(url_atual.match(/area_cliente/)){
	document.getElementById("btn_menu_login").classList.add("active");

} else if(url_atual.match(/contato/)){
	document.getElementById("btn_menu_contato").classList.add("active");
}