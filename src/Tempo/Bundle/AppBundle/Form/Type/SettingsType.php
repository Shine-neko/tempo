<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locale', 'choice', array(
                'choices'   => array(
                    'fr'   => 'tempo.profile.form.language.french',
                    'en' => 'tempo.profile.form.language.english',
                ),
                'label' => 'tempo.profile.form.locale',
                'required' => true
            ))
            ->add('time_zone', 'choice', array(
            'label'   => 'tempo.profile.form.time_zone',
            'choices' => array(
                -43200 => '(GMT -12:00) Eniwetok, Kwajalein',
                -39600 => '(GMT -11:00) Midway Island, Samoa',
                -36000 => '(GMT -10:00) Hawaii',
                -32400 => '(GMT -9:00) Alaska',
                -28800 => '(GMT -8:00) Pacific Time (US &amp; Canada)',
                -25200 => '(GMT -7:00) Mountain Time (US &amp; Canada)',
                -21600 => '(GMT -6:00) Central Time (US &amp; Canada), Mexico City',
                -18000 => '(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima',
                -14400 => '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz',
                -12600 => '(GMT -3:30) Newfoundland',
                -10800 => '(GMT -3:00) Brazil, Buenos Aires, Georgetown',
                -7200  => '(GMT -2:00) Mid-Atlantic',
                -3600  => '(GMT -1:00) Azores, Cape Verde Islands',
                0      => '(GMT) Western Europe Time, London, Lisbon, Casablanca',
                3600   => '(GMT +1:00) Brussels, Copenhagen, Madrid, Paris',
                7200   => '(GMT +2:00) Kaliningrad, South Africa',
                10800  => '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg',
                12600  => '(GMT +3:30) Tehran',
                14400  => '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi',
                16200  => '(GMT +4:30) Kabul',
                18000  => '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent',
                19800  => '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi',
                14950  => '(GMT +5:45) Kathmandu',
                21600  => '(GMT +6:00) Almaty, Dhaka, Colombo',
                25200  => '(GMT +7:00) Bangkok, Hanoi, Jakarta',
                28800  => '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong',
                32400  => '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk',
                34200  => '(GMT +9:30) Adelaide, Darwin',
                36000  => '(GMT +10:00) Eastern Australia, Guam, Vladivostok',
                39600  => '(GMT +11:00) Magadan, Solomon Islands, New Caledonia',
                43200  => '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka',
            )
        ));
    }

    public function getName()
    {
        return 'setting';
    }
}
