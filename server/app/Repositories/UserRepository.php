<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    public function getUserData($id)
    {
        return $this->_user->getDataById($id);
    }

    public function softDeleteById($id)
    {
        return $this->_user->softDeleteById($id);
    }

    public function upsertData($upsertData)
    {
        return $this->_user->upsertData($upsertData, ['id']);
    }
}
