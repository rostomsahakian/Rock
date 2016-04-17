<?php
include_once TEMPLATE_H_F_PATH . 'header.php';

function compare_filters($a, $b) {
    return strnatcmp($a['filter'], $b['filter']);
}
?>

<!--PAGE CONTENT GO HERE-->
<div class="container rock-main-container">
    <?php
    echo $pagecontent;
    ?>

    <div class="col-md-12">
        <div class="col-md-2">
            <div class="list-group">
                <h4 href="#" class="list-group-item rock-list-group-heading">
                    Categories
                </h4>
                <?php
                foreach ($page_data as $data) {
                    usort($data, "compare_filters");
                    foreach ($data as $items) {
                        ?>
                        <a href="#" class="list-group-item"><?= $items['filter'] ?></a>
                        <?php
                    }
                    ?>


                </div>
            </div>

            <div class="col-md-10">
                <?php
                foreach ($data as $to_display) {
                    foreach ($to_display['display'] as $for_categories) {

                        /*
                         * Item Name
                         */
                        $item_name = $for_categories['item_name'];
                        $clear_url_spaces = str_replace(" ", "-", $item_name);
                        $remove_ands = str_replace("&", "and", $clear_url_spaces);
                        $clean_p_name = preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands));

                        /*
                         * Brand Name
                         */
                        $brand = str_replace(" ", "-", $for_categories['brand']);
                        $clean_brand_name = str_replace(" ", "-", $brand);
                        $remove_ands_from_brand = str_replace("&", "and", $clean_brand_name);
                        $brand_name_url = '/' . preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands_from_brand));
                        /*
                         * Gender
                         */
                        $gender = $for_categories['gender'];
                        $clean_gender = str_replace(" ", "-", $gender);
                        $remove_ands_from_gender = str_replace("&", "and", $clean_gender);
                        $gender_url = '/' . preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands_from_gender));

                        /*
                         * Category
                         */
                        $category = $for_categories['category'];
                        $clean_category = str_replace(" ", "-", $category);
                        $remove_ands_from_category = str_replace("&", "and", $clean_category);
                        $category_for_url = '/' . preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands_from_category));
                        /*
                         * Other specs
                         */
                        $model_number = $for_categories['model_number'];
                        $item_image = $for_categories['item_image_url'];
                        $item_price = $for_categories['price'];
                        ?>





                        <div class="col-md-4 rock-item-image-holder"> 

                            <div class="row">
<!--                                <span class="rock-category-in-box"><?php // $category ?></span>-->
                                <a href="<?= $brand_name_url ?>" class="rock-brand-in-box"><?= $brand ?></a>
                                <a  href="<?= $gender_url . $category_for_url . $brand_name_url . "/" . $model_number ?>#<?= $clean_p_name ?> "  class="rock-product-link">
                                    <span class="rollover" >                                    
<!--                                        <a class="rock-view-details-in-box" href="<?php // $gender_url . $category_for_url . $brand_name_url . "/" . $model_number ?>#<?php //$clean_p_name ?>" >View Product</a>-->

                                    </span>
                                </a>

                                <img src="<?= $item_image ?>">
                            </div>
                            <div class="row rock-item-captions">

                                <p> <?= $item_name ?><p> 
                                <p>  REG. PRICE: $<?= $item_price ?></p>  

                            </div>
                        </div>

                        <?php
                    }
                }
            }
            ?>      

        </div>
    </div>



</div>





<?php
include_once TEMPLATE_H_F_PATH . 'footer.php';
?>