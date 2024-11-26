<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style>
    .border-1 {
        border-width: 1px;
        border-style: solid;
    }
    .border-danger {
        border: 1px solid #dc3545;
    }
    #block-view {
        display: none; /* Oculto por defecto */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
        z-index: 9999; /* Alto z-index para estar encima de todos los demás elementos */
        text-align: center;
        color: white;
        font-size: 24px;
        padding-top: 20%;
    }
    
</style>


<script type="text/javascript">
    $(document).ready(function() {
        if ("<?= $this->session->flashdata('resultado_generacion') ?>") {
            body_respuesta = document.getElementById('modalBodyRespuesta');
            body_respuesta.innerHTML = "<?= $this->session->flashdata('resultado_generacion') ?>";
            $('#respuestaModal').modal('show');
        };
    })
</script>

<div id="block-view">Cargando, por favor espera...</div>

<!-- Modal Confirmacion procesar Salida Edicion -->
<div class="modal fade" id="confModal" tabindex="-1" role="dialog" aria-labelledby="confModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="confModalLabel">Confirmacion</h4>
        <button type="button" id="xButton" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBodyContent">
        <!-- aca se cargan los datos a confirmar -->
      </div>
      <div class="modal-footer">
        <button type="button" id="CloseConf" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="ConfButton" class="btn btn-success">Generar Salida de Edicion</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Respuesta Salida Edicion -->
<div class="modal fade" id="respuestaModal" tabindex="-1" role="dialog" aria-labelledby="respuestaModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="respuestaModalLabel">Resultado de la Salida de Edicion</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBodyRespuesta">
        <!-- aca se cargan los resultados de la generacion -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="content-wrapper">
    <div id="cabecera">
      SSTI - Generacion de Salida de Edicion
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Generacion de Salida de Edicion
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissable" style="position: relative; bottom: 5px;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                    <?php endif; ?>
                <?php
                if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissable" style="position: relative; bottom: 5px; ">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?= $this->session->flashdata('success'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal content">
                    <div class="modal-header">
                        kajsdnakjdn
                    </div>
                </div>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Procesar Totales</h3>
                    </div>
                    <form method="POST" id="generar_salida">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form group">
                                        <label >Tipo de proyecto</label>
                                        <select class="form-control" id="tipo_proyecto" name="tipo_proyecto">
                                            <option value="" disabled selected hidden>Seleccionar</option>
                                            <option value= 0 >PROVINCIA BS</option> <!-- PROVINCIA BS AS -->
                                            <option value= 1 >CABA</option> <!-- CABA -->
                                            <option value= 2 >INTERIOR y RN</option> <!-- INTERIOR y RN (sin santa fe)-->
                                            <option value= 3 >SANTA FE</option> <!-- Solo Santa Fe-->
                                            <option value= 4 >LUCES</option> <!-- Todos los proyecto de luces-->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >Proyecto</label>
                                        <select class="form-control" id="proyectos" name="proyectos">
                                            <option value="" disabled selected hidden>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >Tipo de proceso</label>
                                        <select class="form-control" id="tipo_proceso" name="tipo_proceso">
                                            <option value="" disabled selected hidden>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-top: 25px;">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;">Procesar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        
        <?php if (sizeof($protocolos) == 0):?>
            <div class="row">
                <div class="col-xs-12">
                    <h2>No hay protocolos para procesar!</h2>
                </div>
            </div>

        <?php else: ?>

            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-primary" disabled>Procesar Seleccionados</button>
                    &nbsp;
                    <i class="fa fa-info-circle fa-lg" title="Proximamente"></i>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                <div class="box">
                    <div id="botonImprimir" class="box-header">
                        <h1 class="box-title">
                            Total: <span class="text-primary"><b id="protocolos_mostrados"><?= $total_protocolos; ?></b></span>
                            &nbsp;|&nbsp;&nbsp;&nbsp;Seleccionados: <span class="text-primary"><b>0</b></span>
                        </h1>
                        <div class="box-tools">
                            <form id="searchList">
                                <div class="input-group">
                                    <input id="searchText" type="text" name="searchText" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                                    <select id="criterio" class="form-control pull-right" name="criterio" style="width: 103px; height: 30px;">
                                        <option value="0" >Todos</option>
                                        <option value="1" >Serie</option>
                                        <option value="2" >Proyecto</option>
                                        <option value="3" >Protocolo</option>
                                    </select>
                                    <div class="input-group-btn">
                                        <button id="searchButton" class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div id="divTabla" class="box-body table-responsive no-padding">
                        <table id="tablaDatos" class="table table-bordered table-hover">
                            <thead>
                                <tr class="info">
                                    <th width="50px">Seleccionar para procesar</th>
                                    <th>Protocolo</th>
                                    <th>Proyecto</th>
                                    <th>Equipo</th>
                                    <!-- <th>Acciones</th> -->
                                </tr>
                            </thead>
                            <tbody id="listado_protocolos">
                            <!-- aca se van a agregar la lista de protocolos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php endif ?>

    </section>
