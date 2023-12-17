<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal;

use App\Http\Controllers\Controller;
use App\Model\User\Entity\BranchInfo;
use App\Model\User\Entity\UserInfo;
use App\Model\User\Entity\UserRepository;


class BaseController extends Controller
{
    public UserInfo $currentUser;
    protected BranchInfo $branch;
    public UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->currentUser = $this->userRepository->getUserInfo();
        $this->branch = $this->currentUser->userBranch;
    }

    public function getBranchInfo(): BranchInfo
    {
        return $this->branch;
    }
}
