<?php
include_once TEMPLATE_H_F_PATH . 'header.php';
?>
<!--PAGE CONTENT GO HERE-->
<div class="container rock-main-container" >


    <div class="row">
        <div class="col-md-12">
            <hr/>
            <?php
            foreach ($page_data_item as $data) {
                foreach ($data as $item_d) {
                    ?>

                    <h1><?= $item_d['item_name'] ?></h1>
                </div>
                <div class="col-md-12">
                    <div class="col-md-1">&nbsp;</div>
                    <div class="col-md-4 rock-item-page-image-div" id="ex1">    
                        <img src="<?= $item_d['item_image_url'] ?>"/>
                    </div>

                    <div class="col-md-6 rock-item-page-details">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading"><?= $item_d['item_name'] ?><br/><span>by <a href="/<?= $item_d['brand'] ?>"><?= $item_d['brand'] ?></a></span></div>

                            <!-- Price and Quantity -->
                            <div class="panel-body">
                                <div class="col-sm-6">
                                    <h3>$ <?= $item_d['price'] ?></h3>
                                </div>
                                <div class="col-sm-6 rock-quantity-div-select">
                                    <label>Quantity: </label>
                                    <select>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                </div>                               
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 rock-item-page-details">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Sizes</div>

                            <!-- Sizes-->

                            <div class="panel-body">
                                <div class="col-md-7">
                                    <label>Size: </label>
                                    <select style="width: 100px">
                                        <option>XS</option>
                                        <option>S</option>
                                        <option>M</option>
                                        <option>L</option>
                                        <option>XL</option>
                                        <option>XXL</option>
                                        <option>XXXL</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 rock-item-page-details">
                        <button class="btn btn-success btn-large rock-add-to-cart-button">ADD TO BAG</button>
                    </div>
                    <div class="col-md-6 rock-item-page-details">
                        <button class="btn btn-default btn-large rock-add-to-cart-button">ADD TO WISHLIST</button>
                    </div>
                    <!-- Description -->
                    <div class="col-md-6 rock-item-page-details">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Details</div>

                            <!-- Sizes-->

                            <div class="panel-body">
                                <div class="row">
                                    <ul class="nav nav-tabs" role="tablist" id="tabs_login" >
                                        <li class="active" aria-controls="login" role="tab" ><a href="#description" data-toggle="tab">Description</a></li>
                                        <li aria-controls="f_pass" role="tab" ><a href="#specs" data-toggle="tab">Specification</a></li>
                                    </ul>
                                </div>

                                <div class="tab-content roc">

                                    <div class="tab-pane active" id="description">
                                        <div class="col-md-12 rock-item-desc">
                                            <?= $item_d['description'] ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="specs">
                                        <div class="col-md-12 rock-item-desc">
                                            <ul>
                                                <li>Color: <?= $item_d['color']; ?></li>
                                                <li>Category: <?= $item_d['category']; ?></li>
                                                <li>Model# :<?= $item_d['model_number']; ?></li>
                                                <li>Availability: In Stock </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>




<?php
//include_once TEMPLATE_H_F_PATH . 'footer.php';
?>