</div>


<script src="<?php echo base_url('assets/js/formValidator.js');?>" type="text/javascript"></script>

<script>
    
    $(document).ready(function() {
        $('#tipo_proyecto').change(function() {
            vaciar_inputs();
        })
    })

    // completar los tipos de proceso segun el tipo de proyecto seleccionado
    $(document).ready(function(){
        $('#proyectos').change(function() {
            var tipo_seleccionado = $('#tipo_proyecto').val();
            var procesos = $('#tipo_proceso');
            var opciones = '<option value="" disabled selected hidden>Seleccionar</option>';
            var proyectos_solo_opcion_todos = [1,2,3,4];

            if ( proyectos_solo_opcion_todos.includes(parseInt(tipo_seleccionado)) ){
                opciones += '<option value=0 > Procesar todo </option>';

            } else if (tipo_seleccionado == 0) {
                opciones += '<option value=1 >Procesar Fijos</option>';
                opciones += '<option value=2 >Procesar Moviles</option>';
                opciones += '<option value=3 >Procesar Rechazados</option>';
            }
            procesos.html(opciones);
        });
    });

    //esto es si no uso la funcion de arriba que completa con los proyectos
    function vaciar_inputs() {
        $('#proyectos').empty().append('<option value="" disabled selected hidden>Seleccionar</option>');
        $('#proyectos').append('<option value=0 >Todos</option>');
        $('#tipo_proceso').empty().append('<option value="" disabled selected hidden>Seleccionar</option>');
    }
    
    function removeCointainerErrors(nameInput){
        const elementContainerError = document.getElementById(`${nameInput}-errors`);
        if (elementContainerError) {
        elementContainerError.remove();
        }
    }
    
    const rules ={
        tipo_proyecto: ['selectRequired', 'required'],
        proyectos: ['selectRequired', 'required'],
        tipo_proceso: ['selectRequired', 'required'],
    };

    document.getElementById('generar_salida').addEventListener('submit', function(event) {
        event.preventDefault();
        const validator = new FormValidator("generar_salida", rules);
        const result = validator.validate();

        if (!result.valid) {
            Object.keys(rules).forEach((nameInput) => {

                if (Object.keys(result.errors).includes(nameInput)) {
                    removeCointainerErrors(nameInput);
                    document.getElementById(nameInput).classList.add("border-1","border-danger");
                    const divContainerError = document.createElement('div');
                    divContainerError.id = `${nameInput}-errors`; 
                    // genero un solo <small> para imprimir uno solo de los posibles errores por input, en pantalla
                    for (const errorInInput of result.errors[nameInput]) {
                        const errorMessage = document.createElement('small');
                        errorMessage.classList.add("text-danger");
                        errorMessage.textContent = errorInInput;
                        divContainerError.appendChild(errorMessage);
                        break; // Salgo del bucle luego del primer mensaje de error para que solo se imprima uno de los errores del input
                    }
                    document.getElementById(nameInput).insertAdjacentElement('afterend', divContainerError);
                }else {
                  // para inputs que hayan pasado la validacion mientras otros no, remuevo los posibles estilos y mensajes de error de un submit anterior
                  document.getElementById(nameInput).classList.remove("border-1", "border-danger");
                  removeCointainerErrors(nameInput);
              }
            })
        } else {
            Object.keys(rules).forEach((nameInput) => {
            document.getElementById(nameInput).classList.remove("border-1", "border-danger");
            removeCointainerErrors(nameInput)
        });

            const tipoProyecto = document.getElementById('tipo_proyecto').selectedOptions[0].text;
            const proyecto = document.getElementById('proyectos').selectedOptions[0]?.text;
            const tipoProceso = document.getElementById('tipo_proceso').selectedOptions[0]?.text;
            const modalBodyContent = `
                <p><h4><strong>Realmente quiere Ejecutar la salida de edicion?</strong><h4/></p>
                <p><strong>Tipo de proyecto:</strong> ${tipoProyecto}</p>
                <p><strong>Proyecto:</strong> ${proyecto}</p>
                <p><strong>Tipo de proceso:</strong> ${tipoProceso}</p>
            `;
            document.getElementById('modalBodyContent').innerHTML = modalBodyContent;
            $('#confModal').modal('show')

            $('#ConfButton').click(function() {
                console.log('Se acepto la salida de edicion');
                $("#confModal").hide();
                // $('#generar_salida').submit();
                $('#block-view').show();
                const tipoProyectoValue = document.getElementById('tipo_proyecto').value;
                const proyectoValue = document.getElementById('proyectos').value;
                const tipoProcesoValue = document.getElementById('tipo_proceso').value;

                const opciones = {
                    0: { p: 6, q: { 1: 7, 2: 8, 3: 9 } },
                    1: { p: 3 },
                    2: { p: 5 },
                    3: { p: 99 },
                    4: { p: 88 }
                };
                const p = opciones[tipoProyectoValue]?.p;
                const q = (opciones[tipoProyectoValue]?.q && opciones[tipoProyectoValue].q[tipoProcesoValue]) || '';
                const url =" <?= base_url('usar_generador_salida_edicion') ?>" + `?p=${p}${q ? `&q=${q}` : ''}`;

                fetch(url, {
                    method: 'GET'
                })
                .then(response => response.text())
                .then(data => {
                    $('#block-view').hide();
                    body_respuesta = document.getElementById('modalBodyRespuesta');
                    body_respuesta.innerHTML = data;
                    $('#respuestaModal').modal('show');
                });
                $('#respuestaModal').on('hidden.bs.modal', function () {
                    window.location.reload();
                });
            });
        }
    })

    //carga la lista de protocolos cuando carga la pagina
    $(document).ready(function(){
        
        var data_protocolos = <?= json_encode($protocolos); ?>;
        
        var html = '';
        data_protocolos.forEach(function(item){
            html += '<tr>';
            html += `<td> <input type="checkbox" value="${item.id}"> </td>`
            html += `<td>${item.id}</td>`;
            html += `<td>${item.proyecto}</td>`;
            html += `<td>${item.equipo}</td>`;
            html += '</tr>';
        })

        $("#listado_protocolos").html(html);
    })

    // modifica la lista de protocolos con los resultados de la busqueda
    // modifica tambien la cantidad total mostrada
    $(document).ready(function() {
        $("#searchList").submit(function(event) {
            event.preventDefault();
            
            var searchText = $("#searchText").val().toLowerCase();
            var criterio = $("#criterio").val();

            var data_protocolos = <?= json_encode($protocolos); ?>;

            var data_filtrada = data_protocolos.filter(function(item){
                if (criterio == 0){
                    return true;
                } else if (criterio == 1){
                    return item.equipo.toLowerCase().includes(searchText);
                } else if (criterio == 2){
                    return item.proyecto.toLowerCase().includes(searchText);
                } else if (criterio == 3 && searchText != ''){
                    console.log(parseInt(searchText));
                    return item.id == parseInt(searchText)
                } else {
                    return true;
                }
            })
            
            var html = '';
            console.log(data_filtrada);
            if (data_filtrada.length == 0) {
                html += '<tr>';
                html += `<td colspan=4 style="text-align:center"> <h3>No se encontraron registros!</h3> </td>`
                html += '</tr>';
            } else {
                data_filtrada.forEach(function(item){
                    html += '<tr>';
                    html += `<td> <input type="checkbox" value="${item.id}"> </td>`
                    html += `<td>${item.id}</td>`;
                    html += `<td>${item.proyecto}</td>`;
                    html += `<td>${item.equipo}</td>`;
                    html += '</tr>';
                });
            }
            $("#listado_protocolos").html(html);
            $("#protocolos_mostrados").html(data_filtrada.length);
        })
    })

    
</script>


