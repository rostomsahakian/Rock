<?php
include_once TEMPLATE_H_F_PATH . 'header.php';
?>

<!--PAGE CONTENT GO HERE-->
<div class="container rock-main-container" >

    <?php
    foreach ($page_data_sub as $data) {
        //var_dump($data);
        ?>

        <div class="row">
            <div class="col-md-12">
                <hr/>
                <h1><?= str_replace("|" , " ", $page_title) ?></h1>
            </div>
            <div class="col-md-12 rock-items-col-12">
                <div class="row">
                    <?php
                    foreach ($data['pagination'] as $pagination) {
                        echo $pagination;
                    }
                    ?>
                </div>

                <?php
                foreach ($data['data'] as $categories_items) {
                    foreach ($categories_items as $c_items) {
                        foreach ($c_items as $items) {

                            $brand = $items['brand'];


                            $item_name = trim($items['item_name']);
                            $item_image = $items['item_image_url'];
                            $item_price = $items['price'];
                            /*
                             * Gender (if applicable)
                             */
                            if ($items['gender'] != "") {
                                $clean_gender = str_replace(" ", "-", $items['gender']);
                                $remove_ands_from_gender = str_replace("&", "and", $clean_gender);
                                $gender = '/' . preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands_from_gender));
                            } else {
                                continue;
                            }
                            /*
                             * Category
                             */
                            $clean_category = str_replace(" ", "-", $items['category']);
                            $remove_ands_from_category = str_replace("&", "and", $clean_category);
                            $category = '/' . preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands_from_category));

                            /*
                             * Brand Name
                             */
                            $clean_brand_name = str_replace(" ", "-", $items['brand']);
                            $remove_ands_from_brand = str_replace("&", "and", $clean_brand_name);
                            $brand_name = '/' . preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands_from_brand));
                            /*
                             * Model Number
                             */
                            $model_number = $items['model_number'];
                            /*
                             * Item_name
                             */
                            $clear_url_spaces = str_replace(" ", "-", $items['item_name']);
                            $remove_ands = str_replace("&", "and", $clear_url_spaces);
                            $clean_p_name = preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands));
                            ?>

                            <div class="col-md-4 rock-item-image-holder"> 

                                <div class="row">


                                    <a href="<? ?>" class="rock-brand-in-box"><?= $brand ?></a>
                                    <a  href="<?= $gender . $category . $brand_name . "/" . $model_number ?>#<?= $clean_p_name ?> "  class="rock-product-link">
                                        <span class="rollover" >                                    

                                        </span>
                                    </a>
                                    <img id="zoom_<?= $model_number ?>" src="<?= $item_image ?>"  title="<?= $brand." ".$item_name." ".$model_number ?>" class="rock-item-image">


                                </div>

                                <div class="row rock-item-captions">

                                    <p class="rock-item-name"> <?= $item_name ?><p> 
                                    <p>  REG. PRICE:  $<?= $item_price ?></p>  

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
//include_once TEMPLATE_H_F_PATH . 'footer.php';
?>