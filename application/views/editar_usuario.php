<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
</head>
<body>
    <div class="content-wrapper" id="cabecera">
        <form action="" method="post">
            <table>
                <thead>
                    <tr style="color:forestgreen">
                        <th>Datos</th>
                        <th>Ingresa los nuevos datos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nombre completo</td>
                        <td>
                            <input type="text" name="nombre_completo" value="<?php echo $usuario_id[0]->name; ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Nombre</td>
                        <td>
                            <input type="text" name="nombre" value="<?php echo $usuario_id[0]->nombre; ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Apellido</td>
                        <td>
                            <input type="text" name="apellido" value="<?php echo $usuario_id[0]->apellido; ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <input type="email" name="email" value="<?php echo $usuario_id[0]->email; ?>" >
                        </td>
                    </tr>
                </tbody>
        </table>
    <br>
    <button type="submit">Actualizar Datos</button>
</form>
</div>
</body>
</html>