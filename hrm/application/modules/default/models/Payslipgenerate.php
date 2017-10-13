<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2015 Sapplica
 *   
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/

class Default_Model_Payslipgenerate extends Zend_Db_Table_Abstract
{
    public function getAllEmployees($loginUserId){
    	$db = Zend_Db_Table::getDefaultAdapter();
        $query = $db->query("SELECT mu.id as emp_id, mu.userfullname, mr.rolename, mpf.freqtype FROM main_users as mu INNER JOIN main_roles as mr ON mr.id=mu.emprole LEFT JOIN main_jobtitles as mjt ON mjt.id=mu.jobtitle_id LEFT JOIN main_payfrequency as mpf ON mpf.id=mjt.jobpayfrequency WHERE mu.isactive=1 AND mu.emprole !=".$loginUserId);
        $data = $query->fetchAll();
        return $data;
    }    
}