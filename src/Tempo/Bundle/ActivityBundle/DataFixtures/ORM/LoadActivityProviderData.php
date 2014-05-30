<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;


use Tempo\Bundle\ActivityBundle\Entity\ActivityProvider;

class LoadActivityProviderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<5; $i++) {

            $activity = new ActivityProvider();
            $activity->setProvider($this->getReference('project_privider_'.$i));
            $activity->setMessage('provider.github.commit');
            $activity->setParameters(unserialize('s:2615:"{"ref":"refs/heads/master","after":"784960f0558dc6ea859c3829f176af75750b0390","before":"6a30fde12fcd877959f133658db17dd3445d805e","created":false,"deleted":false,"forced":false,"compare":"https://github.com/tempo-project/hooks/compare/6a30fde12fcd...784960f0558d","commits":[{"id":"966ff06d10b4b28b64c5ef68bfcc2e042395d341","distinct":true,"message":"Update README.md","timestamp":"2013-11-19T06:58:49-08:00","url":"https://github.com/tempo-project/hooks/commit/966ff06d10b4b28b64c5ef68bfcc2e042395d341","author":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"committer":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"added":[],"removed":[],"modified":["README.md"]},{"id":"37031c6cdc20a4e675fd154eb8e5f0563e3e3e62","distinct":true,"message":"Update README.md","timestamp":"2013-11-19T07:02:47-08:00","url":"https://github.com/tempo-project/hooks/commit/37031c6cdc20a4e675fd154eb8e5f0563e3e3e62","author":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"committer":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"added":[],"removed":[],"modified":["README.md"]},{"id":"784960f0558dc6ea859c3829f176af75750b0390","distinct":true,"message":"test","timestamp":"2013-11-19T07:49:16-08:00","url":"https://github.com/tempo-project/hooks/commit/784960f0558dc6ea859c3829f176af75750b0390","author":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"committer":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"added":["test.txt"],"removed":[],"modified":[]}],"head_commit":{"id":"784960f0558dc6ea859c3829f176af75750b0390","distinct":true,"message":"test","timestamp":"2013-11-19T07:49:16-08:00","url":"https://github.com/tempo-project/hooks/commit/784960f0558dc6ea859c3829f176af75750b0390","author":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"committer":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"added":["test.txt"],"removed":[],"modified":[]},"repository":{"id":14027115,"name":"hooks","url":"https://github.com/tempo-project/hooks","description":"","watchers":0,"stargazers":0,"forks":0,"fork":false,"size":168,"owner":{"name":"tempo-project","email":null},"private":false,"open_issues":1,"has_issues":true,"has_downloads":true,"has_wiki":true,"created_at":1383249893,"pushed_at":1384876169,"master_branch":"master","organization":"tempo-project"},"pusher":{"name":"none"}}";'));
            $activity->setCreatedAt(new \DateTime('now'));
            $manager->persist($activity);
            $manager->flush();

            $this->addReference('activity_'.$i, $activity);
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 70;
    }
}
