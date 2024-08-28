<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "clientes";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['costo']) || empty($_POST['fecha_inicio'])|| empty($_POST['fecha_inicio'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son requeridos</div>';
    } else {
        $idcliente = $_POST['id'];
        $nombre = $_POST['nombre'];
        $costo = $_POST['costo'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_final = $_POST['fecha_final'];
            $sql_update = mysqli_query($conexion, "UPDATE cliente SET nombre = '$nombre' , costo = '$costo', fecha_inicio = '$fecha_inicio', fecha_final = '$fecha_final' WHERE idcliente = $idcliente");

            if ($sql_update) {
                $alert = '<div class="alert alert-success" role="alert">Cliente Actualizado correctamente</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al Actualizar el Cliente</div>';
            }
    }
}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
    header("Location: clientes.php");
}
$idcliente = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $idcliente");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: clientes.php");
} else {
    if ($data = mysqli_fetch_array($sql)) {
        $idcliente = $data['idcliente'];
        $nombre = $data['nombre'];
        $costo = $data['costo'];
        $fecha_inicio = $data['fecha_inicio'];
        $fecha_final = $data['fecha_final'];
    }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Cliente
                </div>
                <div class="card-body">
                    <form class="" action="" method="post">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" placeholder="Ingrese Nombre" name="nombre" class="form-control" id="nombre" value="<?php echo $nombre; ?>">
                        </div>
                        <div class="form-group">
                            <label for="costo">costo</label>
                            <input type="number" placeholder="Ingrese costo" name="costo" class="form-control" id="costo" value="<?php echo $costo; ?>">
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio">FechaInicio</label>
                            <input type="text" placeholder="Ingrese fecha inicio" name="fecha_inicio" class="form-control" id="fecha_inicio" value="<?php echo $fecha_inicio; ?>">
                        </div>
                        <div class="form-group">
                            <label for="fecha_final">FechaFinal</label>
                            <input type="text" placeholder="Ingrese fecha final" name="fecha_final" class="form-control" id="fecha_final" value="<?php echo $fecha_inicio; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Cliente</button>
                        <a href="clientes.php" class="btn btn-danger">Atras</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>