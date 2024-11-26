<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
        .select-container {
            position: relative;
            display: inline-block;
        }

        .select-container select {
            padding: 8px;
        }

        .select-container .tooltip {
            visibility: hidden;
            width: 200px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 60%; /* Position the tooltip above the select */
            left: 50%;
            margin-left: -100px;
            opacity: 0.5;
            transition: opacity 0.5s;
        }

        .select-container .tooltip::after {
            content: "";
            position: absolute;
            top: 100%; /* At the bottom of the tooltip */
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent; /* Arrow */
        }

        .select-container:hover .tooltip {
            visibility: visible;
            opacity: 0.8;
        }
</style>


<div class="content-wrapper">
    <section class="content-header">
        <div class="row bg-title" style="position: relative; bottom: 15px; ">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">REPORTE PDFS</h4> 
            </div>
            <div class="text-right">
                <ol class="breadcrumb" style="background-color: white">
                    <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                    <li class="active">Reporte</li>
                </ol>
            </div>
        </div>
    </section>  

        <div class="container-fluid">

            <div class="panel panel-primary ">
                <div class="panel-heading container-fluid ">
                    <div class="row">

                        <div class="col-md-6">
                            <h3><?= $title ?></h3>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Fecha Desde</label>
                            <input type="date" class="form-control" id="fDesde" name="fDesde" required value="">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Fecha Hasta</label>
                            <input type="date" class="form-control" id="fHasta" name="fHasta" required value="">
                        </div>
                    </div>

                </div>

                <br>

                <div class="product-item float-clear">
                    <div class="col-md-3">
                        <label class="pull-left">Zonas</label>
                        <select id="zonas" class="form-control">
                            <option value="">Seleccione un zona</option>
                            <option value="PBA" data-pertenece="1">PBA</option>
                            <option value="RN" data-pertenece="2">RN</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="pull-left">Municipio</label>
                        <select id="municipio" class="form-control">
                            <option value="">Seleccione un proyecto</option>
                            <?php foreach ($municipio as $item) : ?>
                                <option value="<?= $item->id; ?>" pertenece="<?= $item->zona; ?>"><?= $item->descrip; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-md-3 select-container" >
                        <label class="pull-left" >Serie del equipos</label>
                        <select id="seriesEquipos" class="form-control">
                            <option id="serie" value="">Seleccione un equipo</option>
                            <?php foreach ($equipo as $item) : ?>
                                <option value="<?= $item->municipio; ?>" data-id="<?= $item->id; ?>"><?= $item->serie; ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="tooltip">Si no figuran equipos es porque no tiene</div>
                    </div>

                    <div class="col-md-2">
                        <label class="pull-left">filtro de las Series</label>
                        <input type="text" id="filtroSerie" class="form-control">
                    </div>



                    <div class="col-md-1">
                        <label class="control-label">Aceptar</label>
                        <button id="btnBuscar" type="button" class="btn btn-success">Buscar</button>
                    </div>

                    <br>
                </div>
                <hr>

                <br>

                <table style="border-collapse:collapse;" class="table table-striped table-bordered table-hover table-responsive" id="example">

                </table>
            </div>
            <div id="datosTabla">
            </div>
        </div>
            <hr>
            <br>
            <table style="border-collapse:collapse;" class="table table-striped table-bordered table-hover table-responsive" id="example">
            </table>
        </div>
        <div id="datosTabla">
        </div>
</div>



