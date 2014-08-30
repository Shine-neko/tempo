<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;


use Tempo\Bundle\ProjectBundle\Entity\ActivityProvider;

class LoadActivityProviderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<5; $i++) {

            $activity = (new ActivityProvider())
                ->setProvider($this->getReference('project_privider_'.$i))
                ->setMessage('')
                ->setParameters('s:2615:"{"ref":"refs/heads/master","after":"784960f0558dc6ea859c3829f176af75750b0390","before":"6a30fde12fcd877959f133658db17dd3445d805e","created":false,"deleted":false,"forced":false,"compare":"https://github.com/tempo-project/hooks/compare/6a30fde12fcd...784960f0558d","commits":[{"id":"966ff06d10b4b28b64c5ef68bfcc2e042395d341","distinct":true,"message":"Update README.md","timestamp":"2013-11-19T06:58:49-08:00","url":"https://github.com/tempo-project/hooks/commit/966ff06d10b4b28b64c5ef68bfcc2e042395d341","author":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"committer":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"added":[],"removed":[],"modified":["README.md"]},{"id":"37031c6cdc20a4e675fd154eb8e5f0563e3e3e62","distinct":true,"message":"Update README.md","timestamp":"2013-11-19T07:02:47-08:00","url":"https://github.com/tempo-project/hooks/commit/37031c6cdc20a4e675fd154eb8e5f0563e3e3e62","author":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"committer":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"added":[],"removed":[],"modified":["README.md"]},{"id":"784960f0558dc6ea859c3829f176af75750b0390","distinct":true,"message":"test","timestamp":"2013-11-19T07:49:16-08:00","url":"https://github.com/tempo-project/hooks/commit/784960f0558dc6ea859c3829f176af75750b0390","author":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"committer":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"added":["test.txt"],"removed":[],"modified":[]}],"head_commit":{"id":"784960f0558dc6ea859c3829f176af75750b0390","distinct":true,"message":"test","timestamp":"2013-11-19T07:49:16-08:00","url":"https://github.com/tempo-project/hooks/commit/784960f0558dc6ea859c3829f176af75750b0390","author":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"committer":{"name":"Mbechezi Mlanawo","email":"mlanawo.mbechezi@ikimea.com","username":"Shine-neko"},"added":["test.txt"],"removed":[],"modified":[]},"repository":{"id":14027115,"name":"hooks","url":"https://github.com/tempo-project/hooks","description":"","watchers":0,"stargazers":0,"forks":0,"fork":false,"size":168,"owner":{"name":"tempo-project","email":null},"private":false,"open_issues":1,"has_issues":true,"has_downloads":true,"has_wiki":true,"created_at":1383249893,"pushed_at":1384876169,"master_branch":"master","organization":"tempo-project"},"pusher":{"name":"none"}}";')
                ->setCreatedAt(new \DateTime());

            $manager->persist($activity);
            $this->addReference('activity_'.$i, $activity);
        }

        $activity = (new ActivityProvider())
            ->setProvider($this->getReference('project_privider_6'))
            ->setMessage('Build 1 of tempo-project/tempo Passed in 0 min 26 sec')
            ->setCreatedAt(new \DateTime())
            ->setParameters('a:20:{s:2:"id";i:1;s:6:"number";s:1:"1";s:6:"status";N;s:10:"started_at";N;s:11:"finished_at";N;s:14:"status_message";s:6:"Passed";s:6:"commit";s:20:"62aae5f70ceee39123ef";s:6:"branch";s:6:"master";s:7:"message";s:18:"the commit message";s:11:"compare_url";s:63:"https://github.com/tempo-project/tempo/compare/master...develop";s:12:"committed_at";s:22:"2011-11-11T11: 11: 11Z";s:14:"committer_name";s:16:"Mlanawo MBECHEZI";s:15:"committer_email";s:27:"mlanawo.mbechezi@ikimea.com";s:11:"author_name";s:22:"Mlanawo MBECHEZI Fuchs";s:12:"author_email";s:27:"mlanawo.mbechezi@ikimea.com";s:4:"type";s:4:"push";s:9:"build_url";s:52:"https://travis-ci.org/tempo-project/project/builds/1";s:10:"repository";O:8:"stdClass":4:{s:2:"id";i:1;s:4:"name";s:5:"tempo";s:10:"owner_name";s:13:"tempo-project";s:3:"url";s:37:"http://github.com/tempo-project/tempo";}s:6:"config";O:8:"stdClass":1:{s:13:"notifications";O:8:"stdClass":1:{s:8:"webhooks";a:2:{i:0;s:29:"http://evome.fr/notifications";i:1;s:19:"http://example.com/";}}}s:6:"matrix";a:1:{i:0;O:8:"stdClass":20:{s:2:"id";i:2;s:13:"repository_id";i:1;s:6:"number";s:3:"1.1";s:5:"state";s:7:"created";s:10:"started_at";N;s:11:"finished_at";N;s:6:"config";O:8:"stdClass":1:{s:13:"notifications";O:8:"stdClass":1:{s:8:"webhooks";a:2:{i:0;s:29:"http://evome.fr/notifications";i:1;s:19:"http://example.com/";}}}s:6:"status";N;s:3:"log";s:0:"";s:6:"result";N;s:9:"parent_id";i:1;s:6:"commit";s:20:"62aae5f70ceee39123ef";s:6:"branch";s:6:"master";s:7:"message";s:18:"the commit message";s:12:"committed_at";s:22:"2011-11-11T11: 11: 11Z";s:14:"committer_name";s:16:"Mlanawo MBECHEZI";s:15:"committer_email";s:27:"mlanawo.mbechezi@ikimea.com";s:11:"author_name";s:16:"Mlanawo MBECHEZI";s:12:"author_email";s:27:"mlanawo.mbechezi@ikimea.com";s:11:"compare_url";s:61:"https://github.com/svenfuchs/minimal/compare/master...develop";}}}');

        $manager->persist($activity);
        $manager->flush();

    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 70;
    }
}
