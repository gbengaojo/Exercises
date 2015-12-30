<?php

class ReportsExportSalesRevenue extends ReportsExport
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
                            'G' => array('Customer', 'null'));

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
        $current_row += 1;

        $jobs          = 0;
        $productsTotal = 0;
        $serviceTot    = 0;
        $expenseTot    = 0;
        $laborTot      = 0;
        $total         = 0;

        $this->obj->setActiveSheetIndex(0)->setCellValue('A10', 'caching???! or what?!');

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
                $this->obj->setActiveSheetIndex(0)->setCellValue("A$current_row", $report['productRate']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("B$current_row", $report['serviceRate']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("C$current_row", $report['total_labor_charges']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("D$current_row", $report['total_expense_charges']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("E$current_row", $report['total']);
                $this->obj->setActiveSheetIndex(0)->setCellValue("F$current_row", $report['public_notes']);
                $current_row += 1;

                if ($this->auxiliary['jobChargers'] == 1
                        && isset($this->reports['jobPrdtSevc'][$report['job_id']])
                        || isset($this->reports['jobOtherCharge'][$report['job_id']])) {
                    echo '<pre>'; print_r($this->reports['jobPrdtSevc']); exit;
                }
            }
        }
    }

}
