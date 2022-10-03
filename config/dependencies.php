<?php
declare(strict_types=1);

use App\Application\Manager\CreatePostManager;
use App\Application\Manager\GetPostManager;
use App\Application\Manager\LoginManager;
use App\Application\Manager\SearchPostManager;
use App\Application\Manager\SearchUserByEmailManager;
use App\Application\Manager\SearchUserManager;
use App\Application\Manager\UpdatePostManager;
use App\Application\Manager\UpdateUserManager;
use App\Application\Service\JWTService;
use App\Application\Service\PasswordValidator;
use App\Application\Translator\UserTranslator;
use App\Infrastructure\Console\CreateUserCommand;
use App\Domain\Repository\UserRepositoryInterface;
use App\Application\Manager\CreateUserManager;
use App\Infrastructure\Controller\CreatePostController;
use App\Infrastructure\Controller\CreateUserController;
use App\Infrastructure\Controller\GetPostController;
use App\Infrastructure\Controller\LoginController;
use App\Infrastructure\Controller\SearchPostController;
use App\Infrastructure\Controller\SearchUserByEmailController;
use App\Infrastructure\Controller\SearchUserController;
use App\Infrastructure\Controller\UpdatePostController;
use App\Infrastructure\Controller\UpdateUserController;
use App\Infrastructure\Middleware\AuthorizationMiddleware;
use App\Infrastructure\Middleware\RequestMiddleware;
use App\Infrastructure\Repository\PostRepository;
use App\Infrastructure\Repository\UserRepository;
use DI\Container;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/** @var Container $container */
$container->set('errorHandler', function ($container) {
    return function (
        ServerRequestInterface $request,
        Throwable              $exception,
    ) {

        $statusCode = $exception->getCode() < 100 || $exception->getCode() >500 ? 500 : $exception->getCode();

        $response = new JsonResponse(
            [
                "error" => $exception->getMessage(),
                "code" => $exception->getCode(),
            ],
            $statusCode
        );

        return $response;
    };
});

$container->set(AuthorizationMiddleware::class, static function (ContainerInterface $container): AuthorizationMiddleware
{
    return new AuthorizationMiddleware(
        $container->get(JWTService::class)
    );
});

$container->set(RequestMiddleware::class, static function (ContainerInterface $container): RequestMiddleware
{
    return new RequestMiddleware(
        $container->get(JWTService::class)
    );
});

$container->set(EntityManager::class, static function (Container $c): EntityManagerInterface {
    /** @var array $settings */
    $settings = $c->get('settings');

    Type::addType('uuid', \Ramsey\Uuid\Doctrine\UuidType::class);


    // Use the ArrayAdapter or the FilesystemAdapter depending on the value of the 'dev_mode' setting
    // You can substitute the FilesystemAdapter for any other cache you prefer from the symfony/cache library
    $cache = $settings['doctrine']['dev_mode'] ?
        DoctrineProvider::wrap(new ArrayAdapter()) :
        DoctrineProvider::wrap(new FilesystemAdapter(directory: $settings['doctrine']['cache_dir']));

    $config = Setup::createAttributeMetadataConfiguration(
        $settings['doctrine']['metadata_dirs'],
        $settings['doctrine']['dev_mode'],
        null,
        $cache
    );

    return EntityManager::create($settings['doctrine']['connection'], $config);
});

$container->set(Serializer::class, static function (Container $c): SerializerInterface {
    $extractor = new PropertyInfoExtractor([], [new ReflectionExtractor()]);

    $encoders = [new JsonEncoder()];
    $normalizers = [new ObjectNormalizer(null, null, null, $extractor)];

    return new Serializer($normalizers, $encoders);
});


$container->set(UserRepository::class, static function (Container $container): UserRepositoryInterface {
    return new UserRepository(
        $container->get(EntityManager::class)
    );
});

