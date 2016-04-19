<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of promotions
 * The user can choose their prefered brands to be promoted
 * it will effect the footer links and the navigation brands
 * @author rostom
 */
class promotions {

    public $_queries;
    public $_mens;
    public $_womens;
    public $_boys;
    public $_girls;

    public function __construct() {
        $this->_queries = new queries();
        $this->GetDataForPromtionForm();
    }

    public function CreateTableForPromition() {
        
    }

    public function PromotionBackendModule() {
        if (isset($_REQUEST['brand_id_d'])) {
            $to_delete = array(
                "table" => "brand_promotions",
                "field1" => "id",
                "value1" => $_REQUEST['brand_id_d']
            );
            $this->_queries->DeleteServices($to_delete, $option="2");
            
            
        }
        ?>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;Promote Your Favorite Brands</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Please Select Up to 10 Brands From the Lists Below for each gender.</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">

                            <form method="post"  >
                                <input type="hidden" name="gender" value="mens" id="gen"/>
                                <label>Available Mens Designers</label>
                                <div class="form-group">
                                    <select name="brand" class="brand">
                                        <option value="select">--Select--</option>
                                        <?php
                                        foreach ($this->_mens as $mens_brands) {
                                            ?>
                                            <option value="<?= $mens_brands['brand'] ?>"><?= $mens_brands['brand'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-8" id="showres_mens">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <form method="post">
                                <input type="hidden" name="gender" value="womens" id="gen_w"/>
                                <label>Available Womens Designers</label>
                                <div class="form-group">
                                    <select name="brand_womens" class="brand_w">
                                        <option value="select">--Select--</option>
                                        <?php
                                        foreach ($this->_womens as $womens_brands) {
                                            ?>
                                            <option value="<?= $womens_brands['brand'] ?>"><?= $womens_brands['brand'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>

                            <div class="row" >
                                <div class="col-md-8" id="showres_womens">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <form method="post">
                                <input type="hidden" name="gender" value="boys" id="gen_b"/>
                                <label>Available Boys Designers</label>
                                <div class="form-group">
                                    <select name="brand_boys" class="brand_b">
                                        <option value="select">--Select--</option>
                                        <?php
                                        foreach ($this->_boys as $boys_brands) {
                                            ?>
                                            <option value="<?= $boys_brands['brand'] ?>"><?= $boys_brands['brand'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col-md-8" id="showres_boys">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form method="post">
                                <input type="hidden" name="gender" value="girls" id="gen_g" />
                                <label>Available Girls Designers</label>
                                <div class="form-group" >
                                    <select name="brand_girls" class="brand_g">
                                        <option value="select">--Select--</option>
                                        <?php
                                        foreach ($this->_girls as $girls_brands) {
                                            ?>
                                            <option value="<?= $girls_brands['brand'] ?>"><?= $girls_brands['brand'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-8" id="showres_girls">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Edit your Favorite Brands <a href="/rock.admin/?cmd=b_promotion&option=true"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Designer</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                foreach ($this->GetBrandsForEditing("Mens") as $b_data) {
                                    ?>
                                    <tr>
                                        <td><?= $b_data['brand'] ?></td>
                                        <td><a class="btn btn-danger btn-xs" href="/rock.admin/?cmd=b_promotion&option=true&brand_id_d=<?= $b_data['id'] ?>"/>Delete</a></td>                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Designer</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                foreach ($this->GetBrandsForEditing("Womens") as $b_data) {
                                    ?>
                                    <tr>
                                        <td><?= $b_data['brand'] ?></td>
                                        <td><a class="btn btn-danger btn-xs" href="/rock.admin/?cmd=b_promotion&option=true&brand_id_d=<?= $b_data['id'] ?>"/>Delete</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Designer</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                foreach ($this->GetBrandsForEditing("Boys") as $b_data) {
                                    ?>
                                    <tr>
                                        <td><?= $b_data['brand'] ?></td>
                                        <td><a class="btn btn-danger btn-xs" href="/rock.admin/?cmd=b_promotion&option=true&brand_id_d=<?= $b_data['id'] ?>"/>Delete</a></td>                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Designer</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                foreach ($this->GetBrandsForEditing("Girls") as $b_data) {
                                    ?>
                                    <tr>
                                        <td><?= $b_data['brand'] ?></td>
                                        <td><a class="btn btn-danger btn-xs" href="/rock.admin/?cmd=b_promotion&option=true&brand_id_d=<?= $b_data['id'] ?>"/>Delete</a></td>                                    </tr>
                                        <?php
                                    }
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        public function GetDataForPromtionForm() {

            /*
             * First get distinct brands for eaach gender
             */
            /*
             * 1. Mens
             */
            $this->_queries->_res = NULL;
            $table = "all_products";
            $fields = array(
                "field1" => "brand",
                "field2" => "gender"
            );
            $value = "Mens";

            $get_mens_brands = $this->_queries->GetData($table, $fields, $value, $option = "10");
            $get_mens_brands = $this->_queries->RetData();

            $this->_mens = $get_mens_brands;

            /*
             * 2. Womens
             */
            $this->_queries->_res = NULL;
            $table = "all_products";
            $fields = array(
                "field1" => "brand",
                "field2" => "gender"
            );
            $value = "Womens";

            $get_womens_brands = $this->_queries->GetData($table, $fields, $value, $option = "10");
            $get_womens_brands = $this->_queries->RetData();

            $this->_womens = $get_womens_brands;
            /*
             * 3. Boys
             */
            $this->_queries->_res = NULL;
            $table = "all_products";
            $fields = array(
                "field1" => "brand",
                "field2" => "gender"
            );
            $value = "Boys";

            $get_boys_brands = $this->_queries->GetData($table, $fields, $value, $option = "10");
            $get_boys_brands = $this->_queries->RetData();

            $this->_boys = $get_boys_brands;
            /*
             * 4. Girls
             */
            $this->_queries->_res = NULL;
            $table = "all_products";
            $fields = array(
                "field1" => "brand",
                "field2" => "gender"
            );
            $value = "Girls";

            $get_girls_brands = $this->_queries->GetData($table, $fields, $value, $option = "10");
            $get_girls_brands = $this->_queries->RetData();

            $this->_girls = $get_girls_brands;
        }

        public function ReturnMensData() {
            return $this->_mens;
        }

        public function ReturnWomensData() {
            return $this->_womens;
        }

        public function ReturnBoyssData() {
            return $this->_boys;
        }

        public function ReturnGirlsData() {
            return $this->_girls;
        }

        public function InsertTopDesigners(array $data) {



            $brand = $data['brand'];
            $gender = $data['gender'];
            if ($brand == "select") {
                echo "2";
            }

            $data = array(
                "tables" => array(
                    "table1" => "brand_promotions"
                ),
                "columns" => array(
                    "brand",
                    "gender"
                ),
                "values" => array(
                    "'" . $brand . "'",
                    "'" . $gender . "'"
                )
            );

            $this->_queries->_res = NULL;
            $fs = array(
                "field1" => "brand",
                "field3" => "gender",
            );
            $vs = array(
                "value1" => $brand,
                "value2" => $gender
            );
            $check_data = $this->_queries->GetData("brand_promotions", $fs, $vs, $option = "11");
            $check_data = $this->_queries->RetData();



            if (count($check_data) > 0) {

                foreach ($check_data as $d) {
                    echo $d['brand'];
                }
            } else {
                /*
                 * If empty first check the number of enteries
                 * 
                 */
                $num_rows_per_gender = $this->_queries->GetData("brand_promotions", "gender", $gender, $option = "6");
                if ($num_rows_per_gender['row_count'] > 9) {
                    echo "3";
                } else {
                    echo "1";

                    $insert = $this->_queries->Insertvalues($data, $option = "1");

                    if ($insert) {
                        echo "seccess";
                    } else {
                        echo "failed";
                    }
                }
            }
        }

        public function GetBrandsForEditing($gender) {


            $this->_queries->_res = NULL;
            $get_each = $this->_queries->GetData("brand_promotions", "gender", $gender, $option = "0");
            $get_each = $this->_queries->RetData();

            return $get_each;
        }

    }
    