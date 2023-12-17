<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use App\Model\Ejournal\Dicts\Branch;

class UserRepository
{
    public function getUserInfo(): UserInfo
    {
//      On full version:
//      $user = \Illuminate\Support\Facades\Auth::user();
//      $companyName = $user->ldap->getFirstAttribute('company');
//      $this->userInfo->userLogin  = $user->name;
        $userInfo = new UserInfo();
        $userInfo->userLogin = $this->getUserLogin();
        $userInfo->userName = $this->getUserName();
        $userInfo->userBranch = $this->branchInfoFromLoginPrefix($userInfo->userLogin);
        return $userInfo;
    }

    public function getUserLogin(): string
    {
        /**
         *    on full version
         *    $this->userLogin  = Auth::user()->name;
         *    return Auth::user()->name;
         */
        return 'kl_demouser';
    }

    public function getUserName(): string
    {
        /**
         * ПІБ зареєстрованого юзера
         * on full version
         * return Auth::user()->ldap->getFirstAttribute('displayName');
         */
        return 'Demo User';
    }

    public static function branchInfoFromLoginPrefix(string $userlogin): BranchInfo
    {
        $result = new BranchInfo();
        $tmp = Branch::
        where('prefix', 'like', '%' . substr($userlogin, 0, 3) . '%')
            ->get()
            ->first();
        $result->id = $tmp->id;
        $result->body = $tmp->body;
        return $result;
    }


}
