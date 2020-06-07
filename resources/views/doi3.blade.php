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
	                    <li><a href="#">Descargar diccionario</a></li>
	            	    <li><a href="#">Descargar ejemplo</a></li>
		            </ul>
				</div>
				<button class="btn btn-success" id="subir"><i class="fa fa-upload"></i> Subir</button>
				<button class="btn btn-default pull-right" id="importacion" style="display: none"><i class="fa fa-refresh fa-fw"></i> Tabla</button>
				<div class="box-tools pull-right" style="padding-top: 6px;" id="refresh">
					<button class="btn btn-box-tool" title="Consulta la tabla cada 10 segundos"><i class="fa fa-refresh fa-spin fa-fw"></i></button>
              	</div>
			</div>
			<div class="box-body" id="tabla-box">
				<div class="callout callout-default">
					<h4><i class="fa fa-table" aria-hidden="true"></i>  Tabla de importaciones</h4>
	                <p>
						Puede ver el periodo al que corresponden las prestaciones que subio, tambien entrar a la declaracion jurada de ese periodo y ver el historial de modificaciones.
					</p>
                </div>
				<table id="datatable" class="table">
				</table>
			</div>
			<div class="box-body" style="display: none" id="subir-box">

<div class="callout callout-success">
					<h4><i class="icon fa fa-upload"></i>  Subida de archivo</h4>

                <p>Desde esta opción usted podrá subir los archivos para la carga de prestaciones. Recuerde respetar la estructura de datos.</p>
				<p>Si tiene dudas consulte en el boton "Diccionario" (arriba a la izquierda)</p>
              </div>
		
				<div class="alert alert-danger" id="errores-div">
			        <ul id="errores-form">
			        </ul>
			    </div>
				<div class="row">
				<div class="col col-md-3">

<form action="api/postCsv" method="post" enctype="multipart/form-data" id="subida">
			<span class="btn btn-default fileinput-button">
					<i class="glyphicon glyphicon-plus"></i>
					<span>Seleccionar archivos</span>
					<input id="fileupload" type="file" name="file" multiple>
				</span>

  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Subit" name="submit">
</form>
					</div>
				<div class="col col-md-9">
				<div id="progress" class="progress">
					<div class="progress-bar progress-bar-success"></div>
				</div>
				</div>
				</div>
				<!-- The container for the uploaded files -->
				<div id="files" class="files"></div>
<div class="modal fade modal-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Atención!</h4>
            </div>
            <div class="modal-body">
                <p id="modal-text"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>




			</div>
			<div class="box-body" style="display: none" id="diccionario-box">

<div class="callout callout-info">
					<h4><i class="icon fa fa-book"></i>  Diccionario de datos</h4>

                <p>
					Si tiene dudas de como generar el archivo de prestaciones para subir al SIRGe Web ingrese a esta opción.
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



		</div>
	</div>
</div>
</div>