<script>
    $(document).ready(function() {
        $("#datosTabla").on('click', '#verDetalle', function() {
            let expo = $(this).attr('data-expo');
            let proto = $(this).attr('data-proto');
           

            let form = $('<form></form>').attr('method', 'POST').attr('action', "<?=  base_url('generarCsv') ?>");
            form.append($('<input>').attr('type', 'hidden').attr('name', 'expo').attr('value', expo));
            form.append($('<input>').attr('type', 'hidden').attr('name', 'proto').attr('value', proto));
            $('body').append(form);
            form.submit();

           
        });

        $("#btnBuscar").click(function() {
            fDesde = $("#fDesde").val();
            fHasta = $("#fHasta").val();
            municipio = $("#municipio").val();
            provincia = $("#zonas").find("option:selected").attr("data-pertenece");
            seriesEquipos = $("#seriesEquipos").find(':selected').attr('data-id');
            nombreEquipos = $("#seriesEquipos").children("option:selected").text();

            esto = $(this);
            $(this).removeClass('btn-success');
            $(this).addClass("btn-warning");
            $(esto).text('Cargando...');
            $(this).prop('disabled', true);
            $(".mostrar").fadeOut(1000);

            $.ajax({
                url: "<?= base_url('busquedaDeSalidaPPSVdePDF') ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    provincia,
                    fDesde,
                    fHasta,
                    municipio,
                    seriesEquipos,
                    nombreEquipos,
                }
            }).done(function(data) {
                console.log(data);
                html = "";
                html += `<div class='panel panel-primary'>
                            <div class='panel-heading'>
                                <br>
                            </div>
                            <div>`;

                // Verificar si la propiedad 'datos' no es null
                if (data.datos != null) {

                    html += `<table id="Tabla" style="border-collapse:collapse;" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead >
                                        <tr>
                                            <th class="divPadre"><strong>N° Protocolo</strong></th>
                                            <th class="divPadre"><strong>N° Exportacion</strong></th>
                                            <th class="divPadre"><strong>Serie de Equipo</strong></th>
                                            <th class="divPadre"><strong>Municipio</strong></th>
                                            <th class="divPadre"><strong>CSV</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody id='contenido'>`;
                    $.each(data.datos, function(key, campo) {
                        html += `<tr>`;
                        html += `<td class="text-center"><h4><span class='label label-primary'>${campo.idprotocolo}</span></h4></td>`;
                        html += `<td class="text-center"><h4>`;
                        $.each(campo.expo_nro, function(index, expo) {
                            html += `<span class='label label-default'>${expo}</span> `;
                        });
                        html += `</h4></td>`;
                        html += `<td class="text-center"><h4><span class='label label-info'>${campo.serie}</span></h4></td>`;
                        html += `<td class="text-center"><h4><span class='label label-danger'>${campo.descrip}</span></h4></td>`;
                        html += `<td><button class="btn btn-success" id="verDetalle" data-proto='${campo.idprotocolo}' data-expo='`
                        $.each(campo.expo_nro, function(index, expo) {
                            if (index === campo.expo_nro.length - 1) {
                                html += `${expo}`;
                            } else {
                                html += `${expo}, `;
                            }
                        });
                        html += `'>
                                        <svg  width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM3.517 14.841a1.13 1.13 0 0 0 .401.823q.195.162.478.252.284.091.665.091.507 0 .859-.158.354-.158.539-.44.187-.284.187-.656 0-.336-.134-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.566-.21l-.621-.144a1 1 0 0 1-.404-.176.37.37 0 0 1-.144-.299q0-.234.185-.384.188-.152.512-.152.214 0 .37.068a.6.6 0 0 1 .246.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.2-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.439 0-.776.15-.337.149-.527.421-.19.273-.19.639 0 .302.122.524.124.223.352.367.228.143.539.213l.618.144q.31.073.463.193a.39.39 0 0 1 .152.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.167.07-.413.07-.175 0-.32-.04a.8.8 0 0 1-.248-.115.58.58 0 0 1-.255-.384zM.806 13.693q0-.373.102-.633a.87.87 0 0 1 .302-.399.8.8 0 0 1 .475-.137q.225 0 .398.097a.7.7 0 0 1 .272.26.85.85 0 0 1 .12.381h.765v-.072a1.33 1.33 0 0 0-.466-.964 1.4 1.4 0 0 0-.489-.272 1.8 1.8 0 0 0-.606-.097q-.534 0-.911.223-.375.222-.572.632-.195.41-.196.979v.498q0 .568.193.976.197.407.572.626.375.217.914.217.439 0 .785-.164t.55-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.764a.8.8 0 0 1-.118.363.7.7 0 0 1-.272.25.9.9 0 0 1-.401.087.85.85 0 0 1-.478-.132.83.83 0 0 1-.299-.392 1.7 1.7 0 0 1-.102-.627zm8.239 2.238h-.953l-1.338-3.999h.917l.896 3.138h.038l.888-3.138h.879z"/>
                                        </svg>
                                    </button>
                                </td></tr>`;
                    });
                    html += `       </tbody>
                            </table>`;
                } else {
                    html += `<div class="alert alert-danger text-center">
                                <strong>¡Advertencia!</strong> no se ha encontrado ningun dato, por favor, verfique si el rango de fecha o la serie del equipo son correctos.
                            </div>`;
                }
                html += `   </div>
                        </div>`;


                $("#datosTabla").fadeOut(function() {
                    $(this).html(html).stop(true, true).fadeIn(500);
                    $('#Tabla').DataTable({
                        pageLength: 25,
                        lengthChange: false,
                        searching: true,
                        order: [],
                    });
                });

            }).always(function() {
                $(esto).removeClass('btn-warning');
                $(esto).addClass("btn-success");
                $(esto).text('Buscar');
                $(esto).prop('disabled', false);
            });
        });


    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const municipioSelect = document.getElementById('municipio');
        const seriesEquiposSelect = document.getElementById('seriesEquipos');
        const originalSeriesOptions = Array.from(seriesEquiposSelect.options);

        municipioSelect.addEventListener('change', () => {
            const selectedMunicipio = municipioSelect.value;
            seriesEquiposSelect.innerHTML = '<option value="">Seleccione un proyecto</option>';
            originalSeriesOptions.forEach(option => {
                if (option.value === selectedMunicipio) {
                    seriesEquiposSelect.appendChild(option.cloneNode(true));
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        var $municipioSelect = $("#municipio");
        var $municipioOptions = $municipioSelect.find("option").clone();

        $("#zonas").change(function() {
            var selectedZona = $(this).val();
            $municipioSelect.html($municipioOptions); // Reset options to original

            if (selectedZona) {
                $municipioSelect.find("option").each(function() {
                    if ($(this).attr("pertenece") !== selectedZona && $(this).attr("pertenece") !== undefined) {
                        $(this).remove();
                    }
                });
            }

            $municipioSelect.val(""); // Reset the municipio selection
        });
    });
</script>


<script>
    var select = document.getElementById("seriesEquipos");
    var filtroInput = document.getElementById("filtroSerie");

    filtroInput.addEventListener("input", function() {
        var filtro = filtroInput.value.toLowerCase();
        var options = select.getElementsByTagName("option");

        for (var i = 0; i < options.length; i++) {
            var option = options[i];
            var optionText = option.textContent.toLowerCase();

            if (optionText.indexOf(filtro) !== -1 || filtro === "") {
                option.style.display = "";
            } else {
                option.style.display = "none";
            }
        }
    });
</script>