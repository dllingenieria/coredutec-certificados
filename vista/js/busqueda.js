$(function() {
	var table;
	document.getElementById("txtNRegistro").focus(); 
	//----- Carga todas las listas desplegables -----//
	cargarListas('cmbTipoDocumento','SPCARGARTIPOIDENTIFICACION');

	//----- Establece los valores por defecto de las listas desplegables -----//
	cargarValorSelected('#cmbTipoDocumento','3',1000);

	$("input[name=radBusqueda]").click(function(){
		if($('input:radio[name=radBusqueda]:checked').val() == 'registro'){
			$("#numeroRegistro").show();
			$("#numeroDocumento").hide();
			if(typeof table !== "undefined"){
	            table.destroy(); 
	            $('#tablaCertificados').empty();
	        }
	        $("#txtNRegistro").val('');
	        document.getElementById("txtNRegistro").focus(); 
		}else{
			$("#numeroRegistro").hide();
			$("#numeroDocumento").show();
			if(typeof table !== "undefined"){
	            table.destroy(); 
	            $('#tablaCertificados').empty();
	        }
	        $("#txtNDocumento").val('');
			document.getElementById("txtNDocumento").focus();
		}
    });

	//----- Realizar la Busqueda por Numero de Certificado-----//
	$("#btnConsultar1").click(function(){
		if($("#txtNRegistro").val() == ''){
			mostrarPopUpError("Por favor ingrese la información solicitada");
		}else{
			consultarCertificadosPorRegistro();
		}
	});

	//----- Realizar la Busqueda por Numero de Documento-----//
	$("#btnConsultar2").click(function(){ 
		if($("#cmbTipoDocumento option:selected").val() == 0){
			mostrarPopUpError("Por favor seleccione un Tipo de Documento");
		}else{
			if($("#txtNDocumento").val() == ''){
				mostrarPopUpError("Por favor escriba un Número de Documento");
			}else{
				consultarCertificadosPorDocumento();
			}
		}
	});

	//----- Valida que solo se ingrese en las cajas de texto los valores apropiados -----//
	$('#txtNDocumento').validCampoFranz('0123456789');
	$('#txtNRegistro').validCampoFranz('0123456789SECMPCAB-');

	//----- Consulta en la base de datos los certificados disponibles por # de registro -----//
	function consultarCertificadosPorRegistro(){
		/*mensaje de procesando*/
		var mensaje="Procesando la información<br>Espere por favor";
		jsShowWindowLoad(mensaje);
		$.post("../../controlador/fachada.php", {
			clase: 'clsCertificados',
			oper: 'consultarCertificadosPorRegistro',
			pCodigoCertificado: $("#txtNRegistro").val()
		}, function(data) {
			if (data !== 0) {
				if(data !== null){
					cargarInformacionEnTabla(data);
					jsRemoveWindowLoad();
				}else{
					jsRemoveWindowLoad();
					mostrarPopUpError("No existen certificados con los datos suministrados");
					document.getElementById("txtNRegistro").focus();
				}             
			}else {
				jsRemoveWindowLoad();
				mostrarPopUpError("No existen certificados con los datos suministrados");
				document.getElementById("txtNRegistro").focus();
			}
		}, "json");
	};

	//----- Consulta en la base de datos los certificados disponibles por # de documento -----//
	function consultarCertificadosPorDocumento(){
		/*mensaje de procesando*/
		var mensaje="Procesando la información<br>Espere por favor";
		jsShowWindowLoad(mensaje);
		$.post("../../controlador/fachada.php", {
			clase: 'clsCertificados',
			oper: 'consultarCertificadosPorDocumento',
			pTipoDocumento: $("#cmbTipoDocumento option:selected").val(),
			pDocumento: $("#txtNDocumento").val()
		}, function(data) {
			if (data !== 0) {
				if(data !== null){
					cargarInformacionEnTabla(data);
					jsRemoveWindowLoad();
				}else{
					jsRemoveWindowLoad();
					document.getElementById("txtNDocumento").focus();
					mostrarPopUpError("No existen certificados con los datos suministrados");
				}             
			}else {
				jsRemoveWindowLoad();
				document.getElementById("txtNDocumento").focus();
				mostrarPopUpError("No existen certificados con los datos suministrados");
			}
		}, "json");
	};

	//----- Crea la tabla y carga la información -----//
	function cargarInformacionEnTabla(data){
		//se destruye el datatable al inicio
		if(typeof table !== "undefined"){
            table.destroy(); 
            $('#tablaCertificados').empty();
        }
		table = $('#tablaCertificados').DataTable({
			"data": data,
			columns: [
			{ title: "Id" },
			{ title: "Código" },
			{ title: "Programa" },
			{ title: "Curso" },
			{ title: "Fecha" },
			{ title: "Descarga", data: null, className: "center", defaultContent: '<a id="descargar-link" class="descargar-link" href="#" title="Edit">Descargar</a>'}
			],
			"paging":   false,
			"info":     false,
			"order": [[ 3, "desc" ]],
			"scrollY": "300px",
			"scrollX": true,
			"bDestroy": true,
			"scrollCollapse": true,
			"columnDefs": [
			{"targets": [ 0 ],"visible": false,"searchable": false}
			],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
                "sProcessing":     "Procesando...",
				"sSearch": "Filtrar:",
				"zeroRecords": "Ningún resultado encontrado",
				"infoEmpty": "No hay registros disponibles",
				"Search:": "Filtrar"
			}
		});
		$('#tablaCertificados tbody').on('click', 'tr', function () {
			if ( $(this).hasClass('selected')) {
				$(this).removeClass('selected');
				seleccionado = false;
			}else{
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				seleccionado = true;
			}
			if(typeof(Storage) !== "undefined") {
				sessionStorage.IdCertificado = table.row(this).data()[0];				
			} else {
				mostrarPopUpError("Por favor actualice su navegador o utilice otro: SessionStorage");
			}
		} );
	}
	
	//----- Consulta los datos para el certificado y lo muestra en pantalla -----//
	$(document).on('click', '#descargar-link', function() {	
		var mensaje="Procesando la información<br>Espere por favor";
		jsShowWindowLoad(mensaje);
	   	$.post("../../controlador/fachada.php", {
			clase: 'clsCertificados',
			oper: 'consultarCertificadoPorId',
			pIdCertificado: sessionStorage.IdCertificado
			}, function(data) {
			if (data == 0){
				jsRemoveWindowLoad();
				mostrarPopUpError("Hubo un problema para generar el certificado");
			}else{
				jsRemoveWindowLoad();
				$("#txtCodigoCertificado").val(data[0].CodigoCertificado);
				$("#txtFechaCertificado").val(data[0].FechaCertificado);
		        $("#txtTipoIdentificacion").val(data[0].TipoIdentificacion);
		        $("#txtNumeroIdentificacion").val(data[0].NumeroIdentificacion);
		        $("#txtLugarExpedicion").val(data[0].LugarExpedicion);
		        $("#txtEstudiante").val(data[0].Estudiante);
		        $("#txtCurso").val(data[0].Curso);
		        $("#txtModulo").val(data[0].Modulo);
		        $("#txtDuracion").val(data[0].Duracion);
		        $("#txtConvenio").val(data[0].Convenio);
				$("#txtRuta").val(data[0].Ruta);
				$("#txtNombreSecretaria").val(data[0].NombreSecretaria);
				pRutaFirma = data[0].RutaFirma;
                $("#txtRutaFirma").val('../vista/images/firmas/'+pRutaFirma.substr(20));
				$("#frmCertificadoModulo").submit();
			}		
		}, "json");
	});

	//----- Consulta en la base de datos los valores de las listas -----//
	function cargarListas(objeto,procedimiento) {
	    $.post("../../controlador/fachada.php", {
	        clase: 'clsUtilidades',
	        oper: 'cargarListas',
	        objeto: objeto,
	        procedimiento: procedimiento
	    }, function(data) {
	        if (data !== 0) {
	            formarOptionValueLista(data,objeto);
	        }
	        else {
	            alert('error');
	        }
	    }, "json");
	} 

	//----- Llena las listas -----//
	function formarOptionValueLista(data,objeto) {
	    $('#'+objeto).find('option').remove();
	    SetParametroPorDefecto("#"+objeto, '0', 'Seleccione...');
	    for (i = 0; i < data.length; i++) {
	        $('#'+objeto).append($('<option>', {
	            value: data[i].Id,
	            text: data[i].Nombre
	        }));
	    }
	} 

	//----- Establece los valores por defecto de las listas -----//
	function cargarValorSelected(objeto,value,tiempo){
        setTimeout(function() {
            $(objeto+' option[value="'+value+'"]').attr('selected','selected');    
        }, tiempo);       
    }

    //----- Establece los valores por defecto de las listas a Seleccione...-----//
    function SetParametroPorDefecto(atributo, valor, texto) {
	    $(atributo).append($('<option>', {
	        value: valor,
	        text: texto
	    }));
	}

    //----- Muestra el PopUp -----//
    function mostrarPopUpError(err_men) {
	    $("#textoError").html(err_men);
	    $('#element_to_pop_upMen').bPopup({
	        speed: 450,
	        transition: 'slideDown'
	    });
	}

	//----- Valida el correo electrónico -----//
	function validar_email(email){
	    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	    return regex.test(email) ? true : false;
	}

	//----- Quita la Cortina -----//
	function jsRemoveWindowLoad() {
	    // eliminamos el div que bloquea pantalla
	    $("#WindowLoad").remove();
	 
	}
	
	//----- Configuracion general de la cortina -----// 
	function jsShowWindowLoad(mensaje) {
	    //eliminamos si existe un div ya bloqueando
	    jsRemoveWindowLoad();
	 
	    //si no enviamos mensaje se pondra este por defecto
	    if (mensaje === undefined) mensaje = "Procesando la información<br>Espere por favor";
	 
	    //centrar imagen gif
	    height = 20;//El div del titulo, para que se vea mas arriba (H)
	    var ancho = 0;
	    var alto = 0;
	 
	    //obtenemos el ancho y alto de la ventana de nuestro navegador, compatible con todos los navegadores
	    if (window.innerWidth == undefined) ancho = window.screen.width;
	    else ancho = window.innerWidth;
	    if (window.innerHeight == undefined) alto = window.screen.height;
	    else alto = window.innerHeight;
	 
	    //operación necesaria para centrar el div que muestra el mensaje
	    var heightdivsito = alto/2 - parseInt(height)/2;//Se utiliza en el margen superior, para centrar
	 
	   //imagen que aparece mientras nuestro div es mostrado y da apariencia de cargando
	    imgCentro = "<div style='text-align:center;height:" + alto + "px;'><div  style='color:#000;margin-top:" + heightdivsito + "px; font-size:20px;font-weight:bold'>" + mensaje + "</div><img src='../images/loading.gif' width='107' height='106'></div>";
	 
	        //creamos el div que bloquea grande------------------------------------------
	        div = document.createElement("div");
	        div.id = "WindowLoad"
	        div.style.width = ancho + "px";
	        div.style.height = alto + "px";
	        $("body").append(div);
	 
	        //creamos un input text para que el foco se plasme en este y el usuario no pueda escribir en nada de atras
	        input = document.createElement("input");
	        input.id = "focusInput";
	        input.type = "text"
	 
	        //asignamos el div que bloquea
	        $("#WindowLoad").append(input);
	 
	        //asignamos el foco y ocultamos el input text
	        $("#focusInput").focus();
	        $("#focusInput").hide();
	 
	        //centramos el div del texto
	        $("#WindowLoad").html(imgCentro);
	 
	}

});