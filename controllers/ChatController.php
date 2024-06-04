<?php
session_start();
require_once '../config/Database.php';
require_once '../models/Message.php';
require_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

$messageModel = new Message($db);
$userModel = new User($db);

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$currentUser = $userModel->getUserByUsername($_SESSION['username']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pesan'])) {
    $pesan = $_POST['pesan'];

    if (!empty(trim($pesan))) {
        $messageModel->addMessage($currentUser['id'], $pesan);
    }
}

$messages = $messageModel->getMessages();
