<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $category = trim($_POST["category"]);

    $imageName = basename($_FILES["image"]["name"]);
    $targetDir = "uploads/";
    $targetFile = $targetDir . $imageName;
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO perfumes (name, description, category, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $description, $category, $imageName);

        if ($stmt->execute()) {
            echo "Perfume added successfully! <a href='admin.php'>Go Back</a>";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Image upload failed.";
    }
}
?>
