<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
</head>
<body>
    <div class="content-wrapper" id="cabecera">
        <h3 style="color:forestgreen"><b><?php echo $usuario_detalles[0]->name?></b></h3>
        <table>
            <thead>
                <tr>
                    <h5>ID: <b><?php echo $usuario_detalles[0]->userId . "<br>" ; ?></b></h5>
                    <h5>Nombre: <b><?php echo $usuario_detalles[0]->nombre . "<br>" ; ?></b></h5>
                    <h5>Apellido: <b><?php echo $usuario_detalles[0]->apellido . "<br>" ; ?></b></h5>
                    <h5>Email: <b><?php echo $usuario_detalles[0]->email . "<br>" ; ?></b></h5>
                    <h5>Rol de Usuario: <b><?php echo $usuario_detalles[0]->roleId . "<br>" ; ?></b></h5>
                </tr>
            </thead>
        </table>
    </div>
</body>
</html>