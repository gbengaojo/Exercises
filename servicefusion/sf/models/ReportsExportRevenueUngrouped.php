<?php
/*---------------------------------------------------------
Class: ReportsExportRevenueUngrouped for generating Excel
       files for the Reports > Sales Revenue > All Sales
       Ungrouped.
       http://timelist.com/task/575/2215/44705
Author: Gbenga Ojo <gbenga@servicefusion.com>
Origin Date: December 22, 2015
Modified: December 30, 2015
----------------------------------------------------------*/

class ReportsExportRevenueUngrouped extends ReportsExport
{
    private $start_date;
    private $end_date;

    /**
     * ReportsExportSalesRevenue construct
     * @param null $params (array)
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
        $jobs          = 0;
        $productsTotal = 0;
        $serviceTotal  = 0;
        $expenseTotal  = 0;
        $laborTotal    = 0;
        $total         = 0;
        $currencyFormat = Yii::app()->session['CurrencySymbol'];

        // Report title
        $this->obj->getActiveSheet()->mergeCells('A4:H4');
        $this->obj->setActiveSheetIndex(0)->setCellValue('A4', "General Sales Revenue Report");
        $this->obj->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true);
        $this->obj->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Date
        $this->obj->getActiveSheet()->mergeCells('A5:H5');
        $this->obj->setActiveSheetIndex(0)->setCellValue('A5', "Date Range: " . $this->start_date . " - " . $this->end_date);
        $this->obj->getActiveSheet()->getStyle('A5:H5')->getFont()->setBold(true);
        $this->obj->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Table headers
        $current_row = 7;
        $header_arr = array('A' => array('Job#', 'Products'),
                            'B' => array('Date', 'Services'),
                            'C' => array('Time', 'Labor'),
                            'D' => array('Status', 'Expenses'),
                            'E' => array('PO/Ref#', 'Total'),
                            'F' => array('Job Category', 'Job Details'),
                            'G' => array('Customer', ''));

        // First header row
        foreach ($header_arr as $key => $value) {
            $this->obj->setActiveSheetIndex(0)->setCellValue($key . $current_row, $value[0]);
            $this->obj->getActiveSheet()->getColumnDimension($key)->setWidth(15);
            $this->obj->getActiveSheet()->getStyle($key . $current_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $this->obj->getActiveSheet()->getStyle("A$current_row:G$current_row")->getFont()->setBold(true);
        $current_row += 1;

        // Second header row
        foreach ($header_arr as $key => $value) {
            $this->obj->setActiveSheetIndex(0)->setCellValue($key . $current_row, $value[1]);
            $this->obj->getActiveSheet()->getColumnDimension($key)->setWidth(15);
            $this->obj->getActiveSheet()->getStyle($key . $current_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        // bold headers
        $this->obj->getActiveSheet()->getStyle("A$current_row:G$current_row")->getFont()->setBold(true);

        // Start data
        if (!empty($this->reports)) {                         // echo '<pre>'; print_r($this->reports); die;
            // $this->obj->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('0.00');
            foreach ($this->reports as $report) {
                // job_number, job_start_date, startTime, jobStatus, job_po_number, category, customer_name
                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", $report['job_number']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("B$current_row", $report['job_start_date']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("C$current_row", $report['startTime']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("D$current_row", $report['jobStatus']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $report['job_po_number']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", $report['category']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", $report['customer_name']);
                $current_row += 1;

                // productRate, serviceRate, total_labor_charges, total_expense_charges, total, public_notes
                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", $currencyFormat.number_format($report['productRate'], 2));
                $this->obj->setActiveSheetIndex(0)->setCellValue("B$current_row", $currencyFormat.number_format($report['serviceRate'], 2));
                $this->obj->setActiveSheetIndex(0)->setCellValue("C$current_row", $currencyFormat.number_format($report['total_labor_charges'], 2));
                $this->obj->setActiveSheetIndex(0)->setCellValue("D$current_row", $currencyFormat.number_format($report['total_expense_charges'], 2));
                $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $currencyFormat.number_format($report['total'], 2));
                $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", $report['public_notes']);
                $current_row += 1;

                // if Job Charges exist...
                if ($this->auxiliary['jobChargers'] == 1
                        && (isset($this->reports['jobPrdtSevc'][$report['job_id']])
                        || isset($this->reports['jobOtherCharge'][$report['job_id']]))) {

                    // Set Job Charges title
                    $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", 'Job Charges');
                    $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", 'Qty');
                    $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", 'Rate');
                    $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", 'Total');
                    // bold headers
                    $this->obj->getActiveSheet()->getStyle("A$current_row:G$current_row")->getFont()->setBold(true);
                    $this->obj->getActiveSheet()->getStyle("A$current_row:H$current_row")
                                                ->applyFromArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                                                                       'color' => array('rgb' => '999999'))));
                    $current_row += 1;

                    // Other Job charges
                    if (isset($this->reports['jobPrdtSevc'][$report['job_id']])) {
                        $prdSerTot = 0;
                        $flag      = 0;

                        // Display individual job charges
                        foreach ($this->reports['jobPrdtSevc'][$report['job_id']] as $key => $value) {
                            $flag = 1;

                            $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", $value['name']);
                            $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $value['multiplier']);
                            $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", isset($value['rate']) && $value['rate'] != "" ? $currencyFormat.number_format($value['rate'],2) : $currencyFormat.'0');
                            $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", $currencyFormat.number_format($value['total'], 2));
                            $prdSerTot += $value['total'];
                            $current_row += 1;
                        }

                        if ($flag == 1) {
                            $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", 'Job Subtotal');
                            $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", $currencyFormat.number_format($prdSerTot, 2));
                            $this->obj->getActiveSheet()->getStyle("A$current_row:G$current_row")->getFont()->setBold(true);
                            $current_row += 1;
                        }
                    }

                    // Other job charges
                    if (isset($this->reports['jobOtherCharge'][$report['job_id']])) {
                        foreach ($this->reports['jobOtherCharge'][$report['job_id']] as $key => $otherCharge) {
                            foreach ($otherCharge as $value) {
                                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", $value['short_name']);
                                $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", number_format($value['rate'], 2) . '%');
                                $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", $currencyFormat . number_format($value['total'], 2));
                                $current_row += 1;
                            }
                        }
                    }

                    // Some service tech info
                    if (isset($this->reports['labortimes'][$report['job_id']])) {
                        foreach ($this->reports['labortimes'][$report['job_id']] as $empid => $techs) {
                            $techName = $techs['name'];
                            $rowId = 0;
                            foreach($techs as $key => $values) {
                                if (is_array($values)) {
                                    foreach ($values as $times) {
                                        if ($times['is_drive_time_billed'] || ($times['is_labor_time_billed'])) {
                                            $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", date(Yii::app()->session['dateFormat'],strtotime($key))." - ".$techName);
                                            $current_row += 1;
                                        }
                                        if ($times['is_drive_time_billed']) {
                                            $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", 'Drive Time (' . $times['driving_time'] . ')');
                                            $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $currencyFormat.$times['drive_time_rate']."/hr");
                                            $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", $currencyFormat.number_format($times['dramount'],2));
                                            $current_row += 1;
                                        }
                                        if ($times['is_labor_time_billed']) {
                                            $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", 'Labor Time (' . $times['labor_time'] . ')');
                                            $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $currencyFormat.$times['drive_time_rate']."/hr");
                                            $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", $currencyFormat.number_format($times['dramount'],2));
                                            $current_row += 1;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // Some job totals
                    if (!empty($this->reports['expenses'][$report['job_id']][0])){
                        foreach($this->reports['expenses'][$report['job_id']][0] as $expense) {
                            if ($expense['is_billable']) {
                                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", $expense['expense_category_type']);
                                $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $currencyFormat.number_format($expense['amount'], 2));
                                $current_row += 1;
                            }
                        }
                    }

                    // More job totals
                    if (isset($this->reports['jobTotal']) && !empty($this->reports['jobTotal'])) { //print_r($reports['jobTotal']);die;
                        foreach ($this->reports['jobTotal'] as $key => $jobTotal) {
                            if ($key == $report['job_id']) {
                                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", 'Total Time & Labor');
                                $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", $currencyFormat.number_format($jobTotal['total_labor_charges'], 2));
                                $this->obj->getActiveSheet()->getStyle("A$current_row")->getFont()->setBold(true);
                                $current_row += 1;
                                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", 'Total Billable Expenses');
                                $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", $currencyFormat.number_format($jobTotal['total_expense_charges'], 2));
                                $this->obj->getActiveSheet()->getStyle("A$current_row")->getFont()->setBold(true);
                                $current_row += 1;
                                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", 'Job Total');
                                $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", $currencyFormat.number_format(($jobTotal['job_total']+$jobTotal['total_expense_charges']+$jobTotal['total_labor_charges']),2));
                                $this->obj->getActiveSheet()->getStyle("A$current_row:H$current_row")->getFont()->setBold(true);
                                $current_row += 2;
                            }
                        }
                    }
                }

                $jobs++;
                $productsTotal += $report['productRate'];
                $serviceTotal  += $report['serviceRate'];
                $expenseTotal  += $report['total_expense_charges'];
                $laborTotal    += $report['total_labor_charges'];
                $total         += $report['total'];
            }
        } else {
            $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", "No details available");
        }

        // Grand Totals
        $this->obj->getActiveSheet()->mergeCells("A$current_row:H$current_row");
        $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", "Grand Total For All Customers");
        $this->obj->getActiveSheet()->getStyle("A$current_row:H$current_row")->getFont()->setBold(true);
        $this->obj->getActiveSheet()->getStyle("A$current_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->obj->getActiveSheet()->getStyle("A$current_row:H$current_row")
            ->applyFromArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '999999'))));
        $current_row += 1;

        $this->obj->setActiveSheetIndex(0)->setCellValue("B$current_row", 'Jobs:');
        $this->obj->setActiveSheetIndex(0)->setCellValue("C$current_row", 'Products:');
        $this->obj->setActiveSheetIndex(0)->setCellValue("D$current_row", 'Services:');
        $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", 'Labor:');
        $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", 'Expenses (B):');
        $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", 'Grand Total:');
        $this->obj->getActiveSheet()->getStyle("A$current_row:H$current_row")->getFont()->setBold(true);
        $current_row += 1;
        $this->obj->setActiveSheetIndex(0)->setCellValue("B$current_row", $jobs);
        $this->obj->setActiveSheetIndex(0)->setCellValue("C$current_row", $currencyFormat.number_format($productsTotal, 2));
        $this->obj->setActiveSheetIndex(0)->setCellValue("D$current_row", $currencyFormat.number_format($serviceTotal, 2));
        $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $currencyFormat.number_format($laborTotal, 2));
        $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", $currencyFormat.number_format($expenseTotal, 2));
        $this->obj->setActiveSheetIndex(0)->setCellValue("G$current_row", $currencyFormat.number_format($total, 2));
    }

}
