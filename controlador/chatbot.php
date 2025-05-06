<?php
// chatbot.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents("php://input"), true);
$pregunta = strtolower(trim($data["query"] ?? ""));

$respuesta = "Lo siento, no entendí tu pregunta.";


if (strpos($pregunta, "precio") !== false || strpos($pregunta, "membresía") !== false) {
    $respuesta = "La mensualidad es de $500 MXN. También hay opciones semanales y trimestrales.";
} elseif (strpos($pregunta, "registro") !== false) {
    $respuesta = "Puedes registrarte directamente en recepción o desde nuestra app móvil.";
}

// Responder en formato JSON
echo json_encode(["response" => $respuesta]);
?>