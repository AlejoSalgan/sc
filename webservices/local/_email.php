<?php

    include_once("../../Scripts2015/EnviarMail.php");

    if (!$_GET["p"]) {
        echo "Lo sentimos, SSTI está experimentando problemas de consultas.";
        exit; 
    }
      
    
    $recibidos = $_GET['p'];

    $mail = $recibidos['mail'];
    $subject = $recibidos['subject'];
    $texto = $recibidos['Texto'];


    $text .= "------------------------------------------------------------------<br>";
    // $text .= "Mail : " . $mail  ;

    $text .= "<br>";
    $text .= "Motivo : ";
    $text .= "<br>";
    $text .= $subject  ;

    $text .= "<br>";
    $text .= "Descripción : ";
    $text .= "<br>";
    $text .= $texto  ;
    $text .= "<br>";

    $text .= "------------------------------------------------------------------<br>";


    if(EnviarMail($mail, "mailNotificacion", "Notificaciòn cambio de equipo", $text)){
        echo "enviado";
    };

    
?>