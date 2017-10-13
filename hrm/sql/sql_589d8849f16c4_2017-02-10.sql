ALTER TABLE `main_pa_initialization` ADD `performance_app_flag` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=bu wise,0=dept wise' AFTER `isactive`;

alter table `main_leaverequest` add column `approver_comments` text after `reason`;

alter table `main_leaverequest_summary` add column `approver_comments` text after `reason`;

alter table `main_wizard` add column `departments` tinyint(1) DEFAULT '1' NULL COMMENT '1=No,2=Yes' after `org_details`;

alter table `main_wizard` add column `servicerequest` tinyint(1) DEFAULT '1' NULL COMMENT '1=No,2=Yes' after `departments`;

ALTER TABLE `main_empjobhistory` ADD `client_id` INT NULL AFTER `active_company`, ADD `vendor` VARCHAR(200) NULL AFTER `client_id`, ADD `paid_amount` DECIMAL(25,2) NULL AFTER`vendor`, ADD `received_amount` DECIMAL(25,2) NULL AFTER `paid_amount`;

ALTER TABLE main_empvisadetails DROP INDEX unique_user_id;

CREATE TABLE `main_hr_wizard` (                                         
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,                  
`leavetypes` tinyint(1) DEFAULT '1' COMMENT '1=No,2=Yes',      
`holidays` tinyint(1) DEFAULT '1' COMMENT '1=No,2=Yes',
`perf_appraisal` tinyint(1) DEFAULT '1' COMMENT '1=No,2=Yes',
`iscomplete` tinyint(1) DEFAULT '1' COMMENT '0=later,1=No,2=Yes',  
`createdby` bigint(20) unsigned DEFAULT NULL,                      
`modifiedby` bigint(20) unsigned DEFAULT NULL,                     
`createddate` datetime DEFAULT NULL,                               
`modifieddate` datetime DEFAULT NULL,                              
`isactive` tinyint(1) DEFAULT NULL,                                
PRIMARY KEY (`id`)                                                 
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


insert into main_hr_wizard   (  leavetypes,   holidays,   iscomplete,   createdby,   modifiedby,   createddate,   modifieddate,   isactive  )  values  (   1,   1,   1,   1,   1,   now(),   now(),   1  );

insert  into `main_menu`(`id`,`menuName`,`url`,`helpText`,`toolTip`,`iconPath`,`parent`,`menuOrder`,`nav_ids`,`isactive`,`segment_flag`,`org_menuid`,`menufields`,`menuQuery`,`hasJoins`,`modelName`,`functionName`,`defaultOrderBy`) values
(175,'Appraisal History','/appraisalhistory','Appraisal History','Appraisal History','appraisal_history.jpg',149,7,',149,175,',1,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(176,'Policy Documents','/#','Policy Documents','Policy Documents','policy_documents.jpg',1,7,',1,176,',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(177,'Exit Procedure','/#','Employee Exit Procedure','Employee Exit Procedure','exit_procedure.jpg',4,6,',4,177,',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(178,'Settings','/exitprocsettings','Employee Exit Procedure Settings','Employee Exit Procedure Settings','exit_procedure.jpg',177,1,',4,177,178,',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(179,'Exit Types','/exittypes','Exit Types','Exit Types','exit_types.jpg',177,2,',4,177,178,',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(180,'Initiate/Check Status','/exitproc','Initiate exit proc or check status','Initiate exit proc or check status','initiate_exit_proc.jpg',177,3,',4,177,180,',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(181,'All Exit Procedures','/allexitproc','All exit procedures','All exit procedures','all_exit_proc.jpg',177,4,',4,177,181,',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(182,'Categories','/categories','Categories for Policy documents','Categories for Policy documents','pd_categories.jpg',176,1,',4,176,182,',1,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(183,'View/Manage Policy Documents','/policydocuments','View or Manage Policy documents','View or Manage Policy documents','',176,2,',4,176,183,',1,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(184,'Add Employee Leaves', '/addemployeeleaves', 'Add Employee Leaves', 'Add Employee Leaves', 'addemployeeleaves.jpg', 
17, 3, ',3,17,184', 1, 2, 302, NULL, NULL, NULL, NULL, NULL, NULL);

insert  into `main_privileges`(`role`,`group_id`,`object`,`addpermission`,`editpermission`,`deletepermission`,`viewpermission`,`uploadattachments`, `viewattachments`,`createdby`,`modifiedby`,`createddate`,`modifieddate`,`isactive`) values 
(1,(NULL),175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,1,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,2,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,3,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,4,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,6,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,7,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(1, NULL, 184, 'Yes', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, now(), now(), 1),
(NULL, 1, 184, 'Yes', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, now(), now(), 1),
(NULL, 3, 184, 'Yes', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, now(), now(), 1),
(1,NULL,176,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,now(),now(),1),
(NULL,1,176,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,now(),now(),1),
(NULL,2,176,'No','No','No','Yes','No','Yes',1,1,now(),now(),1),
(NULL,3,176,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,now(),now(),1),
(NULL,4,176,'No','No','No','Yes','No','Yes',NULL,NULL,now(),now(),1),
(NULL,5,176,'No','No','No','No','No','Yes',1,1,now(),now(),0),
(NULL,6,176,'Yes','Yes','Yes','Yes','Yes','Yes',NULL,NULL,now(),now(),1), 
(1,NULL,182,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,now(),now(),1),
(NULL,1,182,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,now(),now(),1),
(NULL,3,182,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,now(),now(),1),
(NULL,6,182,'Yes','Yes','No','Yes','Yes','Yes',NULL,NULL,now(),now(),1),
(1,NULL,183,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,now(),now(),1),
(NULL,1,183,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,now(),now(),1),
(NULL,2,183,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,3,183,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,now(),now(),1),
(NULL,4,183,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,6,183,'Yes','Yes','No','Yes','Yes','Yes',NULL,NULL,now(),now(),1);

update main_pa_initialization a
inner join main_pa_implementation b on a.pa_configured_id=b.id
set a.performance_app_flag=b.performance_app_flag;

UPDATE `main_menu` SET `parent`=NULL,`isactive` = '0' WHERE `main_menu`.`id` = 155 AND `main_menu`.`menuName` ='Appraisal Settings';

update main_privileges set isactive=0 where object=155;

UPDATE `main_menu` SET `parent` = '0', `menuOrder` = '16', `nav_ids` = ',130,',`url` = '/timemanagement' WHERE `main_menu`.`id` = 130;

update main_menu set menuName = 'Self Service',menuOrder=2 where id=4;
update main_menu set menuName = 'Service Request',menuOrder=4 where id=143;
update main_menu set menuName = 'HR',menuOrder=5 where id=3;
update main_menu set menuName = 'Appraisals',menuOrder=6 where id=149;
update main_menu set menuName = 'Talent Acquisition',menuOrder=7 where id=19;
update main_menu set menuName = 'Background Check',menuOrder=8 where id=5;
update main_menu set menuName = 'Site Config',menuOrder=11 where id=70;
update main_menu set menuName = 'Modules',menuOrder=12 where id=142;
update main_menu set menuName = 'Time',menuOrder=16,isactive=1 where id=130;
update main_menu set menuOrder=9 where id=1;
update main_menu set menuOrder=10 where id=8;

UPDATE `main_dateformat` SET `js_dateformat` = 'M-dd-yy' WHERE `main_dateformat`.`id` = 11;

UPDATE `tbl_states` SET `state_name` = 'British Columbia' WHERE `tbl_states`.`id` = 144;

CREATE TABLE `main_pd_categories` (                                     
`id` bigint(20) unsigned NOT NULL auto_increment,                     
`category` varchar(200) NOT NULL,                                     
`description` text,                                                   
`isused` tinyint(4) NOT NULL default '0' COMMENT '0-notused,1-used',  
`isactive` tinyint(4) NOT NULL default '1',                           
`modifiedby` bigint(20) unsigned NOT NULL,                            
`createdby` bigint(20) unsigned NOT NULL,                             
`modifieddate` datetime default NULL,                                 
`createddate` datetime default NULL,                                  
PRIMARY KEY  (`id`)                                                   
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `main_pd_documents` (                                        
`id` bigint(20) unsigned NOT NULL auto_increment,                       
`category_id` bigint(20) unsigned NOT NULL,                             
`subcategory_id` bigint(20) unsigned default NULL COMMENT 'not used ',  
`document_name` varchar(500) NOT NULL,                                  
`document_version` varchar(100) default NULL,                           
`description` text,                                                     
`file_name` text,                                                       
`isactive` tinyint(4) NOT NULL default '1',                             
`modifiedby` bigint(20) unsigned default NULL,                          
`createdby` bigint(20) unsigned default NULL,                           
`modifieddate` datetime default NULL,                                   
`createddate` datetime default NULL,                                    
`flag1` varchar(100) default NULL,                                      
`flag2` varchar(100) default NULL,                                      
PRIMARY KEY  (`id`)                                                     
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `tm_clients` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `client_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(20) default NULL,
  `poc` varchar(100) NOT NULL,
  `address` varchar(200) default NULL,
  `country_id` bigint(20) unsigned default NULL,
  `state_id` bigint(20) unsigned default NULL,
  `fax` varchar(50) default NULL,
  `is_active` tinyint(1) unsigned NOT NULL default '1',
  `created_by` int(10) unsigned NOT NULL,
  `modified_by` int(10) unsigned default NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `modified` timestamp NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_client_country` (`country_id`),
  KEY `FK_client_state` (`state_id`),
  CONSTRAINT `FK_client_country` FOREIGN KEY (`country_id`) REFERENCES `tbl_countries` (`id`),
  CONSTRAINT `FK_client_state` FOREIGN KEY (`state_id`) REFERENCES `tbl_states` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

CREATE TABLE `tm_projects` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `project_name` varchar(100) NOT NULL,
  `project_status` enum('initiated','draft','in-progress','hold','completed') NOT NULL,
  `base_project` bigint(20) default NULL,
  `description` varchar(500) default NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `modified_by` int(10) unsigned default NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `FK_tm_projects_client` (`client_id`),
  CONSTRAINT `FK_tm_projects_client` FOREIGN KEY (`client_id`) REFERENCES `tm_clients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE `tm_tasks` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `task` varchar(200) NOT NULL,
  `is_default` tinyint(1) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `modified_by` int(10) unsigned default NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE `tm_project_tasks` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `project_id` bigint(20) unsigned NOT NULL,
  `task_id` bigint(20) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `modified_by` int(10) unsigned default NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `FK_tm_project_tasks_project` (`project_id`),
  KEY `FK_tm_project_tasks_task` (`task_id`),
  CONSTRAINT `FK_tm_project_tasks_project` FOREIGN KEY (`project_id`) REFERENCES `tm_projects` (`id`),
  CONSTRAINT `FK_tm_project_tasks_task` FOREIGN KEY (`task_id`) REFERENCES `tm_tasks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE `tm_project_task_employees` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `project_id` bigint(20) unsigned NOT NULL,
  `task_id` bigint(20) unsigned NOT NULL,
  `project_task_id` bigint(20) unsigned NOT NULL,
  `emp_id` int(10) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `modified_by` int(10) unsigned default NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `FK_tm_project_task_employees_project` (`project_id`),
  KEY `FK_tm_project_task_employees_task` (`task_id`),
  KEY `FK_tm_project_task_employees_proj_task` (`project_task_id`),
  KEY `FK_tm_project_task_employees_employee` (`emp_id`),
  CONSTRAINT `FK_tm_project_task_employees_employee` FOREIGN KEY (`emp_id`) REFERENCES `main_users` (`id`),
  CONSTRAINT `FK_tm_project_task_employees_proj_task` FOREIGN KEY (`project_task_id`) REFERENCES `tm_project_tasks` (`id`),
  CONSTRAINT `FK_tm_project_task_employees_project` FOREIGN KEY (`project_id`) REFERENCES `tm_projects` (`id`),
  CONSTRAINT `FK_tm_project_task_employees_task` FOREIGN KEY (`task_id`) REFERENCES `tm_tasks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE `tm_project_employees` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `project_id` bigint(20) unsigned NOT NULL,
  `emp_id` int(10) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `modified_by` int(10) unsigned default NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `FK_tm_project_employees_project` (`project_id`),
  KEY `FK_tm_project_employees_employee` (`emp_id`),
  CONSTRAINT `FK_tm_project_employees_employee` FOREIGN KEY (`emp_id`) REFERENCES `main_users` (`id`),
  CONSTRAINT `FK_tm_project_employees_project` FOREIGN KEY (`project_id`) REFERENCES `tm_projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `tm_emp_timesheets` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `emp_id` int(10) unsigned NOT NULL,
  `project_task_id` bigint(20) unsigned default NULL,
  `project_id` bigint(20) unsigned default NULL,
  `ts_year` smallint(4) unsigned NOT NULL,
  `ts_month` tinyint(2) unsigned default NULL,
  `ts_week` tinyint(1) unsigned default NULL,
  `cal_week` tinyint(2) unsigned NOT NULL,
  `sun_date` date default NULL,
  `sun_duration` varchar(6) default NULL,
  `mon_date` date default NULL,
  `mon_duration` varchar(6) default NULL,
  `tue_date` date default NULL,
  `tue_duration` varchar(6) default NULL,
  `wed_date` date default NULL,
  `wed_duration` varchar(6) default NULL,
  `thu_date` date default NULL,
  `thu_duration` varchar(6) default NULL,
  `fri_date` date default NULL,
  `fri_duration` varchar(6) default NULL,
  `sat_date` date default NULL,
  `sat_duration` varchar(6) default NULL,
  `week_duration` varchar(6) default NULL,
  `created_by` int(10) unsigned NOT NULL,
  `modified_by` int(10) default NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `IDX_emp_task_time` (`emp_id`,`project_task_id`,`ts_year`,`ts_month`,`ts_week`,`cal_week`),
  KEY `FK_tm_emp_timesheets_proj_task` (`project_task_id`),
  KEY `FK_tm_emp_timesheets_project` (`project_id`),
  CONSTRAINT `FK_tm_emp_timesheets_employee` FOREIGN KEY (`emp_id`) REFERENCES `main_users` (`id`),
  CONSTRAINT `FK_tm_emp_timesheets_proj_task` FOREIGN KEY (`project_task_id`) REFERENCES `tm_project_tasks` (`id`),
  CONSTRAINT `FK_tm_emp_timesheets_project` FOREIGN KEY (`project_id`) REFERENCES `tm_projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `tm_emp_ts_notes` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `emp_id` int(10) unsigned NOT NULL,
  `ts_year` smallint(4) NOT NULL,
  `ts_month` tinyint(2) default NULL,
  `ts_week` tinyint(1) default NULL,
  `cal_week` tinyint(2) unsigned NOT NULL,
  `sun_date` date NOT NULL,
  `sun_note` varchar(200) default NULL,
  `mon_date` date default NULL,
  `mon_note` varchar(200) default NULL,
  `tue_date` date default NULL,
  `tue_note` varchar(200) default NULL,
  `wed_date` date default NULL,
  `wed_note` varchar(200) default NULL,
  `thu_date` date default NULL,
  `thu_note` varchar(200) default NULL,
  `fri_date` date default NULL,
  `fri_note` varchar(200) default NULL,
  `sat_date` date default NULL,
  `sat_note` varchar(200) default NULL,
  `week_note` varchar(200) default NULL,
  `created_by` int(10) unsigned default NULL,
  `modified_by` int(10) unsigned default NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `IDX_emp_ts_notes` (`emp_id`,`ts_year`,`ts_month`,`ts_week`,`cal_week`),
  CONSTRAINT `FK_tm_emp_ts_notes_employee` FOREIGN KEY (`emp_id`) REFERENCES `main_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `tm_ts_status` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `emp_id` int(10) unsigned NOT NULL,
  `project_id` bigint(20) unsigned default NULL,
  `ts_year` smallint(4) unsigned NOT NULL,
  `ts_month` tinyint(2) unsigned default NULL,
  `ts_week` tinyint(1) unsigned default NULL,
  `cal_week` tinyint(2) default NULL,
  `sun_date` date default NULL,
  `sun_project_status` enum('saved','submitted','no_entry') default NULL,
  `sun_status` enum('saved','submitted','no_entry') default NULL,
  `sun_status_date` timestamp NULL default NULL,
  `mon_date` date default NULL,
  `mon_project_status` enum('saved','submitted','no_entry') default NULL,
  `mon_status` enum('saved','submitted','no_entry') default NULL,
  `mon_status_date` timestamp NULL default NULL,
  `tue_date` date default NULL,
  `tue_project_status` enum('saved','submitted','no_entry') default NULL,
  `tue_status` enum('saved','submitted','no_entry') default NULL,
  `tue_status_date` timestamp NULL default NULL,
  `wed_date` date default NULL,
  `wed_project_status` enum('saved','submitted','no_entry') default NULL,
  `wed_status` enum('saved','submitted','no_entry') default NULL,
  `wed_status_date` timestamp NULL default NULL,
  `thu_date` date default NULL,
  `thu_project_status` enum('saved','submitted','no_entry') default NULL,
  `thu_status` enum('saved','submitted','no_entry') default NULL,
  `thu_status_date` timestamp NULL default NULL,
  `fri_date` date default NULL,
  `fri_project_status` enum('saved','submitted','no_entry') default NULL,
  `fri_status` enum('saved','submitted','no_entry') default NULL,
  `fri_status_date` timestamp NULL default NULL,
  `sat_date` date default NULL,
  `sat_project_status` enum('saved','submitted','no_entry') default NULL,
  `sat_status` enum('saved','submitted','no_entry') default NULL,
  `sat_status_date` timestamp NULL default NULL,
  `week_status` enum('saved','submitted','no_entry') default NULL,
  `created_by` int(10) unsigned default NULL,
  `modified_by` int(10) unsigned default NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `IDX_emp_ts_project_status` (`emp_id`,`project_id`,`ts_year`,`ts_month`,`ts_week`,`cal_week`),
  KEY `FK_tm_ts_status_project` (`project_id`),
  CONSTRAINT `FK_tm_ts_status_employee` FOREIGN KEY (`emp_id`) REFERENCES `main_users` (`id`),
  CONSTRAINT `FK_tm_ts_status_project` FOREIGN KEY (`project_id`) REFERENCES `tm_projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


DELIMITER $$

DROP TRIGGER `main_leaverequest_aft_ins`$$

CREATE
   
    TRIGGER `main_leaverequest_aft_ins` AFTER INSERT ON `main_leaverequest` 
    FOR EACH ROW BEGIN
				    declare user_name,repmanager_name,leave_type_name,dept_name,buss_unit_name varchar(200);
				    declare dept_id,bunit_id bigint(20);
				    select userfullname into user_name from main_users where id = new.user_id;
				    select userfullname into repmanager_name from main_users where id = new.rep_mang_id;
				    select leavetype into leave_type_name from main_employeeleavetypes where id = new.leavetypeid;
				    select department_id into dept_id from main_employees where user_id = new.user_id;
				    select b.id,concat(d.deptname," (",d.deptcode,")") ,
				    if(b.unitcode != "000",concat(b.unitcode,"","-"),"") into bunit_id,dept_name,buss_unit_name 
				    FROM `main_departments` AS `d` LEFT JOIN `main_businessunits` AS `b` ON b.id=d.unitid 
				    WHERE (d.isactive = 1 and d.id = dept_id);
				    insert into main_leaverequest_summary (leave_req_id, user_id, user_name, department_id, 
				    department_name, bunit_id,buss_unit_name, reason, approver_comments, leavetypeid, leavetype_name, leaveday, from_date, to_date, leavestatus, 
				    rep_mang_id, rep_manager_name, no_of_days, appliedleavescount, is_sat_holiday, createdby, 
				    modifiedby, createddate, modifieddate, isactive)
				    values(new.id,new.user_id, user_name, dept_id, dept_name,bunit_id,buss_unit_name,new.reason,new.approver_comments, 
				    new.leavetypeid, leave_type_name, new.leaveday, new.from_date, new.to_date, new.leavestatus, 
				    new.rep_mang_id, repmanager_name, new.no_of_days, new.appliedleavescount, new.is_sat_holiday, 
				    new.createdby, new.modifiedby, new.createddate, new.modifieddate, new.isactive);
				    END;
$$

DELIMITER ;

DELIMITER $$

DROP TRIGGER `main_leaverequest_aft_upd`$$

CREATE
    TRIGGER `main_leaverequest_aft_upd` AFTER UPDATE ON `main_leaverequest` 
    FOR EACH ROW BEGIN
				    declare user_name,repmanager_name,leave_type_name,dept_name,buss_unit_name varchar(200);
				    declare dept_id,bunit_id bigint(20);
				    #select userfullname into user_name from main_users where id = new.user_id;
				    #select userfullname into repmanager_name from main_users where id = new.rep_mang_id;
				    #select leavetype into leave_type_name from main_employeeleavetypes where id = new.leavetypeid;
				    select department_id into dept_id from main_employees where user_id = new.user_id;
				    select b.id,concat(d.deptname," (",d.deptcode,")") ,
				    if(b.unitcode != "000",concat(b.unitcode,"","-"),"") into bunit_id,dept_name,buss_unit_name 
				    FROM `main_departments` AS `d` LEFT JOIN `main_businessunits` AS `b` ON b.id=d.unitid 
				    WHERE (d.isactive = 1 and d.id = dept_id);
				    UPDATE  main_leaverequest_summary set
				    user_id = new.user_id, 
				    department_id = dept_id, 
				    department_name = dept_name, 
				    bunit_id = bunit_id,
				    buss_unit_name = buss_unit_name,
				    approver_comments = new.approver_comments, 
				    leavestatus = new.leavestatus, 
				    modifieddate = new.modifieddate, 
				    isactive = new.isactive where leave_req_id = new.id;
				    END;
$$

DELIMITER ;
ALTER TABLE `tm_emp_ts_notes`
ADD `sun_reject_note` varchar(200) NULL after `sun_note`,
ADD `mon_reject_note` varchar(200) NULL after `mon_note`,
ADD `tue_reject_note` varchar(200) NULL after `tue_note`,
ADD `wed_reject_note` varchar(200) NULL after `wed_note`,
ADD `thu_reject_note` varchar(200) NULL after `thu_note`,
ADD `fri_reject_note` varchar(200) NULL after `fri_note`,
ADD `sat_reject_note` varchar(200) NULL after `sat_note`;

ALTER TABLE `tm_projects`
ADD `currency_id` int(10) unsigned NOT NULL after `client_id`,
ADD `project_type` enum('billable','non_billable','revenue') NOT NULL after `currency_id`,
ADD `lead_approve_ts` tinyint(1) NOT NULL after `project_type`, 
ADD `estimated_hrs` MEDIUMINT(5) DEFAULT NULL after `lead_approve_ts`,
ADD `start_date` date DEFAULT NULL after `estimated_hrs`,
ADD `end_date` date DEFAULT NULL after `start_date`, 
ADD `initiated_date` timestamp NULL DEFAULT NULL after `end_date`,
ADD `hold_date` timestamp NULL DEFAULT NULL after `initiated_date`, 
ADD `completed_date` timestamp NULL DEFAULT NULL after `hold_date`;

update tm_projects set currency_id = (select id from main_currency limit 0,1);

ALTER TABLE tm_projects
ADD CONSTRAINT `FK_tm_projects_currency`
FOREIGN KEY (`currency_id`) REFERENCES `main_currency` (`id`);

ALTER TABLE `tm_project_employees`
ADD `cost_rate` decimal(8,2) unsigned DEFAULT NULL after `emp_id`,
ADD `billable_rate` decimal(7,2) unsigned DEFAULT NULL after `cost_rate`;

ALTER TABLE `tm_project_tasks`
ADD `estimated_hrs` MEDIUMINT(5) unsigned DEFAULT NULL after `task_id`,
ADD `is_billable` tinyint(1) DEFAULT '0' after `estimated_hrs`,
ADD `billable_rate` decimal(25,2) DEFAULT NULL after `is_billable`;

ALTER TABLE `tm_ts_status`
ADD `sun_reject_note` varchar(200) NULL after `sun_status_date`,
ADD `mon_reject_note` varchar(200) NULL after `mon_status_date`,
ADD `tue_reject_note` varchar(200) NULL after `tue_status_date`,
ADD `wed_reject_note` varchar(200) NULL after `wed_status_date`,
ADD `thu_reject_note` varchar(200) NULL after `thu_status_date`,
ADD `fri_reject_note` varchar(200) NULL after `fri_status_date`,
ADD `sat_reject_note` varchar(200) NULL after `sat_status_date`;

ALTER TABLE `tm_ts_status` 
CHANGE `sun_project_status` `sun_project_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `sun_status` `sun_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `mon_project_status` `mon_project_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `mon_status` `mon_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `tue_project_status` `tue_project_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `tue_status` `tue_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `wed_project_status` `wed_project_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `wed_status` `wed_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `thu_project_status` `thu_project_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `thu_status` `thu_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `fri_project_status` `fri_project_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `fri_status` `fri_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `sat_project_status` `sat_project_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `sat_status` `sat_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL, 
CHANGE `week_status` `week_status` enum('saved','submitted','approved','enabled','rejected','blocked','no_entry') character set utf8 collate utf8_general_ci NULL; 

/*Table structure for table `tm_configuration` */

DROP TABLE IF EXISTS `tm_configuration`;

CREATE TABLE `tm_configuration` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `ts_weekly_reminder_day` enum('sun','mon','tue','wed','thu','fri','sat') NOT NULL,
  `ts_block_dates_range` varchar(100) NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

/*Table structure for table `tm_cronjob_status` */

DROP TABLE IF EXISTS `tm_cronjob_status`;

CREATE TABLE `tm_cronjob_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cronjob_status` enum('running','stopped') DEFAULT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

/*Table structure for table `tm_mailing_list` */

DROP TABLE IF EXISTS `tm_mailing_list`;

CREATE TABLE `tm_mailing_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `emp_id` int(10) unsigned DEFAULT NULL,
  `emp_full_name` varchar(150) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `mail_type` enum('submit_pending','reminder','block') DEFAULT NULL,
  `ts_dates` text,
  `ts_start_date` date DEFAULT NULL,
  `ts_end_date` date DEFAULT NULL,
  `mail_content` text,
  `is_mail_sent` tinyint(1) unsigned DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_tm_mailing_list_employee` (`emp_id`),
  CONSTRAINT `FK_tm_mailing_list_employee` FOREIGN KEY (`emp_id`) REFERENCES `main_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

/*Table structure for table `tm_process_updates` */

DROP TABLE IF EXISTS `tm_process_updates`;

CREATE TABLE `tm_process_updates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `emp_id` int(10) unsigned NOT NULL,
  `ts_dates` text NOT NULL,
  `action_type` enum('edited','rejected','approved','enabled') NOT NULL,
  `note` varchar(200) DEFAULT NULL,
  `alert` enum('open','closed') DEFAULT NULL,
  `action_by` int(10) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_tm_process_updates_employee` (`emp_id`),
  CONSTRAINT `FK_tm_process_updates_employee` FOREIGN KEY (`emp_id`) REFERENCES `main_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
ALTER TABLE `main_menu` add column `modulename` varchar(50) NULL after `isactive`;

ALTER TABLE `main_sd_configurations` ADD COLUMN `request_for` TINYINT(1) DEFAULT 1 NULL COMMENT '1=service request,2=asset request' AFTER `service_desk_flag`;

ALTER TABLE `main_sd_requests` ADD COLUMN `request_for` TINYINT(1) DEFAULT 1 NULL COMMENT '1=service request, 2= asset request' AFTER `id`, CHANGE `service_desk_id` `service_desk_id` BIGINT(20) UNSIGNED NULL COMMENT 'if request_for is equal to 2 then dump id from asset table', CHANGE `service_request_id` `service_request_id` BIGINT(20) UNSIGNED NULL COMMENT 'If request_for is equal to 2 then dump category from asset table';

ALTER TABLE `main_sd_requests_summary` ADD COLUMN `request_for` TINYINT(1) DEFAULT 1 NULL COMMENT '1=service request,2=asset request' AFTER `id`,CHANGE `service_desk_id` `service_desk_id` BIGINT(20) UNSIGNED NULL COMMENT 'If request_for equal to 2 then dump asset id from asset table', CHANGE `service_desk_name` `service_desk_name` VARCHAR(250) CHARSET latin1 COLLATE latin1_swedish_ci NULL COMMENT 'If request_for equal to 2 then dump asset name from asset table', CHANGE `service_request_name` `service_request_name` VARCHAR(250) CHARSET latin1 COLLATE latin1_swedish_ci NULL COMMENT 'If request_for equal to 2 then dump asset category from asset table', CHANGE `service_request_id` `service_request_id` BIGINT(20) UNSIGNED NULL COMMENT 'If request_for equal to 2 then dump asset name from asset_categories table';

alter table `main_empsalarydetails` change `salary` `salary` varchar(100) NULL;

update main_menu set isactive=0 where id IN(63,64,135);
update main_privileges set isactive=0 where object IN(63,64,135,175);
update `main_menu` set `menuName`='My Leaves' where `id`='62';
update `main_menu` set `url`='/#',`parent`='149',`isactive`='1' where `id`='175';
update `main_menu` set `parent`='0',`isactive`='0' where `id`='155';

insert  into `main_menu`(`id`,`menuName`,`url`,`helpText`,`toolTip`,`iconPath`,`parent`,`menuOrder`,`nav_ids`,`isactive`,`modulename`,`segment_flag`,`org_menuid`,`menufields`,`menuQuery`,`hasJoins`,`modelName`,`functionName`,`defaultOrderBy`) values 
(185,'Expenses','/#','Add Employee Expenses','Add Employee Expenses',NULL,0,18,',185,',1,'expenses',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(186,'Assets','/#','Add Company Assets','Add Company Assets',NULL,0,19,',186,',1,'assets',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(187,'Vendors','/vendors','Add Vendor for Assets','Add Vendor for Assets',NULL,0,20,',187,',0,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(188,'My Appraisal History','/appraisalhistoryself','My Appraisal History','My Appraisal History',NULL,175,1,',149,175,188,',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(189,'Team Appraisal History','/appraisalhistoryteam','Team Appraisal History','Team Appraisal History',NULL,175,2,',149,175,189,',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(190,'Asset Categories','/assets/assetcategories','Add category and sub cateegory for Assets','Add category and sub cateegory for Assets','',186,2,',186,190,',1,'assets',2,0,'','',0,'','',''),
(191,'Category','/expenses/expensecategories','Add category and sub cateegory for Expenses','Add category and sub cateegory for Expenses','',185,2,',185,191,',1,'expenses',2,0,'','',0,'','',''),
(192,'Payment Mode','/expenses/paymentmode','Add payment modes for Expenses','Add payment modes for Expenses','',185,3,',185,192,',1,'expenses',2,0,'','',0,'','',''),
(193,'Receipts','/expenses/receipts','Add receipts for Expenses','Add receipts for Expenses','',185,4,',185,193,',1,'expenses',2,0,'','',0,'','',''),
(194,'Trips','/expenses/trips','Add trips for Expenses','Add trips for Expenses','',185,5,',185,194,',1,'expenses',2,0,'','',0,'','',''),
(195,'Advances','/expenses/advances','Add advance for Employ','Add advance for Employ','',185,6,',185,195,',1,'expenses',2,0,'','',0,'','',''),
(196,'My Advances','/expenses/advances/myadvances','View list of my advances','View list of my advances','',195,7,',185,195,196,',1,'expenses',2,0,'','',0,'','',''),
(197,'Employee Advances','/expenses/employeeadvances','View list of Employee advances','View list of Employee advances','',195,7,',185,195,197,',1,'expenses',2,0,'','',0,'','',''),
(198,'Expenses','/expenses/expenses','Add Employee Expenses',NULL,NULL,185,1,',185,198,',1,'expenses',2,0,NULL,NULL,NULL,NULL,NULL,NULL),
(199,'My Employee Expenses','/expenses/myemployeeexpenses','Submitted Employee Expenses',NULL,NULL,185,9,',185,199,',1,'expenses',2,0,NULL,NULL,NULL,NULL,NULL,NULL),
(200,'Assets','/assets/assets','Assets',NULL,NULL,186,1,',186,200,',1,'assets',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL);


insert  into `main_privileges`(`role`,`group_id`,`object`,`addpermission`,`editpermission`,`deletepermission`,`viewpermission`,`uploadattachments`,`viewattachments`,`createdby`,`modifiedby`,`createddate`,`modifieddate`,`isactive`) values
(1,NULL,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,1,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,2,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,3,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,4,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,6,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(2,1,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(3,2,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(4,3,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(5,4,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(8,6,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(9,4,175,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(1,NULL,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(3,2,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(4,3,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(8,6,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,185,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(1,NULL,186,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,186,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,2,186,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,3,186,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,186,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,6,186,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,186,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(3,2,186,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(4,3,186,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,186,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(8,6,186,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,186,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(1,NULL,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,1,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,2,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,3,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,4,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,6,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(2,1,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(3,2,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(4,3,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(5,4,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(8,6,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(9,4,188,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(1,NULL,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,1,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,2,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,3,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,4,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,6,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(2,1,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(3,2,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(4,3,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(5,4,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(8,6,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(9,4,189,'No','No','No','Yes','No','No',1,1,now(),now(),1),
(NULL,3,8,'No','No','No','No','No','No',1,1,now(),now(),1),
(4,3,8,'No','No','No','No','No','No',1,1,now(),now(),1),
(1,NULL,190,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,190,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,2,190,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,3,190,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,190,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,6,190,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,190,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(3,2,190,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(4,3,190,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,190,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(8,6,190,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,190,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(1,NULL,191,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,191,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,2,191,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,3,191,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,191,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,6,191,'NO','No','No','No','No','No',1,1,NOW(),NOW(),0),
(2,1,191,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(3,2,191,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(4,3,191,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,191,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(8,6,191,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(9,4,191,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(1,NULL,192,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,192,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,2,192,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,3,192,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,192,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,6,192,'NO','No','No','No','No','No',1,1,NOW(),NOW(),0),
(2,1,192,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(3,2,192,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(4,3,192,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,192,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(8,6,192,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(9,4,192,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(1,NULL,193,'No','No','No','No','No','No',1,1,NOW(),NOW(),1),
(NULL,1,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(3,2,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(4,3,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(8,6,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,193,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(1,NULL,194,'No','No','No','No','No','No',1,1,NOW(),NOW(),1),
(NULL,1,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(3,2,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(4,3,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(8,6,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,194,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(1,NULL,195,'No','No','No','No','No','No',1,1,NOW(),NOW(),1),
(NULL,1,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(3,2,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(4,3,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(8,6,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,195,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(1,NULL,196,'No','No','No','No','No','No',1,1,NOW(),NOW(),1),
(NULL,1,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(3,2,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(4,3,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(8,6,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,196,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(1,NULL,197,'No','No','No','No','No','No',1,1,NOW(),NOW(),1),
(NULL,1,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(3,2,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(4,3,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(8,6,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,197,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(1,NULL,198,'No','No','No','No','No','No',1,1,NOW(),NOW(),1),
(NULL,1,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(3,2,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(4,3,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(8,6,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,198,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(1,NULL,199,'No','No','No','No','No','No',1,1,NOW(),NOW(),1),
(NULL,1,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(3,2,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(4,3,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(8,6,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,199,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(1,NULL,200,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,200,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,2,200,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,3,200,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,200,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,6,200,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(2,1,200,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(3,2,200,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(4,3,200,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(5,4,200,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(8,6,200,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(9,4,200,'No','No','No','No','No','No',1,1,NOW(),NOW(),0),
(NULL,3,8,'No','No','No','No','No','No',1,1,now(),now(),1),
(4,3,8,'No','No','No','No','No','No',1,1,now(),now(),1);


CREATE TABLE `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(50) NOT NULL,
  `sub_category` int(50) NOT NULL,
  `company_asset_code` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `location` varchar(15) NOT NULL,
  `allocated_to` int(11) DEFAULT NULL,
  `responsible_technician` int(50) NOT NULL,
  `vendor` int(11) NOT NULL,
  `asset_classification` varchar(50) NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `invoice_number` varchar(11) NOT NULL,
  `manufacturer` varchar(50) NOT NULL,
  `key_number` varchar(11) NOT NULL,
  `warenty_status` enum('Yes','No') NOT NULL,
  `warenty_end_date` date DEFAULT NULL,
  `is_working` enum('No','Yes') NOT NULL,
  `notes` text,
  `image` text,
  `imagencrpname` text NOT NULL,
  `qr_image` text NOT NULL,
  `isactive` tinyint(4) NOT NULL,
  `created_by` int(50) NOT NULL,
  `modified_by` int(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `assets_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `parent` int(11) NOT NULL,
  `is_active` tinyint(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `modified_by` varchar(11) CHARACTER SET latin1 NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=utf8;

CREATE TABLE `assets_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `history` varchar(500) DEFAULT NULL,
  `isactive` tinyint(1) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_advacne_summary` (
  `id` int(11) NOT NULL auto_increment,
  `employee_id` int(11) default NULL,
  `total` float(10,2) default NULL,
  `utilized` float(10,2) default NULL,
  `returned` float(10,2) default NULL,
  `balance` float(10,2) default NULL,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUEEMP` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_advance` (
  `id` int(11) NOT NULL auto_increment,
  `type` enum('advance','return') default 'advance',
  `from_id` int(11) default NULL,
  `to_id` int(11) default NULL,
  `payment_ref_number` varchar(200) default NULL,
  `payment_mode_id` int(11) default NULL,
  `project_id` int(11) default NULL,
  `currency_id` int(11) default NULL,
  `amount` float(10,2) default NULL,
  `application_currency_id` int(11) default NULL,
  `application_amount` float(10,2) default NULL,
  `advance_conversion_rate` float(10,2) default NULL,
  `description` text,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime NOT NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_categories` (
  `id` int(11) NOT NULL auto_increment,
  `expense_category_name` varchar(100) default NULL,
  `unit_price` varchar(50) default NULL,
  `unit_name` varchar(50) default NULL,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `created_date` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_forward` (
  `id` int(11) NOT NULL auto_increment,
  `expense_id` int(11) default NULL,
  `trip_id` int(11) default NULL,
  `from_id` int(11) default NULL,
  `to_id` int(11) default NULL,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_history` (
  `id` int(11) NOT NULL auto_increment,
  `expense_id` int(11) default NULL,
  `trip_id` int(11) default NULL,
  `history` varchar(500) default NULL,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_notifications` (
  `id` int(11) NOT NULL auto_increment,
  `expense_id` int(11) default NULL,
  `trip_id` int(11) default NULL,
  `notification` varchar(500) default NULL,
  `link` varchar(200) default NULL,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_payment_methods` (
  `id` int(11) NOT NULL auto_increment,
  `payment_method_name` varchar(100) default NULL,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `created_date` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_receipts` (
  `id` int(11) NOT NULL auto_increment,
  `expense_id` int(11) default NULL,
  `trip_id` int(11) default NULL,
  `receipt_name` varchar(100) default NULL COMMENT 'orginal file name',
  `receipt_filename` varchar(100) default NULL COMMENT 'auto generated file name',
  `receipt_file_type` varchar(5) default NULL,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_return_advance` (
  `id` int(11) NOT NULL auto_increment,
  `from_id` int(11) default NULL,
  `to_id` int(11) default NULL,
  `currency_id` int(11) default NULL,
  `returned_amount` float(10,2) default NULL,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_trip_history` (
  `id` int(11) NOT NULL auto_increment,
  `trip_id` int(11) default NULL,
  `expense_id` int(11) default NULL,
  `history` varchar(500) default NULL,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_trips` (
  `id` int(11) NOT NULL auto_increment,
  `manager_id` int(11) default NULL,
  `trip_name` varchar(100) default NULL,
  `from_date` date default NULL,
  `to_date` date default NULL,
  `description` text,
  `status` enum('NS','S','A','R') default 'NS' COMMENT 'NS-Notsubmitted,S-submitted,R-Rejected,A-Approved',
  `rejected_note` text,
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL auto_increment,
  `expense_name` varchar(100) default NULL,
  `category_id` int(11) default NULL,
  `project_id` int(11) default NULL,
  `client_id` int(11) default NULL,
  `trip_id` int(11) default NULL,
  `manager_id` int(11) default NULL,
  `expense_date` date default NULL,
  `expense_currency_id` int(11) default NULL,
  `expense_amount` float(10,2) default NULL,
  `expense_conversion_rate` float(5,2) default NULL,
  `application_currency_id` int(11) default NULL,
  `application_amount` float(10,2) default NULL,
  `advance_amount` float(10,2) default NULL,
  `is_reimbursable` tinyint(1) default NULL,
  `is_from_advance` tinyint(1) default '0',
  `expense_payment_id` int(11) default NULL,
  `expense_payment_ref_no` varchar(200) default NULL,
  `description` text,
  `status` enum('saved','submitted','approved','rejected') default 'saved',
  `createdby` int(11) default NULL,
  `modifiedby` int(11) default NULL,
  `createddate` datetime default NULL,
  `modifieddate` datetime default NULL,
  `isactive` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DELIMITER $$

DROP TRIGGER `main_sd_request_aft_ins`$$

CREATE
    TRIGGER `main_sd_request_aft_ins` AFTER INSERT ON `main_sd_requests` 
    FOR EACH ROW BEGIN
	DECLARE x_service_desk_name,x_service_request_name,x_raised_by_name,x_executor_name,
		x_reporting_manager_name,x_approver_1_name,x_approver_2_name,x_approver_3_name,raised_empid,raised_img
		VARCHAR(250);
	
	IF(new.request_for=1) THEN
	SELECT service_desk_name INTO x_service_desk_name FROM main_sd_depts WHERE id = new.service_desk_id;
	SELECT service_request_name INTO x_service_request_name FROM main_sd_reqtypes WHERE id = new.service_request_id;
	ELSE
	SELECT NAME INTO x_service_desk_name FROM assets WHERE id = new.service_desk_id;
	SELECT NAME INTO x_service_request_name FROM assets_categories WHERE id = new.service_request_id AND parent=0;
	END IF;
	SELECT userfullname,employeeId,profileimg INTO x_raised_by_name,raised_empid,raised_img FROM main_employees_summary WHERE user_id = new.raised_by;
	SELECT userfullname INTO x_executor_name FROM main_employees_summary WHERE user_id = new.executor_id;
	SELECT userfullname INTO x_reporting_manager_name FROM main_employees_summary WHERE user_id = new.reporting_manager_id;
	SELECT userfullname INTO x_approver_1_name FROM main_employees_summary WHERE user_id = new.approver_1;
	SELECT userfullname INTO x_approver_2_name FROM main_employees_summary WHERE user_id = new.approver_2;
	SELECT userfullname INTO x_approver_3_name FROM main_employees_summary WHERE user_id = new.approver_3;
	
	INSERT INTO main_sd_requests_summary (
	request_for,sd_requests_id, service_desk_id, service_desk_name, service_desk_conf_id, service_request_name, service_request_id,
	priority, description, attachment, STATUS, raised_by, raised_by_name, ticket_number, executor_id, executor_name, executor_comments,
	reporting_manager_id, reporting_manager_name, approver_status_1, approver_status_2, approver_status_3, reporting_manager_status,
	approver_1, approver_1_name, approver_2, approver_2_name, approver_3, approver_3_name, isactive, createdby, modifiedby,
	createddate, modifieddate,raised_by_empid,approver_1_comments,approver_2_comments,approver_3_comments,reporting_manager_comments,
	to_mgmt_comments,to_manager_comments
	)
	VALUES	(	
	new.request_for,new.id, new.service_desk_id, x_service_desk_name, new.service_desk_conf_id, x_service_request_name, new.service_request_id,
	new.priority, new.description, new.attachment, new.status, new.raised_by, x_raised_by_name, new.ticket_number, new.executor_id,
	x_executor_name, new.executor_comments,	new.reporting_manager_id, x_reporting_manager_name, new.approver_status_1,
	new.approver_status_2, new.approver_status_3, new.reporting_manager_status, new.approver_1, x_approver_1_name, new.approver_2,
	x_approver_2_name, new.approver_3, x_approver_3_name, new.isactive, new.createdby, new.modifiedby, new.createddate, new.modifieddate,
        raised_empid,new.approver_1_comments,new.approver_2_comments,new.approver_3_comments,new.reporting_manager_comments,
	new.to_mgmt_comments,new.to_manager_comments
	);
	INSERT INTO main_request_history(request_id,description,emp_id,emp_name,createdby,modifiedby,createddate,modifieddate,isactive,emp_profileimg)
	VALUE (new.id,CONCAT(CONCAT(UCASE(LEFT(x_service_desk_name, 1)), SUBSTRING(x_service_desk_name, 2)) ,' Request has been raised by '),new.raised_by,CONCAT(UCASE(LEFT(x_raised_by_name, 1)), SUBSTRING(x_raised_by_name, 2)),new.createdby,new.createdby,new.createddate,new.modifieddate,new.isactive,raised_img);
    END;
	
$$

DELIMITER ;

DELIMITER $$

DROP TRIGGER `main_sd_request_aft_upd`$$

CREATE
    TRIGGER `main_sd_request_aft_upd` AFTER UPDATE ON `main_sd_requests` 
    FOR EACH ROW BEGIN
	DECLARE x_service_desk_name,x_service_request_name,x_raised_by_name,x_executor_name,
		x_reporting_manager_name,x_approver_1_name,x_approver_2_name,x_approver_3_name
		VARCHAR(250);
	
	IF(new.request_for=1) THEN
	SELECT service_desk_name INTO x_service_desk_name FROM main_sd_depts WHERE id = new.service_desk_id;
	SELECT service_request_name INTO x_service_request_name FROM main_sd_reqtypes WHERE id = new.service_request_id;
	ELSE
	SELECT NAME INTO x_service_desk_name FROM assets WHERE id = new.service_desk_id;
	SELECT NAME INTO x_service_request_name FROM assets_categories WHERE id = new.service_request_id AND parent=0;
	END IF;
	SELECT userfullname INTO x_raised_by_name FROM main_employees_summary WHERE user_id = new.raised_by;
	SELECT userfullname INTO x_executor_name FROM main_employees_summary WHERE user_id = new.executor_id;
	SELECT userfullname INTO x_reporting_manager_name FROM main_employees_summary WHERE user_id = new.reporting_manager_id;
	SELECT userfullname INTO x_approver_1_name FROM main_employees_summary WHERE user_id = new.approver_1;
	SELECT userfullname INTO x_approver_2_name FROM main_employees_summary WHERE user_id = new.approver_2;
	SELECT userfullname INTO x_approver_3_name FROM main_employees_summary WHERE user_id = new.approver_3;
	
	UPDATE main_sd_requests_summary SET
	request_for=new.request_for,service_desk_id = new.service_desk_id, service_desk_name = x_service_desk_name, service_desk_conf_id = new.service_desk_conf_id,
	service_request_name = x_service_request_name, service_request_id = new.service_request_id, priority = new.priority,
	description = new.description, attachment = new.attachment, STATUS = new.status, raised_by = new.raised_by,
	raised_by_name = x_raised_by_name, ticket_number = new.ticket_number, executor_id = new.executor_id, executor_name = x_executor_name,
	executor_comments = new.executor_comments, reporting_manager_id = new.reporting_manager_id, reporting_manager_name = x_reporting_manager_name,
	approver_status_1 = new.approver_status_1, approver_status_2 = new.approver_status_2, approver_status_3 = new.approver_status_3,
	reporting_manager_status = new.reporting_manager_status, approver_1 = new.approver_1, approver_1_name = x_approver_1_name,
	approver_2 = new.approver_2, approver_2_name = x_approver_2_name, approver_3 = new.approver_3, approver_3_name = x_approver_3_name,
	isactive = new.isactive, createdby = new.createdby, modifiedby = new.modifiedby, createddate = new.createddate, modifieddate = new.modifieddate
	,approver_1_comments = new.approver_1_comments,approver_2_comments = new.approver_2_comments,approver_3_comments = new.approver_3_comments,reporting_manager_comments = new.reporting_manager_comments,
	to_mgmt_comments = new.to_mgmt_comments,to_manager_comments = new.to_manager_comments
	WHERE sd_requests_id = new.id;
    END;
	
$$

DELIMITER ;
set global sql_mode = "STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION";
ALTER TABLE assets MODIFY purchase_date DATE;
ALTER TABLE assets MODIFY warenty_end_date DATE;
ALTER TABLE main_accountclasstype MODIFY createddate DATETIME;
ALTER TABLE main_accountclasstype MODIFY modifieddate DATETIME;
ALTER TABLE main_announcements MODIFY createddate DATETIME;
ALTER TABLE main_announcements MODIFY modifieddate DATETIME;
ALTER TABLE main_assignmententryreasoncode MODIFY createddate DATETIME;
ALTER TABLE main_assignmententryreasoncode MODIFY modifieddate DATETIME;
ALTER TABLE main_attendancestatuscode MODIFY createddate DATETIME;
ALTER TABLE main_attendancestatuscode MODIFY modifieddate DATETIME;
ALTER TABLE main_bankaccounttype MODIFY createddate DATETIME;
ALTER TABLE main_bankaccounttype MODIFY modifieddate DATETIME;
ALTER TABLE main_cities MODIFY createddate DATETIME;
ALTER TABLE main_cities MODIFY modifieddate DATETIME;
ALTER TABLE main_competencylevel MODIFY createddate DATETIME;
ALTER TABLE main_competencylevel MODIFY modifieddate DATETIME;
ALTER TABLE main_countries MODIFY createddate DATETIME;
ALTER TABLE main_countries MODIFY modifieddate DATETIME;
ALTER TABLE main_currency MODIFY createddate DATETIME;
ALTER TABLE main_currency MODIFY modifieddate DATETIME;
ALTER TABLE main_currencyconverter MODIFY createddate DATETIME;
ALTER TABLE main_currencyconverter MODIFY modifieddate DATETIME;
ALTER TABLE main_dateformat MODIFY createddate DATETIME;
ALTER TABLE main_dateformat MODIFY modifieddate DATETIME;
ALTER TABLE main_educationlevelcode MODIFY createddate DATETIME;
ALTER TABLE main_educationlevelcode MODIFY modifieddate DATETIME;
ALTER TABLE main_eeoccategory MODIFY createddate DATETIME;
ALTER TABLE main_eeoccategory MODIFY modifieddate DATETIME;
ALTER TABLE main_empadditionaldetails MODIFY createddate DATETIME;
ALTER TABLE main_empadditionaldetails MODIFY modifieddate DATETIME;
ALTER TABLE main_empcommunicationdetails MODIFY createddate DATETIME;
ALTER TABLE main_empcommunicationdetails MODIFY modifieddate DATETIME;
ALTER TABLE main_empeducationdetails MODIFY createddate DATETIME;
ALTER TABLE main_empeducationdetails MODIFY modifieddate DATETIME;
ALTER TABLE main_empexperiancedetails MODIFY createddate DATETIME;
ALTER TABLE main_empexperiancedetails MODIFY modifieddate DATETIME;
ALTER TABLE main_empholidays MODIFY createddate DATETIME;
ALTER TABLE main_empholidays MODIFY modifieddate DATETIME;
ALTER TABLE main_empjobhistory MODIFY createddate DATETIME;
ALTER TABLE main_empjobhistory MODIFY modifieddate DATETIME;
ALTER TABLE main_employeedocuments MODIFY createddate DATETIME;
ALTER TABLE main_employeedocuments MODIFY modifieddate DATETIME;
ALTER TABLE main_employeeleavetypes MODIFY createddate DATETIME;
ALTER TABLE main_employeeleavetypes MODIFY modifieddate DATETIME;
ALTER TABLE main_employmentstatus MODIFY createddate DATETIME;
ALTER TABLE main_employmentstatus MODIFY modifieddate DATETIME;
ALTER TABLE main_empmedicalclaims MODIFY createddate DATETIME;
ALTER TABLE main_empmedicalclaims MODIFY modifieddate DATETIME;
ALTER TABLE main_emppersonaldetails MODIFY createddate DATETIME;
ALTER TABLE main_emppersonaldetails MODIFY modifieddate DATETIME;
ALTER TABLE main_empsalarydetails MODIFY createddate DATETIME;
ALTER TABLE main_empsalarydetails MODIFY modifieddate DATETIME;
ALTER TABLE main_empskills MODIFY createddate DATETIME;
ALTER TABLE main_empskills MODIFY modifieddate DATETIME;
ALTER TABLE main_empworkeligibility MODIFY createddate DATETIME;
ALTER TABLE main_empworkeligibility MODIFY modifieddate DATETIME;
ALTER TABLE main_ethniccode MODIFY createddate DATETIME;
ALTER TABLE main_ethniccode MODIFY modifieddate DATETIME;
ALTER TABLE main_gender MODIFY createddate DATETIME;
ALTER TABLE main_gender MODIFY modifieddate DATETIME;
ALTER TABLE main_geographygroup MODIFY createddate DATETIME;
ALTER TABLE main_geographygroup MODIFY modifieddate DATETIME;
ALTER TABLE main_holidaygroups MODIFY createddate DATETIME;
ALTER TABLE main_holidaygroups MODIFY modifieddate DATETIME;
ALTER TABLE main_jobtitles MODIFY createddate DATETIME;
ALTER TABLE main_jobtitles MODIFY modifieddate DATETIME;
ALTER TABLE main_language MODIFY createddate DATETIME;
ALTER TABLE main_language MODIFY modifieddate DATETIME;
ALTER TABLE main_licensetype MODIFY createddate DATETIME;
ALTER TABLE main_licensetype MODIFY modifieddate DATETIME;
ALTER TABLE main_maritalstatus MODIFY createddate DATETIME;
ALTER TABLE main_maritalstatus MODIFY modifieddate DATETIME;
ALTER TABLE main_militaryservice MODIFY createddate DATETIME;
ALTER TABLE main_militaryservice MODIFY modifieddate DATETIME;
ALTER TABLE main_monthslist MODIFY createddate DATETIME;
ALTER TABLE main_monthslist MODIFY modifieddate DATETIME;
ALTER TABLE main_nationality MODIFY createddate DATETIME;
ALTER TABLE main_nationality MODIFY modifieddate DATETIME;
ALTER TABLE main_nationalitycontextcode MODIFY createddate DATETIME;
ALTER TABLE main_nationalitycontextcode MODIFY modifieddate DATETIME;
ALTER TABLE main_numberformats MODIFY createddate DATETIME;
ALTER TABLE main_numberformats MODIFY modifieddate DATETIME;
ALTER TABLE main_payfrequency MODIFY createddate DATETIME;
ALTER TABLE main_payfrequency MODIFY modifieddate DATETIME;
ALTER TABLE main_pa_category MODIFY createddate DATETIME;
ALTER TABLE main_pa_category MODIFY modifieddate DATETIME;
ALTER TABLE main_pa_employee_ratings MODIFY createddate DATETIME;
ALTER TABLE main_pa_employee_ratings MODIFY modifieddate DATETIME;
ALTER TABLE main_pa_ff_employee_ratings MODIFY createddate DATETIME;
ALTER TABLE main_pa_ff_employee_ratings MODIFY modifieddate DATETIME;
ALTER TABLE main_pa_manager_initialization MODIFY createddate DATETIME;
ALTER TABLE main_pa_manager_initialization MODIFY modifieddate DATETIME;
ALTER TABLE main_pa_ratings MODIFY createddate DATETIME;
ALTER TABLE main_pa_ratings MODIFY modifieddate DATETIME;
ALTER TABLE main_positions MODIFY createddate DATETIME;
ALTER TABLE main_positions MODIFY modifieddate DATETIME;
ALTER TABLE main_prefix MODIFY createddate DATETIME;
ALTER TABLE main_prefix MODIFY modifieddate DATETIME;
ALTER TABLE main_racecode MODIFY createddate DATETIME;
ALTER TABLE main_racecode MODIFY modifieddate DATETIME;
ALTER TABLE main_remunerationbasis MODIFY createddate DATETIME;
ALTER TABLE main_remunerationbasis MODIFY modifieddate DATETIME;
ALTER TABLE main_roles MODIFY createddate DATETIME;
ALTER TABLE main_roles MODIFY modifieddate DATETIME;
ALTER TABLE main_sd_configurations MODIFY createddate DATETIME;
ALTER TABLE main_sd_configurations MODIFY modifieddate DATETIME;
ALTER TABLE main_sd_depts MODIFY createddate DATETIME;
ALTER TABLE main_sd_depts MODIFY modifieddate DATETIME;
ALTER TABLE main_sd_reqtypes MODIFY createddate DATETIME;
ALTER TABLE main_sd_reqtypes MODIFY modifieddate DATETIME;
ALTER TABLE main_states MODIFY createddate DATETIME;
ALTER TABLE main_states MODIFY modifieddate DATETIME;
ALTER TABLE main_timeformat MODIFY createddate DATETIME;
ALTER TABLE main_timeformat MODIFY modifieddate DATETIME;
ALTER TABLE main_timezone MODIFY createddate DATETIME;
ALTER TABLE main_timezone MODIFY modifieddate DATETIME;
ALTER TABLE main_userloginlog MODIFY logindatetime DATETIME;
ALTER TABLE main_users MODIFY createddate DATETIME;
ALTER TABLE main_users MODIFY modifieddate DATETIME;
ALTER TABLE main_veteranstatus MODIFY createddate DATETIME;
ALTER TABLE main_veteranstatus MODIFY modifieddate DATETIME;
ALTER TABLE main_weekdays MODIFY createddate DATETIME;
ALTER TABLE main_weekdays MODIFY modifieddate DATETIME;
ALTER TABLE main_workeligibilitydoctypes MODIFY createddate DATETIME;
ALTER TABLE main_workeligibilitydoctypes MODIFY modifieddate DATETIME;
ALTER TABLE tbl_employmentstatus MODIFY createddate DATETIME;
ALTER TABLE tbl_employmentstatus MODIFY modifieddate DATETIME;
ALTER TABLE tbl_weeks MODIFY createddate DATETIME;
ALTER TABLE tbl_weeks MODIFY modifieddate DATETIME;
ALTER TABLE tm_emp_ts_notes MODIFY sun_date DATE;
ALTER TABLE assets MODIFY category int;
ALTER TABLE assets MODIFY sub_category int;
ALTER TABLE assets MODIFY company_asset_code int;
ALTER TABLE assets MODIFY allocated_to int;
ALTER TABLE assets MODIFY responsible_technician int;
ALTER TABLE assets MODIFY vendor int;
ALTER TABLE assets MODIFY created_by int;
ALTER TABLE assets MODIFY modified_by int;
ALTER TABLE assets_categories MODIFY parent int;
ALTER TABLE assets_categories MODIFY created_by int;
ALTER TABLE main_candidatedetails MODIFY requisition_id int;
ALTER TABLE main_cronstatus MODIFY cron_status int;
ALTER TABLE main_currencyconverter MODIFY basecurrency int;
ALTER TABLE main_currencyconverter MODIFY targetcurrency int;
ALTER TABLE main_emailcontacts MODIFY group_id int;
ALTER TABLE main_emailcontacts MODIFY business_unit_id int;
ALTER TABLE main_employees_summary MODIFY user_id int;
ALTER TABLE main_empworkdetails MODIFY user_id int;
ALTER TABLE main_hierarchylevels MODIFY level_number int;
ALTER TABLE main_interviewrounddetails MODIFY interview_round_number int;
ALTER TABLE main_mail_settings MODIFY port int;
ALTER TABLE main_requisition MODIFY position_id int;
ALTER TABLE main_requisition_summary MODIFY req_id int;
ALTER TABLE main_requisition_summary MODIFY position_id int;
ALTER TABLE main_roles MODIFY levelid int;
ALTER TABLE main_settings MODIFY userid int;
ALTER TABLE tm_clients MODIFY created_by int;        
ALTER TABLE tm_emp_timesheets MODIFY created_by int;        
ALTER TABLE tm_projects MODIFY created_by int;        
ALTER TABLE tm_project_employees MODIFY created_by int;
ALTER TABLE tm_project_tasks MODIFY created_by int;        
ALTER TABLE tm_project_task_employees MODIFY created_by int;
ALTER TABLE tm_tasks MODIFY created_by int;
ALTER TABLE main_empadditionaldetails MODIFY user_id bigint;
ALTER TABLE main_empcommunicationdetails MODIFY user_id bigint;
ALTER TABLE main_empcreditcarddetails MODIFY user_id bigint;
ALTER TABLE main_empdependencydetails MODIFY user_id bigint;
ALTER TABLE main_empdisabilitydetails MODIFY user_id bigint;
ALTER TABLE main_empeducationdetails MODIFY user_id bigint;
ALTER TABLE main_empexperiancedetails MODIFY user_id bigint;
ALTER TABLE main_empjobhistory MODIFY user_id bigint;
ALTER TABLE main_employeedocuments MODIFY user_id bigint;
ALTER TABLE main_employees MODIFY user_id bigint;
ALTER TABLE main_empmedicalclaims MODIFY user_id bigint;
ALTER TABLE main_emppersonaldetails MODIFY user_id bigint;
ALTER TABLE main_empsalarydetails MODIFY user_id bigint;
ALTER TABLE main_empvisadetails MODIFY user_id bigint;
ALTER TABLE main_empvisadetails MODIFY createdby bigint;
ALTER TABLE main_empvisadetails MODIFY modifiedby bigint;
ALTER TABLE main_empworkeligibility MODIFY user_id bigint;
ALTER TABLE main_emp_reporting MODIFY emp_id bigint;
ALTER TABLE main_emp_reporting MODIFY reporting_manager_id bigint;
ALTER TABLE main_hierarchylevels MODIFY parent bigint;
ALTER TABLE main_hierarchylevels MODIFY userid bigint;
ALTER TABLE main_logmanager MODIFY menuId bigint;
ALTER TABLE main_logmanagercron MODIFY menuId bigint;
ALTER TABLE main_pd_categories MODIFY modifiedby bigint;
ALTER TABLE main_pd_categories MODIFY createdby bigint;
ALTER TABLE main_pd_documents MODIFY category_id bigint;
ALTER TABLE main_sd_reqtypes MODIFY service_desk_id bigint;
ALTER TABLE main_sd_requests_summary MODIFY sd_requests_id bigint;
ALTER TABLE main_weekdays MODIFY day_name bigint;
ALTER TABLE main_candidatedetails MODIFY experience float;
ALTER TABLE assets_categories MODIFY modified_by varchar(11);
ALTER TABLE tm_projects MODIFY lead_approve_ts TINYINT;
ALTER TABLE tbl_countries Modify country_code CHAR(10) CHARSET utf8 COLLATE utf8_general_ci NOT NULL; 
ALTER TABLE assets MODIFY isactive TINYINT;
ALTER TABLE assets_categories MODIFY is_active TINYINT;
ALTER TABLE main_pa_initialization MODIFY performance_app_flag TINYINT;
ALTER TABLE main_pd_categories MODIFY isused TINYINT;
ALTER TABLE main_pd_categories MODIFY isactive TINYINT;
ALTER TABLE main_pd_documents MODIFY isactive TINYINT;
ALTER TABLE main_settings MODIFY flag TINYINT;
ALTER TABLE main_settings MODIFY isactive TINYINT;
ALTER TABLE tbl_cities MODIFY is_active TINYINT;
ALTER TABLE tbl_countries MODIFY is_active TINYINT;
ALTER TABLE tbl_states MODIFY isactive TINYINT;
ALTER TABLE tm_clients MODIFY is_active TINYINT;
ALTER TABLE tm_emp_timesheets MODIFY cal_week TINYINT;
ALTER TABLE tm_emp_timesheets MODIFY is_active TINYINT;
ALTER TABLE tm_emp_ts_notes MODIFY cal_week TINYINT;
ALTER TABLE tm_emp_ts_notes MODIFY is_active TINYINT;
ALTER TABLE tm_projects MODIFY is_active TINYINT;
ALTER TABLE tm_project_employees MODIFY is_active TINYINT;
ALTER TABLE tm_project_tasks MODIFY is_active TINYINT;
ALTER TABLE tm_project_task_employees MODIFY is_active TINYINT;
ALTER TABLE tm_tasks MODIFY is_default TINYINT;
ALTER TABLE tm_tasks MODIFY is_active TINYINT;
ALTER TABLE tm_ts_status MODIFY is_active TINYINT;
ALTER TABLE `assets` CHANGE `invoice_number` `invoice_number` VARCHAR(50) NULL;


insert  into `main_menu`(`id`,`menuName`,`url`,`helpText`,`toolTip`,`iconPath`,`parent`,`menuOrder`,`nav_ids`,`isactive`,`modulename`,`segment_flag`,`org_menuid`,`menufields`,`menuQuery`,`hasJoins`,`modelName`,`functionName`,`defaultOrderBy`) values(201,'Disciplinary','/#','','','',0,21,',21,',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(202,'Violation Type','/disciplinaryviolation','','','',201,1,',201,202,',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(203,'Raise An Incident','/disciplinaryincident','','','',201,2,',201,203,',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(204,'My Incidents','/disciplinarymyincidents','','','',201,3,',201,204,',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(205,'Team Incidents','/disciplinaryteamincidents','','','',201,4,',201,205,',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(206,'All Incidents','/disciplinaryallincidents','','','',201,5,',201,206,',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL);



INSERT INTO `main_privileges` (`role`, `group_id`, `object`, `addpermission`, `editpermission`, `deletepermission`, `viewpermission`, `uploadattachments`, `viewattachments`, `createdby`, `modifiedby`, `createddate`, `modifieddate`, `isactive`) VALUES
(1, NULL, 201, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(1, NULL, 202, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(1, NULL, 203, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(1, NULL, 204, 'No', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(1, NULL, 205, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(1, NULL, 206, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),

(NULL,1,201,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,202,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,203,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,204,'No','Yes','No','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,205,'No','No','No','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,1,206,'No','No','No','Yes','No','No',1,1,NOW(),NOW(),1),

(NULL,2,201,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,204,'No','Yes','No','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,2,205,'No','No','No','Yes','No','No',1,1,NOW(),NOW(),1),

(NULL,3,201,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,204,'No','Yes','No','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,205,'No','No','No','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,3,206,'No','No','No','Yes','No','No',1,1,NOW(),NOW(),1),

(NULL,4,201,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,204,'No','Yes','No','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,4,205,'No','No','No','Yes','No','No',1,1,NOW(),NOW(),1),

(NULL,6,201,'Yes','Yes','Yes','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,204,'No','Yes','No','Yes','No','No',1,1,NOW(),NOW(),1),
(NULL,6,205,'No','No','No','Yes','No','No',1,1,NOW(),NOW(),1),

(2, 1, 201, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(2, 1, 202, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(2, 1, 203, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(2, 1, 204, 'No', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(2, 1, 205, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(2, 1, 206, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),

(3, 2, 201, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(3, 2, 204, 'No', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(3, 2, 205, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),

(4, 3, 201, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(4, 3, 204, 'No', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(4, 3, 205, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(4, 3, 206, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),

(5, 4, 201, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(5, 4, 204, 'No', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(5, 4, 205, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),

(8, 6, 201, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(8, 6, 204, 'No', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(8, 6, 205, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),

(9, 4, 201, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 1, 1, NOW(), NOW(), 1),
(9, 4, 204, 'No', 'Yes', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1),
(9, 4, 205, 'No', 'No', 'No', 'Yes', 'No', 'No', 1, 1, NOW(), NOW(), 1);

update `main_menu` set `parent`='0',`isactive`='0'where `id` IN(177,178,179,180,181);

CREATE TABLE `main_disciplinary_violation_types` (  
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,    
 `violationname` varchar(255) NOT NULL,            
 `description` varchar(255) DEFAULT NULL,          
 `createdby` int(11) unsigned DEFAULT NULL,        
 `modifiedby` int(11) unsigned DEFAULT NULL,       
 `createddate` datetime DEFAULT NULL,              
 `modifieddate` datetime DEFAULT NULL,             
 `isactive` tinyint(1) unsigned DEFAULT '1',       
 PRIMARY KEY (`id`)                                
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `main_disciplinary_incident` (                                                                                  
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,                                                                             
`incident_raised_by` bigint(20) unsigned DEFAULT NULL,                                                                     
`employee_bu_id` bigint(20) unsigned DEFAULT NULL,                                                                         
`employee_dept_id` bigint(20) unsigned DEFAULT NULL,                                                                       
`employee_id` bigint(20) unsigned DEFAULT NULL,                                                                            
`employee_rep_mang_id` bigint(20) unsigned DEFAULT NULL,

`date_of_occurrence` date DEFAULT NULL,
                                                                   
`violation_id` bigint(20) unsigned DEFAULT NULL,                                                                           
`violation_expiry` date DEFAULT NULL,                                                                                      
`employee_job_title_id` bigint(20) unsigned DEFAULT NULL,                                                                  
`employer_statement` text,                                                                                                 
`employee_appeal` tinyint(1) DEFAULT '1' COMMENT '1=Yes,2=No',                                                             
`employee_statement` text,                                                                                                 
`cao_verdict` tinyint(1) DEFAULT '1' COMMENT '1=guilty,2=not guilty',                                                      
`corrective_action` enum('Suspension With Pay','Suspension W/O Pay','Termination','Other') DEFAULT 'Suspension With Pay',  
`corrective_action_text` varchar(255) DEFAULT NULL,                                                                        
`incident_status` enum('Initiated','Appealed','Closed') DEFAULT 'Initiated',                                               
`createdby` bigint(20) unsigned DEFAULT NULL,                                                                              
`modifiedby` bigint(20) unsigned DEFAULT NULL,                                                                             
`createddate` datetime DEFAULT NULL,                                                                                       
`modifieddate` datetime DEFAULT NULL,                                                                                      
`isactive` tinyint(1) DEFAULT '1',                                                                                         
PRIMARY KEY (`id`)                                                                                                         
) ENGINE=MyISAM DEFAULT CHARSET=latin1;    


CREATE TABLE `main_disciplinary_history` (               
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,      
 `incident_id` bigint(20) unsigned DEFAULT NULL,        
 `description` varchar(300) DEFAULT NULL,               
 `action_emp_id` bigint(20) unsigned DEFAULT NULL,      
 `createdby` bigint(20) unsigned DEFAULT NULL,          
 `createddate` datetime DEFAULT NULL,                   
 PRIMARY KEY (`id`)                                     
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DELIMITER $$

DROP TRIGGER `main_users_aft_upd`$$

CREATE
   
    TRIGGER `main_users_aft_upd` AFTER UPDATE ON `main_users` 
    FOR EACH ROW BEGIN
    declare groupid int(11);
    
    select group_id into groupid from main_roles where id = old.emprole;
    if old.userfullname != new.userfullname then
    begin 
    
    if (groupid != 5 or groupid is null) then 
    begin
	
        update main_leaverequest_summary set rep_manager_name = new.userfullname,modifieddate = utc_timestamp() where rep_mang_id = new.id and isactive = 1;
        update main_leaverequest_summary set user_name = new.userfullname,modifieddate = utc_timestamp() where user_id = new.id and isactive = 1; 
	
	
	update main_requisition_summary set reporting_manager_name = new.userfullname,modifiedon = utc_timestamp() where reporting_id = new.id and isactive = 1;
	update main_requisition_summary set approver1_name = new.userfullname,modifiedon = utc_timestamp() where approver1 = new.id and isactive = 1;
	update main_requisition_summary set approver2_name = new.userfullname,modifiedon = utc_timestamp() where approver2 = new.id and isactive = 1;
	update main_requisition_summary set approver3_name = new.userfullname,modifiedon = utc_timestamp() where approver3 = new.id and isactive = 1;
	update main_requisition_summary set createdby_name = new.userfullname,modifiedon = utc_timestamp() where createdby = new.id and isactive = 1;
	
	
	update main_employees_summary set reporting_manager_name = new.userfullname,modifieddate = utc_timestamp() where reporting_manager = new.id and isactive = 1;
	update main_employees_summary set referer_name = new.userfullname,modifieddate = utc_timestamp() where candidatereferredby = new.id and isactive = 1;
	update main_employees_summary set createdby_name = new.userfullname,modifieddate = utc_timestamp() where createdby = new.id and isactive = 1;
        update main_employees_summary set userfullname = new.userfullname,modifieddate = utc_timestamp() where user_id = new.id and isactive = 1;
	
	
	update main_bgchecks_summary set specimen_name = new.userfullname,modifieddate = utc_timestamp() where specimen_id = new.id and specimen_flag = 1 and isactive = 1;
	update main_bgchecks_summary set createdname = new.userfullname,modifieddate = utc_timestamp() where createdby = new.id and isactive = 1;
	update main_bgchecks_summary set modifiedname = new.userfullname,modifieddate = utc_timestamp() where modifiedby = new.id and isactive = 1;
	
	
	update main_interviewrounds_summary set interviewer_name = new.userfullname,modified_date = utc_timestamp() where interviewer_id = new.id and isactive = 1;
	update main_interviewrounds_summary set created_by_name = new.userfullname,modified_date = utc_timestamp() where created_by = new.id and isactive = 1;
	
	
	update main_userloginlog set userfullname = new.userfullname where userid = new.id;
	
	
	update main_sd_requests_summary set raised_by_name = new.userfullname,modifieddate = utc_timestamp() where raised_by = new.id;
	update main_sd_requests_summary set executor_name = new.userfullname,modifieddate = utc_timestamp() where executor_id = new.id;
	update main_sd_requests_summary set reporting_manager_name = new.userfullname,modifieddate = utc_timestamp() where reporting_manager_id = new.id;
	update main_sd_requests_summary set approver_1_name = new.userfullname,modifieddate = utc_timestamp() where approver_1 = new.id;	
	update main_sd_requests_summary set approver_2_name = new.userfullname,modifieddate = utc_timestamp() where approver_2 = new.id;
	update main_sd_requests_summary set approver_3_name = new.userfullname,modifieddate = utc_timestamp() where approver_3 = new.id;
	
    end;
    end if;
    end;
    end if;
    if old.employeeId != new.employeeId then 
    begin 
        if (groupid != 5 or groupid is null) then 
        begin
	    
            update main_employees_summary set employeeId = new.employeeId,modifieddate = utc_timestamp() where user_id = new.id; 
            
        end;
        end if;
    end;
    end if;
    if old.isactive != new.isactive then
    begin
	if (groupid != 5 or groupid is null) then 
        begin
	    
            update main_employees_summary set isactive = new.isactive,modifieddate = utc_timestamp() where user_id = new.id; 
            
        end;
        end if;
    end;
    end if; 
    if old.profileimg != new.profileimg then
    begin
	if (groupid != 5 or groupid is null) then 
        begin
	    
            update main_employees_summary set profileimg = new.profileimg,modifieddate = utc_timestamp() where user_id = new.id; 
            
	    
            update main_request_history set emp_profileimg = new.profileimg,modifieddate = utc_timestamp() where emp_id = new.id; 
            
        end;
        end if;
    end;
    end if; 
    if old.backgroundchk_status != new.backgroundchk_status then
    begin
	if (groupid != 5 or groupid is null) then 
        begin
	    
            update main_employees_summary set backgroundchk_status = new.backgroundchk_status,modifieddate = utc_timestamp() where user_id = new.id; 
            
        end;
        end if;
    end;
    end if;
if (old.contactnumber != new.contactnumber || new.contactnumber IS NOT NULL) then
    begin
	if (groupid != 5 or groupid is null) then 
        begin
	    
            update main_employees_summary set contactnumber = new.contactnumber,modifieddate = utc_timestamp() where user_id = new.id; 
            
        end;
        end if;
    end;
    end if;
    
    END;
$$

DELIMITER ;
CREATE TABLE `main_requisition_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition_id` int(20) DEFAULT NULL,
  `candidate_id` int(20) DEFAULT NULL,
  `candidate_name` varchar(150) DEFAULT NULL,
  `interview_id` int(20) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `isactive` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `main_leaverequest_history` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `leaverequest_id` INT(20) DEFAULT NULL,
  `description` VARCHAR(500) DEFAULT NULL,
  `createdby` INT(11) DEFAULT NULL,
  `modifiedby` INT(11) DEFAULT NULL,
  `createddate` DATETIME DEFAULT NULL,
  `modifieddate` DATETIME DEFAULT NULL,
  `isactive` TINYINT(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `main_vendors` (			
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,			
		`name` varchar(255) DEFAULT NULL,			
		`contact_person` varchar(255) DEFAULT NULL,			
		`address` varchar(200) DEFAULT NULL,			
		`country` bigint(20) DEFAULT NULL,			
		`state` bigint(20) DEFAULT NULL,			
		`city` bigint(20) DEFAULT NULL,			
		`pincode` varchar(15) DEFAULT NULL,			
		`primary_phone` varchar(15) DEFAULT NULL,			
		`secondary_phone` varchar(15) DEFAULT NULL,			
		`createdby` int(10) unsigned DEFAULT NULL,			
		`modifiedby` int(10) unsigned DEFAULT NULL,			
		`createddate` datetime DEFAULT NULL,			
		`modifieddate` datetime DEFAULT NULL,			
		`isactive` tinyint(1) DEFAULT '1',			
		PRIMARY KEY (`id`)			
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

ALTER TABLE `main_candidatedetails` ADD COLUMN  `source` ENUM('Vendor','Website','Referal')  AFTER `pincode`;
ALTER TABLE `main_candidatedetails` ADD COLUMN `source_val` VARCHAR(150) AFTER `source`;
ALTER TABLE `main_candidatedetails` DROP INDEX `NewIndex1`;
ALTER TABLE `main_candidatedetails` DROP INDEX `NewIndex2`;
ALTER TABLE `main_requisition` ADD COLUMN `recruiters` int(11) AFTER `appstatus3`;
ALTER TABLE `main_requisition` ADD COLUMN `client_id` int(11) AFTER `recruiters`;
ALTER TABLE `main_requisition_summary` ADD COLUMN `recruiters` varchar(150) AFTER `appstatus3`;
ALTER TABLE `main_requisition_summary` ADD COLUMN `client_id` INT(11) AFTER `recruiters`;
ALTER TABLE `main_candidatedetails` CHANGE `qualification` `qualification` VARCHAR(100) CHARSET utf8 COLLATE utf8_general_ci NULL;

INSERT  INTO `main_menu`(`id`,`menuName`,`url`,`helpText`,`toolTip`,`iconPath`,	`parent`,`menuOrder`,`nav_ids`,`isactive`,`modulename`,`segment_flag`,`org_menuid`,`menufields`,`menuQuery`,`hasJoins`,`modelName`,`functionName`,`defaultOrderBy`)VALUES
(207,'Contacts','/#','','','',3,8,',3,207',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(208,'Clients','/clients','','','',207,3,',3,207,208',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(209,'Projects','/projects','','','',207,4,',3,207,209',1,'default',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL);


INSERT  INTO `main_privileges`(`role`,`group_id`,`object`,`addpermission`,`editpermission`,`deletepermission`,`viewpermission`,`uploadattachments`,`viewattachments`,`createdby`,`modifiedby`,`createddate`,`modifieddate`,`isactive`) VALUES
(1,NULL,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,1,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,2,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,3,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,4,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,5,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,6,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(2,1,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(3,2,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(4,3,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(5,4,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(6,5,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(8,6,207,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(1,NULL,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,1,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,2,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,3,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,4,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,5,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,6,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(2,1,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(3,2,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(4,3,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(5,4,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(6,5,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(8,6,208,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(1,NULL,187,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,1,187,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,3,187,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,6,187,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(2,1,187,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(4,3,187,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(8,6,187,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(1,NULL,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,1,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,2,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,3,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,4,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,5,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(NULL,6,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(2,1,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(3,2,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(4,3,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(5,4,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(6,5,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1),
(8,6,209,'Yes','Yes','Yes','Yes','Yes','Yes',1,1,NOW(),NOW(),1);


UPDATE `main_menu` SET `parent`=207 ,`nav_ids` =  ',3,207,21',`menuOrder`=1 WHERE id=21;
UPDATE `main_menu` SET `parent`=207 ,`nav_ids` =  ',3,207,187',`menuOrder`=2,`isactive`=1 WHERE id=187;
UPDATE `main_menu` SET `parent`=0 ,`isactive`=0 WHERE id=2;
UPDATE `main_menu` SET `parent`=3 ,`nav_ids` =  ',3,20,',`menuOrder`=2 WHERE id=20;
UPDATE `main_menu` SET `menuName`='Recruitments' WHERE id=19;
UPDATE `main_menu` SET menuName='Candidates' WHERE id=55;
UPDATE `main_menu` SET menuName='Interviews' WHERE id=57;
UPDATE `main_menu` SET `menuName`='External Users' WHERE `id`='21';
update `main_menu` set `menuName`='Manage Categories' where `id`='182';

DELIMITER $$

DROP TRIGGER `main_requisition_aft_ins`$$

CREATE
    TRIGGER `main_requisition_aft_ins` AFTER INSERT ON `main_requisition` 
    FOR EACH ROW BEGIN
        DECLARE pos_name,rep_name,bunit_name,dept_name,job_name,empt_name,app1_name,app2_name,app3_name,createdbyname VARCHAR(200);
        SELECT positionname INTO pos_name FROM main_positions WHERE id = new.position_id;
        SELECT userfullname INTO rep_name FROM main_users WHERE id = new.reporting_id;
        SELECT userfullname INTO app1_name FROM main_users WHERE id = new.approver1;
        SELECT userfullname INTO createdbyname FROM main_users WHERE id = new.createdby;
        SET app2_name = NULL;
        SET app3_name = NULL;
        IF new.approver2 IS NOT NULL THEN 
        SELECT userfullname INTO app2_name FROM main_users WHERE id = new.approver2;
        END IF;
        
        IF new.approver3 IS NOT NULL THEN 
        SELECT userfullname INTO app3_name FROM main_users WHERE id = new.approver3;
        END IF;
        SELECT unitname INTO bunit_name FROM main_businessunits WHERE id = new.businessunit_id;
        SELECT deptname INTO dept_name FROM main_departments WHERE id = new.department_id;
        SELECT jobtitlename INTO job_name FROM main_jobtitles WHERE id = new.jobtitle;
        SELECT te.employemnt_status INTO empt_name FROM main_employmentstatus em 
       INNER JOIN tbl_employmentstatus te ON te.id = em.workcodename WHERE em.id = new.emp_type;
		INSERT INTO main_requisition_summary 
        (req_id, requisition_code, onboard_date, position_id, position_name, reporting_id, reporting_manager_name,businessunit_id, businessunit_name, department_id, department_name, jobtitle, jobtitle_name,req_no_positions, selected_members, filled_positions, jobdescription, req_skills, req_qualification,req_exp_years,emp_type, emp_type_name, req_priority, additional_info, req_status, approver1, approver1_name,approver2, approver2_name, approver3, approver3_name, appstatus1, appstatus2, appstatus3,recruiters,client_id, isactive,createdby, modifiedby,createdon, modifiedon,createdby_name
        )
        VALUES
        (new.id, 
         
        new.requisition_code, 
        new.onboard_date, 
        new.position_id, 
        pos_name, 
        new.reporting_id, 
        rep_name, 
        new.businessunit_id, 
        bunit_name, 
        new.department_id, 
        dept_name, 
        new.jobtitle, 
        job_name, 
        new.req_no_positions, 
        new.selected_members, 
        new.filled_positions, 
        new.jobdescription, 
        new.req_skills, 
        new.req_qualification, 
        new.req_exp_years, 
        new.emp_type, 
        empt_name, 
        new.req_priority, 
        new.additional_info, 
        new.req_status, 
        new.approver1, 
        app1_name, 
        new.approver2, 
        app2_name, 
        new.approver3, 
        app3_name, 
        new.appstatus1, 
        new.appstatus2, 
        new.appstatus3, 
        new.recruiters,
        new.client_id,
        new.isactive, 
        new.createdby, 
        new.modifiedby, 
        new.createdon, 
        new.modifiedon,createdbyname
        );
    END;
$$

DELIMITER ;

DELIMITER $$
DROP TRIGGER `main_requisition_aft_upd`$$

CREATE TRIGGER `main_requisition_aft_upd` AFTER UPDATE ON `main_requisition` 
    FOR EACH ROW BEGIN
	DECLARE pos_name,rep_name,bunit_name,dept_name,job_name,empt_name,app1_name,app2_name,app3_name VARCHAR(200);
	SELECT positionname INTO pos_name FROM main_positions WHERE id = new.position_id;
	SELECT userfullname INTO rep_name FROM main_users WHERE id = new.reporting_id;
	SELECT userfullname INTO app1_name FROM main_users WHERE id = new.approver1;
	SET app2_name = NULL;
	SET app3_name = NULL;
	IF new.approver2 IS NOT NULL THEN 
        SELECT userfullname INTO app2_name FROM main_users WHERE id = new.approver2;
        END IF;
	
	IF new.approver3 IS NOT NULL THEN 
        SELECT userfullname INTO app3_name FROM main_users WHERE id = new.approver3;
        END IF;
	SELECT unitname INTO bunit_name FROM main_businessunits WHERE id = new.businessunit_id;
	SELECT deptname INTO dept_name FROM main_departments WHERE id = new.department_id;
	SELECT jobtitlename INTO job_name FROM main_jobtitles WHERE id = new.jobtitle;
	SELECT te.employemnt_status INTO empt_name FROM main_employmentstatus em 
       INNER JOIN tbl_employmentstatus te ON te.id = em.workcodename WHERE em.id = new.emp_type;
	UPDATE main_requisition_summary SET
	 requisition_code = new.requisition_code,onboard_date = new.onboard_date, position_id = new.position_id, position_name = pos_name, 
	 reporting_id = new.reporting_id, reporting_manager_name = rep_name , 
	businessunit_id = new.businessunit_id, businessunit_name = bunit_name, 
	department_id = new.department_id, department_name = dept_name, 
	jobtitle = new.jobtitle, jobtitle_name = job_name,	req_no_positions = new.req_no_positions, 
	selected_members = new.selected_members, filled_positions = new.filled_positions, 
	jobdescription = new.jobdescription, req_skills = new.req_skills, req_qualification = new.req_qualification, 
	req_exp_years = new.req_exp_years, 	emp_type = new.emp_type, emp_type_name = empt_name, 
	req_priority = new.req_priority, additional_info = new.additional_info, req_status = new.req_status,
	 approver1 = new.approver1, approver1_name = app1_name,	approver2 = new.approver2, 
	 approver2_name = app2_name, approver3 = new.approver3, approver3_name = app3_name, 
	 appstatus1 = new.appstatus1, appstatus2 = new.appstatus2, appstatus3 = new.appstatus3,recruiters=new.recruiters,client_id=new.client_id, 
	 modifiedby = new.modifiedby, 	modifiedon = new.modifiedon,isactive = new.isactive WHERE req_id = new.id ;
	 
    END;
$$

DELIMITER ;

UPDATE main_patches_version SET isactive=0;
INSERT INTO main_patches_version (version, createddate, modifieddate, isactive) VALUES ("3.1", now(), now(),1);