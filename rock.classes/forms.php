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
    public $_url;
    public $_message = array();
    public $_page_type = array();
    public $_fields = array();
    public $_more_inputs = array();
    public $_uploads;

    public function __construct() {
        $this->_queries = new queries();
        $this->_pages_instance = new Page();
        $this->_uploads = new uploads();
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

    public function EditPageForm(array $page_data = NULL, array $url_options = NULL, array $images = NULL, array $files = NULL, $page_id) {

        /*
         * Check if the page id isset by user
         */
        $page_id = (isset($page_id) ? $page_id : 0);


        /*
         * break down the recieved data
         */
        if ($page_data != NULL) {


            if ($page_data[0]['id'] == $page_id) {
                $page_vars = json_decode($page_data[0]['vars'], true);
                $edit = true;
                $specials = 0;
                if (isset($_REQUEST['hidden'])) {
                    $specials +=2;
                }
                $this->_editFormData['id'] = $page_data[0]['id'];
                $this->_editFormData['parent'] = $page_data[0]['parent'];
                $this->_editFormData['type'] = $page_data[0]['type'];
                $this->_editFormData['body'] = $page_data[0]['body'];
                $this->_editFormData['name'] = $page_data[0]['name'];
                $this->_editFormData['ord'] = $page_data[0]['ord'];
                $this->_editFormData['title'] = $page_data[0]['title'];
                $this->_editFormData['description'] = $page_data[0]['description'];
                $this->_editFormData['keywords'] = $page_data[0]['keywords'];
                $this->_editFormData['special'] = $page_data[0]['special'];
                $this->_editFormData['template'] = $page_data[0]['template'];
                $this->_editFormData['ass_date'] = $page_data[0]['associated_date'];

                if ($url_options != NULL) {

                    $this->_editFormData['url_option'] = $url_options[0]['option'];
                    $this->_editFormData['url_page_id'] = $url_options[0]['page_id'];
                } else {
                    $this->_editFormData['url_option'] = "short";
                    $this->_editFormData['url_page_id'] = $url_options[0]['page_id'];
                }

                $_SESSION['id'] = $this->_editFormData['id'];


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
                <form method="post" id="pages_form" name="form[page_edit]" enctype="multipart/form-data">
                    <div class="col-md-12">

                        <div class="panel panel-default " style="padding: 10px;" >
                            <div class="panel-heading bg-primary">Edit <?= $this->_editFormData['name'] ?></div>
                            <div class="panel-body" >

                                <input type="hidden" name="form[page_edit][id]" value="<?= $page_id; ?>"/>
                                <div class="row">
                                    <ul class="nav nav-tabs" role="tablist" id="tabs_editpage" >
                                        <li class="active" aria-controls="login" role="tab" ><a href="#tabs-common-details" data-toggle="tab">Common Details</a></li>
                                        <li aria-controls="f_pass" role="tab" ><a href="#tabs-advanced-options" data-toggle="tab">Advanced Options</a></li>
                                        <li aria-controls="f_pass" role="tab" ><a href="#tabs-images" data-toggle="tab">Images</a></li>
                                        <li aria-controls="f_pass" role="tab" ><a href="#tabs-files" data-toggle="tab">Files</a></li>
                                        <!--add plugin tabs here-->
                                        <li class=""> </li>
                                    </ul>

                                </div>
                                <div class="tab-content">

                                    <div class="tab-pane active" id="tabs-common-details">

                                        <!-- name and title div-->
                                        <div class="row" style="margin-top:5px; ">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>name</label>
                                                    <input type="text" name="form[page_edit][page_name]" value="<?= (isset($_REQUEST['form']['page_edit']['page_name']) ? $_REQUEST['form']['page_edit']['page_name'] : htmlspecialchars($this->_editFormData['name'])) ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>title</label>
                                                    <input type="text" name="form[page_edit][page_title]" value="<?= (isset($_REQUEST['form']['page_edit']['page_title']) ? $_REQUEST['form']['page_edit']['page_title'] : htmlspecialchars($this->_editFormData['title'])) ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <?php
                                                $url_array = array(
                                                    "parent_id" => (isset($_REQUEST['form']['page_edit']['parent']) ? $_REQUEST['form']['page_edit']['parent'] : $this->_editFormData['parent']),
                                                    "id" => $this->_editFormData['id'],
                                                    "selected" => (isset($_REQUEST['form']['page_edit']['url_rewrite']) ? $_REQUEST['form']['page_edit']['url_rewrite'] : $this->_editFormData['url_option']),
                                                    "page_name" => (isset($_REQUEST['form']['page_edit']['page_name']) ? $_REQUEST['form']['page_edit']['page_name'] : $this->_editFormData['name']),
                                                );



                                                $set_url = $this->URL_RE_WRITER($url_array);
                                                $set_url = $this->RET_URL();
                                                ?>
                                                <a href="<?= $set_url ?>" target="_blank" class="btn bg-primary">View page</a>
                                            </div>


                                        </div>
                                        <?php ?>
                                        <!-- name and tile div ends-->
                                        <!--*****************-->
                                        <!-- type, parent, date div begins-->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>type</label>
                                                    <select name="form[page_edit][type]" class="form-control">
                                                        <?php
                                                        $this->DefinePageTypes();
                                                        $page_type = $this->RetPageTypes();

                                                        foreach ($page_type as $k => $p_type) {

                                                            // var_dump($k);
                                                            ?>
                                                            <option value="<?= (isset($_REQUEST['form']['page_edit']['type']) ? $_REQUEST['form']['page_edit']['type'] : $k) ?>"><?= $p_type ?></option>
                                                            <!-- insert plugin page types here-->

                                                        <?php } ?>
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
                                                        if ((isset($_REQUEST['form']['page_edit']['parent']) ? $_REQUEST['form']['page_edit']['parent'] == 0 : $this->_editFormData['parent'] == 0))
                                                            
                                                            ?>
                                                        <option value="0">-- None --</option>
                                                        <?php
                                                        if ($get_data_child_parent != NULL) {
                                                            foreach ($get_data_child_parent as $parents) {
                                                                if ((isset($_REQUEST['form']['page_edit']['parent']) ? $_REQUEST['form']['page_edit']['parent'] == $parents['id'] : $this->_editFormData['parent'] == $parents['id'])) {

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
                                                    <input type="date" id="date-human" class="form-control" name="form[page_edit][associated_date]" value="<?= (isset($_REQUEST['form']['page_edit']['associated_date']) ? $_REQUEST['form']['page_edit']['associated_date'] : $this->_editFormData['ass_date']) ?>"/>


                                                </div>
                                            </div>
                                        </div>
                                        <!-- type, parent, date div ends-->
                                        <!--*****************-->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="panel panel-default">

                                                    <div class="panel-heading"><span><i class="glyphicon glyphicon-picture"  ></i>&nbsp;Upload Images</span></div>
                                                    <div class="panel-body">
                                                        <input type="file" name="form[page_edit][uploadimage]"  class="btn btn-default btn-xs"/>

                                                        <input type="submit" class="btn btn-danger btn-xs" name="form[page_edit][douploadimage]" value="Upload" style="margin-top: 10px;"/>
                                                    </div>



                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><span><i class="glyphicon glyphicon-file" ></i>&nbsp;Upload Files</span></div>
                                                    <div class="panel-body">
                                                        <input type="file" name="form[page_edit][uploadfile]"   class="btn btn-default btn-xs"/>

                                                        <input type="submit" class="btn btn-success btn-xs" name="form[page_edit][douploadfile]" value="Upload" style="margin-top: 10px;"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--URL Options-->
                                            <div class="col-md-4">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading"><span><i class="glyphicon glyphicon-transfer"></i>&nbsp;Url Options</span></div>
                                                                <div class="panel-body">

                                                                    <table class="table">
                                                                        <tr>
                                                                            <td>
                                                                                <span class="small">Short URL</span>   
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $check_short = '';
                                                                                $check_long = '';
                                                                                $option_url = (isset($_REQUEST['form']['page_edit']['url_rewrite']) ? $_REQUEST['form']['page_edit']['url_rewrite'] : $this->_editFormData['url_option']);

                                                                                if ($option_url == "short") {

                                                                                    $check_short = 'checked="checked"';
                                                                                    $check_long = '';
                                                                                } else {
                                                                                    $check_short = '';
                                                                                    $check_long = 'checked="checked"';
                                                                                }
                                                                                ?>
                                                                                <input type="radio" name="form[page_edit][url_rewrite]" value="short" <?= $check_short ?> />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="small">Long URL</span> 
                                                                            </td>
                                                                            <td>


                                                                                <input type="radio" name="form[page_edit][url_rewrite]" value="long"  <?= $check_long ?>/> 

                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <input type="submit" name="form[page_edit][rewrite_url]" value="Set url mode" class="btn btn-success btn-xs"/>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <?php
                                        /*
                                         * If page type is categories == 9 then do it per designer 
                                         * else if page type is 5 
                                         */
                                        if ($this->_editFormData['type'] == "9") {

                                            if (isset($_REQUEST['form']['page_edit']['dolinkbrand'])) {
                                                $brand_id = isset($_REQUEST['form']['page_edit']['brand_name']) ? $_REQUEST['form']['page_edit']['brand_name'] : NULL;
                                                $brand_table = isset($_REQUEST['form']['page_edit']['table_name']) ? $_REQUEST['form']['page_edit']['table_name'] : NULL;
                                                $brand_name = isset($_REQUEST['form']['page_edit']['b_real_name']) ? $_REQUEST['form']['page_edit']['b_real_name'] : NULL;
                                                $choice = isset($_REQUEST['form']['page_edit']['choice']) ? $_REQUEST['form']['page_edit']['choice'] : 'gender';

                                                $brand_data = array(
                                                    "id" => $brand_id,
                                                    "table" => "brands",
                                                    "parent" => $this->_editFormData['id'],
                                                    "choice" => $choice,
                                                    "brand_name" => $brand_name,
                                                    "page_name" => $this->_editFormData['name']
                                                );
                                                $this->GetAllBrandInfo($brand_data);
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><i class="fa fa-link"></i>&nbsp; Link your brand</div>
                                                        <div class="panel-body">

                                                            <div class="form-group">
                                                                <select name="form[page_edit][brand_name]" class="form-control">
                                                                    <?php
                                                                    $value = array(
                                                                        "patern" => "rock_"
                                                                    );
                                                                    $this->_queries->_res = NULL;
                                                                    $see_brands = $this->_queries->GetData("brands", NULL, NULL, $option = "7");
                                                                    $see_brands = $this->_queries->RetData();

                                                                    foreach ($see_brands as $brands) {

                                                                        if (count($brands) > 0) {
                                                                            ?>
                                                                            <option value="<?= $brands['id'] ?>"><?= $brands['brand'] ?></option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="--none--">--No Brand Tables--</option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>

                                                                <div class="form-group">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <?php
                                                                            $checked_1 = '';
                                                                            $checked_2 = '';
                                                                            $choice_value = (isset($_REQUEST['form']['page_edit']['choice']) ? isset($_REQUEST['form']['page_edit']['choice']) : '');
                                                                            if ($choice_value == "category") {
                                                                                $checked_1 = 'checked="checked"';
                                                                                $checked_2 = '';
                                                                            } else {
                                                                                $checked_1 = '';
                                                                                $checked_2 = 'checked="checked"';
                                                                            }
                                                                            ?>

                                                                            <td>By Category <input type="radio" name="form[page_edit][choice]" value="category" <?= $checked_1 ?> /></td>
                                                                            <td>By Gender <input type="radio" name="form[page_edit][choice]" value="gender"  <?= $checked_2 ?>/> </td>
                                                                        </tr>

                                                                    </table>
                                                                </div>
                                                                <div class="form-group" style="margin-top:10px;">

                                                                    <input type="submit" name="form[page_edit][dolinkbrand]" value="Link band" class="btn btn-success btn-xs"/>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        } else if ($this->_editFormData['type'] == "3") {
                                            /*
                                             * If page type is 3 it is category so lets say we have mens it should show all mens products by categories
                                             */
                                            if (isset($_REQUEST['form']['page_edit']['dogetcats'])) {
                                                $selection = $_REQUEST['form']['page_edit']['get_cats'];
                                                $selection_parent_id = $this->_editFormData['id'];

                                                $data_for_function_get_by_category = array(
                                                    "selection" => $selection,
                                                    "parent_id" => $selection_parent_id
                                                );
                                                /*
                                                 * Call the function
                                                 */
                                                $this->GetProductsBycategory($data_for_function_get_by_category);
                                            }
                                            ?>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><span>Set Products</span></div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <select name="form[page_edit][get_cats]">
                                                                    <?php
                                                                    $this->_queries->_res = NULL;
                                                                    $get_cats_form_all = $this->_queries->GetData("all_products", "gender", NULL, $option = "8");
                                                                    $get_cats_form_all = $this->_queries->RetData();
                                                                    if ($get_cats_form_all != NULL) {
                                                                        foreach ($get_cats_form_all as $unique_cats) {
                                                                            ?>

                                                                            <option value="<?= $unique_cats['gender'] ?>"><?= $unique_cats['gender'] ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="form-group" style="margin-top:10px;">

                                                                    <input type="submit" name="form[page_edit][dogetcats]" value="Link Categories" class="btn btn-success btn-xs"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>  
                                            </div>


                                        <?php } ?>
                                        <!-- page body text-->
                                        <div class="row">
                                            <div class="col-md-12">

                                                <label>Body</label>                                                                
                                                <?= $this->ckeditor('form[page_edit][content]', (isset($_REQUEST['form']['page_edit']['content']) ? $_REQUEST['form']['page_edit']['content'] : $this->_editFormData['body'])) ?>    
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
                                                                <input type="text" name="form[page_edit][keywords]" value="<?= (isset($_REQUEST['form']['page_edit']['keywords']) ? $_REQUEST['form']['page_edit']['keywords'] : htmlspecialchars($this->_editFormData['keywords'])) ?>" class="form-control"/>
                                                                <label>description</label>

                                                                <input type="text" name="form[page_edit][description]" value="<?= (isset($_REQUEST['form']['page_edit']['description']) ? $_REQUEST['form']['page_edit']['description'] : htmlspecialchars($this->_editFormData['description'])) ?>" class="form-control"/>
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
                                                                            <input type="hidden" value="<?= $this->_editFormData['url_option'] ?>" name="form[page_edit][url_option]"/>
                                                                            <input type="hidden" value="<?= $this->_editFormData['url_page_id'] ?>" name="form[page_edit][url_page_id]"/>
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
                                    <!---Images Tab--->
                                    <div class="tab-pane" id="tabs-images">
                                        <div class="col-md-12">
                                            <div class="row" style="margin-top:5px; ">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><span>Images</span><p>To use the image simply copy this url: <strong><?= $images[0]['image_path'] ?></strong> and the name of the image.</p></div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <?php
                                                            if ($images != NULL) {
                                                                foreach ($images as $image) {
                                                                    ?>

                                                                    <div class="col-xs-7 col-md-2">
                                                                        <a href="<?= $image['image_path'] . $image['image_name'] ?>" target="_blank" class="thumbnail">
                                                                            <img src="<?= $image['image_path'] . $image['image_name'] ?>" alt=" " title="">
                                                                        </a>
                                                                        <a  href="<?= $image['image_path'] . $image['image_name'] ?>" target="_blank"  class="caption">
                                                                            <p style="font-size: 10px"><?= $image['image_name'] ?></p>





                                                                        </a>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <p>This page currently has no images.</p>
                                                            <?php }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--END Images Tab-->
                                    <!--****-->
                                    <!--Files Tab -->
                                    <!--Advanced edit part starts-->
                                    <div class="tab-pane" id="tabs-files">
                                        <div class="col-md-12">
                                            <div class="row" style="margin-top:5px; ">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><span> Files</span></div>
                                                    <div class="panel-body">
                                                        <?php
                                                        if ($files != NULL) {
                                                            foreach ($files as $file) {

                                                                if ($file['file_extension'] == "css") {
                                                                    $file_image = ABSOLUTH_PATH_IMAGES . "images_css.png";
                                                                } else if ($file['file_extension'] == "pdf") {
                                                                    $file_image = ABSOLUTH_PATH_IMAGES . "image_pdf.png";
                                                                } else if ($file['file_extension'] == "js") {
                                                                    $file_image = ABSOLUTH_PATH_IMAGES . "image_js.png";
                                                                } else if ($file['file_extension'] == "csv") {
                                                                    $file_image = ABSOLUTH_PATH_IMAGES . "image_csv.png";
                                                                }
                                                                ?>

                                                                <div class="col-xs-6 col-md-1">
                                                                    <a href="#" class="thumbnail">
                                                                        <img src="<?= $file_image ?>" alt=" " title="">
                                                                    </a>
                                                                    <a class="caption">
                                                                        <p style="font-size: 9px;"><?= $file['file_name'] ?></p>
                                                                    </a>
                                                                </div>
                                                                <?php
                                                            }
                                                        } else {
                                                            
                                                        }
                                                        ?>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!--END Files Tab-->
                                    <!--****-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" value="<?= $this->_editFormData['type'] ?>" name="form[page_edit][type]"/>
                                <input type="submit" name="form[page_edit][action]" value="<?= $edit ? 'Update Page Details' : 'Insert Page Details' ?>" class="btn btn-primary"/>



                            </div>
                        </div>
                    </div>
                </form>

                <?php
            } else {
                echo "page not found error#10";
            }
        } else {
#Error #11 null value for the first argument
            echo "page not found error#11";
        }
    }

    public function ListAllPagesOnMainContent(array $list_pages) {
        $this->_list_pages = $list_pages;
        ?>
        <div class="col-lg-12">
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
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form  method="post">
                                                <input type="hidden" name="p_id" value="<?= $do_list_pages['id'] ?>"/>
                                                <input type="hidden" name="page_parent" value="<?= $do_list_pages['parent'] ?>"/>
                                                <input type="hidden" name="cmd" value="choose_edit_page"/>
                                                <input type="submit"  name="do_delete_page" class="btn btn-danger btn-xs" value="Delete"/>
                                            </form>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="?cmd=edit_page&option=edit&page_id=<?= $do_list_pages['id'] ?>" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-pencil"></i></a>
                                        </div>
                                    </div>
                                </td>


                            </tr>
                        <?php } ?>
                    </table>

                </div>
            </div>
        </div>

        <?php
    }

    /*
     * Updates the order in what pages are shown
     */

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
     * Delete pages 
     */

    public function DoDeleteSelectedPage(array $delete_data) {


        if (isset($_REQUEST['do_delete_page'])) {

            $page_id = $delete_data[0];
            $parent = $delete_data[1];
            //var_dump($page_id);
            //var_dump($parent);
            $tables = array("pages", "page_file", "page_images", "url_options");
            $fields = array("id", "page_id", "page_id", "page_id");
            $values = $page_id;
            $to_delete = array(
                "tables" => $tables,
                "fields" => $fields,
                "value" => $values
            );
            $flag = 1;
            if ($flag == 1) {

                $message = array("message" => "This will dlete the page and all the associated files with it. Are you sure?<br/><br/>"
                    . "<div class='btn-group'>"
                    . "<form method='post'>"
                    . "<input type='hidden' name='do_delete_page' value='Delete'/>"
                    . "<input type='hidden' name='cmd' value='choose_edit_page'/>"
                    . "<input type='hidden' name='page_parent' value='" . $_REQUEST['page_parent'] . "'/>"
                    . "<input type='hidden' name='p_id' value='" . $_REQUEST['p_id'] . "'/>"
                    . "<input type='submit' name='confirm' value='yes' class='btn btn-default'/>"
                    . "<input type='submit' name='cancel' value='no' class='btn btn-default'/>"
                    . "</div>");

                array_push($message, $flag);
                $this->_message = $message;

                if (isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == "yes") {
                    $do_delete = $this->_queries->DeleteServices($to_delete, $option = "0");
                }
            }
            if ($flag == 0) {
                
            }
            return FALSE;
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
        //var_dump($page_form_data);
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

    /*
     * Returns the error messages and displays them where described.
     */

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

    /*
     * CKEDITOR Called in page edit form
     */

    public function ckeditor($name, $value = '', $height = 450) {
        return ' <textarea class="form-control" rows="20" name="' . addslashes($name) . '">' . htmlspecialchars($value) . '</textarea>'
                . '<script> CKEDITOR.replace( "' . $name . '"); '
                . ''
                . '</script>';
    }

    /*
     * Upload Images
     * It will got to a frontend fold and will have its own directory for each page type
     */

    public function Do_Upload_images($image, $path, $date_added, $page_uid, $page_type = NULL) {

        $this->_queries->_res = NULL;
        $get_number_of_images = $this->_queries->GetData("page_images", "page_id", $page_uid, $option = "6");


        $number = $get_number_of_images['row_count'];
        //var_dump($number);
        $dir = ABSOLUTH_PATH_IMAGES;

        foreach ($_FILES as $k => $file) {
            // Create directory if it does not exist
            if (!is_dir(ABSOLUTH_PATH_IMAGE_FRONT_END . "page_id_" . $page_uid . "_images/")) {
                mkdir(ABSOLUTH_PATH_IMAGE_FRONT_END . "page_id_" . $page_uid . "_images/");
            }


            $upload_file_new_name = preg_replace('/^.*\.([^.]+)$/D', "image_" . $page_uid . "_" . ((int) $number + 1) . ".$1", basename($file['name']["page_edit"]["uploadimage"]));


            $upload_file = ABSOLUTH_PATH_IMAGE_FRONT_END . "page_id_" . $page_uid . "_images/" . $upload_file_new_name;


            $path = ABSOLUTH_PATH_IMAGE_FRONT_END . "page_id_" . $page_uid . "_images/";
            $uploadOk = 1;

            $imageFileType = pathinfo($upload_file, PATHINFO_EXTENSION);
        }

        if (isset($_POST['form']['page_edit']['douploadimage'])) {

            $check = getimagesize($file["tmp_name"]['page_edit']['uploadimage']);

            if ($check !== FALSE) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }
        if (file_exists($upload_file)) {
            $uploadOk = 0;
        }
        if ($file["size"]['page_edit']['uploadimage'] > 5000000) {
            
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            
        } else {

            if (move_uploaded_file($file["tmp_name"]['page_edit']['uploadimage'], $upload_file)) {

                $image_name = preg_replace('/^.*\.([^.]+)$/D', "image_" . $page_uid . "_" . ((int) $number + 1) . ".$1", basename($file['name']["page_edit"]["uploadimage"]));

                $table = array("table1" => "page_images");
                $columns = array("`page_id`", "`image_name`", "`image_path`", "`date_added`");

                $values = array("'" . $page_uid . "'", "'" . $image_name . "'", "'" . $path . "'", "'" . DATE_ADDED . "'");
                $values_to_insert = array(
                    "tables" => $table,
                    "columns" => $columns,
                    "values" => $values
                );
                $insert_images_into = $this->_queries->Insertvalues($values_to_insert, $option = "1");
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * Upload Files
     * It will got to a frontend fold and will have its own directory for each page type
     * Extensions allowed:
     * 1.CSS
     * 2.js
     * 3.pdf
     * 4.CSV
     */

    public function Do_Upload_files($file_n, $path, $date_added, $page_uid, $page_type = NULL) {

        foreach ($_FILES as $k => $file) {
// Create directory if it does not exist
            if (!is_dir(ABSOLUTH_PATH_FILE_FRONT_END . "page_id_" . $page_uid . "_files/")) {
                mkdir(ABSOLUTH_PATH_FILE_FRONT_END . "page_id_" . $page_uid . "_files/");
            }
            $upload_file = ABSOLUTH_PATH_FILE_FRONT_END . "page_id_" . $page_uid . "_files/" . basename($file['name']["page_edit"]["uploadfile"]);

            $path = ABSOLUTH_PATH_FILE_FRONT_END . "page_id_" . $page_uid . "_files/";

            $uploadOk = 1;

            $uploadFileType = pathinfo($upload_file, PATHINFO_EXTENSION);
        }
        if (isset($_POST['form']['page_edit']['douploadfile'])) {



            if (isset($_POST['form']['page_edit']['douploadfile']) === false) {
                $uploadOk = 0;
            } else {
                $uploadOk = 1;
            }
        }


        if ($file["size"]['page_edit']['uploadfile'] > 5000000) {
            $uploadOk == 0;
        }
        if ($uploadFileType != "css" && $uploadFileType != "pdf" && $uploadFileType != "js" && $uploadFileType != "csv") {
            $uploadOk == 0;
        }
        if ($uploadOk == 0) {
            
        } else {
            if (file_exists("$path/$upload_file")) {
                unlink("$path/$upload_file");
            }

            if (move_uploaded_file($file["tmp_name"]['page_edit']['uploadfile'], $upload_file)) {

                $file_name = basename($file['name']['page_edit']['uploadfile']);

                $table = array("table1" => "page_files");
                $columns = array("`page_id`", "`file_name`", "`file_extension`", "`file_path`", "`date_added`");

                $values = array("'" . $page_uid . "'", "'" . $file_name . "'", "'" . $uploadFileType . "'", "'" . $path . "'", "'" . DATE_ADDED . "'");
                $values_to_insert = array(
                    "tables" => $table,
                    "columns" => $columns,
                    "values" => $values
                );

                $files_to_delete = array(
                    "table" => "page_files",
                    "field1" => "page_id",
                    "value1" => $page_uid,
                    "field2" => "file_name",
                    "value2" => $file_name
                );
                $this->_queries->_res = NULL;
                $check_file_in_db = $this->_queries->GetData("page_files", "file_name", $file_name, $option = "6");
                if ((int) $check_file_in_db > 0) {
                    $do = $this->_queries->DeleteServices($files_to_delete, $option = "1");
                }


                $insert_file_into = $this->_queries->Insertvalues($values_to_insert, $option = "1");
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * URL REWITE OPTION MODES
     * 1. SHORT
     * 2. LONG
     */

    public function ReWriteUrl(array $values) {
        if (isset($values['option']) && $values['option'] != '' && $values['id'] == $values['url_page_id']) {
            $option = $values['option'];
            //var_dump($values['id']);
            //Update if different
            $update_vars = array(
                "'" . addslashes($option) . "'",
            );
            $fields = array(
                "option",
            );
            $data_for_query = array(
                "table" => "url_options",
                "value1" => $update_vars,
                "field" => $fields,
                "field2" => "page_id",
                "value2" => $values['id']
            );
            $url_option_to_update = $this->_queries->UpdateQueriesServices($data_for_query, $option = "3");
            if ($url_option_to_update) {

                return true;
            } else {
                return false;
            }
        } else {
            $option = $values['option'];
            $table = array("table1" => "url_options");
            $columns = array("`page_id`", "`option`");
            $values = array("'" . $values['id'] . "'", "'" . $option . "'");
            $values_to_insert = array(
                "tables" => $table,
                "columns" => $columns,
                "values" => $values
            );
            $insert_option_into = $this->_queries->Insertvalues($values_to_insert, $option = "1");
            if ($insert_option_into) {

                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * Use this to determine how the url will show in the frontend
     */

    public function URL_RE_WRITER(array $url_option) {

        if ($url_option['selected'] == "short") {

            if ($url_option['parent_id'] === 0 || $url_option['parent_id'] == "0") {
                $clear_url_spaces = str_replace(" ", "-", $url_option['page_name']);
                $remove_ands = str_replace("&", "and", $clear_url_spaces);
                $url = '/' . preg_replace('/[^a-zA-Z0-9,-\/]/', '-', strtolower($remove_ands));
                $this->_url = $url;
            } else {
                $clear_url_spaces = str_replace(" ", "-", $url_option['page_name']);
                $remove_ands = str_replace("&", "and", $clear_url_spaces);
                $url = '/' . preg_replace('/[^a-zA-Z0-9,-\/]/', '-', strtolower($remove_ands));
                $this->_url = $url;
            }
        } else {
            if ($url_option['parent_id'] === 0 || $url_option['parent_id'] == "0") {
                $clear_url_spaces = str_replace(" ", "-", $url_option['page_name']);
                $remove_ands = str_replace("&", "and", $clear_url_spaces);
                $url = '/' . preg_replace('/[^a-zA-Z0-9,-\/]/', '-', strtolower($remove_ands));
                $this->_url = $url;
            } else {
                $table = "pages";
                $field = "id";
                $value = $url_option['parent_id'];
                $find_parent_name_data = array(
                    "table" => $table,
                    "select" => "name",
                    "field" => $field,
                    "value" => $value
                );
                $this->_queries->_parent = NULL;
                $find_parent_name = $this->_queries->findParent($find_parent_name_data, $option = "1");
                $find_parent_name = array_reverse($find_parent_name);
                $a = array();
                for ($i = 0; $i < count($find_parent_name); $i++) {
                    $new_parent_url = $find_parent_name[$i]['name'];
                    array_push($a, $new_parent_url);
                }
                $parent_url = implode("/", $a);
                $clear_parent_spaces = str_replace(" ", "-", $parent_url);
                $remove_parent_ands = str_replace("&", "and", $clear_parent_spaces);
                $parent_url = '/' . preg_replace('/[^a-zA-Z0-9,-\/]/', '-', strtolower($remove_parent_ands));
                $clear_url_s = str_replace(" ", "-", $url_option['page_name']);
                $remove_long_ands = str_replace("&", "and", $clear_url_s);
                $url = strtolower($parent_url . '/' . preg_replace('/[^a-zA-Z0-9,-\/]/', '-', $remove_long_ands));
                $this->_url = $url;
            }
        }
    }

    /*
     * Add new page form popup
     */

    public function AddNewPagePopUp(array $paren_list = NULL) {
        ?>
        <div class="row">
            <div class="col-md-12">
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
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="panel panel-default">
                        <div class="panel-heading"><span><i class="glyphicon glyphicon-plus-sign"></i> Add New page</span></div>
                        <div class="panel-body">
                            <form method="post" name="form[add_new_page]">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>page Name</label>
                                            <input type="text" name="form[add_new_page][page_name]" value="<?= (isset($_REQUEST['form']['add_new_page']['page_name']) ? $_REQUEST['form']['add_new_page']['page_name'] : '') ?>" class="form-control"/>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Parent</label>
                                            <select name="form[add_new_page][page_parent]" class="form-control">
                                                <option value="0">--None--</option>

                                                <?php
                                                if ($paren_list != NULL) {

                                                    foreach ($paren_list as $p_list) {
                                                        //  var_dump($p_list);
                                                        ?>
                                                        <option value="<?= (isset($_REQUEST['form']['add_new_page']['page_parent'])) ? $_REQUEST['form']['add_new_page']['page_parent'] : $p_list['id'] ?>"><?= $p_list['name'] ?></option>

                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select name="form[add_new_page][page_type]" class="form-control">
                                                <?php
                                                $this->DefinePageTypes();
                                                $page_types = $this->RetPageTypes();
                                                foreach ($page_types as $v => $p_type) {
                                                    ?>
                                                    <option value="<?= (isset($_REQUEST['form']['add_new_page']['page_type']) ? $_REQUEST['form']['add_new_page']['page_type'] : $v ) ?>"><?= $p_type ?></option>

                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <input type="submit" name="form[add_new_page][do_add_new_page]" value="Add New page" class="btn btn-primary"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
            <?php
        }

        /*
         * Will process AddNewPagePopUp function
         */

        public function DoAddNewPage(array $data = NULL, array $data_to_compare = NULL) {
            if ($data != NULL) {
                $page_name = $data['form']['add_new_page']['page_name'];
                $new_page_parent = $data['form']['add_new_page']['page_parent'];
                $page_type = $data['form']['add_new_page']['page_type'];
                /*
                 * First check and make sure data is enterd
                 */
                $flag = 0;
                if (empty($page_name)) {
                    $flag = 1;
                    if ($flag === 1) {
                        $message = array("message" => "Page name cannot be empty");

                        array_push($message, $flag);
                        $this->_message = $message;
                    }
                }
                if (!isset($page_type)) {
                    $page_type = "0";
                }
                if ($data_to_compare != NULL) {
                    for ($i = 0; $i < count($data_to_compare); $i++) {

                        $exsisting_pages_name = $data_to_compare[$i]['name'];
                        $exsisting_pages_ids = $data_to_compare[$i]['id'];

                        if ($new_page_parent == $exsisting_pages_ids) {
                            if ($page_name == $exsisting_pages_name) {
                                $flag = 1;
                                if ($flag === 1) {
                                    $message = array("message" => "Page name cannot be the same as the parent");

                                    array_push($message, $flag);
                                    $this->_message = $message;
                                }
                            }
                        } else if ($new_page_parent === "0") {
                            $exsisting_pages_parents = $data_to_compare[$i]['parent'];
                            if ($new_page_parent == $exsisting_pages_parents) {
                                if ($page_name == $exsisting_pages_name) {
                                    $flag = 1;
                                    if ($flag === 1) {
                                        $message = array("message" => "Page name is duplicated! Try an other name.");
                                        array_push($message, $flag);
                                        $this->_message = $message;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($flag == 0) {


                    $table = array("table1" => "pages");
                    $columns = array("`name`", "`alias`", "`parent`", "`type`", "`edate`");
                    $page_alias = trim(strtolower($page_name));
                    $values = array("'" . $page_name . "'", "'" . $page_alias . "'", "'" . (int) $new_page_parent . "'", "'" . $page_type . "'", "'" . date("Y m d") . "'");
                    $values_to_insert = array(
                        "tables" => $table,
                        "columns" => $columns,
                        "values" => $values
                    );
                    $insert_new_page_details = $this->_queries->Insertvalues($values_to_insert, $option = "1");
                    /*
                     * Select the name of this page where parent is equal to parent
                     */
                    $table_for_url_query = "pages";
                    $fields_for_url_query = array(
                        "field1" => "name",
                        "field2" => "id",
                        "field3" => "parent"
                    );
                    $values_for_query_url = array(
                        "value1" => $page_name,
                        "value2" => $new_page_parent
                    );
                    $this->_queries->_res = NULL;
                    $get_page_info_for_url = $this->_queries->GetData($table_for_url_query, $fields_for_url_query, $values_for_query_url, $option = "9");
                    $get_page_info_for_url = $this->_queries->RetData();
                    foreach ($get_page_info_for_url as $data_for_url) {
                        
                    }
                    $add_url_option = array(
                        "selected" => "long",
                        "parent_id" => $new_page_parent,
                        "page_name" => $data_for_url['name']
                    );
                    $url_for_page = $this->URL_RE_WRITER($add_url_option);
                    $url_for_page = $this->RET_URL();
                    $table_to_insert_url = array("table1" => "page_urls");
                    $columns_to_insert = array("`page_id`", "`long_url`");

                    $values_to_insert_url_table = array("'" . $data_for_url['id'] . "'", "'" . $url_for_page . "'");

                    $values_to_insert_in_url = array(
                        "tables" => $table_to_insert_url,
                        "columns" => $columns_to_insert,
                        "values" => $values_to_insert_url_table
                    );
                    $insert_new_page_url = $this->_queries->Insertvalues($values_to_insert_in_url, $option = "1");



                    if ($insert_new_page_details) {
                        $flag = 1;
                        $message = array("message" => "Page {$page_name} was added.");
                        array_push($message, $flag);
                        $this->_message = $message;
                    } else {
                        $flag = 1;
                        $message = array("message" => "page was not added.");
                        array_push($message, $flag);
                        $this->_message = $message;
                    }
                }
            }
        }

        public function RET_MESSAGE_TO() {
            return $this->_message;
        }

        public function RET_URL() {
            return $this->_url;
        }

        /*
         * Page Types
         * Add more if needed 
         * Number must be +2 of the last available number
         * Just for convension
         */

        public function DefinePageTypes() {

            $page_type = array(
                "0" => "Normal",
                "1" => "Sub-Menu",
                "3" => "Category",
                "5" => "Sub-Category",
                "7" => "Item-Page",
                "9" => "Designers"
            );


            $this->_page_type = $page_type;
        }

        /*
         * Return Page_types
         */

        public function RetPageTypes() {
            return $this->_page_type;
        }

        public function ItemPageForm(array $data, array $images = NULL) {

            foreach ($data as $item) {
                ?>
                <div class="col-md-12" style="margin-top: 10px !important;">
                    <?php
                    if ($this->_flag == 1) {
                        ?>
                        <div class="list-group">
                            <ul>
                                <?php
                                foreach ($this->error_message as $message) {

                                    echo "<li class='list-group-item list-group-item-warning'><i class='glyphicon glyphicon-info-sign'></i>&nbsp;" . $message . "</li>";
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <form method="post" id="pages_form" name="form[item_edit]" enctype="multipart/form-data">
                    <div class="col-md-12">

                        <div class="panel panel-default " style="padding: 10px;" >
                            <div class="panel-heading bg-primary">Edit Item  <?= $item['model_number'] ?></div>
                            <div class="panel-body" >

                                <input type="hidden" name="form[item_edit][id]" value="<?= $item['id']; ?>"/>
                                <div class="row">
                                    <ul class="nav nav-tabs" role="tablist" id="tabs_editpage" >
                                        <li class="active" aria-controls="items" role="tab" ><a href="#tabs-common-details" data-toggle="tab">Common Details</a></li> 
                                        <li aria-controls="f_pass" role="tab" ><a href="#tabs-images" data-toggle="tab">Images</a></li>
                                        <li aria-controls="items_se" role="tab" ><a href="#tabs-advanced-details" data-toggle="tab">Advanced Details</a></li>   

                                        <!--add plugin tabs here-->

                                    </ul>

                                </div>
                                <div class="tab-content">

                                    <div class="tab-pane active" id="tabs-common-details">
                                        <div class="panel-body">
                                            <!--ROW-->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>ID:</label>
                                                        <input type="text" name="form[item_edit][db_id]" value="<?= $item['id'] ?>" disabled="disabled" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Model Number:</label>
                                                        <input type="text" name="form[item_edit][model_number]" value="<?= isset($_REQUEST['form']['item_edit']['model_number']) ? $_REQUEST['form']['item_edit']['model_number'] : $item['model_number'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Category Name:</label>
                                                        <input type="text" name="form[item_edit][category_name]" value="<?= $item['category_name'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END ROW-->
                                            <!--ROW-->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Product Name:</label>
                                                        <input type="text" name="form[item_edit][product_name]" value="<?= isset($_REQUEST['form']['item_edit']['product_name']) ? $_REQUEST['form']['item_edit']['product_name'] : $item['product_name'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Alias:</label>
                                                        <input type="text" name="form[item_edit][alias]" value="<?= isset($_REQUEST['form']['item_edit']['alias']) ? $_REQUEST['form']['item_edit']['alias'] : $item['alias'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Color:</label>
                                                        <input type="text" name="form[item_edit][color]" value="<?= isset($_REQUEST['form']['item_edit']['color']) ? $_REQUEST['form']['item_edit']['color'] : $item['color'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END ROW-->
                                            <!--ROW-->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Description:</label>
                                                        <textarea class="form-control" name="form[item_edit][description]"><?= (isset($_REQUEST['form']['item_edit']['description']) ? $_REQUEST['form']['item_edit']['description'] : $item['product_description']) ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Keywords:</label>
                                                        <input type="text" name="form[item_edit][keywords]" value="<?= isset($_REQUEST['form']['item_edit']['keywords']) ? $_REQUEST['form']['item_edit']['keywords'] : $item['keywords'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Version:</label>
                                                        <input type="text" name="form[item_edit][version]" value="<?= isset($_REQUEST['form']['item_edit']['version']) ? $_REQUEST['form']['item_edit']['version'] : $item['version'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END ROW-->
                                            <!--ROW-->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Size:</label>
                                                        <input type="text" name="form[item_edit][size]" value="<?= isset($_REQUEST['form']['item_edit']['size']) ? $_REQUEST['form']['item_edit']['size'] : $item['size'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="panel panel-default">
                                                        <?php
                                                        $status_icon = "";
                                                        $status = (isset($_REQUEST['form']['item_edit']['status']) ? $_REQUEST['form']['item_edit']['status'] : $item['status']);
                                                        if ($status == "1") {
                                                            $status_icon = "glyphicon glyphicon-plus-sign btn btn-success btn-xs";
                                                        } else {
                                                            $status_icon = "glyphicon glyphicon-minus-sign btn btn-danger btn-xs";
                                                        }
                                                        ?>
                                                        <div class="panel-heading"><i class="<?= $status_icon ?>"></i><span> Status</span></div>
                                                        <div class="panel-body">

                                                            <div class="form-group">
                                                                <?php
                                                                $enabled = '';
                                                                $disabled = '';
                                                                //$status = (isset($_REQUEST['form']['item_edit']['status']) ? $_REQUEST['form']['item_edit']['status'] : $item['status']);
                                                                if ($status == "1") {

                                                                    $enabled = 'checked="checked"';
                                                                    $disabled = '';
                                                                } else {
                                                                    $enabled = '';
                                                                    $disabled = 'checked="checked"';
                                                                }
                                                                ?>
                                                                <table class="table table-hover">
                                                                    <tr>
                                                                        <td><span>Enabled</span></td>
                                                                        <td><input type="radio" name="form[item_edit][status]" value="1" <?= $enabled; ?> class="form-control"/></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span>Disable</span></td>
                                                                        <?php ?>
                                                                        <td><input type="radio" name="form[item_edit][status]" value="0" <?= $disabled; ?> class="form-control"/></td>
                                                                    </tr>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Date Added:</label>
                                                        <input type="date" name="form[item_edit][date_added]" value="<?= isset($_REQUEST['form']['item_edit']['date_added']) ? $_REQUEST['form']['item_edit']['date_added'] : $item['date_added'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END ROW-->
                                            <!--ROW-->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Added_by:</label>
                                                        <input type="text" name="form[item_edit][added_by]" value="<?= isset($_REQUEST['form']['item_edit']['added_by']) ? $_REQUEST['form']['item_edit']['added_by'] : $item['added_by'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Edited By:</label>
                                                        <input type="text" name="form[item_edit][edited_by]" value="<?= isset($_REQUEST['form']['item_edit']['edited_by']) ? $_REQUEST['form']['item_edit']['edited_by'] : $item['edited_by'] ?>"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">

                                                </div>
                                            </div>
                                            <!--END ROW-->
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tabs-images">
                                        <div class="row">
                                            <div class="col-md-4" style="margin-top:10px;">
                                                <div class="panel panel-default">

                                                    <div class="panel-heading"><span><i class="glyphicon glyphicon-picture"  ></i>&nbsp;Upload Images</span></div>
                                                    <div class="panel-body">
                                                        <input type="file" name="form[page_edit][uploadimage]"  class="btn btn-default btn-xs"/>

                                                        <input type="submit" class="btn btn-danger btn-xs" name="form[page_edit][douploadimage]" value="Upload" style="margin-top: 10px;"/>
                                                    </div>



                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <i class="glyphicon glyphicon-cloud"></i><span> Images</span>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <?php
                                                                if ($images != NULL) {
                                                                    foreach ($images as $image) {
                                                                        ?>

                                                                        <div class="col-xs-7 col-md-2">
                                                                            <a href="<?= $image['image_path'] . $image['image_name'] ?>" target="_blank" class="thumbnail">
                                                                                <img src="<?= $image['image_path'] . $image['image_name'] ?>" alt=" " title="">
                                                                            </a>
                                                                            <a  href="<?= $image['image_path'] . $image['image_name'] ?>" target="_blank"  class="caption">
                                                                                <p style="font-size: 10px"><?= $image['image_name'] ?></p>





                                                                            </a>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <p>This page currently has no images.</p>
                                                                <?php }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tabs-advanced-details">
                                        <!--Advanced edit part starts-->

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
                                                                <input type="text" name="form[page_edit][meta_keywords]" value="<?= (isset($_REQUEST['form']['page_edit']['meta_keywords']) ? $_REQUEST['form']['page_edit']['meta_keywords'] : htmlspecialchars($item['meta_keywords'])) ?>" class="form-control"/>
                                                                <label>description</label>

                                                                <input type="text" name="form[page_edit][meta_description]" value="<?= (isset($_REQUEST['form']['page_edit']['meta_description']) ? $_REQUEST['form']['page_edit']['meta_description'] : htmlspecialchars($item['meta_description'])) ?>" class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--END MetaData-->

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
                    <div class="form-group">
                        <input type="submit" value="Update Item" name="form[item_edit][update_item]" class="btn btn-primary"/>
                    </div>
            </div>
            </form>


            <?php
//                if (isset($_REQUEST['form']['item_edit']['update_item'])) {
//                    var_dump($_REQUEST);
//                }
        }
    }

    /*
     * Processes the item pages
     */

    public function DoProcessItempages(array $data) {
        
    }

    /*
     * Carousel Form
     */

    public function CarouselForm(array $data = NULL) {
        ?>
        <div class="col-md-12">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-play-circle"></i><span>&nbsp;Carousel Setup</span>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-6" style="margin-top:10px;">
                            <div class="panel panel-default">

                                <div class="panel-heading"><span><i class="glyphicon glyphicon-picture"  ></i>&nbsp;Upload Images</span></div>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label>Please enter name your Carousel</label>
                                        <input type="tex" value="<?= (isset($_REQUEST['form']['carousel_setup']['c_name']) ? $_REQUEST['form']['carousel_setup']['c_name'] : '') ?>" name="from[carousel_setup][c_name]" class="form-control"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="form[page_edit][uploadimage]"  class="btn btn-default btn-xs"/>

                                        <input type="submit" class="btn btn-danger btn-xs" name="form[page_edit][douploadimage]" value="Upload" style="margin-top: 10px;"/>
                                    </div>
                                </div>



                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="fa fa-television"></i>&nbsp;<span>Carousels</span>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <form >
                                                    <select class="form-control" name="form[crousel][names]">
                                                        <option value="none">--</option>
                                                        <option value="none">1</option>
                                                    </select>
                                                </form>
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



        <?php
    }

    public function CustomizedProductUploader(array $data = NULL) {

        if (isset($_REQUEST['form']['uploads']['douploadfile'])) {

            $file = $_REQUEST['form']['uploads']['douploadfile'];
            $table_name = $_REQUEST['form']['uploads']['table_name'];
            if (empty($table_name) || empty($file)) {

                $flag = 1;
                $message = array("message" => "All fields are empty");
                $this->ReturnMessages($message, $flag);
            } else {

                $this->_uploads->UploadFileFunction($file);
                $this->_uploads->ReturnFileHeaders($table_name);


                foreach ($this->_uploads->RetMessageTo() as $messages) {
                    $flag = 1;
                    $message = array("message" => $messages);
                    $this->ReturnMessages($message, $flag);
                }
            }
        }
        ?>
        <div class="col-lg-12">
            <div class="col-md-12" style="margin-top: 10px !important;">
                <?php
                if ($this->_flag == 1) {
                    ?>
                    <div class="list-group">
                        <ul>
                            <?php
                            foreach ($this->error_message as $message) {

                                echo "<li class='list-group-item list-group-item-warning'><i class='glyphicon glyphicon-info-sign'></i>&nbsp;" . $message . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-floppy-open"></i>&nbsp;<span>Items Uploads Manager</span>
                </div>
                <div class="panel-body">

                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading"><span><i class="glyphicon glyphicon-file" ></i>&nbsp;Upload Files</span></div>
                            <div class="panel-body">
                                <form name="form[uploads]" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label><span style="color:#E21A2C">**</span>Table Name <em>(Make sure the name of the table matches the same as the <strong>brand name</strong>)</em></label>
                                        <input type="text" name="form[uploads][table_name]" value="<?= (isset($_REQUEST['form']['uploads']['table_name']) ? $_REQUEST['form']['uploads']['table_name'] : '') ?>" class="form-control" />
                                    </div>

                                    <input type="file" name="form[uploads][uploadfile]"   class="btn btn-default btn-xs"/>

                                    <input type="submit" class="btn btn-success btn-xs" name="form[uploads][douploadfile]" value="Upload" style="margin-top: 10px;"/>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12" style="margin-top: 10px;">

                        <div class="panel panel-default">
                            <div class="panel panel-heading">
                                <label>Your Brand Tables</label>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">

                                    <form method="post" name="form[brands]">
                                        <select name="form[brands][tables]">
                                            <?php
                                            $value = array(
                                                "patern" => "rock_"
                                            );
                                            $this->_queries->_res = NULL;
                                            $see_tables = $this->_queries->CreateTableServices($value, $option = "1");
                                            $see_tables = $this->_queries->RetData();

                                            foreach ($see_tables as $brand_tables) {
                                                if ($brand_tables['Tables_in_rock_cmsdb (%rock_%)'] != '') {
                                                    ?>
                                                    <option value="<?= $brand_tables['Tables_in_rock_cmsdb (%rock_%)'] ?>"><?= $brand_tables['Tables_in_rock_cmsdb (%rock_%)'] ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="--none--">--No Brand Tables--</option>
                                                    <?php
                                                }
                                            }
                                            ?>



                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>




        <?php
    }

    /*
     * Social Media form
     * 1.Facebook
     * 2.twitter
     * 3.Instagram
     * 4.Youtube
     * 5.Linkedin
     * 6.Yelp
     * 7.google+
     * 
     */

    public function SocialMediaForm(array $social_media = NULL) {

        if (isset($_REQUEST['form']['social']['set_icons'])) {

            $facebook_url = (isset($_REQUEST['form']['social']['facebook']) ? (empty($_REQUEST['form']['social']['facebook']) ? 'https://www.facebook.com/' : $_REQUEST['form']['social']['facebook']) : 'https://www.facebook.com/');
            $facebook_icon = (isset($_REQUEST['form']['social']['facebook_icons']) ? $_REQUEST['form']['social']['facebook_icons'] : 'faceboo_color.png');
            $facebook_status = $_REQUEST['form']['social']['facebook_status'];


            $twitter_url = (isset($_REQUEST['form']['social']['twitter']) ? (empty($_REQUEST['form']['social']['twitter']) ? 'https://twitter.com/' : $_REQUEST['form']['social']['twitter']) : 'https://twitter.com/');
            $twitter_icon = (isset($_REQUEST['form']['social']['twitter_icons']) ? $_REQUEST['form']['social']['twitter_icons'] : 'twitter_color.png');
            $twitter_status = $_REQUEST['form']['social']['twitter_status'];


            $instagram_url = (isset($_REQUEST['form']['social']['instagram']) ? (empty($_REQUEST['form']['social']['instagram']) ? 'https://www.instagram.com/' : $_REQUEST['form']['social']['instagram']) : 'https://www.instagram.com/');
            $instagram_icon = (isset($_REQUEST['form']['social']['instagram_icons']) ? $_REQUEST['form']['social']['instagram_icons'] : 'instagram_color.png');
            $instagram_status = $_REQUEST['form']['social']['instagram_status'];

            $youtube_url = (isset($_REQUEST['form']['social']['youtube']) ? (empty($_REQUEST['form']['social']['youtube']) ? 'https://www.youtube.com/' : $_REQUEST['form']['social']['youtube']) : 'https://www.youtube.com/');
            $youtube_icon = (isset($_REQUEST['form']['social']['youtube_icons']) ? $_REQUEST['form']['social']['youtube_icons'] : 'youtube_color.png');
            $youtube_status = $_REQUEST['form']['social']['youtube_status'];

            $linkedin_url = (isset($_REQUEST['form']['social']['linkedin']) ? (empty($_REQUEST['form']['social']['linkedin']) ? 'https://www.linkedin.com/' : $_REQUEST['form']['social']['linkedin']) : 'https://www.linkedin.com/');
            $linkedin_icon = (isset($_REQUEST['form']['social']['linkedin_icons']) ? $_REQUEST['form']['social']['linkedin_icons'] : 'linkedin_color.png');
            $linkedin_status = $_REQUEST['form']['social']['linkedin_status'];

            $google_plus_url = (isset($_REQUEST['form']['social']['google']) ? (empty($_REQUEST['form']['social']['google']) ? 'https://plus.google.com' : $_REQUEST['form']['social']['google']) : 'https://plus.google.com');
            $google_plus_icon = (isset($_REQUEST['form']['social']['google_icons']) ? $_REQUEST['form']['social']['google_icons'] : 'google_plus_color.png');
            $google_status = $_REQUEST['form']['social']['google_status'];





            $table = "social_media";

            $image_path = "/r.frontend/social_media/social_media_by_alfredo/";
            $table = array("table1" => "social_media");
            $columns = array("`url`", "`image_url`", "`image_name`", "`status`");
            $facebook = array("'" . $facebook_url . "'", "'" . $image_path . "'", "'" . $facebook_icon . "'", "'" . $facebook_status . "'");
            $twitter = array("'" . $twitter_url . "'", "'" . $image_path . "'", "'" . $twitter_icon . "'", "'" . $twitter_status . "'");
            $instagram = array("'" . $instagram_url . "'", "'" . $image_path . "'", "'" . $instagram_icon . "'", "'" . $instagram_status . "'");
            $youtube = array("'" . $youtube_url . "'", "'" . $image_path . "'", "'" . $youtube_icon . "'", "'" . $youtube_status . "'");
            $linkedin = array("'" . $linkedin_url . "'", "'" . $image_path . "'", "'" . $linkedin_icon . "'", "'" . $linkedin_status . "'");
            $google_plus = array("'" . $google_plus_url . "'", "'" . $image_path . "'", "'" . $google_plus_icon . "'", "'" . $linkedin_status . "'");

            $values_to_insert = array(
                "tables" => $table,
                "columns" => $columns,
                "values" => array(
                    $facebook,
                    $twitter,
                    $instagram,
                    $youtube,
                    $linkedin,
                    $google_plus
                )
            );
            /*
             * First check see if the table has data
             */



            $check_db_for_social_media = $this->_queries->GetData("social_media", "image_url", $image_path, $option = "6");
            if ($check_db_for_social_media['row_count'] > 0) {
                /*
                 * if yes->UPDATE
                 */

                $facebook = array("'" . $facebook_url . "',", "'" . $image_path . "',", "'" . $facebook_icon . "',", "'" . $facebook_status . "'");
                $twitter = array("'" . $twitter_url . "',", "'" . $image_path . "',", "'" . $twitter_icon . "',", "'" . $twitter_status . "'");
                $instagram = array("'" . $instagram_url . "',", "'" . $image_path . "',", "'" . $instagram_icon . "',", "'" . $instagram_status . "'");
                $youtube = array("'" . $youtube_url . "',", "'" . $image_path . "',", "'" . $youtube_icon . "',", "'" . $youtube_status . "'");
                $linkedin = array("'" . $linkedin_url . "',", "'" . $image_path . "',", "'" . $linkedin_icon . "', ", "'" . $linkedin_status . "'");
                $google_plus = array("'" . $google_plus_url . "',", "'" . $image_path . "',", "'" . $google_plus_icon . "',", "'" . $google_status . "'");
                $cols = array("url", "image_url", "image_name", "status");


                for ($i = 0; $i < count($social_media); $i++) {
                    $values_to_update = array(
                        "table" => "social_media",
                        "fields" => $cols,
                        "values" => array(
                            $facebook,
                            $twitter,
                            $instagram,
                            $youtube,
                            $linkedin,
                            $google_plus,
                        ),
                        "field2" => "id",
                        "value2" => $social_media
                    );
                }
                $do_update_social_media = $this->_queries->UpdateQueriesServices($values_to_update, $option = "4");

                $flag = 1;
                $message = array("message" => "Social Media Updated.");
                array($this->_message, $message);
                $this->ReturnMessages($message, $flag);
            } else {

                $flag = 1;
                $message = array("message" => "Social Media Inserted.");
                array($this->_message, $message);
                $this->ReturnMessages($message, $flag);

                /*
                 * else INSERT
                 */


                $do_insert_soecial_media = $this->_queries->Insertvalues($values_to_insert, $option = "2");
            }
        }
        ?>
        <div class="col-md-12">
            <div class="col-md-12" style="margin-top: 10px !important;">
                <?php
                if ($this->_flag == 1) {
                    ?>
                    <div class="list-group">
                        <ul>
                            <?php
                            foreach ($this->error_message as $message) {

                                echo "<li class='list-group-item list-group-item-warning'><i class='glyphicon glyphicon-info-sign'></i>&nbsp;" . $message . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <form method="post" name="form[social]">    

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-cogs"></i>&nbsp;<span>Social Media Manager</span></div>
                    <div class="panel-body">
                        <!--Social Media Form enter-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-facebook-square"></i>&nbsp;Facebook</label>
                                    <input type="text" name="form[social][facebook]" value="<?= (isset($_REQUEST['form']['social']['facebook']) ? $_REQUEST['form']['social']['facebook'] : $social_media[0]['url']) ?>" class="form-control"  placeholder="http://url of socail media" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <table class="table table-hover table-bordered" style="margin-top:21px">
                                        <!--LOGIC-->
                                        <?php
                                        $checked_1 = '';
                                        $checked_2 = '';
                                        $checked_3 = '';
                                        $selection = ((isset($_REQUEST['form']['social']['facebook_icons']) ? $_REQUEST['form']['social']['facebook_icons'] : $social_media[0]['image_name']));
                                        if ($selection == "faceboo_color.png") {
                                            $checked_1 = 'checked="checked"';
                                            $checked_2 = '';
                                            $checked_3 = '';
                                        } else if ($selection == "facebook.png") {
                                            $checked_1 = '';
                                            $checked_2 = 'checked="checked"';
                                            $checked_3 = '';
                                        } else {
                                            $checked_1 = '';
                                            $checked_2 = '';
                                            $checked_3 = 'checked="checked"';
                                        }
                                        ?>
                                        <tr>
                                            <td style="width:100px;">                                               
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/faceboo_color.png" alt="" width="25" height="25"/>                                          
                                                <input type="radio" name="form[social][facebook_icons]" value="faceboo_color.png" <?= $checked_1 ?>  />                                                
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/facebook.png" alt="" width="25" height="25"/>
                                                <input type="radio" name="form[social][facebook_icons]" value="facebook.png" <?= $checked_2 ?> />
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/facebook_circle.png" alt="" width="25" height="25"/> 
                                                <input type="radio" name="form[social][facebook_icons]" value="facebook_circle.png" <?= $checked_3 ?>  />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top:30px">
                                    <label>Status</label>
                                    <?php
                                    $selection = (isset($_REQUEST['form']['social']['facebook_status']) ? $_REQUEST['form']['social']['facebook_status'] : $social_media[0]['status'] );
                                    if ($selection == 1) {
                                        $checked_1 = 'checked="checked"';
                                        $checked_2 = '';
                                    } else {
                                        $checked_1 = '';
                                    }
                                    ?>
                                    <input type="hidden"  name="form[social][facebook_status]" value="0" />
                                    <input type="checkbox"  name="form[social][facebook_status]" value="1" <?= $checked_1 ?>/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-twitter-square"></i>&nbsp;Twitter</label>
                                    <input type="text" name="form[social][twitter]" value="<?= (isset($_REQUEST['form']['social']['twitter']) ? $_REQUEST['form']['social']['twitter'] : $social_media[1]['url']) ?>" class="form-control"  placeholder="http://url of socail media" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <table class="table table-hover table-bordered" style="margin-top:21px">
                                        <!--LOGIC-->
                                        <?php
                                        $checked_1 = '';
                                        $checked_2 = '';
                                        $checked_3 = '';
                                        $selection = ((isset($_REQUEST['form']['social']['twitter_icons']) ? $_REQUEST['form']['social']['twitter_icons'] : $social_media[1]['image_name']));
                                        if ($selection == "twitter_color.png") {
                                            $checked_1 = 'checked="checked"';
                                            $checked_2 = '';
                                            $checked_3 = '';
                                        } else if ($selection == "twitter.png") {
                                            $checked_1 = '';
                                            $checked_2 = 'checked="checked"';
                                            $checked_3 = '';
                                        } else {
                                            $checked_1 = '';
                                            $checked_2 = '';
                                            $checked_3 = 'checked="checked"';
                                        }
                                        ?>
                                        <tr>
                                            <td style="width:100px;">                                               
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/twitter_color.png" alt="" width="25" height="25"/>
                                                <input type="radio" name="form[social][twitter_icons]" value="twitter_color.png" <?= $checked_1 ?>  />                                                
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/twitter.png" alt="" width="25" height="25"/>
                                                <input type="radio" name="form[social][twitter_icons]" value="twitter.png" <?= $checked_2 ?>   />
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/twitter_circle.png" alt="" width="25" height="25"/> 
                                                <input type="radio" name="form[social][twitter_icons]" value="twitter_circle.png" <?= $checked_3 ?>  />
                                            </td>
                                        </tr>



                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top:30px">
                                    <label>Status</label>
                                    <?php
                                    $checked_1 = '';

                                    $selection = (isset($_REQUEST['form']['social']['twitter_status']) ? $_REQUEST['form']['social']['twitter_status'] : $social_media[1]['status'] );
                                    if ($selection == 1) {
                                        $checked_1 = 'checked="checked"';
                                    } else {
                                        $checked_1 = '';
                                    }
                                    ?>
                                    <input type="hidden"  name="form[social][twitter_status]" value="0"/>
                                    <input type="checkbox"  name="form[social][twitter_status]" value="1" <?= $checked_1 ?>/>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-instagram"></i>&nbsp;Instagram</label>
                                    <input type="text" name="form[social][instagram]" value="<?= (isset($_REQUEST['form']['social']['instagram']) ? $_REQUEST['form']['social']['instagram'] : $social_media[2]['url']) ?>" class="form-control"  placeholder="http://url of socail media" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <table class="table table-hover table-bordered" style="margin-top:21px">
                                        <!--LOGIC-->
                                        <?php
                                        $checked_1 = '';
                                        $checked_2 = '';
                                        $checked_3 = '';
                                        $selection = ((isset($_REQUEST['form']['social']['instagram_icons']) ? $_REQUEST['form']['social']['instagram_icons'] : $social_media[2]['image_name']));
                                        if ($selection == "instagram_color.png") {
                                            $checked_1 = 'checked="checked"';
                                            $checked_2 = '';
                                            $checked_3 = '';
                                        } else if ($selection == "instagram.png") {
                                            $checked_1 = '';
                                            $checked_2 = 'checked="checked"';
                                            $checked_3 = '';
                                        } else {
                                            $checked_1 = '';
                                            $checked_2 = '';
                                            $checked_3 = 'checked="checked"';
                                        }
                                        ?>
                                        <tr>
                                            <td style="width:100px;">                                               
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/instagram_color.png" alt="" width="25" height="25"/>                                          
                                                <input type="radio" name="form[social][instagram_icons]" value="instagram_color.png" <?= $checked_1 ?>  />                                                
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/instagram.png" alt="" width="25" height="25"/>
                                                <input type="radio" name="form[social][instagram_icons]" value="instagram.png" <?= $checked_2 ?>  />
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/instagram_circle.png" alt="" width="25" height="25"/> 
                                                <input type="radio" name="form[social][instagram_icons]" value="instagram_circle.png" <?= $checked_3 ?>   />
                                            </td>
                                        </tr>



                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top:30px">
                                    <label>Status</label>
                                    <?php
                                    $checked_1 = '';

                                    $selection = (isset($_REQUEST['form']['social']['instagram_status']) ? $_REQUEST['form']['social']['instagram_status'] : $social_media[2]['status'] );
                                    if ($selection == 1) {
                                        $checked_1 = 'checked="checked"';
                                    } else {
                                        $checked_1 = '';
                                    }
                                    ?>
                                    <input type="hidden"  name="form[social][instagram_status]" value="0" />
                                    <input type="checkbox"  name="form[social][instagram_status]" value="1" <?= $checked_1 ?>/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-youtube-square"></i>&nbsp;YouTube</label>
                                    <input type="text" name="form[social][youtube]" value="<?= (isset($_REQUEST['form']['social']['youtube']) ? $_REQUEST['form']['social']['youtube'] : $social_media[3]['url']) ?>" class="form-control"  placeholder="http://url of socail media" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <table class="table table-hover table-bordered" style="margin-top:21px">
                                        <!--LOGIC-->
                                        <?php
                                        $checked_1 = '';
                                        $checked_2 = '';
                                        $checked_3 = '';
                                        $selection = ((isset($_REQUEST['form']['social']['youtube_icons']) ? $_REQUEST['form']['social']['youtube_icons'] : $social_media[3]['image_name']));
                                        if ($selection == "youtube_color.png") {
                                            $checked_1 = 'checked="checked"';
                                            $checked_2 = '';
                                            $checked_3 = '';
                                        } else if ($selection == "youtube.png") {
                                            $checked_1 = '';
                                            $checked_2 = 'checked="checked"';
                                            $checked_3 = '';
                                        } else {
                                            $checked_1 = '';
                                            $checked_2 = '';
                                            $checked_3 = 'checked="checked"';
                                        }
                                        ?>
                                        <tr>
                                            <td style="width:100px;">                                               
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/youtube_color.png" alt="" width="25" height="25"/>                                          
                                                <input type="radio" name="form[social][youtube_icons]" value="youtube_color.png"  <?= $checked_1 ?> />                                                
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/youtube.png" alt="" width="25" height="25"/>
                                                <input type="radio" name="form[social][youtube_icons]" value="youtube.png" <?= $checked_2 ?>   />
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/youtube_circle.png" alt="" width="25" height="25"/> 
                                                <input type="radio" name="form[social][youtube_icons]" value="youtube_circle.png"  <?= $checked_3 ?>  />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group" style="margin-top:30px">
                                    <label>Status</label>
                                    <?php
                                    $checked_1 = '';

                                    $selection = (isset($_REQUEST['form']['social']['youtube_status']) ? $_REQUEST['form']['social']['youtube_status'] : $social_media[3]['status'] );
                                    if ($selection == 1) {
                                        $checked_1 = 'checked="checked"';
                                    } else {
                                        $checked_1 = '';
                                    }
                                    ?>
                                    <input type="hidden"  name="form[social][youtube_status]" value="0" />
                                    <input type="checkbox"  name="form[social][youtube_status]" value="1" <?= $checked_1 ?>/>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-linkedin-square"></i>&nbsp;LinkedIn</label>
                                    <input type="text" name="form[social][linkedin]" value="<?= (isset($_REQUEST['form']['social']['linkedin']) ? $_REQUEST['form']['social']['linkedin'] : $social_media[4]['url']) ?>" class="form-control"  placeholder="http://url of socail media" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <table class="table table-hover table-bordered" style="margin-top:21px">
                                        <!--LOGIC-->
                                        <?php
                                        $checked_1 = '';
                                        $checked_2 = '';
                                        $checked_3 = '';
                                        $selection = ((isset($_REQUEST['form']['social']['linkedin_icons']) ? $_REQUEST['form']['social']['linkedin_icons'] : $social_media[4]['image_name']));
                                        if ($selection == "linkedin_color.png") {
                                            $checked_1 = 'checked="checked"';
                                            $checked_2 = '';
                                            $checked_3 = '';
                                        } else if ($selection == "linedin.png") {
                                            $checked_1 = '';
                                            $checked_2 = 'checked="checked"';
                                            $checked_3 = '';
                                        } else {
                                            $checked_1 = '';
                                            $checked_2 = '';
                                            $checked_3 = 'checked="checked"';
                                        }
                                        ?>
                                        <tr>
                                            <td style="width:100px;">                                               
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/linkedin_color.png" alt="" width="25" height="25"/>                                          
                                                <input type="radio" name="form[social][linkedin_icons]" value="linkedin_color.png"  <?= $checked_1 ?>  />                                                
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/linedin.png" alt="" width="25" height="25"/>
                                                <input type="radio" name="form[social][linkedin_icons]" value="linedin.png" <?= $checked_2 ?>  />
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/linkedin_circle.png" alt="" width="25" height="25"/> 
                                                <input type="radio" name="form[social][linkedin_icons]" value="linkedin_circle.png" <?= $checked_3 ?>   />
                                            </td>
                                        </tr>



                                    </table>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group" style="margin-top:30px">
                                    <label>Status</label>
                                    <?php
                                    $checked_1 = '';

                                    $selection = (isset($_REQUEST['form']['social']['linkedin_status']) ? $_REQUEST['form']['social']['linkedin_status'] : $social_media[4]['status'] );
                                    if ($selection == 1) {
                                        $checked_1 = 'checked="checked"';
                                    } else {
                                        $checked_1 = '';
                                    }
                                    ?>
                                    <input type="hidden"  name="form[social][linkedin_status]" value="0" />
                                    <input type="checkbox"  name="form[social][linkedin_status]" value="1" <?= $checked_1 ?>/>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-google-plus-square"></i>&nbsp;Google Plus</label>
                                    <input type="text" name="form[social][google]" value="<?= (isset($_REQUEST['form']['social']['google']) ? $_REQUEST['form']['social']['google'] : $social_media[5]['url']) ?>" class="form-control"  placeholder="http://url of socail media" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <table class="table table-hover table-bordered" style="margin-top:21px">
                                        <!--LOGIC-->
                                        <?php
                                        $checked_1 = '';
                                        $checked_2 = '';
                                        $checked_3 = '';
                                        $selection = ((isset($_REQUEST['form']['social']['google_icons']) ? $_REQUEST['form']['social']['google_icons'] : $social_media[5]['image_name']));
                                        if ($selection == "google_plus_color.png") {
                                            $checked_1 = 'checked="checked"';
                                            $checked_2 = '';
                                            $checked_3 = '';
                                        } else if ($selection == "google_plus.png") {
                                            $checked_1 = '';
                                            $checked_2 = 'checked="checked"';
                                            $checked_3 = '';
                                        } else {
                                            $checked_1 = '';
                                            $checked_2 = '';
                                            $checked_3 = 'checked="checked"';
                                        }
                                        ?>
                                        <tr>
                                            <td style="width:100px;">                                               
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/google_plus_color.png" alt="" width="25" height="25"/>                                          
                                                <input type="radio" name="form[social][google_icons]" value="google_plus_color.png" <?= $checked_1 ?>   />                                                
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/google_plus.png" alt="" width="25" height="25"/>
                                                <input type="radio" name="form[social][google_icons]" value="google_plus.png" <?= $checked_2 ?>   />
                                            </td>

                                            <td style="width:100px;"> 
                                                <img src="/r.frontend/social_media/social_media_by_alfredo/google_plus_circle.png" alt="" width="25" height="25"/> 
                                                <input type="radio" name="form[social][google_icons]" value="google_plus_circle.png" <?= $checked_3 ?>   />
                                            </td>
                                        </tr>



                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top:30px">
                                    <label>Status</label>
                                    <?php
                                    $checked_1 = '';

                                    $selection = (isset($_REQUEST['form']['social']['google_status']) ? $_REQUEST['form']['social']['google_status'] : $social_media[5]['status'] );
                                    if ($selection == 1) {
                                        $checked_1 = 'checked="checked"';
                                    } else {
                                        $checked_1 = '';
                                    }
                                    ?>
                                    <input type="hidden"  name="form[social][google_status]" value="0" />
                                    <input type="checkbox"  name="form[social][google_status]" value="1" <?= $checked_1 ?>/>
                                </div>
                            </div>
                        </div>
                        <!---END Panel-->
                        <div class="form-group">
                            <input type="submit" name="form[social][set_icons]" value="Set Social Media" class="btn btn-success"/>
                        </div>
                    </div>

                </div>

        </div>
        </form>
        <?php
    }

    public function GetAllBrandInfo(array $brand_data_request = NULL) {


        if ($brand_data_request != NULL) {
            /*
             * First we get the table name
             * 2nd we will get all the data from that table
             * 3rd create a page in pages with parent id as the id of the page being set
             * the page will be called brand_nam_catagories
             * categories will have children
             * for example if the gender if availble
             * +gender
             *      +catagories
             *          -items
             * 
             * i.e 
             * Men
             *  Accesoires
             *      bags
             */

            $this->_queries->_res = NULL;
            $get_brand_info = $this->_queries->GetData($brand_data_request['table'], "id", $brand_data_request['id'], $option = "0");
            $get_brand_info = $this->_queries->RetData();

            foreach ($get_brand_info as $brand_info) {
                
            }
            $this->_queries->_res = NULL;
            $get_all_data_for_brand = $this->_queries->GetData($brand_info['table_name'], $brand_data_request['choice'], NULL, "8");
            $get_all_data_for_brand = $this->_queries->RetData();

            foreach ($get_all_data_for_brand as $cat_data) {

                $for_categories[] = $cat_data[$brand_data_request['choice']];

                /*
                 * Check if the data is there (prevent duplication)
                 * select from pages where name = cate-choice and parent is equel to id of the page
                 */
                $columns = array(
                    "field1" => "name",
                    "field2" => "id",
                    "field3" => "parent"
                );
                $values_to_check = array(
                    "value1" => $cat_data[$brand_data_request['choice']],
                    "value2" => $brand_data_request['parent']
                );
                $table_to_check = "pages";

                $this->_queries->_res = NULL;
                $check_db_for_sub_pages = $this->_queries->GetData($table_to_check, $columns, $values_to_check, $option = "9");
                $check_db_for_sub_pages = $this->_queries->RetData();
                $sub_page_parents[] = $check_db_for_sub_pages;
                if (count($check_db_for_sub_pages) > 0) {
                    //var_dump($check_db_for_sub_pages);
                    continue;
                } else {


                    /*
                     * Now Create the catergory if not already based on user selection
                     * if gender
                     * then first create the catgories page
                     * 
                     */



                    $columns = array(
                        "name",
                        "alias",
                        "parent",
                        "cdate",
                        "title",
                        "type"
                    );
                    $page_alias = trim(strtolower($cat_data[$brand_data_request['choice']]));
                    $values = array(
                        "'" . $cat_data[$brand_data_request['choice']] . "'",
                        "'" . $page_alias . "'",
                        "'" . $brand_data_request['parent'] . "'",
                        "'" . date("Y,m,d") . "'",
                        "'" . $brand_info['brand'] . " " . $cat_data[$brand_data_request['choice']] . "'",
                        "'" . "5" . "'"
                    );
                    $tabel = array(
                        "table1" => "pages"
                    );
                    $values_to_add_a_page = array(
                        "tables" => $tabel,
                        "columns" => $columns,
                        "values" => $values
                    );
                    $do_add_catagroy = $this->_queries->Insertvalues($values_to_add_a_page, $option = "1");
                    if ($do_add_catagroy) {



                        var_dump("pages added");
                    } else {
                        var_dump("unbale to add");
                    }
                }
            }
            /*
             * Now Create the sub-catergory if not already based on user selection
             * foreach category see if it has any subcategories
             * 
             */
            if ($brand_data_request['choice'] == "gender") {


                $columns = array(
                    "field1" => "category",
                    "field2" => "gender"
                );

                /*
                 * SUB-Category 
                 */
                foreach ($for_categories as $sc) {


                    $this->_queries->_res = NULL;
                    $get_all_data_for_sub_cat = $this->_queries->GetData($brand_info['table_name'], $columns, $sc, "10");
                    $get_all_data_for_sub_cat = $this->_queries->RetData();

                    $sub_categories[] = $get_all_data_for_sub_cat;

                    $columns_for_finding_parents = array(
                        "field1" => "name",
                        "field2" => "id",
                        "field3" => "parent"
                    );
                    $table_to_find_parent = "pages";

                    $values_to_find_parent = array(
                        "value1" => $sc,
                        "value2" => $brand_data_request['parent']
                    );

                    $this->_queries->_res = NULL;
                    $get_sub_parents = $this->_queries->GetData($table_to_find_parent, $columns_for_finding_parents, $values_to_find_parent, "9");
                    $get_sub_parents = $this->_queries->RetData();
                    $sub_p [] = $get_sub_parents;

                    /*
                     * Insert into pages values 
                     * parent page id of top
                     */


                    for ($i = 0; $i < count($get_all_data_for_sub_cat); $i++) {
                        var_dump($get_all_data_for_sub_cat[$i]);
                        $columns_to_sub = array(
                            "name",
                            "alias",
                            "parent",
                            "cdate",
                            "title",
                            "type"
                        );
                        $page_alias = trim(strtolower($get_all_data_for_sub_cat[$i]['category']));
                        $values_to_sub = array(
                            "'" . $get_all_data_for_sub_cat[$i]['category'] . "'",
                            "'" . $page_alias . "'",
                            "'" . $get_sub_parents[0]['id'] . "'",
                            "'" . date("Y,m,d") . "'",
                            "'" . $brand_info['brand'] . " " . $get_all_data_for_sub_cat[$i]['category'] . "'",
                            "'" . "5" . "'"
                        );
                        $tabel_to_sub = array(
                            "table1" => "pages"
                        );
                        $values_to_add_a_sub_page = array(
                            "tables" => $tabel_to_sub,
                            "columns" => $columns_to_sub,
                            "values" => $values_to_sub
                        );
                        $do_add_sub_catagroy = $this->_queries->Insertvalues($values_to_add_a_sub_page, $option = "1");
                        if ($do_add_sub_catagroy) {



                            var_dump("pages added");
                        } else {
                            var_dump("unbale to add");
                        }
                        /*
                         * Select the name of this page where parent is equal to parent
                         */
                        $table_for_url_query = "pages";
                        $fields_for_url_query = array(
                            "field1" => "name",
                            "field2" => "id",
                            "field3" => "parent"
                        );

                        $values_for_query_url = array(
                            "value1" => $get_all_data_for_sub_cat[$i]['category'],
                            "value2" => $get_sub_parents[0]['id']
                        );

                        echo "<br/>";
                        var_dump($values_for_query_url);

                        $this->_queries->_res = NULL;
                        $get_page_info_for_url = $this->_queries->GetData($table_for_url_query, $fields_for_url_query, $values_for_query_url, $option = "9");
                        $get_page_info_for_url = $this->_queries->RetData();

                        foreach ($get_page_info_for_url as $data_for_url) {


                            $add_url_option = array(
                                "selected" => "long",
                                "parent_id" => $get_sub_parents[0]['id'],
                                "page_name" => $get_all_data_for_sub_cat[$i]['category']
                            );
                            $url_for_page = $this->URL_RE_WRITER($add_url_option);
                            $url_for_page = $this->RET_URL();
                            $table_to_insert_url = array("table1" => "page_urls");
                            $columns_to_insert = array("`page_id`", "`long_url`");

                            $values_to_insert_url_table = array("'" . $data_for_url['id'] . "'", "'" . $url_for_page . "'");

                            $values_to_insert_in_url = array(
                                "tables" => $table_to_insert_url,
                                "columns" => $columns_to_insert,
                                "values" => $values_to_insert_url_table
                            );
                            $insert_new_page_url = $this->_queries->Insertvalues($values_to_insert_in_url, $option = "1");
                        }
                    }
                }
            } else {
                $columns_by_gender = array(
                    "field1" => "gender",
                    "field2" => "category"
                );

                /*
                 * SUB-Category 
                 */
                foreach ($for_categories as $sg) {


                    $this->_queries->_res = NULL;
                    $get_all_data_for_sub_gender = $this->_queries->GetData($brand_info['table_name'], $columns_by_gender, $sg, "10");
                    $get_all_data_for_sub_gender = $this->_queries->RetData();

                    $sub_gender[] = $get_all_data_for_sub_gender;
                    var_dump($sub_gender);
                    $columns_for_finding_parents_gender = array(
                        "field1" => "name",
                        "field2" => "id",
                        "field3" => "parent"
                    );
                    $table_to_find_parent_gender = "pages";

                    $values_to_find_parent_gender = array(
                        "value1" => $sg,
                        "value2" => $brand_data_request['parent']
                    );

                    $this->_queries->_res = NULL;
                    $get_sub_parents_gender = $this->_queries->GetData($table_to_find_parent_gender, $columns_for_finding_parents_gender, $values_to_find_parent_gender, "9");
                    $get_sub_parents_gender = $this->_queries->RetData();
                    $sub_p_gender [] = $get_sub_parents_gender;

                    /*
                     * Insert into pages values 
                     * parent page id of top
                     */


                    for ($i = 0; $i < count($get_all_data_for_sub_gender); $i++) {
                        var_dump($get_all_data_for_sub_gender[$i]);
                        $columns_to_gender = array(
                            "name",
                            "alias",
                            "parent",
                            "cdate",
                            "title",
                            "type"
                        );
                        $page_alias = trim(strtolower($get_all_data_for_sub_gender[$i]['gender']));
                        $values_to_gender = array(
                            "'" . $get_all_data_for_sub_gender[$i]['gender'] . "'",
                            "'" . $page_alias . "'",
                            "'" . $get_sub_parents_gender[0]['id'] . "'",
                            "'" . date("Y,m,d") . "'",
                            "'" . $brand_info['brand'] . " " . $get_all_data_for_sub_gender[$i]['gender'] . "'",
                            "'" . "5" . "'"
                        );
                        $tabel_to_gender = array(
                            "table1" => "pages"
                        );
                        $values_to_add_a_sub_gender = array(
                            "tables" => $tabel_to_gender,
                            "columns" => $columns_to_gender,
                            "values" => $values_to_gender
                        );
                        $do_add_sub_catagroy_gender = $this->_queries->Insertvalues($values_to_add_a_sub_gender, $option = "1");
                        if ($do_add_sub_catagroy_gender) {



                            var_dump("pages added");
                        } else {
                            var_dump("unbale to add");
                        }
                    }
                }
            }
        }
    }

    public function GetProductsBycategory(array $data = NULL) {

        if ($data != NULL) {

            /*
             * If data is not empty
             * Select distinct categories where gender is = to selection
             */




            $columns = array(
                "field1" => "category",
                "field2" => "gender"
            );
            $this->_queries->_res = NULL;
            $get_all_cat_names = $this->_queries->GetData("all_products", $columns, $data['selection'], "10");
            $get_all_cat_names = $this->_queries->RetData();


            foreach ($get_all_cat_names as $category_name) {


                $check_if_exists_in_table = array(
                    "field1" => "name",
                    "field2" => "id",
                    "field3" => "parent"
                );
                $check_if_exists_in_table_values = array(
                    "value1" => $category_name['category'],
                    "value2" => $data['parent_id']
                );
                $this->_queries->_res = NULL;
                $check_pages_table = $this->_queries->GetData("pages", $check_if_exists_in_table, $check_if_exists_in_table_values, $option = "9");
                $check_pages_table = $this->_queries->RetData();

                if (count($check_pages_table) > 0) {

                    var_dump(count($check_pages_table));
                } else {


                    $columns_for_catagory = array(
                        "name",
                        "alias",
                        "parent",
                        "cdate",
                        "title",
                        "type"
                    );
                    $page_alias = trim(strtolower($category_name['category']));
                    $values_for_catagory = array(
                        "'" . $category_name['category'] . "'",
                        "'" . $page_alias . "'",
                        "'" . $data['parent_id'] . "'",
                        "'" . date("Y,m,d") . "'",
                        "'" . $data['selection'] . " | " . $category_name['category'] . "'",
                        "'" . "5" . "'"
                    );
                    $tabel_for_catagory = array(
                        "table1" => "pages"
                    );
                    $values_to_add_for_catagory_pages = array(
                        "tables" => $tabel_for_catagory,
                        "columns" => $columns_for_catagory,
                        "values" => $values_for_catagory
                    );
                    $do_add_categories_to_pages = $this->_queries->Insertvalues($values_to_add_for_catagory_pages, $option = "1");

                    /*
                     * Select the name of this page where parent is equal to parent
                     */
                    $table_for_url_query = "pages";
                    $fields_for_url_query = array(
                        "field1" => "name",
                        "field2" => "id",
                        "field3" => "parent"
                    );

                    $values_for_query_url = array(
                        "value1" => $category_name['category'],
                        "value2" => $data['parent_id']
                    );

                    echo "<br/>";
                    var_dump($values_for_query_url);

                    $this->_queries->_res = NULL;
                    $get_page_info_for_url = $this->_queries->GetData($table_for_url_query, $fields_for_url_query, $values_for_query_url, $option = "9");
                    $get_page_info_for_url = $this->_queries->RetData();

                    foreach ($get_page_info_for_url as $data_for_url) {


                        $add_url_option = array(
                            "selected" => "long",
                            "parent_id" => $data['parent_id'],
                            "page_name" => $category_name['category']
                        );
                        $url_for_page = $this->URL_RE_WRITER($add_url_option);
                        $url_for_page = $this->RET_URL();
                        $table_to_insert_url = array("table1" => "page_urls");
                        $columns_to_insert = array("`page_id`", "`long_url`");

                        $values_to_insert_url_table = array("'" . $data_for_url['id'] . "'", "'" . $url_for_page . "'");

                        $values_to_insert_in_url = array(
                            "tables" => $table_to_insert_url,
                            "columns" => $columns_to_insert,
                            "values" => $values_to_insert_url_table
                        );
                        $insert_new_page_url = $this->_queries->Insertvalues($values_to_insert_in_url, $option = "1");
                    }
                }
            }
        }
    }

}
