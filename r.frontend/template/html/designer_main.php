<?php
include_once TEMPLATE_H_F_PATH . 'header.php';
?>
<!--PAGE CONTENT GO HERE-->
<div class="container rock-main-container">
    <?php
    echo $pagecontent;
    ?>

    <div class="col-md-12">
        <div class="col-md-3">
            <div class="list-group">

                <h4 href="#" class="list-group-item rock-list-group-heading">
                    <i class="fa fa-list fa-2x" aria-hidden="true"></i> &nbsp; &nbsp; <?= str_replace("|", " ", $page_title) ?>
                </h4>
                <?php
                foreach ($page_data_brands as $brands_page_data) {
                    foreach ($brands_page_data as $brands_pages_name) {


                        $page_name = $brands_pages_name['page_name'];
                        $page_id = $brands_pages_name['id'];
                        $page_name_no_spaces = str_replace(" ", "-", strtolower($page_name));
                        $page_name_no_ands = str_replace("&", "and", $page_name_no_spaces);
                        $page_url_clean = preg_replace('/[^a-zA-Z0-9,-]/', "-", $page_name_no_ands);
                        ?>
                        <a href="/<?= $page_url_clean ?>" class="list-group-item rock-list-group-item"><?= $page_name ?></a>


                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-md-9" style="margin-top: 10px;">
            <?php
            foreach ($brands_page_data as $single_designer_item) {
                foreach ($single_designer_item['single_data_per_brand'] as $singles) {

                    $item_name = $singles['item_name'];
                    $item_name_with_no_spaces = str_replace(" ", "-", $item_name);
                    $item_name_with_no_ands = str_replace("&", "-", $item_name_with_no_spaces);
                    $item_name_clean = preg_replace('/[a-zA-Z0-9,-]/', "-", $item_name_with_no_ands);

                    $item_image = $singles['item_image_url'];
                    $item_brand_id = $singles['brand_id'];
                    $item_price = $singles['price'];

                    $item_brand = $singles['brand'];
                    $item_brand_no_spaces = str_replace(" ", "-", strtolower($item_brand));
                    $item_brand_no_ands = str_replace("&", "and", $item_brand_no_spaces);
                    $item_brand_clean = preg_replace('/[^a-zA-Z0-9,-]/', "-", $item_brand_no_ands);


                    $item_model_number = $singles['model_number'];
                    $item_category = $singles['category'];
                    $item_category_no_spaces = str_replace(" ", "-", $item_category);
                    $item_category_no_ands = str_replace("&", "and", $item_category_no_spaces);
                    $item_category_clean = preg_replace('/[^a-zA-Z0-9,-]/', "-", $item_category_no_ands);

                    $item_gender = $singles['gender'];
                    $item_gender_no_spaces = str_replace(" ", "-", $item_gender);
                    $item_gender_no_ands = str_replace("&", "and", $item_gender_no_spaces);
                    $item_gender_clean = preg_replace('/[^a-zA-Z0-9,-]/', "-", $item_gender_no_ands);
                    ?>





                    <div class="col-md-4 rock-item-image-holder"> 

                        <div class="row">
                            <a href="<?= $item_brand_clean ?>" class="rock-brand-in-box"><?= $item_brand ?></a>
                            <a  href="<?= $item_gender_clean ."/". $item_category_clean ."/".  $item_brand_clean . "/" .  $item_model_number ?>"  class="rock-product-link">
                                <span class="rollover" >                                    

                                </span>
                            </a>

                            <img src="<?= $item_image ?>" style="border:0px;">
                        </div>
                        <div class="row rock-item-captions">

                            <p class="rock-item-name"> <?= $item_name ?><p> 
                            <p>  REG. PRICE: $<?= $item_price ?></p>  
        <!--                                    <p><a href="<?// $gender_url . $category_for_url . "/" . $page_id ?>" title="<?//$category ?>"> <?= $category ?></a><p> -->


                        </div>
                    </div>

                    <?php
                }
            }
            ?>
        </div>
    </div>


</div>

