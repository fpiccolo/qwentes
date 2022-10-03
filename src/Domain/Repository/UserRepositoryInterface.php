<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user);

    public function getByUsernameAndPassword(string $email, string $password): ?User;

    public function searchUser(int $page, int $itemPerPage, array $emails, array $countryCodes, array $sorts): array;

    public function findUserByEmail(string $email);
}