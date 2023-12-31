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
$database = Conexion::conectar();


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

    <title>Pacientes</title>
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
        <td class="menu-btn menu-icon-schedule">
            <a href="schedule.php" class="non-style-link-menu">
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
        <td class="menu-btn menu-icon-patient  menu-active menu-icon-patient-active">
            <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active">
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

                    <form action="" method="post" class="header-search">

                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Búsqueda Nombre de Paciente or Email" list="patient">&nbsp;&nbsp;

                        <?php
                        echo '<datalist id="patient">';
                        $list11 = $database->prepare("select  name,email from patients;");
                        $list11->execute();
                        $num_rows = $list11->rowCount();

                        for ($y = 0; $y < $num_rows; $y++) {
                            $row00 = $list11->fetch(PDO::FETCH_ASSOC);
                            $d = $row00["name"];
                            $c = $row00["email"];
                            echo "<option value='$d'><br/>";
                            echo "<option value='$c'><br/>";
                        };

                        echo ' </datalist>';
                        ?>


                        <input type="Submit" value="Búsqueda" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

                    </form>
                    

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Fecha
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php
                        date_default_timezone_set('America/Argentina/Buenos_Aires');

                        $date = date('d-M-Y');
                        echo $date;
                        ?>
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../../img/calendar.svg" width="100%"></button>
                </td>


            </tr>


            <tr>
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Todos los Pacientes (<?php echo $num_rows; ?>)</p>
                </td>

            </tr>
            <?php
            if ($_POST) {
                $keyword = $_POST["search"];

                $sqlmain = "select * from patients where email='$keyword' or name='$keyword' or name like '$keyword%' or name like '%$keyword' or name like '%$keyword%' ";
            } else {
                $sqlmain = "select * from patients order by id_patient desc";
            }



            ?>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                                <thead>
                                    <tr>
                                        <th class="table-headin">


                                            Nombre

                                        </th>
                                        <th class="table-headin">


                                            DNI

                                        </th>
                                        <th class="table-headin">


                                            Teléfono

                                        </th>
                                        <th class="table-headin">
                                            Email
                                        </th>
                                        <th class="table-headin">

                                            Fecha de Nacimiento

                                        </th>
                                        <th class="table-headin">

                                            Eventos

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php


                                    $result = $database->prepare($sqlmain);
                                    $result->execute();
                                    $num_rows = $result->rowCount();
                                    // var_dump($num_rows);
                                    // exit();

                                    if ($num_rows == 0) {
                                        echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="patient.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Pacientes &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    } else {
                                        for ($x = 0; $x < $num_rows; $x++) {
                                            $row = $result->fetch(PDO::FETCH_ASSOC);
                                            $pid = $row["id_patient"];
                                            $name = $row["name"];
                                            $email = $row["email"];
                                            $dni = $row["dni"];
                                            $surn = $row["surname"];
                                            $tel = $row["phone"];
                                            $birth = $row["day_of_birth"];
                                            if ($birth) {
                                                $formattedBirth = date("d-m-Y", strtotime($birth));
                                            } else {
                                                $formattedBirth = "No Disponible";
                                            }

                                            echo '<tr>
                                            <td> &nbsp;' .
                                                    substr($name, 0, 35)
                                                    . '</td>
                                            <td>
                                            ' . substr($dni, 0, 12) . '
                                            </td>
                                            <td>
                                                ' . substr($tel, 0, 10) . '
                                            </td>
                                            <td>
                                            ' . substr($email, 0, 20) . '
                                            </td>
                                            <td>
                                            ' . substr($formattedBirth, 0, 10) . '
                                            </td>
                                            <td >
                                            <div style="display:flex;justify-content: center;">
                                            
                                            <a href="?action=view&id=' . $pid . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Ver</font></button></a>
                                            </div>
                                            </td>
                                            </tr>';
                                        }
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
        // $sql = "SELECT * FROM patientes WHERE id_patient= $id";
        // $stmt = $database->prepare($sql);
        // $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // $birth = $result["day_of_birth"];
            echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                            <a class="close" href="patient.php">&times;</a>
                            <div class="content">

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
                                        <label for="name" class="form-label">ID Paciente: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        P-' . $id . '<br><br>
                                    </td>
                                    
                                </tr>
                                
                                <tr>
                                    
                                    <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Nombre: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $name . '<br>
                                    </td>
                                    
                                </tr>

                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Email" class="form-label">Correo: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    ' . $email . '<br>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="dni" class="form-label">DNI: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    ' . $dni . '<br>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Tele" class="form-label">Teléfono: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    ' . $tel . '<br>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Fecha de Nacimiento: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $birth . '<br><br>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a href="patient.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                    </td>
                    
                                </tr>

                            </table>
                            </div>
                        </center>
                        <br><br>
                </div>
                </div>
                ';
        //};
    }
    ?>
    </div>

</body>

</html>