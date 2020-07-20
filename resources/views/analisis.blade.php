<div class="box-body" id="subir-box">
	<div class="callout callout-default">
		<h4>Validaciones</h4>
        <p>Aca puede ver el estado del analisis de los datos importados.</p>
    </div>

	<div class="box box-solid">
            <div class="box-body">
              <div class="box-group" id="accordion">
                <div class="panel box box-danger">
                  <div class="box-header with-border">
                    <h2 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseLast" class="collapsed" aria-expanded="false">
                        Errores
                      </a>
                    </h2>
                  </div>
                  <div id="collapseLast" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
                    <div class="box-body" id="errores-body">
                    </div>
                  </div>
                </div>

                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h2 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="">
                        Prestacion
                      </a>
                    </h2>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true" style="">
                    <div class="box-body" id="prestacion-box">
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h2 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" class="">
                        Beneficiario
                      </a>
                    </h2>
					<div class="box-tools pull-right">
						<span class="label label-success">No hay validaciones pendientes</span>
					</div>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse in" aria-expanded="true" style="">
                    <div class="box-body" id="beneficiario-box">
                    </div>
                  </div>
                </div>
                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h2 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">
                        Factura
                      </a>
                    </h2>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
                    <div class="box-body">
                    </div>
                  </div>
                </div>
                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h2 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" class="collapsed" aria-expanded="false">
                        Liquidacion
                      </a>
                    </h2>
					<div class="box-tools pull-right">
						<span class="label"></span>
					</div>
                  </div>
                  <div id="collapseFour" class="panel-collapse collapse" aria-expanded="true">
                    <div class="box-body">
                    </div>
                  </div>
                </div>
                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h2 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive" class="collapsed" aria-expanded="false">
                        Orden de pago
                      </a>
                    </h2>
					<div class="box-tools pull-right">
						<span class="label"></span>
					</div>
                  </div>
                  <div id="collapseFive" class="panel-collapse collapse" aria-expanded="true">
                    <div class="box-body">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
</div>
<script>
function copiar() {
  var copyText = document.getElementById("ids");

  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  document.execCommand("copy");


  copyText.closest(".row").remove()
}


	function copyPaste(id) {

		$.ajax({
			url: "api/advertencias",
		}).done(function (data) {
			console.log(data)
			
			html = `
				<div class="row">
					<div class="col col-md-6">
					</div>
					<div class="col col-md-6">
					<input type="text" value="where id in (1,2,5,2,4,2)" id="ids">
					<button onclick="copiar()">Copiar</button>
					</div>
				</div>	
			`

			$("#ta-"+id).closest(".row").after(html)
		
		}).fail(function (error) {
			alert("Error")
			console.log(error)
		});

	}

$(document).ready(function (){


	function getJobs(id) {
		$.ajax({
			url: "api/jobs",
		}).done(function (data) {
			console.log(data)
			jobs = JSON.parse(data)
			console.log(json)
			
			jobs.forEach(function(job) {
				html = makeRow(job)
				$("#beneficiario-box").append(html);
			})
		
		}).fail(function (error) {
			alert("Error")
			console.log(error)
		});
	}



	function makeRow(job) {
		html = `<div class="row">
		    <div class="col col-md-3">
		 	  <p>` + job.column + `</p>
		    </div>
			<div class="col col-md-3">
		 	  <p>` + job.message + `</p>
			</div>
			<div class="col col-md-2">
		 	  <p>` + job.count + `</p>
			</div>
			<div class="col col-md-4">`

		if (job.count > 0) {
		  html += `<span class="btn btn-xs btn-default" id="ta-`
				+ job.id_tipo_advertencia + 
				`" onclick="copyPaste(` 
				+ job.id_tipo_advertencia  + 
				`)" >Copiar ids</span>     `
		  html += `<span class="btn btn-xs btn-default">Ver tabla</span>`
		}

		html +=
			  `<span class="label label-success pull-right">`
				+ job.status +
			  `</span>
			</div>
		</div>
		`
		if (job.count > 0) html += `<hr style="border: 1.5px solid">` 

		return html
	}



getJobs(1)
})
</script>
