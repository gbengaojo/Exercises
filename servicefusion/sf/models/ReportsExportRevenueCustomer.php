<?php
/*---------------------------------------------------------
Class: ReportsExportRevenueCustomer for generating Excel
       files for the Reports > Sales Revenue > Sales By
       Customer.
       http://timelist.com/task/575/2215/44705
Author: Gbenga Ojo <gbenga@servicefusion.com>
Origin Date: December 30, 2015
Modified: December 30, 2015
----------------------------------------------------------*/
class ReportsExportRevenueCustomer extends ReportsExport
{
    private $start_date;
    private $end_date;

    /**
     * construct
     *
     * @param: (array) $param holding some necessary values from
     *         the controller
     */
    public function __construct($params) {
        parent::__construct($params);

        $this->start_date = htmlspecialchars($this->auxiliary['post']['start_date']);
        $this->end_date   = htmlspecialchars($this->auxiliary['post']['end_date']);
        $this->generateExcelHeader();
        $this->calculateData();
        $this->writeExcelFile();
    }

    /**
     * calculate data specific to this report
     */
    public function calculateData() {
        // Report title
        $this->obj->getActiveSheet()->mergeCells('A4:H4');
        $this->obj->setActiveSheetIndex(0)->setCellValue('A4', "Sales By Customer Report");
        $this->obj->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true);
        $this->obj->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Date
        $this->obj->getActiveSheet()->mergeCells('A5:H5');
        $this->obj->setActiveSheetIndex(0)->setCellValue('A5', "Date Range: " . $this->start_date . " - " . $this->end_date);
        $this->obj->getActiveSheet()->getStyle('A5:H5')->getFont()->setBold(true);
        $this->obj->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // increment row
        $current_row = 7;

        if (!empty($this->reports)) {
            foreach ($this->reports as $reports) {
                // Client name
                $this->obj->getActiveSheet()->mergeCells("A$current_row:H$current_row");
                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", $reports['name']);
                // bold headers
                $this->obj->getActiveSheet()->getStyle("A$current_row:H$current_row")->getFont()->setBold(true);
                $this->obj->getActiveSheet()->getStyle("A$current_row:H$current_row")
                                            ->applyFromArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                   'color' => array('rgb' => '999999'))));
                $current_row += 1;

                // Title headers
                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", "Job#");
                $this->obj->setActiveSheetIndex(0)->setCellValue("B$current_row", "Date");
                $this->obj->setActiveSheetIndex(0)->setCellValue("C$current_row", "Time");
                $this->obj->setActiveSheetIndex(0)->setCellValue("D$current_row", "Status");
                $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", "PO/Ref#");
                $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", "Job Category");
                $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", "Tech(s)");
                $current_row += 1;

                // More title headers
                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", "Products");
                $this->obj->setActiveSheetIndex(0)->setCellValue("B$current_row", "Services");
                $this->obj->setActiveSheetIndex(0)->setCellValue("C$current_row", "Labor");
                $this->obj->setActiveSheetIndex(0)->setCellValue("D$current_row", "Expenses (B)");
                $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", "Total");
                $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", "Job Details");
                $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", "");
                $current_row += 1;

                // some values to calculate totals
                $jobs          = 0;
                $productsTotal = 0;
                $serviceTotal  = 0;
                $expenseTotal  = 0;
                $laborTotal    = 0;
                $total         = 0;

                foreach ($reports as $report) {
                    if (is_array($report)) {
                        // Display report data
                        $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", $report['job_number']);
                        $this->obj->setActiveSheetIndex(0)->setCellValue("B$current_row", date(Yii::app()->session['dateFormat'],strtotime($report['job_start_date'])));
                        $this->obj->setActiveSheetIndex(0)->setCellValue("C$current_row", date(Yii::app()->session['timeFormat'],strtotime($report['startTime'])));
                        $this->obj->setActiveSheetIndex(0)->setCellValue("D$current_row", $report['jobStatus']);
                        $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $report['job_po_number']);
                        $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", $report['category']);
                        $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", Reports::getJobAssignedTechName($report['job_id']));
                        $current_row += 1;

                        // Display more report data...
                        $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", $currencyFormat.number_format($report['productRate'], 2));
                        $this->obj->setActiveSheetIndex(0)->setCellValue("B$current_row", $currencyFormat.number_format($report['serviceRate'], 2));
                        $this->obj->setActiveSheetIndex(0)->setCellValue("C$current_row", $currencyFormat.number_format($report['total_labor_charges'], 2));
                        $this->obj->setActiveSheetIndex(0)->setCellValue("D$current_row", $currencyFormat.number_format($report['total_expense_charges'], 2));
                        $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $currencyFormat.number_format($report['total'], 2));
                        $this->obj->getActiveSheet()->mergeCells("F$current_row:G$current_row");
                        $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", $report['public_notes']);
                    }
                }
            }
        }
    }
}