<script>
	function addToken() {
		token = $('meta[name="csrf-token"]').attr('content')
		$("#subida").append('<input type="hidden" name="_token" value="' + token + '">')
	}

	function showTabla() {
		$("#tabla-box").show()	
		$("#importacion").show()
		$("#refresh").hide()
		$("#subir-box").hide()	
		$("#analisis-box").hide()	
		$("#diccionario-box").hide()	
	}
	

	function showSubir() {
		$("#subir-box").show()	
		$("#diccionario-box").hide()	
		$("#tabla-box").hide()	
		$("#analisis-box").hide()	
		$("#importacion").show()
		$("#refresh").hide()
	}

	function showDiccionario() {
		$("#diccionario-box").show()	
		$("#subir-box").hide()	
		$("#tabla-box").hide()	
		$("#analisis-box").hide()	
		$("#importacion").show()
		$("#refresh").hide()
		datatableDiccionario();
	}

	function getAnalisis(id) {
		$.ajax({
		  url: "api/analisis/" + id,
		}).done(function(html) {
			$("#analisis-box").show()	
			$("#analisis-box").html(html)	
		}).fail(function(error) {
			alert("Error")
			console.log(error)
		});
	}

	function showAnalisis() {
		getAnalisis(1);
		$("#diccionario-box").hide()	
		$("#subir-box").hide()	
		$("#tabla-box").hide()	
		$("#importacion").show()
		$("#refresh").hide()
	}

	function showAdvertencias() {
		datatableAdvertencias()
		$("#advertencias-box").show()	
		$("#diccionario-box").hide()	
		$("#subir-box").hide()	
		$("#tabla-box").hide()	
		$("#importacion").hide()
		$("#refresh").hide()
	}

	function datatableDiccionario() {
		return $('#diccionario-datatable').DataTable({
			paging:   false,
			searching:   false,
	        ordering: false,
	        ajax : {
				url: 'api/diccionario',
				dataSrc: "data",
			},
	        columns: [
	            { data: 'orden', title: 'Orden' },
	            { data: 'campo', title: 'Campo' },
				{ data: 'tipo', title: 'Tipo' },
	        ]
		});
	}

	function datatableImportaciones() {
		return $('#datatable').DataTable({
			debug: true,
			processing: true,
	        ajax : {
				url: 'api/importaciones',
				dataSrc: 'data',
			},
	        columns: [
	            { data: 'id_provincia', title: 'Provincia'},
				{ data: 'periodo', title: "Periodo" },
	            { data: 'fecha', title: 'Subida'},
	        	{ data: 'facturadas', title: "Facturadas" },
	        	{ data: 'liquidadas', title: "Liquidadas" },
	        	{ data: 'pagadas', title: "Pagadas" },
	            { data: 'total', title: 'total'},
				{ render: function() {
					return '<button onclick="showAnalisis()" class="btn btn-warning btn-xs"> Advertencias</button>'
				  },
				  orderable: false
				}
	        ]
		});
	}

	function datatableAdvertencias() {
		return $('#advertencias-datatable').DataTable({
			debug: true,
			processing: true,
	        ajax : {
				url: 'api/advertencias',
				dataSrc: 'data',
			},
	        columns: [
	            { data: 'prestacion_id', title: 'ID'},
				{ data: 'column', title: "Columna" },
	            { data: 'message', title: 'Advertencia'}
	        ]
		});
	}



	function progress(data, type, row, meta ) {
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
        	{ title: "Estado",
			  render: function(data, type, row, meta) {
				return "Importando"
			  }
			},
			{ render: function(data, type, row, meta) {
				return progress(data, type, row, meta)
              },
			  orderable: false,
			  title: "Progreso"
			},
			{ render: function() {
				return '<button onclick="showAnalisis()" class="btn btn-success btn-xs"> Analisis</button>'
			  },
			  orderable: false
			}
		]
	});

		$(".content .analisis").on("click", showAnalisis)

	}

	$(document).ready(function(){
		addToken()
		$("#importacion").on("click", showTabla)
		$("#subir").on("click", showSubir)
		$(".diccionario").on("click", showDiccionario)

     	var dataSet = [
		    [ "Buenos Aires", "2020-01", "2020-02-01 15:00", 10000, 11000, 12000, 33, 33000],
		    [ "CABA", "2020-02", "2020-03-01 15:00", 8000, 9000, 10000, 27, 27000],
	    	[ "Jujuy", "2020-01", "2020-02-01 12:00", 5000, 6000, 7000, 18, 18000],
		    [ "Salta", "2020-01", "2020-02-01 12:00", 5000, 6000, 7000, 12, 23123]
		]

		//var dt = drawTable(dataSet)
		var dt = datatableImportaciones()
		
		function fetchData() {
			for(i = 0; i < 4; i++) {
				if (dataSet[i][6] > dataSet[i][7]) {
					dataSet[i][6] = dataSet[i][7];
				} else {
					dataSet[i][6] = dataSet[i][6] + 134;
				}
			}

			return dataSet
		}
		/*
		function refresh(dataSet) {
			setTimeout(function(dataSet){ 
				dataSet = fetchData()
				drawTable(dataSet); 
				refresh(dataSet)
			}, 1000, dataSet);
		}
		
		refresh(dataSet)
		*/

	});
</script>
