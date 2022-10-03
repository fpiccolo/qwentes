<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\User;
use Cake\Chronos\Chronos;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{

    private string $key;
    private string $algorithm;

    public function __construct(
        string $key,
        string $algorithm,
    )
    {
        $this->key = $key;
        $this->algorithm = $algorithm;
    }

    public function createJWT(User $user): string
    {
        $payload = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'given_name' => $user->getGivenName(),
            'family_name' => $user->getFamilyName(),
            'exp' => Chronos::now()->addMinute(60)->toUnixString(),
            'iat' => Chronos::now()->toUnixString(),
        ];

        return JWT::encode(
            $payload,
            $this->key,
            $this->algorithm
        );
    }

    public function validate(string $token)
    {

        try {
            JWT::decode($token, new Key($this->key, $this->algorithm));
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage(), 500);
        }
    }
}