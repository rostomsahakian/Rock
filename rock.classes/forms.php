<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of forms
 *
 * @author rostom
 */
class forms {

    public $url = '/';
    public $error = 0;
    public $error_message = array();
    public $_formdata = array();
    public $_queries;
    public $_flag = 0;
    public $_email_flag = "";
    public $_pass_flag = "";
    public $_editFormData = array();
    public $_pages_instance;
    public $_list_pages = array();
    public $_values = array();

    public function __construct() {
        $this->_queries = new queries();
        $this->_pages_instance = new Page();
    }

    public function BackEndLoginForm() {
        ?>
        <div class="container login-form">
            <div class="col-lg-12">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="panel panel-default" style="padding: 5px;">
                        <div class="panel-body" >
                            <div class="row">
                                <ul class="nav nav-tabs" role="tablist" id="tabs_login" >
                                    <li class="active" aria-controls="login" role="tab" ><a href="#admin-login" data-toggle="tab">Login</a></li>
                                    <li aria-controls="f_pass" role="tab" ><a href="#admin-forgotten-password" data-toggle="tab">Forgotten Password</a></li>
                                </ul>
                            </div>

                            <div class="tab-content">

                                <div class="tab-pane active" id="admin-login">
                                    <?php
                                    if ($this->error == 1) {
                                        ?>
                                        <div class="col-md-12" style="margin-top: 10px !important;">
                                            <div class="panel panel-danger">
                                                <div class="panel-heading">
                                                    <h5>Attention</h5>
                                                </div>
                                                <div class="panel-body danger">
                                                    <ul>
                                                        <?php
                                                        foreach ($this->error_message as $message) {

                                                            echo "<li>" . $message . "</li>";
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <form  method="post" name="form[login]">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" name="form[login][email]" id="email" value="<?php
                                                $email_v = (isset($_POST['form']['login']['email']) ? $_POST['form']['login']['email'] : '');
                                                echo $email_v
                                                ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" name="form[login][password]" id='password' value="<?php
                                                $pass_v = (isset($_POST['form']['login']['password']) ? $_POST['form']['login']['password'] : '');
                                                echo $pass_v
                                                ?>">
                                            </div>
                                            <div class="form-group">

                                                <input type="submit" name="form[login][do_login_action]" class="btn btn-primary" value="login">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane" id="admin-forgotten-password">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="token">Email</label>
                                            <input type="email" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn bg-primary" value="Send">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>If you've forgotten your password, use the form above
                                            to send a token for creating a new password, then use the token
                                            below to change your password</p>
                                        <div class="form-group">
                                            <label for="token_back">Token</label>
                                            <input class="form-control" type="text"/> 
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password">New Password</label>
                                            <input class="form-control" type="password"/> 
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password_rep">(repeat)</label>
                                            <input class="form-control" type="password"/> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn bg-primary" value="Send">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
        <center>Grow-a-Rock, All rights Reserved &copy; <?= date("Y"); ?> </center>

        <?php
    }

    public function login_check_if_user_exists(array $form_data) {

        if (!isset($form_data)) {
            return false;
        } else {
            if (array_key_exists("email", $form_data) && array_key_exists("password", $form_data)) {

                $tables = array("table1" => "user_accounts");

                $fields = array(
                    "field1" => "email",
                    "field2" => "password"
                );

                $values = array(
                    "value1" => $form_data['email'],
                    "value2" => $form_data['password']
                );

                $data_to_check = array(
                    "tables" => $tables,
                    "fields" => $fields,
                    "values" => $values
                );

                $check_if_exists = $this->_queries->checkUserInDB($data_to_check, "1");

                if ($check_if_exists) {

                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function login_check_is_email_provided($email) {
        if (!isset($email) || $email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

            return true;
        } else {
            return false;
        }
    }

    public function login_check_is_password_provided($password) {
        if (!isset($password) || $password == "") {

            return true;
        } else {
            return false;
        }
    }

    public function login_proccess(array $form_data) {

        if (isset($form_data['form']['login']['do_login_action'])) {

            $this->_formdata['email'] = $form_data['form']['login']['email'];
            $this->_formdata['password'] = $form_data['form']['login']['password'];

            /*
             * Check if the email is provided and is a valid email format
             */


            if ($this->login_check_is_email_provided($this->_formdata['email'])) {

                $this->error = 1;

                if ($this->error == 1) {
                    $error_message = array();
                    array_push($this->error_message, "Email is not provided");
                    $error_message = $this->error_message;
                }
            }
            /*
             * Check if password is provided
             */

            if ($this->login_check_is_password_provided($this->_formdata['password'])) {

                $this->error = 1;

                if ($this->error == 1) {
                    $error_message = array();
                    array_push($this->error_message, "password is not provided");
                    $error_message = $this->error_message;
                }
            }

            if ($this->error == 0) {
                $check_if_valid = array(
                    "email" => $this->_formdata['email'],
                    "password" => md5($this->_formdata['password'])
                );
                if ($this->login_check_if_user_exists($check_if_valid)) {


                    $data_received = $this->_queries->RetData();
                    foreach ($data_received as $data) {

                        $_SESSION['userdata'] = $data;
                        $groups = json_decode($data['groups']);
                        $_SESSION['userdata']['groups'] = array();
                        foreach ($groups as $g) {
                            $_SESSION['userdata']['groups'][$g] = true;
                            if ($data['extras'] == '') {
                                $data['extras'] = '[]';
                                $_SESSION['userdata']['extras'] = json_decode($data['extras']);
                                $this->login_redirect("?cmd=menus&option=true", "success");
                            }
                        }
                    }
                } else {
                    $this->error = 1;

                    if ($this->error == 1) {
                        $error_message = array();
                        array_push($this->error_message, "login failed. Please try again!");
                        $error_message = $this->error_message;
                    }
                }
            }
        }
    }

    /*
     * @Athu: Rostom
     * Desc: helper function
     */

    public function login_redirect($url, $msg = 'success') {
        if ($msg) {
            $this->url = $url;
            $this->url .="&login_msg=" . $msg;
            header('Location:' . $this->url);
            exit;
        }
    }

    public function EditPageForm(array $page_data = NULL, $page_id) {
        /*
         * Check if the page id isset by user
         */
        $page_id = (isset($page_id) ? $page_id : 0);


        /*
         * break down the recieved data
         */
        if ($page_data != NULL) {
            foreach ($page_data as $page_editables) {
                if ($page_editables['id'] == $page_id) {
                    $page_vars = json_decode($page_editables['vars'], true);
                    $edit = true;
                    $specials = 0;
                    if (isset($_REQUEST['hidden'])) {
                        $specials +=2;
                    }
                    $this->_editFormData['id'] = $page_editables['id'];
                    $this->_editFormData['parent'] = $page_editables['parent'];
                    $this->_editFormData['type'] = 0;
                    $this->_editFormData['body'] = $page_editables['body'];
                    $this->_editFormData['name'] = $page_editables['name'];
                    $this->_editFormData['ord'] = $page_editables['ord'];
                    $this->_editFormData['title'] = $page_editables['title'];
                    $this->_editFormData['description'] = $page_editables['description'];
                    $this->_editFormData['keywords'] = $page_editables['keywords'];
                    $this->_editFormData['special'] = $page_editables['special'];
                    $this->_editFormData['template'] = $page_editables['template'];
                    $this->_editFormData['ass_date'] = $page_editables['associated_date'];
                    $page_vars = array();
                    if ($this->_editFormData['special'] & 2) {
                        echo '<em>NOTE: this page is currenly hidden from the front-end navigation. Use the "Advanced Options" to un-hide it.<em>';
                    }
                    ?>
                    <?php
                    if ($this->_flag == 1) {
                        ?>
                        <div class="col-md-12" style="margin-top: 10px !important;">

                            <div class="list-group">
                                <ul>
                                    <?php
                                    foreach ($this->error_message as $message) {

                                        echo "<li class='list-group-item list-group-item-warning'><i class='glyphicon glyphicon-info-sign'></i>&nbsp;" . $message . "</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <form method="post" id="pages_form" name="form['page_edit]" enctype="multipart/form-data">
                        <div class="col-md-12">

                            <div class="panel panel-default " style="padding: 10px;" >
                                <div class="panel-heading bg-primary">Edit <?= $this->_editFormData['name'] ?></div>
                                <div class="panel-body" >

                                    <input type="hidden" name="form[page_edit][id]" value="<?= $page_id; ?>"/>
                                    <div class="row">
                                        <ul class="nav nav-tabs" role="tablist" id="tabs_editpage" >
                                            <li class="active" aria-controls="login" role="tab" ><a href="#tabs-common-details" data-toggle="tab">Common Details</a></li>
                                            <li aria-controls="f_pass" role="tab" ><a href="#tabs-advanced-options" data-toggle="tab">Advanced Options</a></li>
                                            <!--add plugin tabs here-->
                                        </ul>
                                    </div>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="tabs-common-details">

                                            <!-- name and title div-->
                                            <div class="row" style="margin-top:5px; ">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>name</label>
                                                        <input type="text" name="form[page_edit][page_name]" value="<?= htmlspecialchars($this->_editFormData['name']) ?>" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>title</label>
                                                        <input type="text" name="form[page_edit][page_title]" value="<?= htmlspecialchars($this->_editFormData['title']) ?>" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <label>Preview</label>
                                                        <?php
                                                        $url = '/' . str_replace('', '-', $this->_editFormData['name']);
                                                        ?>
                                                        <input type="button" name="prev" class="form-control" value="Preview"/> 
                                                        <a href="<?= $url ?>" target="_blank">View page</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- name and tile div ends-->
                                            <!--*****************-->
                                            <!-- type, parent, date div begins-->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>type</label>
                                                        <select name="form[page_edit][type]" class="form-control">
                                                            <option value="0">Normal</option>
                                                            <!-- insert plugin page types here-->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>parent</label>
                                                        <select name="form[page_edit][parent]" class="form-control">
                                                            <?php
                                                            /*
                                                             * If the parent is zero meaning it is a top level page do not change the parent
                                                             * If you want to make a page then use it under page
                                                             */

                                                            $tables = array("table1" => "pages");
                                                            $fields = array(
                                                                "field1" => "id",
                                                                "field2" => "name",
                                                                "field3" => "parent",
                                                                "field4" => "ord",
                                                            );
                                                            $values = array(
                                                                "value1" => 0,
                                                                "value2" => $this->_editFormData['id']
                                                            );
                                                            $child_data = array(
                                                                "tables" => $tables,
                                                                "fields" => $fields,
                                                                "values" => $values
                                                            );
                                                            $this->_queries->_res = NULL;
                                                            $get_data_child_parent = $this->_queries->findChildren($child_data, $option = 1);
                                                            $get_data_child_parent = $this->_queries->RetData();
                                                            ?>

                                                            <?php
                                                            if ($this->_editFormData['parent'] == 0)
                                                                
                                                                ?>
                                                            <option value="0">-- None --</option>
                                                            <?php
                                                            if ($get_data_child_parent != NULL) {
                                                                foreach ($get_data_child_parent as $parents) {
                                                                    if ($this->_editFormData['parent'] == $parents['id']) {

                                                                        $selected = "selected='selected'";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                    ?>

                                                                    <option value="<?= $parents['id'] ?>" <?= $selected ?>><?= $parents['name'] ?></option>


                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Associated Date</label>
                                                        <?php
                                                        if (!isset($this->_editFormData['ass_date']) ||
                                                                !preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $this->_editFormData['ass_date']) ||
                                                                $this->_editFormData['ass_date'] == '0000-00-00') {
                                                            $this->_editFormData['ass_date'] = date('Y-m-d');
                                                        }
                                                        ?>
                                                        <input type="date" id="date-human" class="form-control" name="form[page_edit][associated_date]" value="<?= $this->_editFormData['ass_date'] ?>"/>


                                                    </div>
                                                </div>
                                            </div>
                                            <!-- type, parent, date div ends-->
                                            <!--*****************-->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><span><i class="glyphicon glyphicon-picture"  ></i>&nbsp;Upload Images</span></div>
                                                        <input type="file" name="form[page_edit][images]"  value="" style="margin: 10px;;"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><span><i class="glyphicon glyphicon-file" ></i>&nbsp;Upload Files</span></div>
                                                        <input type="file" name="form[page_edit][files]"  value=""  style="margin: 10px; "/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- page body text-->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Body</label>
                    <!--                                                    <textarea class="form-control" rows="20" name="form[page_edit][content]"><?php //htmlspecialchars($this->_editFormData['body'])   ?></textarea>-->
                                                    <?= $this->ckeditor('form[page_edit][content]', $this->_editFormData['body']) ?>
                                                </div>
                                            </div>
                                        </div>                            

                                        <!--Advanced edit part starts-->
                                        <div class="tab-pane" id="tabs-advanced-options">
                                            <div class="col-md-12">
                                                <div class="row" style="margin-top:5px; ">
                                                    <!-- Meta Data-->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading bg-primary">
                                                                    <label>MetaData</label>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <label>keywords</label>
                                                                    <input type="text" name="form[page_edit][keywords]" value="<?= htmlspecialchars($this->_editFormData['keywords']) ?>" class="form-control"/>
                                                                    <label>description</label>

                                                                    <input type="text" name="form[page_edit][description]" value="<?= htmlspecialchars($this->_editFormData['description']) ?>" class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--END MetaData-->
                                                    <!-- Special case-->
                                                    <div class="col-md-4">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading bg-primary">
                                                                <label>Special</label>
                                                            </div>
                                                            <div class="panel-body">

                                                                <div class="row">
                                                                    <table style="margin-left: 20px;">
                                                                        <?php
                                                                        if ($this->_editFormData['special'] == '1') {
                                                                            $checked = 'checked="checked"';
                                                                        } else {
                                                                            $checked = "";
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="checkbox" name="form[page_edit][is_homepage]" <?= $checked ?>/>

                                                                                <span>Is Home Page</span>
                                                                            </td>
                                                                        </tr>

                                                                        <?php
                                                                        if ($this->_editFormData['special'] != 1 && $this->_editFormData['special'] != 0) {

                                                                            $checked = 'checked="checked"';
                                                                        } else {

                                                                            $checked = "";
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="checkbox" name="form[page_edit][is_hidden]" <?= $checked ?>/>
                                                                                <span>Does not appear in navigation</span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--END Special case-->
                                                    <!--other-->
                                                    <div class="col-md-4">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading bg-primary">
                                                                <label>Other</label>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-9 ">
                                                                        <div class="form-group">
                                                                            <label>Order of</label>
                                                                            <select class="form-control" name="form[page_edit][page_vars][order_of_sub_pages]">
                                                                                <?php
                                                                                $arr = array('as shown in admin menu', 'alphabetically', 'by associated date');
                                                                                foreach ($arr as $k => $v) {
                                                                                    if (isset($page_vars['order_of_sub_pages']) &&
                                                                                            $page_vars['order_of_sub_pages'] == $k) {
                                                                                        $selected = "selected='selected'";
                                                                                    } else {
                                                                                        $selected = "";
                                                                                    }
                                                                                    ?>
                                                                                    <option value="<?= $k ?>" <?= $selected ?>>                                                                             
                                                                                        <?= $v; ?>
                                                                                    </option>
                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <div class="form-group">
                                                                            <label>Sub-pages</label>
                                                                            <select class="form-control" name="form[page_edit][page_vars][order_of_sub_pages_dir]">
                                                                                <option value="0">ascending (a-z, 0-9)</option>
                                                                                <?php
                                                                                if (isset($page_vars['order_of_sub_pages_dir']) == '1') {
                                                                                    $sub_selected = 'selected="selected"';
                                                                                } else {
                                                                                    $sub_selected = "";
                                                                                }
                                                                                ?>
                                                                                <option value="1">descending (z-a, 9-0)</option>


                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">

                                    <input type="submit" name="form[page_edit][action]" value="<?= $edit ? 'Update Page Details' : 'Insert Page Details' ?>" class="btn btn-primary"/>



                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                } else {
                    echo "page not found error#10";
                }
            }
        } else {
            #Error #11 null value for the first argument
            echo "page not found error#11";
        }
    }

    public function ListAllPagesOnMainContent(array $list_pages) {
        $this->_list_pages = $list_pages;
        //var_dump($this->_list_pages);
        ?>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span>Edit Your Pages</span>                    
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr class="active">
                            <th>#</th>
                            <th>Order</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Actions</th>
                            <?php
                            foreach ($this->_list_pages as $do_list_pages) {
                                ?>
                            </tr>
                            <tr>
                                <td>
                                    <?= $do_list_pages['id'] ?>
                                </td>
                                <td>
                                    <?php
//                                    if(isset($_REQUEST['new_order']) && isset($_REQUEST['page_id']) && $_REQUEST['page_id'] == $do_list_pages['id']){
//                                        $do_list_pages['ord'] = $_REQUEST['new_order'];
//                                    }
                                    ?>
                                    <form  method="post">
                                        <input  type="text"  style="width: 25px; text-align:center;" name="new_order" value="<?= (isset($do_list_pages['ord']) && $do_list_pages['ord'] != '') ? $do_list_pages['ord'] : 0; ?>"/>
                                        <input type="hidden" name="page_id" value="<?= $do_list_pages['id'] ?>"/>
                                        <input type="hidden" name="old_order" value="<?= $do_list_pages['ord'] ?>" />
                                        <input type="hidden" name="parent" value="<?= $do_list_pages['parent'] ?>"/>
                                        <input type="hidden" name="cmd" value="choose_edit_page"/>
                                        <input type="submit"  name="do_update_order" class="btn btn-default btn-xs" value="update"/>
                                    </form>

                                </td>
                                <td>
                                    <?= $do_list_pages['name'] ?>
                                </td>
                                <td>
                                    <?= $do_list_pages['parent'] ?>
                                </td>
                                <td>
                                    <?= $do_list_pages['title'] ?>
                                </td>

                                <td>
                                    Admin
                                </td>
                                <td>
                                    <?= $do_list_pages['cdate'] ?>
                                </td>
                                <td>
                                    <a href="?cmd=choose_edit_page&option=delete&page_id=<?= $do_list_pages['id'] ?>"><i class="glyphicon glyphicon-trash"></i></a>

                                    <a href="?cmd=edit_page&option=edit&page_id=<?= $do_list_pages['id'] ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                                </td>


                            </tr>
                        <?php } ?>
                    </table>

                </div>
            </div>
        </div>

        <?php
    }

    public function DoUpdateOrderForPages(array $order_data) {

        if (isset($_REQUEST['do_update_order'])) {

            $new_order = $order_data[0];
            $old_order = $order_data[1];
            $page_id = $order_data[2];
            $parent = $order_data[3];
            $data = array(
                "table" => "pages",
                "field" => "parent",
                "value" => $parent
            );

            if ($parent != 0 || $parent != "0") {
                $get_child_data = $this->_queries->findParent($data, $option = "2");
            } else {
                $get_child_data = $this->_queries->findParent($data, $option = "2");
                $get_child_data = $this->_queries->RetData();
            }
            foreach ($get_child_data as $child) {

                $table = array("table1" => "pages");
                $fields = array("field1" => "ord", "field2" => "id");
                $values = array("value1" => $new_order, "value2" => $page_id);

                $update_order_array = array(
                    "tables" => $table,
                    "fields" => $fields,
                    "values" => $values
                );
                $update_order_query = $this->_queries->UpdateQueriesServices($update_order_array, $option = "1");
            }
        }
    }

    /*
     * Reference to page data in array
     * each nuber represents the key for the value
     *  #[0] = Name
      #[1] = Title
      #[2] = Type
      #[3] = ID
      #[4] = Parent
      #[5] = Associated date
      #[6] = Content {Body}
      #[7] = Keywords
      #[8] = Description
      #[9] = Special 1 is home page?
      #[10] = Special 2 is hidden pahe?
      #[11] = vars json
     */

    public function setupPagesNames(array $page_form_data) {


        $table = array("table1" => "pages");
        $fields = array(
            "field1" => "id",
            "field2" => "name",
            "field3" => "parent",
        );
        $values = array(
            "value1" => $page_form_data[0],
            "value2" => $page_form_data[4],
            "value3" => $page_form_data[3],
        );
        $check_name = $this->_queries->GetData($table, $fields, $values, $option = "4");

        if ($check_name === true) {
            return true;
        } else {
            return false;
        }
    }

    public function setupSpecialPages(array $page_from_data) {


        $special = (isset($page_from_data[9]) && ($page_from_data[9] == "on" && (isset($page_from_data[0]) && ($page_from_data[0] == "Home"))) ? 1 : 0);

        $table = array("table1" => "pages");
        $fields = array("field1" => "id", "field2" => "special");
        $values = array("value1" => "num_specials", "value2" => 1, "value3" => $page_from_data[3]);

        $check_home_page = $this->_queries->GetData($table, $fields, $values, $option = "5");
        $check_home_page = $this->_queries->RetData();
        $this->_values = $check_home_page;
        if ($check_home_page === true) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Reference to page data in array
     * each nuber represents the key for the value
     *  #[0] = Name
      #[1] = Title
      #[2] = Type
      #[3] = ID
      #[4] = Parent
      #[5] = Associated date
      #[6] = Content {Body}
      #[7] = Keywords
      #[8] = Description
      #[9] = Special 1 is home page?
      #[10] = Special 2 is hidden pahe?
      #[11] = vars json
      #[12] = transmission type Update or Save
     */

    public function UpdatePages(array $page_form_data, $type = NULL) {
        if ($type != NULL) {
            switch ($type) {
                case "update_page_details":
                    $update_vars = array(
                        "'" . date("Y,m,d") . "',",
                        "'" . addslashes($page_form_data[2]) . "',",
                        "'" . addslashes($page_form_data[5]) . "',",
                        "'" . addslashes($page_form_data[7]) . "',",
                        "'" . addslashes($page_form_data[8]) . "',",
                        "'" . addslashes($page_form_data[0]) . "',",
                        "'" . addslashes($page_form_data[1]) . "',",
                        "'" . addslashes($page_form_data[6]) . "',",
                        "'" . $page_form_data[4] . "',",
                        "'" . addslashes($page_form_data[11]) . "'"
                    );
                    $fields = array(
                        "edate",
                        "type",
                        "associated_date",
                        "keywords",
                        "description",
                        "name",
                        "title",
                        "body",
                        "parent",
                        "vars",
                    );

                    $data_for_query = array(
                        "table" => "pages",
                        "value1" => $update_vars,
                        "field" => $fields,
                        "field2" => "id",
                        "value2" => $page_form_data[3]
                    );
                    $data_to_update = $this->_queries->UpdateQueriesServices($data_for_query, $option = "3");
                    if ($data_to_update) {
                        return true;
                    } else {
                        return false;
                    }
                    break;
                case "insert_page_details":
                    break;
            }
        }
    }

    public function ReturnMessages(array $message, $flag_value = 0) {

        if (isset($message) && $message != NULL && $flag_value != 0) {
            $this->_flag = $flag_value;
            array_push($this->error_message, $message['message']);
            $message = $this->error_message;
        }
    }

    public function ReturnvaluesFromFormsFunctions() {
        return $this->_values;
    }

    public function ckeditor($name, $value = '', $height = 450) {
        return ' <textarea class="form-control" rows="20" name="' . addslashes($name) . '">' . htmlspecialchars($value) . '</textarea>'
                . '<script> CKEDITOR.replace( "' . $name . '" ); </script>';
    }

    public function Do_Upload_images($image, $path, $date_added, $page_uid, $page_type) {

        $dir = IMAGE_PATH;
        $image_file = $dir . basename($_FILES["uploadimage"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($image_file, PATHINFO_EXTENSION);
        if (isset($_POST['imgupload'])) {
            $check = getimagesize($_FILES["uploadimage"]["tmp_name"]);
            if ($check !== FALSE) {
                $this->ReturnMessages("File is an image - " . $check["mime"] . ".");

                $uploadOk = 1;
            } else {
                $this->ReturnMessages("File is not an image.");
                $uploadOk = 0;
            }
        }
//        if (file_exists($image_file)) {
//            $this->ErrorMessages("Sorry, file already exists.");
//            $uploadOk = 0;
//        }
        if ($_FILES['uploadimage']["size"] > 5000000) {
            $this->ReturnMessages("Sorry, your file is too large.");
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $this->ReturnMessages("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            $this->ReturnMessages("Sorry, your file was not uploaded.");
        } else {
            if (move_uploaded_file($_FILES["uploadimage"]["tmp_name"], $image_file)) {
                $this->ReturnMessages("<br/>The file " . basename($_FILES["uploadimage"]["name"]) . " has been uploaded.");
                $image_name = basename($_FILES["uploadimage"]["name"]);

                //$this->SavePageUID($page_uid, $page_type);
                //$this->_values['one'] = $page_uid;
                //$this->_values['two'] = $page_type;
                //$this->_values['three'] = $date_added;
                // $this->Insert_Into_generic("page_content", "page_id", "page_type", "page_added", NULL, $this->_values);

                $sql = "INSERT INTO `page_images`(`page_uid`,`image_path`, `image_name`, `date_added`) VALUES ('$page_uid','$path','$image_name','$date_added')";

                $result = $this->_mysqli->query($sql);
            } else {
                $this->ReturnMessages("Sorry, there was an error uploading your file.");
            }
        }
    }

}
