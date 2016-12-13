var datos={};

function soloNumeros(valor){
	var num="0123456789";
	var cont=0,cont_p=0;
	for(i=0;i<valor.length;i++){
		if(num.indexOf(valor.charAt(i),0)==-1){
			if(valor.charAt(i)=='.'){
				cont_p++;
			}
			cont++;
		}
	}
	if(cont_p==1){
		cont--;
	}
	return cont;
}

function clean(){
	$("#d").val("");
	$("#t_anio").val("");
	$("#t").val("");
	$("#c").val("");
	$("#i").val("");
	$("#a").val("");
	$("#qr").val("");
	$("#qp").val("");
	$("#qf").val("");
	$("#qs").val("");
	$("#result").empty();
	
}

function verificar(){
	var flag=0;
	var demanda = document.getElementById("d").value;
	
	var t_anio = document.getElementById("t_anio").value;
	
	var lead = document.getElementById("t").value;
	
	var coste = document.getElementById("c").value;
	
	var interes = document.getElementById("i").value;
	
	var costo_pedido = document.getElementById("a").value;
	
	var cant_solic = document.getElementById("qr").value;
	
	var pendientes = document.getElementById("qp").value;
	
	var q_final = document.getElementById("qf").value;
	
	var segurito = document.getElementById("qs").value;
	
	if((soloNumeros(demanda)!=0)||(demanda<0)){
		alert('La demanda ingresada no esta en el formato correspondiente');
		flag++;
	}
	if((soloNumeros(t_anio)!=0)||(t_anio<0)){
		alert('Las unidades de tiempo trabajado ingresada no esta en el formato correspondiente');
		flag++;
	}
	if((soloNumeros(lead)!=0)||(lead<0)){
		alert('El periodo que demora el proveedor en entregar el pedido ingresado no esta en el formato correspondiente');
		flag++;
	}
	if((soloNumeros(coste)!=0)||(coste<0)){
		alert('El costo unitario ingresado no esta en el formato correspondiente');
		flag++;
	}
	if((soloNumeros(interes)!=0)||(interes<0)){
		alert('El interes ingresado no esta en el formato correspondiente');
		flag++;
	}
	if((soloNumeros(costo_pedido)!=0)||(costo_pedido<0)){
		alert('El costo de realizar un pedido ingresado no esta en el formato correspondiente');
		flag++;
	}
	if((soloNumeros(cant_solic)!=0)||(cant_solic<0)){
		alert('La camtidad de solicitudes no atendidas ingresada no esta en el formato correspondiente');
		flag++;
	}
	if((soloNumeros(pendientes)!=0)||(pendientes<0)){
		alert('La cantidad de elementos pendientes ingresada no esta en el formato correspondiente');
		flag++;
	}
	if((soloNumeros(q_final)!=0)||(q_final<0)){
		alert('La cantidad de saldo fina ingresada no esta en el formato correspondiente');
		flag++;
	}
	if((soloNumeros(segurito)!=0)||(segurito<0)){
		alert('La cantidad de stock de seguridad ingresada no esta en el formato correspondiente');
		flag++;
	}

	if(flag==0){
		calcular(demanda,t_anio,lead,coste,interes,costo_pedido,cant_solic,pendientes,q_final,segurito);
	}
}

function calcular(d,t_anio,t,c,i,a,qr,qp,qf,qs){
	
	if(i==0){
		i=1;
	}
	var q_aste=Math.sqrt((2*d*a)/(c*i));
	var n_aste=Math.sqrt((d*c*i)/(a*2));
	var ct=(d*c)+((d/q_aste)*a)+((q_aste/2)*c*i);
	var d_chica=(d/t_anio)
	var pp=parseInt(d_chica*t)+qs;
	var tr_aste= parseInt(q_aste*t_anio)/d;
	var q= parseInt(d_chica*parseInt(tr_aste+t))-qf-qp+qr+qs;
	var qmax=q_aste+qs;
	
	
	datos['d']=d;
	datos['c']=c;
	datos['i']=i;
	datos['a']=a;
	
	$("#result").append('<h4>EOQ</h4><br><label>Q*:  '+q_aste+' [unidades]</label><br><label>N*:  '+n_aste+'[pedidos/año]</label><br><label>CT:  '+ct+' [unidades monetarias]</label><br>');
	$("#result").append('<h4>Punto de pedido</h4><br><label>PP: '+pp+' [unidades de tiempo a trabajar]</label><br><label>Q*max:  '+qmax+' [unidades]</label><br><label>Q*min:  '+qs+' [unidades]</label><br>');
	$("#result").append('<h4>Periodo de revisión</h4><br><label>t*r:  '+tr_aste+' [unidades de tiempo trabajado]</label><br><label>Q:  '+q+' [unidades]</label>');
	$("#desct").prop('disabled',false);
}

function agregar(){
	$("#mini").append('<br><input type="text" name="minimo">');
	$("#maxi").append('<br><input type="text" name="maximo">');
	$("#cuan").append('<br><input type="text" name="costito">');
}
