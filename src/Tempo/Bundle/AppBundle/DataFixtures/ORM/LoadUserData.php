<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tempo\Bundle\AppBundle\Model\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('tempo.manager.user');
        $users = array(
            'admin'           => 'Ad Min',
            'john.doe'        => 'John Doe',
            'brian.lester'    => 'Brian Lester',
            'jack.gill'       => 'Jack Gill',
            'olivia.pace'     => 'Olivia Pace',
            'nola weaver'     => 'Nola Weaver',
            'oren tyler'      => 'Oren Tyler',
            'warren.spencer'  => 'Warren Spencer',
            'jacob.gallegos'  => 'Jacob Gallegos',
            'jordan.saunders' => 'Jordan Saunders',
            'xavier.stein'    => 'Xavier Stein',
            'beck.nash'       => 'Beck Nash',
            'ann.perry'       => 'Ann Perry',
            'chase.hoffman'   => 'Chase Hoffman',
            'gregory.joyner'  => 'Gregory Joyner',
            'dexter.schwartz' => 'Dexter Schwartz'
        );

        foreach ($users as $username => $name) {
            $account = new User();
            $fullName = explode(' ', $name);

            if ($username == 'admin') {
                $account->addRole('ROLE_SUPER_ADMIN');
            }
            $account->setUsername($username);
            $account->setSlug($username);
            $account->setEmail($username. '@test.com');
            $account->setEmailCanonical($username. '@test.com');
            $account->setLastName($fullName[1]);
            $account->setFirstName($fullName[0]);
            $account->setPlainPassword($username);
            $account->addRole(User::ROLE_DEFAULT);
            $account->setEnabled(true);
            $account->setToken(sha1(uniqid(rand(), true)));

            $userManager->save($account);

            $this->addReference($username, $account);
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 10;
    }
}
