<?php
namespace Models;

enum UserRole: string{
    case Admin = 'admin';
    case User = 'user';
}

?>