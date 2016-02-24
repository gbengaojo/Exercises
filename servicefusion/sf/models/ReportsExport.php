<?php
/*---------------------------------------------------------
Class: Csv for generating CSV files for the Reports
       http://timelist.com/task/575/2215/44705
Author: Gbenga Ojo <gbenga@servicefusion.com>
Origin Date: December 21, 2015
Modified: December 30, 2015

There is a distinction between the parameter being sent
to differing Sales Revenue Reports pages. The  "All Sales
Ungrouped" reports page is passed a single $reports
variable which is a single one-dimensional array. All of
the other reports under that section are passed a two-
dimensional array ($reportArray). All reports generate
totals at the bottom, whose values are incrementally updated
during each loop iteration within the view.

Probably like to create a new function to generate a CSV
for each respective Reports::<actionMethod()>, corresponding to
the different sections on the Reports page. Each implementation
is different, and in addition, implementations themselves differ
within individual sections.

Some of the necessary variables are calculated within the
respective views, so the file cannot be generated until the
views are rendered.

Because of the way in which data is being routed within the
application, we'll need to HTTP POST our required data to the
ReportController, then from there, call the appropriate
methods here to construct and deliver our file.
----------------------------------------------------------*/

class ReportsExport extends Reports
{
    protected $reports;
    protected $report_type;
    protected $report_sub_type;
    protected $auxiliary;
    protected $obj;
    protected $objWriter;


    /**
     * initialization
     *
     * @param: (array|mixed) $params = array('reports => (array| 1d or 2d)
     *                                       'report_type' => (string)
     *                                       'report_sub_type' => (string)
     *                                       'auxiliary' => (array))
     *         report_type corresponds (roughly) to the top report categories
     *              Specifically, it corresponds to methods that generate
     *              reports within the ReportsController.
     *         report_sub_type corresponds to, where applicable, the string
     *              that identifies report sub-categories within the
     *              ReportsController.
     *         auxiliary is an array that usually corresponds to the $reports
     *              or $reportArray that's used to generate reports in the
     *              controller, as well as variables used for the totals
     *              that display at the bottom of the reports, but can hold
     *              any additional information we need.
     */
    public function __construct($params = null) {
        if (is_null($params)) {
            // Exception handling;
        }
        
        $this->reports         = $params['reports'];
        $this->report_type     = $params['report_type'];
        $this->report_sub_type = $params['report_sub_type'];
        $this->auxiliary       = $params['auxiliary'];

        Yii::import('ext.phpexcel.XPHPExcel');
        $this->obj = XPHPExcel::createPHPExcel();
    }

    /**
     * calculate any additional data needed
     *
     * @return: (array) all the values necessary to generate our Excel file
     * @throws:
     */
    public function calculateValues() {
    }

    /**
     * generates actual Excel file
     *
     * @param: (array)
     * @return:
     * @throws:
     */
    public function generateExcelHeader() {

        // define some relevant variables
        $loggedInId = $_SESSION['primId'];
        $user       = Workforce::model()->find('id=:userId',array('userId'=>$loggedInId));
        $companyId  = addslashes(Yii::app()->session['companyId']);
        $company    = Company::model()->find('id = :companyId', array('companyId' => $companyId));
        $createdAt  = date(Yii::app()->session['dateFormat'] . ' ' . Yii::app()->session['timeFormat'], strtotime(date("Y-m-d H:i")));
        $createdBy  = $user->first_name . ' ' . $user->last_name;


        /* Begin Excel Report construction */

        // Main heading
        $this->obj->getActiveSheet()->mergeCells('A1:H1');
        $this->obj->setActiveSheetIndex(0)->setCellValue('A1', $company->company_name);
        $this->obj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
        $this->obj->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

        // Creating date and author
        $this->obj->getActiveSheet()->mergeCells('A2:H2');
        $this->obj->setActiveSheetIndex(0)->setCellValue('A2', "Created At: ".$createdAt);
        $this->obj->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
        $this->obj->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->obj->getActiveSheet()->mergeCells('A3:H3');
        $this->obj->setActiveSheetIndex(0)->setCellValue('A3', "Created By: ".$createdBy);
        $this->obj->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
        $this->obj->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    }


    /**
     * write temporary file to the filesystem; respond to the user
     * with a download.
     *
     * @param: (object) XPHPExcel object
     * @throws:
     * @return:
     */
    public function writeExcelFile() {
        // Write to file, provide download, and exit
        $this->obj->setActiveSheetIndex(0);
        $this->objWriter = PHPExcel_IOFactory::createWriter($this->obj, 'Excel2007');
        $this->objWriter->save(Yii::app()->basePath . '/../estimates/report.xlsx');

        // create temp file and read contents
        $file_path = Yii::app()->basePath . '/../estimates/report.xlsx';
        $data      = file_get_contents($file_path);      // Read contents
        $name      = "Report_" . date("Y-m-d") . ".xlsx";   // todo: (change to dates requested for report?)
        
        // send file to user and delete temporaryfile
        if (Yii::app()->getRequest()->sendFile($name, $data)) {
            unlink($file_path);
        }

    }

    /**
     * destructor
     */
    public function __destruct() {
        unset($this->obj);
        unset($this->objWriter);
    }
}
