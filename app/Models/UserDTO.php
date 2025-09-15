<?php

namespace App\Models;

class UserDTO
{
    public string $user_id;
    public string $username;
    public string $user_group_id;
    public $secondary_group_ids;
    public string $primary_group;

    public static function from_entity(User $entity)
    {
        $user = new UserDTO();

        $user->user_id = $entity->user_id;
        $user->username = $entity->username;
        $user->user_group_id = $entity->user_group_id;
        $user->secondary_group_ids = $entity->secondary_group_ids;

        return $user;
    }
}
