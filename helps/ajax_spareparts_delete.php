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

$idProductLevelTree = Tools::getValue('idPieceLevelThree', false);
$idPieceLevelTwo    = Tools::getValue('idPieceLevelTwo', false);
if(!empty($idPieceLevelTwo) && !empty($idProductLevelTree)):
    if(deleteProduct($idPieceLevelTwo, $idProductLevelTree)):
        if(!getSparepartsNevelTwoInThreeID($idPieceLevelTwo)):
            if(deleteProductNevelTwo($idPieceLevelTwo)):
                echo json_encode('true', JSON_FORCE_OBJECT);
                die();
            else:
                echo json_encode('false', JSON_FORCE_OBJECT);
                die();
            endif;
        endif;
        echo json_encode('true', JSON_FORCE_OBJECT);
        die();
    else:
        echo json_encode('false', JSON_FORCE_OBJECT);
        die();
    endif;
endif;

if(!empty($idPieceLevelTwo)):
    if(deleteProductNevelTwo($idPieceLevelTwo)):
        echo json_encode('true', JSON_FORCE_OBJECT);
        die();
    else:
        echo json_encode('false', JSON_FORCE_OBJECT);
        die();
    endif;
endif;
//echo json_encode('True', JSON_FORCE_OBJECT);
die();



//-----------------------------------------------------
// CALL FUNCTIONS
//-----------------------------------------------------

function getSparepartsNevelThree($idPieceLevelTwo, $idProductLevelTree)
{
    $sql = 'SELECT * FROM `'._DB_PREFIX_.'product_spareparts` WHERE id_product_level_two = '.$idPieceLevelTwo.' AND id_product_level_three = '.$idProductLevelTree;
    if(DB::getInstance()->execute($sql)):
        if(!DB::getInstance()->getRow($sql)):
            return false;
        endif;
    else:
        return false;
    endif;
    return true;
}

function deleteProduct($idPieceLevelTwo, $idProductLevelTree)
{
    if(getSparepartsNevelThree($idPieceLevelTwo, $idProductLevelTree)):
        $tableSpareparts = 'product_spareparts';
        $where = '`id_product_level_two` = '.$idPieceLevelTwo. ' and `id_product_level_three` = '.$idProductLevelTree;
        if(DB::getInstance()->delete($tableSpareparts, $where)):
            return true;
        else:
            return false;
        endif;
    else:
        return false;
    endif;
}

function getSparepartsNevelTwoID($idProduct)
{
    $sql = 'SELECT * FROM `'._DB_PREFIX_.'product_spareparts_despice` WHERE `id_product_level_two` = '.$idProduct;
    if(DB::getInstance()->execute($sql)):
        return DB::getInstance()->getRow($sql);
    else:
        return false;
    endif;
}

function getSparepartsNevelTwoInThreeID($idProduct)
{
    $sql = 'SELECT * FROM `'._DB_PREFIX_.'product_spareparts` WHERE `id_product_level_two` = '.$idProduct;
    if(DB::getInstance()->execute($sql)):
        return DB::getInstance()->getRow($sql);
    else:
        return false;
    endif;
}
function deleteProductNevelTwo($idPieceLevelTwo){
    if(getSparepartsNevelTwoInThreeID($idPieceLevelTwo)):
        $tableSpareparts = 'product_spareparts';
        $where = '`id_product_level_two` = '.$idPieceLevelTwo;
        if(DB::getInstance()->delete($tableSpareparts, $where)):
            if(getSparepartsNevelTwoID($idPieceLevelTwo)):
                $tableSpareparts = 'product_spareparts_despice';
                $where = '`id_product_level_two` = '.$idPieceLevelTwo;
                if(DB::getInstance()->delete($tableSpareparts, $where)):
                    return true;
                else:
                    return false;
                endif;
            endif;
            return false;
        else:
            return false;
        endif;
    else:
        if(getSparepartsNevelTwoID($idPieceLevelTwo)):
            $tableSpareparts = 'product_spareparts_despice';
            $where = '`id_product_level_two` = '.$idPieceLevelTwo;
            if(DB::getInstance()->delete($tableSpareparts, $where)):
                return true;
            else:
                return false;
            endif;
        endif;
    endif;
}