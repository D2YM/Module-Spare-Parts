<?php

//======================================================================
// CLASS MANAGER SPAREPART REGISTER AND UPDATE
//======================================================================
require_once('../../../config/config.inc.php');
require_once('../../../init.php');


header('Content-Type: application/json');

//-----------------------------------------------------
// DEFINE VAR
//-----------------------------------------------------

$moduleName = 'sparepartsproducts';
$module = Module::getInstanceByName($moduleName);


$idProductLevelOne  = Tools::getValue('idProductLevelOne', false);
$idProductLevelTwo    = Tools::getValue('idProductLevelTwo', false);

$lists = getSparepartsNevelThree($idProductLevelOne);
/*$listTwo = getListProductsTwo($lists);

$listTwo = array_unique($listTwo, SORT_REGULAR);
unset($listTwo[0]);
*/
//$json[] = array('listTwo' => $listTwo, 'listThree' => getListProductsTree($lists));
$json = unifyListProduct($lists);
echo json_encode($json, JSON_FORCE_OBJECT);
die();


function getSparepartsNevelThree($idProductLevelOne)
{
    $sql =  'SELECT `'._DB_PREFIX_.'product_spareparts`.`id_product_level_three`, `'._DB_PREFIX_.'product_spareparts`.`id_product_level_two`, `'._DB_PREFIX_.'product_spareparts_despice`.`name_product_despice_spareparts`
             FROM `'._DB_PREFIX_.'product_spareparts_despice`
             INNER JOIN `'._DB_PREFIX_.'product_spareparts` ON `'._DB_PREFIX_.'product_spareparts`.`id_product_level_two`=`'._DB_PREFIX_.'product_spareparts_despice`.`id_product_level_two`
             WHERE `'._DB_PREFIX_.'product_spareparts_despice`.`id_product_level_one` = '.$idProductLevelOne;

    if(DB::getInstance()->execute($sql)):
        return DB::getInstance()->executeS($sql);
    else:
        return false;
    endif;
    return false;
}

function getListProductsTree($lists)
{
    $json = null;
    if ( !empty($lists) ) :
        foreach($lists as $list):
            $idPthree = $list['id_product_level_three'];
            $idPtwo = $list['id_product_level_two'];
            $image = Image::getCover($idPthree);
            $product = new Product($idPthree, false, Context::getContext()->language->id);
            $link = new Link;
            $imagePath = 'http://'.$link->getImageLink($product->link_rewrite, $image['id_image'], 'home_default');

            $json[] = array('image'=>$imagePath, 'productSparePart'=>$product, 'idPtwo' => $idPtwo, 'idPthree' => $idPthree);
            
        endforeach;
    endif;
    return $json;
}

function getListProductsTwo($lists)
{
    $json[] = array();
    if ( !empty($lists) ) :
        foreach($lists as $list):
            $idPtwo = $list['id_product_level_two'];
            $namePLevelTwo = $list['name_product_despice_spareparts'];

            $json[] = array('idPtwo' => $idPtwo, 'namePLevelTwo' => $namePLevelTwo);
            
        endforeach;
    endif;
    $json = array_unique($json, SORT_REGULAR);
    unset($json[0]);
    return $json;
}
function unifyListProduct($lists)
{
    $listTwo = getListProductsTwo($lists);
    $listThree = getListProductsTree($lists);
    $listY = array();
    $listT = array();
    foreach($listTwo as $two):
        //echo $two['idPtwo'].'->';
        $listT = array();
        foreach($listThree as $three):
            if($three['idPtwo'] === $two['idPtwo']):
                //echo $three['idPthree'].',';
                $listT[] = $three;
            endif;
        endforeach;
        //echo '/';
        $listY[] = array('two' => $two, 'three'=> $listT);
    endforeach;
    return $listY;
}