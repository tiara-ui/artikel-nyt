<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function hasRole($role)
{
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function requireRole($role, $redirectTo = '../index.php')
{
    if (!isLoggedIn() || !hasRole($role)) {
        header('Location: ' . $redirectTo);
        exit();
    }
}

function logout()
{
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit();
}

function getCurrentUser()
{
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role']
        ];
    }
    return null;
}
