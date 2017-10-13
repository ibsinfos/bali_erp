<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    /* 	
     * 	@author : Joyonto Roy
     * 	date	: 4 August, 2014
     * 	Ekattor School  Management System
     * 	http://codecanyon.net/user/Creativeitem
     */

    class Librarian extends CI_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
            /* cache control */
            //$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
            //$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        }

        /*         * *default functin, redirects to login page if no librarian logged in yet** */

        public function index()
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url() . 'index.php?login', 'refresh');
            if ($this->session->userdata('librarian_login') == 1)
                redirect(base_url() . 'index.php?librarian/dashboard', 'refresh');
        }

        /*         * *LIBRARIAN DASHBOARD** */

        function dashboard()
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            $page_data['page_name'] = 'dashboard';
            $page_data['page_title'] = get_phrase('librarian_dashboard');
            $this->load->view('backend/index', $page_data);
        }

        function general_setting($param1 = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            if (!empty($_POST['save_setting']))
            {
                $data['setting_for'] = $this->input->post("setting_for");
                $data['max_issue_limit'] = $this->input->post("max_issue_limit");
                $data['max_days_limit'] = $this->input->post("max_days_limit");
                $data['fine_amount'] = $this->input->post("fine_amount");
                $check_data = $this->db->get_where('general_library_setting', array(
                            'setting_for' => $data['setting_for']
                        ))->result_array();
                if (empty($check_data))
                {
                    $this->db->insert('general_library_setting', $data);
                }
                else
                {
                    $this->db->where('setting_for', $data['setting_for']);
                    $this->db->update('general_library_setting', $data);
                }
                $this->session->set_flashdata('flash_message', get_phrase('setting_save_successfully'));
                redirect(base_url() . 'index.php?librarian/general_setting/' . $data['setting_for'], 'refresh');
            }
            $page_data['setting_for'] = empty($param1) ? "Student" : $param1;
            $page_data['record'] = $this->db->get_where('general_library_setting', array(
                        'setting_for' => $page_data['setting_for']
                    ))->row();
            $page_data['record'] = (array) $page_data['record'];
            $page_data['page_name'] = 'general_setting';
            $page_data['page_title'] = get_phrase('manage_general_library_setting');
            $this->load->view('backend/index', $page_data);
        }

        function category($param1 = '', $param2 = '', $param3 = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            if ($param1 == 'create')
            {
                $data['category_name'] = $this->input->post('category_name');
                $data['category_status'] = $this->input->post('category_status');
                $this->db->insert('book_category', $data);
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                redirect(base_url() . 'index.php?librarian/category/', 'refresh');
            }
            if ($param1 == 'do_update')
            {
                $data['category_name'] = $this->input->post('category_name');
                $data['category_status'] = $this->input->post('category_status');
                $this->db->where('category_id', $param2);
                $this->db->update('book_category', $data);
                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                redirect(base_url() . 'index.php?librarian/category/', 'refresh');
            }
            else if ($param1 == 'edit')
            {
                $page_data['edit_data'] = $this->db->get_where('book_category', array(
                            'category_id' => $param2
                        ))->result_array();
            }
            if ($param1 == 'delete')
            {
                $this->db->where('category_id', $param2);
                $this->db->delete('book_category');
                redirect(base_url() . 'index.php?librarian/category/', 'refresh');
            }
            if($param1 == 'import_excel')
            {
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/category_subcategory_details.xlsx');
                // Importing excel sheet for book upload
                include 'simplexlsx.class.php';
                $xlsx = new SimpleXLSX('uploads/category_subcategory_details.xlsx');
                list($num_cols, $num_rows) = $xlsx->dimension();
                $f = 0;
                foreach ($xlsx->rows() as $r)
                {
                // Ignore the inital name row of excel file
                    if ($f == 0)
                    {
                        $f++;
                        continue;
                    }
                    for ($i = 0; $i < $num_cols; $i++)
                    {
                        //For Category & Subcategory
                        if ($i == 0)
                            $data['category_name'] = $r[$i];
                        else if ($i == 1)
                            $data2['subcategory_name'] = $r[$i];
                        else if ($i == 2)
                            $data2['subcategory_status'] = $r[$i];                       
                    }                   
                    $cat_id = $this->db->get_where('book_category', array("category_name" => $data['category_name']))->row()->category_id;
                    
                    if(!empty($cat_id))
                    { 
                        $data2['category_id'] = $cat_id;
                    }
                    else{
                        $data['category_status'] = "Active";
                        $this->db->insert('book_category',$data);
                        $category_id = $this->db->insert_id();                        
                        $data2['category_id'] = $category_id;
                        //$data2['subcategory_status'] = "Active";
                    }                    
                    $this->db->insert('book_subcategory', $data2);         
               
                }
                $this->session->set_flashdata('flash_message', get_phrase('Details_added_successfully'));
                redirect(base_url() . 'index.php?librarian/bulk_upload', 'refresh');
            }
                       
            $page_data['category_id'] = $param1;
            $page_data['category'] = $this->db->get_where('book_category')->result_array();
            $page_data['page_name'] = 'category';
            $page_data['page_title'] = get_phrase('manage_category');
            $this->load->view('backend/index', $page_data);
        }

        function subcategory($category_id = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            // detect the first class
            if ($category_id == '')
                $category_id = $this->db->get_where('book_category', array("category_status" => "Active"))->first_row()->category_id;

            $page_data['page_name'] = 'subcategory';
            $page_data['page_title'] = get_phrase('manage_subcategory');
            $page_data['category_id'] = $category_id;
            $this->load->view('backend/index', $page_data);
        }

        function subcategories($param1 = '', $param2 = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            if ($param1 == 'create')
            {
                $data['subcategory_name'] = $this->input->post('subcategory_name');
                $data['subcategory_status'] = $this->input->post('subcategory_status');
                $data['category_id'] = $this->input->post('category_id');
                $this->db->insert('book_subcategory', $data);
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                redirect(base_url() . 'index.php?librarian/subcategory/' . $data['category_id'], 'refresh');
            }

            if ($param1 == 'edit')
            {
                $data['subcategory_name'] = $this->input->post('subcategory_name');
                $data['subcategory_status'] = $this->input->post('subcategory_status');
                $data['category_id'] = $this->input->post('category_id');
                $this->db->where('subcategory_id', $param2);
                $this->db->update('book_subcategory', $data);
                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                redirect(base_url() . 'index.php?librarian/subcategory/' . $data['category_id'], 'refresh');
            }

            if ($param1 == 'delete')
            {
                $this->db->where('subcategory_id', $param2);
                $this->db->delete('book_subcategory');
                $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
                redirect(base_url() . 'index.php?librarian/subcategory/', 'refresh');
            }
        }

        function message($param1 = 'message_home', $param2 = '', $param3 = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
            {
                $this->session->set_userdata('last_page', current_url());
                redirect(base_url(), 'refresh');
            }

            if ($param1 == 'send_new')
            {
                $message_thread_code = $this->crud_model->send_new_private_message();
                $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
                redirect(base_url() . 'index.php?librarian/message/message_read/' . $message_thread_code, 'refresh');
            }

            if ($param1 == 'send_reply')
            {
                $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
                $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
                redirect(base_url() . 'index.php?librarian/message/message_read/' . $param2, 'refresh');
            }

            if ($param1 == 'message_read')
            {
                $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
                $this->crud_model->mark_thread_messages_read($param2);
            }

            $page_data['message_inner_page_name'] = $param1;
            $page_data['page_name'] = 'message';
            $page_data['page_title'] = get_phrase('private_messaging');
            $this->load->view('backend/index', $page_data);
        }

        function books($param1 = '', $param2 = '', $param3 = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            if ($param1 == 'create')
            {
                $book_data['book_title'] = $this->input->post('book_title');
                $book_data['book_author'] = $this->input->post('book_author');
                $book_data['isbn_number'] = $this->input->post('isbn_number');
                $book_data['book_note'] = $this->input->post('book_note');
                $book_data['subcategory_id'] = $this->input->post('subcategory_id');
                $stock_data['no_of_books'] = $this->input->post('no_of_books');
                $stock_data['supplier_name'] = $this->input->post('supplier_name');
                $stock_data['bill_number'] = $this->input->post('bill_number');
                $stock_data['total_price'] = $this->input->post('total_price');
                $stock_data['currency'] = $this->input->post('currency');

                $this->db->insert('books', $book_data);
                $my_book_id = $this->db->insert_id();
                if (!empty($my_book_id) && !empty($stock_data['no_of_books']))
                {
                    $stock_data['book_id'] = $my_book_id;
                    $this->db->insert('books_stock', $stock_data);
                    for ($i = 1; $i <= $stock_data['no_of_books']; $i++)
                    {
                        $book_list_data = array(
                            "book_id" => $my_book_id,
                            "book_issue_status" => "No",
                            "book_status" => "Active",
                        );
                        $this->db->insert('books_list', $book_list_data);
                    }
                }
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
                redirect(base_url() . 'index.php?librarian/books/', 'refresh');
            }
            if ($param1 == 'do_update')
            {
                $book_data['book_title'] = $this->input->post('book_title');
                $book_data['book_author'] = $this->input->post('book_author');
                $book_data['isbn_number'] = $this->input->post('isbn_number');
                $book_data['book_note'] = $this->input->post('book_note');
                $book_data['subcategory_id'] = $this->input->post('subcategory_id');
                $this->db->where('book_id', $param2);
                $this->db->update('books', $book_data);
                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                redirect(base_url() . 'index.php?librarian/books/', 'refresh');
            }
            elseif ($param1 == 'update_stock')
            {
                $stock_data['no_of_books'] = $this->input->post('no_of_books');
                $stock_data['supplier_name'] = $this->input->post('supplier_name');
                $stock_data['bill_number'] = $this->input->post('bill_number');
                $stock_data['total_price'] = $this->input->post('total_price');
                if (!empty($stock_data['no_of_books']))
                {
                    $stock_data['book_id'] = $param2;
                    $this->db->insert('books_stock', $stock_data);
                    for ($i = 1; $i <= $stock_data['no_of_books']; $i++)
                    {
                        $book_list_data = array(
                            "book_id" => $param2,
                            "book_issue_status" => "No",
                            "book_status" => "Active",
                        );
                        $this->db->insert('books_list', $book_list_data);
                    }
                }
                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                redirect(base_url() . 'index.php?librarian/books/', 'refresh');
            }
            else if ($param1 == 'edit')
            {
                $page_data['edit_data'] = $this->db->get_where('books', array(
                            'book_id' => $param2
                        ))->result_array();
            }
            if ($param1 == 'delete')
            {
                $this->db->where('category_id', $param2);
                $this->db->delete('book_category');
                redirect(base_url() . 'index.php?librarian/category/', 'refresh');
            }
            
            if($param1 == 'import_excel')
            {
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/book_import.xlsx');
                // Importing excel sheet for book upload
                include 'simplexlsx.class.php';
                $xlsx = new SimpleXLSX('uploads/book_import.xlsx');
                list($num_cols, $num_rows) = $xlsx->dimension();
                $f = 0;
                foreach ($xlsx->rows() as $r)
                {
                // Ignore the inital name row of excel file
                    if ($f == 0)
                    {
                        $f++;
                        continue;
                    }
                    for ($i = 0; $i < $num_cols; $i++)
                    {
                        //For Book Details
                        if ($i == 0)
                            $book_data['book_title'] = $r[$i];
                        else if ($i == 1)
                            $book_data['book_author'] = $r[$i];
                        else if ($i == 2)
                            $book_data['isbn_number'] = $r[$i];
                        else if ($i == 3)
                            $book_data['book_note'] = $r[$i];
                        //For Category & Subcategory
                        else if ($i == 4)
                            //$category_name = $r[$i];
                            $data['category_name'] = $r[$i];
                        else if ($i == 5)
                            $data2['subcategory_name'] = $r[$i];
                        //For Stock details
                        else if ($i == 6)
                            $stock_data['no_of_books'] = $r[$i];
                        else if ($i == 7)
                            $stock_data['supplier_name'] = $r[$i];
                        else if ($i == 8)
                            $stock_data['bill_number'] = $r[$i];
                        else if ($i == 9)
                            $stock_data['total_price'] = $r[$i];
                        else if ($i == 10)
                            $stock_data['currency'] = $r[$i];                        
                    }                   
                    $cat_id = $this->db->get_where('book_category', array("category_name" => $data['category_name']))->row()->category_id;
                    
                   /* if(!empty($cat_id))
                    { 
                        $data2['category_id'] = $cat_id;
                    }
                    else{
                        $data['category_status'] = "Active";
                        $this->db->insert('book_category',$data);
                        $category_id = $this->db->insert_id();                        
                        $data2['category_id'] = $category_id;
                        $data2['subcategory_status'] = "Active";
                    }                    
                    $this->db->insert('book_subcategory', $data2);*/
                    
                    $book_data['subcategory_id'] = $this->db->get_where('book_subcategory', array('category_id' => $cat_id, 'subcategory_name' => $data2['subcategory_name']))->row()->subcategory_id;
                    $this->db->insert('books', $book_data);
                    $my_book_id = $this->db->insert_id();
                    if (!empty($my_book_id) && !empty($stock_data['no_of_books']))
                    {
                        $stock_data['book_id'] = $my_book_id;
                        $this->db->insert('books_stock', $stock_data);
                        for ($i = 1; $i <= $stock_data['no_of_books']; $i++)
                        {
                            $book_list_data = array(
                                "book_id" => $my_book_id,
                                "book_issue_status" => "No",
                                "book_status" => "Active",
                            );
                            $this->db->insert('books_list', $book_list_data);
                        }
                    }
                }
                $this->session->set_flashdata('flash_message', get_phrase('books_added_successfully'));
                redirect(base_url() . 'index.php?librarian/bulk_upload', 'refresh');
            }      
            
            $page_data['book_id'] = $param1;
            $page_data['books'] = $this->crud_model->get_books_list();
            $page_data['page_name'] = 'books';
            $page_data['page_title'] = get_phrase('manage_books');
            $this->load->view('backend/index', $page_data);
        }

        function stock_history($param1 = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            $page_data['book_id'] = $param1;
            $book_detail = $this->db->get_where('books', array(
                        'book_id' => $param1
                    ))->row();
            $book_name = empty($book_detail->book_title) ? "" : $book_detail->book_title;
            $page_data['books_stock'] = $this->db->get_where('books_stock', array(
                        'book_id' => $param1
                    ))->result_array();
            $page_data['page_name'] = 'books_stock';
            $page_data['page_title'] = get_phrase('stock_detail_of_book') . " " . $book_name;
            $this->load->view('backend/index', $page_data);
        }

        function books_list($param1 = '', $param2 = '', $param3 = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            if ($param1 == 'change_status')
            {
                $book_data['book_unique_id'] = $this->input->post('book_unique_id');
                $book_data['book_status'] = $this->input->post('book_status');
                $this->db->where('book_unique_id', $book_data['book_unique_id']);
                $this->db->update('books_list', $book_data);
                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
                redirect(base_url() . 'index.php?librarian/books_list/' . $param2, 'refresh');
            }

            $page_data['book_id'] = $param1;
            $book_detail = $this->db->get_where('books', array(
                        'book_id' => $param1
                    ))->row();
            $book_name = empty($book_detail->book_title) ? "" : $book_detail->book_title;
            $page_data['books_stock'] = $this->db->get_where('books_list', array(
                        'book_id' => $param1
                    ))->result_array();
            $page_data['page_name'] = 'books_list';
            $page_data['page_title'] = get_phrase('listing_of_book') . " " . $book_name;
            $this->load->view('backend/index', $page_data);
        }

        function issuereturnbooks($param1 = '', $param2 = '', $param3 = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            $page_data = array();
            if ($param1 == "return")
            {
                $issued_detail = (array) $this->db->get_where('book_issue_table', array(
                            'issue_id' => $param2,
                        ))->row();
                if (!empty($issued_detail))
                {
                    $page_data['user_type'] = $issued_detail['user_type'];
                    $page_data['user_id'] = $issued_detail['user_id'];
                    $unique_book_id = $issued_detail['book_unique_id'];

                    if ($issued_detail['status'] == "Issued")
                    {
                        $update_arr = array(
                            "return_date" => date("Y-m-d"),
                            "return_to" => $this->session->userdata('librarian_id'),
                            "status" => "Returned",
                        );

                        $this->db->where('issue_id', $param2);
                        $this->db->update('book_issue_table', $update_arr);

                        $this->db->where('book_unique_id', $unique_book_id);
                        $this->db->update('books_list', array("book_issue_status" => "No"));
                        $this->session->set_flashdata('flash_message', get_phrase("return_successfully"));
                    }
                }
            }
            elseif ($param1 == "reissue")
            {
                $issued_detail = (array) $this->db->get_where('book_issue_table', array(
                            'issue_id' => $param2,
                        ))->row();
                if (!empty($issued_detail))
                {
                    $page_data['user_type'] = $issued_detail['user_type'];
                    $page_data['user_id'] = $issued_detail['user_id'];
                    $unique_book_id = $issued_detail['book_unique_id'];

                    if ($issued_detail['status'] == "Issued")
                    {
                        $update_arr = array(
                            "return_date" => date("Y-m-d"),
                            "return_to" => $this->session->userdata('librarian_id'),
                            "status" => "Returned",
                        );

                        $this->db->where('issue_id', $param2);
                        $this->db->update('book_issue_table', $update_arr);

                        $issue_data = array(
                            "user_id" => $issued_detail['user_id'],
                            "user_type" => $issued_detail['user_type'],
                            "book_unique_id" => $issued_detail['book_unique_id'],
                            "issue_date" => date("Y-m-d"),
                            "issue_by" => $this->session->userdata('librarian_id'),
                            "status" => "Issued",
                        );

                        $this->db->insert('book_issue_table', $issue_data);
                        $this->session->set_flashdata('flash_message', get_phrase("reissue_successfully"));
                    }
                }
            }
            elseif ($param1 == "return_with_fine")
            {
                $issued_detail = (array) $this->db->get_where('book_issue_table', array(
                            'issue_id' => $param2,
                        ))->row();
                if (!empty($issued_detail))
                {
                    $page_data['user_type'] = $issued_detail['user_type'];
                    $page_data['user_id'] = $issued_detail['user_id'];
                    $unique_book_id = $issued_detail['book_unique_id'];
                    $book_status = $this->input->post('book_status');
                    $fine_amount = $this->input->post('fine_amount');

                    if ($issued_detail['status'] == "Issued")
                    {
                        $update_arr = array(
                            "return_date" => date("Y-m-d"),
                            "return_to" => $this->session->userdata('librarian_id'),
                            "status" => $book_status,
                        );

                        $this->db->where('issue_id', $param2);
                        $this->db->update('book_issue_table', $update_arr);

                        $this->db->where('book_unique_id', $unique_book_id);
                        $this->db->update('books_list', array("book_issue_status" => "No", 'book_status' => $book_status));

                        $fine_arr = array(
                            "issue_id" => $param2,
                            "fine_amount" => $fine_amount,
                            "taken_status" => "Reviced"
                        );
                        $this->db->insert('library_fine_table', $fine_arr);
                        $this->session->set_flashdata('flash_message', get_phrase("return_successfully"));
                    }
                }
            }
            if (!empty($_POST['issue_new_book']))
            { 
                $user_type = $this->input->post("user_type");
                $user_id = $this->input->post("user_id");
                $book_id_arr = $this->input->post("book_id"); //gets unique id here 
                
                //                            
                //echo"user".$user_type."id".$user_id."book".$book_id_arr; exit;
                if (!empty($book_id_arr))
                {   
                    foreach ($book_id_arr as $book_id)
                    {
                        if (!empty($book_id))
                        {   
                            $book_issue_status = $this->db->get_where('books_list', array(
                                        'book_unique_id' => $book_id,
                                        'book_status' => "Active",
                                        'book_issue_status' => "No"
                                    ))->num_rows();
                            
                            if (!empty($book_issue_status))
                            {   
                                $issue_data = array(
                                    "user_id" => $user_id,
                                    "user_type" => $user_type,
                                    "book_unique_id" => $book_id,
                                    "issue_date" => date("Y-m-d"),
                                    "return_date" => date("Y-m-d", strtotime('+5 days')),
                                    "issue_by" => $this->session->userdata('librarian_id'),
                                    "status" => "Issued",
                                );

                                $this->db->insert('book_issue_table', $issue_data);
                                $this->db->where('book_unique_id', $book_id);
                                $this->db->update('books_list', array("book_issue_status" => "Yes"));
                            }
                        }
                    } 
                }
                $page_data['user_type'] = $user_type;
                $page_data['user_id'] = $user_id;
//                $this->session->set_flashdata('flash_message', get_phrase("books_issues_successfully"));
            }
            if (!empty($_POST['get_user_log']))
            {
                $user_type = $this->input->post("user_type");
                $student_id = $this->input->post("student_id");
                $teacher_id = $this->input->post("teacher_id");
                $page_data['user_type'] = $user_type;
                $page_data['user_id'] = empty($student_id) ? $teacher_id : $student_id;
            }
            $page_data['issue_log'] = $this->crud_model->get_records("book_issue_table", $page_data, "*", "issue_id", "desc");
            if (!empty($page_data['user_id']) && !empty($page_data['user_type']))
            {
                $general_setting = (array) $this->db->get_where('general_library_setting', array(
                            'setting_for' => $page_data['user_type'],
                        ))->row();
                $user_current_issued = $this->db->get_where('book_issue_table', array(
                            'user_type' => $page_data['user_type'],
                            'user_id' => $page_data['user_id'],
                            'status' => "Issued"
                        ))->num_rows();
                $remaining_issue = empty($general_setting['max_issue_limit']) ? "7" : $general_setting['max_issue_limit'] - $user_current_issued;
            }
            $page_data['remaining_issue'] = empty($remaining_issue) ? false : true;
            $page_data['page_name'] = 'issuereturnbooks';
            $page_data['page_title'] = get_phrase('issue_/_return_books');
            $this->load->view('backend/index', $page_data);
        }

        function get_subcategory($category_id)
        {
            $subcategory = $this->db->get_where('book_subcategory', array(
                        'category_id' => $category_id,
                        'subcategory_status' => "Active"
                    ))->result_array();
            foreach ($subcategory as $row)
            {
                echo '<option value="' . $row['subcategory_id'] . '">' . $row['subcategory_name'] . '</option>';
            }
        }

        function fine_calculate_cron_job()
        {
            $general_settings = $this->db->get('general_library_setting')->result_array();
            $general_setting_arr = array();
            foreach ($general_settings as $setting)
            {
                $general_setting_arr[$setting['setting_for']] = array(
                    "max_issue_limit" => $setting['max_issue_limit'],
                    "max_days_limit" => $setting['max_days_limit'],
                    "fine_amount" => $setting['fine_amount'],
                );
            }

            $issued_book_arr = $this->db->get_where('book_issue_table', array(
                        'status' => "Issued",
                    ))->result_array();
            foreach ($issued_book_arr as $issued_book)
            {
                $day_limit = $general_setting_arr[$issued_book['user_type']]['max_days_limit'];
                $fine_amount = $general_setting_arr[$issued_book['user_type']]['fine_amount'];
                if (!empty($day_limit) && !empty($fine_amount))
                {
                    $current_day = strtotime(date("Y-m-d"));
                    $return_last_date = strtotime("+" . $day_limit . " days", strtotime($issued_book['issue_date']));
                    if ($current_day > $return_last_date)
                    {
                        $fine_arr = array(
                            "issue_id" => $issued_book['issue_id'],
                            "fine_amount" => $fine_amount,
                            "taken_status" => "Due"
                        );
                        $this->db->insert('library_fine_table', $fine_arr);
                    }
                }
            }
        }
        
        
        /*     * ***BULK UPLOAD DATABASE********* */

        function bulk_upload($param1 = '', $param2 = '', $param3 = '')
        {
            if ($this->session->userdata('librarian_login') != 1)
                redirect(base_url(), 'refresh');
            $page_data['page_info'] = 'Bulk data upload';
            $page_data['page_name'] = 'bulk_upload';
            $page_data['page_title'] = get_phrase('bulk_data_upload');
            $this->load->view('backend/index', $page_data);
        }
        

    }
    