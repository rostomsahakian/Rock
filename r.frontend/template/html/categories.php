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
                   <?= str_replace("|", " ", $page_title) ?>
                </h4>
                <?php
                foreach ($page_data as $data) {
                    usort($data, "compare_filters");
                    foreach ($data as $items) {
                        // var_dump($items);
                        foreach ($items['display'] as $get_id) {
                            foreach ($get_id['page_real_id'] as $page_real_id) {

                                $parent_name = strtolower($items['parent_name']);
                                $no_spaces_parent_name = str_replace(" ", "-", $parent_name);
                                $no_ands_parent_name = str_replace("&", "and", $no_spaces_parent_name);
                                $clean_parent_name = preg_replace('/[^a-zA-Z0-9,-]/', "-", $no_ands_parent_name);

                                $category_name = strtolower($items['filter']);
                                $no_spaces_cat_name = str_replace(" ", "-", $category_name);
                                $no_ands_cat_name = str_replace("&", "and", $no_spaces_cat_name);
                                $clean_cat_name = preg_replace('/[^a-zA-Z0-9,-]/', "-", $no_ands_cat_name)
                                ?>
                                <a href="/<?= $clean_parent_name . "/" . $clean_cat_name . "/" . $page_real_id['child_id'] ?>" class="list-group-item"><?= $items['filter'] ?></a>
                                <?php
                            }
                        }
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
            //$page_id = $for_categories['page_real_id'];
            // var_dump($for_categories);
            foreach ($for_categories['page_real_id'] as $c) {


                $page_id = $c['child_id'];
                ?>





                            <div class="col-md-4 rock-item-image-holder"> 

                                <div class="row">
                <!--                                <span class="rock-category-in-box"><?php // $category    ?></span>-->
                                    <a href="<?= $brand_name_url ?>" class="rock-brand-in-box"><?= $brand ?></a>
                                    <a  href="<?= $gender_url . $category_for_url . $brand_name_url . "/" . $model_number ?>"  class="rock-product-link">
                                        <span class="rollover" >                                    
                <!--                                        <a class="rock-view-details-in-box" href="<?php // $gender_url . $category_for_url . $brand_name_url . "/" . $model_number    ?>#<?php //$clean_p_name    ?>" >View Product</a>-->

                                        </span>
                                    </a>

                                    <img src="<?= $item_image ?>">
                                </div>
                                <div class="row rock-item-captions">

                                <p> <?= $item_name ?><p> 
                                <p>  REG. PRICE: $<?= $item_price ?></p>  
<!--                                    <p><a href="<?// $gender_url . $category_for_url . "/" . $page_id ?>" title="<?//$category ?>"> <?= $category ?></a><p> -->


                                </div>
                            </div>

                <?php
            }
        }
    }
}
?>      

        </div>
    </div>



</div>





<?php

?>