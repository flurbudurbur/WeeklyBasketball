<?php
session_start();
header('Content-Type: application/json');
require_once '../DB/_conn.php';
require_once './voting.class.php';
$json = json_decode(file_get_contents('php://input'), true);

// echo json_encode($json);

$userId = $json['user'];
$postId = $json['id'];
$vote = $json['likes'];

$voting = new voting();
$voting->execute($userId, $postId);

?>