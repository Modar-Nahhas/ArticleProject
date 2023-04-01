<?php

namespace App\Enum;

enum PermissionsEnum: string
{
    case ViewUsers = 'view_users';

    case ViewArticle = 'view_article';
    case AddArticle = 'add_article';
    case EditArticle = 'edit_article';
    case DeleteArticle = 'delete_article';
}
