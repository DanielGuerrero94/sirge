<section class="content-header">
	<h1>
		DOI 3
	</h1>
</section>
<div class="content">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="box box-info">
				<div class="box-header">
					<div class="btn-group">
						<button class="btn btn-info diccionario"><i class="fa fa-book"></i> Diccionario</button>
						<a href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</a>
						<ul class="dropdown-menu" role="menu" hidden>
							<li><a href="#" class="diccionario">Ver</a></li>
							<li><a href="api/diccionario/export">Descargar diccionario</a></li>
							<li><a href="#">Descargar ejemplo</a></li>
						</ul>
					</div>
					<button class="btn btn-success" id="subir"><i class="fa fa-upload"></i> Subir</button>
					<button class="btn btn-default pull-right" id="importacion" style="display: none">
						<i class="fa fa-refresh fa-fw"></i> Tabla
					</button>
					<div class="box-tools pull-right" style="padding-top: 6px;" id="refresh">
						<button class="btn btn-box-tool" title="Consulta la tabla cada 10 segundos"><i
								class="fa fa-refresh fa-spin fa-fw"></i></button>
					</div>
				</div>
				<div class="box-body" id="tabla-box">
					<div class="callout callout-default">
						<h4><i class="fa fa-table" aria-hidden="true"></i> Tabla de importaciones</h4>
						<p>
							Puede ver el periodo al que corresponden las prestaciones que subio, tambien entrar a la
							declaracion jurada de ese periodo y ver el historial de modificaciones.
						</p>
					</div>
					<table id="datatable" class="table">
					</table>
				</div>
				<div class="box-body" style="display: none" id="subir-box">

					<div class="callout callout-success">
						<h4><i class="icon fa fa-upload"></i> Subida de archivo</h4>

						<p>Desde esta opción usted podrá subir los archivos para la carga de prestaciones. Recuerde
							respetar la estructura de datos.</p>
						<p>Si tiene dudas consulte en el boton "Diccionario" (arriba a la izquierda)</p>
					</div>

					<div class="row">
						<form method="post" enctype="multipart/form-data" id="subida" name="form-upload">
							<div class="col col-md-3">
								<span class="btn btn-default fileinput-button">
									<i class="glyphicon glyphicon-plus"></i>
									<span>Seleccionar archivo</span>
									<input id="fileupload" type="file" name="file">
								</span>
							</div>
							<div class="col col-md-3" hidden>
								<div id="upload-progress" class="progress">
								</div>
							</div>

							@if(true)
							<div class="col col-md-3">
								<select class="form-control" id="provincia" name="id_provincia" aria-hidden="true"
									placeholder="Seleccionar Provincia">
									@foreach($provincias as $provincia)
									<option data-id="{{$provincia->id_provincia}}" value="{{$provincia->id_provincia}}">
										{{$provincia->descripcion}}</option>
									@endforeach
								</select>
							</div>
							@endif
						</form>
					</div>
				</div>
				<div class="box-body" style="display: none" id="diccionario-box">

					<div class="callout callout-info">
						<h4><i class="icon fa fa-book"></i> Diccionario de datos</h4>

						<p>
							Si tiene dudas de como generar el archivo de prestaciones para subir al SIRGe Web ingrese a
							esta
							opción.
						</p>

					</div>
					<table id="diccionario-datatable" class="table">
					</table>
				</div>
				<div class="box-body" style="display: none" id="analisis-box">
				</div>
				<div class="box-body" style="display: none" id="advertencias-box">
					<table id="advertencias-datatable" class="table">
					</table>
				</div>
				<div class="box-body" style="display: none" id="errores-box">
					<table id="errores-datatable" class="table">
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function addToken() {
		token = $('meta[name="csrf-token"]').attr('content')
		$("#subida").append('<input type="hidden" name="_token" id="token" value="' + token + '">')
	}

	function showTabla() {
		$("#tabla-box").show()
		$("#importacion").show()
		$("#refresh").hide()
		$("#subir-box").hide()
		$("#analisis-box").hide()
		$("#advertencias-box").hide()
		$("#errores-box").hide()
		$("#diccionario-box").hide()
	}


	function showSubir() {
		$("#subir-box").show()
		$("#diccionario-box").hide()
		$("#tabla-box").hide()
		$("#analisis-box").hide()
		$("#errores-box").hide()
		$("#advertencias-box").hide()
		$("#importacion").show()
		$("#refresh").hide()
	}

	function showDiccionario() {
		$("#diccionario-box").show()
		$("#subir-box").hide()
		$("#tabla-box").hide()
		$("#analisis-box").hide()
		$("#advertencias-box").hide()
		$("#errores-box").hide()
		$("#importacion").show()
		$("#refresh").hide()
		datatableDiccionario();
	}

	function getAnalisis(id) {
		$.ajax({
			url: "api/analisis/" + id,
		}).done(function (html) {
			$("#analisis-box").show()
			$("#analisis-box").html(html)
		}).fail(function (error) {
			alert("Error")
			console.log(error)
		});
	}

	function showAnalisis() {
		getAnalisis(1);
		$("#diccionario-box").hide()
		$("#subir-box").hide()
		$("#tabla-box").hide()
		$("#errores-box").hide()
		$("#advertencias-box").hide()
		$("#importacion").show()
		$("#refresh").hide()
	}

	function showAdvertencias() {
		datatableAdvertencias()
		$("#advertencias-box").show()
		$("#diccionario-box").hide()
		$("#errores-box").hide()
		$("#subir-box").hide()
		$("#tabla-box").hide()
		$("#importacion").show()
		$("#refresh").hide()
	}

	function showErrores(id) {
		//datatableErrores(id)
		resumenErrores(id)
		$("#errores-box").show()
		$("#diccionario-box").hide()
		$("#advertencias-box").hide()
		$("#subir-box").hide()
		$("#tabla-box").hide()
		$("#importacion").show()
		$("#refresh").hide()
	}

	function datatableDiccionario() {
		return $('#diccionario-datatable').DataTable({
			destroy: true,
			paging: false,
			searching: false,
			ordering: false,
			ajax: {
				url: 'api/diccionarios',
				dataSrc: "data",
			},
			columns: [
				{ data: 'orden', title: 'Orden' },
				{ data: 'campo', title: 'Campo' },
				{ data: 'tipo', title: 'Tipo' },
				{ data: 'descripcion', title: 'Descripción' },
				{ data: 'ejemplo', title: 'Ejemplo' }
			]
		});
	}

	function renderButtons() {
		html = '<div class="btn-group">'
       		 + '<button type="button" class="btn btn-default">Action</button>'
             + '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'
			 + '<span class="caret"></span>'
			 + '<i class="fa-ellipsis-v"></i>'
			 + '<span class="sr-only">Toggle Dropdown</span>'
			 + '</button>'
			 + '<ul class="dropdown-menu" role="menu">'
			 + '<li><a href="#">Action</a></li>'
			 + '<li><a href="#">Another action</a></li>'
	         + '<li><a href="#">Something else here</a></li>'
			 + '<li class="divider"></li>'
	 		 + '<li><a href="#">Separated link</a></li>'
			 + '</ul>'
			 + '</div>';
		return html;
	}

	function datatableImportaciones() {
		return $('#datatable').DataTable({
			destroy: true,
			debug: true,
			processing: false,
			responsive: true,
			columnDefs: [
	            { width: 50, targets: 0 },
	            { width: 100, targets: 2 },
	        ],
	        fixedColumns: true,
			ajax: {
				url: 'api/importaciones',
				dataSrc: 'data',
			},
			columns: [
				{ data: 'id_provincia', title: 'Provincia' },
				{ data: 'periodo', title: "Periodo" },
				{ data: 'facturadas', title: "Facturadas" },
				{ data: 'liquidadas', title: "Liquidadas" },
				{ data: 'pagadas', title: "Pagadas" },
				{   title: "Estado",
					render: function (data, type, row) {
						now = +row.insertados + +row.errores
						max = row.total
						percentage = now * 100 / max
						percentage = percentage.toFixed(2)
						return '<div class="progress"><div class="progress-bar progress-bar-aqua progress-bar-striped" role="progressbar" style="width: ' + percentage + '%" aria-valuenow="' + now + '" aria-valuemin="0" aria-valuemax="' + max + '" title="' + now + '/' + max + '">' + percentage + '%</div></div>'
					},
					orderable: false
				},
				{
					render: function (data, type, row) {
						if(row.advertencias > 0) {
							return '<button onclick="showAnalisis()" class="btn btn-primary btn-xs" title="Detalle" style="margin-top:4px"><i class="fa fa-info-circle"> Detalle</i></button>';
							}

						html = 'Importando'

						if(+row.insertados + +row.errores == row.total || +row.insertados + +row.errores == row.total - 1) {
							html = 'Validaciones'
							if(row.errores > 0) {
/*
								html += '<button onclick="showErrores(' + row.id + ')" class="btn btn-danger btn-xs" title="Errores"><i class="fa fa-exclamation-circle"> Errores </i></button>';
*/
								html += ' - Errores: ' + row.errores
							}

						}

						return html
					},
					orderable: false
				}
			]
		});
	}

	var tiposAdvertencia 

	function tipoAdvertencias() {
		$.ajax({
		  url: "api/tipo_advertencias",
		}).done(function(data) {
			tiposAdvertencia = JSON.parse(data)
		}).fail(function(error) {
			alert("Error")
			console.log(error)
		});
	}

	function resumenErrores(id) {
		$.ajax({
		  url: "api/errores_importacion/" + id,
		}).done(function(data) {
			resumen = JSON.parse(data)
			console.log(resumen);
		}).fail(function(error) {
			alert("Error")
			console.log(error)
		});
	}


	function renderAdvertencia(id) {
		return tiposAdvertencia.filter(function(a) {return a.id == id}).shift().column
	}

	function datatableAdvertencias() {
		tipoAdvertencias()

		return $('#advertencias-datatable').DataTable({
			destroy: true,
			processing: true,
			ajax: {
				url: 'api/advertencias',
				dataSrc: 'data',
			},
			columns: [
				{ data: 'id_prestacion', title: 'ID' },
				{ title: "Advertencia", render: function (data, type, row, meta) {
					return renderAdvertencia(row.id_tipo_advertencia);
				} },
				{ data: 'value', title: 'Valor Equivocado' }
				//{ data: 'ejemplo', title: 'Ejemplo' }
			]
		});
	}

	function datatableErrores() {
		return $('#errores-datatable').DataTable({
			destroy: true,
			debug: true,
			processing: false,
			responsive: true,
			columnDefs: [
	            { width: 50, targets: 0 },
	            { width: 100, targets: 2 },
	        ],
	        fixedColumns: true,
			ajax: {
				url: 'api/errores_importacion',
				dataSrc: 'data',
			},
			columns: [
				{ data: 'id_prestacion', title: 'ID' },
				{ data: 'codigo', title: "Codigo" },
				{ data: 'mensaje', title: 'Mensaje' }
			]
		});
	}

	function progress(data, type, row, meta) {
		var now = row[6]
		var max = row[7]
		var percentage = now * 100 / max
		/*
		$.ajax({
		  url: "api/importacion/" + "1" + "/progress",
		}).done(function(html) {
			$("#analisis-box").show()	
			$("#analisis-box").html(html)	
		}).fail(function(error) {
			alert("Error")
			console.log(error)
		});
		*/
		percentage = percentage.toFixed(2)
		return '<div class="progress"><div class="progress-bar progress-bar-aqua progress-bar-striped" role="progressbar" style="width: ' + percentage + '%" aria-valuenow="' + now + '" aria-valuemin="0" aria-valuemax="' + max + '" title="' + now + '/' + max + '">' + percentage + '%</div></div>'
	}

	function drawTable(dataSet) {
		$("#tabla-box #datatable_wrapper").remove();
		$("#tabla-box").append('<table id="datatable" class="table"></table>');

		return $('#datatable').DataTable({
			/*
			processing: true,
			serverSide: true,
			ajax : 'listar-lotes-table/7',
			columns: [
				{ data: 'periodo', name: 'lote' },
				{ data: 'subido' , name: 'inicio'},
			]
			*/
			data: dataSet,
			columns: [
				{ title: "Provincia" },
				{ title: "Periodo" },
				{ title: "Subida" },
				{ title: "Facturadas" },
				{ title: "Liquidadas" },
				{ title: "Pagadas" },
				{
					title: "Estado",
					render: function (data, type, row, meta) {
						return "Importando"
					}
				},
				{
					render: function (data, type, row, meta) {
						return progress(data, type, row, meta)
					},
					orderable: false,
					title: "Progreso"
				},
				{
					render: function () {
						return '<button onclick="showAnalisis()" class="btn btn-success btn-xs"> Analisis</button>'
					},
					orderable: false
				}
			]
		});

		$(".content .analisis").on("click", showAnalisis)
	}

	$(document).ready(function () {
		addToken()
		$("#importacion").on("click", showTabla)
		$("#subir").on("click", showSubir)
		$(".diccionario").on("click", showDiccionario)

		var dataSet = [
			["Buenos Aires", "2020-01", "2020-02-01 15:00", 10000, 11000, 12000, 33, 33000],
			["CABA", "2020-02", "2020-03-01 15:00", 8000, 9000, 10000, 27, 27000],
			["Jujuy", "2020-01", "2020-02-01 12:00", 5000, 6000, 7000, 18, 18000],
			["Salta", "2020-01", "2020-02-01 12:00", 5000, 6000, 7000, 12, 23123]
		]

		$(document).on({
    	    ajaxStart: function() { },
	        ajaxStop: function() { }
	    });

		var dt = datatableImportaciones()

		function fetchData() {
			for (i = 0; i < 4; i++) {
				if (dataSet[i][6] > dataSet[i][7]) {
					dataSet[i][6] = dataSet[i][7];
				} else {
					dataSet[i][6] = dataSet[i][6] + 134;
				}
			}

			return dataSet
		}
		function refresh() {
			setTimeout(function(){ 
				$('#datatable').DataTable().ajax.reload();
				refresh()
			}, 4000);
		}
		
		refresh()

		function getDataUploadFile() {
			var form = new FormData($("#subida")[0]);
			var provincia = $('#provincia').val();
			var token = $('#token').val();

			data = [
				{
					name: 'file',
					value: form
				},
				{
					name: '_token',
					value: token
				},
				{
					name: 'id_provincia',
					value: provincia
				}
			];
			return data;
		}

		$("#subir-box").on("change", "#subida input", function (event) {
			//var data = getDataUploadFile();
			//var data = new FormData($("#subida")[0]);
			var formData = new FormData();
			formData.append('_token', $("#token").val());
			formData.append('provincia', $("#provincia").val());
			// Attach file
			formData.append('file', $('input[type=file]')[0].files[0]);
			for (var pair of formData.entries()) {
			    console.log(pair[0]+ ', ' + pair[1]); 
			}
	
			console.log($('input[type=file]')[0]);
			$("#upload-progress").parent().show();


			$.ajax({
				xhr: function() {
				    var xhr = new window.XMLHttpRequest();
		
				    xhr.upload.addEventListener("progress", function(evt) {
		            if (evt.lengthComputable) {
		      		  var percentComplete = evt.loaded / evt.total;
		              percentComplete = parseInt(percentComplete * 100);
			          console.log(percentComplete);
						
					  $("#upload-progress").html('<div style="margin-top:4px" class="progress-bar progress-bar-sucess progress-bar-striped" role="progressbar" style="width: ' + percentComplete + '%" aria-valuenow="' + evt.loaded + '" aria-valuemin="0" aria-valuemax="' + evt.total + '" title="' + evt.loaded + '/' + evt.total + '">' + percentComplete + '%</div>');

			  	      if (percentComplete === 100) {
						$("#upload-progress").hide();
			    	  }

				    }
				  }, false);

				    return xhr;
				},
				url: "api/postCsv",
				type: 'post',
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					alert("Se subio el archivo.");
					showTabla()
				},
				error: function (data) {
					alert("Error al subir un archivo.");
					console.log(data)
				}
			});
		});


	});
</script>
