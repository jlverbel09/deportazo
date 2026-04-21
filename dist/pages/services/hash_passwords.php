<?php
require_once '../conexion.php';

// Script to hash existing plain text passwords
try {
    // Get all users
    $stmt = $conexion->query("SELECT id, password FROM usuario");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
        $updateStmt = $conexion->prepare("UPDATE usuario SET password = ? WHERE id = ?");
        $updateStmt->execute([$hashedPassword, $user['id']]);
        echo "Updated password for user ID: " . $user['id'] . "\n";
    }

    echo "All passwords have been hashed successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>