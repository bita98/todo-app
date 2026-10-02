<?php

require_once "db.php";

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$title = trim($_POST["title"] ?? "");

if (!$id || $title === "") {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("UPDATE todos SET title = ? WHERE id = ?");
$stmt->bind_param("si", $title, $id);
$stmt->execute();

header("Location: index.php?status=updated");
exit;