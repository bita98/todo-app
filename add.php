<?php

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$title = trim($_POST["title"] ?? "");

if ($title === "") {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("INSERT INTO todos (title) VALUES (?)");
$stmt->bind_param("s", $title);
$stmt->execute();

header("Location: index.php?status=added");
exit;