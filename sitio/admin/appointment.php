<?php

session_start();

if (isset($_SESSION["usr_rol"])) {
    if (($_SESSION["usr_rol"]) == "" or $_SESSION['usr_rol'] != '3') {
        header("location: ../vistas/login/login.php");
    } else {
            $useremail = $_SESSION["email"];
            $username = $_SESSION["name"];
            // var_dump($useremail);
            // exit();
        }
    } else {
        header("location: ../vistas/login/login.php");
    }

    //import link
    include("../modelos/conexion.php");
    $database = Conexion::conectar();

    $sql = "select * from medics";
    // Prepara la consulta SQL
    $stmt = $database->prepare($sql);
    $stmt->execute();
    // var_dump($stmt);
    // exit();
    // Si se está ejecutando la sentencia SQL
    if ($stmt->execute())
    {
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $userid = $resultado["id_medic"];
        $username = $resultado["name_medic"];
        // var_dump($userid);
        // exit();
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/Logo.png">

    <title>Citas</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>

<?php
    $sqlmain = "SELECT appointment.appointment_id,
    schedule.scheduleid,
    schedule.title,
    medics.name_medic,
    patients.name,
    schedule.scheduledate,
    schedule.scheduletime,
    appointment.apponum,
    appointment.appodate
    FROM schedule
    INNER JOIN appointment ON schedule.scheduleid = appointment.schedule_id
    INNER JOIN patients ON patients.id_patient = appointment.patient_id
    INNER JOIN medics ON schedule.id_medic = medics.id_medic
    WHERE medics.id_medic = '$userid'";
    // print_r ($sqlmain);
    // exit();

    //Prepara la consulta
    $stmt = $database->prepare($sqlmain);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($result);
    // exit();
    if ($_POST) {
        //print_r($_POST);

        if (!empty($_POST["sheduledate"])) {
            $sheduledate = $_POST["sheduledate"];
            $sqlmain .= " and schedule.scheduledate='$sheduledate' ";
            $pdo = $database->prepare($sqlmain);
            $pdo->execute();
            // var_dump($pdo);
            // exit();
        }

    }
    else {
        $sqlmain = "SELECT
            appointment.appointment_id,
            schedule.scheduleid,
            schedule.title,
            medics.name_medic,
            patients.name,
            schedule.scheduledate,
            schedule.scheduletime,
            appointment.apponum,
            appointment.appodate
            FROM
                schedule
            INNER JOIN
                appointment ON schedule.scheduleid = appointment.schedule_id
            INNER JOIN
                patients ON patients.id_patient = appointment.patient_id
            INNER JOIN
                medics ON schedule.id_medic = medics.id_medic
            ORDER BY
                scheduledate DESC";
    }
    ?>
<body>

    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../../img/Logo.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo $username  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail, 0, 22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../vistas/login/logout.php"><input type="button" value="Cerrar Sesión" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="dashboard.php"><input type="button" value="Nosotros" class="logout-btn btn-primary-soft btn"></a>
                                </td>

                            </tr>
                        </table>
                    </td>

                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Inicio</p>
                        </a>
        </div></a>
        </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor ">
                <a href="doctors.php" class="non-style-link-menu ">
                    <div>
                        <p class="menu-text">Doctores</p>
                </a>
    </div>
    </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-schedule ">
            <a href="schedule.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Calendario</p>
                </div>
            </a>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
            <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active">
                <div>
                    <p class="menu-text">Turnos</p>
            </a></div>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-patient">
            <a href="patient.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Pacientes</p>
            </a></div>
        </td>
    </tr>

    </table>
    </div>
    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="index.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Volver</font>
                        </button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Administrador de Turnos Reservados</p>

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Fecha
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php
                        date_default_timezone_set('America/Argentian/Buenos_Aires');
                        $today = date('d-M-Y');
                        echo $today;
                        $today = date('Y-m-d');
                        ?>
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../../img/calendar.svg" width="100%"></button>
                </td>
            </tr>

            <!-- <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Calendario de Sesión</div>
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Agregar a Sesión</font></button>
                        </a>
                        </div>
                    </td>
                </tr> -->
            <tr>

                <td colspan="4" style="padding-top:10px;width: 100%;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Todas las Citas (<?php echo $num_rows; ?>)</p>
                </td>

            </tr>
            <tr>
                <td colspan="4" style="padding-top:0px;width: 100%;">
                    <center>
                        <table class="filter-container" border="0">
                            <tr>
                                <td width="10%">
                                </td>
                                <td width="5%" style="text-align: center;">
                                    Fecha:
                                </td>
                                <td width="30%">
                                    <form action="" method="post">
                                        <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                                </td>
                                <td width="12%">
                                        <input type="submit" name="filter" value=" Filtro" class=" btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin :0;width:100%">
                                    </form>
                                </td>
                            </tr>
                        </table>

                    </center>
                </td>

            </tr>



            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">
                                            Nombre de Paciente
                                        </th>
                                        <th class="table-headin">

                                            Número de Turno

                                        </th>


                                        <th class="table-headin">
                                            Doctor
                                        </th>
                                        <th class="table-headin">


                                            Nombre Sesión

                                        </th>

                                        <th class="table-headin">

                                            Fecha y hora del Turno

                                        </th>

                                        <th class="table-headin">

                                            Eventos

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $result = $database->prepare($sqlmain);
                                    $result->execute();

                                    $rows = $result->fetchAll(PDO::FETCH_ASSOC); // Obtener todas las filas de resultados
                                    // print_r($rows);
                                    $fecha_actual = date("d-m-Y"); // Obtener la fecha actual en el formato Y-m-d

                                    foreach ($rows as $row) {
                                        $appoid = $row["appointment_id"];
                                        $scheduleid = $row["scheduleid"];
                                        $title = $row["title"];
                                        $docname = $row["name_medic"];
                                        $scheduledate = $row["scheduledate"];
                                        $formattedDate = date("d-m-Y", strtotime($scheduledate));
                                        $scheduletime = $row["scheduletime"];
                                        $pname = $row["name"];
                                        //print_r($pname);
                                        $apponum = $row["apponum"];
                                        $appodate = $row["appodate"];

                                        if ($num_rows > 0 ) {

                                            echo
                                            '<tr >
                                                <td style="font-weight:600;"> &nbsp;' .

                                                        substr($pname, 0, 25)
                                                        . '</td >
                                                <td style="text-align:center;font-size:18px;font-weight:500; color: var(--btnnicetext);">
                                                ' . $apponum . '

                                                </td>
                                                <td>
                                                ' . substr($docname, 0, 25) . '
                                                </td>
                                                <td>
                                                ' . substr($title, 0, 15) . '
                                                </td>
                                                <td style="text-align:center;font-size:18px;">
                                                    ' . substr($formattedDate, 0, 10) . ' - ' . substr($scheduletime, 0, 5) . 'hs.'.'
                                                </td>
                                                <td>
                                                    <div style="display:flex;justify-content: center;">';

                                                if ($formattedDate < $fecha_actual) {
                                                    // Si la fecha de la reserva es menor que la fecha actual, muestra "Cita Finalizada" sin enlace
                                                    echo "<button type='button' class='login-btn btn-disabled' style='padding-top:11px;padding-bottom:11px;width:88%'>";
                                                    echo "<font class='tn-in-text'><strong>CITA FINALIZADA</strong></font>";
                                                    echo "</button>";
                                                } else {
                                                    // Si la fecha de la reserva es mayor o igual a la fecha actual, muestra el botón "Cancelar Turno" con el enlace para eliminar
                                                    echo "<a href='?action=drop&id=' . $appoid. &scheduleid= .  '$scheduleid'  . &name= . '$pname' . &session= . '$title' . &apponum= . '$apponum' . ' . "."class='non-style-link'><button  class='btn-primary-soft btn button-icon btn-delete'  style='padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;'><font class='tn-in-text'>Cancelar Turno</font></button></a>";
                                                    echo "</a>";
                                                }

                                        }
                                    }

                                    if ($num_rows == 0) {
                                        echo '<tr>
                                        <td colspan="7">
                                        <br><br><br><br>
                                        <center>
                                        <img src="../../img/notfound.svg" width="25%">

                                        <br>
                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">¡No pudimos encontrar nada relacionado con sus palabras clave!</p>
                                        <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Mostrar todas las Citas &nbsp;</font></button>
                                        </a>
                                        </center>
                                        <br><br><br><br>
                                        </td>
                                        </tr>';
                                    }

                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </center>
                </td>
            </tr>



        </table>
    </div>
    </div>
    <?php

    if ($_GET) {
        $id = $_GET["id"];
        $action = $_GET["action"];
        if ($action == 'add-session') {

            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>

                        <a class="close" href="schedule.php">&times;</a>
                        <div style="display: flex;justify-content: center;">
                        <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                                <td class="label-td" colspan="2">' .
                ""

                . '</td>
                            </tr>

                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Agregar Nueva Sesión.</p><br>
                                </td>
                            </tr>

                            // formulario

                            <tr>
                                <td class="label-td" colspan="2">
                            <form action="add-session.php" method="POST" class="add-new-form">
                                <label for="title" class="form-label">Nombre Sesión : </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="title" class="input-text" placeholder="Nombre de Sesión" required><br>
                                    </td>
                                </tr>
                                <tr>

                                    <td class="label-td" colspan="2">
                                        <label for="docid" class="form-label">Selecicona Doctor: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <select name="docid" id="" class="box" >
                                        <option value="" disabled selected hidden>Escoge Nombre Doctor</option><br/>';


                                        $list11 = $database->prepare("select  * from  medics;");
                                        $num_rows = $list11->rowCount();

                                        for ($y = 0; $y < $num_rows; $y++) {
                                            $row00 = $list11->fetch(PDO::FETCH_ASSOC);
                                            $sn = $row00["name_medic"];
                                            $id00 = $row00["id_medic"];
                                            echo "<option value=" . $id00 . ">$sn</option><br/>";
                                        };

                echo     '       </select><br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="nop" class="form-label">Numero de Pacientes/Appointment Numbers : </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="number" name="nop" class="input-text" min="0"  placeholder="The final appointment number for this session depends on this number" required><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="date" class="form-label">Fecha de Sesión: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="date" name="date" class="input-text" min="' . date('Y-m-d') . '" required><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="time" class="form-label">Calendario Time: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="time" name="time" class="input-text" placeholder="Time" required><br>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input type="reset" value="Resetear" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <input type="submit" value="Place this Sesión" class="login-btn btn-primary btn" name="shedulesubmit">
                                    </td>

                                </tr>
                            </form>
                            </tr>
                        </table>
                        </div>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        } elseif ($action == 'session-added') {
            $titleget = $_GET["title"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br>
                        <h2>Sesión Placed.</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                        ' . substr($titleget, 0, 40) . ' was scheduled.<br><br>

                        </div>
                        <div style="display: flex;justify-content: center;">

                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
            </div>
            </div>
            ';
        } elseif ($action == 'drop') {
            $nameget = $_GET["name"];
            $session = $_GET["session"];
            $apponum = $_GET["apponum"];
            $scheduleid = $_GET["scheduleid"];
//            exit();
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Estás segur@?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            Deseas borrar este registro<br><br>
                            Nombre Paciente &nbsp;<b>' . substr($nameget, 0, 40) . '</b><br>
                            Número de cita &nbsp; : <b>' . substr($apponum, 0, 40) . '</b><br><br>

                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id=' . $id . '&scheduleid=' . $scheduleid . '" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;Si&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';
        } elseif ($action == 'view') {
            $sqlmain = "select * from medics where id_medic='$id'";
            $result = $database->prepare($sqlmain);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $name = $row["name_medic"];
            $email = $row["email_medic"];
            $spe = $row["specialty_id"];

            $spcil_res = $database->prepare("select specialty_name from specialties where id='$spe'");
            $spcil_array = $spcil_res->fetch(PDO::FETCH_ASSOC);
            $spcil_name = $spcil_array["specialty_name"];
            $dni = $row['dni_medic'];
            $tele = $row['phone_medic'];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">
                            ConfiguroWeb<br>

                        </div>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">

                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Ver Detalles</p><br><br>
                                </td>
                            </tr>

                            <tr>

                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Nombre: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    ' . $name . '<br><br>
                                </td>

                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Correo: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $email . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">DNI: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $nic . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Teléfono: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $tele . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Especialidad: </label>

                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            ' . $spcil_name . '<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="doctors.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>


                                </td>

                            </tr>

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        }
    }

    ?>
    </div>

</body>

</html>