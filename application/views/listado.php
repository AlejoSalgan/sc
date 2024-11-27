<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper" id="cabecera">Listado de usuarios
       <span class="pull-right">
         <a href="<?= base_url(); ?>" class="fa fa-home">Inicio</a>
       </span>
       <?php echo "<br>" . $this->session->flashdata('success'); ?>

       <hr>

       <?php foreach ($usuarios as $usuario): ?>
          <h4><?php echo $usuario->name; ?></h4>
          <a href="<?php echo base_url() . "usuarios/" . $usuario->userId; ?>" style="display:inline">Ver detalles</a>
          <a href="<?php echo base_url() . "usuarios/editar_usuario/$usuario->userId"; ?>" style="display:inline">Editar usuario</a>
          <hr>
        <?php endforeach ?>

        <div>
        <form action="<?php echo base_url() ?>usuarios/crear_usuario" method="post">

          <label for="">Nuevo Usuario
            <input id="nombre" name="nombre" type="text">
          </label>

          <label for="">Nuevo Email
            <input id="email" name="email" type="text">
          </label>

          <button type="submit">Enviar</button>

        </form>
        <hr>
       </div>
</div>