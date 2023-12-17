<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

class UserInfo
{
    public BranchInfo $userBranch;
    public string $userLogin;
    public string $userName;
}