$container->set(CreateUserManager::class, static function (Container $container): CreateUserManager {
    return new CreateUserManager(
        $container->get(UserRepository::class),
        $container->get(UserTranslator::class),
        $container->get(PasswordValidator::class),
    );
});

$container->set(PasswordValidator::class, static function (Container $container): PasswordValidator {
    return new PasswordValidator();
});

$container->set(LoginController::class, static function (Container $container): LoginController {
    return new LoginController(
        $container->get(LoginManager::class)
    );
});

$container->set(JWTService::class, static function (Container $container): JWTService {
    return new JWTService(
        $container->get('settings')['jwt']['key'],
        $container->get('settings')['jwt']['algorithm']
    );
});

$container->set(LoginManager::class, static function (Container $container): LoginManager {
    return new LoginManager(
        $container->get(UserRepository::class),
        $container->get(JWTService::class)
    );
});

$container->set(CreateUserCommand::class, static function (Container $container): Command {
    return new CreateUserCommand(
        $container->get(CreateUserManager::class)
    );
});

$container->set(CreateUserController::class, static function (Container $container): CreateUserController {
    return new CreateUserController(
        $container->get(CreateUserManager::class),
        $container->get(Serializer::class),
    );
});

$container->set(SearchUserController::class, static function (Container $container): SearchUserController {
    return new SearchUserController(
        $container->get(SearchUserManager::class),
    );
});

$container->set(SearchUserManager::class, static function (Container $container): SearchUserManager {
    return new SearchUserManager(
        $container->get(UserRepository::class),
        $container->get(UserTranslator::class),
    );
});

$container->set(UserTranslator::class, static function (Container $container): UserTranslator {
    return new UserTranslator();
});

$container->set(SearchUserByEmailManager::class, static function (Container $container): SearchUserByEmailManager {
    return new SearchUserByEmailManager(
        $container->get(UserRepository::class),
        $container->get(UserTranslator::class),
    );
});

$container->set(SearchUserByEmailController::class, static function (Container $container): SearchUserByEmailController {
    return new SearchUserByEmailController(
        $container->get(SearchUserByEmailManager::class),
    );
});

$container->set(UpdateUserController::class, static function (Container $container): UpdateUserController {
    return new UpdateUserController(
        $container->get(UpdateUserManager::class),
        $container->get(Serializer::class),
    );
});

$container->set(UpdateUserManager::class, static function (Container $container): UpdateUserManager {
    return new UpdateUserManager(
        $container->get(UserRepository::class),
        $container->get(UserTranslator::class),
    );
});

$container->set(PostRepository::class, static function (Container $container): PostRepository {
    return new PostRepository(
        $container->get(EntityManager::class),
    );
});

$container->set(CreatePostManager::class, static function (Container $container): CreatePostManager {
    return new CreatePostManager(
        $container->get(PostRepository::class),
    );
});

$container->set(CreatePostController::class, static function (Container $container): CreatePostController {
    return new CreatePostController(
        $container->get(CreatePostManager::class),
    );
});

$container->set(GetPostManager::class, static function (Container $container): GetPostManager {
    return new GetPostManager(
        $container->get(PostRepository::class),
    );
});

$container->set(GetPostController::class, static function (Container $container): GetPostController {
    return new GetPostController(
        $container->get(GetPostManager::class),
    );
});

$container->set(UpdatePostManager::class, static function (Container $container): UpdatePostManager {
    return new UpdatePostManager(
        $container->get(PostRepository::class),
    );
});

$container->set(UpdatePostController::class, static function (Container $container): UpdatePostController {
    return new UpdatePostController(
        $container->get(UpdatePostManager::class),
    );
});


$container->set(SearchPostController::class, static function (Container $container): SearchPostController {
    return new SearchPostController(
        $container->get(SearchPostManager::class),
    );
});

$container->set(SearchPostManager::class, static function (Container $container): SearchPostManager {
    return new SearchPostManager(
        $container->get(PostRepository::class),
    );
});