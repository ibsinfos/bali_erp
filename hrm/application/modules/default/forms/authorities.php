<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2014 Sapplica
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

class Default_Form_authorities extends Zend_Form
{
	public function init()
	{
            $auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                try {
                    $school_id = $auth->getStorage()->read()->school_id;
                }
                catch(Exception $e){
                }
            }  
            $this->setMethod('post');
            $this->setAttrib('id', 'formid');
            $this->setAttrib('name', 'authorities');
            
            $id = new Zend_Form_Element_Hidden('id');

            $name = new Zend_Form_Element_Text('name');
            $name->setAttrib('maxLength', 50);
            $name->setRequired(true);
            $name->addValidator('NotEmpty', false, array('messages' => 'Please enter authority name.')); 
            $name->addValidator(new Zend_Validate_Db_NoRecordExists(
                                      array('table'=>'main_authorities',
                                                'field'=>'name',
                                              'exclude'=>"id!='".Zend_Controller_Front::getInstance()->getRequest()->getParam('id')."' and isActive='1' AND school_id = '".$school_id."'",    
                                         ) )  
                            );
        $name->getValidator('Db_NoRecordExists')->setMessage('Authority name already exists.');
   	
	$description = new Zend_Form_Element_Textarea('description');
        $description->setAttrib('rows', 10);
        $description->setAttrib('cols', 50);
	$description ->setAttrib('maxlength', '200');

        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Save');

	$this->addElements(array($id,$name,$description,$submit));
        $this->setElementDecorators(array('ViewHelper')); 
    }
}