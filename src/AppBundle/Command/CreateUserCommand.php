<?php
namespace AppBundle\Command;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Tests\Encoder\EncoderFactoryTest;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dispatcher:user:create')
            ->setDescription('Create user')
            ->addOption(
                'username',
                'u',
                InputOption::VALUE_REQUIRED,
                'Username'
            )
            ->addOption(
                'email',
                'em',
                InputOption::VALUE_REQUIRED,
                'E-mail address'
            )
            ->addOption(
                'password',
                'p',
                InputOption::VALUE_REQUIRED,
                'Password'
            );
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /**
         * @var $cnt ContainerInterface
         */
        $cnt = $this->getContainer();


        $userEntity = new User();
        /**
         * @var $encoder PasswordEncoderInterface
         */
        $encoder = $cnt->get('security.encoder_factory')->getEncoder($userEntity);
        try {
            $userEntity->setUsername($input->getOption('username'));
            $userEntity->setEmail($input->getOption('email'));
            $userEntity->setPassword($encoder->encodePassword($input->getOption('password'), $userEntity->getSalt()));
            $userEntity->setActive(true);
            /**
             * @var $em EntityManager
             */
            $em = $cnt->get('doctrine.orm.entity_manager');
            $em->persist($userEntity);
            $em->flush();
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
        }
        $output->writeln('USER CREATED!');
    }
}