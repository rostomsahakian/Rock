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
    public $_email_flag = "";
    public $_pass_flag = "";
    public $_editFormData = array();
    public $_pages_instance;

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
                    $this->_editFormData['special'] = $specials;
                    $this->_editFormData['template'] = $page_editables['template'];
                    $this->_editFormData['ass_date'] = $page_editables['associated_date'];
                    $page_vars = array();
                    if ($this->_editFormData['special'] & 2) {
                        echo '<em>NOTE: this page is currenly hidden from the front-end navigation. Use the "Advanced Options" to un-hide it.<em>';
                    }
                    ?>
                    <form method="post" id="pages_form" name="form['page_edit]">
                        <div class="col-md-12">
                            <div class="panel panel-default " style="padding: 10px;" >
                                <div class="panel-heading bg-primary">Edit Page</div>
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
                                                        <label>&nbsp;</label>
                                                        <?php
                                                        $url = '/' . str_replace('', '-', $this->_editFormData['name']);
                                                        ?>
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
                                                            if ($this->_editFormData['parent'] != "0") {
                                                                $data_for_query = array(
                                                                    "table" => "pages",
                                                                    "fields" => "id",
                                                                    "value" => $this->_editFormData['parent'],
                                                                    "option" => "0");

                                                                $parent = $this->_pages_instance->getInstance($this->_editFormData['parent'], $data_for_query);
                                                                ?>
                                                                <option value="<?= $this->_pages_instace->id ?>"><?= htmlspecialchars($this->_pages_instance->name) ?></option>

                                                                <?php
                                                            } else {
                                                                ?>
                                                                <option value="0">-- None --</option>
                                                                <?php
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
                                                        <input type="date" class="form-control" name="form[page_edit][associated_date]" value="<?= $this->_editFormData['ass_date'] ?>"/>


                                                    </div>
                                                </div>
                                            </div>
                                            <!-- type, parent, date div ends-->
                                            <!--*****************-->
                                            <!-- page body text-->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Body</label>
                                                    <textarea class="form-control" rows="20"><?= htmlspecialchars($this->_editFormData['body']) ?></textarea>
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
                                                                <?php
                                                                $specials = array('Is Home Page', 'Does not appear in navigation');
                                                                for ($i = 0; $i < count($specials); ++$i) {
                                                                    if ($specials[$i] != '') {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-md-9 ">

                                                                                <input type="checkbox" name="form[page_edit][special<?= $i ?>]" 
                                                                                <?php
                                                                                if ($this->_editFormData['special'] & pow(2, $i)) {
                                                                                    echo 'checked="checked"';
                                                                                }
                                                                                ?>
                                                                                       />

                                                                                <?php
                                                                                echo $specials[$i];
                                                                                ?>
                                                                            </div>

                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>


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
                                    <input type="submit" name="form[page_edit][do_edit]" value="Update page Details" class="btn btn-primary"/>

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

}