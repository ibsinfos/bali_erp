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

class Default_Form_employeetypes extends Zend_Form
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
            $this->setAttrib('name', 'employee_types');
            
            $id = new Zend_Form_Element_Hidden('id');

            $title = new Zend_Form_Element_Text('title');
            $title->setAttrib('maxLength', 50);
            $title->setRequired(true);
            $title->addValidator('NotEmpty', false, array('messages' => 'Please enter employee type.')); 
            $title->addValidators(array(
                        array(
                                'validator'   => 'Regex',
                                'breakChainOnFailure' => true,
                                'options'     => array( 
                                'pattern' =>'/^[a-zA-Z][a-zA-Z0-9\-\s]*$/i',
                                'messages' => array(
                                'regexNotMatch'=>'Please enter valid position.'
                                        )
                                )
                        )
                )); 
            $title->addValidator(new Zend_Validate_Db_NoRecordExists(
                                      array('table'=>'main_employeetypes',
                                                'field'=>'title',
                                              'exclude'=>"id!='".Zend_Controller_Front::getInstance()->getRequest()->getParam('id')."' and isActive='1' AND school_id = '".$school_id."'",    
                                         ) )  
                            );
        $title->getValidator('Db_NoRecordExists')->setMessage('Employee type already exists.');
   	
	$description = new Zend_Form_Element_Textarea('description');
        $description->setAttrib('rows', 10);
        $description->setAttrib('cols', 50);
	$description ->setAttrib('maxlength', '200');

        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Save');

	$this->addElements(array($id,$title,$description,$submit));
        $this->setElementDecorators(array('ViewHelper')); 
    }
}