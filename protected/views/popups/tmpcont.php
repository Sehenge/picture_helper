<?php
echo '<span style="font-size: 18px; text-align: center; position: relative; top: 10px; margin-bottom: 15px; display: block;"> Current feed:</span>';

//var_dump($data);die(1);
foreach ($data as $key => $model) {
    //print_r($model);die(1);
    $fPicture = explode(",", $model['pictures']);
    echo '<div class=tmpModel><strong>' . ($key+1) . '</strong>' . '. ' . $model['model'] .
        ' - ' . $model['colorCode'] . ' - ' . $model['size'] . '<a rel="' . $key . '">Delete</a>' . '<div class="fullModel">',
     '<img src="' . $fPicture[0] . '" width="450px" style="float: right;"/>',
     '<ul style="font-size: 14px;word-wrap: break-word;">',
     '<li>UPC: ' . $model['upc'] . '</li>',
     '<li>Model: ' . $model['model'] . '</li>',
     '<li>Brand: ' . $model['brand'] . '</li>',
     '<li>Manufacturer: ' . $model['manufacturer'] . '</li>',
     '<li>Color Code: ' . $model['colorCode'] . '</li>',
     '<li>Color: ' . $model['color'] . '</li>',
     '<li>Frame: ' . $model['frame'] . '</li>',
     '<li>Lens: ' . $model['lens'] . '</li>',
     '<li>Material: ' . $model['material'] . '</li>',
     '<li>Usage: ' . $model['usage'] . '</li>',
     '<li>Size: ' . $model['size'] . '</li>',
     '<li>Starting Bid: ' . $model['startingBid'] . '</li>',
     '<li>Seller Cost: ' . $model['sellerCost'] . '</li>',
     '<li>Retail price: ' . $model['retail'] . '</li>',
     '<li>Quantity: ' . $model['quantity'] . '</li>',
     '<li>RX: ' . $model['rxable'] . '</li>',
     '<li>Polarized: ' . $model['polarized'] . '</li>',
     '<li>Gender: ' . $model['gender'] . '</li>',
     '<li>Department: ' . $model['description'] . '</li>',
     '<li>Style: ' . $model['style'] . '</li>',
     '<li>Country: ' . $model['country'] . '</li>',
     '<li>Pictures: ' . $model['pictures'] . '</li>',
     '</ul></ul>',
     '</div></div>';
}