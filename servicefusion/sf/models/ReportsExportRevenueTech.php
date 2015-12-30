<?php
/*---------------------------------------------------------
Class: ReportsExportRevenueCustomer for generating Excel
       files for the Reports > Sales Revenue > Sales By
       Service Tech
       (http://timelist.com/task/575/2215/44705)
Author: Gbenga Ojo <gbenga@servicefusion.com>
Origin Date: December 30, 2015
Modified: December 30, 2015
----------------------------------------------------------*/
class ReportsExportRevenueTech extends ReportsExport
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
        $this->calclulateData();
        $this->writeExcelFile();
    }

}
