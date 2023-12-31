<?php

    session_start();

    if (isset($_SESSION["usr_rol"])) {
        if (($_SESSION["usr_rol"]) == "" or $_SESSION['usr_rol'] != '2') {
            header("location: ../vistas/login/login.php");
        } else {
            $useremail = $_SESSION["email_medic"];
        }
    } else {
        header("location: ../vistas/login/login.php");
    }

    //import link
    include("../modelos/conexion.php");
    $database = Conexion::conectar();

    $sql = "select * from medics where email_medic ='$useremail'";
    // Prepara la consulta SQL
    $stmt = $database->prepare($sql);
    $stmt->bindParam(1, $useremail, PDO::PARAM_STR);

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
            FROM schedule 
            INNER JOIN appointment 
            ON schedule.scheduleid=appointment.schedule_id
            INNER JOIN patients 
            ON patients.id_patient=appointment.patient_id
            INNER JOIN medics
            ON schedule.id_medic=medics.id_medic 
            WHERE  medics.id_medic= '$userid' ";
            $sqlmain .= " ORDER BY schedule.scheduledate DESC";
// var_dump($userid);
// exit();
    //Prepara la consulta

    $stmt = $database->prepare($sqlmain);
    $stmt->execute(); 
    $num_rows = $stmt->rowCount();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($num_rows);
    // exit();

if ($_POST) {
    //print_r($_POST);

    if (!empty($_POST["sheduledate"])) {
        $sheduledate = $_POST["sheduledate"];
        $sqlmain .= " and schedule.scheduledate='$sheduledate' ";
    };
        //echo $sqlmain;
        $pdo = $database->prepare($sqlmain);
        $pdo->execute();
        // var_dump($result);
        // exit();
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
                                    <p class="profile-title"><?php echo substr($username, 0, 13)  ?>..</p>
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
                    <td class="menu-btn menu-icon-dashbord ">
                        <a href="index.php" class="non-style-link-menu ">
                            <div>
                                <p class="menu-text">Inicio</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment  menu-active menu-icon-appoinment-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active">
                            <div>
                                <p class="menu-text">Mis Citas</p>
                            </div>
                        </a>
                    </td>
                </tr>

                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Mis Sesiones</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Mis Pacientes</p>
                        </a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Configuración</p>
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
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Administrador de Citas</p>

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Fecha
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php

                        date_default_timezone_set('America/Argenitina/Buenos_Aires');

                        $today = date('d-M-Y');
                        echo $today;
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
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Mis Citas (<?php echo $num_rows; ?>)</p>
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
                        <!-- <thead>
                            <tr>
                                <th class="table-headin">
                                    Nombre de Paciente
                                </th>

                                <th class="table-headin">
                                    Número de cita
                                </th>

                                <th class="table-headin">
                                    Nombre Sesión
                                </th>

                                <th class="table-headin">
                                    Fecha y hora de la sesión
                                </th>

                                <th class="table-headin">
                                    Eventos
                                </th>
                            </tr>
                        </thead> -->


                    <tbody>
                    <?php

                    $stmt = $database->prepare($sqlmain);
                    $stmt->execute(); 
                    $num_rows = $stmt->rowCount();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                

                    if ($num_rows == 0) {
                        echo '<tr>
                        <td colspan="7">
                        <br><br><br><br>
                        <center>
                        <img src="../../img/notfound.svg" width="25%">

                        <br>
                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">¡No pudimos encontrar nada relacionado con sus palabras clave!</p>
                        <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Mostrar todas las citas &nbsp;</font></button>
                        </a>
                        </center>
                        <br><br><br><br>
                        </td>
                        </tr>';
                    } elseif($result === false)
                        {
                            echo 'ERROR';
                        }
                        else
                        {
                            // var_dump($num_rows);
                            // exit();
                            $fecha_actual = date("d-m-Y"); // Obtener la fecha actual en el formato Y-m-d

                            echo "<table>"; // Abre la tabla
                            foreach ($result as $row) {
                                $scheduledate = isset($row["scheduledate"]) ? $row["scheduledate"] : '';
                                $formattedDate = date("d-m-Y", strtotime($scheduledate));
                            
                                echo "<tr>"; // Abre una fila
                                echo "<td style='width: 25%;'>"; // Abre una celda
                            
                                echo "<div class='dashboard-items search-items'>";
                                echo "<div style='width:100%;'>";
                                echo "<div class='h3-search'>Nombre del Paciente: " . substr($row["name"], 0, 30) . "<br>";
                                echo "Número de Reserva: OC-000-" . $row["appointment_id"] . "</div>";
                                echo "<div class='h1-search'>" . substr($row["title"], 0, 21) . "<br></div>";
                                echo "<div class='h3-search'>Número de Reserva:<div class='h1-search'>0" . $row["apponum"] . "</div></div>";
                                echo "<div class='h4-search'>Fecha y Hora del Turno: " . $formattedDate . "<br>Inicio: <b>" . substr($row["scheduletime"], 0, 5) . "</b><strong>hs</strong>.</div><br>";
                            
                                echo "<input type='hidden' name='action' value='drop'>";
                                echo "<input type='hidden' name='id' value='" . $row["appointment_id"] . "'>";
                                echo "<input type='hidden' name='scheduleid' value='" . $row["scheduleid"] . "'>";
                                echo "<input type='hidden' name='title' value='" . $row["title"] . "'>";
                                echo "<input type='hidden' name='doc' value='" . $row["name_medic"] . "'>";
                            
                                if ($formattedDate < $fecha_actual) {
                                    // Si la fecha de la reserva es menor que la fecha actual, muestra "Cita Finalizada" sin enlace
                                    echo "<button type='button' class='login-btn btn-disabled' style='padding-top:11px;padding-bottom:11px;width:100%'>";
                                    echo "<font class='tn-in-text'><strong>CITA FINALIZADA</strong></font>";
                                    echo "</button>";
                                } else {
                                    // Si la fecha de la reserva es mayor o igual a la fecha actual, muestra el botón "Cancelar Turno" con el enlace para eliminar
                                    echo "<a href='?action=drop&id=" . $row["appointment_id"] . "&scheduleid=" . $row["scheduleid"] . "&name=" . $row["name"] . "&session=" . $row["title"] . "&apponum=" . $row["apponum"] . "'>";
                                    echo "<button type='submit' class='login-btn btn-primary-soft btn' style='padding-top:11px;padding-bottom:11px;width:100%'>";
                                    echo "<font class='tn-in-text'>Cancelar Turno</font>";
                                    echo "</button>";
                                    echo "</a>";
                                }
                                echo "</div>";
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</table>"; // Cierra la tabla
                            
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
        $action = $_GET["action"];
        $id = $_GET["id"];
        if ($action == 'drop') {
            $id = $_GET["id"];
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
        }
    }

    ?>
    </div>

</body>

</html>