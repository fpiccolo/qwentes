<?php
declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Application\DTO\Input\CreateUserInput;
use App\Application\Manager\CreateUserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    private CreateUserManager $createUserManager;

    public function __construct(CreateUserManager $createUserManager)
    {
        parent::__construct(null);
        $this->createUserManager = $createUserManager;
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setName('user:create');
        $this->setDescription('A sample command');

        $this
            ->addArgument('givenName', InputArgument::REQUIRED, 'User password')
            ->addArgument('familyName', InputArgument::REQUIRED, 'User password')
            ->addArgument('email', InputArgument::REQUIRED, 'User password')
            ->addArgument('password', InputArgument::REQUIRED, 'User password');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $input = new CreateUserInput(
            $input->getArgument('givenName'),
            $input->getArgument('familyName'),
            $input->getArgument('email'),
            null,
            $input->getArgument('password'),
            null
        );

        $outputDto = $this->createUserManager->createUser($input);

        $output->writeln("<info>User $outputDto->email created</info>");

        // The error code, 0 on success
        return 0;
    }
}