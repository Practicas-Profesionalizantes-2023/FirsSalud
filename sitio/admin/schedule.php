<?php

session_start();

if (isset($_SESSION["usr_rol"])) {
    if (($_SESSION["usr_rol"]) == "" or $_SESSION['usr_rol'] != '3') {
        header("location: ../vistas/login/login.php");
    } else {
        $useremail = $_SESSION["email"];
        $username = $_SESSION["name"];
    }
} else {
    header("location: ../vistas/login/login.php");
}

//import link
include("../modelos/conexion.php");

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
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.png">

    <title>Calendario</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>

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
        <td class="menu-btn menu-icon-schedule menu-active menu-icon-schedule-active">
            <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active">
                <div>
                    <p class="menu-text">Calendario</p>
                </div>
            </a>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-appoinment">
            <a href="appointment.php" class="non-style-link-menu">
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
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Administrador de Turnos</p>

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Fecha
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php

                        date_default_timezone_set('America/Argentina/Buenos_Aires');

                        $today = date('d-M-Y');
                        echo $today;
                        $today = date('Y-m-d');

                        $database = Conexion::conectar();
                        $list110 = $database->prepare("SELECT  * FROM  schedule WHERE scheduledate >='$today';");
                        $list110->execute();
                        $num_rows = $list110->rowCount();

                        // if($result["datetime"])
                        // var_dump($num_rows);
                        // exit();
                        // $row = $list110->fetch(PDO::FETCH_ASSOC);

                    
                        ?>
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../../img/calendar.svg" width="100%"></button>
                </td>


            </tr>

            <tr>
                <td colspan="4">
                    <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Calendario de Turnos</div>
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button class="login-btn btn-primary btn button-icon" style="margin-left:25px;background-image: url('../../img/icons/add.svg');">Agregar Turno</font></button>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;">

                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Turnos Disponibles (<?php echo $num_rows; ?>)</p>
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
                                        <input type="date" name="scheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">

                                        </td>
                                        <td width="5%" style="text-align: center;">
                                            Doctor:
                                        </td>
                                        <td width="30%">
                                            <select name="id_medic" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;">
                                                <option value="" disabled selected hidden>Escoge Nombre Doctor De La Lista</option><br />

                                                <?php

                                                $list11 = $database->prepare("select  * from  medics order by name_medic asc;");
                                                $list11->execute();
                                                $num_rows = $list11->rowCount();

                                                for ($y = 0; $y < $num_rows; $y++) {
                                                    $row00 = $list11->fetch(PDO::FETCH_ASSOC);
                                                    $sn = $row00["name_medic"];
                                                    $id00 = $row00["id_medic"];
                                                    echo "<option value=" . $id00 . ">$sn</option><br/>";
                                                };
                                                ?>

                                            </select>
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

            <?php
            if ($_POST) {
                //print_r($_POST);
                $sqlpt1 = "";
                if (!empty($_POST["scheduledate"])) {
                    $scheduledate = $_POST["scheduledate"];
                    $sqlpt1 = " schedule.scheduledate='$scheduledate' ";
                }


                $sqlpt2 = "";
                if (!empty($_POST["id_medic"])) {
                    $docid = $_POST["id_medic"];
                    $sqlpt2 = " medics.id_medic=$docid ";
                }
                //echo $sqlpt2;
                //echo $sqlpt1;
                $sqlmain = "SELECT
                    schedule.scheduleid,
                    schedule.title,
                    medics.name_medic,
                    schedule.scheduledate,
                    schedule.scheduletime,
                    schedule.nop
                    FROM schedule INNER JOIN medics
                    ON schedule.id_medic=medics.id_medic ";

                $sqllist = array($sqlpt1, $sqlpt2);
                $sqlkeywords = array(" where ", " and ");
                $key2 = 0;
                foreach ($sqllist as $key) {

                    if (!empty($key)) {
                        $sqlmain .= $sqlkeywords[$key2] . $key;
                        $key2++;
                    };
                };
                //echo $sqlmain;

            } else {
                $sqlmain = "SELECT schedule.scheduleid, schedule.title, medics.name_medic, schedule.scheduledate, schedule.scheduletime, schedule.nop 
                FROM schedule 
                INNER JOIN medics ON schedule.id_medic = medics.id_medic  
                ORDER BY schedule.scheduledate ASC, schedule.scheduletime ASC";
            }



            ?>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">


                                            Nombre Sesión

                                        </th>

                                        <th class="table-headin">
                                            Doctor
                                        </th>
                                        <th class="table-headin">

                                            Fecha y Hora Cita

                                        </th>
                                        <th class="table-headin">

                                            Número máximo que se puede reservar

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
                                

                                    // var_dump($num_rows);
                                    // exit();
                                foreach ($rows as $row) {
                                    $scheduleid = $row["scheduleid"];
                                    $title = $row["title"];
                                    $docname = $row["name_medic"];
                                    $scheduledate = $row["scheduledate"];
                                    $formattedDate = date("d-m-Y", strtotime($scheduledate));
                                    $scheduletime = $row["scheduletime"];
                                    $nop = $row["nop"];
                                    
                                
                                    while($update==0 && $nop > 0)
                                    {
                                        if($scheduledate < $today)
                                            {
                                                $sql = $database->prepare("UPDATE schedule SET nop = nop - 1 WHERE scheduleid = '$scheduleid'");
                                                $sql->execute();
                                            }
                                        $update=1;
                                    }
                                    // if ($nop > 0 ) {

                                        echo '<tr>
                                            <td> &nbsp;' .
                                                substr($title, 0, 30)
                                                . '</td>
                                            <td>
                                            ' . substr($docname, 0, 20) . '
                                            </td>
                                            <td style="text-align:center;">
                                                ' . substr($formattedDate, 0, 10) . ' - ' . substr($scheduletime, 0, 5) . 'hs.'.'
                                            </td>
                                            <td style="text-align:center;">
                                                ' . $nop . '
                                            </td>

                                            <td>
                                            <div style="display:flex;justify-content: center;">
                                            
                                            <a href="?action=view&id=' . $scheduleid . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Ver</font></button></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="?action=drop&id=' . $scheduleid . '&name=' . $title . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Remove</font></button></a>
                                            </div>
                                            </td>
                                            </tr>';
                                    }
                                //} 
                                if(empty($result))
                                    {
                                        echo '<tr>
                                            <td colspan="4">
                                            <br><br><br><br>
                                            <center>
                                            <img src="../../img/notfound.svg" width="25%">
                                            
                                            <br>
                                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldn\'t find anything related to your keywords !</p>
                                            <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Mostrar todas las Sesiones &nbsp;</font></button></a>
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
                                    <label for="id_medic" class="form-label">Selecicona Doctor: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <select name="id_medic" id="" class="box" >
                                    <option value="" disabled selected hidden>Escoge Nombre Doctor</option><br/>';


                                    $list11 = $database->prepare("select  * from  medics order by name_medic asc;");
                                    $list11->execute();
                                    $num_rows = $list11->rowCount();

                                    for ($y = 0; $y < $num_rows; $y++) {
                                        $row00 = $list11->fetch(PDO::FETCH_ASSOC);
                                        $sn = $row00["name_medic"];
                                        $id00 = $row00["id_medic"];
                                        echo "<option value=" . $id00 . ">$sn</option><br/>";
                                    };
            echo     '              </select><br><br>
                                </td>
                            </tr>
                            
                    
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="date" class="form-label">Fecha de Sesión (desde): </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="date" name="start_date" class="input-text" min="' . date('Y-m-d') . '" required><br>
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                                <label for="date" class="form-label">Fecha de Sesión (hasta): </label>
                            </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="date" name="end_date" class="input-text" min="' . date('Y-m-d') . '" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="time" class="form-label">Hora Calendario (desde): </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="time" name="start_time" class="input-text" placeholder="Hora" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="time" class="form-label">Hora Calendario (hasta): </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="time" name="end_time" class="input-text" placeholder="Hora" required><br>
                                </td>
                            </tr>
                            <tr>

                            <tr>
                            <td class="label-td" colspan="2">
                                <label for="number" class="form-label">Duracion del Turno: </label>
                            </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="number" name="duration" class="input-text" placeholder="Minutos" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Resetear" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                
                                    <input type="submit" value="Coloque esta sesión" class="login-btn btn-primary btn" name="shedulesubmit">
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
                        <h2>Sesión fijada</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                        ' . substr($titleget, 0, 40) . ' Fue programada.<br><br>
                            
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
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Estás segur@?</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                            Deseas borrar este registro<br>(' . substr($nameget, 0, 40) . ').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-session.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Si&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';
        } elseif ($action == 'view') {
            $sqlmain = "SELECT schedule.scheduleid, schedule.title, medics.name_medic, schedule.scheduledate, schedule.scheduletime, schedule.nop
            FROM schedule
            INNER JOIN medics ON schedule.id_medic = medics.id_medic 
            WHERE schedule.scheduleid = '$id'";
            $result = $database->prepare($sqlmain);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $docname = $row["name_medic"];
            $scheduleid = $row["scheduleid"];
            $title = $row["title"];
            $scheduledate = $row["scheduledate"];
            $formattedDate = date("d-m-Y", strtotime($scheduledate));
            $scheduletime = $row["scheduletime"];
            $nop = $row['nop'];
        
            echo '
            <div id="popup1" class="overlay">
                <div class="popup" style="width: 70%;">
                    <center>
                        <h2></h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                        </div>
                        <div class="abc scroll" style="display: flex;justify-content: center;">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Ver Detalles</p><br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for "name" class="form-label">Nombre Sesión: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">' . $title . '<br><br></td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Email" class="form-label">Doctor de esta sesión: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">' . $docname . '<br><br></td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="nic" class="form-label">Fecha Programada </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">' . $formattedDate . '<br><br></td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Tele" class="form-label">Hora Programada </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">' . $scheduletime . '<br><br></td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label"><b>Paciente registrado para esta sesión:</b></label>
                                        <br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <center>
                                        <div class="abc scroll">
                                            <table width="100%" class="sub-table scrolldown" border="0">
                                            <thead>
                                            <tr>   
                                                <th class="table-headin">ID Paciente</th>
                                                <th class="table-headin">Nombre de Paciente</th>
                                                <th class="table-headin">Número de cita</th>
                                                <th class="table-headin">Teléfono: Paciente</th>
                                            </tr>
                                            </thead>
                                            <tbody>';
            
            // La consulta de pacientes relacionados con esta sesión debe ir aquí
            // Asegúrate de obtener solo los pacientes relacionados con esta sesión
            
            // Ejemplo de consulta para obtener pacientes relacionados:
            $sqlPatients = "SELECT appointment.apponum, patients.id_patient, patients.name, patients.phone
                FROM appointment
                INNER JOIN patients ON patients.id_patient = appointment.patient_id
                WHERE appointment.schedule_id = '$scheduleid'";
            $stmtPatients = $database->prepare($sqlPatients);
            $stmtPatients->execute();
            
            if ($stmtPatients->rowCount() > 0) {
                while ($rowPatient = $stmtPatients->fetch(PDO::FETCH_ASSOC)) {
                    $apponum = $rowPatient["apponum"];
                    $pid = $rowPatient["id_patient"];
                    $pname = $rowPatient["name"];
                    $ptel = $rowPatient["phone"];
                    echo '<tr style="text-align:center;">
                            <td>' . substr($pid, 0, 15) . '</td>
                            <td style="font-weight:600;padding:25px">' . substr($pname, 0, 25) . '</td >
                            <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">' . $apponum . '</td>
                            <td>' . substr($ptel, 0, 25) . '</td>
                        </tr>';
                }
            } else {
                echo '<tr>
                <td colspan="7">
                <br><br><br><br>
                <center>
                <img src="../../img/notfound.svg" width="25%">
                
                <br>
                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">¡No hay paciente registrado para este turno!</p>
                <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Mostrar todos los Turnos &nbsp;</font></button>
                </a>
                </center>
                <br><br><br><br>
                </td>
                </tr>';
            }
            
            echo '</tbody>
                </table>
                </div>
                </center>
                </td>
                </tr>
                </table>
                </div>
                </div>
                </div>';
        }
    }

    ?>
    </div>

</body>

</html>