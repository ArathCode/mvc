<?php
// chatbot.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents("php://input"), true);
$pregunta = strtolower(trim($data["query"] ?? ""));

$respuesta = "Lo siento, no entendí tu pregunta.";

if (strpos($pregunta, "horario") !== false) {
    $respuesta = "Nuestro horario es de lunes a sábado de 6 AM a 10 PM.";
} elseif (strpos($pregunta, "precio") !== false || strpos($pregunta, "membresía") !== false) {
    $respuesta = "La mensualidad es de $500 MXN. También hay opciones semanales y trimestrales.";
} elseif (strpos($pregunta, "registro") !== false) {
    $respuesta = "Puedes registrarte directamente en recepción ";
} elseif (strpos($pregunta, "dónde están") !== false || strpos($pregunta, "ubicación") !== false || strpos($pregunta, "dirección") !== false) {
    $respuesta = "Estamos ubicados en Calle Ejemplo #123, Colonia Centro. ¡Te esperamos!";
} elseif (strpos($pregunta, "qué es dragon gym") !== false || strpos($pregunta, "quiénes son") !== false) {
    $respuesta = "Dragon Gym es un gimnasio completo con áreas de pesas, clases funcionales, boxeo y más.";
}
 elseif (strpos($pregunta, "clases") !== false || strpos($pregunta, "qué clases hay") !== false) {
    $respuesta = "Tenemos clases de box, funcional, y entrenamiento personalizado.";
} elseif (strpos($pregunta, "horario de box") !== false) {
    $respuesta = "Las clases de box son de lunes a viernes a las 7:00 p.m.";
} elseif (strpos($pregunta, "entrenador") !== false || strpos($pregunta, "entrenadores") !== false) {
    $respuesta = "Contamos con entrenadores certificados para ayudarte en tu rutina y objetivos.";
} elseif (strpos($pregunta, "regadera") !== false || strpos($pregunta, "baño") !== false) {
    $respuesta = "Sí, contamos con regaderas y baños para hombres y mujeres.";
} elseif (strpos($pregunta, "ayuda") !== false || strpos($pregunta, "soporte") !== false) {
    $respuesta = "Puedes hablar con el personal en recepción o escribirnos por WhatsApp para atención directa.";
}

// Responder en formato JSON
echo json_encode(["respuesta" => $respuesta]);
?>