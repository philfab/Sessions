<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=Sessions', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pseudo = 'phil_admin';
    $email = 'phil_admin@gmail.com';
    $password = 'philadmin';
    $roles = 'ROLE_ADMIN';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $req = $pdo->prepare("INSERT INTO user (pseudo, email, password, roles) VALUES (:pseudo, :email, :password, :roles)");
    $req->bindParam(':pseudo', $pseudo);
    $req->bindParam(':email', $email);
    $req->bindParam(':password', $hashedPassword);
    $req->bindParam(':roles', $roles);

    $req->execute();

    echo "Admin créé !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
