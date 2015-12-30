<?php
/**
 * 
 * Enter description here ...
 * @author sujathan
 *
 */
class Reports extends CActiveRecord
{
	
 	public static function model($className=__CLASS__)
 	{
 		return parent::model($className);
 	}
 	public function tableName()
 	{
 		return '{{UNVETTED}}';
 	}
    /**
     * 
     * Enter description here ...
     * @param unknown_type $from
     */
    public function getSalesReportGeneral($from='',$type='')
    {
    	$result=Reports::getQueryParts($from,$type);
    	
    	$queryParts=$result[0];
    	$techQueryPart=$result[1];
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	/*$report = Yii::app()->db->createCommand()
				->select("uj.id as job_id,ujcs.category,uj.ubase_customer_id as customer_id,uj.job_start_date,uj.time_frame_promised_start as startTime,uj.public_notes,uj.job_po_number,uc.customer_name,ms.name as jobStatus,ujt.total_labor_charges,ujt.total_expense_charges,COALESCE(sum(ujsr.total),0) as serviceRate,COALESCE(sum(ujpr.total),0) as productRate,COALESCE(ujt.total_labor_charges,0)+COALESCE(ujt.total_expense_charges,0)+COALESCE(ujt.job_total,0)-COALESCE(ujt.job_total_payments,0) as total")
				->from('ubase_jobs uj')
				->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
				->join('master_statuses ms','uj.master_status_id = ms.id')
				->join('ubase_job_totals ujt','ujt.ubase_job_id = uj.id')
				->join('master_status_categories msc','ms.master_status_category_id=msc.id')
				->leftjoin('ubase_job_service_rates ujsr','ujsr.ubase_job_id = uj.id')   
				->leftjoin('ubase_job_product_rates ujpr','ujpr.ubase_job_id = uj.id') 
				->leftjoin('ubase_job_categories ujcs','ujcs.id  = uj.ubase_job_categories_id')           
				->where("msc.code != 'ESTIMATE' AND uj.ubase_company_id=$companyId  $queryParts")
				->group('uj.id,uj.job_start_date')
				->order('uj.job_start_date asc,uj.time_frame_promised_start asc')
				->queryAll();*/
    	
    	$report = Yii::app()->db->createCommand()
		    	 ->select("uj.id as job_id, uj.job_number, ujcs.category,uj.ubase_customer_id as customer_id,uj.job_start_date,uj.time_frame_promised_start as startTime,uj.public_notes,uj.job_po_number,uc.customer_name,ms.name as jobStatus,ujt.total_labor_charges,ujt.total_expense_charges,COALESCE(ujsr.serviceRate,0) as serviceRate,COALESCE(ujpr.productRate,0) as productRate,COALESCE(ujt.total_labor_charges,0)+COALESCE(ujt.total_expense_charges,0)+COALESCE(ujt.job_total,0) as total")
		    	->from('ubase_jobs uj')
			    	->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
			    	->join('master_statuses ms','uj.master_status_id = ms.id')
			    	->join('ubase_job_totals ujt','ujt.ubase_job_id = uj.id')
			    	->join('master_status_categories msc','ms.master_status_category_id=msc.id')
			    	->leftjoin('
			    				(SELECT ubase_job_id, sum(total)  serviceRate FROM  ubase_job_service_rates GROUP BY ubase_job_id) ujsr','ujsr.ubase_job_id = uj.id'
							  )
			    	->leftjoin('
			    				(SELECT ubase_job_id,sum(total) as productRate  FROM  ubase_job_product_rates GROUP BY ubase_job_id) ujpr','ujpr.ubase_job_id = uj.id'
							  )
			    	->leftjoin('ubase_job_categories ujcs','ujcs.id  = uj.ubase_job_categories_id')
		    	->where("msc.code != 'ESTIMATE' AND uj.ubase_company_id=$companyId  $queryParts")
		    	->group('uj.id,uj.job_start_date')
		    	->order('uj.job_start_date asc,uj.time_frame_promised_start asc')
		    	->queryAll();
    	
    	
		foreach ($report as $index=>$row){//for selecting job assigned workers
			$jobId=$row['job_id'];
			$jobAssignedWorkers = Yii::app()->db->createCommand()
								->select("ujaw.ubase_user_id as user_id")
								->from('ubase_job_assigned_workers ujaw')
								->where("ujaw.ubase_job_id=$jobId and ujaw.is_deleted='0' $techQueryPart")
								->queryColumn();
			//$report[$index]['users']=implode(',',$jobAssignedWorkers);
			$report[$index]['users']=$jobAssignedWorkers;
			if($techQueryPart!='' && empty($jobAssignedWorkers)){
				unset($report[$index]);
			}

            

		}  
		
		if(isset($_POST['Ungrouped']['JobCharges']) && $_POST['Ungrouped']['JobCharges']==1){
            foreach ($report as $index=>$row){
             $id=$row['job_id'];   
            $modelJobServiceLists = JobServiceLists::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$id));
            $modelJobServiceRates = JobServiceRates::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$id));
            
			$report['labortimes'][$id] = Jobs::model()->jobClosingDetails($id, $row['customer_id'], $companyId);
			$report['expenses'][$id] = Jobs::model()->jobExpenseDetails($id, $row['customer_id'], $companyId);
			$report['jobTotal'][$id] = Jobs::model()->JobTotalDetails($id);
            $tempArray = array();
            $b=0;
            $duplicates = false;
            $modelJobRateServiceProductGroup = $modelJobChargesListsArray = array();
            foreach($modelJobServiceRates as $serviceRate){
                $tempArray[$b] = $serviceRate['item_index'];
                $b++;
            }
            if (count(array_unique($tempArray)) != count($tempArray)){
                $duplicates = true;
            }
            if($duplicates){
                $v = 0;
                foreach($modelJobServiceRates as $serviceRate){
                    $serviceRate['item_index'] = $v;
                    $v++;
                }
            }
            
            $i=0;
            if(isset($modelJobServiceLists[0])){ 
                foreach($modelJobServiceLists as $serviceList){
                    $serviceListId = $serviceList['id'];
                    $serviceId = $serviceList['master_service_id'];
                    $sql = "select short_description from master_services where id=$serviceId";
                    $shortDescription=Yii::app()->db->createCommand($sql)->queryScalar();
                    foreach($modelJobServiceRates as $serviceRate){
                        if($serviceListId == $serviceRate['ubase_job_service_list_id']){
                            $sumTotalServices=0;
                            $sumTotalServices=($serviceRate['multiplier']*$serviceRate['rate']);
                            $serviceRate['short_name']=isset($serviceRate['short_name'])?$serviceRate['short_name']:'';
                            if($companyPreferences->include_longtext_on_workorders == 1){
                                $serviceRate['long_name']=isset($serviceRate['long_name'])?"<br />".nl2br($serviceRate['long_name']):'';
                            }else{
                                $serviceRate['long_name'] = '';
                            }
                            $serviceRate['item_index'] = ($serviceRate['item_index'] == '0') ? $i:$serviceRate['item_index'];
                            //$serviceRate['item_index'] = $i; // For 2288
                            $modelJobRateServiceProductGroup[$serviceRate['item_index']]['name'] = ucfirst($serviceRate['short_name']).$serviceRate['long_name'];
                            $modelJobRateServiceProductGroup[$serviceRate['item_index']]['multiplier'] = $serviceRate['multiplier'];
                            $modelJobRateServiceProductGroup[$serviceRate['item_index']]['rate'] = intval($serviceRate['rate']);
                            $modelJobRateServiceProductGroup[$serviceRate['item_index']]['total'] = $serviceRate['multiplier']*$serviceRate['rate'];
                            $modelJobRateServiceProductGroup[$serviceRate['item_index']]['parent_index'] = $serviceRate['parent_index'];
                            $modelJobRateServiceProductGroup[$serviceRate['item_index']]['item_index'] = $serviceRate['item_index'];
                            $modelJobRateServiceProductGroup[$serviceRate['item_index']]['is_group'] = 0;
                            $modelJobRateServiceProductGroup[$serviceRate['item_index']]['service_product_total'] = $sumTotalServices;
                            $modelJobRateServiceProductGroup[$serviceRate['item_index']]['show_rate_items'] = $serviceList['show_rate_items'];
                            $i++;
                        }
                    }
                }
            }

            $modelJobProductLists = JobProductLists::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$id));
            $modelJobProductRates = JobProductRates::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$id));
            
            $tempArray = array();
            $b=0;
            foreach($modelJobProductRates as $productRate){
                $tempArray[$b] = $productRate['item_index'];
                $b++;
            }
            if (count(array_unique($tempArray)) != count($tempArray)){
                $duplicates = true;
            }
            if($duplicates){
                foreach($modelJobProductRates as $productRate){
                    $productRate['item_index'] = $v;
                    $v++;
                }
            }
            
            $i = $i; // For 2288
            if(isset($modelJobProductLists[0])){
                foreach($modelJobProductLists as $productList){ 
                    $productListId = $productList['id'];
                    $productId = $productList['ubase_product_id'];
                    $sql = "select make,model,sku from ubase_products where id=$productId";
                    $make=Yii::app()->db->createCommand($sql)->queryRow();
                    foreach($modelJobProductRates as $productRate){
                        if($productListId == $productRate['ubase_job_product_list_id']){
                            $sumTotalProducts=0;    
                            $sumTotalProducts = ($productRate['multiplier']*$productRate['rate']);
                            $productRate['short_name']=isset($productRate['short_name'])?$productRate['short_name']:'';
                            if($companyPreferences->include_longtext_on_workorders == 1){
                                $productRate['long_name']=isset($productRate['long_name'])?"<br />".nl2br($productRate['long_name']):'';
                            }else{
                                $productRate['long_name'] = '';
                            }
                            $productRate['item_index'] = ($productRate['item_index'] == '0') ? $i:$productRate['item_index'];
                            $modelJobRateServiceProductGroup[$productRate['item_index']]['name'] = ucfirst($productRate['short_name']).$productRate['long_name'];
                            $modelJobRateServiceProductGroup[$productRate['item_index']]['multiplier'] = $productRate['multiplier'];
                            $modelJobRateServiceProductGroup[$productRate['item_index']]['rate'] = $productRate['rate'];
                            $modelJobRateServiceProductGroup[$productRate['item_index']]['total'] = $productRate['multiplier']*$productRate['rate'];
                            $modelJobRateServiceProductGroup[$productRate['item_index']]['parent_index'] = $productRate['parent_index'];
                            $modelJobRateServiceProductGroup[$productRate['item_index']]['item_index'] = $productRate['item_index'];
                            $modelJobRateServiceProductGroup[$productRate['item_index']]['is_group'] = 0;
                            $modelJobRateServiceProductGroup[$productRate['item_index']]['service_product_total'] = $sumTotalProducts;
                            $modelJobRateServiceProductGroup[$productRate['item_index']]['show_rate_items'] = $productList['show_rate_items'];
                            $i++;
                        }
                    }                                                   
                }                               
            }

            if(isset($modelJobRateServiceProductGroup)){
                $modelJobRateGroups = JobRateGroups::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$id));
                foreach ($modelJobRateServiceProductGroup as $elementKey => $proser) {
                
                    if(isset($modelJobRateGroups[0])){
                        foreach($modelJobRateGroups as $rateGroup){
                            if($proser['parent_index']==$rateGroup['item_index'] &&  $proser['show_rate_items']==0 && $rateGroup['show_rate_items']==0){
                                unset($modelJobRateServiceProductGroup[$elementKey]);
                            
                            }

                        }
                    }
                }
            }

            $modelJobRateGroups = JobRateGroups::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$id));
            
            $tempArray = array();
            $b=0;
            foreach($modelJobRateGroups as $rateGroup){
                $tempArray[$b] = $rateGroup['item_index'];
                $b++;
            }
            if (count(array_unique($tempArray)) != count($tempArray)){
                $duplicates = true;
            }
            if($duplicates){
                foreach($modelJobRateGroups as $rateGroup){
                    $rateGroup['item_index'] = $v;
                    $v++;
                }
            }
            
            if(isset($modelJobRateGroups[0])){
                foreach($modelJobRateGroups as $rateGroup){
                    
                    $rateGroup['group_name']='<b>'.$rateGroup['group_name'].'</b>';
                    if($companyPreferences->include_longtext_on_workorders == 1){
                        $rateGroup['group_long_name']=isset($rateGroup['group_long_name'])?"<br />".nl2br($rateGroup['group_long_name']):'';
                    }else{
                        $rateGroup['group_long_name'] = '';
                    }
                    $modelJobRateServiceProductGroup[$rateGroup['item_index']]['name'] = $rateGroup['group_name'].$rateGroup['group_long_name'];
                    $modelJobRateServiceProductGroup[$rateGroup['item_index']]['multiplier'] = '';
                    $modelJobRateServiceProductGroup[$rateGroup['item_index']]['rate'] = '';
                    $modelJobRateServiceProductGroup[$rateGroup['item_index']]['total'] = $rateGroup['group_total'];
                    $modelJobRateServiceProductGroup[$rateGroup['item_index']]['parent_index'] = $rateGroup['item_index'];
                    $modelJobRateServiceProductGroup[$rateGroup['item_index']]['item_index'] = $rateGroup['item_index'];
                    $modelJobRateServiceProductGroup[$rateGroup['item_index']]['is_group'] = 1;
                    $modelJobRateServiceProductGroup[$rateGroup['item_index']]['service_product_total'] = 0;
                    $i++;
                }
            }

            ksort($modelJobRateServiceProductGroup,1);
            $modelJobChargesLists = JobOtherCharges::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$id));
            if(!empty($modelJobRateServiceProductGroup)) 
            	$report['jobPrdtSevc'][$id] = $modelJobRateServiceProductGroup;
            $k = 0;
            foreach ($modelJobChargesLists as $charge){
                $modelJobChargesListsArray[$charge['parent_index']][$k]['id']=$charge['id'];
                $modelJobChargesListsArray[$charge['parent_index']][$k]['short_name']=$charge['short_name'];
                $modelJobChargesListsArray[$charge['parent_index']][$k]['is_percentage']=$charge['is_percentage'];
                $modelJobChargesListsArray[$charge['parent_index']][$k]['is_discount']=$charge['is_discount'];
                $modelJobChargesListsArray[$charge['parent_index']][$k]['rate']=$charge['rate'];
                $modelJobChargesListsArray[$charge['parent_index']][$k]['total']=$charge['total'];
              /*  $otherChargeDetails = OtherCharges::model()->find('id=:id',array('id'=>$charge['ubase_job_other_charge_id']));
                if($otherChargeDetails){
                    $modelJobChargesListsArray[$charge['parent_index']][$k]['applies_to_id_service']=$otherChargeDetails['applies_to_id_service'];
                    $modelJobChargesListsArray[$charge['parent_index']][$k]['applies_to_id_product']=$otherChargeDetails['applies_to_id_product'];
                    $modelJobChargesListsArray[$charge['parent_index']][$k]['applies_to_id_fee']=$otherChargeDetails['applies_to_id_fee'];
                    $modelJobChargesListsArray[$charge['parent_index']][$k]['category']=$otherChargeDetails['category'];
                    $modelJobChargesListsArray[$charge['parent_index']][$k]['type']=$otherChargeDetails['short_name'];
                }
                else{
                    $modelJobChargesListsArray[$charge['parent_index']][$k]['applies_to_id_service']="";
                    $modelJobChargesListsArray[$charge['parent_index']][$k]['applies_to_id_product']="";
                    $modelJobChargesListsArray[$charge['parent_index']][$k]['applies_to_id_fee']="";
                    $modelJobChargesListsArray[$charge['parent_index']][$k]['category']='';
                }*/
                $k++;
            }
            ksort($modelJobChargesListsArray,1);
            if(!empty($modelJobChargesListsArray)) 
            	$report['jobOtherCharge'][$id] = $modelJobChargesListsArray;
        }
    	}
    	//print_r($report);die;
		return $report;
    }
    /**
     * 
     * Enter description here ...
     * @param unknown_type $from
     */
	public function getSalesReportCustomer($from='',$type='')
    {
    	$report=array();
   		$customerJobs=Reports::getSalesReportGeneral($from,$type);
   		foreach ($customerJobs as $data){
                $report[$data['customer_id']][]=$data;
                $report[$data['customer_id']]['name']=$data['customer_name'];
        }
		usort($report, array("Helper", "cmp"));
		unset($customerJobs);
		return $report;
    }
 	
    /**
     * 
     * Enter description here ...
     * @param unknown_type $from
     */
	public function getSalesReportTech($from='',$type='')
    {
    	$report=array();
    	$customerJobs=Reports::getSalesReportGeneral($from,$type);
    	foreach ($customerJobs as $data){
                if(!empty($data['users'])){
                	foreach ($data['users'] as $userId){
                		$report[$userId][]=$data;
                		$report[$userId]['name']=Helper::getUsernameFromUserId($userId);
                	}
                }
        }
        usort($report, array("Helper", "cmp"));
    	unset($customerJobs);
		return $report;
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $from
     */
	public function getSalesReportEstimate($from='',$type='')
    {
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$result=Reports::getQueryParts($from,$type);
    	$queryParts=$result[0];
    	/*$estimates = Yii::app()->db->createCommand()
				->select("uj.id as job_id,uj.created_at,uj.star_rating,uj.public_notes,uc.customer_name,uc.id as customer_id,concat(uu.first_name,' ',uu.last_name) as owner ,ms.code,ms.name as status,us.short_name as source,COALESCE(sum(ujsr.total),0) as serviceRate,COALESCE(sum(ujpr.total),0) as productRate,COALESCE(ujt.job_total,0) as total")
				->from('ubase_jobs uj')
				->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
				->join('master_statuses ms','uj.master_status_id=ms.id')
				->join('master_status_categories msc','ms.master_status_category_id=msc.id')
				->join('ubase_job_totals ujt','ujt.ubase_job_id = uj.id')
				->leftjoin('ubase_job_service_rates ujsr','ujsr.ubase_job_id = uj.id')   
				->leftjoin('ubase_job_product_rates ujpr','ujpr.ubase_job_id = uj.id')
				->leftjoin('ubase_sources us' ,'us.id=uj.ubase_source_id')
				->leftjoin('ubase_jobs_ubase_users_crm ujuuc','ujuuc.ubase_job_id = uj.id')
				->leftJoin('ubase_users uu', 'uu.id=ujuuc.ubase_user_id')
				->where("upper(msc.code)='ESTIMATE' and ms.code IN ('01_REQ','02_EST','04_ACC','03_LST')  and uj.ubase_company_id=$companyId $queryParts")
				->group('uj.id')
				->order('uj.created_at asc')
				->queryAll();*/
    	$estimates = Yii::app()->db->createCommand()
    	->select("uj.id as job_id, uj.job_number, uj.created_at,uj.star_rating,uj.public_notes,uc.customer_name,uc.id as customer_id,concat(uu.first_name,' ',uu.last_name) as owner ,ms.code,ms.name as status,us.short_name as source,COALESCE(ujsr.serviceRate,0) as serviceRate,COALESCE(ujpr.productRate,0) as productRate,COALESCE(ujt.job_total,0) as total")
    	->from('ubase_jobs uj')
    	->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
    	->join('master_statuses ms','uj.master_status_id=ms.id')
    	->join('master_status_categories msc','ms.master_status_category_id=msc.id')
    	->join('ubase_job_totals ujt','ujt.ubase_job_id = uj.id')
    	->leftjoin('(SELECT ubase_job_id, sum(total)  serviceRate FROM  ubase_job_service_rates GROUP BY ubase_job_id) ujsr','ujsr.ubase_job_id = uj.id')
    	->leftjoin('(SELECT ubase_job_id,sum(total) as productRate  FROM  ubase_job_product_rates GROUP BY ubase_job_id) ujpr','ujpr.ubase_job_id = uj.id')
    	->leftjoin('ubase_sources us' ,'us.id=uj.ubase_source_id')
    	->leftjoin('ubase_jobs_ubase_users_crm ujuuc','ujuuc.ubase_job_id = uj.id')
    	->leftJoin('ubase_users uu', 'uu.id=ujuuc.ubase_user_id')
    	->where("upper(msc.code)='ESTIMATE' and ms.code IN ('01_REQ','02_EST','04_ACC','03_LST')  and uj.ubase_company_id=$companyId $queryParts")
    	->group('uj.id')
    	->order('uj.created_at asc')
    	->queryAll();
    	
		$reports=array();
    	foreach ($estimates as $estimate){
    			$jobId=$estimate['job_id'];
    			$customerId=$estimate['customer_id'];
				$tags = Yii::app()->db->createCommand()
								->select("ujtg.tags as")
								->from('ubase_jobs_tags ujtg')
								->where("ujtg.ubase_job_id =$jobId")
								->queryColumn();
				$phoneNumber=Yii::app()->db->createCommand()
								->select('CP.phone_number')
								->from('ubase_customer_phones CP')
								->leftJoin('ubase_customer_contacts CC', 'CP.ubase_customer_contact_id=CC.id AND CC.is_deleted = 0')
								->where("CP.ubase_customer_id=$customerId AND CC.is_primary=1 AND CP.is_active=1 ORDER BY CP.id ASC LIMIT 1")
								->queryScalar();
				$estimate['tags']=implode(',',$tags);
				$estimate['phone']=$phoneNumber;
                $reports[$estimate['code']][]=$estimate;
                $reports[$estimate['code']]['status']=$estimate['status'];
        }
		//print_r($reports);die();
    	return $reports;
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $from
     */
    private function getQueryParts($from,$type)
    {
    	$queryParts='';
    	$techQueryPart='';
    	$tblColumn=$type=='estimate'?'uj.created_at':'uj.job_start_date';
    	$tblColumn= $type == 'tax' ? 'ui.date' : $tblColumn;
    	if($from=='last_month'){
    		$queryParts=" and YEAR($tblColumn) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH($tblColumn) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)";
    	}
    	else if($from=='this_month'){
    		$queryParts=" and YEAR($tblColumn) = YEAR(CURDATE()) AND MONTH($tblColumn) = MONTH(CURDATE())";
    	}
    	else if($from=='this_week'){
    		//$queryParts=" and YEARWEEK($tblColumn) = YEARWEEK(CURRENT_DATE) ";    		
				$startDate=date("Y-m-d",strtotime("sunday last week"));
				$endDate=date("Y-m-d",strtotime("saturday this week"));
				$queryParts=" and DATE($tblColumn) <= '$endDate' and $tblColumn >= '$startDate'";
    	}
    	else if($from=='last_12_months'){
    		//$queryParts=' and $tblColumn < Now() and $tblColumn > DATE_ADD(Now(), INTERVAL- 12 MONTH)';
    		$time=strtotime("-1 year", time());
    		$startDate=date("Y-m-d",$time);
    		$endDate=date("Y-m-d");
    		$queryParts=" and DATE($tblColumn) <= '$endDate' and $tblColumn >= '$startDate'";
    	}
    	else if($from=='last_quarter'){
    		$time=strtotime("-4 month", time());
    		$startDate=date("Y-m-d",$time);
    		$endDate=date("Y-m-d");
    		$queryParts=" and DATE($tblColumn) <= '$endDate' and $tblColumn >= '$startDate'";
    	}
    	else if($from=='custom'){
    		$customerName=$job_po_number=$job_techs=$job_status='';
    		if($type=='ungrouped'){
    			if($_POST['Ungrouped']['start_date'] && $_POST['Ungrouped']['end_date']){
    				$startDate=Helper::getActualDateFormatToDB($_POST['Ungrouped']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['Ungrouped']['end_date']);
    				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
    			}
    			$customerName=$_POST['Ungrouped']['customer_name'];
    			if($customerName)
    			 	$queryParts .=" and uc.customer_name like '%".$customerName."%'";
    			$job_po_number=$_POST['Ungrouped']['job_po_number'];
    			if($job_po_number)
    				$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'"; 
    			if(!empty($_POST['Ungrouped']['job_techs']) && $_POST['Ungrouped']['job_techs'][0]!=''){
    				$job_techs='('.ltrim(implode(',', $_POST['Ungrouped']['job_techs']),',').')';
    				$techQueryPart=" and ujaw.ubase_user_id in $job_techs ";
    			}
    			if(!empty($_POST['Ungrouped']['job_status'])){
    				$job_status='('.implode(', ', $_POST['Ungrouped']['job_status']).')';
    		 		$queryParts .=" and msc.code in $job_status";
    			}
    		}
    		else if($type=='customer'){
    			if($_POST['Customer']['start_date'] && $_POST['Customer']['end_date']){
    				$startDate=Helper::getActualDateFormatToDB($_POST['Customer']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['Customer']['end_date']);
    				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
    			}
    			$customerName=$_POST['Customer']['customer_name'];
    			if($customerName)
    			 	$queryParts .=" and uc.customer_name like '%".$customerName."%'";
    			$job_po_number=$_POST['Customer']['job_po_number'];
    			if($job_po_number)
    				$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'"; 
    			if(!empty($_POST['Customer']['job_techs']) && $_POST['Customer']['job_techs'][0]!=''){
    				$job_techs='('.ltrim(implode(',', $_POST['Customer']['job_techs']),',').')';
    				$techQueryPart=" and ujaw.ubase_user_id in $job_techs ";
    			}
    			if(!empty($_POST['Customer']['job_status'])){
    				$job_status='('.implode(', ', $_POST['Customer']['job_status']).')';
    		 		$queryParts .=" and msc.code in $job_status";
    			}
    		}
    		else if($type=='tech'){
    			if($_POST['Tech']['start_date'] && $_POST['Tech']['end_date']){
    				$startDate=Helper::getActualDateFormatToDB($_POST['Tech']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['Tech']['end_date']);
    				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
    			}
    			$customerName=$_POST['Tech']['customer_name'];
    			if($customerName)
    			 	$queryParts .=" and uc.customer_name like '%".$customerName."%'";
    			$job_po_number=$_POST['Tech']['job_po_number'];
    			if($job_po_number)
    				$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'"; 
    			if(!empty($_POST['Tech']['job_techs']) && $_POST['Tech']['job_techs'][0]!=''){
    				$job_techs='('.ltrim(implode(',', $_POST['Tech']['job_techs']),',').')';
    				$techQueryPart=" and ujaw.ubase_user_id in $job_techs ";
    			}
    			if(!empty($_POST['Tech']['job_status'])){
    				$job_status='('.implode(', ', $_POST['Tech']['job_status']).')';
    		 		$queryParts .=" and msc.code in $job_status";
    			}
    		}
    		else if($type=='referral'){
    			if($_POST['Referral']['start_date'] && $_POST['Referral']['end_date']){
    				$startDate=Helper::getActualDateFormatToDB($_POST['Referral']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['Referral']['end_date']);
    				$queryParts=" and DATE(uj.job_start_date) <= '$endDate' and uj.job_start_date >= '$startDate'";
    			}
    			$customerName=$_POST['Referral']['customer_name'];
    			if($customerName)
    			$queryParts .=" and uc.customer_name like '%".$customerName."%'";
    			$job_po_number=$_POST['Referral']['job_po_number'];
    			if($job_po_number)
    			$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'";
    			if(!empty($_POST['Referral']['job_sources']) && $_POST['Referral']['job_sources'][0]!=''){
    				$job_sources='('.ltrim(implode(',', $_POST['Referral']['job_sources']),',').')';
    				$queryParts .=" and us.id in $job_sources ";
    			}
    			if(!empty($_POST['Referral']['job_status'])){
    				$job_status='('.implode(', ', $_POST['Referral']['job_status']).')';
    				$queryParts .=" and msc.code in $job_status";
    			}
    		}
    		else if($type=='estimate'){
    			if($_POST['Estimate']['start_date'] && $_POST['Estimate']['end_date']){
    				$startDate=Helper::getActualDateFormatToDB($_POST['Estimate']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['Estimate']['end_date']);
    				$queryParts=" and DATE(uj.created_at) <= '$endDate' and uj.created_at >= '$startDate'";
    			}
    			$customerName=$_POST['Estimate']['customer_name'];
    			if($customerName)
    			 	$queryParts .=" and uc.customer_name like '%".$customerName."%'";
    			if(!empty($_POST['Estimate']['oppurtunity_owner']) && $_POST['Estimate']['oppurtunity_owner'][0]!=''){
    				$job_techs='('.ltrim(implode(',', $_POST['Estimate']['oppurtunity_owner']),',').')';
    				$queryParts .=" and ujuuc.ubase_user_id in $job_techs ";
    			}
    			if(!empty($_POST['Estimate']['job_status'])){
    				$job_status='('.implode(', ', $_POST['Estimate']['job_status']).')';
    		 		$queryParts .=" and ms.code in $job_status";
    			}
    		}
    		else if($type=='tax'){
    			if($_POST['Tax']['start_date'] && $_POST['Tax']['end_date']){
    				$startDate=Helper::getActualDateFormatToDB($_POST['Tax']['start_date']);
    				$endDate=Helper::getActualDateFormatToDB($_POST['Tax']['end_date']);
    				$queryParts=" and DATE(ui.date) <= '$endDate' and ui.date >= '$startDate'";
    			}
    			$customerName=$_POST['Tax']['customer_name'];
    			if($customerName)
    			$queryParts .=" and uct.customer_name like '%".$customerName."%'";
    			$job_po_number=$_POST['Tax']['job_po_number'];
    			if($job_po_number)
    			$queryParts .=" and uj.job_po_number like '%".$job_po_number."%'";
    			if(isset($_POST['Tax']['invoice_paid']) && isset($_POST['Tax']['invoice_unpaid'])) {
    				
    			} else {
	                if(isset($_POST['Tax']['invoice_paid']) && $_POST['Tax']['invoice_paid']==1) {
	                    $queryParts .=" and ui.is_paid = 1 ";
	                }
	               // echo $_POST['Tax']['invoice_unpaid'];die;
	                if(isset($_POST['Tax']['invoice_unpaid']) && $_POST['Tax']['invoice_unpaid']==0) {
	                    $queryParts .=" and ui.is_paid = 0 ";
	                }
    			}
    		
    		}
    	}
    	//echo $queryParts;die('yutuy');
    	return array($queryParts,$techQueryPart);
    }
    
    public function getJobAssignedTechName($jobId)
    {
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$techies='';
    	$customerJobs = Yii::app()->db->createCommand()
			->select("concat(t7.first_name,' ',t7.last_name) as user_name")
			->from('ubase_job_assigned_workers t8 ')
			->join('ubase_jobs t1','t1.id = t8.ubase_job_id')
			->join('ubase_users t7','t8.ubase_user_id = t7.id')
  			->where("t1.ubase_company_id=$companyId and t1.id=$jobId and t8.is_deleted='0'")
			->queryAll();
			foreach ($customerJobs as $data){
				$techies .=", ".$data['user_name'];
			}
		return ltrim($techies,',');
    }
    
    public function salesCommission($from='',$type='',$queryParts='',$servicePart='',$productPart='')
    {
    	if($type=='agent'){
    		$main="ubase_jobs_ubase_users user";
    		$parts=" and uu.is_sales_rep=1";
    		$sub="";
    	}
    	else{
    		$main="ubase_job_assigned_workers user";
    		$parts=" and uu.is_field_worker=1";
    		$sub="user.is_deleted='0' and";
    	}
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$report = Yii::app()->db->createCommand()
				->select("uj.id as job_id,user.ubase_user_id as user_id,concat(uu.first_name,' ',uu.last_name) as user_name,uu.commission_rate,uu.rate_type,uc.customer_name,uj.ubase_customer_id as jobCustomerId,ujl.name,ujl.address_1,ujl.address_2,ujl.city,ujl.state,ujl.postal_code")
				->from("$main")
				->join('ubase_jobs uj','user.ubase_job_id=uj.id')
				->join('ubase_users uu','user.ubase_user_id = uu.id')
				->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
				->join('master_statuses ms','uj.master_status_id = ms.id') 
				->join('master_status_categories msc','ms.master_status_category_id=msc.id')  
				->leftjoin('ubase_job_locations ujl','ujl.ubase_job_id=uj.id')
				->where(" $sub msc.code != 'ESTIMATE' and user.ubase_company_id=$companyId $parts $queryParts")
				->queryAll();
		$report1=array();
		
    	foreach ($report as $data){
                $report1[$data['user_id']]['serviceTotal']=isset( $report1[$data['user_id']]['serviceTotal'])? $report1[$data['user_id']]['serviceTotal']:0;
                $report1[$data['user_id']]['productTotal']=isset($report1[$data['user_id']]['productTotal'])? $report1[$data['user_id']]['productTotal']:0;
                $report1[$data['user_id']]['name']=$data['user_name'];
                $report1[$data['user_id']]['commission_rate']=$data['commission_rate'];
                $report1[$data['user_id']]['type']=$data['rate_type']=='Fixed Amount Per Job'?'Per Job':'Of Base Charges';
            //  $report1[$data['user_id']]['jobs'][]=$data['job_id'];
            //  $report1[$data['user_id']]['totalJobs']=count( $report1[$data['user_id']]['jobs']);
            /*  $report1[$data['user_id']]['SP'][]=Yii::app()->db->createCommand()
								->select('IFNULL(ujpr.short_name,ujsr.short_name) as name,IFNULL(ujpr.rate,ujsr.rate) as rate,IFNULL(ujpr.multiplier,ujsr.multiplier) as quantity')
								->from('ubase_jobs uj')
								->leftjoin('ubase_job_service_rates ujsr','ujsr.ubase_job_id = uj.id')   
								->leftjoin('ubase_job_product_rates ujpr','ujpr.ubase_job_id = uj.id') 
								->leftjoin('ubase_job_service_lists ujsl','ujsl.id=ujsr.ubase_job_service_list_id') 
								->leftjoin('ubase_job_product_lists ujpl','ujpl.id=ujpr.ubase_job_product_list_id') 
								->where("uj.id=$data[job_id] $spPart")
								->queryAll();*/
				$report1[$data['user_id']]['S']=$report1[$data['user_id']]['P']=array();
				if($servicePart!='NOTSEARCH' && $servicePart!='NONE'){		
					$servCond = " and usr.pays_commission != 0 "; // Ticket #2627
					//$servCond = "";
				 	$report1[$data['user_id']]['S']=Yii::app()->db->createCommand()
								->select('ujsr.short_name as name,ujsr.rate as rate,ujsr.multiplier as quantity')
								->from('ubase_job_service_rates ujsr')
							 	->leftjoin('ubase_job_service_lists ujsl','ujsl.id=ujsr.ubase_job_service_list_id') 
							 	->leftjoin('ubase_service_rates usr','ujsl.master_service_id=usr.master_service_id')
								->where("ujsr.ubase_job_id=$data[job_id] $servCond and ujsl.ubase_job_id=$data[job_id] $servicePart")
								->queryAll();
					$report1[$data['user_id']]['serviceTotal']+=ServiceRates::model()->getServicesTotalRate($data['job_id'],$servicePart);
				}
				if($productPart!='NOTSEARCH' && $productPart!='NONE'){		
					$prodCond = " and up.pays_commission != 0 ";	 // Ticket #2627			
					//$prodCond = "";
				 	$report1[$data['user_id']]['P']=Yii::app()->db->createCommand()
								->select('ujpr.short_name as name,ujpr.rate as rate,ujpr.multiplier as quantity')
								->from('ubase_job_product_rates ujpr')
								->leftjoin('ubase_job_product_lists ujpl','ujpl.id=ujpr.ubase_job_product_list_id') 
								->leftjoin('ubase_products up','ujpl.ubase_product_id=up.id')
								->where("ujpr.ubase_job_id=$data[job_id] $prodCond and ujpl.ubase_job_id=$data[job_id] $productPart")
								->queryAll();
					$report1[$data['user_id']]['productTotal']+=ServiceRates::model()->getProductsTotalRate($data['job_id'],$productPart);
				}
				if(!empty($report1[$data['user_id']]['P']) || !empty($report1[$data['user_id']]['S'])){
					 $report1[$data['user_id']]['jobs'][]=$data['job_id'];
				}
				$report1[$data['user_id']]['totalJobs']=isset($report1[$data['user_id']]['jobs'])?count( $report1[$data['user_id']]['jobs']):0;
				$report1[$data['user_id']]['SP'][]=array_merge($report1[$data['user_id']]['S'],$report1[$data['user_id']]['P']);				
								
				
				//$report1[$data['user_id']]['totalSales']=isset($report1[$data['user_id']]['totalSales'])?$report1[$data['user_id']]['totalSales']:0;
				$report1[$data['user_id']]['totalSales']=$report1[$data['user_id']]['productTotal']+$report1[$data['user_id']]['serviceTotal'];
				$report1[$data['user_id']]['agentCommisions']=0;
				if($data['rate_type']=='Fixed Amount Per Job'){
					$report1[$data['user_id']]['agentCommisions']=$report1[$data['user_id']]['totalJobs']*$data['commission_rate'];
				}
				else if($data['rate_type']=='Percentage Of Base Charges'){
					$report1[$data['user_id']]['agentCommisions']=$report1[$data['user_id']]['totalSales']*($data['commission_rate']/100);
				}
				$report1[$data['user_id']]['customerName']=$data['customer_name'];
				$report1[$data['user_id']]['jobCustomerId']=$data['jobCustomerId'];
				$report1[$data['user_id']]['locationName']=$data['name'];
				$report1[$data['user_id']]['address_1']=$data['address_1'];
				$report1[$data['user_id']]['address_2']=$data['address_2'];
				$report1[$data['user_id']]['city']=$data['city'];
				$report1[$data['user_id']]['state']=$data['state'];
				$report1[$data['user_id']]['postal_code']=$data['postal_code'];
        }
      
        foreach ($report1 as $emp=>$data){
        	$merge=array();
        	foreach ($data['SP'] as $data1){
        		$merge=array_merge($merge,$data1);
        	}
        	$report1[$emp]['services&products']=$merge;
        	unset($merge);
        	unset($report1[$emp]['SP']);
        	unset($data1);
        	unset($report1[$emp]['jobs']);
        }
      
		foreach ($report1 as $emp=>$data){
			$resultArray = array();
         	$array1=$data['services&products'];
         	$count=count($array1);
			for($i=0;$i<$count;$i++)
			{
				if(!isset($resultArray[ucfirst($array1[$i]['name'])][$array1[$i]['rate']])) {
           			$resultArray[ucfirst($array1[$i]['name'])][$array1[$i]['rate']] = $array1[$i]['quantity'];
        		}
		        else {
		           continue;
		        }
				for($j=$i+1;$j<$count;$j++){
						if($array1[$i]['name']==$array1[$j]['name'] && $array1[$i]['rate']==$array1[$j]['rate']){
							$resultArray[ucfirst($array1[$i]['name'])][$array1[$i]['rate']] += $array1[$j]['quantity']; 
						}
						
				}
				
         	}
         	unset($report1[$emp]['services&products']);
         	//ksort($resultArray);
         	$report1[$emp]['services&products']=$resultArray;
         }
       $resultArray=$report='';
       return $report1;
    }
    
    public function customSalesRevenue($from='',$type='',$queryParts='',$servicePart='',$productPart='',$startDate='',$endDate='')
    {
    	
    	$main="ubase_job_assigned_workers user";
    	$parts=" and uu.is_field_worker=1";
    	$sub="user.is_deleted='0' and";
    		
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$report = Yii::app()->db->createCommand()
	    	->select("uj.id as job_id,uj.job_number,uj.job_start_date,user.ubase_user_id as user_id,
	    			concat(uu.first_name,' ',uu.last_name) as user_name,uc.customer_name,uc.id as customer_id,ujt.job_total,
	    			up.make,up.model,sum(ujpr.multiplier) as multiplier,ujpl.ubase_product_id as jobProductId,
	    			up.unit_cost as unitCost, sum(ujsr.cost) as serviceCost,ujpr.cost as productCost,uj.public_notes as jobDescription")
	    	->from("$main")
	    	->join('ubase_jobs uj','user.ubase_job_id=uj.id')
	    	->join('ubase_users uu','user.ubase_user_id = uu.id')
	    	->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
	    	->join('master_statuses ms','uj.master_status_id = ms.id')
	    	->join('master_status_categories msc','ms.master_status_category_id=msc.id')
	    	->join('ubase_job_totals ujt','ujt.ubase_job_id=uj.id')
	    	->leftjoin('ubase_job_product_lists ujpl','ujpl.ubase_job_id=uj.id')
	    	->leftjoin('ubase_job_product_rates ujpr','ujpr.ubase_job_product_list_id=ujpl.id')
	    	->leftjoin('ubase_products up','ujpl.ubase_product_id=up.id')
	    	->leftjoin('ubase_job_service_lists ujsl','ujsl.ubase_job_id=uj.id')
	    	->leftjoin('ubase_job_service_rates ujsr','ujsr.ubase_job_service_list_id = ujsl.id')
	    	->where(" $sub msc.code != 'ESTIMATE' AND user.ubase_company_id=$companyId $parts $queryParts 
	    			 GROUP BY ujpl.ubase_product_id,user.ubase_user_id,uj.id")
    		//->getText();echo $report;exit;// AND up.ubase_company_id=$companyId removed for Ticket 2251
    		->queryAll();
    	
    	/* $report = Yii::app()->db->createCommand()
	    	->select("uj.id as job_id,uj.job_number,uj.job_start_date,user.ubase_user_id as user_id,concat(uu.first_name,' ',uu.last_name) as user_name,uc.customer_name,ujt.job_total")
	    	->from("$main")
	    	->join('ubase_jobs uj','user.ubase_job_id=uj.id')
	    	->join('ubase_users uu','user.ubase_user_id = uu.id')
	    	->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
	    	->join('master_statuses ms','uj.master_status_id = ms.id')
	    	->join('master_status_categories msc','ms.master_status_category_id=msc.id')
	    	->join('ubase_job_totals ujt','ujt.ubase_job_id=uj.id')
	    	->where(" $sub msc.code != 'ESTIMATE' and user.ubase_company_id=$companyId $parts $queryParts")
	    	//->getText();echo $report;exit;
	    	->queryAll(); */
    	$report1=array();
    	$repeatCust = array();
    	$productCostTotal = 0;
    	foreach ($report as $data){
    		$serviceCost = 0;
    		if($data['serviceCost'] && $data['serviceCost']!=''){
    			$serviceCost = $data['serviceCost'];
    		}
    		$productCost = 0;
    		$productCostTotal = 0;
    		$serviceCostTotal = 0;
    		if($data['productCost'] && $data['productCost']!=''){
    			$productCost = $data['productCost'];
    			//$productCostTotal+=$data['productCost'];
    		}
    		$report1[$data['user_id']]['techName']=$data['user_name'];
    		$report1[$data['user_id']]['techId']=$data['user_id'];
    		$report1[$data['user_id']]['details'][$data['job_id']]['date']=$data['job_start_date'];
    		$report1[$data['user_id']]['details'][$data['job_id']]['customerName']=$data['customer_name'];
    		$report1[$data['user_id']]['details'][$data['job_id']]['customerId']=$data['customer_id'];
    		$report1[$data['user_id']]['details'][$data['job_id']]['jobNumber']=$data['job_number'];
    		$report1[$data['user_id']]['details'][$data['job_id']]['grossSales']=$data['job_total']; 
    		$report1[$data['user_id']]['details'][$data['job_id']]['jobDescription']=$data['jobDescription'];
    		
    		$report1[$data['user_id']]['details'][$data['job_id']]['partsUsed'] .= $data['make'].' '.$data['model'].', ';
    		
    		$jobId = $data['job_id'];
    		$modelJobServiceLists = JobServiceLists::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$jobId));
    		$modelJobServiceRates = JobServiceRates::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$jobId));
    		if(isset($modelJobServiceLists[0])){    			
    			foreach($modelJobServiceLists as $serviceList){
    				$serviceListId = $serviceList['id'];
    				$serviceId = $serviceList['master_service_id'];    				
    				foreach($modelJobServiceRates as $serviceRate){
    					if($serviceListId == $serviceRate['ubase_job_service_list_id'] && $serviceList['ubase_job_id']==$jobId){
    						$serviceCostTotal+=$serviceRate['cost'];
    					}
    				}
    			}
    		}
    		
    		$modelJobProductLists = JobProductLists::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$jobId));
    		$modelJobProductRates = JobProductRates::model()->findAll('ubase_job_id=:jobId',array(':jobId'=>$jobId));
    		
    		if(isset($modelJobProductLists[0])){    			
    			foreach($modelJobProductLists as $productList){
    				$productListId = $productList['id'];
    				$productId = $productList['ubase_product_id'];    				
    				foreach($modelJobProductRates as $productRate){
    		
    					if($productListId == $productRate['ubase_job_product_list_id']){
    						$productCostTotal+=$productRate['cost'];
    					}
    				}
    			}
    		}
    		
    		$report1[$data['user_id']]['details'][$data['job_id']]['serviceCost']=$serviceCostTotal;
    		$report1[$data['user_id']]['details'][$data['job_id']]['partsCost']=$productCostTotal;
    		$reportCharge = Yii::app()->db->createCommand()
	    		->select("sum(total) as chargeTotal")
	    		->from("ubase_job_other_charges ujoc")
	    		->join('ubase_other_charges uoc',"ujoc.ubase_job_other_charge_id=uoc.id and uoc.category=1")
	    		->where("ujoc.ubase_job_id=$jobId")
	    		->queryAll();
    		$chargeTotal = $reportCharge[0]['chargeTotal'];
    		$report1[$data['user_id']]['details'][$data['job_id']]['taxCollected'] = $chargeTotal;
    		$modelTechs = Yii::app()->db->createCommand()
    		->select("uu.id,concat(uu.first_name,' ',uu.last_name) as tech")
    		->from('ubase_job_assigned_workers ujaw')
    		->join('ubase_users uu','uu.id=ujaw.ubase_user_id')
    		->where("ujaw.ubase_job_id=$jobId and ujaw.ubase_company_id=$companyId and ujaw.is_deleted='0' AND uu.is_field_worker=1")
    		->queryAll();
    		$t = 0;
    		$assignedWorkers = "";
    		foreach ($modelTechs as $tech){
    			if($tech['id'] != $data['user_id']){
	    			if($t>0){
	    				$assignedWorkers.= ", ".$tech['tech'];
	    			}else{
	    				$assignedWorkers.= $tech['tech'];
	    			}
	    			$t++;
    			}
    		}
    		
    		$report1[$data['user_id']]['details'][$data['job_id']]['assignedWorkers'] = $assignedWorkers;
    		/* $reportProduct = Yii::app()->db->createCommand()
	    		->select("total as productTotal,short_name")
	    		->from("ubase_job_product_rates ujpr")
	    		->join('ubase_job_product_lists ujpl',"ujpl.id=ujpr.ubase_job_product_list_id and ujpl.ubase_job_id=$jobId")
	    		->where("ujpr.ubase_job_id=$jobId")
	    		->queryAll();
    		foreach($reportProduct as $product){
	    		$report1[$data['user_id']]['details'][$data['job_id']]['partsCost'] += $product['productTotal'];
	    		$report1[$data['user_id']]['details'][$data['job_id']]['partsUsed'] .= $product['short_name'].', ';
    		} */
    		$productId = $data['jobProductId'];
    		$multiplier = $data['multiplier'];
    		$reportProduct = array();
    		if($productId){
    		$reportProduct = Yii::app()->db->createCommand()
	    		->select("sum(uioup.unit_cost) as unit_cost,count(id) as count")
	    		->from("ubase_inventory_orders_ubase_products uioup")
	    		->where("uioup.ubase_product_id=$productId AND uioup.ubase_company_id=$companyId")
	    		->queryAll();
    			//->getText();//echo $reportProduct;exit;
    		}
    		
    		$avgCost = 0;
    		$partCost = 0;
    		if(isset($reportProduct[0]['unit_cost'])){
    			$avgCost = ($reportProduct[0]['unit_cost']) / ($reportProduct[0]['count']);
    		}
    		else{
    			$avgCost = $data['unitCost'];
    		}
    		$partCost = $avgCost * $multiplier;
    		//$report1[$data['user_id']]['details'][$data['job_id']]['partsCost'] += $partCost;
    		
    		$repeatCust[$data['job_id']] = $data['customer_id'];
    	}
    
    	$repeatCustArray = array();
	    foreach ($repeatCust as $cust) {
	    	$repeatCustArray[$cust]++;
	    }
    	foreach (array_keys($repeatCustArray, 1) as $key) {
    		unset($repeatCustArray[$key]);
    	}
    	$repeatCustArray = array_keys($repeatCustArray);
    	Reports::createcustomeSalesRevenueExcel($report1,$startDate,$endDate,$repeatCustArray);
    }
    
    public function createcustomeSalesRevenueExcel($array,$startDate,$endDate,$repeatCust)
    {
    	Yii::import('ext.phpexcel.XPHPExcel');
    	$objPHPExcel= XPHPExcel::createPHPExcel();
    	
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$company = Company::model()->find('id=:companyId',array('companyId'=>$companyId));
    	
    	/**  Main Heading -Company Name **/
    	$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $company->company_name);
    	$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
    	
    	$createdAt = date(Yii::app()->session['dateFormat'].' '.Yii::app()->session['timeFormat'],strtotime(date("Y-m-d H:i")));
    	
    	$loggedInId = $_SESSION['primId'];
    	$user = Workforce::model()->find('id=:userId',array('userId'=>$loggedInId));
    	$createdBy = $user->first_name.' '.$user->last_name;
    	
    	$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "Created At: ".$createdAt);
    	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	
    	$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Created By: ".$createdBy);
    	$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	
    	//$startDate = date(Yii::app()->session['dateFormat'],strtotime($startDate));
    	//$endDate = date(Yii::app()->session['dateFormat'],strtotime($endDate));
    	
    	$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "Date Range: ".$startDate.' - '.$endDate);
    	$objPHPExcel->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	
    	$keys = array_keys($array);
    	$i = 0;
    	$j = 0;
    	$startIndex = 6;
    	
    	foreach($array as $techData){
    		$grossSalesTotal = 0;
    		$partsCostTotal = 0;
    		$taxCollectedTotal = 0;
    		$profitTotal = 0;
    		$totalServiceCost = 0;
    		$techName = $array[$keys[$i]]['techName'];
    		$techId = $array[$keys[$i]]['techId'];
    		$startTechName = $startIndex + $j;//echo $startTechName.':';
    		$objPHPExcel->getActiveSheet()->mergeCells('A'.$startTechName.':F'.$startTechName);
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startTechName, $techName);
    		$objPHPExcel->getActiveSheet()->getStyle('A'.$startTechName)->getFont()->setSize(14);
    		$objPHPExcel->getActiveSheet()->getStyle('A'.$startTechName)->getFont()->setBold(true);
    		
    		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startTechName, 'Repeat Customer');
    		//$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    		$temp=$startTechName;
    		
    		//$objPHPExcel->getActiveSheet()->getRowDimension('A')->setRowHeight(65);
    		$j = $j+2;//echo $j.'main';
    		$startTechName = $startIndex + $j;
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startTechName, 'Date');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    		$objPHPExcel->getActiveSheet()->getStyle('A'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startTechName, 'Customer Name');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
    		$objPHPExcel->getActiveSheet()->getStyle('B'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startTechName, 'Repeat Customer');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
    		$objPHPExcel->getActiveSheet()->getStyle('C'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startTechName, 'Job#');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
    		$objPHPExcel->getActiveSheet()->getStyle('D'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startTechName, 'Gross Sales');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    		$objPHPExcel->getActiveSheet()->getStyle('E'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startTechName, 'Parts Cost');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    		$objPHPExcel->getActiveSheet()->getStyle('F'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    		
    		
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startTechName, 'Service Cost');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    		$objPHPExcel->getActiveSheet()->getStyle('G'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startTechName, 'Tax Collected');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    		$objPHPExcel->getActiveSheet()->getStyle('H'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$startTechName, 'Profit');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    		$objPHPExcel->getActiveSheet()->getStyle('I'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$startTechName, 'Split');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    		$objPHPExcel->getActiveSheet()->getStyle('J'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$startTechName, 'Parts Used');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    		$objPHPExcel->getActiveSheet()->getStyle('K'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		

    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$startTechName, 'Description');
    		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    		$objPHPExcel->getActiveSheet()->getStyle('L'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
    		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    		
    		
    		$objPHPExcel->getActiveSheet()->getStyle('A'.$startTechName.':L'.$startTechName)->getFont()->setBold(true);
    		
    		$jobCount=0;
    		foreach($techData['details'] as $details){
    			$profit = 0;
    			$j = $j+1;//echo $j.'sub';
    			$startTechName = $startIndex + $j;
    			
    			$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('0.00');
    			$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('0.00');
    			$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('0.00');
    			$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('0.00');
    			
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startTechName,date(Yii::app()->session['dateFormat'],strtotime($details['date'])));
    			$objPHPExcel->getActiveSheet()->getStyle('A'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startTechName, $details['customerName']);
    			$objPHPExcel->getActiveSheet()->getStyle('B'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			$repeatCustomer = "No";
    			if(in_array($details['customerId'],$repeatCust)){
    				$repeatCustomer = "Yes";
    			}
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startTechName, $repeatCustomer);
    			$objPHPExcel->getActiveSheet()->getStyle('C'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startTechName, $details['jobNumber']);
    			$objPHPExcel->getActiveSheet()->getStyle('D'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startTechName, number_format(isset($details['grossSales'])?$details['grossSales']:0,2));
    			$objPHPExcel->getActiveSheet()->getStyle('E'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startTechName, number_format(isset($details['partsCost'])?$details['partsCost']:0,2));
    			$objPHPExcel->getActiveSheet()->getStyle('F'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startTechName, number_format(isset($details['serviceCost'])?$details['serviceCost']:0,2));
    			$objPHPExcel->getActiveSheet()->getStyle('G'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startTechName, number_format(isset($details['taxCollected'])?$details['taxCollected']:0,2));
    			$objPHPExcel->getActiveSheet()->getStyle('H'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$startTechName, rtrim($details['assignedWorkers'], ", "));
    			$objPHPExcel->getActiveSheet()->getStyle('J'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$startTechName, rtrim($details['partsUsed'], ", "));
    			$objPHPExcel->getActiveSheet()->getStyle('K'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			
                $profit = $details['grossSales'] - ($details['taxCollected'] + $details['partsCost'] + $details['serviceCost']);
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$startTechName, number_format($profit,2));
    			$objPHPExcel->getActiveSheet()->getStyle('I'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$startTechName, $details['jobDescription']);
    			$objPHPExcel->getActiveSheet()->getStyle('L'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    			
    			$grossSalesTotal += $details['grossSales'];
    			$partsCostTotal +=  $details['partsCost'];
    			$taxCollectedTotal += $details['taxCollected'];
    			$totalServiceCost += $details['serviceCost'];
    			$profitTotal +=  $profit;
    			$jobCount++;
    			//print_r($details);exit;
    		}
    		/* if($jobCount>1){
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$temp, 'Yes');
    			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    		}
    		else{
    			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$temp, 'No');
    			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    		} */
    		$j = $j+1;
    		$startTechName = $startIndex + $j;
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startTechName, 'Totals');
    		$objPHPExcel->getActiveSheet()->getStyle('A'.$startTechName.':H'.$startTechName)->getFont()->setBold(true);
    		
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startTechName, number_format($grossSalesTotal,2));
    		$objPHPExcel->getActiveSheet()->getStyle('E'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startTechName, number_format($partsCostTotal,2));
    		$objPHPExcel->getActiveSheet()->getStyle('F'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startTechName, number_format($totalServiceCost,2));
    		$objPHPExcel->getActiveSheet()->getStyle('G'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startTechName, number_format($taxCollectedTotal,2));
    		$objPHPExcel->getActiveSheet()->getStyle('H'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$startTechName, number_format($profitTotal,2));
    		$objPHPExcel->getActiveSheet()->getStyle('I'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		
    		$j = $j+2;
    		$i++;
    	}
    	//exit;
    	$objPHPExcel->setActiveSheetIndex(0);
    	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    	
    	
    	$objWriter->save(Yii::app()->basePath.'/../estimates/report.xlsx');
    	
    	$file_path =Yii::app()->basePath.'/../estimates/report.xlsx';
    	$data = file_get_contents($file_path); // Read the file's contents
    	$name="Report_".date("Y-m-d",strtotime($startDate))."-".date("Y-m-d",strtotime($endDate)).".xlsx";
    	if(Yii::app()->getRequest()->sendFile($name,$data)){
    			unlink($file_path);
    	}
    }
    
    public function getJobDriveLaborPayroll($from='',$type='',$queryString='')
    {
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$report = Yii::app()->db->createCommand()
    			->select("uj.id as job_id,uj.job_number,ujlc.ubase_user_id as tech_id,concat(uu.first_name,' ',uu.last_name) as tech_name,uj.public_notes,uj.job_po_number,uc.customer_name, DAYNAME(ujlc.labor_date) as day,uj.job_start_date as date,uj.time_frame_promised_start start_time,uj.job_duration,ujlc.driving_time ,ujlc.labor_time,ujlc.driving_time+ujlc.labor_time as total_time,ujlc.labor_date,ujlc.labor_time_start,ujlc.labor_time_end")
				->from('ubase_job_labor_charges ujlc')
				->join('ubase_jobs uj','ujlc.ubase_job_id=uj.id')
				->join('ubase_users uu','ujlc.ubase_user_id = uu.id')
				->join('master_statuses ms','uj.master_status_id = ms.id')
	    		->join('master_status_categories msc','ms.master_status_category_id=msc.id')
				->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
				->leftjoin('ubase_job_assigned_workers ujaw','ujaw.ubase_job_id=uj.id and ujaw.ubase_user_id=ujlc.ubase_user_id')
				->where("uj.ubase_company_id=$companyId  and ujlc.is_deleted=0 $queryString")
				->order("tech_name desc,ujlc.labor_date asc")
				->queryAll();
		$final=array();
		foreach ($report as $data){
				$data['services']=Jobs::getServiceNamesOfJob($data['job_id']);
				$final[$data['tech_id']][]=$data;
				$final[$data['tech_id']]['name']=$data['tech_name'];
		}
		$report='';
		return $final;
    }
    
    public function getEmployeePayroll($from='',$type='',$queryStringDate,$queryStringTech)
    {
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	/* $report = Yii::app()->db->createCommand()
    			->select("uu.id,concat(uu.first_name,' ',uu.last_name) as tech_name,ujpi.regular_rate,ujpi.overtime_starts_after,ujpi.overtime_rate,ujpi.doubletime_starts_after,ujpi.doubletime_rate,ujpi.overtime_starts_after_type,ujpi.doubletime_starts_after_type")
    			->from('ubase_users uu')
    			->leftjoin("ubase_user_payroll_items ujpi",'ujpi.ubase_user_id=uu.id')
    			->where("uu.ubase_company_id=$companyId  and uu.is_field_worker=1 $queryStringTech")
    			->order('tech_name desc')
    			->queryAll(); */
    	// remove field worker to ticket no 2099
    	$report = Yii::app()->db->createCommand()
    	->select("uu.id,concat(uu.first_name,' ',uu.last_name) as tech_name,ujpi.regular_rate,ujpi.overtime_starts_after,ujpi.overtime_rate,ujpi.doubletime_starts_after,ujpi.doubletime_rate,ujpi.overtime_starts_after_type,ujpi.doubletime_starts_after_type")
    	->from('ubase_users uu')
    	->leftjoin("ubase_user_payroll_items ujpi",'ujpi.ubase_user_id=uu.id')
    	->where("uu.ubase_company_id=$companyId  $queryStringTech")
    	->order('tech_name desc')
    	->queryAll();
    	
		foreach ($report as $index=>$data){
			$user=$data['id'];
			$report[$index]['status']=Yii::app()->db->createCommand()
    						->select("uuws.created_at,uuws.status,date(uuws.created_at) as date,DATE_FORMAT(uuws.created_at,'%H:%i:%s') time")
    						->from('ubase_user_working_statuses uuws')
    						->where("uuws.ubase_user_id=$user $queryStringDate")
    						->order('created_at asc')
    						->queryAll();
    						
		}
    	return $report;
    }
    
    public function hoursLaber($report,$endDate='')
    {
    	//error_reporting(E_ALL);
    	//ini_set('display_errors', 'On');
    	//echo "<pre>";
    	//print_r($report);
    	
    	$laberStatusArray = array();
    	$newReportArray = array();
    	$overTimeCalCulation='';
    	foreach ($report as $laberReports){ //print_r($laberReports['status']);
    		//echo $laberReports['status'][]['date'];
    		foreach ($laberReports['status'] as $hoursReports){
    			$date=$hoursReports['date'];
    			$status=$hoursReports['status'];
    			$createdAt=$hoursReports['created_at'];
    			$time=$hoursReports['time'];
    			$laberStatusArray[$laberReports['id']][$date][] = array('status'=>$status,'created_at'=>$createdAt,'time'=>$time);
    		}
    		
    	}
    	//echo "<pre/>";
    	//print_r($laberStatusArray);
    	foreach ($laberStatusArray as $userIDKey=>$laberStatus){
    		
    		$i=0;
    		$durationTemp=0;
    		$duration=0;
    		$regular = 0;
    		$overtime = 0;
    		$clockOuttime = 0;
    		$clockIntime = 0;
    		foreach ($laberStatus as $dateKey=>$status){ //print_r($status); die();
    			//echo "<br>";
    			$next = next($laberStatus); 
    			$commingDate = key($laberStatus);/*Get Next Index*/
    			if($commingDate==''){
    				//$commingDate = $dateKey; 
    				$commingDate = $endDate;
    				//$commingDate =  date('Y-m-d', strtotime('+1 day', strtotime($dateKey)));;
    			}
    			$alradyAdded = 0;
				$durationTemp=0;
    			$duration=0;
    			$overtime = 0;
    			$clockOuttime = 0;
    			$clockIntime = 0;
    			$clockInCount = 0;
    			$overtime1 = 0;
    			$overtime2 = 0;
    			$totalHoursWorked = 0;
    			$totalOverTime = 0;
    			$overTimeCal=Reports::getOvertimecalculations($userIDKey);
    			$overTimeStartsAfter = $overTimeCal['overtime_starts_after'];
    			$doubleTimeStartsAfter = $overTimeCal['doubletime_starts_after'];
    			$overTimeCalCulation = $overTimeCal['overtime_starts_after_type'];
    			
    			//$overTimeStartsAfter!='0.00' ? $overTimeStartsAfter : 0;
    			//$doubleTimeStartsAfter!='0.00' ? $doubleTimeStartsAfter : 0;
    			
    			
	    		for($i=0;$i< count($status);$i++){
	    			
	    		if($status[$i]['status']=='CLOCK_IN' && $clockInCount==0){
	    			$clockIntime = $status[$i]['created_at'];
	    			$clockInCount++;
	    		}
	    		if($status[$i]['status']=='CLOCK_OUT'){
	    		
	    			$clockOuttime = $status[$i]['created_at'];
	    		}
	    			if($status[$i]['status']=='CLOCK_IN' || $status[$i]['status']=='BREAK_END'){
	    				
	    				$fromDate=$status[$i]['created_at'];
	    				if(isset($status[$i+1])){
		    				if($status[$i+1]['status']=='BREAK_START' || $status[$i+1]['status']=='CLOCK_OUT'){
		    					$toDate=$status[$i+1]['created_at'];
		    					$duration=Reports::timeDiffrence($fromDate,$toDate);
		    					if($clockIntime==0){ // Ticket #2711 point 1 related fix
		    						$duration = 0;
		    					}
		    					$durationTemp = $duration+$durationTemp;
		    				}
	    				}else{
	    					if($dateKey!=date('Y-m-d')){
	    						$nextDate = date('Y-m-d', strtotime('+1 day', strtotime($dateKey)));
	    						$toDate =$nextDate." "."00:00:00";
	    						$duration=Reports::timeDiffrence($fromDate,$toDate);
	    						if($clockIntime==0){ // Ticket #2711 point 1 related fix
	    							$duration = 0;
	    						}
	    						$durationTemp = $duration+$durationTemp;
	    						
	    						/*****************START DUPLICATE ENTRTy**************/
	    						
	    						if($nextDate!=$commingDate){
	    							$startTime = strtotime("$nextDate 00:00:00");
	    							//echo $commingDate."---";
	    							$endTime = strtotime("$commingDate 00:00:00");
	    							//echo "---".date('Y-m-d',$endTime)."<br/>";
	    							$totalHoursWorked=$durationTemp;
	    							
	    							if($overTimeCal['overtime_starts_after_type']=='Hours Per Day'){
	    								 
	    								if(($totalHoursWorked <= $overTimeStartsAfter) || $overTimeStartsAfter==0){
	    									$regular = $totalHoursWorked;
	    								}else{
	    									$totalOverTime = $totalHoursWorked - $overTimeStartsAfter;
	    									$regular = $totalHoursWorked - $totalOverTime;
	    									if ($doubleTimeStartsAfter != 0) {
		    									if($totalOverTime <=  $doubleTimeStartsAfter){
		    										$overtime1 = $totalOverTime;
		    									}else{
		    										$overtime1 = $doubleTimeStartsAfter - $regular;
		    									}
	    									}else {
	    										$overtime1 = $totalOverTime;
	    										$overtime2 = 0;
	    									}
	    									if ($doubleTimeStartsAfter != 0) {
		    									if($totalOverTime > $doubleTimeStartsAfter){
		    										$overtime2 = $totalHoursWorked - $doubleTimeStartsAfter;
		    									}
	    									}
	    							
	    								}
	    							
	    							}elseif($overTimeCal['overtime_starts_after_type']=='Hours Per Week'){
	    								$regular = $totalHoursWorked;
	    							}
	    							if(!$alradyAdded){
	    								$newReportArray[$userIDKey][$dateKey][] = array('regular'=>$regular,'overtime1'=>$overtime1,'overtime2'=>$overtime2,'clockIntime'=>$clockIntime,'clockOuttime'=>$clockOuttime,'overTimeStartsAfter'=>$overTimeStartsAfter,'doubleTimeStartsAfter'=>$doubleTimeStartsAfter,'overTimeCalCulation'=>$overTimeCalCulation);
	    								$alradyAdded = 1;
	    							}
	    							
	    							
	    							// Loop between timestamps, 24 hours at a time
	    							for ($k = $startTime; $k < $endTime; $k = $k + 86400) {
	    								  
	    								 $toDateG = date('Y-m-d', $k); // 2010-05-01, 2010-05-02, etc
	    								 $totalHoursWorked=24;
	    								 if($overTimeCal['overtime_starts_after_type']=='Hours Per Day'){
	    								 	if(($totalHoursWorked <= $overTimeStartsAfter) || $overTimeStartsAfter==0){
	    								 		$regular = $totalHoursWorked;
	    								 	}else{
		    								 	$totalOverTime = $totalHoursWorked - $overTimeStartsAfter;
		    								 	$regular = $totalHoursWorked - $totalOverTime;
		    								 	if($doubleTimeStartsAfter!= 0) {
			    								 	if($totalOverTime <=  $doubleTimeStartsAfter){
			    										$overtime1 = $totalOverTime;
			    									}else{
			    										$overtime1 = $doubleTimeStartsAfter - $regular;
			    									}
		    								 	}else {
		    								 		$overtime1 = $totalOverTime;
		    								 		$overtime2 = 0;
		    								 	}
		    								 	if($doubleTimeStartsAfter!= 0) {
			    								 	if($totalOverTime > $doubleTimeStartsAfter){
			    								 		$overtime2 = $totalHoursWorked - $doubleTimeStartsAfter;
			    								 	}
		    								 	}
	    								 	}
	    								 }elseif($overTimeCal['overtime_starts_after_type']=='Hours Per Week'){
	    								 	$regular = 24;
	    								 }
	    								 
	    								  $newReportArray[$userIDKey][$toDateG][] = array('regular'=>$regular,'overtime1'=>$overtime1,'overtime2'=>$overtime2,'clockIntime'=>0,'clockOuttime'=>0,'overTimeStartsAfter'=>$overTimeStartsAfter,'doubleTimeStartsAfter'=>$doubleTimeStartsAfter,'overTimeCalCulation'=>$overTimeCalCulation);
	    							}
	    						} 
	    						/**********END Dulipdate Entry***********************/
	    						
	    					}
	    					
	    				}
	    				
	    			}
	    			
	    			if($i==0){
	    				
	    				if($status[$i]['status']=='BREAK_START' || $status[$i]['status']=='CLOCK_OUT'){
	    					$fromDate = $dateKey." "."00:00:00";
	    					$toDate=$status[$i]['created_at'];
	    					//echo $status[$i]['status']." FROM ".$fromDate."To date ".$toDate;
		    				$duration=Reports::timeDiffrence($fromDate,$toDate);
		    				if($clockIntime==0){ // Ticket #2711 point 1 fix
		    					$duration = 0;
		    				}
	    					$durationTemp = $duration+$durationTemp;
	    				}
	    				
	    			}
	    		
	    			//echo $durationTemp."<br/>";
	    			
	    			//$i++;
	    		}
	    		
	    		$totalHoursWorked = $durationTemp;
	    		
	    		if($overTimeCal['overtime_starts_after_type']=='Hours Per Day'){
	    			if(($totalHoursWorked <= $overTimeStartsAfter) || $overTimeStartsAfter==0){
	    				$regular = $totalHoursWorked;
	    			}else{
	    				$totalOverTime = $totalHoursWorked - $overTimeStartsAfter;
	    				$regular = $totalHoursWorked - $totalOverTime;
	    				if ($doubleTimeStartsAfter != 0) {
	    					if($totalOverTime <=  $doubleTimeStartsAfter){
	    						$overtime1 = $totalOverTime;
	    					}else{
	    						$overtime1 = $doubleTimeStartsAfter - $regular;
	    					}
	    				}else{
	    					$overtime1 = $totalOverTime;
	    					$overtime2 = 0;
	    				}
	    				if ($doubleTimeStartsAfter != 0) {
		    				if($totalOverTime > $doubleTimeStartsAfter){
		    					$overtime2 = $totalHoursWorked - $doubleTimeStartsAfter;
		    				}
	    				}
	    				
	    			}
	    			
	    		
	    		}elseif($overTimeCal['overtime_starts_after_type']=='Hours Per Week'){
	    			
	    			$regular = $totalHoursWorked;
	    			
	    		}
	    		//die($overTimeCalCulation);
	    		if(!$alradyAdded){
	    		 $newReportArray[$userIDKey][$dateKey][] = array('regular'=>$regular,'overtime1'=>$overtime1,'overtime2'=>$overtime2,'clockIntime'=>$clockIntime,'clockOuttime'=>$clockOuttime,'overTimeStartsAfter'=>$overTimeStartsAfter,'doubleTimeStartsAfter'=>$doubleTimeStartsAfter,'overTimeCalCulation'=>$overTimeCalCulation);
	    		}
	    		
    		}
    		
    	}
    	//die("here");
    	
    	return $newReportArray;
    }
    
    function getOvertimecalculations($userId)
    {
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	return $overTimeCal = Yii::app()->db->createCommand()
	    	->select("overtime_starts_after_type,doubletime_starts_after_type,overtime_starts_after,doubletime_starts_after")
	    	->from('ubase_user_payroll_items')
	    	->where("ubase_company_id=$companyId  and ubase_user_id=$userId")
	    	->queryRow();
    }
    public function daySheet($from,$type,$queryParts='',$techQueryPart='',$queryPartsVisit='',$techQueryPartVisit='',$noTechsFlag='',$unasOnly='')
    {
    	$reports=array();
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$report = Yii::app()->db->createCommand()
				->select("uj.id as job_id, uj.job_number, uj.ubase_customer_id as customer_id,ucc.fname,ucc.lname,ucp.phone_number,uce.email,uj.job_start_date,uj.time_frame_promised_start as startTime,uj.time_frame_promised_end as endTime,uj.public_notes,uj.internal_notes,uc.customer_name,ujl.name,ujl.address_1,ujl.address_2,ujl.city,ujl.state,ujl.postal_code")
				->from('ubase_jobs uj')
				->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
				->join('master_statuses ms','uj.master_status_id = ms.id')
				->join('master_status_categories msc','ms.master_status_category_id=msc.id')
				->leftjoin('ubase_job_note_to_customer ujn','ujn.ubase_job_id = uj.id')
				->leftjoin('ubase_customer_contacts ucc','ucc.ubase_customer_id = uc.id and ucc.is_primary=1 AND ucc.is_deleted = 0')
				->leftjoin('ubase_customer_phones ucp','ucp.ubase_customer_contact_id = ucc.id and ucp.is_active=1')
				->leftjoin('ubase_customer_emails uce','uce.ubase_customer_contact_id = ucc.id and uce.is_active=1')
				->leftjoin('ubase_job_locations ujl','ujl.ubase_job_id=uj.id')       
				->where(" uj.ubase_company_id=$companyId  $queryParts")  //Removed msc.code != 'ESTIMATE' for Ticket #2502: To list estimates also 
				->group('uj.id,uj.job_start_date')
				->order('uj.job_start_date asc,uj.time_frame_promised_start asc')
				->queryAll();
		foreach ($report as $index=>$row){//for selecting job assigned workers
			$jobId=$row['job_id'];
			$curTechQueryPart = $techQueryPart;
			if($noTechsFlag == 1 && $unasOnly==1){
				$curTechQueryPart ='';
			}
			$jobAssignedWorkers = Yii::app()->db->createCommand()
								->select("ujaw.ubase_user_id as user_id")
								->from('ubase_job_assigned_workers ujaw')
								->where("ujaw.ubase_job_id=$jobId and ujaw.is_deleted='0' $curTechQueryPart")
								->queryColumn();
			//$report[$index]['users']=implode(',',$jobAssignedWorkers);
			if($noTechsFlag == 1 && empty($jobAssignedWorkers)){
				$report[$index]['users']=array('Unassigned');
			}else{
				$report[$index]['users']=$jobAssignedWorkers;
			}
				
			if($techQueryPart!='' && empty($jobAssignedWorkers)){
				if($noTechsFlag != 1){
					unset($report[$index]);
				}else{
					if($unasOnly!=1){
						$jobAssignedWorkersNow = Yii::app()->db->createCommand()
						->select("ujaw.ubase_user_id as user_id")
						->from('ubase_job_assigned_workers ujaw')
						->where("ujaw.ubase_job_id=$jobId and ujaw.is_deleted='0' ")
						->queryColumn();
						if(!empty($jobAssignedWorkersNow)){
							unset($report[$index]);
						}
					}
				}
			}else{
    			if($techQueryPart!='' && $noTechsFlag == 1 && $unasOnly==1){
    				unset($report[$index]);
    			}
    		}
			
		}
		//print_r($report);die;
		$jobsVisits = Yii::app()->db->createCommand()
				->select("uj.id as job_id, uj.job_number, ujv.id as visit_id,uj.ubase_customer_id as customer_id,ucc.fname,ucc.lname,ucp.phone_number,uce.email,ujv.job_start_date,ujv.time_frame_promised_start as startTime,ujv.time_frame_promised_end as endTime,uj.public_notes,ujv.notes_for_techs as internal_notes,uc.customer_name,ujl.name,ujl.address_1,ujl.address_2,ujl.city,ujl.state,ujl.postal_code")
				->from('ubase_jobs uj')
				->join ("ubase_job_visits ujv","ujv.ubase_job_id=uj.id")
				->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
				->join('master_statuses ms','uj.master_status_id = ms.id')
				->join('master_status_categories msc','ms.master_status_category_id=msc.id')
				->leftjoin('ubase_job_note_to_customer ujn','ujn.ubase_job_id = uj.id')
				->leftjoin('ubase_customer_contacts ucc','ucc.ubase_customer_id = uc.id and ucc.is_primary=1 AND ucc.is_deleted = 0')
				->leftjoin('ubase_customer_phones ucp','ucp.ubase_customer_contact_id = ucc.id and ucp.is_active=1')
				->leftjoin('ubase_customer_emails uce','uce.ubase_customer_contact_id = ucc.id and uce.is_active=1')
				->leftjoin('ubase_job_locations ujl','ujl.ubase_job_id=uj.id')       
				->where("uj.ubase_company_id=$companyId  $queryPartsVisit")  //Removed msc.code != 'ESTIMATE' for Ticket #2502: To list estimates also
				->group('ujv.id,uj.job_start_date')
				->order('ujv.job_start_date asc,ujv.time_frame_promised_start asc')
				->queryAll();
				foreach ($jobsVisits as $index=>$row){//for selecting job assigned workers
					$jobId=$row['visit_id'];
					$curTechQueryPartVisit = $techQueryPartVisit;
					if($noTechsFlag == 1 && $unasOnly==1){
						$curTechQueryPartVisit ='';
					}

					$jobAssignedWorkersVisit = Yii::app()->db->createCommand()
					->select("jaw.ubase_user_id")
					->from("ubase_job_visits_assigned_workers jaw")
					->where("jaw.ubase_job_visit_id = $jobId and jaw.is_deleted='0' $curTechQueryPartVisit")
					->queryColumn();
					//$report[$index]['users']=implode(',',$jobAssignedWorkers);
					
					if($noTechsFlag == 1 && empty($jobAssignedWorkersVisit)){
						$jobsVisits[$index]['users']=array('Unassigned');
					}else{
						$jobsVisits[$index]['users']=$jobAssignedWorkersVisit;
					}
					if($techQueryPart!='' && empty($jobAssignedWorkersVisit)){
						if($noTechsFlag != 1){
							unset($jobsVisits[$index]);
						}else{
							if($unasOnly!=1){
								$jobAssignedWorkersVisitNow = Yii::app()->db->createCommand()
								->select("jaw.ubase_user_id")
								->from("ubase_job_visits_assigned_workers jaw")
								->where("jaw.ubase_job_visit_id = $jobId and jaw.is_deleted='0' ")
								->queryColumn();
								if(!empty($jobAssignedWorkersVisitNow)){
									unset($jobsVisits[$index]);
								}
							}
						}
					}else{
		    			if($techQueryPart!='' && $noTechsFlag == 1 && $unasOnly==1){
		    				unset($jobsVisits[$index]);
		    			}
		    		}					
				}
				
		$customerJobs = array_merge($jobsVisits,$report);	//print_r($customerJobs);exit;	
		//$customerJobs=$report;
    	foreach ($customerJobs as $data){
                if(!empty($data['users'])){
                	foreach ($data['users'] as $userId){
                		if($userId != 'Unassigned'){
                			$reports[$userId]['data'][]=$data;                		
                			$reports[$userId]['name']=Helper::getUsernameFromUserId($userId);
                		}else{
                			$userId = 'Unassigned';
                			$reports[$userId]['data'][]=$data;
                			$reports[$userId]['name']='Unassigned';
                		}
                		usort($reports[$userId]['data'], array("Helper", "cmpDaySheetDate"));
                	}
                }
        }//print_r($reports);exit;	
        
        usort($reports, array("Helper", "cmpDaySheetName"));
        //print_r($reports);exit;
        //usort($reports, array("Helper", "cmpDaySheet"));
    	unset($customerJobs);
		return $reports;
    }
    
    public function daySheetExpanded($from,$type,$queryParts='',$techQueryPart='',$queryPartsVisit='',$techQueryPartVisit='',$noTechsFlag='',$unasOnly='')
    {
    	$reports=array();
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$report = Yii::app()->db->createCommand()
    	->select("uj.id as job_id, uj.job_number, uj.ubase_customer_id as customer_id,ucc.fname,ucc.lname,ucp.phone_number,uce.email,uj.job_start_date,uj.time_frame_promised_start as startTime,uj.time_frame_promised_end as endTime,uj.public_notes,uj.internal_notes,uc.customer_name,ujl.name,ujl.address_1,ujl.address_2,ujl.city,ujl.state,ujl.postal_code")
    	->from('ubase_jobs uj')
    	->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
    	->join('master_statuses ms','uj.master_status_id = ms.id')
    	->join('master_status_categories msc','ms.master_status_category_id=msc.id')
    	->leftjoin('ubase_job_note_to_customer ujn','ujn.ubase_job_id = uj.id')
    	->leftjoin('ubase_customer_contacts ucc','ucc.ubase_customer_id = uc.id and ucc.is_primary=1 AND ucc.is_deleted = 0')
    	->leftjoin('ubase_customer_phones ucp','ucp.ubase_customer_contact_id = ucc.id and ucp.is_active=1')
    	->leftjoin('ubase_customer_emails uce','uce.ubase_customer_contact_id = ucc.id and uce.is_active=1')
    	->leftjoin('ubase_job_locations ujl','ujl.ubase_job_id=uj.id')
    	->where(" uj.ubase_company_id=$companyId  $queryParts")    //Removed msc.code != 'ESTIMATE' for Ticket #2502: To list estimates also
    	->group('uj.id,uj.job_start_date')
    	->order('uj.job_start_date asc,uj.time_frame_promised_start asc')
    	->queryAll();
    	foreach ($report as $index=>$row){//for selecting job assigned workers
    		$jobId=$row['job_id'];
    		$curTechQueryPart = $techQueryPart;
    		if($noTechsFlag == 1 && $unasOnly==1){
    			$curTechQueryPart ='';
    		}
    		$jobAssignedWorkers = Yii::app()->db->createCommand()
    		->select("ujaw.ubase_user_id as user_id")
    		->from('ubase_job_assigned_workers ujaw')
    		->where("ujaw.ubase_job_id=$jobId and ujaw.is_deleted='0' $curTechQueryPart")
    		->queryColumn();
    		//$report[$index]['users']=implode(',',$jobAssignedWorkers);
    		if($noTechsFlag == 1 && empty($jobAssignedWorkers)){
    			$report[$index]['users']=array('Unassigned');
    		}else{
    			$report[$index]['users']=$jobAssignedWorkers;
    		}
    		if($techQueryPart!='' && empty($jobAssignedWorkers)){
    			if($noTechsFlag != 1){
    				unset($report[$index]);
    			}else{
					if($unasOnly!=1){
						$jobAssignedWorkersNow = Yii::app()->db->createCommand()
			    		->select("ujaw.ubase_user_id as user_id")
			    		->from('ubase_job_assigned_workers ujaw')
			    		->where("ujaw.ubase_job_id=$jobId and ujaw.is_deleted='0' ")
			    		->queryColumn();
						if(!empty($jobAssignedWorkersNow)){
							unset($report[$index]);
						}
					}
				}
    		}else{
    			if($techQueryPart!='' && $noTechsFlag == 1 && $unasOnly==1){
    				unset($report[$index]);
    			}
    		}
    	}
    	$jobsVisits = Yii::app()->db->createCommand()
    	->select("uj.id as job_id, uj.job_number, ujv.id as visit_id,uj.ubase_customer_id as customer_id,ucc.fname,ucc.lname,ucp.phone_number,uce.email,ujv.job_start_date,ujv.time_frame_promised_start as startTime,ujv.time_frame_promised_end as endTime,uj.public_notes,ujv.notes_for_techs as internal_notes,uc.customer_name,ujl.name,ujl.address_1,ujl.address_2,ujl.city,ujl.state,ujl.postal_code")
    	->from('ubase_jobs uj')
    	->join ("ubase_job_visits ujv","ujv.ubase_job_id=uj.id")
    	->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
    	->join('master_statuses ms','uj.master_status_id = ms.id')
    	->join('master_status_categories msc','ms.master_status_category_id=msc.id')
    	->leftjoin('ubase_job_note_to_customer ujn','ujn.ubase_job_id = uj.id')
    	->leftjoin('ubase_customer_contacts ucc','ucc.ubase_customer_id = uc.id and ucc.is_primary=1 AND ucc.is_deleted = 0')
    	->leftjoin('ubase_customer_phones ucp','ucp.ubase_customer_contact_id = ucc.id and ucp.is_active=1')
    	->leftjoin('ubase_customer_emails uce','uce.ubase_customer_contact_id = ucc.id and uce.is_active=1')
    	->leftjoin('ubase_job_locations ujl','ujl.ubase_job_id=uj.id')
    	->where("uj.ubase_company_id=$companyId  $queryPartsVisit")     //Removed msc.code != 'ESTIMATE' for Ticket #2502: To list estimates also
    	->group('ujv.id,uj.job_start_date')
    	->order('ujv.job_start_date asc,ujv.time_frame_promised_start asc')
    	->queryAll();
    	foreach ($jobsVisits as $index=>$row){//for selecting job assigned workers
    		$jobId=$row['visit_id'];
    		$curTechQueryPartVisit = $techQueryPartVisit;
    		if($noTechsFlag == 1 && $unasOnly==1){
    			$curTechQueryPartVisit ='';
    		}
    
    		$jobAssignedWorkersVisit = Yii::app()->db->createCommand()
    		->select("jaw.ubase_user_id")
    		->from("ubase_job_visits_assigned_workers jaw")
    		->where("jaw.ubase_job_visit_id = $jobId and jaw.is_deleted='0' $curTechQueryPartVisit")
    		->queryColumn();
    		//$report[$index]['users']=implode(',',$jobAssignedWorkers);
    		if($noTechsFlag == 1 && empty($jobAssignedWorkersVisit)){
    			$jobsVisits[$index]['users']=array('Unassigned');
    		}else{
    			$jobsVisits[$index]['users']=$jobAssignedWorkersVisit;
    		}
    		if($techQueryPart!='' && empty($jobAssignedWorkersVisit)){
    			if($noTechsFlag != 1){
    				unset($jobsVisits[$index]);
    			}else{
					if($unasOnly!=1){
						$jobAssignedWorkersVisitNow = Yii::app()->db->createCommand()
			    		->select("jaw.ubase_user_id")
			    		->from("ubase_job_visits_assigned_workers jaw")
			    		->where("jaw.ubase_job_visit_id = $jobId and jaw.is_deleted='0' ")
			    		->queryColumn();
						if(!empty($jobAssignedWorkersVisitNow)){
							unset($jobsVisits[$index]);
						}
					}
				}
    		}else{
    			if($techQueryPart!='' && $noTechsFlag == 1 && $unasOnly==1){
    				unset($jobsVisits[$index]);
    			}
    		}
    	}
    
    	$customerJobs = array_merge($jobsVisits,$report);
    	//$customerJobs=$report;
    	foreach ($customerJobs as $data){
    		if(!empty($data['users'])){
    			foreach ($data['users'] as $userId){
    				if($userId != 'Unassigned'){
	    				$reports[$userId]['data'][]=$data;
	                	$reports[$userId]['name']=Helper::getUsernameFromUserId($userId);
    				}else{
    					$userId = 'Unassigned';
    					$reports[$userId]['data'][]=$data;
    					$reports[$userId]['name']='Unassigned';
    				}
                	usort($reports[$userId]['data'], array("Helper", "cmpDaySheetDate"));
    			}
    		}
    	}
    	usort($reports, array("Helper", "cmpDaySheetName"));
    	unset($customerJobs);
    	return $reports;
    }
    
    public function daySheetWorkOrder($from,$type,$queryParts='',$techQueryPart='',$queryPartsVisit='',$techQueryPartVisit='')
    {
    	 
    	$reports=array();
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$report = Yii::app()->db->createCommand()
    	->select("uj.id as job_id, uj.job_number,uj.completion_notes, uj.ubase_customer_id as customer_id,uj.job_po_number,ucc.fname,ucc.lname,ucp.phone_number,uj.job_start_date,uj.job_end_date,uj.job_duration,uj.time_frame_promised_start as startTime,uj.time_frame_promised_end as endTime,uj.ubase_customer_contact_id,
    	uj.public_notes,uj.internal_notes,uc.customer_name,ujl.name,ujl.address_1,ujl.address_2,ujl.city,ujl.state,ujl.postal_code,ucm.company_name,ucm.street_1 as cmpnyStreet1,ucm.street_2 as cmpnyStreet2,ucm.city as cmpnyCity,ucm.state as cmpnyState,ucm.postal_code as cmpnyPostalCode")
    	->from('ubase_jobs uj')
    	->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
    	->join('master_statuses ms','uj.master_status_id = ms.id')
    	->join('master_status_categories msc','ms.master_status_category_id=msc.id')
    	->join('ubase_companies ucm','uj.ubase_company_id=ucm.id')
    	->leftjoin('ubase_job_note_to_customer ujn','ujn.ubase_job_id = uj.id')
    	->leftjoin('ubase_customer_contacts ucc','ucc.ubase_customer_id = uc.id and ucc.is_primary=1 AND ucc.is_deleted = 0')
    	->leftjoin('ubase_customer_phones ucp','ucp.ubase_customer_contact_id = ucc.id and ucp.is_active=1')
    	->leftjoin('ubase_job_locations ujl','ujl.ubase_job_id=uj.id')
    	 
    	 
    	->where(" uj.ubase_company_id=$companyId  $queryParts")    //Removed msc.code != 'ESTIMATE' for Ticket #2502: To list estimates also
    	->group('uj.id,uj.job_start_date')
    	->order('uj.id desc')
    	->queryAll();
    	$reportArray = array();
    	if(!empty($report)){
    		foreach ($report as $rep){
    			$contactId = $rep['ubase_customer_contact_id'];
    			$customerId = $rep['customer_id'];
    			$reportArray[$rep['job_id']]['jobId'] = $rep['job_id'];
    			$reportArray[$rep['job_id']]['jobNumber'] = $rep['job_number'];
    			$reportArray[$rep['job_id']]['startDate'] = $rep['job_start_date'];
    			$reportArray[$rep['job_id']]['endDate'] = $rep['job_end_date'];
    			$reportArray[$rep['job_id']]['startTime'] = $rep['startTime'];
    			$reportArray[$rep['job_id']]['endTime'] = $rep['endTime'];
    			$reportArray[$rep['job_id']]['jobDuration'] = $rep['job_duration'];
    			$reportArray[$rep['job_id']]['jobDesc'] = $rep['public_notes'];
    			$reportArray[$rep['job_id']]['internalNotes'] = $rep['internal_notes'];
    			$reportArray[$rep['job_id']]['customerName'] = $rep['customer_name'];
    			$reportArray[$rep['job_id']]['contactFname'] = $rep['fname'];
    			$reportArray[$rep['job_id']]['contactLname'] = $rep['lname'];
    			$reportArray[$rep['job_id']]['adress1'] = $rep['address_1'];
    			$reportArray[$rep['job_id']]['adress2'] = $rep['address_2'];
    			$reportArray[$rep['job_id']]['city'] = $rep['city'];
    			$reportArray[$rep['job_id']]['state'] = $rep['state'];
    			$reportArray[$rep['job_id']]['postalCode'] = $rep['postal_code'];
    			$reportArray[$rep['job_id']]['companyName'] = $rep['company_name'];
    			$reportArray[$rep['job_id']]['cmpnyStreet1'] = $rep['cmpnyStreet1'];
    			$reportArray[$rep['job_id']]['cmpnyStreet2'] = $rep['cmpnyStreet2'];
    			$reportArray[$rep['job_id']]['cmpnyCity'] = $rep['cmpnyCity'];
    			$reportArray[$rep['job_id']]['cmpnyState'] = $rep['cmpnyState'];
    			$reportArray[$rep['job_id']]['cmpnyPostalCode'] = $rep['cmpnyPostalCode'];
    			$reportArray[$rep['job_id']]['jobPoNumber'] = $rep['job_po_number'];
    			$reportArray[$rep['job_id']]['completeionNotes'] = $rep['completion_notes'];
    			$status=Jobs::getServiceStatus($rep['job_id']);
    			$reportArray[$rep['job_id']]['statusName'] = $status;
    			
    			$jobTasks=JobTasks::model()->findAll('ubase_job_id=:jobId AND is_deleted=0',array(':jobId'=>$rep['job_id']));
    			$taskArray = array();
    			$i = 0;
    			foreach ($jobTasks as $task){
    				$taskArray[$i]['Desc'] = $task['description'];
    				$taskArray[$i]['IsCmpltd'] = $task['is_completed'];
    				$i++;
    			}
    			$reportArray[$rep['job_id']]['tasks'] = $taskArray;
    			$techs=array();
    			$sql = "SELECT b.first_name,b.last_name FROM `ubase_job_assigned_workers` a JOIN ubase_users b ON (a.ubase_user_id=b.id) where ubase_job_id =".$rep['job_id'];
    			$techsArray=Yii::app()->db->createCommand($sql)->queryAll();
    			$i = 0;
    			foreach ($techsArray as $tech){
    				$techs[$i]['Name']=$tech['first_name'].' '.$tech['last_name'];
    				$i++;
    			}
    			$reportArray[$rep['job_id']]['techs'] = $techs;
    			$customField = array();
    			$i = 0;
    			$modelCustomFields = JobCustomFieldValues::model()->findAll('ubase_job_id=:id',array(':id'=>$rep['job_id']));
    			foreach ($modelCustomFields as $custom){
    				$customField[$i]['type'] = $custom['type'];
    				$customField[$i]['name'] = $custom['name'];
    				$customField[$i]['values'] = $custom['values'];
    				$customField[$i]['job_value'] = $custom['job_value'];
    				$i++;
    			}
    			 
    			$reportArray[$rep['job_id']]['customFields'] = $customField;
    			$phoneArray = array();
    			$i = 0;
    			$customerPhones =CustomerPhones::model()->findAll('ubase_customer_contact_id=:ubase_customer_contact_id',array(':ubase_customer_contact_id'=>$contactId));
    			foreach ($customerPhones as $phone){
    				$phoneArray[$i]['phoneNumber'] = $phone['phone_number'];
    				$phoneArray[$i]['phoneExt'] = $phone['phone_ext'];
    				$i++;
    			}
    			$reportArray[$rep['job_id']]['phoneArray'] = $phoneArray;
    			$emailArray = array();
    			$i = 0;
    			$customerEmails =CustomerEmails::model()->findAll('ubase_customer_contact_id=:ubase_customer_contact_id',array(':ubase_customer_contact_id'=>$contactId));
    			foreach ($customerEmails as $email){
    				$emailArray[$i]['email'] = $email['email'];
    				$i++;
    			}
    			$reportArray[$rep['job_id']]['emailArray'] = $emailArray;
    			$customerLocation=CustomerLocations::model()->find('ubase_customer_id=:ubase_customer_id and is_primary=1',array(':ubase_customer_id'=>$customerId));
    			$reportArray[$rep['job_id']]['customerStreet1'] = $customerLocation['street_1'];
    			$reportArray[$rep['job_id']]['customerStreet2'] = $customerLocation['street_2'];
    			$reportArray[$rep['job_id']]['customerState'] = $customerLocation['state'];
    			$reportArray[$rep['job_id']]['customerCity'] = $customerLocation['city'];
    			$reportArray[$rep['job_id']]['customerPostalCode'] = $customerLocation['postal_code'];
    			$sql = "SELECT a.time_value,c.first_name,c.last_name,b.name FROM `ubase_job_time_logs` a JOIN master_statuses b ON(a.code=b.code and b.ubase_company_id=$companyId) JOIN ubase_users c ON(a.ubase_user_id=c.id) where a.ubase_company_id=$companyId and a.ubase_job_id=".$rep['job_id']." ORDER BY a.id ASC";
    			$jobStatuses=Yii::app()->db->createCommand($sql)->queryAll();
    			$jobStatusesArray = array();
    			$i = 0;
    			foreach ($jobStatuses as $status){
    				$jobStatusesArray[$i]['timeValue'] = $status['time_value'];
    				$jobStatusesArray[$i]['techName'] = $status['first_name']." ".$status['last_name'];
    				$jobStatusesArray[$i]['statusName'] = $status['name'];
    				$i++;
    			}
    			$reportArray[$rep['job_id']]['jobStatuses'] = $jobStatusesArray;
    			$sqlFees = "SELECT sum(a.total) FROM `ubase_job_other_charges` a JOIN ubase_other_charges b ON(a.ubase_job_other_charge_id = b.id and b.category='2') WHERE a.`ubase_job_id` = ".$rep['job_id'];
    			$jobTotalFees=Yii::app()->db->createCommand($sqlFees)->queryScalar();
    			$sqlDis = "SELECT sum(a.total) FROM `ubase_job_other_charges` a JOIN ubase_other_charges b ON(a.ubase_job_other_charge_id = b.id and b.category='3') WHERE a.`ubase_job_id` = ".$rep['job_id'];
    			$jobTotalDis=Yii::app()->db->createCommand($sqlDis)->queryScalar();
    			$reportArray[$rep['job_id']]['jobTotalCharge'] = $jobTotalFees-$jobTotalDis;
    			
    			$sqlTax = "SELECT sum(a.total) FROM `ubase_job_other_charges` a JOIN ubase_other_charges b ON(a.ubase_job_other_charge_id = b.id and b.category=1) WHERE a.`ubase_job_id` = ".$rep['job_id'];
    			$jobTotalTax=Yii::app()->db->createCommand($sqlTax)->queryScalar();
    			$reportArray[$rep['job_id']]['jobTotalTax'] = $jobTotalTax;
    			
    			$sqlSer = "SELECT sum(total) FROM `ubase_job_service_rates` where ubase_job_id = ".$rep['job_id'];
    			$jobTotalSer = Yii::app()->db->createCommand($sqlSer)->queryScalar();
    			$sqlPro = "SELECT sum(total) FROM `ubase_job_product_rates` where ubase_job_id = ".$rep['job_id'];
    			$jobTotalPro = Yii::app()->db->createCommand($sqlPro)->queryScalar();
    			$reportArray[$rep['job_id']]['ProSerTotal'] = $jobTotalPro+$jobTotalSer;
    			
    		}
    	}
    	//print_r($reportArray);exit;
    	unset($customerJobs);
    	return $reportArray;
    
    }
    
    public function transactionsByCustomer($queryParts)
    {
    	$reports=$report=array();
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$reports = Yii::app()->db->createCommand()
    			->select("uc.customer_name,uj.id as job_id, uj.job_number, up.transaction_type,up.received_on,up.authorization_code,up.memo,up.amount,up.received_by,up.reference_number,up.transaction_type,cpm.first_four,cpm.last_four,cpm.cc_type,upt.name as method,upt.type,up.transaction_token")
    			->from("ubase_customers uc")
    			->leftjoin('ubase_jobs uj', 'uj.ubase_customer_id=uc.id')
    			->join('ubase_payments up', 'up.ubase_job_id=uj.id')
    			->leftJoin('ubase_customer_pay_methods cpm', 'cpm.id=up.ubase_customer_pay_method_id')
    			->leftjoin('ubase_payment_types upt','upt.id=up.ubase_payment_type_id')
    			->leftjoin('ubase_users uu', 'up.created_by=uu.id')
    			->where("uc.ubase_company_id=$companyId and uc.is_deleted=0 $queryParts")
    			->order("uc.customer_name asc,up.received_on desc")
    			->queryAll();
    			
    	foreach ($reports as $data){
                $report[$data['customer_name']][]=$data;
        }
    	return $report;
    	$report=$reports='';
    }
    
	public function transactionsByJob($queryParts)
    {
    	$reports=$report=array();
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$reports = Yii::app()->db->createCommand()
    			->select("uc.customer_name,uj.id as job_id, uj.job_number, up.transaction_type,up.received_on,up.authorization_code,up.memo,up.amount,up.received_by,up.reference_number,up.transaction_type,cpm.first_four,cpm.last_four,cpm.cc_type,upt.name as method,upt.type,up.transaction_token")
    			->from("ubase_customers uc")
    			->leftjoin('ubase_jobs uj', 'uj.ubase_customer_id=uc.id')
    			->join('ubase_payments up', 'up.ubase_job_id=uj.id')
    			->leftJoin('ubase_customer_pay_methods cpm', 'cpm.id=up.ubase_customer_pay_method_id')
    			->leftjoin('ubase_payment_types upt','upt.id=up.ubase_payment_type_id')
    			->leftjoin('ubase_users uu', 'up.created_by=uu.id')
    			->where("uc.ubase_company_id=$companyId and uc.is_deleted=0 $queryParts")
    			->order('uc.customer_name asc,up.received_on desc')
    			->queryAll();
    	foreach ($reports as $data){
                $report[$data['job_id']][]=$data;
        }
    	return $report;
    	$report=$reports='';
    }
    
	public function transactionsByTech($queryParts)
    {
    	$reports=$report=array();
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$reports = Yii::app()->db->createCommand()
    			->select("concat(uu.first_name,' ',uu.last_name) as tech_name,uc.customer_name,uj.id as job_id, uj.job_number, up.transaction_type,up.received_on,up.authorization_code,up.memo,up.amount,up.transaction_type,up.received_by,up.reference_number,cpm.first_four,cpm.last_four,cpm.cc_type,upt.name as method,upt.type,up.transaction_token")
    			->from("ubase_payments up")
    			->leftjoin('ubase_jobs uj', 'up.ubase_job_id=uj.id')
    			->leftjoin("ubase_customers uc",'uj.ubase_customer_id=uc.id')
    			->join('ubase_users uu', 'up.created_by=uu.id')
    			->leftJoin('ubase_customer_pay_methods cpm', 'cpm.id=up.ubase_customer_pay_method_id')
    			->leftjoin('ubase_payment_types upt','upt.id=up.ubase_payment_type_id')
    			->where("uu.ubase_company_id=$companyId and uu.is_deleted=0 $queryParts")
    			->order('tech_name asc,up.received_on desc')
    			->queryAll();
    	foreach ($reports as $data){
                $report[$data['tech_name']][]=$data;
        }
    	return $report;
    	$report=$reports='';
    }
    
    
    function timeDiffrence($fromDate,$toDate)
    {
    	$to_time = strtotime($toDate);
    	$from_time = strtotime($fromDate);
    	$timeDiff = round(($to_time - $from_time)/3600,2);
    	$timeDiff = ($to_time - $from_time)/3600;
    	//$timeDiff = ($to_time - $from_time);
    	return $timeDiff;
    	
    }
    
    /**
     * 
     * Function to get sales report by Referral
     * @Author : Nabeel
     * @param $from
     * @param $type
     */
	public function getSalesReportReferral($from='',$type='')
    {
    	$report=array();
    	$customerJobs=Reports::fetchSalesReportReferral($from,$type);
    	foreach ($customerJobs as $data){
                $report[$data['ubase_source_id']][]=$data;
                $report[$data['ubase_source_id']]['name']=$data['source_name'];
        }
        usort($report, array("Helper", "cmp"));
    	unset($customerJobs);
		return $report;
    }
    
    /**
     * 
     * Function to get sales report by Referral
     * @Author : Nabeel
     * @param $from
     * @param $type
     */
    public function fetchSalesReportReferral($from='',$type='')
    {
    	$result=Reports::getQueryParts($from,$type);
    	
    	$queryParts=$result[0];
    	$techQueryPart=$result[1];
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	/*$report = Yii::app()->db->createCommand()
				->select("uj.id as job_id,ujcs.category,uj.ubase_customer_id as customer_id,uj.ubase_source_id,uj.job_start_date,uj.time_frame_promised_start as startTime,uj.public_notes,uj.job_po_number,IFNULL(us.short_name, 'zz') as source_name,uc.customer_name,ms.name as jobStatus,ujt.total_labor_charges,ujt.total_expense_charges,COALESCE(sum(ujsr.total),0) as serviceRate,COALESCE(sum(ujpr.total),0) as productRate,COALESCE(ujt.total_labor_charges,0)+COALESCE(ujt.total_expense_charges,0)+COALESCE(ujt.job_total,0)-COALESCE(ujt.job_total_payments,0) as total")
				->from('ubase_jobs uj')
				->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
				->leftjoin('ubase_sources us','uj.ubase_source_id = us.id')
				->join('master_statuses ms','uj.master_status_id = ms.id')
				->join('ubase_job_totals ujt','ujt.ubase_job_id = uj.id')
				->join('master_status_categories msc','ms.master_status_category_id=msc.id')
				->leftjoin('ubase_job_service_rates ujsr','ujsr.ubase_job_id = uj.id')   
				->leftjoin('ubase_job_product_rates ujpr','ujpr.ubase_job_id = uj.id')     
				->leftjoin('ubase_job_categories ujcs','ujcs.id  = uj.ubase_job_categories_id')      
				->where("msc.code != 'ESTIMATE' AND uj.ubase_company_id=$companyId  $queryParts")
				->group('uj.id,uj.job_start_date')
				->order('uj.job_start_date asc,uj.time_frame_promised_start,us.short_name asc')
				->queryAll();*/
    	
    	$report = Yii::app()->db->createCommand()
    	->select("uj.id as job_id, uj.job_number, ujcs.category,uj.ubase_customer_id as customer_id,uj.ubase_source_id,uj.job_start_date,uj.time_frame_promised_start as startTime,uj.public_notes,uj.job_po_number,IFNULL(us.short_name, 'zz') as source_name,uc.customer_name,ms.name as jobStatus,ujt.total_labor_charges,ujt.total_expense_charges,COALESCE(ujsr.serviceRate,0) as serviceRate,COALESCE(ujpr.productRate,0) as productRate,COALESCE(ujt.total_labor_charges,0)+COALESCE(ujt.total_expense_charges,0)+COALESCE(ujt.job_total,0) as total")
    	->from('ubase_jobs uj')
    	->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
    	->leftjoin('ubase_sources us','uj.ubase_source_id = us.id')
    	->join('master_statuses ms','uj.master_status_id = ms.id')
    	->join('ubase_job_totals ujt','ujt.ubase_job_id = uj.id')
    	->join('master_status_categories msc','ms.master_status_category_id=msc.id')
    	->leftjoin('(SELECT ubase_job_id, sum(total)  serviceRate FROM  ubase_job_service_rates GROUP BY ubase_job_id) ujsr','ujsr.ubase_job_id = uj.id')
    	->leftjoin('(SELECT ubase_job_id,sum(total) as productRate  FROM  ubase_job_product_rates GROUP BY ubase_job_id) ujpr','ujpr.ubase_job_id = uj.id')
    	->leftjoin('ubase_job_categories ujcs','ujcs.id  = uj.ubase_job_categories_id')
    	->where("msc.code != 'ESTIMATE' AND uj.ubase_company_id=$companyId  $queryParts")
    	->group('uj.id,uj.job_start_date')
    	->order('uj.job_start_date asc,uj.time_frame_promised_start,us.short_name asc')
    	->queryAll();
    	
    	
		foreach ($report as $index=>$row){//for selecting job assigned workers
			$jobId=$row['job_id'];
			$jobAssignedWorkers = Yii::app()->db->createCommand()
								->select("ujaw.ubase_user_id as user_id")
								->from('ubase_job_assigned_workers ujaw')
								->where("ujaw.ubase_job_id=$jobId and ujaw.is_deleted='0'")
								->queryColumn();
			//$report[$index]['users']=implode(',',$jobAssignedWorkers);
			$report[$index]['users']=$jobAssignedWorkers;
			if($techQueryPart!='' && empty($jobAssignedWorkers)){
				unset($report[$index]);
			}
		}  
		
		return $report;
    }
    /**
     * Function to generate custom Product Sales By Customer Report
     * @param unknown_type $from
     * @param unknown_type $type
     */
    public function getProductSalesByCustomerReport($from='',$type='',$queryParts='',$servicePart='',$productPart='',$startDate='',$endDate='')
    {
    	$report=array();
    	$main = "ubase_customers uc";
    	$parts=" and uu.is_field_worker=1";
    	//$sub="user.is_deleted='0' and";
    	$sub = "";
    		
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$reportsCust = Yii::app()->db->createCommand()
	    	->select("uj.id as job_id,uj.job_number,uj.job_start_date,uc.customer_name,uc.id as customer_id,ujt.job_total,
	    			up.make,up.model,sum(ujpr.multiplier) as multiplier,ujpl.ubase_product_id as jobProductId,
	    			up.unit_cost as unitCost,ujpl.id as productListId, up.part_number, ujpr.multiplier as qty")
	    	->from("$main")
	    	->join('ubase_jobs uj','uc.id=uj.ubase_customer_id')	    	
	    	->join('master_statuses ms','uj.master_status_id = ms.id')
	    	->join('master_status_categories msc','ms.master_status_category_id=msc.id')
	    	->join('ubase_job_totals ujt','ujt.ubase_job_id=uj.id')
	    	->join('ubase_job_product_lists ujpl','ujpl.ubase_job_id=uj.id')
	    	->join('ubase_job_product_rates ujpr','ujpr.ubase_job_product_list_id=ujpl.id')
	    	->join('ubase_products up','ujpl.ubase_product_id=up.id')
	    	->leftjoin('ubase_job_assigned_workers user','user.ubase_job_id=uj.id')
	    	->leftjoin('ubase_users uu','user.ubase_user_id = uu.id')
	    	->where("msc.code != 'ESTIMATE'  $queryParts 
	    			AND up.ubase_company_id=$companyId GROUP BY ujpr.id ORDER BY uj.id")
    		//->getText();echo $reportsCust;exit;
    		->queryAll();    		    		    	   
    	
   		foreach ($reportsCust as $data){
                $report[$data['customer_id']][]=$data;
                $report[$data['customer_id']]['name']=$data['customer_name'];
        }
		usort($report, array("Helper", "cmp"));
		unset($reportsCust);
        //print_r($report);die;
    	return $report;
    	$report=$reports='';
    }

    /**
     * 
     * Enter description here ...
     * @param unknown_type $from
     */
    public function getSalesTaxReport($from='',$type='')
    {
        $companyId =addslashes(Yii::app()->session['companyId']);
        $result=Reports::getQueryParts($from,$type);
        $queryParts=$result[0];
        $result= array();
       $saleTax = Yii::app()->db->createCommand()
        ->select("uc.short_name,uc.id,uc.applies_to_id_service,uc.applies_to_id_product,uc.applies_to_id_fee,ujc.ubase_job_id,uc.rate as tax_rate,ujc.total,ujc.rate,ui.invoice_number,ui.date,uj.job_number,uct.customer_name,ujt.job_total")
        ->from('ubase_other_charges uc')
        ->join('ubase_job_other_charges ujc','ujc.ubase_job_other_charge_id  = uc.id')
        ->join('ubase_invoice_job_lists ujl','ujl.ubase_job_id  = ujc.ubase_job_id' )
        ->join('ubase_invoices ui','ui.id= ujl.ubase_invoice_id')
        ->join('ubase_jobs uj','uj.id= ujc.ubase_job_id')
        ->join('ubase_customers uct','uct.id= uj.ubase_customer_id')
        ->join('ubase_job_totals ujt','ujt.ubase_job_id = uj.id')
        ->where("uc.ubase_company_id=$companyId and uc.category=1 $queryParts")
        ->queryAll();
         //print_r($saleTax);die;
       if(!empty($saleTax)) {
        $i=0;
            foreach ($saleTax as $sales) {
                $jobid = $sales['ubase_job_id'];
                //$service = $sales['applies_to_id_service'];
                //$product = $sales['applies_to_id_product'];
                //$fees = $sales['applies_to_id_fee'];
               //	$service = rtrim($service, ',');
               	//$product = rtrim($product, ',');
               	//$fees = rtrim($fees, ',');
                $servicesSelectedModel = UbaseOtherChargesUbaseServices::model()->findAll("ubase_other_charge_id=:chargeId",array(":chargeId"=>$sales['id']));
                foreach($servicesSelectedModel as $service){
                	$servicesSelected .= $service['ubase_service_id'].',';
                }
                $servicesSelected = rtrim($servicesSelected, ',');
                $productsSelectedModel = UbaseOtherChargesUbaseProducts::model()->findAll("ubase_other_charge_id=:chargeId",array(":chargeId"=>$sales['id']));
                foreach($productsSelectedModel as $product){
                	$productsSelected .= $product['ubase_product_id'].',';
                }
                $productsSelected = rtrim($productsSelected, ',');
                $chargesSelectedModel = UbaseOtherChargesUbaseFees::model()->findAll("ubase_other_charge_id=:chargeId",array(":chargeId"=>$sales['id']));
                foreach($chargesSelectedModel as $fee){
                	$chargesSelected .= $fee['ubase_fee_id'].',';
                }
                $chargesSelected = rtrim($chargesSelected, ',');
               	$qryService = '';
               	$qryProduct = '';
               	$qryFees = '';
               	if($service && $service!=''){
               		$qryService = "AND us.master_service_id IN ($servicesSelected)";
               	}
                if($product && $product!=''){
                	$qryProduct = "AND us.ubase_product_id IN ($productsSelected)";
                }
           		if($fees && $fees!=''){
                	$qryFees = "AND oc.ubase_job_other_charge_id IN ($chargesSelected)";
                }
                	 $servTotal = Yii::app()->db->createCommand()
                    ->select("sum(usr.total)")
                    ->from('ubase_job_service_lists us')
                    ->join('ubase_job_service_rates usr','usr.ubase_job_service_list_id = us.id')
                    ->where("us.ubase_job_id = $jobid  $qryService")
                    ->queryScalar();
                    $proTotal = Yii::app()->db->createCommand()
                    ->select("sum(usr.total)")
                    ->from('ubase_job_product_lists us')
                    ->join('ubase_job_product_rates usr','usr.ubase_job_product_list_id = us.id')
                    ->where("us.ubase_job_id = $jobid  $qryProduct")
                    ->queryScalar();
                    $feeTotal = Yii::app()->db->createCommand()
                    ->select("sum(oc.total)")
                    ->from('ubase_job_other_charges oc')
                    ->where("oc.ubase_job_id = $jobid  $qryFees")
                    ->queryScalar();
                    $result[$sales['short_name']][$i]['date'] = $sales['date'];
                    $result[$sales['short_name']][$i]['invoiceno'] = $sales['invoice_number'];
                    $result[$sales['short_name']][$i]['customer_name'] = $sales['customer_name'];
                    $result[$sales['short_name']][$i]['job_number'] = $sales['job_number'];
                    $result[$sales['short_name']][$i]['job_total'] = $sales['job_total'];
                    $result[$sales['short_name']][$i]['tax_amt'] = $servTotal+$feeTotal+$proTotal;
                    $result[$sales['short_name']][$i]['tax_rate'] = $sales['rate'];
                    $result[$sales['short_name']][$i]['tax'] = $sales['total'];

            $i++;
            }

        }
        return $result;
    }
    
	public function serviceAgreementReport($from,$type,$queryParts)
	{
		$companyId =addslashes(Yii::app()->session['companyId']);
    	$report = Yii::app()->db->createCommand()
	    	->select("ucsa.id,ucsa.name as agreementName,ucsa.date_effective,ucsa.date_expires,ucsa.description,ucsa.amount,ucsa.per_what,uc.customer_name,uc.id as customer_id")
	    	->from("ubase_customer_service_agreements ucsa")
	    	->join('ubase_customers uc','ucsa.ubase_customer_id = uc.id')
	    	->where("$queryParts AND uc.ubase_company_id=$companyId ORDER BY `ucsa`.`date_expires` DESC")
    		//->getText();echo $report;exit;// AND up.ubase_company_id=$companyId removed for Ticket 2251
    		->queryAll();
    		foreach ($report as $key=>$value){
    			$sqlContatctId="SELECT id  FROM `ubase_customer_contacts` WHERE `ubase_customer_id` = $value[customer_id] AND `is_primary` = 1";
    			$contactId =Yii::app()->db->createCommand($sqlContatctId)->queryScalar();
    			$sqlLocation = "SELECT *  FROM `ubase_customer_locations` WHERE `ubase_customer_id` = $value[customer_id] AND `is_primary` = 1 AND `is_active` = 1";
    			$location = Yii::app()->db->createCommand($sqlLocation)->queryRow();
    			$report[$key]['Address'] = $location['street_1'];
    			$report[$key]['City'] = $location['city'];
    			$report[$key]['State'] = $location['state'];
    			$report[$key]['PostalCode'] = $location['postal_code'];
    			$sqlEmail = "SELECT email FROM `ubase_customer_emails` WHERE `ubase_customer_contact_id` = '$contactId' AND `is_active` = 1";
    			$email = Yii::app()->db->createCommand($sqlEmail)->queryScalar();
    			$report[$key]['Email'] = $email;
    			$sqlPhone = "SELECT phone_number FROM `ubase_customer_phones` WHERE `ubase_customer_contact_id` = '$contactId' AND `is_active` = 1";
    			$phone = Yii::app()->db->createCommand($sqlPhone)->queryScalar();
    			$report[$key]['PhoneNumber'] = $phone;
    		}
    		Reports::createServiceAgreementExcel($from,$report);
	}
	public function createServiceAgreementExcel($from,$report)
	{
		Yii::import('ext.phpexcel.XPHPExcel');
    	$objPHPExcel= XPHPExcel::createPHPExcel();
    	
    	$companyId =addslashes(Yii::app()->session['companyId']);
    	$company = Company::model()->find('id=:companyId',array('companyId'=>$companyId));
    	
    	
    	
    	
    	$i = 0;
    	$j = 0;
    	$startIndex = 0;
    	$startTechName = $startIndex + $j;//echo $startTechName.':';
    	
    	//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startTechName, 'Repeat Customer');
    	//$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    	$temp=$startTechName;

    	//$objPHPExcel->getActiveSheet()->getRowDimension('A')->setRowHeight(65);
    	$j = $j+1;//echo $j.'main';
    	$startTechName = $startIndex + $j;
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startTechName, 'Customer Name');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    	$objPHPExcel->getActiveSheet()->getStyle('A'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startTechName, 'Agreement Name');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    	$objPHPExcel->getActiveSheet()->getStyle('B'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startTechName, 'Effective Date');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(23);
    	$objPHPExcel->getActiveSheet()->getStyle('C'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startTechName, 'Expiration Date');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(23);
    	$objPHPExcel->getActiveSheet()->getStyle('D'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startTechName, 'Description');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
    	$objPHPExcel->getActiveSheet()->getStyle('E'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startTechName, 'Amount');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getStyle('F'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startTechName, 'Billing Frequency');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startTechName, 'Address');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getStyle('H'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$startTechName, 'City');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getStyle('I'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$startTechName, 'State');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getStyle('J'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$startTechName, 'Zip Code');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getStyle('K'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$startTechName, 'Phone Number');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getStyle('L'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$startTechName, 'Email');
    	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
    	$objPHPExcel->getActiveSheet()->getStyle('M'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	
    	
    	$objPHPExcel->getActiveSheet()->getStyle('J'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


    	$objPHPExcel->getActiveSheet()->getStyle('A'.$startTechName.':M'.$startTechName)->getFont()->setBold(true);

    	 
    	foreach($report as $details){


    		$j = $j+1;//echo $j.'sub';
    		$startTechName = $startIndex + $j;
    		 
    		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('0.00');
    		    		 
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startTechName,$details['customer_name']);
    		$objPHPExcel->getActiveSheet()->getStyle('A'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startTechName,$details['agreementName']);
    		$objPHPExcel->getActiveSheet()->getStyle('B'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startTechName, date(Yii::app()->session['dateFormat'],strtotime($details['date_effective'])));
    		$objPHPExcel->getActiveSheet()->getStyle('C'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		$expirationDate = ($details['date_expires'] && $details['date_expires'] !='0000-00-00 00:00:00')?date(Yii::app()->session['dateFormat'],strtotime($details['date_expires'])):"";
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startTechName, $expirationDate);
    		$objPHPExcel->getActiveSheet()->getStyle('D'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		 
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startTechName,$details['description']);
    		$objPHPExcel->getActiveSheet()->getStyle('E'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startTechName, number_format(isset($details['amount'])?$details['amount']:0,2));
    		$objPHPExcel->getActiveSheet()->getStyle('F'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startTechName, $details['per_what']);
    		$objPHPExcel->getActiveSheet()->getStyle('G'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		 
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startTechName, $details['Address']);
    		$objPHPExcel->getActiveSheet()->getStyle('H'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$startTechName, $details['City']);
    		$objPHPExcel->getActiveSheet()->getStyle('I'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		 
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$startTechName, $details['State']);
    		$objPHPExcel->getActiveSheet()->getStyle('J'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		 
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$startTechName, $details['PostalCode']);
    		$objPHPExcel->getActiveSheet()->getStyle('K'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		 
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$startTechName, $details['PhoneNumber']);
    		$objPHPExcel->getActiveSheet()->getStyle('L'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$startTechName, $details['Email']);
    		$objPHPExcel->getActiveSheet()->getStyle('M'.$startTechName)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		 
    	}
    	
		$objPHPExcel->setActiveSheetIndex(0);
    	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    	
    	
    	$objWriter->save(Yii::app()->basePath.'/../estimates/report.xlsx');
    	
    	$file_path =Yii::app()->basePath.'/../estimates/report.xlsx';
    	$data = file_get_contents($file_path); // Read the file's contents
    	$name="ServiceAgreementReport_".$from.".xlsx";
    	if(Yii::app()->getRequest()->sendFile($name,$data)){
    			unlink($file_path);
    	}
	}
	/**
	 * Function to generate expense report
	 * @param string $from
	 * @param string $type
	 * @param unknown $queryStringDate
	 * @param unknown $queryStringTech
	 * @return Ambigous <multitype:, mixed>
	 */
	public function getExpensesReport($from='',$type='',$queryString,$queryStringTech,$techQueryPart)
	{
		$reports=array();
		$companyId =addslashes(Yii::app()->session['companyId']);
						
		$report = Yii::app()->db->createCommand()
		->select("jex.id, jex.ubase_user_id, jex.expense_date, jex.amount, jex.is_billable, jex.ubase_expense_category_id,jex.purchased_from, jea.attached_file_name, jea.actual_file_name, uec.category_name,uj.id as job_id,uj.job_number,jex.ubase_user_id as tech_id,concat(uu.first_name,' ',uu.last_name) as tech_name,uj.public_notes,uj.job_po_number,uc.customer_name,uj.job_start_date as date")
		->from('ubase_job_expenses jex')
		->join('ubase_expense_categories uec','uec.id = jex.ubase_expense_category_id')
		->leftjoin('ubase_job_expense_attachments jea','jea.ubase_job_expense_id = jex.id')
		->join('ubase_jobs uj','jex.ubase_job_id=uj.id')
		->join('ubase_users uu','jex.ubase_user_id = uu.id')
		->join('master_statuses ms','uj.master_status_id = ms.id')
		->join('master_status_categories msc','ms.master_status_category_id=msc.id')
		->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
		->where("uj.ubase_company_id=$companyId  $queryString")
		->order("tech_name desc")
		->queryAll();
		$userIdArray = array();
		/*
		foreach ($report as $index=>$row){
			$userIdArray[]=$row['ubase_user_id'];
		}
		foreach ($report as $index=>$row){
			$report[$index]['users']=$userIdArray;			
		}
		*/
		foreach ($report as $index=>$row){//for selecting job assigned workers
			$jobId=$row['job_id'];
			$jobAssignedWorkers = Yii::app()->db->createCommand()
			->select("jex.ubase_user_id  as user_id")
			->from('ubase_job_expenses jex')
			->where("jex.ubase_job_id=$jobId $techQueryPart")
			->queryColumn();
			//$report[$index]['users']=implode(',',$jobAssignedWorkers);
			$jobAssignedWorkers = array_unique($jobAssignedWorkers);
			$report[$index]['users']=$jobAssignedWorkers;
			if($techQueryPart!='' && empty($jobAssignedWorkers)){
				unset($report[$index]);
			}
		}
		
		foreach ($report as $data){
			if(!empty($data['users'])){
				foreach ($data['users'] as $userId){
					if($userId==$data['ubase_user_id']){
					$reports[$userId][]=$data;
					$reports[$userId]['name']=Helper::getUsernameFromUserId($userId);
					$reports[$userId]['userIdKey']=$userId;
					}
				}
			}
		}
		usort($reports, array("Helper", "cmp"));
		//unset($customerJobs);
		//print_r($reports);die;
		return $reports;
	}
	public function getExpenseCategories($companyId)
	{
		$categ = array();
		$categ = Yii::app()->db->createCommand()
		->select("id, category_name")
		->from('ubase_expense_categories')
		->where("ubase_company_id=$companyId  and is_active=1")
		->queryAll();
		return $categ;
	}
	public function salesProductServices($from='',$type='',$queryParts='',$servicePart='',$productPart='')
	{		
		$serviceFilter = $productFilter = 1;
		if($servicePart=='NONE'){
			$serviceFilter = 0;
			$servicePart = "";
		}	
		if($productPart=='NONE'){
			$productFilter = 0;
			$productPart = "";
		}
		$companyId =addslashes(Yii::app()->session['companyId']);
		$servReports = $prodReports = $reportFinal = array();
		$jobServiceIds = $jobProductIds = $jobCountArray = array();
		if ($serviceFilter)	{
			
			$serviceReport = Yii::app()->db->createCommand()
			->select("uj.id as job_id,uj.job_start_date as date,uc.customer_name,serv.short_description,serv.id as serviceId,ujsr.*")
			->from("master_services serv")
			->join('ubase_job_service_lists ujsl','ujsl.master_service_id=serv.id')
			->join('ubase_job_service_rates ujsr','ujsr.ubase_job_service_list_id = ujsl.id')
			->join('ubase_jobs uj','ujsr.ubase_job_id=uj.id')
			->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
			->join('master_statuses ms','uj.master_status_id = ms.id')
			->join('master_status_categories msc','ms.master_status_category_id=msc.id')
			->where(" $sub msc.code != 'ESTIMATE' and ujsl.ubase_company_id=$companyId and uj.ubase_company_id=$companyId $servicePart $queryParts")
			->queryAll();
			// ->getText();die;
			
			

		
		
			foreach ($serviceReport as $index=>$row){//
				$jobId=$row['job_id'];
				$jobServiceIds[] = $row['serviceId'];
				$jobServiceIdUniqueArray = array_unique($jobServiceIds);
				$serviceReport[$index]['serviceids']=$jobServiceIdUniqueArray;
				if($servicePart!='' && empty($jobServiceIdUniqueArray)){
					unset($serviceReport[$index]);
				}
			}
			
			foreach ($serviceReport as $data){
				if(!empty($data['serviceids'])){
					foreach ($data['serviceids'] as $serviceId){
						if($serviceId==$data['serviceId']){
							$servReports[$serviceId][]=$data;
							$servReports[$serviceId]['name']=$data['short_description'];
							$servReports[$serviceId]['servProdIdKey']=$serviceId;
						}
					}
				}
			}
			usort($servReports, array("Helper", "cmp"));		
		}	
		/*
		$report1=array();
	
		foreach ($serviceReport as $data){			
			$report1[$data['serviceId']]['jobId']=$data['job_id'];
			$report1[$data['serviceId']]['date']=$data['date'];
			$report1[$data['serviceId']]['customerName']=$data['customer_name'];
			$report1[$data['serviceId']]['name']=$data['short_description'];
			$report1[$data['serviceId']]['qty']=$data['multiplier'];
			$report1[$data['serviceId']]['rate']=$data['rate'];
			$report1[$data['serviceId']]['total']=$data['total'];
		}
		*/
		if ($productFilter) {
					$productReport = Yii::app()->db->createCommand()
					->select("uj.id as job_id,uj.job_start_date as date,uc.customer_name,up.make as short_description,up.id as productId,ujpr.*")
					->from("ubase_products up")
					->join('ubase_job_product_lists ujpl','ujpl.ubase_product_id=up.id')
					->join('ubase_job_product_rates ujpr','ujpr.ubase_job_product_list_id = ujpl.id')
					->join('ubase_jobs uj','ujpr.ubase_job_id=uj.id')
					->join('ubase_customers uc','uj.ubase_customer_id = uc.id')
					->join('master_statuses ms','uj.master_status_id = ms.id')
					->join('master_status_categories msc','ms.master_status_category_id=msc.id')
					->where(" $sub msc.code != 'ESTIMATE' and ujpl.ubase_company_id=$companyId and uj.ubase_company_id=$companyId $productPart $queryParts")
					->queryAll();
					// ->getText();die;
					foreach ($productReport as $index=>$row){//
						$jobId=$row['job_id'];
						$jobProductIds[] = $row['productId'];
						$jobProductIdUniqueArray = array_unique($jobProductIds);
						$productReport[$index]['productids']=$jobProductIdUniqueArray;
						if($productPart!='' && empty($jobProductIdUniqueArray)){
							unset($productReport[$index]);
						}
					}
					
					foreach ($productReport as $data){
						if(!empty($data['productids'])){
							foreach ($data['productids'] as $productId){
								if($productId==$data['productId']){
									$prodReports[$productId][]=$data;
									$prodReports[$productId]['name']=$data['short_description'];
									$prodReports[$productId]['servProdIdKey']=$productId;
								}
							}
						}
					}
					usort($prodReports, array("Helper", "cmp"));
		}
		//print_r($prodReports);die;
		/*
		$report2=array();
		
		foreach ($productReport as $data){
			$report2[$data['productId']]['jobId']=$data['job_id'];
			$report2[$data['productId']]['date']=$data['date'];
			$report2[$data['productId']]['customerName']=$data['customer_name'];
			$report2[$data['productId']]['name']=$data['short_description'];
			$report2[$data['productId']]['qty']=$data['multiplier'];
			$report2[$data['productId']]['rate']=$data['rate'];
			$report2[$data['productId']]['total']=$data['total'];
		}
			*/
	         //$reportFinal = array_merge($servReports,$prodReports);
	         $reportFinal = array_merge($prodReports,$servReports);
	         return $reportFinal;
		}
}
?>
