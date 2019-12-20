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

$data_id            = Tools::getValue('data', false);
$idProduct          = Tools::getValue('idProduct', false);
$idPieceLevelTwo  = Tools::getValue('idPieceLevelTwo', false);
$namePieceLevelTwo  = Tools::getValue('namePieceLevelTwo', false);

if(empty($namePieceLevelTwo)):
    die('Nombre del repuesto es obligatorio');
endif;

//-----------------------------------------------------
// CALL FUNCTIONS
//-----------------------------------------------------

if(!empty($idPieceLevelTwo)):
    setSparepartsNevelTwo($idProduct, $idPieceLevelTwo, $namePieceLevelTwo);
    $ans = processDataSparepartsNevelThree($data_id, $idProduct, $namePieceLevelTwo, $idPieceLevelTwo);
    if(!$ans):
        echo json_encode('true', JSON_FORCE_OBJECT);
        die();
    else:
        echo json_encode('false', JSON_FORCE_OBJECT);
        die();
    endif;
    die();
endif;

if($data = getSparepartsNevelTwo($idProduct, $namePieceLevelTwo)):
    $ans = processDataSparepartsNevelThree($data_id, $idProduct, $namePieceLevelTwo);
    if(!$ans):
        echo json_encode('true', JSON_FORCE_OBJECT);
        die();
    else:
        echo json_encode('false', JSON_FORCE_OBJECT);
        die();
    endif;
    die();
else:
    $resp = registerSparepartsNevelTwo($idProduct, $namePieceLevelTwo);
    $ans = processDataSparepartsNevelThree($data_id, $idProduct, $namePieceLevelTwo);
    if(!$ans):
        echo json_encode('true', JSON_FORCE_OBJECT);
        die();
    else:
        echo json_encode('false', JSON_FORCE_OBJECT);
        die();
    endif;
    die();
endif;

echo json_encode($_POST, JSON_FORCE_OBJECT);

die();

//-----------------------------------------------------
// FUNCTIONS
//-----------------------------------------------------

/* function registerSparepartsNevelTwo */

# $tableSpareparts              -> Name table en DB
# $datos                        -> Datos to register
# DB::getInstance()->insert()   -> Insert data for DB

/**
 * This funtion for register product to nevel two
 * in DB using function of prestashop
 */

function registerSparepartsNevelTwo($idProduct, $namePieceLevelTwo)
{
    $tableSpareparts = 'product_spareparts_despice';
    $datos = array(
        'id_product_level_one' => $idProduct,
        'name_product_despice_spareparts' => strtolower($namePieceLevelTwo)
    );
    return DB::getInstance()->insert(
        $tableSpareparts,
        $datos 
    );
}

/* function getSparepartsNevelTwo */

# $sql                              -> SQL consult for DB
# DB::getInstance()->execute($sql)  -> Datos to register
# DB::getInstance()->getRow()       -> get data for DB
# Return response of DB

/**
 * This funtion for register product to nevel two
 * in DB using function of prestashop
 */

function getSparepartsNevelTwo($idProduct, $namePieceLevelTwo)
{
    $sql = 'SELECT * FROM `'._DB_PREFIX_.'product_spareparts_despice` WHERE `id_product_level_one` = '.$idProduct.' AND `name_product_despice_spareparts` = "'.strtolower($namePieceLevelTwo).'"';
    if(DB::getInstance()->execute($sql)):
        return DB::getInstance()->getRow($sql);
    else:
        return false;
    endif;
}

/* function getSparepartsNevelTwo with idSparepartsNevelTwo */

# $sql                              -> SQL consult for DB
# DB::getInstance()->execute($sql)  -> Datos to register
# DB::getInstance()->getRow()       -> get data for DB
# Return response of DB

/**
 * This funtion for register product to nevel two
 * in DB using function of prestashop
 */

function getSparepartsNevelTwoId($idProduct, $idPieceLevelTwo)
{
    $sql = 'SELECT * FROM `'._DB_PREFIX_.'product_spareparts_despice` WHERE `id_product_level_one` = '.$idProduct.' AND `id_product_level_two` = '.$idPieceLevelTwo;
    if(DB::getInstance()->execute($sql)):
        return DB::getInstance()->getRow($sql);
    else:
        return false;
    endif;
}

/* function setSparepartsNevelTwo */

# $tableSpareparts              -> Name table en DB
# $where                        -> Sentence condicionalite for update data
# $datos                        -> Datos to register
# DB::getInstance()->insert()   -> Insert data for DB
# Return response of DB

/**
 * This funtion for register product to nevel two
 * in DB using function of prestashop
 */

function setSparepartsNevelTwo($idProduct, $idPieceLevelTwo, $namePieceLevelTwo)
{
    if(getSparepartsNevelTwoId($idProduct, $idPieceLevelTwo)):
        $tableSpareparts = 'product_spareparts_despice';
        $where = 'id_product_level_two = '.$idPieceLevelTwo;
        $datos = array(
            'id_product_level_one' => $idProduct,
            'name_product_despice_spareparts' => strtolower($namePieceLevelTwo)
        );
        return DB::getInstance()->update(
            $tableSpareparts,
            $datos,
            $where 
        );
    endif;
}

function processDataSparepartsNevelThree($data, $idProduct, $namePieceLevelTwo, $idPieceLevelTwo = null)
{
    $error = false;
    $data = json_decode($data);
    if(is_null($idPieceLevelTwo)):
        $resp = getSparepartsNevelTwo($idProduct, $namePieceLevelTwo);
        $idPieceLevelTwo = $resp['id_product_level_two'];
        $error = bucleWriteDataProduct($data, $idPieceLevelTwo);
    else:
        $error = bucleWriteDataProduct($data, $idPieceLevelTwo);
    endif;
    return $error;
}

function bucleWriteDataProduct($data, $idPieceLevelTwo)
{
    $error = false;
    if(is_array($data) || is_object($data)):
        foreach($data as $dat):  
            if(!getSparepartsNevelThree($dat, $idPieceLevelTwo)):
                if(!registerSparepartsNevelThree($dat, $idPieceLevelTwo))
                    $error = true;
            endif;
        endforeach;
    endif;
    return $error;
}

function registerSparepartsNevelThree($idProduct, $idPieceLevelTwo)
{
    $tableSpareparts = 'product_spareparts';
    $datos = array(
        'id_product_level_three' => $idProduct,
        'id_product_level_two' => $idPieceLevelTwo
    );
    return DB::getInstance()->insert(
        $tableSpareparts,
        $datos 
    );
}

function getSparepartsNevelThree($idProduct, $idPieceLevelTwo)
{
    $sql = 'SELECT * FROM `'._DB_PREFIX_.'product_spareparts` WHERE `id_product_level_three` = '.$idProduct.' AND `id_product_level_two` = '.$idPieceLevelTwo;

    if(DB::getInstance()->execute($sql)):
        return DB::getInstance()->getRow($sql);
    else:
        return false;
    endif;
}

function setSparepartsNevelThree($idProduct, $idPieceLevelTwo)
{
    $tableSpareparts = 'product_spareparts_despice';
    $where = 'id_product_level_two = '.$idPieceLevelTwo;
    $datos = array(
        'id_product_level_three' => $idProduct
    );
    return DB::getInstance()->update(
        $tableSpareparts,
        $datos,
        $where 
    );
}