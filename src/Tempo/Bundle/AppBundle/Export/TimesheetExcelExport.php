<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Export;

class TimesheetExcelExport
{
    protected $filename;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function save($dir)
    {
        $phpExcel = new \PHPExcel();

        $phpExcel->getDefaultStyle()->getFont()->setName('Arial')
            ->setSize(10);

        $style = array(
            'font' => array(
                'color' =>  array('rgb' => 'ffffff'),
                'bold' => true,
            ),
            'fill' =>  array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '005782',
                ),
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $phpExcel->getActiveSheet()
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'date')
            ->setCellValue('C1', 'worklog état')
            ->setCellValue('D1', 'action')
            ->setCellValue('E1', 'durée')
            ->setCellValue('F1', 'coût');

        $phpExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($style);

        $i = 2;
        foreach ($this->data['projects'] as $project) {
            $phpExcel->getActiveSheet()->setCellValue('B'.$i, $project['name']);
            $i++;

            foreach( $project['cras'] as $time ) {
                if(isset($time['list'])) {
                    foreach($time['list'] as $item) {
                        $phpExcel->getActiveSheet()->setCellValue('A'.$i, $item->getId());
                        $phpExcel->getActiveSheet()->setCellValue('B'.$i, $item->getPeriod()->format('Y-m-d'));
                        $phpExcel->getActiveSheet()->setCellValue('C'.$i, $item->getBillable());
                        $phpExcel->getActiveSheet()->setCellValue('D'.$i, $item->getDescription());
                        $phpExcel->getActiveSheet()->setCellValue('E'.$i, $item->getTime(). 'H');
                        $phpExcel->getActiveSheet()->setCellValue('F'.$i, "0");
                        $i++;
                    }
                }
            }
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');

        $file = $dir . uniqid('export_cra'). '.xls';

        $objWriter->save($file);

        return $file;
    }
}
