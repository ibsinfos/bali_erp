<?php
class Default_Plugin_AccessControl extends Zend_Controller_Plugin_Abstract
{
  private $_acl,$id_param;
          
  public function preDispatch(Zend_Controller_Request_Abstract $request)
  {
	$storage = new Zend_Auth_Storage_Session();
	$data = $storage->read();
	$role = $data['emprole'];
	if($role == 1)
		$role = 'admin';
	else if($role == 2)
	 $role = 'management';
//	else if($role == 3)
//	 $role = 'manager';
	else if($role == 10)
	 $role = 'Teacher';
	else if($role == 12)
	 $role = 'External';
	else if($role == 13)
	 $role = 'agencies';
	else if($role == 15)
	 $role = 'CLW';
	else if($role == 17)
	 $role = 'PEON';
	else if($role == 18)
	 $role = 'Gardener';
	else if($role == 19)
	 $role = 'managers';
	
  	$request->getModuleName();
        $request->getControllerName();
        $request->getActionName();
    	
        
        $module = $request->getModuleName();
	$resource = $request->getControllerName();
	$privilege = $request->getActionName();
	$this->id_param = $request->getParam('id');
	$allowed = false;
        $acl = $this->_getAcl();
	$moduleResource = "$module:$resource";
	
	if($resource == 'profile')
            $role = 'viewer';
		
	if($resource == 'services')
            $role = 'services';
		
	if($role != '') 
        {
            if ($acl->has($moduleResource)) 
            {						
                $allowed = $acl->isAllowed($role, $moduleResource, $privilege);	
			    	 
            }	 
            if (!$allowed)//  && $role !='admin') 
            {				
                $request->setControllerName('error');
	        $request->setActionName('error');
            }
	}
  }
  
protected function _getAcl()
{
    if ($this->_acl == null ) 
    {
	   $acl = new Zend_Acl();

	   $acl->addRole('admin');            
	   $acl->addRole('viewer');            
	   
	 $acl->addRole('management');
	 //$acl->addRole('manager');
	 $acl->addRole('Teacher');
	 $acl->addRole('External');
	 $acl->addRole('agencies');
	 $acl->addRole('CLW');
	 $acl->addRole('PEON');
	 $acl->addRole('Gardener');
	 $acl->addRole('managers');
	   $storage = new Zend_Auth_Storage_Session();
	   $data = $storage->read();
	   $role = $data['emprole'];
		
	$auth = Zend_Auth::getInstance(); 
	$tmroleText=array();
	$tmroleText = array('1'=>'admin','2'=>'management','10'=>'Teacher','12'=>'External','13'=>'agencies','15'=>'CLW','17'=>'PEON','18'=>'Gardener','19'=>'managers');
	
		if($auth->hasIdentity())
		{
			$tm_role = Zend_Registry::get('tm_role');
			$timeManagementRole = new Zend_Session_Namespace('tm_role');
			if(empty($timeManagementRole->tmrole))
			{
				$tm_role = $timeManagementRole->tmrole;
			}				
		}
                if($role == 1) { $tm_role = 'Admin'; }
               //=echo $tm_role; echo $role;die; 
			if(!empty($tm_role) && $tm_role == 'Admin') { 
	if(!isset($role))
								$tmroleText[$role] = 'admin';
		 $acl->addResource(new Zend_Acl_Resource('timemanagement:index'));
									$acl->allow($tmroleText[$role], 'timemanagement:index', array('index','week','edit','view','getstates','converdate'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:reports'));
									$acl->allow($tmroleText[$role], 'timemanagement:reports', array('index','employeereports','projectsreports','getempduration','getprojecttaskduration','tmreport'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:clients'));
									$acl->allow($tmroleText[$role], 'timemanagement:clients', array('index','edit','view','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:configuration'));
									$acl->allow($tmroleText[$role], 'timemanagement:configuration', array('index','add'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:currency'));
									$acl->allow($tmroleText[$role], 'timemanagement:currency', array('index'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:defaulttasks'));
									$acl->allow($tmroleText[$role], 'timemanagement:defaulttasks', array('index','edit','view','delete','checkduptask'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:emptimesheets'));
									$acl->allow($tmroleText[$role], 'timemanagement:emptimesheets', array('index','displayweeks','getmonthlyspan','accordion','employeetimesheet','empdisplayweeks','emptimesheetmonthly','emptimesheetweekly','enabletimesheet','approvetimesheet','rejecttimesheet','approvedaytimesheet','rejectdaytimesheet','getweekstartenddates'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:expenses'));
									$acl->allow($tmroleText[$role], 'timemanagement:expenses', array('index','edit','view','delete','download','uploadpreview','getprojectbyclientid','getfilename','submitexpense','expensereports','viewexpenses','viewexpensereports','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:expensecategory'));
									$acl->allow($tmroleText[$role], 'timemanagement:expensecategory', array('index','edit','view','delete'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:projectresources'));
									$acl->allow($tmroleText[$role], 'timemanagement:projectresources', array('index','resources','view','addresourcesproject','viewemptasks','addresources','deleteprojectresource','assigntasktoresources','taskassign','resourcetaskdelete','resourcetaskassigndelete'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:projects'));
									$acl->allow($tmroleText[$role], 'timemanagement:projects', array('index','edit','view','add','tasks','addtasksproject','addtasks','delete','checkempforprojects'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:projecttasks'));
									$acl->allow($tmroleText[$role], 'timemanagement:projecttasks', array('index','viewtasksresources','deletetask','assignresourcestotask','saveresources','edittaskname'));
 } 
 elseif(!empty($tm_role) && $tm_role == 'Manager') { 
		 $acl->addResource(new Zend_Acl_Resource('timemanagement:index'));
									$acl->allow($tmroleText[$role], 'timemanagement:index', array('index','week','save','submit','eraseweek','getstates','getapprovedtimesheet','closeapprovealert','converdate'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:notifications'));
									$acl->allow($tmroleText[$role], 'timemanagement:notifications', array('pendingsubmissions','pendingsubmissionsweeklyview','weeklymonthlyview'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:clients'));
									$acl->allow($tmroleText[$role], 'timemanagement:clients', array('index','edit','view','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:defaulttasks'));
									$acl->allow($tmroleText[$role], 'timemanagement:defaulttasks', array('index','edit','view','delete','checkduptask'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:projects'));
									$acl->allow($tmroleText[$role], 'timemanagement:projects', array('index','edit','view','add','tasks','addtasksproject','addtasks','delete','checkempforprojects'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:projectresources'));
									$acl->allow($tmroleText[$role], 'timemanagement:projectresources', array('index','resources','view','addresourcesproject','viewemptasks','addresources','deleteprojectresource','assigntasktoresources','taskassign','resourcetaskdelete','resourcetaskassigndelete'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:projecttasks'));
									$acl->allow($tmroleText[$role], 'timemanagement:projecttasks', array('index','viewtasksresources','deletetask','assignresourcestotask','saveresources','edittaskname'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:reports'));
									$acl->allow($tmroleText[$role], 'timemanagement:reports', array('index','employeereports','projectsreports','getempduration','getprojecttaskduration','tmreport'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:emptimesheets'));
									$acl->allow($tmroleText[$role], 'timemanagement:emptimesheets', array('index','displayweeks','getmonthlyspan','accordion','employeetimesheet','empdisplayweeks','emptimesheetmonthly','emptimesheetweekly','enabletimesheet','approvetimesheet','rejecttimesheet','approvedaytimesheet','rejectdaytimesheet','getweekstartenddates'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:expenses'));
									$acl->allow($tmroleText[$role], 'timemanagement:expenses', array('index','edit','view','delete','download','uploadpreview','getprojectbyclientid','getfilename','submitexpense','expensereports','viewexpenses','viewexpensereports','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus'));
 } 
 elseif(!empty($tm_role) && $tm_role == 'Employee') { 
                $acl->addResource(new Zend_Acl_Resource('default:requisition'));
                    $acl->allow($tmroleText[$role], 'default:requisition', array('index','add','edit','viewhr','approverequisition','addcandidate','interview','getdepartments','getpositions','viewpopup','view','delete','getapprreqdata','chkreqforclose','getempreportingmanagers','getemailcount','getapprovers','approverejectrequisition','addpopup'));
                    
		 $acl->addResource(new Zend_Acl_Resource('timemanagement:index'));
									$acl->allow($tmroleText[$role], 'timemanagement:index', array('index','week','save','submit','eraseweek','getstates','getapprovedtimesheet','closeapprovealert','converdate'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:employeeprojects'));
									$acl->allow($tmroleText[$role], 'timemanagement:employeeprojects', array('index','view','emptasksgrid'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:notifications'));
									$acl->allow($tmroleText[$role], 'timemanagement:notifications', array('getnotifications','index'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:expenses'));
									$acl->allow($tmroleText[$role], 'timemanagement:expenses', array('index','edit','view','delete','download','uploadpreview','getprojectbyclientid','getfilename','submitexpense','expensereports','viewexpenses','viewexpensereports','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus','updateexpensestatus'));

		 $acl->addResource(new Zend_Acl_Resource('timemanagement:reports'));
									$acl->allow($tmroleText[$role], 'timemanagement:reports', array('index','employeereports','projectsreports','getempduration','getprojecttaskduration','tmreport'));
 } 
		
	   $acl->addResource(new Zend_Acl_Resource('login:index'));	
	   $acl->allow('viewer', 'login:index', array('index','confirmlink','forgotpassword','forgotsuccess','login','pass','browserfailure','forcelogout','useractivation'));

	   if($role == 1 ) 
	   {				 		    	
		
		 $acl->addResource(new Zend_Acl_Resource('default:accountclasstype'));
                    $acl->allow('admin', 'default:accountclasstype', array('index','view','edit','addpopup','saveupdate','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:addemployeeleaves'));
                    $acl->allow('admin', 'default:addemployeeleaves', array('index','add','edit','view'));
                    
                 $acl->addResource(new Zend_Acl_Resource('default:agencylist'));
                    $acl->allow('admin', 'default:agencylist', array('index','add','view','edit','delete','deletepoc'));
                    
                 $acl->addResource(new Zend_Acl_Resource('default:appraisalinit'));
                    $acl->allow('admin', 'default:appraisalinit', array('checkappadmin','getdepartmentsadmin','discardsteptwo','displayline','addlinemanager','displayreport','deletelinemanager','deletereportmanager','constructreportacc','constructacc','displayemployees','displaycontentreportacc','displaycontentacc','viewconfmanagers','confmanagers','displaymanagers','displayreportmanagers','getperiod','index','add','delete','view','edit','viewassigngroups','assigngroups','displaygroupedemployees','showgroupedemployees','viewgroupedemployees','savegroupedemployeesajax','changesettings','displaysettings','deletegroupedemployees','initializegroup','completeappraisal','checkemployeeresponse','getemployeeslinemanagers','savemngrorghierarchy','getconfiglinemanagers','validateconfig'));   
                    
                    $acl->addResource(new Zend_Acl_Resource('default:appraisalmanager'));
                    $acl->allow('admin', 'default:appraisalmanager', array('submitmanager','deletemanagergroup','savemanagergroup','index','viewgroup','createnewgroup','showgroups','showviewgroups','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:appraisalquestions'));
                    $acl->allow('admin', 'default:appraisalquestions', array('index','addpopup','add','view','edit','delete','savequestionpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:appraisalratings'));
                    $acl->allow('admin', 'default:appraisalratings', array('index','addratings','add','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:appraisalself'));
                    $acl->allow('admin', 'default:appraisalself', array('index','edit','save'));

		 $acl->addResource(new Zend_Acl_Resource('default:appraisalskills'));
                    $acl->allow('admin', 'default:appraisalskills', array('index','add','view','edit','delete','getappraisalskills','saveskillspopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:appraisalstatus'));
                    $acl->allow('admin', 'default:appraisalstatus', array('index','manager','managerstatus','checkappraisalimplementation','employee','employeestatus','employeeActi','addlinemanager','displaymanagers','updatelinemanager'));
                    
		 $acl->addResource(new Zend_Acl_Resource('default:announcements'));
                    $acl->allow('admin', 'default:announcements', array('index','add','view','edit','getdepts','delete','uploadsave','uploaddelete'));

		 $acl->addResource(new Zend_Acl_Resource('default:attendancestatuscode'));
                    $acl->allow('admin', 'default:attendancestatuscode', array('index','view','edit','delete'));
                
                 $acl->addResource(new Zend_Acl_Resource('default:approvedrequisitions'));
                    $acl->allow('admin', 'default:approvedrequisitions', array('index','view','edit'));   
                    
		 $acl->addResource(new Zend_Acl_Resource('default:bankaccounttype'));
                    $acl->allow('admin', 'default:bankaccounttype', array('index','view','edit','addpopup','delete'));
                    
                 $acl->addResource(new Zend_Acl_Resource('default:bgscreeningtype'));
                    $acl->allow('admin', 'default:bgscreeningtype', array('index','view','edit','add','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:businessunits'));
                    $acl->allow('admin', 'default:businessunits', array('index','edit','view','delete','getdeptnames'));
                    
                 $acl->addResource(new Zend_Acl_Resource('default:candidatedetails'));
                    $acl->allow('admin', 'default:candidatedetails', array('index','view','edit','addpopup','add','delete','chkcandidate','uploadfile','deleteresume','download','multipleresume','getvendors','viewpopup'));   
                    
		 $acl->addResource(new Zend_Acl_Resource('default:categories'));
                    $acl->allow('admin', 'default:categories', array('index','add','edit','view','delete','addnewcategory'));

		 $acl->addResource(new Zend_Acl_Resource('default:cities'));
                    $acl->allow('admin', 'default:cities', array('index','view','edit','delete','getcitiescand','addpopup','addnewcity'));

		 $acl->addResource(new Zend_Acl_Resource('default:clients'));
                    $acl->allow('admin', 'default:clients', array('index','edit','view','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:competencylevel'));
                    $acl->allow('admin', 'default:competencylevel', array('index','view','edit','addpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:countries'));
                    $acl->allow('admin', 'default:countries', array('index','view','edit','saveupdate','delete','getcountrycode','addpopup','addnewcountry'));

		 $acl->addResource(new Zend_Acl_Resource('default:currency'));
                    $acl->allow('admin', 'default:currency', array('index','view','edit','addpopup','delete','gettargetcurrency'));

		 $acl->addResource(new Zend_Acl_Resource('default:currencyconverter'));
                    $acl->allow('admin', 'default:currencyconverter', array('index','add','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:dashboard'));
                    $acl->allow('admin', 'default:dashboard', array('index','saveuserdashboard','getwidgtes','upgradeapplication','emailsettings','changepassword','editpassword','update','uploadpreview','viewprofile','viewsettings','savemenuwidgets','getmenuname','fetchmenuname','getnavids','getopeningpositondate','menuwork','employeeimageupdate'));

		 $acl->addResource(new Zend_Acl_Resource('default:departments'));
                    $acl->allow('admin', 'default:departments', array('index','view','viewpopup','edit','editpopup','getdepartments','delete','getempnames'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryallincidents'));
                    $acl->allow('admin', 'default:disciplinaryallincidents', array('index','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryincident'));
                    $acl->allow('admin', 'default:disciplinaryincident', array('index','view','edit','add','getemployees','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinarymyincidents'));
                    $acl->allow('admin', 'default:disciplinarymyincidents', array('index','view','edit','saveemployeeappeal','getdisciplinaryincidentpdf'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryteamincidents'));
                    $acl->allow('admin', 'default:disciplinaryteamincidents', array('index','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryviolation'));
                    $acl->allow('admin', 'default:disciplinaryviolation', array('index','add','view','edit','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationlevelcode'));
                    $acl->allow('admin', 'default:educationlevelcode', array('index','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:eeoccategory'));
                    $acl->allow('admin', 'default:eeoccategory', array('index','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:emailcontacts'));
                    $acl->allow('admin', 'default:emailcontacts', array('index','add','edit','getgroupoptions','view','delete','getmailcnt'));

		 $acl->addResource(new Zend_Acl_Resource('default:empconfiguration'));
                    $acl->allow('admin', 'default:empconfiguration', array('index','edit','add'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleavesummary'));
                    $acl->allow('admin', 'default:empleavesummary', array('index','statusid','view','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:employee'));
                    $acl->allow('admin', 'default:employee', array('getemprequi','index','changeorghead','add','edit','view','getdepartments','getpositions','delete','getempreportingmanagers','makeactiveinactive','changereportingmanager','addemppopup','uploadexcel','getindividualempdetails'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeeleavetypes'));
                    $acl->allow('admin', 'default:employeeleavetypes', array('index','view','edit','delete'));
                    
		 $acl->addResource(new Zend_Acl_Resource('default:employmentstatus'));
                    $acl->allow('admin', 'default:employmentstatus', array('index','view','edit','delete','addpopup'));
                 
                 $acl->addResource(new Zend_Acl_Resource('default:empscreening'));
                    $acl->allow('admin', 'default:empscreening', array('index','add','edit','view','getemployeedata','getagencylist','getpocdata','forcedfullupdate','delete','checkscreeningstatus','uploadfeedback','download','deletefeedback'));   
                    
		 $acl->addResource(new Zend_Acl_Resource('default:ethniccode'));
                    $acl->allow('admin', 'default:ethniccode', array('index','view','edit','saveupdate','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:gender'));
                    $acl->allow('admin', 'default:gender', array('index','view','edit','saveupdate','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:geographygroup'));
                    $acl->allow('admin', 'default:geographygroup', array('index','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:heirarchy'));
                    $acl->allow('admin', 'default:heirarchy', array('index','edit','addlist','editlist','saveadddata','saveeditdata','deletelist'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaydates'));
                    $acl->allow('admin', 'default:holidaydates', array('index','add','addpopup','view','viewpopup','edit','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaygroups'));
                    $acl->allow('admin', 'default:holidaygroups', array('index','add','view','edit','delete','getempnames','getholidaynames','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:identitycodes'));
                    $acl->allow('admin', 'default:identitycodes', array('index','add','addpopup','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:identitydocuments'));
                    $acl->allow('admin', 'default:identitydocuments', array('index','add','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:index'));
                    $acl->allow('admin', 'default:index', array('index','loginpopupsave','logout','clearsessionarray','forcelogout','browserfailure','sendpassword','updatecontactnumber','getstates','getstatesnormal','getcities','getcitiesnormal','getdepartments','getpositions','gettargetcurrency','calculatedays','calculatebusinessdays','calculatecalendardays','fromdatetodate','fromdatetodateorg','validateorgheadjoiningdate','medicalclaimdates','gettimeformat','chkcurrenttime','popup','createorremoveshortcut','sessiontour','getissuingauthority','setsessionval','checkisactivestatus','updatetheme','welcome','getmultidepts','getmultiemps'));

		 $acl->addResource(new Zend_Acl_Resource('default:jobtitles'));
                    $acl->allow('admin', 'default:jobtitles', array('index','view','edit','addpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:language'));
                    $acl->allow('admin', 'default:language', array('index','view','edit','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:leavemanagement'));
                    $acl->allow('admin', 'default:leavemanagement', array('index','add','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:leaverequest'));
                    $acl->allow('admin', 'default:leaverequest', array('index','saveleaverequestdetails','gethalfdaydetails','editpopup','updateleavedetails'));

		 $acl->addResource(new Zend_Acl_Resource('default:licensetype'));
                    $acl->allow('admin', 'default:licensetype', array('index','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:managemenus'));
                    $acl->allow('admin', 'default:managemenus', array('index','save'));

		 $acl->addResource(new Zend_Acl_Resource('default:manageremployeevacations'));
                    $acl->allow('admin', 'default:manageremployeevacations', array('index','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:maritalstatus'));
                    $acl->allow('admin', 'default:maritalstatus', array('index','view','edit','saveupdate','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:militaryservice'));
                    $acl->allow('admin', 'default:militaryservice', array('index','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:mydetails'));
                    $acl->allow('admin', 'default:mydetails', array('index','personaldetailsview','personal','communicationdetailsview','communication','skills','education','experience','leaves','holidays','salarydetailsview','certification','creditcarddetailsview','creditcard','visadetailsview','visa','medicalclaims','disabilitydetailsview','disability','dependency','workeligibilitydetailsview','workeligibility','additionaldetailsedit','jobhistory','delete','documents','assetdetailsview','emppayslip'));

		 $acl->addResource(new Zend_Acl_Resource('default:myemployees'));
                    $acl->allow('admin', 'default:myemployees', array('index','view','perview','comview','skillsview','expview','eduview','trainingview','additionaldetailsview','jobhistoryview','add','edit','skillsedit','jobhistoryedit','expedit','eduedit','trainingedit','additionaldetailsedit','peredit','comedit','docview','docedit','employeereport','getempreportdata','empauto','emprptpdf','exportemployeereport','downloadreport'));

		 $acl->addResource(new Zend_Acl_Resource('default:myholidaycalendar'));
                    $acl->allow('admin', 'default:myholidaycalendar', array('index','view','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:nationality'));
                    $acl->allow('admin', 'default:nationality', array('index','view','edit','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:nationalitycontextcode'));
                    $acl->allow('admin', 'default:nationalitycontextcode', array('index','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:numberformats'));
                    $acl->allow('admin', 'default:numberformats', array('index','add','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:organisationinfo'));
                    $acl->allow('admin', 'default:organisationinfo', array('index','edit','edit_old','saveupdate','uploadpreview','validateorgstartdate','getcompleteorgdata','addorghead'));

		 $acl->addResource(new Zend_Acl_Resource('default:payfrequency'));
                    $acl->allow('admin', 'default:payfrequency', array('index','addpopup','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollcategory'));
                    $acl->allow('admin', 'default:payrollcategory', array('index','add','addpopup','editpopup','editcategoryforemppopup','deleteempcategory','validate','delete','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollgroup'));
                    $acl->allow('admin', 'default:payrollgroup', array('index','add','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipemployee'));
                    $acl->allow('admin', 'default:payslipemployee', array('index','generate','generatebulk'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipgroup'));
                    $acl->allow('admin', 'default:payslipgroup', array('index','add','generate'));
                 
                 $acl->addResource(new Zend_Acl_Resource('default:payslipreport'));
                    $acl->allow('admin', 'default:payslipreport', array('index','filter'));
                    
		 $acl->addResource(new Zend_Acl_Resource('default:pendingleaves'));
                    $acl->allow('admin', 'default:pendingleaves', array('index','view','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:policydocuments'));
                    $acl->allow('admin', 'default:policydocuments', array('index','add','edit','view','delete','uploaddoc','deletedocument','addmultiple','uploadmultipledocs'));

		 $acl->addResource(new Zend_Acl_Resource('default:positions'));
                    $acl->allow('admin', 'default:positions', array('index','add','view','edit','addpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:prefix'));
                    $acl->allow('admin', 'default:prefix', array('index','view','edit','saveupdate','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:projects'));
                    $acl->allow('admin', 'default:projects', array('index','view','delete','viewpopup','editpopup','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:racecode'));
                    $acl->allow('admin', 'default:racecode', array('index','view','edit','saveupdate','delete','addpopup'));
                 
                 $acl->addResource(new Zend_Acl_Resource('default:rejectedrequisitions'));
                    $acl->allow('admin', 'default:rejectedrequisitions', array('index','view'));   
                    
		 $acl->addResource(new Zend_Acl_Resource('default:remunerationbasis'));
                    $acl->allow('admin', 'default:remunerationbasis', array('index','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:reports'));
                    $acl->allow('admin', 'default:reports', array('getrolepopup','emprolesgrouppopup','performancereport','previousappraisals','getselectedappraisaldata','getinterviewroundsdata','interviewrounds','rolesgroup','exportemprolesgroup','exportrolesgroupreport','exportinterviewrpt','exportactiveuserrpt','exportemployeereport','rolesgrouprptpdf','activeuserrptpdf','emprptpdf','interviewrptpdf','rolesgroupdata','emprolesgroup','emprolesgroupdata','activeuser','getactiveuserdata','getempreportdata','empauto','servicedeskreport','getsddata','servicedeskpdf','servicedeskexcel','employeereport','getdeptsemp','index','holidaygroupreports','getpdfreportholiday','getexcelreportholiday','leavesreport','getpdfreportleaves','getexcelreportleaves','leavesreporttabheader','leavemanagementreport','getpdfreportleavemanagement','getexcelreportleavemanagement','bunitauto','bunitcodeauto','getexcelreportbusinessunit','getbusinessunitspdf','businessunits','userlogreport','departments','exportdepartmentpdf','getexcelreportdepartment','candidaterptexcel','candidaterptpdf','getcandidatesreportdata','candidatesreport','requisitionauto','requisitionrptexcel','requisitionrptpdf','getrequisitionsstatusreportdata','requisitionstatusreport','activitylogreport','downloadreport','agencylistreport','agencynameauto','agencysebsiteauto','empscreening','getspecimennames','getagencynames','getexcelreportempscreening','getempscreeningpdf'));
                
                 $acl->addResource(new Zend_Acl_Resource('default:requisition'));
                    $acl->allow('admin', 'default:requisition', array('index','add','edit','viewhr','approverequisition','addcandidate','interview','getdepartments','getpositions','viewpopup','view','delete','getapprreqdata','chkreqforclose','getempreportingmanagers','getemailcount','getapprovers','approverejectrequisition','addpopup'));
                 
                 $acl->addResource(new Zend_Acl_Resource('default:scheduleinterviews'));
                    $acl->allow('admin', 'default:scheduleinterviews', array('candidatepopup','index','view','add','downloadresume','edit','getcandidates','delete'));
                    
		 $acl->addResource(new Zend_Acl_Resource('default:roles'));
                    $acl->allow('admin', 'default:roles', array('index','view','edit','saveupdate','delete','getgroupmenu'));

		 $acl->addResource(new Zend_Acl_Resource('default:sitepreference'));
                    $acl->allow('admin', 'default:sitepreference', array('index','add','view','edit','delete'));
                    
                 $acl->addResource(new Zend_Acl_Resource('default:shortlistedcandidates'));
                    $acl->allow('admin', 'default:shortlistedcandidates', array('index','edit','view','add','delete'));   
                    
		 $acl->addResource(new Zend_Acl_Resource('default:states'));
                    $acl->allow('admin', 'default:states', array('index','view','edit','delete','getstates','getstatescand','addpopup','addnewstate'));

		 $acl->addResource(new Zend_Acl_Resource('default:structure'));
                    $acl->allow('admin', 'default:structure', array('index'));

		 $acl->addResource(new Zend_Acl_Resource('default:timezone'));
                    $acl->allow('admin', 'default:timezone', array('index','view','edit','saveupdate','delete','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:usermanagement'));
                    $acl->allow('admin', 'default:usermanagement', array('index','view','edit','saveupdate','delete','getemailofuser'));

		 $acl->addResource(new Zend_Acl_Resource('default:vendors'));
                    $acl->allow('admin', 'default:vendors', array('index','view','delete','edit','addpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:veteranstatus'));
                    $acl->allow('admin', 'default:veteranstatus', array('index','view','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:wizard'));
                    $acl->allow('admin', 'default:wizard', array('index','managemenu','savemenu','configuresite','configureorganisation','updatewizardcompletion','configureunitsanddepartments','savebusinessunit','configureservicerequest','savecategory'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydoctypes'));
                    $acl->allow('admin', 'default:workeligibilitydoctypes', array('index','view','edit','addpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('assets:assetcategories'));
                    $acl->allow('admin', 'assets:assetcategories', array('index','edit','view','delete','addpopup','addsubcatpopup','assetuserlog'));

		 $acl->addResource(new Zend_Acl_Resource('assets:assets'));
                    $acl->allow('admin', 'assets:assets', array('index','edit','delete','uploadsave','uploaddelete','view','getsubcategories','deleteimage','downloadimage','getemployeesdata'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:advances'));
                    $acl->allow('admin', 'expenses:advances', array('index','getprojects','myadvances','viewmoreadvances','clearadvancesdata','addreturnpopup'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:employeeadvances'));
                    $acl->allow('admin', 'expenses:employeeadvances', array('index','edit','delete','view'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:expensecategories'));
                    $acl->allow('admin', 'expenses:expensecategories', array('index','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:expenses'));
                    $acl->allow('admin', 'expenses:expenses', array('index','edit','clone','view','delete','addpopup','uploadsave','uploaddelete','displayreceipts','addtrippopup','submitexpense','addreceiptimage','expensestatus','listreportingmangers','viewmoremanagers','forwardexpenseto','downloadexpensepdf','bulkexpenses','getcategories','getprojects','getcurrency','uploadedfiles'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:myemployeeexpenses'));
                    $acl->allow('admin', 'expenses:myemployeeexpenses', array('index','view'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:paymentmode'));
                    $acl->allow('admin', 'expenses:paymentmode', array('index','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:receipts'));
                    $acl->allow('admin', 'expenses:receipts', array('index','downloadreceipt','downloadexpensereceipt','deletereceipt','uploadsave','displayreceipts','viewmorereceipts','listexpenses','addreceipttoexpense','viewmoreexpenses','cleardata','showreceiptspopup','listtrips','viewmoretrips','addexpensetotrip'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:trips'));
                    $acl->allow('admin', 'expenses:trips', array('index','edit','view','delete','addpopup','tripstatus','deleteexpense','downloadtrippdf'));

		 $acl->addResource(new Zend_Acl_Resource('default:processes'));
                    $acl->allow('admin', 'default:processes', array('index','addpopup','editpopup','viewpopup','delete','savecomments','displaycomments','savefeedback'));

		 $acl->addResource(new Zend_Acl_Resource('default:interviewrounds'));
                    $acl->allow('admin', 'default:interviewrounds', array('index','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empperformanceappraisal'));
                    $acl->allow('admin', 'default:empperformanceappraisal', array('index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppayslips'));
                    $acl->allow('admin', 'default:emppayslips', array('index','edit','view','printslip','salarydetails'));

		 $acl->addResource(new Zend_Acl_Resource('default:empbenefits'));
                    $acl->allow('admin', 'default:empbenefits', array('index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emprequisitiondetails'));
                    $acl->allow('admin', 'default:emprequisitiondetails', array('index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empremunerationdetails'));
                    $acl->allow('admin', 'default:empremunerationdetails', array('index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsecuritycredentials'));
                    $acl->allow('admin', 'default:empsecuritycredentials', array('index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:apprreqcandidates'));
                    $acl->allow('admin', 'default:apprreqcandidates', array('index','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppersonaldetails'));
                    $acl->allow('admin', 'default:emppersonaldetails', array('index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeedocs'));
                    $acl->allow('admin', 'default:employeedocs', array('index','view','save','delete','edit','update','uploadsave','uploaddelete','downloadfiles'));

		 $acl->addResource(new Zend_Acl_Resource('default:empcommunicationdetails'));
                    $acl->allow('admin', 'default:empcommunicationdetails', array('index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:trainingandcertificationdetails'));
                    $acl->allow('admin', 'default:trainingandcertificationdetails', array('index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:experiencedetails'));
                    $acl->allow('admin', 'default:experiencedetails', array('index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationdetails'));
                    $acl->allow('admin', 'default:educationdetails', array('index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:medicalclaims'));
                    $acl->allow('admin', 'default:medicalclaims', array('index','edit','addpopup','viewpopup','editpopup','delete','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleaves'));
                    $acl->allow('admin', 'default:empleaves', array('index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empskills'));
                    $acl->allow('admin', 'default:empskills', array('index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:disabilitydetails'));
                    $acl->allow('admin', 'default:disabilitydetails', array('index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydetails'));
                    $acl->allow('admin', 'default:workeligibilitydetails', array('index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empadditionaldetails'));
                    $acl->allow('admin', 'default:empadditionaldetails', array('index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:visaandimmigrationdetails'));
                    $acl->allow('admin', 'default:visaandimmigrationdetails', array('index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:creditcarddetails'));
                    $acl->allow('admin', 'default:creditcarddetails', array('index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:dependencydetails'));
                    $acl->allow('admin', 'default:dependencydetails', array('index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empholidays'));
                    $acl->allow('admin', 'default:empholidays', array('index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empjobhistory'));
                    $acl->allow('admin', 'default:empjobhistory', array('index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:assetdetails'));
                    $acl->allow('admin', 'default:assetdetails', array('index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsalarydetails'));
                    $acl->allow('admin', 'default:empsalarydetails', array('index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:logmanager'));
                    $acl->allow('admin', 'default:logmanager', array('index','view','empnamewithidauto'));

		 $acl->addResource(new Zend_Acl_Resource('default:userloginlog'));
                    $acl->allow('admin', 'default:userloginlog', array('index','empnameauto','empidauto','empipaddressauto','empemailauto'));
			   		  	   				   
	   }  
	   if($role == 2 )
           {
               $acl->addResource(new Zend_Acl_Resource('default:approvedrequisitions'));
                            $acl->allow('management', 'default:approvedrequisitions', array('index','edit','view','Approved Requisitions'));
		 $acl->addResource(new Zend_Acl_Resource('default:accountclasstype'));
                            $acl->allow('management', 'default:accountclasstype', array('index','addpopup','saveupdate','add','edit','delete','view','Account Class Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:addemployeeleaves'));
                            $acl->allow('management', 'default:addemployeeleaves', array('index','add','edit','view','Add Employee Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:announcements'));
                            $acl->allow('management', 'default:announcements', array('index','getdepts','uploadsave','uploaddelete','add','edit','delete','view','Announcements'));

		 $acl->addResource(new Zend_Acl_Resource('default:attendancestatuscode'));
                            $acl->allow('management', 'default:attendancestatuscode', array('index','add','edit','delete','view','Attendance Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:bankaccounttype'));
                            $acl->allow('management', 'default:bankaccounttype', array('index','addpopup','add','edit','delete','view','Bank Account Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:businessunits'));
                            $acl->allow('management', 'default:businessunits', array('index','getdeptnames','add','edit','delete','view','Business Units'));

		 $acl->addResource(new Zend_Acl_Resource('default:categories'));
                            $acl->allow('management', 'default:categories', array('index','addnewcategory','add','edit','delete','view','Manage Categories'));
                            
                            $acl->addResource(new Zend_Acl_Resource('default:candidatedetails'));
                            $acl->allow('management', 'default:candidatedetails', array('index','addpopup','chkcandidate','uploadfile','deleteresume','download','multipleresume','getvendors','viewpopup','add','edit','delete','view','Candidates'));

		 $acl->addResource(new Zend_Acl_Resource('default:cities'));
                            $cities_add = 'yes';
                                if($this->id_param == '' && $cities_add == 'yes')
                                    $acl->allow('management','default:cities', array('index','getcitiescand','addpopup','addnewcity','add','delete','view','Cities','edit'));

                                else
                                    $acl->allow('management','default:cities', array('index','getcitiescand','addpopup','addnewcity','add','delete','view','Cities'));

                                
		 $acl->addResource(new Zend_Acl_Resource('default:clients'));
                            $acl->allow('management', 'default:clients', array('index','addpopup','add','edit','delete','view','upload','uploadview','Clients'));

		 $acl->addResource(new Zend_Acl_Resource('default:competencylevel'));
                            $acl->allow('management', 'default:competencylevel', array('index','addpopup','add','edit','delete','view','Competency Levels'));

		 $acl->addResource(new Zend_Acl_Resource('default:countries'));
                            $countries_add = 'yes';
                                if($this->id_param == '' && $countries_add == 'yes')
                                    $acl->allow('management','default:countries', array('index','saveupdate','getcountrycode','addpopup','addnewcountry','add','delete','view','Countries','edit'));

                                else
                                    $acl->allow('management','default:countries', array('index','saveupdate','getcountrycode','addpopup','addnewcountry','add','delete','view','Countries'));

                                
		 $acl->addResource(new Zend_Acl_Resource('default:currency'));
                            $acl->allow('management', 'default:currency', array('index','addpopup','gettargetcurrency','add','edit','delete','view','Currencies'));

		 $acl->addResource(new Zend_Acl_Resource('default:currencyconverter'));
                            $acl->allow('management', 'default:currencyconverter', array('index','add','edit','delete','view','Currency Conversions'));

		 $acl->addResource(new Zend_Acl_Resource('default:dashboard'));
                        $acl->allow('management', 'default:dashboard', array('index','saveuserdashboard','getwidgtes','upgradeapplication','emailsettings','changepassword','editpassword','update','uploadpreview','viewprofile','viewsettings','savemenuwidgets','getmenuname','fetchmenuname','getnavids','getopeningpositondate','menuwork','employeeimageupdate'));

		 $acl->addResource(new Zend_Acl_Resource('default:departments'));
                            $acl->allow('management', 'default:departments', array('index','viewpopup','editpopup','getdepartments','getempnames','add','edit','delete','view','Departments'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryallincidents'));
                            $acl->allow('management', 'default:disciplinaryallincidents', array('index','view','All Incidents'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryincident'));
                            $acl->allow('management', 'default:disciplinaryincident', array('index','getemployees','add','edit','delete','view','upload','uploadview','Raise An Incident'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinarymyincidents'));
                            $acl->allow('management', 'default:disciplinarymyincidents', array('index','saveemployeeappeal','getdisciplinaryincidentpdf','edit','view','My Incidents'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryteamincidents'));
                            $acl->allow('management', 'default:disciplinaryteamincidents', array('index','view','Team Incidents'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryviolation'));
                            $acl->allow('management', 'default:disciplinaryviolation', array('index','addpopup','add','edit','delete','view','upload','uploadview','Violation Type'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationlevelcode'));
                            $acl->allow('management', 'default:educationlevelcode', array('index','add','edit','delete','view','Education Levels'));

		 $acl->addResource(new Zend_Acl_Resource('default:eeoccategory'));
                            $acl->allow('management', 'default:eeoccategory', array('index','add','edit','delete','view','EEOC Categories'));

		 $acl->addResource(new Zend_Acl_Resource('default:emailcontacts'));
                            $acl->allow('management', 'default:emailcontacts', array('index','getgroupoptions','getmailcnt','add','edit','delete','view','Email Contacts'));

		 $acl->addResource(new Zend_Acl_Resource('default:empconfiguration'));
                            $acl->allow('management', 'default:empconfiguration', array('index','edit','Employee Tabs'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleavesummary'));
                            $acl->allow('management', 'default:empleavesummary', array('index','statusid','view','Employee Leaves Summary'));

		 $acl->addResource(new Zend_Acl_Resource('default:employee'));
                            $acl->allow('management', 'default:employee', array('getemprequi','index','changeorghead','getdepartments','getpositions','getempreportingmanagers','makeactiveinactive','changereportingmanager','addemppopup','uploadexcel','getindividualempdetails','add','edit','view','Employees'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeeleavetypes'));
                            $acl->allow('management', 'default:employeeleavetypes', array('index','add','edit','delete','view','Leave Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:employmentstatus'));
                            $acl->allow('management', 'default:employmentstatus', array('index','addpopup','add','edit','delete','view','Employment Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:ethniccode'));
                            $acl->allow('management', 'default:ethniccode', array('index','saveupdate','addpopup','add','edit','delete','view','Ethnic Codes'));

		 $acl->addResource(new Zend_Acl_Resource('default:gender'));
                            $acl->allow('management', 'default:gender', array('index','saveupdate','addpopup','add','edit','delete','view','Gender'));

		 $acl->addResource(new Zend_Acl_Resource('default:geographygroup'));
                            $acl->allow('management', 'default:geographygroup', array('index','add','edit','delete','view','Geo Groups'));

		 $acl->addResource(new Zend_Acl_Resource('default:heirarchy'));
                            $acl->allow('management', 'default:heirarchy', array('index','addlist','editlist','saveadddata','saveeditdata','deletelist','add','edit','view','Organization Hierarchy'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaydates'));
                            $acl->allow('management', 'default:holidaydates', array('index','addpopup','viewpopup','editpopup','add','edit','delete','view','Manage Holidays'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaygroups'));
                            $acl->allow('management', 'default:holidaygroups', array('index','getempnames','getholidaynames','addpopup','add','edit','delete','view','Manage Holiday Group'));
                
                            
		 $acl->addResource(new Zend_Acl_Resource('default:identitycodes'));
                            $acl->allow('management', 'default:identitycodes', array('index','addpopup','add','edit','Identity Codes'));

		 $acl->addResource(new Zend_Acl_Resource('default:identitydocuments'));
                            $acl->allow('management', 'default:identitydocuments', array('index','add','edit','delete','view','Identity Documents'));

		 $acl->addResource(new Zend_Acl_Resource('default:index'));
                        $acl->allow('management', 'default:index', array('index','loginpopupsave','logout','clearsessionarray','forcelogout','browserfailure','sendpassword','updatecontactnumber','getstates','getstatesnormal','getcities','getcitiesnormal','getdepartments','getpositions','gettargetcurrency','calculatedays','calculatebusinessdays','calculatecalendardays','fromdatetodate','fromdatetodateorg','validateorgheadjoiningdate','medicalclaimdates','gettimeformat','chkcurrenttime','popup','createorremoveshortcut','sessiontour','getissuingauthority','setsessionval','checkisactivestatus','updatetheme','welcome','getmultidepts','getmultiemps'));

		 $acl->addResource(new Zend_Acl_Resource('default:jobtitles'));
                            $acl->allow('management', 'default:jobtitles', array('index','addpopup','add','edit','delete','view','Job Titles'));

		 $acl->addResource(new Zend_Acl_Resource('default:language'));
                            $acl->allow('management', 'default:language', array('index','addpopup','add','edit','delete','view','Languages'));

		 $acl->addResource(new Zend_Acl_Resource('default:leavemanagement'));
                            $acl->allow('management', 'default:leavemanagement', array('index','add','edit','delete','view','Leave Management Options'));

		 $acl->addResource(new Zend_Acl_Resource('default:leaverequest'));
                            $leaverequest_add = 'yes';
                                if($this->id_param == '' && $leaverequest_add == 'yes')
                                    $acl->allow('management','default:leaverequest', array('index','saveleaverequestdetails','gethalfdaydetails','editpopup','updateleavedetails','add','Leave Request','edit'));

                                else
                                    $acl->allow('management','default:leaverequest', array('index','saveleaverequestdetails','gethalfdaydetails','editpopup','updateleavedetails','add','Leave Request'));

                                
		 $acl->addResource(new Zend_Acl_Resource('default:licensetype'));
                            $acl->allow('management', 'default:licensetype', array('index','add','edit','delete','view','License Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:managemenus'));
                            $acl->allow('management', 'default:managemenus', array('index','save','add','edit','delete','view','Modules'));

		 $acl->addResource(new Zend_Acl_Resource('default:manageremployeevacations'));
                            $acl->allow('management', 'default:manageremployeevacations', array('index','edit','view','Manager Employee Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:maritalstatus'));
                            $acl->allow('management', 'default:maritalstatus', array('index','saveupdate','addpopup','add','edit','delete','view','Marital Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:militaryservice'));
                            $acl->allow('management', 'default:militaryservice', array('index','add','edit','delete','view','Military Service Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:mydetails'));
                            $acl->allow('management', 'default:mydetails', array('index','personaldetailsview','personal','communicationdetailsview','communication','skills','education','experience','leaves','holidays','salarydetailsview','certification','creditcarddetailsview','creditcard','visadetailsview','visa','medicalclaims','disabilitydetailsview','disability','dependency','workeligibilitydetailsview','workeligibility','additionaldetailsedit','jobhistory','documents','assetdetailsview','add','edit','delete','view','My Details','emppayslip'));

		 $acl->addResource(new Zend_Acl_Resource('default:myemployees'));
                            $acl->allow('management', 'default:myemployees', array('index','perview','comview','skillsview','expview','eduview','trainingview','additionaldetailsview','jobhistoryview','skillsedit','jobhistoryedit','expedit','eduedit','trainingedit','additionaldetailsedit','peredit','comedit','docview','docedit','employeereport','getempreportdata','empauto','emprptpdf','exportemployeereport','downloadreport','view','My Team'));

		 $acl->addResource(new Zend_Acl_Resource('default:myholidaycalendar'));
                            $acl->allow('management', 'default:myholidaycalendar', array('index','view','My Holiday Calendar'));

		 $acl->addResource(new Zend_Acl_Resource('default:nationality'));
                            $acl->allow('management', 'default:nationality', array('index','addpopup','add','edit','delete','view','Nationalities'));

		 $acl->addResource(new Zend_Acl_Resource('default:nationalitycontextcode'));
                            $acl->allow('management', 'default:nationalitycontextcode', array('index','add','edit','delete','view','Nationality Context Codes'));

		 $acl->addResource(new Zend_Acl_Resource('default:numberformats'));
                            $acl->allow('management', 'default:numberformats', array('index','add','edit','delete','view','Number Formats'));

		 $acl->addResource(new Zend_Acl_Resource('default:organisationinfo'));
                            $acl->allow('management', 'default:organisationinfo', array('index','edit_old','saveupdate','uploadpreview','validateorgstartdate','getcompleteorgdata','addorghead','add','edit','view','Organization Info'));

		 $acl->addResource(new Zend_Acl_Resource('default:payfrequency'));
                            $acl->allow('management', 'default:payfrequency', array('index','addpopup','add','edit','delete','view','Pay Frequency'));

		 $acl->addResource(new Zend_Acl_Resource('default:pendingleaves'));
                            $acl->allow('management', 'default:pendingleaves', array('index','delete','view','My Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:policydocuments'));
                            $acl->allow('management', 'default:policydocuments', array('index','uploaddoc','deletedocument','addmultiple','uploadmultipledocs','add','edit','delete','view','View/Manage Policy Documents'));

		 $acl->addResource(new Zend_Acl_Resource('default:positions'));
                            $acl->allow('management', 'default:positions', array('index','addpopup','add','edit','delete','view','Positions'));

		 $acl->addResource(new Zend_Acl_Resource('default:prefix'));
                            $acl->allow('management', 'default:prefix', array('index','saveupdate','addpopup','add','edit','delete','view','Prefixes'));

		 $acl->addResource(new Zend_Acl_Resource('default:projects'));
                            $acl->allow('management', 'default:projects', array('index','viewpopup','editpopup','add','edit','delete','view','upload','uploadview','Projects'));

		 $acl->addResource(new Zend_Acl_Resource('default:racecode'));
                            $acl->allow('management', 'default:racecode', array('index','saveupdate','addpopup','add','edit','delete','view','Race Codes'));
                             $acl->addResource(new Zend_Acl_Resource('default:rejectedrequisitions'));
                            $acl->allow('management', 'default:rejectedrequisitions', array('index','view','Rejected Requisitions'));

		 $acl->addResource(new Zend_Acl_Resource('default:remunerationbasis'));
                            $acl->allow('management', 'default:remunerationbasis', array('index','add','edit','delete','view','Remuneration Basis'));

		 $acl->addResource(new Zend_Acl_Resource('default:reports'));
                            $acl->allow('management', 'default:reports', array('getrolepopup','emprolesgrouppopup','performancereport','previousappraisals','getselectedappraisaldata','getinterviewroundsdata','interviewrounds','rolesgroup','exportemprolesgroup','exportrolesgroupreport','exportinterviewrpt','exportactiveuserrpt','exportemployeereport','rolesgrouprptpdf','activeuserrptpdf','emprptpdf','interviewrptpdf','rolesgroupdata','emprolesgroup','emprolesgroupdata','activeuser','getactiveuserdata','getempreportdata','empauto','servicedeskreport','getsddata','servicedeskpdf','servicedeskexcel','employeereport','getdeptsemp','index','holidaygroupreports','getpdfreportholiday','getexcelreportholiday','leavesreport','getpdfreportleaves','getexcelreportleaves','leavesreporttabheader','leavemanagementreport','getpdfreportleavemanagement','getexcelreportleavemanagement','bunitauto','bunitcodeauto','getexcelreportbusinessunit','getbusinessunitspdf','businessunits','userlogreport','departments','exportdepartmentpdf','getexcelreportdepartment','candidaterptexcel','candidaterptpdf','getcandidatesreportdata','candidatesreport','requisitionauto','requisitionrptexcel','requisitionrptpdf','getrequisitionsstatusreportdata','requisitionstatusreport','activitylogreport','downloadreport','agencylistreport','agencynameauto','agencysebsiteauto','empscreening','getspecimennames','getagencynames','getexcelreportempscreening','getempscreeningpdf','add','edit','delete','view','Analytics'));
                            
                            $acl->addResource(new Zend_Acl_Resource('default:requisition'));
                            $acl->allow('management', 'default:requisition', array('index','viewhr','approverequisition','addcandidate','interview','getdepartments','getpositions','viewpopup','getapprreqdata','chkreqforclose','getempreportingmanagers','getemailcount','getapprovers','approverejectrequisition','addpopup','add','edit','delete','view','Openings/Positions'));

		 $acl->addResource(new Zend_Acl_Resource('default:roles'));
                            $acl->allow('management', 'default:roles', array('index','saveupdate','getgroupmenu','add','edit','delete','view','Roles & Privileges'));
                            
                            $acl->addResource(new Zend_Acl_Resource('default:scheduleinterviews'));
                            $acl->allow('management', 'default:scheduleinterviews', array('candidatepopup','index','downloadresume','getcandidates','add','edit','delete','view','Interviews'));

		 $acl->addResource(new Zend_Acl_Resource('default:sitepreference'));
                            $acl->allow('management', 'default:sitepreference', array('index','view','add','edit','Site Preferences'));

		 $acl->addResource(new Zend_Acl_Resource('default:states'));
                            $states_add = 'yes';
                                if($this->id_param == '' && $states_add == 'yes')
                                    $acl->allow('management','default:states', array('index','getstates','getstatescand','addpopup','addnewstate','add','delete','view','States','edit'));

                                else
                                    $acl->allow('management','default:states', array('index','getstates','getstatescand','addpopup','addnewstate','add','delete','view','States'));

                                
		 $acl->addResource(new Zend_Acl_Resource('default:structure'));
                            $acl->allow('management', 'default:structure', array('index','Organization Structure'));

                 $acl->addResource(new Zend_Acl_Resource('default:shortlistedcandidates'));
                            $acl->allow('management', 'default:shortlistedcandidates', array('index','edit','view','Shortlisted & Selected Candidates'));           
                            
		 $acl->addResource(new Zend_Acl_Resource('default:timezone'));
                            $acl->allow('management', 'default:timezone', array('index','saveupdate','addpopup','add','edit','delete','view','Time Zones'));

		 $acl->addResource(new Zend_Acl_Resource('default:usermanagement'));
                            $acl->allow('management', 'default:usermanagement', array('index','saveupdate','getemailofuser','add','edit','view','External Users'));

		 $acl->addResource(new Zend_Acl_Resource('default:vendors'));
                            $acl->allow('management', 'default:vendors', array('index','addpopup','add','edit','delete','view','upload','uploadview','Vendors'));

		 $acl->addResource(new Zend_Acl_Resource('default:veteranstatus'));
                            $acl->allow('management', 'default:veteranstatus', array('index','add','edit','delete','view','Veteran Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydoctypes'));
                            $acl->allow('management', 'default:workeligibilitydoctypes', array('index','addpopup','add','edit','delete','view','Work Eligibility Document Types'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:advances'));
                            $acl->allow('management', 'expenses:advances', array('index','getprojects','myadvances','viewmoreadvances','clearadvancesdata','addreturnpopup','add','edit','delete','view','Advances'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:employeeadvances'));
                            $acl->allow('management', 'expenses:employeeadvances', array('index','add','edit','delete','view','Employee Advances'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:expenses'));
                            $acl->allow('management', 'expenses:expenses', array('index','clone','addpopup','uploadsave','uploaddelete','displayreceipts','addtrippopup','submitexpense','addreceiptimage','expensestatus','listreportingmangers','viewmoremanagers','forwardexpenseto','downloadexpensepdf','bulkexpenses','getcategories','getprojects','getcurrency','uploadedfiles','add','edit','delete','view','Expenses'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:myemployeeexpenses'));
                            $acl->allow('management', 'expenses:myemployeeexpenses', array('index','add','edit','delete','view','My Employee Expenses'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:receipts'));
                            $acl->allow('management', 'expenses:receipts', array('index','downloadreceipt','downloadexpensereceipt','deletereceipt','uploadsave','displayreceipts','viewmorereceipts','listexpenses','addreceipttoexpense','viewmoreexpenses','cleardata','showreceiptspopup','listtrips','viewmoretrips','addexpensetotrip','add','edit','delete','view','Receipts'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:trips'));
                            $acl->allow('management', 'expenses:trips', array('index','addpopup','tripstatus','deleteexpense','downloadtrippdf','add','edit','delete','view','Trips'));

		 $acl->addResource(new Zend_Acl_Resource('default:processes'));
                            $acl->allow('management', 'default:processes', array('index','addpopup','editpopup','viewpopup','savecomments','displaycomments','savefeedback','index','addpopup','editpopup','viewpopup','delete','savecomments','displaycomments','savefeedback'));

		 $acl->addResource(new Zend_Acl_Resource('default:interviewrounds'));
                            $acl->allow('management', 'default:interviewrounds', array('index','addpopup','editpopup','viewpopup','index','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empperformanceappraisal'));
                            $acl->allow('management', 'default:empperformanceappraisal', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppayslips'));
                            $acl->allow('management', 'default:emppayslips', array('index','view','printslip','salarydetails','index','edit','view','printslip','salarydetails'));

		 $acl->addResource(new Zend_Acl_Resource('default:empbenefits'));
                            $acl->allow('management', 'default:empbenefits', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emprequisitiondetails'));
                            $acl->allow('management', 'default:emprequisitiondetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empremunerationdetails'));
                            $acl->allow('management', 'default:empremunerationdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsecuritycredentials'));
                            $acl->allow('management', 'default:empsecuritycredentials', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:apprreqcandidates'));
                            $acl->allow('management', 'default:apprreqcandidates', array('index','viewpopup','index','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppersonaldetails'));
                            $acl->allow('management', 'default:emppersonaldetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeedocs'));
                            $acl->allow('management', 'default:employeedocs', array('index','view','save','update','uploadsave','uploaddelete','downloadfiles','index','view','save','delete','edit','update','uploadsave','uploaddelete','downloadfiles'));

		 $acl->addResource(new Zend_Acl_Resource('default:empcommunicationdetails'));
                            $acl->allow('management', 'default:empcommunicationdetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:trainingandcertificationdetails'));
                            $acl->allow('management', 'default:trainingandcertificationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:experiencedetails'));
                            $acl->allow('management', 'default:experiencedetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationdetails'));
                            $acl->allow('management', 'default:educationdetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:medicalclaims'));
                            $acl->allow('management', 'default:medicalclaims', array('index','addpopup','viewpopup','editpopup','view','index','edit','addpopup','viewpopup','editpopup','delete','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleaves'));
                            $acl->allow('management', 'default:empleaves', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empskills'));
                            $acl->allow('management', 'default:empskills', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:disabilitydetails'));
                            $acl->allow('management', 'default:disabilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydetails'));
                            $acl->allow('management', 'default:workeligibilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empadditionaldetails'));
                            $acl->allow('management', 'default:empadditionaldetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:visaandimmigrationdetails'));
                            $acl->allow('management', 'default:visaandimmigrationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:creditcarddetails'));
                            $acl->allow('management', 'default:creditcarddetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:dependencydetails'));
                            $acl->allow('management', 'default:dependencydetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empholidays'));
                            $acl->allow('management', 'default:empholidays', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empjobhistory'));
                            $acl->allow('management', 'default:empjobhistory', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:assetdetails'));
                            $acl->allow('management', 'default:assetdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsalarydetails'));
                            $acl->allow('management', 'default:empsalarydetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:logmanager'));
                            $acl->allow('management', 'default:logmanager', array('index','view','empnamewithidauto','index','view','empnamewithidauto'));

		 $acl->addResource(new Zend_Acl_Resource('default:userloginlog'));
                            $acl->allow('management', 'default:userloginlog', array('index','empnameauto','empidauto','empipaddressauto','empemailauto','index','empnameauto','empidauto','empipaddressauto','empemailauto'));
                 $acl->addResource(new Zend_Acl_Resource('default:payrollcategory'));
                    $acl->allow('admin', 'default:payrollcategory', array('index','add','validate','delete','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollgroup'));
                    $acl->allow('admin', 'default:payrollgroup', array('index','add','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipemployee'));
                    $acl->allow('admin', 'default:payslipemployee', array('index','generate','generatebulk'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipgroup'));
                    $acl->allow('admin', 'default:payslipgroup', array('index','add','generate'));
                $acl->addResource(new Zend_Acl_Resource('default:payslipreport'));
                    $acl->allow('admin', 'default:payslipreport', array('index','filter'));
} if($role == 10 )
           {
		 $acl->addResource(new Zend_Acl_Resource('default:announcements'));
                            $acl->allow('Teacher', 'default:announcements', array('index','getdepts','uploadsave','uploaddelete','view','Announcements'));

		 $acl->addResource(new Zend_Acl_Resource('default:businessunits'));
                            $acl->allow('Teacher', 'default:businessunits', array('index','getdeptnames','view','Business Units'));

		 $acl->addResource(new Zend_Acl_Resource('default:dashboard'));
                        $acl->allow('Teacher', 'default:dashboard', array('index','saveuserdashboard','getwidgtes','upgradeapplication','emailsettings','changepassword','editpassword','update','uploadpreview','viewprofile','viewsettings','savemenuwidgets','getmenuname','fetchmenuname','getnavids','getopeningpositondate','menuwork','employeeimageupdate'));

		 $acl->addResource(new Zend_Acl_Resource('default:departments'));
                            $acl->allow('Teacher', 'default:departments', array('index','viewpopup','editpopup','getdepartments','getempnames','view','Departments'));

		 $acl->addResource(new Zend_Acl_Resource('default:employee'));
                            $acl->allow('Teacher', 'default:employee', array('getemprequi','index','changeorghead','getdepartments','getpositions','getempreportingmanagers','makeactiveinactive','changereportingmanager','addemppopup','uploadexcel','getindividualempdetails','view','Employees'));

		 $acl->addResource(new Zend_Acl_Resource('default:heirarchy'));
                            $acl->allow('Teacher', 'default:heirarchy', array('index','addlist','editlist','saveadddata','saveeditdata','deletelist','Organization Hierarchy'));

		 $acl->addResource(new Zend_Acl_Resource('default:index'));
                        $acl->allow('Teacher', 'default:index', array('index','loginpopupsave','logout','clearsessionarray','forcelogout','browserfailure','sendpassword','updatecontactnumber','getstates','getstatesnormal','getcities','getcitiesnormal','getdepartments','getpositions','gettargetcurrency','calculatedays','calculatebusinessdays','calculatecalendardays','fromdatetodate','fromdatetodateorg','validateorgheadjoiningdate','medicalclaimdates','gettimeformat','chkcurrenttime','popup','createorremoveshortcut','sessiontour','getissuingauthority','setsessionval','checkisactivestatus','updatetheme','welcome','getmultidepts','getmultiemps'));

		 $acl->addResource(new Zend_Acl_Resource('default:leaverequest'));
                            $leaverequest_add = 'yes';
                                if($this->id_param == '' && $leaverequest_add == 'yes')
                                    $acl->allow('Teacher','default:leaverequest', array('index','saveleaverequestdetails','gethalfdaydetails','editpopup','updateleavedetails','add','Leave Request','edit'));

                                else
                                    $acl->allow('Teacher','default:leaverequest', array('index','saveleaverequestdetails','gethalfdaydetails','editpopup','updateleavedetails','add','Leave Request'));

                                
		 $acl->addResource(new Zend_Acl_Resource('default:manageremployeevacations'));
                            $acl->allow('Teacher', 'default:manageremployeevacations', array('index','edit','view','Manager Employee Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:mydetails'));
                            $acl->allow('Teacher', 'default:mydetails', array('index','personaldetailsview','personal','communicationdetailsview','communication','skills','education','experience','leaves','holidays','salarydetailsview','certification','creditcarddetailsview','creditcard','visadetailsview','visa','medicalclaims','disabilitydetailsview','disability','dependency','workeligibilitydetailsview','workeligibility','additionaldetailsedit','jobhistory','documents','assetdetailsview','add','edit','delete','view','My Details','emppayslip'));

		 $acl->addResource(new Zend_Acl_Resource('default:myemployees'));
                            $acl->allow('Teacher', 'default:myemployees', array('index','perview','comview','skillsview','expview','eduview','trainingview','additionaldetailsview','jobhistoryview','skillsedit','jobhistoryedit','expedit','eduedit','trainingedit','additionaldetailsedit','peredit','comedit','docview','docedit','employeereport','getempreportdata','empauto','emprptpdf','exportemployeereport','downloadreport','view','My Team'));

		 $acl->addResource(new Zend_Acl_Resource('default:myholidaycalendar'));
                            $acl->allow('Teacher', 'default:myholidaycalendar', array('index','view','My Holiday Calendar'));

		 $acl->addResource(new Zend_Acl_Resource('default:organisationinfo'));
                            $acl->allow('Teacher', 'default:organisationinfo', array('index','edit_old','saveupdate','uploadpreview','validateorgstartdate','getcompleteorgdata','addorghead','Organization Info'));

		 $acl->addResource(new Zend_Acl_Resource('default:pendingleaves'));
                            $acl->allow('Teacher', 'default:pendingleaves', array('index','delete','view','My Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:policydocuments'));
                            $acl->allow('Teacher', 'default:policydocuments', array('index','uploaddoc','deletedocument','addmultiple','uploadmultipledocs','view','View/Manage Policy Documents'));

		 $acl->addResource(new Zend_Acl_Resource('default:structure'));
                            $acl->allow('Teacher', 'default:structure', array('index','Organization Structure'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:advances'));
                            $acl->allow('Teacher', 'expenses:advances', array('index','getprojects','myadvances','viewmoreadvances','clearadvancesdata','addreturnpopup','add','edit','delete','view','Advances'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:employeeadvances'));
                            $acl->allow('Teacher', 'expenses:employeeadvances', array('index','add','edit','delete','view','Employee Advances'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:expenses'));
                            $acl->allow('Teacher', 'expenses:expenses', array('index','clone','addpopup','uploadsave','uploaddelete','displayreceipts','addtrippopup','submitexpense','addreceiptimage','expensestatus','listreportingmangers','viewmoremanagers','forwardexpenseto','downloadexpensepdf','bulkexpenses','getcategories','getprojects','getcurrency','uploadedfiles','add','edit','delete','view','Expenses'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:myemployeeexpenses'));
                            $acl->allow('Teacher', 'expenses:myemployeeexpenses', array('index','add','edit','delete','view','My Employee Expenses'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:receipts'));
                            $acl->allow('Teacher', 'expenses:receipts', array('index','downloadreceipt','downloadexpensereceipt','deletereceipt','uploadsave','displayreceipts','viewmorereceipts','listexpenses','addreceipttoexpense','viewmoreexpenses','cleardata','showreceiptspopup','listtrips','viewmoretrips','addexpensetotrip','add','edit','delete','view','Receipts'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:trips'));
                            $acl->allow('Teacher', 'expenses:trips', array('index','addpopup','tripstatus','deleteexpense','downloadtrippdf','add','edit','delete','view','Trips'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppersonaldetails'));
                            $acl->allow('Teacher', 'default:emppersonaldetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeedocs'));
                            $acl->allow('Teacher', 'default:employeedocs', array('index','view','save','update','uploadsave','uploaddelete','downloadfiles','index','view','save','delete','edit','update','uploadsave','uploaddelete','downloadfiles'));

		 $acl->addResource(new Zend_Acl_Resource('default:empcommunicationdetails'));
                            $acl->allow('Teacher', 'default:empcommunicationdetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:trainingandcertificationdetails'));
                            $acl->allow('Teacher', 'default:trainingandcertificationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:experiencedetails'));
                            $acl->allow('Teacher', 'default:experiencedetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationdetails'));
                            $acl->allow('Teacher', 'default:educationdetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:medicalclaims'));
                            $acl->allow('Teacher', 'default:medicalclaims', array('index','addpopup','viewpopup','editpopup','view','index','edit','addpopup','viewpopup','editpopup','delete','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleaves'));
                            $acl->allow('Teacher', 'default:empleaves', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empskills'));
                            $acl->allow('Teacher', 'default:empskills', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:disabilitydetails'));
                            $acl->allow('Teacher', 'default:disabilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydetails'));
                            $acl->allow('Teacher', 'default:workeligibilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empadditionaldetails'));
                            $acl->allow('Teacher', 'default:empadditionaldetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:visaandimmigrationdetails'));
                            $acl->allow('Teacher', 'default:visaandimmigrationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:creditcarddetails'));
                            $acl->allow('Teacher', 'default:creditcarddetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:dependencydetails'));
                            $acl->allow('Teacher', 'default:dependencydetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empholidays'));
                            $acl->allow('Teacher', 'default:empholidays', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empjobhistory'));
                            $acl->allow('Teacher', 'default:empjobhistory', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:assetdetails'));
                            $acl->allow('Teacher', 'default:assetdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:interviewrounds'));
                            $acl->allow('Teacher', 'default:interviewrounds', array('index','addpopup','editpopup','viewpopup','index','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:apprreqcandidates'));
                            $acl->allow('Teacher', 'default:apprreqcandidates', array('index','viewpopup'));
                            
}if($role == 12 )
           {
		 $acl->addResource(new Zend_Acl_Resource('default:announcements'));
                            $acl->allow('External', 'default:announcements', array('index','getdepts','uploadsave','uploaddelete','view','Announcements'));

		 $acl->addResource(new Zend_Acl_Resource('default:businessunits'));
                            $acl->allow('External', 'default:businessunits', array('index','getdeptnames','view','Business Units'));

		 $acl->addResource(new Zend_Acl_Resource('default:dashboard'));
                        $acl->allow('External', 'default:dashboard', array('index','saveuserdashboard','getwidgtes','upgradeapplication','emailsettings','changepassword','editpassword','update','uploadpreview','viewprofile','viewsettings','savemenuwidgets','getmenuname','fetchmenuname','getnavids','getopeningpositondate','menuwork','employeeimageupdate'));

		 $acl->addResource(new Zend_Acl_Resource('default:departments'));
                            $acl->allow('External', 'default:departments', array('index','viewpopup','editpopup','getdepartments','getempnames','view','Departments'));

		 $acl->addResource(new Zend_Acl_Resource('default:heirarchy'));
                            $acl->allow('External', 'default:heirarchy', array('index','addlist','editlist','saveadddata','saveeditdata','deletelist','Organization Hierarchy'));

		 $acl->addResource(new Zend_Acl_Resource('default:index'));
                        $acl->allow('External', 'default:index', array('index','loginpopupsave','logout','clearsessionarray','forcelogout','browserfailure','sendpassword','updatecontactnumber','getstates','getstatesnormal','getcities','getcitiesnormal','getdepartments','getpositions','gettargetcurrency','calculatedays','calculatebusinessdays','calculatecalendardays','fromdatetodate','fromdatetodateorg','validateorgheadjoiningdate','medicalclaimdates','gettimeformat','chkcurrenttime','popup','createorremoveshortcut','sessiontour','getissuingauthority','setsessionval','checkisactivestatus','updatetheme','welcome','getmultidepts','getmultiemps'));

		 $acl->addResource(new Zend_Acl_Resource('default:organisationinfo'));
                            $acl->allow('External', 'default:organisationinfo', array('index','edit_old','saveupdate','uploadpreview','validateorgstartdate','getcompleteorgdata','addorghead','Organization Info'));

		 $acl->addResource(new Zend_Acl_Resource('default:structure'));
                            $acl->allow('External', 'default:structure', array('index','Organization Structure'));

		 $acl->addResource(new Zend_Acl_Resource('default:processes'));
                            $acl->allow('External', 'default:processes', array('index','editpopup','viewpopup','savecomments','displaycomments','savefeedback'));
}if($role == 13 )
           {
		 $acl->addResource(new Zend_Acl_Resource('default:announcements'));
                            $acl->allow('agencies', 'default:announcements', array('index','getdepts','uploadsave','uploaddelete','view','Announcements'));

		 $acl->addResource(new Zend_Acl_Resource('default:businessunits'));
                            $acl->allow('agencies', 'default:businessunits', array('index','getdeptnames','view','Business Units'));

		 $acl->addResource(new Zend_Acl_Resource('default:dashboard'));
                        $acl->allow('agencies', 'default:dashboard', array('index','saveuserdashboard','getwidgtes','upgradeapplication','emailsettings','changepassword','editpassword','update','uploadpreview','viewprofile','viewsettings','savemenuwidgets','getmenuname','fetchmenuname','getnavids','getopeningpositondate','menuwork','employeeimageupdate'));

		 $acl->addResource(new Zend_Acl_Resource('default:departments'));
                            $acl->allow('agencies', 'default:departments', array('index','viewpopup','editpopup','getdepartments','getempnames','view','Departments'));

		 $acl->addResource(new Zend_Acl_Resource('default:heirarchy'));
                            $acl->allow('agencies', 'default:heirarchy', array('index','addlist','editlist','saveadddata','saveeditdata','deletelist','Organization Hierarchy'));

		 $acl->addResource(new Zend_Acl_Resource('default:index'));
                        $acl->allow('agencies', 'default:index', array('index','loginpopupsave','logout','clearsessionarray','forcelogout','browserfailure','sendpassword','updatecontactnumber','getstates','getstatesnormal','getcities','getcitiesnormal','getdepartments','getpositions','gettargetcurrency','calculatedays','calculatebusinessdays','calculatecalendardays','fromdatetodate','fromdatetodateorg','validateorgheadjoiningdate','medicalclaimdates','gettimeformat','chkcurrenttime','popup','createorremoveshortcut','sessiontour','getissuingauthority','setsessionval','checkisactivestatus','updatetheme','welcome','getmultidepts','getmultiemps'));

		 $acl->addResource(new Zend_Acl_Resource('default:organisationinfo'));
                            $acl->allow('agencies', 'default:organisationinfo', array('index','edit_old','saveupdate','uploadpreview','validateorgstartdate','getcompleteorgdata','addorghead','Organization Info'));

		 $acl->addResource(new Zend_Acl_Resource('default:structure'));
                            $acl->allow('agencies', 'default:structure', array('index','Organization Structure'));

		 $acl->addResource(new Zend_Acl_Resource('default:processes'));
                            $acl->allow('agencies', 'default:processes', array('index','editpopup','viewpopup','savecomments','displaycomments','savefeedback'));
}if($role == 15 )
           {
		 $acl->addResource(new Zend_Acl_Resource('default:dashboard'));
                        $acl->allow('CLW', 'default:dashboard', array('index','saveuserdashboard','getwidgtes','upgradeapplication','emailsettings','changepassword','editpassword','update','uploadpreview','viewprofile','viewsettings','savemenuwidgets','getmenuname','fetchmenuname','getnavids','getopeningpositondate','menuwork','employeeimageupdate'));

		 $acl->addResource(new Zend_Acl_Resource('default:index'));
                        $acl->allow('CLW', 'default:index', array('index','loginpopupsave','logout','clearsessionarray','forcelogout','browserfailure','sendpassword','updatecontactnumber','getstates','getstatesnormal','getcities','getcitiesnormal','getdepartments','getpositions','gettargetcurrency','calculatedays','calculatebusinessdays','calculatecalendardays','fromdatetodate','fromdatetodateorg','validateorgheadjoiningdate','medicalclaimdates','gettimeformat','chkcurrenttime','popup','createorremoveshortcut','sessiontour','getissuingauthority','setsessionval','checkisactivestatus','updatetheme','welcome','getmultidepts','getmultiemps'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollcategory'));
                            $acl->allow('CLW', 'default:payrollcategory', array('index','validate','delete','view','Manage Payroll Category'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollgroup'));
                            $acl->allow('CLW', 'default:payrollgroup', array('index','delete','view','Manage Payroll Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipemployee'));
                            $acl->allow('CLW', 'default:payslipemployee', array('index','generate','generatebulk','delete','view','Generate Payslip Individual Employee'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipgroup'));
                            $acl->allow('CLW', 'default:payslipgroup', array('index','generate','delete','view','Generate Payslip for Payroll Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:processes'));
                            $acl->allow('CLW', 'default:processes', array('index','addpopup','editpopup','viewpopup','savecomments','displaycomments','savefeedback','index','addpopup','editpopup','viewpopup','delete','savecomments','displaycomments','savefeedback'));

		 $acl->addResource(new Zend_Acl_Resource('default:interviewrounds'));
                            $acl->allow('CLW', 'default:interviewrounds', array('index','addpopup','editpopup','viewpopup','index','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empperformanceappraisal'));
                            $acl->allow('CLW', 'default:empperformanceappraisal', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppayslips'));
                            $acl->allow('CLW', 'default:emppayslips', array('index','view','printslip','salarydetails','index','edit','view','printslip','salarydetails'));

		 $acl->addResource(new Zend_Acl_Resource('default:empbenefits'));
                            $acl->allow('CLW', 'default:empbenefits', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emprequisitiondetails'));
                            $acl->allow('CLW', 'default:emprequisitiondetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empremunerationdetails'));
                            $acl->allow('CLW', 'default:empremunerationdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsecuritycredentials'));
                            $acl->allow('CLW', 'default:empsecuritycredentials', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:apprreqcandidates'));
                            $acl->allow('CLW', 'default:apprreqcandidates', array('index','viewpopup','index','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppersonaldetails'));
                            $acl->allow('CLW', 'default:emppersonaldetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeedocs'));
                            $acl->allow('CLW', 'default:employeedocs', array('index','view','save','update','uploadsave','uploaddelete','downloadfiles','index','view','save','delete','edit','update','uploadsave','uploaddelete','downloadfiles'));

		 $acl->addResource(new Zend_Acl_Resource('default:empcommunicationdetails'));
                            $acl->allow('CLW', 'default:empcommunicationdetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:trainingandcertificationdetails'));
                            $acl->allow('CLW', 'default:trainingandcertificationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:experiencedetails'));
                            $acl->allow('CLW', 'default:experiencedetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationdetails'));
                            $acl->allow('CLW', 'default:educationdetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:medicalclaims'));
                            $acl->allow('CLW', 'default:medicalclaims', array('index','addpopup','viewpopup','editpopup','view','index','edit','addpopup','viewpopup','editpopup','delete','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleaves'));
                            $acl->allow('CLW', 'default:empleaves', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empskills'));
                            $acl->allow('CLW', 'default:empskills', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:disabilitydetails'));
                            $acl->allow('CLW', 'default:disabilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydetails'));
                            $acl->allow('CLW', 'default:workeligibilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empadditionaldetails'));
                            $acl->allow('CLW', 'default:empadditionaldetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:visaandimmigrationdetails'));
                            $acl->allow('CLW', 'default:visaandimmigrationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:creditcarddetails'));
                            $acl->allow('CLW', 'default:creditcarddetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:dependencydetails'));
                            $acl->allow('CLW', 'default:dependencydetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empholidays'));
                            $acl->allow('CLW', 'default:empholidays', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empjobhistory'));
                            $acl->allow('CLW', 'default:empjobhistory', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:assetdetails'));
                            $acl->allow('CLW', 'default:assetdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsalarydetails'));
                            $acl->allow('CLW', 'default:empsalarydetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:logmanager'));
                            $acl->allow('CLW', 'default:logmanager', array('index','view','empnamewithidauto','index','view','empnamewithidauto'));

		 $acl->addResource(new Zend_Acl_Resource('default:userloginlog'));
                            $acl->allow('CLW', 'default:userloginlog', array('index','empnameauto','empidauto','empipaddressauto','empemailauto','index','empnameauto','empidauto','empipaddressauto','empemailauto'));
}if($role == 17 )
           {
		 $acl->addResource(new Zend_Acl_Resource('default:addemployeeleaves'));
                            $acl->allow('PEON', 'default:addemployeeleaves', array('index','view','Add Employee Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:attendancestatuscode'));
                            $acl->allow('PEON', 'default:attendancestatuscode', array('index','view','Attendance Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:bankaccounttype'));
                            $acl->allow('PEON', 'default:bankaccounttype', array('index','addpopup','view','Bank Account Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:clients'));
                            $acl->allow('PEON', 'default:clients', array('index','addpopup','view','Clients'));

		 $acl->addResource(new Zend_Acl_Resource('default:competencylevel'));
                            $acl->allow('PEON', 'default:competencylevel', array('index','addpopup','view','Competency Levels'));

		 $acl->addResource(new Zend_Acl_Resource('default:dashboard'));
                        $acl->allow('PEON', 'default:dashboard', array('index','saveuserdashboard','getwidgtes','upgradeapplication','emailsettings','changepassword','editpassword','update','uploadpreview','viewprofile','viewsettings','savemenuwidgets','getmenuname','fetchmenuname','getnavids','getopeningpositondate','menuwork','employeeimageupdate'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationlevelcode'));
                            $acl->allow('PEON', 'default:educationlevelcode', array('index','view','Education Levels'));

		 $acl->addResource(new Zend_Acl_Resource('default:eeoccategory'));
                            $acl->allow('PEON', 'default:eeoccategory', array('index','view','EEOC Categories'));

		 $acl->addResource(new Zend_Acl_Resource('default:empconfiguration'));
                            $acl->allow('PEON', 'default:empconfiguration', array('index','Employee Tabs'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleavesummary'));
                            $acl->allow('PEON', 'default:empleavesummary', array('index','statusid','view','Employee Leaves Summary'));

		 $acl->addResource(new Zend_Acl_Resource('default:employee'));
                            $acl->allow('PEON', 'default:employee', array('getemprequi','index','changeorghead','getdepartments','getpositions','getempreportingmanagers','makeactiveinactive','changereportingmanager','addemppopup','uploadexcel','getindividualempdetails','view','Employees'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeeleavetypes'));
                            $acl->allow('PEON', 'default:employeeleavetypes', array('index','view','Leave Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:employmentstatus'));
                            $acl->allow('PEON', 'default:employmentstatus', array('index','addpopup','view','Employment Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaydates'));
                            $acl->allow('PEON', 'default:holidaydates', array('index','addpopup','viewpopup','editpopup','view','Manage Holidays'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaygroups'));
                            $acl->allow('PEON', 'default:holidaygroups', array('index','getempnames','getholidaynames','addpopup','view','Manage Holiday Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:identitydocuments'));
                            $acl->allow('PEON', 'default:identitydocuments', array('index','view','Identity Documents'));

		 $acl->addResource(new Zend_Acl_Resource('default:index'));
                        $acl->allow('PEON', 'default:index', array('index','loginpopupsave','logout','clearsessionarray','forcelogout','browserfailure','sendpassword','updatecontactnumber','getstates','getstatesnormal','getcities','getcitiesnormal','getdepartments','getpositions','gettargetcurrency','calculatedays','calculatebusinessdays','calculatecalendardays','fromdatetodate','fromdatetodateorg','validateorgheadjoiningdate','medicalclaimdates','gettimeformat','chkcurrenttime','popup','createorremoveshortcut','sessiontour','getissuingauthority','setsessionval','checkisactivestatus','updatetheme','welcome','getmultidepts','getmultiemps'));

		 $acl->addResource(new Zend_Acl_Resource('default:jobtitles'));
                            $acl->allow('PEON', 'default:jobtitles', array('index','addpopup','view','Job Titles'));

		 $acl->addResource(new Zend_Acl_Resource('default:language'));
                            $acl->allow('PEON', 'default:language', array('index','addpopup','view','Languages'));

		 $acl->addResource(new Zend_Acl_Resource('default:leavemanagement'));
                            $acl->allow('PEON', 'default:leavemanagement', array('index','view','Leave Management Options'));

		 $acl->addResource(new Zend_Acl_Resource('default:militaryservice'));
                            $acl->allow('PEON', 'default:militaryservice', array('index','view','Military Service Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:payfrequency'));
                            $acl->allow('PEON', 'default:payfrequency', array('index','addpopup','view','Pay Frequency'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollcategory'));
                            $acl->allow('PEON', 'default:payrollcategory', array('index','validate','view','Manage Payroll Category'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollgroup'));
                            $acl->allow('PEON', 'default:payrollgroup', array('index','view','Manage Payroll Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipemployee'));
                            $acl->allow('PEON', 'default:payslipemployee', array('index','generate','generatebulk','view','Generate Payslip Individual Employee'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipgroup'));
                            $acl->allow('PEON', 'default:payslipgroup', array('index','generate','view','Generate Payslip for Payroll Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:positions'));
                            $acl->allow('PEON', 'default:positions', array('index','addpopup','view','Positions'));

		 $acl->addResource(new Zend_Acl_Resource('default:projects'));
                            $acl->allow('PEON', 'default:projects', array('index','viewpopup','editpopup','view','Projects'));

		 $acl->addResource(new Zend_Acl_Resource('default:remunerationbasis'));
                            $acl->allow('PEON', 'default:remunerationbasis', array('index','view','Remuneration Basis'));

		 $acl->addResource(new Zend_Acl_Resource('default:roles'));
                            $acl->allow('PEON', 'default:roles', array('index','saveupdate','getgroupmenu','view','Roles & Privileges'));

		 $acl->addResource(new Zend_Acl_Resource('default:usermanagement'));
                            $acl->allow('PEON', 'default:usermanagement', array('index','saveupdate','getemailofuser','view','External Users'));

		 $acl->addResource(new Zend_Acl_Resource('default:vendors'));
                            $acl->allow('PEON', 'default:vendors', array('index','addpopup','view','Vendors'));

		 $acl->addResource(new Zend_Acl_Resource('default:veteranstatus'));
                            $acl->allow('PEON', 'default:veteranstatus', array('index','view','Veteran Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydoctypes'));
                            $acl->allow('PEON', 'default:workeligibilitydoctypes', array('index','addpopup','view','Work Eligibility Document Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:processes'));
                            $acl->allow('PEON', 'default:processes', array('index','addpopup','editpopup','viewpopup','savecomments','displaycomments','savefeedback','index','addpopup','editpopup','viewpopup','delete','savecomments','displaycomments','savefeedback'));

		 $acl->addResource(new Zend_Acl_Resource('default:interviewrounds'));
                            $acl->allow('PEON', 'default:interviewrounds', array('index','addpopup','editpopup','viewpopup','index','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empperformanceappraisal'));
                            $acl->allow('PEON', 'default:empperformanceappraisal', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppayslips'));
                            $acl->allow('PEON', 'default:emppayslips', array('index','view','printslip','salarydetails','index','edit','view','printslip','salarydetails'));

		 $acl->addResource(new Zend_Acl_Resource('default:empbenefits'));
                            $acl->allow('PEON', 'default:empbenefits', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emprequisitiondetails'));
                            $acl->allow('PEON', 'default:emprequisitiondetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empremunerationdetails'));
                            $acl->allow('PEON', 'default:empremunerationdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsecuritycredentials'));
                            $acl->allow('PEON', 'default:empsecuritycredentials', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:apprreqcandidates'));
                            $acl->allow('PEON', 'default:apprreqcandidates', array('index','viewpopup','index','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppersonaldetails'));
                            $acl->allow('PEON', 'default:emppersonaldetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeedocs'));
                            $acl->allow('PEON', 'default:employeedocs', array('index','view','save','update','uploadsave','uploaddelete','downloadfiles','index','view','save','delete','edit','update','uploadsave','uploaddelete','downloadfiles'));

		 $acl->addResource(new Zend_Acl_Resource('default:empcommunicationdetails'));
                            $acl->allow('PEON', 'default:empcommunicationdetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:trainingandcertificationdetails'));
                            $acl->allow('PEON', 'default:trainingandcertificationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:experiencedetails'));
                            $acl->allow('PEON', 'default:experiencedetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationdetails'));
                            $acl->allow('PEON', 'default:educationdetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:medicalclaims'));
                            $acl->allow('PEON', 'default:medicalclaims', array('index','addpopup','viewpopup','editpopup','view','index','edit','addpopup','viewpopup','editpopup','delete','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleaves'));
                            $acl->allow('PEON', 'default:empleaves', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empskills'));
                            $acl->allow('PEON', 'default:empskills', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:disabilitydetails'));
                            $acl->allow('PEON', 'default:disabilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydetails'));
                            $acl->allow('PEON', 'default:workeligibilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empadditionaldetails'));
                            $acl->allow('PEON', 'default:empadditionaldetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:visaandimmigrationdetails'));
                            $acl->allow('PEON', 'default:visaandimmigrationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:creditcarddetails'));
                            $acl->allow('PEON', 'default:creditcarddetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:dependencydetails'));
                            $acl->allow('PEON', 'default:dependencydetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empholidays'));
                            $acl->allow('PEON', 'default:empholidays', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empjobhistory'));
                            $acl->allow('PEON', 'default:empjobhistory', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:assetdetails'));
                            $acl->allow('PEON', 'default:assetdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsalarydetails'));
                            $acl->allow('PEON', 'default:empsalarydetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:logmanager'));
                            $acl->allow('PEON', 'default:logmanager', array('index','view','empnamewithidauto','index','view','empnamewithidauto'));

		 $acl->addResource(new Zend_Acl_Resource('default:userloginlog'));
                            $acl->allow('PEON', 'default:userloginlog', array('index','empnameauto','empidauto','empipaddressauto','empemailauto','index','empnameauto','empidauto','empipaddressauto','empemailauto'));
}if($role == 18 )
           {
		 $acl->addResource(new Zend_Acl_Resource('default:addemployeeleaves'));
                            $acl->allow('Gardener', 'default:addemployeeleaves', array('index','view','Add Employee Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:attendancestatuscode'));
                            $acl->allow('Gardener', 'default:attendancestatuscode', array('index','view','Attendance Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:bankaccounttype'));
                            $acl->allow('Gardener', 'default:bankaccounttype', array('index','addpopup','view','Bank Account Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:clients'));
                            $acl->allow('Gardener', 'default:clients', array('index','addpopup','view','Clients'));

		 $acl->addResource(new Zend_Acl_Resource('default:competencylevel'));
                            $acl->allow('Gardener', 'default:competencylevel', array('index','addpopup','view','Competency Levels'));

		 $acl->addResource(new Zend_Acl_Resource('default:dashboard'));
                        $acl->allow('Gardener', 'default:dashboard', array('index','saveuserdashboard','getwidgtes','upgradeapplication','emailsettings','changepassword','editpassword','update','uploadpreview','viewprofile','viewsettings','savemenuwidgets','getmenuname','fetchmenuname','getnavids','getopeningpositondate','menuwork','employeeimageupdate'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationlevelcode'));
                            $acl->allow('Gardener', 'default:educationlevelcode', array('index','view','Education Levels'));

		 $acl->addResource(new Zend_Acl_Resource('default:eeoccategory'));
                            $acl->allow('Gardener', 'default:eeoccategory', array('index','view','EEOC Categories'));

		 $acl->addResource(new Zend_Acl_Resource('default:empconfiguration'));
                            $acl->allow('Gardener', 'default:empconfiguration', array('index','Employee Tabs'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleavesummary'));
                            $acl->allow('Gardener', 'default:empleavesummary', array('index','statusid','view','Employee Leaves Summary'));

		 $acl->addResource(new Zend_Acl_Resource('default:employee'));
                            $acl->allow('Gardener', 'default:employee', array('getemprequi','index','changeorghead','getdepartments','getpositions','getempreportingmanagers','makeactiveinactive','changereportingmanager','addemppopup','uploadexcel','getindividualempdetails','view','Employees'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeeleavetypes'));
                            $acl->allow('Gardener', 'default:employeeleavetypes', array('index','view','Leave Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:employmentstatus'));
                            $acl->allow('Gardener', 'default:employmentstatus', array('index','addpopup','view','Employment Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaydates'));
                            $acl->allow('Gardener', 'default:holidaydates', array('index','addpopup','viewpopup','editpopup','view','Manage Holidays'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaygroups'));
                            $acl->allow('Gardener', 'default:holidaygroups', array('index','getempnames','getholidaynames','addpopup','view','Manage Holiday Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:identitydocuments'));
                            $acl->allow('Gardener', 'default:identitydocuments', array('index','view','Identity Documents'));

		 $acl->addResource(new Zend_Acl_Resource('default:index'));
                        $acl->allow('Gardener', 'default:index', array('index','loginpopupsave','logout','clearsessionarray','forcelogout','browserfailure','sendpassword','updatecontactnumber','getstates','getstatesnormal','getcities','getcitiesnormal','getdepartments','getpositions','gettargetcurrency','calculatedays','calculatebusinessdays','calculatecalendardays','fromdatetodate','fromdatetodateorg','validateorgheadjoiningdate','medicalclaimdates','gettimeformat','chkcurrenttime','popup','createorremoveshortcut','sessiontour','getissuingauthority','setsessionval','checkisactivestatus','updatetheme','welcome','getmultidepts','getmultiemps'));

		 $acl->addResource(new Zend_Acl_Resource('default:jobtitles'));
                            $acl->allow('Gardener', 'default:jobtitles', array('index','addpopup','view','Job Titles'));

		 $acl->addResource(new Zend_Acl_Resource('default:language'));
                            $acl->allow('Gardener', 'default:language', array('index','addpopup','view','Languages'));

		 $acl->addResource(new Zend_Acl_Resource('default:leavemanagement'));
                            $acl->allow('Gardener', 'default:leavemanagement', array('index','view','Leave Management Options'));

		 $acl->addResource(new Zend_Acl_Resource('default:militaryservice'));
                            $acl->allow('Gardener', 'default:militaryservice', array('index','view','Military Service Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:payfrequency'));
                            $acl->allow('Gardener', 'default:payfrequency', array('index','addpopup','view','Pay Frequency'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollcategory'));
                            $acl->allow('Gardener', 'default:payrollcategory', array('index','validate','view','Manage Payroll Category'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollgroup'));
                            $acl->allow('Gardener', 'default:payrollgroup', array('index','view','Manage Payroll Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipemployee'));
                            $acl->allow('Gardener', 'default:payslipemployee', array('index','generate','generatebulk','view','Generate Payslip Individual Employee'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipgroup'));
                            $acl->allow('Gardener', 'default:payslipgroup', array('index','generate','view','Generate Payslip for Payroll Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:positions'));
                            $acl->allow('Gardener', 'default:positions', array('index','addpopup','view','Positions'));

		 $acl->addResource(new Zend_Acl_Resource('default:projects'));
                            $acl->allow('Gardener', 'default:projects', array('index','viewpopup','editpopup','view','Projects'));

		 $acl->addResource(new Zend_Acl_Resource('default:remunerationbasis'));
                            $acl->allow('Gardener', 'default:remunerationbasis', array('index','view','Remuneration Basis'));

		 $acl->addResource(new Zend_Acl_Resource('default:roles'));
                            $acl->allow('Gardener', 'default:roles', array('index','saveupdate','getgroupmenu','view','Roles & Privileges'));

		 $acl->addResource(new Zend_Acl_Resource('default:usermanagement'));
                            $acl->allow('Gardener', 'default:usermanagement', array('index','saveupdate','getemailofuser','view','External Users'));

		 $acl->addResource(new Zend_Acl_Resource('default:vendors'));
                            $acl->allow('Gardener', 'default:vendors', array('index','addpopup','view','Vendors'));

		 $acl->addResource(new Zend_Acl_Resource('default:veteranstatus'));
                            $acl->allow('Gardener', 'default:veteranstatus', array('index','view','Veteran Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydoctypes'));
                            $acl->allow('Gardener', 'default:workeligibilitydoctypes', array('index','addpopup','view','Work Eligibility Document Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:processes'));
                            $acl->allow('Gardener', 'default:processes', array('index','addpopup','editpopup','viewpopup','savecomments','displaycomments','savefeedback','index','addpopup','editpopup','viewpopup','delete','savecomments','displaycomments','savefeedback'));

		 $acl->addResource(new Zend_Acl_Resource('default:interviewrounds'));
                            $acl->allow('Gardener', 'default:interviewrounds', array('index','addpopup','editpopup','viewpopup','index','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empperformanceappraisal'));
                            $acl->allow('Gardener', 'default:empperformanceappraisal', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppayslips'));
                            $acl->allow('Gardener', 'default:emppayslips', array('index','view','printslip','salarydetails','index','edit','view','printslip','salarydetails'));

		 $acl->addResource(new Zend_Acl_Resource('default:empbenefits'));
                            $acl->allow('Gardener', 'default:empbenefits', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emprequisitiondetails'));
                            $acl->allow('Gardener', 'default:emprequisitiondetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empremunerationdetails'));
                            $acl->allow('Gardener', 'default:empremunerationdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsecuritycredentials'));
                            $acl->allow('Gardener', 'default:empsecuritycredentials', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:apprreqcandidates'));
                            $acl->allow('Gardener', 'default:apprreqcandidates', array('index','viewpopup','index','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppersonaldetails'));
                            $acl->allow('Gardener', 'default:emppersonaldetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeedocs'));
                            $acl->allow('Gardener', 'default:employeedocs', array('index','view','save','update','uploadsave','uploaddelete','downloadfiles','index','view','save','delete','edit','update','uploadsave','uploaddelete','downloadfiles'));

		 $acl->addResource(new Zend_Acl_Resource('default:empcommunicationdetails'));
                            $acl->allow('Gardener', 'default:empcommunicationdetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:trainingandcertificationdetails'));
                            $acl->allow('Gardener', 'default:trainingandcertificationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:experiencedetails'));
                            $acl->allow('Gardener', 'default:experiencedetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationdetails'));
                            $acl->allow('Gardener', 'default:educationdetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:medicalclaims'));
                            $acl->allow('Gardener', 'default:medicalclaims', array('index','addpopup','viewpopup','editpopup','view','index','edit','addpopup','viewpopup','editpopup','delete','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleaves'));
                            $acl->allow('Gardener', 'default:empleaves', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empskills'));
                            $acl->allow('Gardener', 'default:empskills', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:disabilitydetails'));
                            $acl->allow('Gardener', 'default:disabilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydetails'));
                            $acl->allow('Gardener', 'default:workeligibilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empadditionaldetails'));
                            $acl->allow('Gardener', 'default:empadditionaldetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:visaandimmigrationdetails'));
                            $acl->allow('Gardener', 'default:visaandimmigrationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:creditcarddetails'));
                            $acl->allow('Gardener', 'default:creditcarddetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:dependencydetails'));
                            $acl->allow('Gardener', 'default:dependencydetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empholidays'));
                            $acl->allow('Gardener', 'default:empholidays', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empjobhistory'));
                            $acl->allow('Gardener', 'default:empjobhistory', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:assetdetails'));
                            $acl->allow('Gardener', 'default:assetdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsalarydetails'));
                            $acl->allow('Gardener', 'default:empsalarydetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:logmanager'));
                            $acl->allow('Gardener', 'default:logmanager', array('index','view','empnamewithidauto','index','view','empnamewithidauto'));

		 $acl->addResource(new Zend_Acl_Resource('default:userloginlog'));
                            $acl->allow('Gardener', 'default:userloginlog', array('index','empnameauto','empidauto','empipaddressauto','empemailauto','index','empnameauto','empidauto','empipaddressauto','empemailauto'));
}if($role == 19 )
           {
		 $acl->addResource(new Zend_Acl_Resource('default:accountclasstype'));
                            $acl->allow('managers', 'default:accountclasstype', array('index','addpopup','saveupdate','add','edit','delete','view','Account Class Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:addemployeeleaves'));
                            $acl->allow('managers', 'default:addemployeeleaves', array('index','add','edit','view','Add Employee Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:announcements'));
                            $acl->allow('managers', 'default:announcements', array('index','getdepts','uploadsave','uploaddelete','add','edit','delete','view','Announcements'));

		 $acl->addResource(new Zend_Acl_Resource('default:attendancestatuscode'));
                            $acl->allow('managers', 'default:attendancestatuscode', array('index','add','edit','delete','view','Attendance Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:bankaccounttype'));
                            $acl->allow('managers', 'default:bankaccounttype', array('index','addpopup','add','edit','delete','view','Bank Account Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:businessunits'));
                            $acl->allow('managers', 'default:businessunits', array('index','getdeptnames','add','edit','delete','view','Business Units'));

		 $acl->addResource(new Zend_Acl_Resource('default:categories'));
                            $acl->allow('managers', 'default:categories', array('index','addnewcategory','add','edit','delete','view','Manage Categories'));

		 $acl->addResource(new Zend_Acl_Resource('default:cities'));
                            $cities_add = 'yes';
                                if($this->id_param == '' && $cities_add == 'yes')
                                    $acl->allow('managers','default:cities', array('index','getcitiescand','addpopup','addnewcity','add','delete','view','Cities','edit'));

                                else
                                    $acl->allow('managers','default:cities', array('index','getcitiescand','addpopup','addnewcity','add','delete','view','Cities'));

                                
		 $acl->addResource(new Zend_Acl_Resource('default:clients'));
                            $acl->allow('managers', 'default:clients', array('index','addpopup','add','edit','delete','view','Clients'));

		 $acl->addResource(new Zend_Acl_Resource('default:competencylevel'));
                            $acl->allow('managers', 'default:competencylevel', array('index','addpopup','add','edit','delete','view','Competency Levels'));

		 $acl->addResource(new Zend_Acl_Resource('default:countries'));
                            $countries_add = 'yes';
                if($this->id_param == '' && $countries_add == 'yes')
                    $acl->allow('managers','default:countries', array('index','saveupdate','getcountrycode','addpopup','addnewcountry','add','delete','view','Countries','edit'));

                else
                    $acl->allow('managers','default:countries', array('index','saveupdate','getcountrycode','addpopup','addnewcountry','add','delete','view','Countries'));

                                
		 $acl->addResource(new Zend_Acl_Resource('default:currency'));
                            $acl->allow('managers', 'default:currency', array('index','addpopup','gettargetcurrency','add','edit','delete','view','Currencies'));

		 $acl->addResource(new Zend_Acl_Resource('default:currencyconverter'));
                            $acl->allow('managers', 'default:currencyconverter', array('index','add','edit','delete','view','Currency Conversions'));

		 $acl->addResource(new Zend_Acl_Resource('default:dashboard'));
                        $acl->allow('managers', 'default:dashboard', array('index','saveuserdashboard','getwidgtes','upgradeapplication','emailsettings','changepassword','editpassword','update','uploadpreview','viewprofile','viewsettings','savemenuwidgets','getmenuname','fetchmenuname','getnavids','getopeningpositondate','menuwork','employeeimageupdate'));

		 $acl->addResource(new Zend_Acl_Resource('default:departments'));
                            $acl->allow('managers', 'default:departments', array('index','viewpopup','editpopup','getdepartments','getempnames','add','edit','delete','view','Departments'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryallincidents'));
                            $acl->allow('managers', 'default:disciplinaryallincidents', array('index','view','All Incidents'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryincident'));
                            $acl->allow('managers', 'default:disciplinaryincident', array('index','getemployees','add','edit','delete','view','Raise An Incident'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinarymyincidents'));
                            $acl->allow('managers', 'default:disciplinarymyincidents', array('index','saveemployeeappeal','getdisciplinaryincidentpdf','edit','view','My Incidents'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryteamincidents'));
                            $acl->allow('managers', 'default:disciplinaryteamincidents', array('index','view','Team Incidents'));

		 $acl->addResource(new Zend_Acl_Resource('default:disciplinaryviolation'));
                            $acl->allow('managers', 'default:disciplinaryviolation', array('index','addpopup','add','edit','delete','view','Violation Type'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationlevelcode'));
                            $acl->allow('managers', 'default:educationlevelcode', array('index','add','edit','delete','view','Education Levels'));

		 $acl->addResource(new Zend_Acl_Resource('default:eeoccategory'));
                            $acl->allow('managers', 'default:eeoccategory', array('index','add','edit','delete','view','EEOC Categories'));

		 $acl->addResource(new Zend_Acl_Resource('default:emailcontacts'));
                            $acl->allow('managers', 'default:emailcontacts', array('index','getgroupoptions','getmailcnt','add','edit','delete','view','Email Contacts'));

		 $acl->addResource(new Zend_Acl_Resource('default:empconfiguration'));
                            $acl->allow('managers', 'default:empconfiguration', array('index','edit','Employee Tabs'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleavesummary'));
                            $acl->allow('managers', 'default:empleavesummary', array('index','statusid','view','Employee Leaves Summary'));

		 $acl->addResource(new Zend_Acl_Resource('default:employee'));
                            $acl->allow('managers', 'default:employee', array('getemprequi','index','changeorghead','getdepartments','getpositions','getempreportingmanagers','makeactiveinactive','changereportingmanager','addemppopup','uploadexcel','getindividualempdetails','add','edit','view','Employees'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeeleavetypes'));
                            $acl->allow('managers', 'default:employeeleavetypes', array('index','add','edit','delete','view','Leave Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:employmentstatus'));
                            $acl->allow('managers', 'default:employmentstatus', array('index','addpopup','add','edit','delete','view','Employment Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:ethniccode'));
                            $acl->allow('managers', 'default:ethniccode', array('index','saveupdate','addpopup','add','edit','delete','view','Ethnic Codes'));

		 $acl->addResource(new Zend_Acl_Resource('default:gender'));
                            $acl->allow('managers', 'default:gender', array('index','saveupdate','addpopup','add','edit','delete','view','Gender'));

		 $acl->addResource(new Zend_Acl_Resource('default:geographygroup'));
                            $acl->allow('managers', 'default:geographygroup', array('index','add','edit','delete','view','Geo Groups'));

		 $acl->addResource(new Zend_Acl_Resource('default:heirarchy'));
                            $acl->allow('managers', 'default:heirarchy', array('index','addlist','editlist','saveadddata','saveeditdata','deletelist','add','edit','view','Organization Hierarchy'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaydates'));
                            $acl->allow('managers', 'default:holidaydates', array('index','addpopup','viewpopup','editpopup','add','edit','delete','view','Manage Holidays'));

		 $acl->addResource(new Zend_Acl_Resource('default:holidaygroups'));
                            $acl->allow('managers', 'default:holidaygroups', array('index','getempnames','getholidaynames','addpopup','add','edit','delete','view','Manage Holiday Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:identitycodes'));
                            $acl->allow('managers', 'default:identitycodes', array('index','addpopup','add','edit','Identity Codes'));

		 $acl->addResource(new Zend_Acl_Resource('default:identitydocuments'));
                            $acl->allow('managers', 'default:identitydocuments', array('index','add','edit','delete','view','Identity Documents'));

		 $acl->addResource(new Zend_Acl_Resource('default:index'));
                        $acl->allow('managers', 'default:index', array('index','loginpopupsave','logout','clearsessionarray','forcelogout','browserfailure','sendpassword','updatecontactnumber','getstates','getstatesnormal','getcities','getcitiesnormal','getdepartments','getpositions','gettargetcurrency','calculatedays','calculatebusinessdays','calculatecalendardays','fromdatetodate','fromdatetodateorg','validateorgheadjoiningdate','medicalclaimdates','gettimeformat','chkcurrenttime','popup','createorremoveshortcut','sessiontour','getissuingauthority','setsessionval','checkisactivestatus','updatetheme','welcome','getmultidepts','getmultiemps'));

		 $acl->addResource(new Zend_Acl_Resource('default:jobtitles'));
                            $acl->allow('managers', 'default:jobtitles', array('index','addpopup','add','edit','delete','view','Job Titles'));

		 $acl->addResource(new Zend_Acl_Resource('default:language'));
                            $acl->allow('managers', 'default:language', array('index','addpopup','add','edit','delete','view','Languages'));

		 $acl->addResource(new Zend_Acl_Resource('default:leavemanagement'));
                            $acl->allow('managers', 'default:leavemanagement', array('index','add','edit','delete','view','Leave Management Options'));

		 $acl->addResource(new Zend_Acl_Resource('default:leaverequest'));
                            $leaverequest_add = 'yes';
                                if($this->id_param == '' && $leaverequest_add == 'yes')
                                    $acl->allow('managers','default:leaverequest', array('index','saveleaverequestdetails','gethalfdaydetails','editpopup','updateleavedetails','add','Leave Request','edit'));

                                else
                                    $acl->allow('managers','default:leaverequest', array('index','saveleaverequestdetails','gethalfdaydetails','editpopup','updateleavedetails','add','Leave Request'));

                                
		 $acl->addResource(new Zend_Acl_Resource('default:licensetype'));
                            $acl->allow('managers', 'default:licensetype', array('index','add','edit','delete','view','License Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:managemenus'));
                            $acl->allow('managers', 'default:managemenus', array('index','save','add','edit','delete','view','Modules'));

		 $acl->addResource(new Zend_Acl_Resource('default:manageremployeevacations'));
                            $acl->allow('managers', 'default:manageremployeevacations', array('index','edit','view','Manager Employee Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:maritalstatus'));
                            $acl->allow('managers', 'default:maritalstatus', array('index','saveupdate','addpopup','add','edit','delete','view','Marital Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:militaryservice'));
                            $acl->allow('managers', 'default:militaryservice', array('index','add','edit','delete','view','Military Service Types'));

		 $acl->addResource(new Zend_Acl_Resource('default:mydetails'));
                            $acl->allow('managers', 'default:mydetails', array('index','personaldetailsview','personal','communicationdetailsview','communication','skills','education','experience','leaves','holidays','salarydetailsview','certification','creditcarddetailsview','creditcard','visadetailsview','visa','medicalclaims','disabilitydetailsview','disability','dependency','workeligibilitydetailsview','workeligibility','additionaldetailsedit','jobhistory','documents','assetdetailsview','add','edit','delete','view','My Details','emppayslip'));

		 $acl->addResource(new Zend_Acl_Resource('default:myemployees'));
                            $acl->allow('managers', 'default:myemployees', array('index','perview','comview','skillsview','expview','eduview','trainingview','additionaldetailsview','jobhistoryview','skillsedit','jobhistoryedit','expedit','eduedit','trainingedit','additionaldetailsedit','peredit','comedit','docview','docedit','employeereport','getempreportdata','empauto','emprptpdf','exportemployeereport','downloadreport','view','My Team'));

		 $acl->addResource(new Zend_Acl_Resource('default:myholidaycalendar'));
                            $acl->allow('managers', 'default:myholidaycalendar', array('index','view','My Holiday Calendar'));

		 $acl->addResource(new Zend_Acl_Resource('default:nationality'));
                            $acl->allow('managers', 'default:nationality', array('index','addpopup','add','edit','delete','view','Nationalities'));

		 $acl->addResource(new Zend_Acl_Resource('default:nationalitycontextcode'));
                            $acl->allow('managers', 'default:nationalitycontextcode', array('index','add','edit','delete','view','Nationality Context Codes'));

		 $acl->addResource(new Zend_Acl_Resource('default:numberformats'));
                            $acl->allow('managers', 'default:numberformats', array('index','add','edit','delete','view','Number Formats'));

		 $acl->addResource(new Zend_Acl_Resource('default:organisationinfo'));
                            $acl->allow('managers', 'default:organisationinfo', array('index','edit_old','saveupdate','uploadpreview','validateorgstartdate','getcompleteorgdata','addorghead','add','edit','view','Organization Info'));

		 $acl->addResource(new Zend_Acl_Resource('default:payfrequency'));
                            $acl->allow('managers', 'default:payfrequency', array('index','addpopup','add','edit','delete','view','Pay Frequency'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollcategory'));
                            $acl->allow('managers', 'default:payrollcategory', array('index','validate','add','edit','delete','view','Manage Payroll Category'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollgroup'));
                            $acl->allow('managers', 'default:payrollgroup', array('index','add','edit','delete','view','Manage Payroll Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipemployee'));
                            $acl->allow('managers', 'default:payslipemployee', array('index','generate','generatebulk','add','edit','delete','view','Generate Payslip Individual Employee'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipgroup'));
                            $acl->allow('managers', 'default:payslipgroup', array('index','generate','add','edit','delete','view','Generate Payslip for Payroll Group'));

		 $acl->addResource(new Zend_Acl_Resource('default:pendingleaves'));
                            $acl->allow('managers', 'default:pendingleaves', array('index','delete','view','My Leaves'));

		 $acl->addResource(new Zend_Acl_Resource('default:policydocuments'));
                            $acl->allow('managers', 'default:policydocuments', array('index','uploaddoc','deletedocument','addmultiple','uploadmultipledocs','add','edit','delete','view','View/Manage Policy Documents'));

		 $acl->addResource(new Zend_Acl_Resource('default:positions'));
                            $acl->allow('managers', 'default:positions', array('index','addpopup','add','edit','delete','view','Positions'));

		 $acl->addResource(new Zend_Acl_Resource('default:prefix'));
                            $acl->allow('managers', 'default:prefix', array('index','saveupdate','addpopup','add','edit','delete','view','Prefixes'));

		 $acl->addResource(new Zend_Acl_Resource('default:projects'));
                            $acl->allow('managers', 'default:projects', array('index','viewpopup','editpopup','add','edit','delete','view','Projects'));

		 $acl->addResource(new Zend_Acl_Resource('default:racecode'));
                            $acl->allow('managers', 'default:racecode', array('index','saveupdate','addpopup','add','edit','delete','view','Race Codes'));

		 $acl->addResource(new Zend_Acl_Resource('default:remunerationbasis'));
                            $acl->allow('managers', 'default:remunerationbasis', array('index','add','edit','delete','view','Remuneration Basis'));

		 $acl->addResource(new Zend_Acl_Resource('default:reports'));
                            $acl->allow('managers', 'default:reports', array('getrolepopup','emprolesgrouppopup','performancereport','previousappraisals','getselectedappraisaldata','getinterviewroundsdata','interviewrounds','rolesgroup','exportemprolesgroup','exportrolesgroupreport','exportinterviewrpt','exportactiveuserrpt','exportemployeereport','rolesgrouprptpdf','activeuserrptpdf','emprptpdf','interviewrptpdf','rolesgroupdata','emprolesgroup','emprolesgroupdata','activeuser','getactiveuserdata','getempreportdata','empauto','servicedeskreport','getsddata','servicedeskpdf','servicedeskexcel','employeereport','getdeptsemp','index','holidaygroupreports','getpdfreportholiday','getexcelreportholiday','leavesreport','getpdfreportleaves','getexcelreportleaves','leavesreporttabheader','leavemanagementreport','getpdfreportleavemanagement','getexcelreportleavemanagement','bunitauto','bunitcodeauto','getexcelreportbusinessunit','getbusinessunitspdf','businessunits','userlogreport','departments','exportdepartmentpdf','getexcelreportdepartment','candidaterptexcel','candidaterptpdf','getcandidatesreportdata','candidatesreport','requisitionauto','requisitionrptexcel','requisitionrptpdf','getrequisitionsstatusreportdata','requisitionstatusreport','activitylogreport','downloadreport','agencylistreport','agencynameauto','agencysebsiteauto','empscreening','getspecimennames','getagencynames','getexcelreportempscreening','getempscreeningpdf','add','edit','delete','view','Analytics'));

		 $acl->addResource(new Zend_Acl_Resource('default:roles'));
                            $acl->allow('managers', 'default:roles', array('index','saveupdate','getgroupmenu','add','edit','delete','view','Roles & Privileges'));

		 $acl->addResource(new Zend_Acl_Resource('default:sitepreference'));
                            $acl->allow('managers', 'default:sitepreference', array('index','view','add','edit','Site Preferences'));

		 $acl->addResource(new Zend_Acl_Resource('default:states'));
                            $states_add = 'yes';
                                if($this->id_param == '' && $states_add == 'yes')
                                    $acl->allow('managers','default:states', array('index','getstates','getstatescand','addpopup','addnewstate','add','delete','view','States','edit'));

                                else
                                    $acl->allow('managers','default:states', array('index','getstates','getstatescand','addpopup','addnewstate','add','delete','view','States'));

                                
		 $acl->addResource(new Zend_Acl_Resource('default:structure'));
                            $acl->allow('managers', 'default:structure', array('index','Organization Structure'));

		 $acl->addResource(new Zend_Acl_Resource('default:timezone'));
                            $acl->allow('managers', 'default:timezone', array('index','saveupdate','addpopup','add','edit','delete','view','Time Zones'));

		 $acl->addResource(new Zend_Acl_Resource('default:usermanagement'));
                            $acl->allow('managers', 'default:usermanagement', array('index','saveupdate','getemailofuser','add','edit','view','External Users'));

		 $acl->addResource(new Zend_Acl_Resource('default:vendors'));
                            $acl->allow('managers', 'default:vendors', array('index','addpopup','add','edit','delete','view','Vendors'));

		 $acl->addResource(new Zend_Acl_Resource('default:veteranstatus'));
                            $acl->allow('managers', 'default:veteranstatus', array('index','add','edit','delete','view','Veteran Status'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydoctypes'));
                            $acl->allow('managers', 'default:workeligibilitydoctypes', array('index','addpopup','add','edit','delete','view','Work Eligibility Document Types'));

		 $acl->addResource(new Zend_Acl_Resource('assets:assetcategories'));
                            $acl->allow('managers', 'assets:assetcategories', array('index','addpopup','addsubcatpopup','assetuserlog','add','edit','delete','view','Asset Categories'));

		 $acl->addResource(new Zend_Acl_Resource('assets:assets'));
                            $acl->allow('managers', 'assets:assets', array('index','uploadsave','uploaddelete','getsubcategories','deleteimage','downloadimage','getemployeesdata','add','edit','delete','view','Assets'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:advances'));
                            $acl->allow('managers', 'expenses:advances', array('index','getprojects','myadvances','viewmoreadvances','clearadvancesdata','addreturnpopup','Advances'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:employeeadvances'));
                            $acl->allow('managers', 'expenses:employeeadvances', array('index','view','Employee Advances'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:expensecategories'));
                            $acl->allow('managers', 'expenses:expensecategories', array('index','add','edit','delete','view','Category'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:expenses'));
                            $acl->allow('managers', 'expenses:expenses', array('index','clone','view','addpopup','uploadsave','uploaddelete','displayreceipts','addtrippopup','submitexpense','addreceiptimage','expensestatus','listreportingmangers','viewmoremanagers','forwardexpenseto','downloadexpensepdf','bulkexpenses','getcategories','getprojects','getcurrency','uploadedfiles','Expenses'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:myemployeeexpenses'));
                            $acl->allow('managers', 'expenses:myemployeeexpenses', array('index','view','My Employee Expenses'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:paymentmode'));
                            $acl->allow('managers', 'expenses:paymentmode', array('index','add','edit','delete','view','Payment Mode'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:receipts'));
                            $acl->allow('managers', 'expenses:receipts', array('index','downloadreceipt','downloadexpensereceipt','deletereceipt','uploadsave','displayreceipts','viewmorereceipts','listexpenses','addreceipttoexpense','viewmoreexpenses','cleardata','showreceiptspopup','listtrips','viewmoretrips','addexpensetotrip','Receipts'));

		 $acl->addResource(new Zend_Acl_Resource('expenses:trips'));
                            $acl->allow('managers', 'expenses:trips', array('index','view','addpopup','tripstatus','deleteexpense','downloadtrippdf','Trips'));

		 $acl->addResource(new Zend_Acl_Resource('default:processes'));
                            $acl->allow('managers', 'default:processes', array('index','addpopup','editpopup','viewpopup','savecomments','displaycomments','savefeedback','index','addpopup','editpopup','viewpopup','delete','savecomments','displaycomments','savefeedback'));

		 $acl->addResource(new Zend_Acl_Resource('default:interviewrounds'));
                            $acl->allow('managers', 'default:interviewrounds', array('index','addpopup','editpopup','viewpopup','index','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empperformanceappraisal'));
                            $acl->allow('managers', 'default:empperformanceappraisal', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppayslips'));
                            $acl->allow('managers', 'default:emppayslips', array('index','view','printslip','salarydetails','index','edit','view','printslip','salarydetails'));

		 $acl->addResource(new Zend_Acl_Resource('default:empbenefits'));
                            $acl->allow('managers', 'default:empbenefits', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:emprequisitiondetails'));
                            $acl->allow('managers', 'default:emprequisitiondetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empremunerationdetails'));
                            $acl->allow('managers', 'default:empremunerationdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsecuritycredentials'));
                            $acl->allow('managers', 'default:empsecuritycredentials', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:apprreqcandidates'));
                            $acl->allow('managers', 'default:apprreqcandidates', array('index','viewpopup','index','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:emppersonaldetails'));
                            $acl->allow('managers', 'default:emppersonaldetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:employeedocs'));
                            $acl->allow('managers', 'default:employeedocs', array('index','view','save','update','uploadsave','uploaddelete','downloadfiles','index','view','save','delete','edit','update','uploadsave','uploaddelete','downloadfiles'));

		 $acl->addResource(new Zend_Acl_Resource('default:empcommunicationdetails'));
                            $acl->allow('managers', 'default:empcommunicationdetails', array('index','view','index','view','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:trainingandcertificationdetails'));
                            $acl->allow('managers', 'default:trainingandcertificationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:experiencedetails'));
                            $acl->allow('managers', 'default:experiencedetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:educationdetails'));
                            $acl->allow('managers', 'default:educationdetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:medicalclaims'));
                            $acl->allow('managers', 'default:medicalclaims', array('index','addpopup','viewpopup','editpopup','view','index','edit','addpopup','viewpopup','editpopup','delete','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empleaves'));
                            $acl->allow('managers', 'default:empleaves', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empskills'));
                            $acl->allow('managers', 'default:empskills', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:disabilitydetails'));
                            $acl->allow('managers', 'default:disabilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:workeligibilitydetails'));
                            $acl->allow('managers', 'default:workeligibilitydetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empadditionaldetails'));
                            $acl->allow('managers', 'default:empadditionaldetails', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:visaandimmigrationdetails'));
                            $acl->allow('managers', 'default:visaandimmigrationdetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:creditcarddetails'));
                            $acl->allow('managers', 'default:creditcarddetails', array('index','view','index','add','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:dependencydetails'));
                            $acl->allow('managers', 'default:dependencydetails', array('index','view','addpopup','editpopup','viewpopup','index','edit','view','addpopup','editpopup','viewpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:empholidays'));
                            $acl->allow('managers', 'default:empholidays', array('index','view','viewpopup','index','edit','view','viewpopup'));

		 $acl->addResource(new Zend_Acl_Resource('default:empjobhistory'));
                            $acl->allow('managers', 'default:empjobhistory', array('index','view','addpopup','viewpopup','editpopup','index','edit','view','addpopup','viewpopup','editpopup','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:assetdetails'));
                            $acl->allow('managers', 'default:assetdetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:empsalarydetails'));
                            $acl->allow('managers', 'default:empsalarydetails', array('index','view','index','edit','view'));

		 $acl->addResource(new Zend_Acl_Resource('default:logmanager'));
                            $acl->allow('managers', 'default:logmanager', array('index','view','empnamewithidauto','index','view','empnamewithidauto'));

		 $acl->addResource(new Zend_Acl_Resource('default:userloginlog'));
                            $acl->allow('managers', 'default:userloginlog', array('index','empnameauto','empidauto','empipaddressauto','empemailauto','index','empnameauto','empidauto','empipaddressauto','empemailauto'));
                            $acl->addResource(new Zend_Acl_Resource('default:payrollcategory'));
                    $acl->allow('admin', 'default:payrollcategory', array('index','add','validate','delete','edit'));

		 $acl->addResource(new Zend_Acl_Resource('default:payrollgroup'));
                    $acl->allow('admin', 'default:payrollgroup', array('index','add','edit','delete'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipemployee'));
                    $acl->allow('admin', 'default:payslipemployee', array('index','generate','generatebulk'));

		 $acl->addResource(new Zend_Acl_Resource('default:payslipgroup'));
                    $acl->allow('admin', 'default:payslipgroup', array('index','add','generate'));
$acl->addResource(new Zend_Acl_Resource('default:payslipreport'));
                    $acl->allow('admin', 'default:payslipreport', array('index','filter'));
}

     // setup acl in the registry for more
           Zend_Registry::set('acl', $acl);
           $this->_acl = $acl;
    }
   return $this->_acl;
}
  }
  
  ?>