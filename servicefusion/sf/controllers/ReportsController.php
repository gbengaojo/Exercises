<?php
/**
 * controller for all the actions related with reports section
 * @author sujathan
 * @package null
 * @category null
 * @link null
 * @license null
 * @date 06/06/2014
 */
class ReportsController extends Controller
{
	public $defaultAction = 'index';
	public $class_dsply;
	public $messagesArray = array();
	public $logonMessagesArray = array();
	/**
	 * 
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * 
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow', // allow authenticated users to access all actions
						'actions'=>array('login'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated users to access all actions
                'users'=>array('@'),
            ),
            /* array('deny',
            	'users'=>array('*'),), */
		);
	}
	
	/**
	 * intialization
	 * 
	 * @return null
	 */
 	public function init()
    {	
    	Yii::app()->session['loginTriggered'] = 'false';
    	$this->class_dsply=isset($this->class_dsply)?$this->class_dsply:"none";
     	Helper::intializeFunction();
     	
    }
    
    
    /**
	 * Using for rendering reports dashboard page
	 * 
	 * @return html
	 */
	public function actionIndex()
	{
    	Yii::app()->session['main']="reports";
    	Yii::app()->session['sub']="reports";

    	$companyId =addslashes(Yii::app()->session['companyId']);
		$techs = $owners = $agents = array();
		$sql = "select id,first_name,last_name,is_sales_rep,is_field_worker from ubase_users 
		where is_active=1 AND ubase_company_id= $companyId ORDER BY first_name,last_name ASC";
		$techsArray=Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($techsArray as $tech){
			if($tech['is_field_worker']==1){
				$techs[$tech['id']]=$tech['first_name'].' '.$tech['last_name'];
			}
			if($tech['is_sales_rep']==1){
				$agents[$tech['id']]=$tech['first_name'].' '.$tech['last_name'];
			}
			$owners[$tech['id']]=$tech['first_name'].' '.$tech['last_name'];
			
		}
		
		$sql = "select id,first_name,last_name,is_sales_rep,is_field_worker from ubase_users
		where is_active=0 AND ubase_company_id= $companyId ORDER BY first_name,last_name ASC";
		$techsArray=Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($techsArray as $tech){
			if($tech['is_field_worker']==1){
				$techs[$tech['id']]=$tech['first_name'].' '.$tech['last_name']." (Inactive)";
			}
			if($tech['is_sales_rep']==1){
				$agents[$tech['id']]=$tech['first_name'].' '.$tech['last_name']." (Inactive)";
			}
			$owners[$tech['id']]=$tech['first_name'].' '.$tech['last_name']." (Inactive)";
				
		}
		
		$sql = "select a.id,a.short_description from master_services a,master_services_ubase_companies c where a.id=c.master_service_id and c.ubase_company_id=$companyId and a.is_active=1 ORDER BY a.short_description";
		$services= Yii::app()->db->createCommand($sql)->queryAll();
		$servicesArray = Array();
		$i = 0;
		foreach ($services as $service){
			$servicesArray[$service['id']]=$service['short_description'];
		}
		$sql = "select a.id,a.make,a.model from ubase_products a where a.ubase_company_id=$companyId and a.is_deleted=0 and a.is_active=1 ORDER BY a.make asc";
		$products= Yii::app()->db->createCommand($sql)->queryAll();
		$productsArray = Array();
		$i = 0;
		foreach ($products as $product){
			$productsArray[$product['id']]=$product['make']." ".$product['model'];
		}
		$techsArray='';
		$sources = array();
		$sourcesArray=ReferralSources::model()->findAll('ubase_company_id=:companyId AND is_deleted = 0 AND is_active = 1',array(':companyId'=>$companyId));
		foreach ($sourcesArray as $source){
				$sources[$source['id']]=$source['short_name'];
		}
		$sql = "select id,short_name,type from ubase_payment_types where ubase_company_id=$companyId ORDER BY short_name";
		$paymentMethods= Yii::app()->db->createCommand($sql)->queryAll();
		$expenseCateg = array();
		$expenseCategArray = Reports::getExpenseCategories($companyId);		
		foreach ($expenseCategArray as $expense){
			$expenseCateg[$expense['id']]=$expense['category_name'];
		}
		$this->render('reports',array('techs'=>$techs,'owners'=>$owners,'agents'=>$agents,'productsArray'=>$productsArray,'servicesArray'=>$servicesArray,'sources'=>$sources,'paymentMethods'=>$paymentMethods,'expenseCateg'=>$expenseCateg));
	}
	
	/**
	 * Using for rendering reports dashboard page
	 *
	 * @return html
	 */
	public function actioncustomReports()
	{
		Yii::app()->session['main']="reports";
		Yii::app()->session['sub']="customReports";
		 
		$companyId =addslashes(Yii::app()->session['companyId']);
		$techs=$owners=$agents=array();
		$sql = "select id,first_name,last_name,is_sales_rep,is_field_worker from 
		ubase_users where is_active=1 AND ubase_company_id= $companyId ORDER BY first_name,last_name ASC";
		$techsArray=Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($techsArray as $tech){
			if($tech['is_field_worker']==1){
				$techs[$tech['id']]=$tech['first_name'].' '.$tech['last_name'];
			}
			if($tech['is_sales_rep']==1){
				$agents[$tech['id']]=$tech['first_name'].' '.$tech['last_name'];
			}
				
			$owners[$tech['id']]=$tech['first_name'].' '.$tech['last_name'];
				
		}
		
		$sql = "select id,first_name,last_name,is_sales_rep,is_field_worker from ubase_users
		where is_active=0 AND ubase_company_id= $companyId ORDER BY first_name,last_name ASC";
		$techsArray=Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($techsArray as $tech){
			if($tech['is_field_worker']==1){
				$techs[$tech['id']]=$tech['first_name'].' '.$tech['last_name']." (Inactive)";
			}
			if($tech['is_sales_rep']==1){
				$agents[$tech['id']]=$tech['first_name'].' '.$tech['last_name']." (Inactive)";
			}
			$owners[$tech['id']]=$tech['first_name'].' '.$tech['last_name']." (Inactive)";
		
		}
		
		$sql = "select a.id,a.short_description from master_services a,master_services_ubase_companies c where a.id=c.master_service_id and c.ubase_company_id=$companyId and a.is_active=1 ORDER BY a.short_description";
		$services= Yii::app()->db->createCommand($sql)->queryAll();
		$servicesArray = Array();
		$i = 0;
		foreach ($services as $service){
			$servicesArray[$service['id']]=$service['short_description'];
		}
		$sql = "select a.id,a.make,a.model from ubase_products a where a.ubase_company_id=$companyId and a.is_deleted=0 and a.is_active=1 ORDER BY a.make asc";
		$products= Yii::app()->db->createCommand($sql)->queryAll();
		$productsArray = Array();
		$i = 0;
		foreach ($products as $product){
			$productsArray[$product['id']]=$product['make']." ".$product['model'];
		}
		$techsArray='';
		$this->render('customReports',array('techs'=>$techs,'owners'=>$owners,'agents'=>$agents,'productsArray'=>$productsArray,'servicesArray'=>$servicesArray));
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function actionSalesRevenue()
	{
		// access permissions
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Sales_Revenue");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}

        // get request parameters and company id
		$type          = Yii::app()->request->getParam('type', 'default');
		$from          = Yii::app()->request->getParam('from', 'default');
        $generateExcel = Yii::app()->request->getParam('generateExcel', false);

        // company id
		$companyId = addslashes(Yii::app()->session['companyId']);

        // query database for company info
		$sql = "select company_name , company_logo from ubase_companies where id=$companyId";
		$company = Yii::app()->db->createCommand($sql)->queryRow();

        // time range for which we want to obtain data
		switch ($from) {
			case 'last_12_months':
				$time = strtotime("-1 year", time());
			   	$dateRange = date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",$time))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d")));	
				break;
			case 'last_month':
			    $dateRange = date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('first day of last month')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("last day of last month"))));	
				break;
			case 'this_month':
			    $dateRange = date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('first day of this month')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d")));	
				break;
			case 'this_week':				
				$startDate = date("Y-m-d",strtotime("sunday last week"));
				$endDate   = date("Y-m-d",strtotime("saturday this week"));
				$dateRange = date(Yii::app()->session['dateFormat'],strtotime($startDate)).' - '.date(Yii::app()->session['dateFormat'],strtotime($endDate));					
				break;
			case 'last_quarter':				
				$startDate = date("Y-m-d",strtotime("sunday last week"));
				$endDate   = date("Y-m-d",strtotime("saturday this week"));
				$dateRange = date(Yii::app()->session['dateFormat'],strtotime($startDate)).' - '.date(Yii::app()->session['dateFormat'],strtotime($endDate));					
				break;
			default:
				$dateRange='';
				break;
		}

        // All Sales Ungrouped
		if ($type == 'ungrouped') {
			$jobChargers = 0;
			if ($from == 'custom') {
				$dateRange = addslashes($_POST['Ungrouped']['start_date']) . ' - ' . addslashes($_POST['Ungrouped']['end_date']);
				$jobChargers = isset($_POST['Ungrouped']['JobCharges']) && $_POST['Ungrouped']['JobCharges'] == 1 ? $_POST['Ungrouped']['JobCharges'] : 0;
			}

			$reports = Reports::getSalesReportGeneral($from,$type);

			// generate Excel
			if ($generateExcel) {
				$params = array('reports'         => $reports,
					 			'report_type'     => 'SalesRevenue',
								'report_sub_type' => 'ungrouped',
								'auxiliary'       => array('post'        => $_POST['Ungrouped'],
													       'dateRange'   => $dateRange,
					                                       'company'     => $company,
					                                       'jobChargers' => $jobChargers));

				$report = new ReportsExportRevenueUngrouped($params);
				// $report->generateExcel();
			} else {
				$this->renderPartial('generalSales', array('reports'=>$reports,'dateRange'=>$dateRange,'company'=>$company,'jobChargers'=>$jobChargers));
			}
		}

        // Sales By Customer
		else if($type=='customer'){
			if($from=='custom'){
				$dateRange=addslashes($_POST['Customer']['start_date']).' - '.addslashes($_POST['Customer']['end_date']);	
			}
			$reports=Reports::getSalesReportCustomer($from,$type);
			$this->renderPartial('salesByCustomer',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}

        // Sales By Service Tech
		else if($type=='tech'){
			if($from=='custom'){
				$dateRange=addslashes($_POST['Tech']['start_date']).' - '.addslashes($_POST['Tech']['end_date']);	
			}
			$reports=Reports::getSalesReportTech($from,$type);
			$this->renderPartial('salesByTech',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}

        // Sales By Referral Source
		else if($type=='referral'){
			if($from=='custom'){
				$dateRange=addslashes($_POST['Referral']['start_date']).' - '.addslashes($_POST['Referral']['end_date']);
			}
			$reports=Reports::getSalesReportReferral($from,$type);
			$this->renderPartial('salesByReferral',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}

        // Estimates
		else if($type=='estimate'){
			if($from=='custom'){
				$dateRange=addslashes($_POST['Estimate']['start_date']).' - '.addslashes($_POST['Estimate']['end_date']);	
			}
			$reports=Reports::getSalesReportEstimate($from,$type);
			$this->renderPartial('estimateSales',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}

        // Sales Tax Reports
		else if($type=='tax'){
			if($from=='custom'){
				$dateRange=addslashes($_POST['Tax']['start_date']).' - '.addslashes($_POST['Tax']['end_date']);	
			}
			$reports=Reports::getSalesTaxReport($from,$type);
			$this->renderPartial('salesTax',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}
		unset($reports);
		unset($company);
	}
	
	/**
	 *
	 * Enter description here ...
	 */
	public function actionCustomSalesRevenue()
	{
	
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Sales_Commission");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}
		$type=Yii::app()->request->getParam('type','default');
		$from=Yii::app()->request->getParam('from','default');
		$companyId =addslashes(Yii::app()->session['companyId']);
		$sql = "select company_name , company_logo from ubase_companies where id=$companyId";
		$company= Yii::app()->db->createCommand($sql)->queryRow();
		$servicePart=$productPart=$queryParts='';
		switch ($from) {
			case 'last_month':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('first day of last month')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("last day of last month"))));
				$startDate=date("Y-m-d",strtotime(date("Y-m-d",strtotime('first day of last month'))));
				$endDate=date('Y-m-d',strtotime(date("Y-m-d",strtotime("last day of last month"))));
				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				break;
			case 'last_2_weeks':
			   	$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("-3 sunday")))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('saturday last week'))));	
				$startDate=date("Y-m-d",strtotime("-3 sunday"));
				$endDate=date("Y-m-d",strtotime('saturday last week'));
				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
			   	break;
			case 'last_week':
			    $dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('monday last week')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("sunday last week"))));	
				$startDate=date("Y-m-d",strtotime("-2 sunday"));
				$endDate=date("Y-m-d",strtotime('saturday last week'));
				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
			    break;
			
			case 'this_week':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('sunday last week')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d")));	
				$startDate=date("Y-m-d",strtotime("sunday last week"));
				$endDate=date("Y-m-d",strtotime("saturday this week"));
				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				break;
			case 'custom':
					
		 		if($_POST['Tech']['closed_at_start_date'] && $_POST['Tech']['closed_at_end_date']){
    				$sDate=Helper::getActualDateFormatToDB($_POST['Tech']['closed_at_start_date']);
    				$eDate=Helper::getActualDateFormatToDB($_POST['Tech']['closed_at_end_date']);
    				$queryParts .=" and DATE(uj.closed_at ) <= '$eDate' and DATE(uj.closed_at)  >= '$sDate'";
    			}
				if($_POST['Tech']['start_date'] && $_POST['Tech']['end_date']){
    				$startDate=Helper::getActualDateFormatToDB($_POST['Tech']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['Tech']['end_date']);
    				$queryParts .=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
    			}
			    else{
			    	$startDate=$sDate;
			    	$endDate=$eDate;
			    }
    			
    			$customerName=addslashes($_POST['Tech']['customer_name']);
    			if($customerName)
    			 	$queryParts .=" and uc.customer_name like '%".$customerName."%'";
    			$job_po_number=addslashes($_POST['Tech']['job_po_number']);
    			if($job_po_number)
    				$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'"; 
    			if(!empty($_POST['Tech']['job_techs']) && $_POST['Tech']['job_techs'][0]!=''){
    				$job_techs='('.ltrim(implode(',', $_POST['Tech']['job_techs']),',').')';
    				$queryParts .=" and user.ubase_user_id in $job_techs ";
    			}
    			if(!empty($_POST['Tech']['job_status'])){
    				$job_status='('.implode(', ', $_POST['Tech']['job_status']).')';
    		 		$queryParts .=" and msc.code in $job_status";
    			}
				break;
			default:
				$dateRange='';
				break;
		}
		//echo $queryParts;die();
		$reports=Reports::customSalesRevenue($from,$type,$queryParts,$servicePart,$productPart,$startDate,$endDate);
		//$this->renderPartial('salesCommissionByTech',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		
		unset($reports);
		unset($company);
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function actionPayroll()
	{
		$job_techs = '';
		$urlFlag = 0;
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Payroll");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}
		$type=Yii::app()->request->getParam('type','default');
		$from=Yii::app()->request->getParam('from','default');
		$print=Yii::app()->request->getParam('print','default');
		$companyId =addslashes(Yii::app()->session['companyId']);
		$noDays = 0;
		$sql = "select company_name , company_logo from ubase_companies where id=$companyId";
		$company= Yii::app()->db->createCommand($sql)->queryRow();
		$queryStringTech='';
		switch ($from) {
			case 'last_2_weeks':
				$noDays = 14;
			   	$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("-3 sunday")))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('saturday last week'))));	
				if($type=='drive_labor'){
					$startDate=date("Y-m-d",strtotime("-3 sunday"));
					$endDate=date("Y-m-d",strtotime('saturday last week'));
					$queryString=" and DATE(ujlc.labor_date) <= '$endDate' and ujlc.labor_date >= '$startDate'";
				}
				else{
					$postStartDate = $startDate=date("Y-m-d",strtotime("-3 sunday"));
					$postEndDate = $endDate=date("Y-m-d",strtotime('saturday last week'));
					$queryStringDate=" and DATE(uuws.created_at) <= '$endDate' and uuws.created_at >= '$startDate'";
				}
			   	break;
			case 'last_week':
				$noDays = 7;
			    $dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('-2 sunday')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("saturday last week"))));	
				if($type=='drive_labor'){
					$startDate=date("Y-m-d",strtotime("-2 sunday"));
					$endDate=date("Y-m-d",strtotime('saturday last week'));
					$queryString=" and DATE(ujlc.labor_date) <= '$endDate' and ujlc.labor_date >= '$startDate'";
				}
				else{
					$postStartDate = $startDate=date("Y-m-d",strtotime("-2 sunday"));
					$postEndDate = $endDate=date("Y-m-d",strtotime('saturday last week'));
					$queryStringDate=" and DATE(uuws.created_at) <= '$endDate' and uuws.created_at >= '$startDate'";
				}
			    break;
			
			case 'this_week':
				$noDays = 7;
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('-1 sunday')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("saturday this week"))));	
				if($type=='drive_labor'){
					$startDate=date("Y-m-d",strtotime("-1 sunday"));
					$endDate=date("Y-m-d",strtotime('saturday this week'));
					$queryString=" and DATE(ujlc.labor_date) <= '$endDate' and ujlc.labor_date >= '$startDate'";
				}
				else{
					$postStartDate = $startDate=date("Y-m-d",strtotime("-1 sunday"));
					$postEndDate = $endDate=date("Y-m-d",strtotime('saturday this week'));
					$queryStringDate=" and DATE(uuws.created_at) <= '$endDate' and uuws.created_at >= '$startDate'";
				}
				break;
			case 'custom':	
				if($type=='drive_labor'){
						
					$dateRange=addslashes($_POST['PayrollDriveLabor']['start_date']).' - '.addslashes($_POST['PayrollDriveLabor']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['PayrollDriveLabor']['start_date']);
					$endDate=Helper::getActualDateFormatToDB($_POST['PayrollDriveLabor']['end_date']);
					$queryString=" and DATE(ujlc.labor_date) <= '$endDate' and ujlc.labor_date >= '$startDate'";
					if(!empty($_POST['PayrollDriveLabor']['job_techs']) && $_POST['PayrollDriveLabor']['job_techs'][0]!=''){
						$job_techs='('.ltrim(implode(',', $_POST['PayrollDriveLabor']['job_techs']),',').')';
						$queryString.=" and ujaw.ubase_user_id in $job_techs ";
					}
					
					$customerName=addslashes($_POST['PayrollDriveLabor']['customer_name']);
					if($customerName)
					$queryString .=" and uc.customer_name like '%".$customerName."%'";
					$job_po_number=addslashes($_POST['PayrollDriveLabor']['job_po_number']);
					if($job_po_number)
					$queryString .=" and uj.job_po_number like '%".$job_po_number."%'";
					if(!empty($_POST['PayrollDriveLabor']['job_status'])){
						$cmplt_master_id = Jobs::getWorkerMasterStatusID('10_CMP',$companyId);
						$clsd_master_id = Jobs::getWorkerMasterStatusID('12_CLS',$companyId);
						$invcd_master_id = Jobs::getWorkerMasterStatusID('14_INV',$companyId);
						$queryString .=" and (ms.id=$cmplt_master_id OR ms.id=$clsd_master_id OR ms.id=$invcd_master_id) ";
					}
				}
				else{
					$dateRange=addslashes($_POST['PayrollDriveLaborHour']['start_date']).' - '.addslashes($_POST['PayrollDriveLaborHour']['end_date']);
					
					$postStartDate = isset($_POST['PayrollDriveLaborHour']['start_date']) ? $_POST['PayrollDriveLaborHour']['start_date'] : "";
					$postEndDate = isset($_POST['PayrollDriveLaborHour']['end_date']) ?$_POST['PayrollDriveLaborHour']['end_date'] : "";
					$startDate=isset($_POST['PayrollDriveLaborHour']['start_date']) ? Helper::getActualDateFormatToDB($_POST['PayrollDriveLaborHour']['start_date']) : "";
					$endDate=isset($_POST['PayrollDriveLaborHour']['end_date']) ?Helper::getActualDateFormatToDB($_POST['PayrollDriveLaborHour']['end_date']) : ""; 
					if($startDate==''){
						
						$startOrginalDate = addslashes(Yii::app()->request->getParam('startdate','default'));
						$startDate = Helper::getActualDateFormatToDB($startOrginalDate);
					}
					if($endDate==''){
						$endOrginalDate = addslashes(Yii::app()->request->getParam('enddate','default'));
					    $endDate = Helper::getActualDateFormatToDB($endOrginalDate);
					}
					if($startOrginalDate!='' && $endOrginalDate!=''){
						$dateRange = $startOrginalDate.' - '.$endOrginalDate;
					}
					if($print=='true'){
						$startDate = Helper::getActualDateFormatToDB(addslashes(Yii::app()->request->getParam('startdate','default')));
						$endDate = Helper::getActualDateFormatToDB(addslashes(Yii::app()->request->getParam('enddate','default')));
					}
					$startingDate = strtotime($startDate);
					$endingDate = strtotime($endDate);
					$datediff = $endingDate - $startingDate;
					$noDays = floor($datediff/(60*60*24));
					
					$queryStringDate=" and DATE(uuws.created_at) <= '$endDate' and uuws.created_at >= '$startDate'";
					if(!empty($_POST['PayrollDriveLaborHour']['job_techs']) && $_POST['PayrollDriveLaborHour']['job_techs'][0]!=''){
						$job_techs='('.ltrim(implode(',', $_POST['PayrollDriveLaborHour']['job_techs']),',').')';
						$queryStringTech=" and uu.id in $job_techs ";
						$urlFlag = 1;
						$jobTechsPrint = ltrim(implode(',', $_POST['PayrollDriveLaborHour']['job_techs']),',');
					}
					
					if($job_techs=='' && $urlFlag==0){
						$jobTechs = addslashes(Yii::app()->request->getParam('job_techs','default'));
						if($jobTechs!=''){
							$job_techs= "($jobTechs)";
							$queryStringTech=" and uu.id in $job_techs ";
						}
						$jobTechsPrint = $jobTechs;
					}
				}
				
				break;
			default:
				$dateRange='';
				break;
		}
		//echo $queryStringDate;die;
		if($type=='employee'){
			$reports=Reports::getEmployeePayroll($from,$type,$queryStringDate,$queryStringTech);
			$statusReports = Reports::hoursLaber($reports,$endDate);
			if($print=='true'){
				$this->renderPartial('employeePayrollView',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company,'statusReports'=>$statusReports,'noDays'=>$noDays,'startDate'=>$startDate,'endDate'=>$endDate));
			}else{
				$this->render('employeePayroll',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company,'statusReports'=>$statusReports,'noDays'=>$noDays,'startDate'=>$postStartDate,'endDate'=>$postEndDate,'from'=>$from,'type'=>$type,'jobTechs'=>$jobTechsPrint));
			}
		}
		else if($type=='drive_labor'){
			$reports=Reports::getJobDriveLaborPayroll($from,$type,$queryString);
			$this->renderPartial('driveLaborPayroll',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}
	
		unset($reports);
		unset($company);
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function actionSalesCommission()
	{
	
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Sales_Commission");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}
		$type=Yii::app()->request->getParam('type','default');
		$from=Yii::app()->request->getParam('from','default');
		$companyId =addslashes(Yii::app()->session['companyId']);
		$sql = "select company_name , company_logo from ubase_companies where id=$companyId";
		$company= Yii::app()->db->createCommand($sql)->queryRow();
		$servicePart=$productPart=$queryParts='';
		switch ($from) {
			case 'last_2_weeks':
			   	$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("-3 sunday")))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('saturday last week'))));	
				$startDate=date("Y-m-d",strtotime("-3 sunday"));
				$endDate=date("Y-m-d",strtotime('saturday last week'));
			   	if($type=='agent'){
					$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				}
				else{
					$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				}
			   	break;
			case 'last_week':
			    $dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('monday last week')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("sunday last week"))));	
				$startDate=date("Y-m-d",strtotime("monday last week"));
				$endDate=date("Y-m-d",strtotime('sunday last week'));
			   	if($type=='agent'){
					$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				}
				else{
					$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				}
			    break;
			
			case 'this_week':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('sunday last week')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d")));	
				$startDate=date("Y-m-d",strtotime("sunday last week"));
				$endDate=date("Y-m-d");
			   	if($type=='agent'){
					$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				}
				else{
					$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				}
				break;
			case 'custom':	
				if($type=='agent'){
					$dateRange=addslashes($_POST['SalesCommissionAgent']['start_date']).' - '.addslashes($_POST['SalesCommissionAgent']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['SalesCommissionAgent']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['SalesCommissionAgent']['end_date']);
					$queryParts .=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				
    				if(isset($_POST['SalesCommissionAgent']['customer_name']) && $_POST['SalesCommissionAgent']['customer_name']!=''){
    			 		$queryParts.=" and uc.customer_name like '%".$_POST['SalesCommissionAgent']['customer_name']."%'";
    				}
					if(isset($_POST['SalesCommissionAgent']['products']) && $_POST['SalesCommissionAgent']['products']!=''){
						if($_POST['SalesCommissionAgent']['products']!='all'){
    			 			$productPart =" and ujpl.ubase_product_id=".$_POST['SalesCommissionAgent']['products'];
						}else{
							$productPart ="";
						}
    				}
    				else{
    					//$productPart='NOTSEARCH';
    					$productPart='NONE';
    				}
					if(isset($_POST['SalesCommissionAgent']['services']) && $_POST['SalesCommissionAgent']['services']!=''){
						if($_POST['SalesCommissionAgent']['services']!='all'){
    			 			$servicePart =" and ujsl.master_service_id=".$_POST['SalesCommissionAgent']['services'];
						}else{
							$servicePart ="";
						}
    				}
    				else{
    					//$servicePart='NOTSEARCH';
    					$servicePart='NONE';
    				}
	    			if(!empty($_POST['SalesCommissionAgent']['job_agents']) && $_POST['SalesCommissionAgent']['job_agents'][0]!=''){
	    				$job_techs='('.ltrim(implode(',', $_POST['SalesCommissionAgent']['job_agents']),',').')';
	    				$queryParts.=" and user.ubase_user_id in $job_techs ";
	    			}
	    			if(!empty($_POST['SalesCommissionAgent']['job_status'])){
	    				$job_status='('.implode(', ', $_POST['SalesCommissionAgent']['job_status']).')';
	    		 		$queryParts .=" and msc.code in $job_status";
	    			}
					else{
	    				$queryParts .=" and msc.code in ('')";
	    			}
				}
				else{
					$dateRange=addslashes($_POST['SalesCommissionTech']['start_date']).' - '.addslashes($_POST['SalesCommissionTech']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['SalesCommissionTech']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['SalesCommissionTech']['end_date']);
					$queryParts .=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
					if(isset($_POST['SalesCommissionTech']['customer_name']) && $_POST['SalesCommissionTech']['customer_name']!=''){
    			 		$queryParts.=" and uc.customer_name like '%".$_POST['SalesCommissionTech']['customer_name']."%'";
    				}
					if(isset($_POST['SalesCommissionTech']['products']) && $_POST['SalesCommissionTech']['products']!=''){
						if($_POST['SalesCommissionTech']['products']!='all'){
    			 			$productPart =" and ujpl.ubase_product_id=".$_POST['SalesCommissionTech']['products'];
						}else{
							$productPart ="";
						}
    				}
					else{
    					//$productPart='NOTSEARCH';
						$productPart='NONE';
    				}
					if(isset($_POST['SalesCommissionTech']['services']) && $_POST['SalesCommissionTech']['services']!=''){
						if($_POST['SalesCommissionTech']['services']!='all'){
    			 			$servicePart =" and ujsl.master_service_id=".$_POST['SalesCommissionTech']['services'];
						}else{
							$servicePart ="";
						}
    				}
					else{
    					//$servicePart='NOTSEARCH';
						$servicePart='NONE';
    				}
	    			if(!empty($_POST['SalesCommissionTech']['job_techs']) && $_POST['SalesCommissionTech']['job_techs'][0]!=''){
	    				$job_techs='('.ltrim(implode(',', $_POST['SalesCommissionTech']['job_techs']),',').')';
	    				$queryParts .=" and user.ubase_user_id in $job_techs ";
	    			}
	    			if(!empty($_POST['SalesCommissionTech']['job_status']) && $_POST['SalesCommissionTech']['job_status'][0]!=''){
	    				$job_status='('.implode(', ', $_POST['SalesCommissionTech']['job_status']).')';
	    		 		$queryParts .=" and msc.code in $job_status";
	    			}
					else{
	    				$queryParts .=" and msc.code in ('')";
	    			}
				}
				break;
			default:
				$dateRange='';
				break;
		}
		//echo $servicePart."===".$productPart;die;
		if($type=='agent'){
			$reports=Reports::salesCommission($from,$type,$queryParts,$servicePart,$productPart);
			$this->renderPartial('salesCommissionByAgent',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}
		else if($type=='tech'){
			$reports=Reports::salesCommission($from,$type,$queryParts,$servicePart,$productPart);
			$this->renderPartial('salesCommissionByTech',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}
		
		unset($reports);
		unset($company);
	}
	
	/**
	 * 
	 */
	public function actionDaySheet()
	{
		
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Payroll");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			//$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}
		$type=Yii::app()->request->getParam('type','default');
		$from=Yii::app()->request->getParam('from','default');
		$companyId =addslashes(Yii::app()->session['companyId']);
		
		$sql = "select company_name , company_logo,street_1,street_2,postal_code,city,state,phone_1,phone_2,email_1 from ubase_companies where id=$companyId";
		$company= Yii::app()->db->createCommand($sql)->queryRow();
		$includeEmail = 0;
		$noTechsFlag = $unasOnly = 0;
		$techQueryPart=$queryParts='';
		switch ($from) {
			case 'today':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d")));	
				$startDate=date("Y-m-d");
				$queryParts=" and DATE(uj.job_start_date) = '$startDate'";
				$queryPartsVisit=" and DATE(ujv.job_start_date) = '$startDate'";
			   	break;
			case 'tomorrow':
			    $dateRange=date(Yii::app()->session['dateFormat'],strtotime("+1 day"));	
				$startDate=date("Y-m-d",strtotime("+1 day"));
				$queryParts=" and DATE(uj.job_start_date) = '$startDate'";
				$queryPartsVisit=" and DATE(ujv.job_start_date) = '$startDate'";
			    break;
			
			case 'nextTwoWeeks':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("+1 day")))).' - '.date(Yii::app()->session['dateFormat'],strtotime("+2 week 1 day"));	
				$startDate=date("Y-m-d",strtotime("+1 day"));
				$endDate=date('Y-m-d',strtotime("+2 week 1 day"));
			   	$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
			   	$queryPartsVisit=" and DATE(ujv.job_start_date) <= '$endDate' and ujv.job_start_date >= '$startDate'";
				break;
			case 'custom':
				
				if($type=="expanded"){
					$dateRange=addslashes($_POST['DaySheetExpanded']['start_date']).' - '.addslashes($_POST['DaySheetExpanded']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['DaySheetExpanded']['start_date']);
					$endDate=Helper::getActualDateFormatToDB($_POST['DaySheetExpanded']['end_date']);
					$queryParts .=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
					$queryPartsVisit .=" and DATE(ujv.job_start_date) <= '$endDate' and ujv.job_start_date >= '$startDate'";
					$customerName=addslashes($_POST['DaySheetExpanded']['customer_name']);
					$showOnlyStartTime = 0;
					if($_POST['DaySheetExpanded']['show_start_time']){
						$showOnlyStartTime = $_POST['DaySheetExpanded']['show_start_time'];
					}
					if($customerName)
						$queryParts .=" and uc.customer_name like '%".$customerName."%'";
						$queryPartsVisit .=" and uc.customer_name like '%".$customerName."%'";
					$job_po_number=addslashes($_POST['DaySheetExpanded']['job_po_number']);
					if($job_po_number)
						$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'";
						$queryPartsVisit .=" and uj.job_po_number like '%".$job_po_number."%'";
					if(!empty($_POST['DaySheetExpanded']['job_techs']) && $_POST['DaySheetExpanded']['job_techs'][0]!=''){
						$expJobTechs = $_POST['DaySheetExpanded']['job_techs'];
						if (($key = array_search('00', $expJobTechs)) !== false) {
							unset($expJobTechs[$key]);
						}
						if(!empty($expJobTechs)){
							$job_techs='('.ltrim(implode(',', $expJobTechs),',').')';
						}else{
							$job_techs="('')";
							$unasOnly = 1;
						}
						$techQueryPart=" and ujaw.ubase_user_id in $job_techs ";
						$techQueryPartVisit=" and jaw.ubase_user_id in $job_techs ";
					
					}
					if(!empty($_POST['DaySheetExpanded']['job_techs']) && in_array('00', $_POST['DaySheetExpanded']['job_techs'])){ // Ticket #2623
						$noTechsFlag = 1;
					}
					if(!empty($_POST['DaySheetExpanded']['job_status'])){
						$cmp = '';
						//$jobStatuses = implode(', ', $_POST['DaySheetExpanded']['job_status']);
						if(!in_array("'CLOSED'",$_POST['DaySheetExpanded']['job_status'])){
							$completedId = Jobs::getWorkerMasterStatusID('10_CMP',$companyId);
							$queryParts .= " and ms.id!=$completedId ";
							$queryPartsVisit .= " and ms.id!=$completedId ";
						}
						else{
							$completedId = Jobs::getWorkerMasterStatusID('10_CMP',$companyId);
							$cmp .='OR (ms.id='.$completedId.')';
						}
						$estCode = ",'ESTIMATE'"; // For Ticket #2502
						$job_status='('.implode(', ', $_POST['DaySheetExpanded']['job_status']).$estCode.')';
						$queryParts .=" and (msc.code in $job_status $cmp) ";
						$queryPartsVisit .=" and (msc.code in $job_status $cmp) ";
						//echo $queryParts;exit;
					}
					else{
						$queryParts .=" and msc.code in ('ESTIMATE')";
						$queryPartsVisit .=" and msc.code in ('ESTIMATE')";
					}
					$includeEmail=$_POST['DaySheetExpanded']['include_email'];
				}else  if($type=="tech"){
					$dateRange=addslashes($_POST['DaySheetTech']['start_date']).' - '.addslashes($_POST['DaySheetTech']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['DaySheetTech']['start_date']);
	    			$endDate=Helper::getActualDateFormatToDB($_POST['DaySheetTech']['end_date']);
					$queryParts .=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
					$queryPartsVisit .=" and DATE(ujv.job_start_date) <= '$endDate' and ujv.job_start_date >= '$startDate'";
					$customerName=addslashes($_POST['DaySheetTech']['customer_name']);
					$showOnlyStartTime = 0;
					if($_POST['DaySheetTech']['show_start_time']){
						$showOnlyStartTime = $_POST['DaySheetTech']['show_start_time'];
					}
	    			if($customerName)
	    			 	$queryParts .=" and uc.customer_name like '%".$customerName."%'";
	    				$queryPartsVisit .=" and uc.customer_name like '%".$customerName."%'";
	    			$job_po_number=addslashes($_POST['DaySheetTech']['job_po_number']);
	    			if($job_po_number)
	    				$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'"; 
	    				$queryPartsVisit .=" and uj.job_po_number like '%".$job_po_number."%'";
	    			if(!empty($_POST['DaySheetTech']['job_techs']) && $_POST['DaySheetTech']['job_techs'][0]!=''){
	    				$daySheetJobTechs = $_POST['DaySheetTech']['job_techs'];
	    				if (($key = array_search('00', $daySheetJobTechs)) !== false) {
	    					unset($daySheetJobTechs[$key]);
	    				}
	    				if(!empty($daySheetJobTechs)){
	    					$job_techs='('.ltrim(implode(',', $daySheetJobTechs),',').')';
	    				}else{
	    					$job_techs="('')";
	    					$unasOnly = 1;
	    				}
	    				$techQueryPart=" and ujaw.ubase_user_id in $job_techs ";
	    				$techQueryPartVisit=" and jaw.ubase_user_id in $job_techs ";		    				    			
	    				
	    			}
	    			if(!empty($_POST['DaySheetTech']['job_techs']) && in_array('00', $_POST['DaySheetTech']['job_techs'])){ // Ticket #2623
	    				$noTechsFlag = 1; 
	    			}
	    			if(!empty($_POST['DaySheetTech']['job_status'])){
	    				$cmp = '';
	    				//$jobStatuses = implode(', ', $_POST['DaySheetTech']['job_status']);
	    				if(!in_array("'CLOSED'",$_POST['DaySheetTech']['job_status'])){
	    					$completedId = Jobs::getWorkerMasterStatusID('10_CMP',$companyId);
	    					$queryParts .= " and ms.id!=$completedId ";
	    					$queryPartsVisit .= " and ms.id!=$completedId ";
	    				}
	    				else{
	    					$completedId = Jobs::getWorkerMasterStatusID('10_CMP',$companyId);
	    					$cmp .='OR (ms.id='.$completedId.')';
	    				}
	    				$estCode = ",'ESTIMATE'"; // For Ticket #2502
	    				$job_status='('.implode(', ', $_POST['DaySheetTech']['job_status']).$estCode.')';
	    		 		$queryParts .=" and (msc.code in $job_status $cmp) ";
	    		 		$queryPartsVisit .=" and (msc.code in $job_status $cmp) ";
	    		 		//echo $queryParts;exit;
	    			}
	    			else{
	    				$queryParts .=" and msc.code in ('ESTIMATE')";
	    				$queryPartsVisit .=" and msc.code in ('ESTIMATE')";
	    			}
	    			$includeEmail=$_POST['DaySheetTech']['include_email'];
				}else  if($type=="workorder"){
					$dateRange=addslashes($_POST['DaySheetWorkOrder']['start_date']).' - '.addslashes($_POST['DaySheetWorkOrder']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['DaySheetWorkOrder']['start_date']);
	    			$endDate=Helper::getActualDateFormatToDB($_POST['DaySheetWorkOrder']['end_date']);
					$queryParts .=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
					$queryPartsVisit .=" and DATE(ujv.job_start_date) <= '$endDate' and ujv.job_start_date >= '$startDate'";
					$customerName=addslashes($_POST['DaySheetWorkOrder']['customer_name']);
					$showOnlyStartTime = 0;
					if($_POST['DaySheetWorkOrder']['show_start_time']){
						$showOnlyStartTime = $_POST['DaySheetWorkOrder']['show_start_time'];
					}
	    			if($customerName)
	    			 	$queryParts .=" and uc.customer_name like '%".$customerName."%'";
	    				$queryPartsVisit .=" and uc.customer_name like '%".$customerName."%'";
	    			$job_po_number=addslashes($_POST['DaySheetWorkOrder']['job_po_number']);
	    			if($job_po_number)
	    				$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'"; 
	    				$queryPartsVisit .=" and uj.job_po_number like '%".$job_po_number."%'";
	    			if(!empty($_POST['DaySheetWorkOrder']['job_techs']) && $_POST['DaySheetWorkOrder']['job_techs'][0]!=''){
	    				$job_techs='('.ltrim(implode(',', $_POST['DaySheetWorkOrder']['job_techs']),',').')';
	    				$techQueryPart=" and ujaw.ubase_user_id in $job_techs ";
	    				$techQueryPartVisit=" and jaw.ubase_user_id in $job_techs ";
	    				
	    			}
	    			if(!empty($_POST['DaySheetWorkOrder']['job_status'])){
	    				$cmp = '';
	    				//$jobStatuses = implode(', ', $_POST['DaySheetTech']['job_status']);
	    				if(!in_array("'CLOSED'",$_POST['DaySheetWorkOrder']['job_status'])){
	    					$completedId = Jobs::getWorkerMasterStatusID('10_CMP',$companyId);
	    					$queryParts .= " and ms.id!=$completedId ";
	    					$queryPartsVisit .= " and ms.id!=$completedId ";
	    				}
	    				else{
	    					$completedId = Jobs::getWorkerMasterStatusID('10_CMP',$companyId);
	    					$cmp .='OR (ms.id='.$completedId.')';
	    				}
	    				$estCode = ",'ESTIMATE'"; // For Ticket #2502
	    				$job_status='('.implode(', ', $_POST['DaySheetWorkOrder']['job_status']).$estCode.')';
	    		 		$queryParts .=" and (msc.code in $job_status $cmp) ";
	    		 		$queryPartsVisit .=" and (msc.code in $job_status $cmp) ";
	    		 		//echo $queryParts;exit;
	    			}
	    			else{
	    				$queryParts .=" and msc.code in ('ESTIMATE')";
	    				$queryPartsVisit .=" and msc.code in ('ESTIMATE')";
	    			}
	    			$includeEmail=$_POST['DaySheetWorkOrder']['include_email'];
				}
				
				break;
			default:
				$dateRange='';
				break;
		}
		$estimate = array();
		//echo $queryParts."<br /><br />".$queryPartsVisit;die;
		if($type=="expanded"){
			$reports=Reports::daySheetExpanded($from,$type,$queryParts,$techQueryPart,$queryPartsVisit,$techQueryPartVisit,$noTechsFlag,$unasOnly);
			$this->renderPartial('daySheetExpanded',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company,'showOnlyStartTime'=>$showOnlyStartTime,'includeEmail'=>$includeEmail));
		}else if($type=="tech"){
			$reports=Reports::daySheet($from,$type,$queryParts,$techQueryPart,$queryPartsVisit,$techQueryPartVisit,$noTechsFlag,$unasOnly);
			$this->renderPartial('daySheetByTech',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company,'showOnlyStartTime'=>$showOnlyStartTime,'includeEmail'=>$includeEmail));
		}
		else if($type=="workorder"){
			$reports=Reports::daySheetWorkOrder($from,$type,$queryParts,$techQueryPart,$queryPartsVisit,$techQueryPartVisit);
			$this->renderPartial('daySheetByWorkOrder',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company,'showOnlyStartTime'=>$showOnlyStartTime,'estimate'=>$estimate,'includeEmail'=>$includeEmail));
		}
		unset($reports);
		
	}
	
	public function actionTransactions()
	{
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Sales_Revenue");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}
		$type=Yii::app()->request->getParam('type','default');
		$from=Yii::app()->request->getParam('from','default');
		$companyId =addslashes(Yii::app()->session['companyId']);
		$sql = "select company_name , company_logo from ubase_companies where id=$companyId";
		$company= Yii::app()->db->createCommand($sql)->queryRow();
		$queryParts='';
		switch ($from) {
			case 'last_12_months':
				$time = strtotime("-1 year", time());
			   	$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",$time))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d")));	
				$startDate=date("Y-m-d",strtotime(date("Y-m-d",$time)));
				$endDate=date('Y-m-d H:i:s',strtotime(date("Y-m-d")));
			   	$queryParts=" and DATE(up.received_on) <= '$endDate' and up.received_on >= '$startDate'";
			   	break;
			case 'last_month':
			    $dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('first day of last month')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("last day of last month"))));	
				$startDate=date("Y-m-d",strtotime(date("Y-m-d",strtotime('first day of last month'))));
				$endDate=date('Y-m-d',strtotime(date("Y-m-d",strtotime("last day of last month"))));
			   	$queryParts=" and DATE(up.received_on) <= '$endDate' and up.received_on >= '$startDate'";
			    break;
			case 'this_month':
			    $dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('first day of this month')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d")));	
				$startDate=date("Y-m-d",strtotime(date("Y-m-d",strtotime('first day of this month'))));
				$endDate=date('Y-m-d H:i:s',strtotime(date("Y-m-d")));
			   	$queryParts=" and DATE(up.received_on) <= '$endDate' and up.received_on >= '$startDate'";
			    break;
			case 'this_week':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('sunday last week')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d")));	
				$startDate=date("Y-m-d",strtotime('sunday last week'));
				$endDate=date('Y-m-d H:i:s',strtotime(date("Y-m-d")));
			   	$queryParts=" and DATE(up.received_on) <= '$endDate' and up.received_on >= '$startDate'";
				break;
			case 'custom':	
				if($type=='customer'){
					$dateRange=addslashes($_POST['CustomerTrans']['start_date']).' - '.addslashes($_POST['CustomerTrans']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['CustomerTrans']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['CustomerTrans']['end_date']);
					$queryParts .=" and DATE(up.received_on) <= '$endDate' and up.received_on >= '$startDate'";
					$trans_types='';
					if(!empty($_POST['CustomerTrans']['trans_types']) && $_POST['CustomerTrans']['trans_types'][0]!=''){
	    				foreach ($_POST['CustomerTrans']['trans_types'] as $types){
	    					$trans_types .=",'".$types."'";
	    				}
	    				$trans_types=ltrim($trans_types,',');
	    				$queryParts .=" and up.transaction_type in ($trans_types)";
	    			}
	    			$payment_types='';
	    			if(!empty($_POST['CustomerTrans']['pay_methods']) && $_POST['CustomerTrans']['pay_methods'][0]!=''){
	    				foreach ($_POST['CustomerTrans']['pay_methods'] as $types){
	    					$payment_types .=",'".$types."'";
	    				}
	    				$payment_types=ltrim($payment_types,',');
	    				$queryParts .=" and upt.id in ($payment_types)";
	    			}
	    	
					if(isset($_POST['CustomerTrans']['customer_name']) && $_POST['CustomerTrans']['customer_name']!=''){
    			 		$queryParts .=" and uc.customer_name like '%".$_POST['CustomerTrans']['customer_name']."%'";
    				}
    				
					if(isset($_POST['CustomerTrans']['job_id']) && $_POST['CustomerTrans']['job_id']!=''){
    			 		$queryParts .=" and uj.id like '%".$_POST['CustomerTrans']['job_id']."%'";
    				}
    				
					if(isset($_POST['CustomerTrans']['memo']) && $_POST['CustomerTrans']['memo']!=''){
    			 		$queryParts .=" and up.memo like '%".$_POST['CustomerTrans']['memo']."%'";
    				}
    				
	    			if(!empty($_POST['CustomerTrans']['job_techs']) && $_POST['CustomerTrans']['job_techs'][0]!=''){
	    				$job_techs='('.ltrim(implode(',', $_POST['CustomerTrans']['job_techs']),',').')';
	    				$queryParts.=" and uu.id in $job_techs ";
	    			}
	    			
				}
				else if($type=='tech'){
					$dateRange=addslashes($_POST['TechTrans']['start_date']).' - '.addslashes($_POST['TechTrans']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['TechTrans']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['TechTrans']['end_date']);
					$queryParts .=" and DATE(up.received_on) <= '$endDate' and up.received_on >= '$startDate'";
					
					$trans_types='';
					if(!empty($_POST['TechTrans']['trans_types']) && $_POST['TechTrans']['trans_types'][0]!=''){
	    				foreach ($_POST['TechTrans']['trans_types'] as $types){
	    					$trans_types .=",'".$types."'";
	    				}
	    				$trans_types=ltrim($trans_types,',');
	    				$queryParts .=" and up.transaction_type in ($trans_types)";
	    			}
	    			$payment_types='';
	    			if(!empty($_POST['TechTrans']['pay_methods']) && $_POST['TechTrans']['pay_methods'][0]!=''){
	    				foreach ($_POST['TechTrans']['pay_methods'] as $types){
	    					$payment_types .=",'".$types."'";
	    				}
	    				$payment_types=ltrim($payment_types,',');
	    				$queryParts .=" and upt.id in ($payment_types)";
	    			}
	    			
					if(isset($_POST['TechTrans']['customer_name']) && $_POST['TechTrans']['customer_name']!=''){
    			 		$queryParts.=" and uc.customer_name like '%".$_POST['TechTrans']['customer_name']."%'";
    				}
    				
					if(isset($_POST['TechTrans']['job_id']) && $_POST['TechTrans']['job_id']!=''){
    			 		$queryParts.=" and uj.id like '%".$_POST['TechTrans']['job_id']."%'";
    				}
    				
					if(isset($_POST['TechTrans']['memo']) && $_POST['TechTrans']['memo']!=''){
    			 		$queryParts.=" and up.memo like '%".$_POST['TechTrans']['memo']."%'";
    				}
    				
	    			if(!empty($_POST['TechTrans']['job_techs']) && $_POST['TechTrans']['job_techs'][0]!=''){
	    				$job_techs='('.ltrim(implode(',', $_POST['TechTrans']['job_techs']),',').')';
	    				$queryParts.=" and uu.id in $job_techs ";
	    			}
				}
				else{
					$dateRange=addslashes($_POST['JobTrans']['start_date']).' - '.addslashes($_POST['JobTrans']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['JobTrans']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['JobTrans']['end_date']);
					$queryParts .=" and DATE(up.received_on) <= '$endDate' and up.received_on >= '$startDate'";
					
					$trans_types='';
					if(!empty($_POST['JobTrans']['trans_types']) && $_POST['JobTrans']['trans_types'][0]!=''){
	    				foreach ($_POST['JobTrans']['trans_types'] as $types){
	    					$trans_types .=",'".$types."'";
	    				}
	    				$trans_types=ltrim($trans_types,',');
	    				$queryParts .=" and up.transaction_type in ($trans_types)";
	    			}
	    			$payment_types='';
	    			if(!empty($_POST['JobTrans']['pay_methods']) && $_POST['JobTrans']['pay_methods'][0]!=''){
	    				foreach ($_POST['JobTrans']['pay_methods'] as $types){
	    					$payment_types .=",'".$types."'";
	    				}
	    				$payment_types=ltrim($payment_types,',');
	    				$queryParts .=" and upt.id in ($payment_types)";
	    			}
					if(isset($_POST['JobTrans']['customer_name']) && $_POST['JobTrans']['customer_name']!=''){
    			 		$queryParts.=" and uc.customer_name like '%".$_POST['JobTrans']['customer_name']."%'";
    				}
    				
					if(isset($_POST['JobTrans']['job_id']) && $_POST['JobTrans']['job_id']!=''){
    			 		$queryParts.=" and uj.id like '%".$_POST['JobTrans']['job_id']."%'";
    				}
    				
					if(isset($_POST['JobTrans']['memo']) && $_POST['JobTrans']['memo']!=''){
    			 		$queryParts.=" and up.memo like '%".$_POST['JobTrans']['memo']."%'";
    				}
    				
	    			if(!empty($_POST['JobTrans']['job_techs']) && $_POST['JobTrans']['job_techs'][0]!=''){
	    				$job_techs='('.ltrim(implode(',', $_POST['JobTrans']['job_techs']),',').')';
	    				$queryParts.=" and uu.id in $job_techs ";
	    			}
				}
				break;
			default :
				$dateRange='';
				break;
		}
		if($type=='customer'){
			$reports=Reports::transactionsByCustomer($queryParts);
			$this->renderPartial('transactionsByCustomer',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}
		else if($type=='tech'){
			$reports=Reports::transactionsByTech($queryParts);
			$this->renderPartial('transactionsByTech',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}
		else if($type=='job'){
			$reports=Reports::transactionsByJob($queryParts);
			$this->renderPartial('transactionByJob',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}
		
		unset($reports);
		unset($company);
	}
	/**
	 * @author Nabeel
	 * Product Sales by Customer Report
	 */
	public function actionCustomProductSalesByCustomer()
	{	
	
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Sales_Commission");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}
		$type=Yii::app()->request->getParam('type','default');
		$from=Yii::app()->request->getParam('from','default');
		$companyId =addslashes(Yii::app()->session['companyId']);
		$sql = "select company_name , company_logo from ubase_companies where id=$companyId";
		$company= Yii::app()->db->createCommand($sql)->queryRow();
		$servicePart=$productPart=$queryParts='';
		switch ($from) {
			case 'last_month':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('first day of last month')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("last day of last month"))));
				$startDate=date("Y-m-d",strtotime(date("Y-m-d",strtotime('first day of last month'))));
				$endDate=date('Y-m-d',strtotime(date("Y-m-d",strtotime("last day of last month"))));
				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				break;
			case 'last_2_weeks':
			   	$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("-3 sunday")))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('saturday last week'))));	
				$startDate=date("Y-m-d",strtotime("-3 sunday"));
				$endDate=date("Y-m-d",strtotime('saturday last week'));
				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
			   	break;
			case 'last_week':
			    //$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('monday last week')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("sunday last week"))));
			    $dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('-2 sunday')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("saturday last week"))));	
				$startDate=date("Y-m-d",strtotime("-2 sunday"));
				$endDate=date("Y-m-d",strtotime('saturday last week'));
				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
			    break;
			
			case 'this_week':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('sunday last week')))).' - '.date(Yii::app()->session['dateFormat'],strtotime("saturday this week"));	
				$startDate=date("Y-m-d",strtotime("sunday last week"));
				$endDate=date("Y-m-d",strtotime("saturday this week"));
				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				break;
			case 'custom':
					
		 		if($_POST['ProdSalesCus']['closed_at_start_date'] && $_POST['ProdSalesCus']['closed_at_end_date']){
    				$sDate=Helper::getActualDateFormatToDB($_POST['ProdSalesCus']['closed_at_start_date']);
    				$eDate=Helper::getActualDateFormatToDB($_POST['ProdSalesCus']['closed_at_end_date']);
    				$queryParts .=" and DATE(uj.closed_at ) <= '$eDate' and DATE(uj.closed_at)  >= '$sDate'";
    			}
				if($_POST['ProdSalesCus']['start_date'] && $_POST['ProdSalesCus']['end_date']){
    				$startDate=Helper::getActualDateFormatToDB($_POST['ProdSalesCus']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['ProdSalesCus']['end_date']);
    				$queryParts .=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
    			}
			    else{
			    	$startDate=$sDate;
			    	$endDate=$eDate;
			    }
    			$dateRange=addslashes($_POST['ProdSalesCus']['start_date']).' - '.addslashes($_POST['ProdSalesCus']['end_date']);
    			$customerName=addslashes($_POST['ProdSalesCus']['customer_name']);
    			if($customerName)
    			 	$queryParts .=" and uc.customer_name like '%".$customerName."%'";
    			$job_po_number=addslashes($_POST['ProdSalesCus']['job_po_number']);
    			if($job_po_number)
    				$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'"; 
    			if(!empty($_POST['ProdSalesCus']['job_techs']) && $_POST['ProdSalesCus']['job_techs'][0]!=''){
    				$job_techs='('.ltrim(implode(',', $_POST['ProdSalesCus']['job_techs']),',').')';
    				$queryParts .=" and user.ubase_user_id in $job_techs ";
    			}
    			if(!empty($_POST['ProdSalesCus']['job_status'])){
    				$job_status='('.implode(', ', $_POST['ProdSalesCus']['job_status']).')';
    		 		$queryParts .=" and msc.code in $job_status";
    			}
				break;
			default:
				$dateRange='';
				break;
		}
		//echo $queryParts;die();		
		$reports=Reports::getProductSalesByCustomerReport($from,$type,$queryParts,$servicePart,$productPart,$startDate,$endDate);
		$this->renderPartial('productSalesByCustomer',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		
		unset($reports);
		unset($company);
	}
	/*
	 * @author Riyas
	 * Ticket 2427
	 * */
	public function actionServiceAgreement()
	{
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Payroll");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			//$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}
		$type=Yii::app()->request->getParam('type','default');
		$from=Yii::app()->request->getParam('from','default');
		$companyId =addslashes(Yii::app()->session['companyId']);

		$sql = "select company_name , company_logo from ubase_companies where id=$companyId";
		$company= Yii::app()->db->createCommand($sql)->queryRow();
		$techQueryPart=$queryParts='';
		switch ($from) {
			case 'expired':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d")));
				$startDate=date("Y-m-d");
				$queryParts=" DATE(ucsa.date_expires) < '$startDate' AND ucsa.date_expires != '0000-00-00'";
				break;
			case 'expire_this_month':
				$startDate = date("Y-m-d",strtotime(date("Y-m-d",strtotime('first day of this month'))));
				$endDate = date("Y-m-d",strtotime(date("Y-m-d",strtotime('last day of this month'))));
				$dateRange = $startDate."-".$endDate;
				$queryParts=" DATE(ucsa.date_expires) >= '$startDate' and DATE(ucsa.date_expires) <= '$endDate' ";
				break;
					
			case 'expire_next_month':
				$startDate = date("Y-m-d",strtotime(date("Y-m-d",strtotime('first day of next month'))));
				$endDate = date("Y-m-d",strtotime(date("Y-m-d",strtotime('last day of next month'))));
				$dateRange = $startDate."-".$endDate;
				$queryParts=" DATE(ucsa.date_expires) >= '$startDate' and DATE(ucsa.date_expires) <= '$endDate' ";
				break;
				
			case 'open_ended':
				$dateRange = '';
				$queryParts=" (ucsa.date_expires IS NULL OR ucsa.date_expires = '0000-00-00') ";
				break;
				
			case 'custom':
		
					$dateRange=addslashes($_POST['ServiceAgreement']['start_date']).' - '.addslashes($_POST['ServiceAgreement']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['ServiceAgreement']['start_date']);
					$endDate=Helper::getActualDateFormatToDB($_POST['ServiceAgreement']['end_date']);
					$dateRange = $startDate."-".$endDate;
					$reportDate = addslashes($_POST['ServiceAgreement']["report_date"]);
					$queryParts=" DATE(ucsa.".$reportDate.") >= '$startDate' and DATE(ucsa.".$reportDate.") <= '$endDate' ";
					
					$agreementName=addslashes($_POST['ServiceAgreement']['agreement_name']);
					if($agreementName)
						$queryParts .=" AND ucsa.name like '%".$agreementName."%'";
				
				break;
			default:
				$dateRange='';
				break;
		}
		
		$reports=Reports::serviceAgreementReport($dateRange,$type,$queryParts);
			
		unset($reports);
		unset($company);
	}
	/**
	 * Function to generate expense report
	 * @author Nabeel
	 * Ticket #2391
	 */
	public function actionExpenses()
	{
		$job_techs =$exp_categories =$cusName = $poNo = '';
		$urlFlag = 0;
		$clsFlag = 0;
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Payroll");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}
		$type=Yii::app()->request->getParam('type','default');
		$from=Yii::app()->request->getParam('from','default');
		$print=Yii::app()->request->getParam('print','default');
		$categ=Yii::app()->request->getParam('categs','default');
		$job_techsUrl=Yii::app()->request->getParam('job_techs','default');
		$clFlagUrl=Yii::app()->request->getParam('cls','default');
		$cusNameUrl=Yii::app()->request->getParam('cusName','default');
		$poNoUrl=Yii::app()->request->getParam('poNo','default');
		$companyId =addslashes(Yii::app()->session['companyId']);
		$noDays = 0;
		$sql = "select company_name , company_logo from ubase_companies where id=$companyId";
		$company= Yii::app()->db->createCommand($sql)->queryRow();
		$queryStringTech =$techQueryPart='';
		$categPrint = "";
		if($print=='true'){
			$startDate = Helper::getActualDateFormatToDB(addslashes(Yii::app()->request->getParam('startdate','default')));
			$endDate = Helper::getActualDateFormatToDB(addslashes(Yii::app()->request->getParam('enddate','default')));
		}
		switch ($from) {
			case 'last_2_weeks':
				$noDays = 14;
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("-3 sunday")))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('saturday last week'))));				
				$postStartDate = $startDate=date("Y-m-d",strtotime("-3 sunday"));
				$postEndDate = $endDate=date("Y-m-d",strtotime('saturday last week'));
				$queryString=" and DATE(jex.expense_date) <= '$endDate' and jex.expense_date >= '$startDate'";				
				break;
			case 'last_week':
				$noDays = 7;
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('-2 sunday')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("saturday last week"))));				
				$postStartDate = $startDate=date("Y-m-d",strtotime("-2 sunday"));
				$postEndDate = $endDate=date("Y-m-d",strtotime('saturday last week'));
				$queryString=" and DATE(jex.expense_date) <= '$endDate' and jex.expense_date >= '$startDate'";				
				break;
					
			case 'this_week':
				$noDays = 7;
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('-1 sunday')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("saturday this week"))));				
				$postStartDate = $startDate=date("Y-m-d",strtotime("-1 sunday"));
				$postEndDate = $endDate=date("Y-m-d",strtotime('saturday this week'));
				$queryString=" and DATE(jex.expense_date) <= '$endDate' and jex.expense_date >= '$startDate'";				
				break;
			case 'custom':
								
					$dateRange=addslashes($_POST['ExpenseEmployee']['start_date']).' - '.addslashes($_POST['ExpenseEmployee']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['ExpenseEmployee']['start_date']);
					$endDate=Helper::getActualDateFormatToDB($_POST['ExpenseEmployee']['end_date']);
					if($print=='true'){
						$startDate = Helper::getActualDateFormatToDB(addslashes(Yii::app()->request->getParam('startdate','default')));
						$endDate = Helper::getActualDateFormatToDB(addslashes(Yii::app()->request->getParam('enddate','default')));
						if($startDate!='' && $endDate!=''){
							$dateRange=date(Yii::app()->session['dateFormat'],strtotime($startDate)).' - '.date(Yii::app()->session['dateFormat'],strtotime($endDate));
						}
					}
					$startingDate = strtotime($startDate);
					$endingDate = strtotime($endDate);
					$datediff = $endingDate - $startingDate;
					$noDays = floor($datediff/(60*60*24));
					
					$queryString=" and DATE(jex.expense_date) <= '$endDate' and jex.expense_date >= '$startDate'";
					if(!empty($_POST['ExpenseEmployee']['job_techs']) && $_POST['ExpenseEmployee']['job_techs'][0]!=''){
						$job_techs='('.ltrim(implode(',', $_POST['ExpenseEmployee']['job_techs']),',').')';
						$queryStringTech.=" and jex.ubase_user_id in $job_techs ";
						$techQueryPart=" and jex.ubase_user_id in $job_techs ";
						$jobTechsPrint = $job_techs;
					}elseif($job_techsUrl!='' && $job_techsUrl!='default' && $print=='true'){
						$techQueryPart=" and jex.ubase_user_id in $job_techsUrl ";
					}
					if(!empty($_POST['ExpenseEmployee']['exp_categories']) && $_POST['ExpenseEmployee']['exp_categories'][0]!=''){
						$exp_categories='('.ltrim(implode(',', $_POST['ExpenseEmployee']['exp_categories']),',').')';
						$queryString.=" and uec.id in $exp_categories ";
						$categPrint = $exp_categories;
					}elseif($categ!='' && $categ!='default' && $print=='true'){
						$queryString.=" and uec.id in $categ ";
					}									
					
					$customerName=addslashes($_POST['ExpenseEmployee']['customer_name']);
					if($customerName){
						$cusName = $customerName;
						$queryString .=" and uc.customer_name like '%".$customerName."%'";
					}elseif ($cusNameUrl!='' && $cusNameUrl!='default'){
						$queryString .=" and uc.customer_name like '%".$cusNameUrl."%'";
					}
					$job_po_number=addslashes($_POST['ExpenseEmployee']['job_po_number']);
					if($job_po_number){
						$poNo = $job_po_number;
						$queryString .=" and uj.job_po_number like '%".$job_po_number."%'";
					}elseif ($poNoUrl!='' && $poNoUrl!='default'){
						$queryString .=" and uj.job_po_number like '%".$poNoUrl."%'";
					}
					if(!empty($_POST['ExpenseEmployee']['job_status'])){
						$statArr = $_POST['ExpenseEmployee']['job_status'];						
						$cmplt_master_id = Jobs::getWorkerMasterStatusID('10_CMP',$companyId);
						$clsd_master_id = Jobs::getWorkerMasterStatusID('12_CLS',$companyId);
						$invcd_master_id = Jobs::getWorkerMasterStatusID('14_INV',$companyId);
						if(count($statArr)==1 && $statArr[0]=="'CLOSED'"){
							$clsFlag = 1;
							$queryString .=" and (ms.id=$cmplt_master_id OR ms.id=$clsd_master_id OR ms.id=$invcd_master_id) ";
						}elseif(count($statArr)==1 && $statArr[0]=="'OPEN','OPEN_ACTIVE'"){
							$queryString .=" and (ms.id!=$cmplt_master_id AND ms.id!=$clsd_master_id AND ms.id!=$invcd_master_id) ";
						}
					}elseif ($clFlagUrl!='' && $clFlagUrl!='default' && $print=='true'){
						$cmplt_master_id = Jobs::getWorkerMasterStatusID('10_CMP',$companyId);
						$clsd_master_id = Jobs::getWorkerMasterStatusID('12_CLS',$companyId);
						$invcd_master_id = Jobs::getWorkerMasterStatusID('14_INV',$companyId);
						if($clFlagUrl==1){
							$queryString .=" and (ms.id=$cmplt_master_id OR ms.id=$clsd_master_id OR ms.id=$invcd_master_id) ";
						}else{
							$queryString .=" and (ms.id!=$cmplt_master_id AND ms.id!=$clsd_master_id AND ms.id!=$invcd_master_id) ";
						}
					}
					$postStartDate = $startDate;
					$postEndDate = $endDate;
	
				break;
			default:
				$dateRange='';
				break;
		}
		//echo $queryString;die;
		if($type=='employee'){
			$reports=Reports::getExpensesReport($from,$type,$queryString,$queryStringTech,$techQueryPart);
			//$statusReports = Reports::hoursLaber($reports,$endDate);
			$statusReports = array();
			if($print=='true'){
				$this->renderPartial('expenseReportView',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company,'statusReports'=>$statusReports,'noDays'=>$noDays,'startDate'=>$startDate,'endDate'=>$endDate));
			}else{
				$this->render('expenseReport',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company,'statusReports'=>$statusReports,'noDays'=>$noDays,'startDate'=>$postStartDate,'endDate'=>$postEndDate,'from'=>$from,'type'=>$type,'jobTechs'=>$jobTechsPrint,'categPrint'=>$categPrint,'clsFlag'=>$clsFlag,'cusName'=>$cusName,'poNo'=>$poNo));
			}
		}
	
		unset($reports);
		unset($company);
	}
	public function actionSalesProductServices()
	{
	
		$accessPermission = Helper::getAccessPermissionDetails("Reports_Sales_Commission");
		if(isset($accessPermission) && $accessPermission->is_view_enabled != '1'){
			$this->redirect(Yii::app()->request->baseUrl."/accessDenied");
		}
		$type=Yii::app()->request->getParam('type','default');
		$from=Yii::app()->request->getParam('from','default');
		$companyId =addslashes(Yii::app()->session['companyId']);
		$sql = "select company_name , company_logo from ubase_companies where id=$companyId";
		$company= Yii::app()->db->createCommand($sql)->queryRow();
		$servicePart=$productPart=$queryParts='';
		switch ($from) {
			case 'last_2_weeks':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("-3 sunday")))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('saturday last week'))));
				$startDate=date("Y-m-d",strtotime("-3 sunday"));
				$endDate=date("Y-m-d",strtotime('saturday last week'));
				if($type==1){
					$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				}
				break;
			case 'last_week':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('monday last week')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime("sunday last week"))));
				$startDate=date("Y-m-d",strtotime("monday last week"));
				$endDate=date("Y-m-d",strtotime('sunday last week'));
				if($type==1){
					$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				}
				break;
					
			case 'this_week':
				$dateRange=date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('sunday last week')))).' - '.date(Yii::app()->session['dateFormat'],strtotime(date("Y-m-d",strtotime('saturday this week'))));
				$startDate=date("Y-m-d",strtotime("sunday last week"));
				$endDate=date("Y-m-d",strtotime("saturday this week"));
				if($type==1){
					$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
				}
				break;
			case 'custom':
				if($type==1){
					$dateRange=addslashes($_POST['SalesProductServices']['start_date']).' - '.addslashes($_POST['SalesProductServices']['end_date']);
					$startDate=Helper::getActualDateFormatToDB($_POST['SalesProductServices']['start_date']);
					$endDate=Helper::getActualDateFormatToDB($_POST['SalesProductServices']['end_date']);
					$queryParts .=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
	
					if(isset($_POST['SalesProductServices']['customer_name']) && $_POST['SalesProductServices']['customer_name']!=''){
						$queryParts.=" and uc.customer_name like '%".$_POST['SalesProductServices']['customer_name']."%'";
					}
					if(isset($_POST['SalesProductServices']['products']) && $_POST['SalesProductServices']['products']!=''){
						if($_POST['SalesProductServices']['products']!='all'){
							$productPart =" and ujpl.ubase_product_id=".$_POST['SalesProductServices']['products'];
						}else{
							$productPart ="";
						}
					}
					else{
						//$productPart='NOTSEARCH';
						$productPart='NONE';
					}
					if(isset($_POST['SalesProductServices']['services']) && $_POST['SalesProductServices']['services']!=''){
						if($_POST['SalesProductServices']['services']!='all'){
							$servicePart =" and ujsl.master_service_id=".$_POST['SalesProductServices']['services'];
						}else{
							$servicePart ="";
						}
					}
					else{
						//$servicePart='NOTSEARCH';
						$servicePart='NONE';
					}
					/*
					if(!empty($_POST['SalesProductServices']['job_agents']) && $_POST['SalesProductServices']['job_agents'][0]!=''){
						$job_techs='('.ltrim(implode(',', $_POST['SalesProductServices']['job_agents']),',').')';
						$queryParts.=" and user.ubase_user_id in $job_techs ";
					}
					*/
					if(!empty($_POST['SalesProductServices']['job_status']) && $_POST['SalesProductServices']['job_status'][0]!=''){
						$job_status='('.implode(', ', $_POST['SalesProductServices']['job_status']).')';
						$queryParts .=" and msc.code in $job_status";
					}
					else{
						$queryParts .=" and msc.code in ('')";
					}
				}
				break;
			default:
				$dateRange='';
				break;
		}
		//echo $servicePart."===".$productPart;die;
		if($type==1){
			$reports=Reports::salesProductServices($from,$type,$queryParts,$servicePart,$productPart);
			$this->renderPartial('salesProductsServices',array('reportArray'=>$reports,'dateRange'=>$dateRange,'company'=>$company));
		}
	
		unset($reports);
		unset($company);
	}


}
