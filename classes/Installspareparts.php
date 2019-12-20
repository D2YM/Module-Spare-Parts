<?php
if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class Installspareparts
{
    public static function createTable(){
        $sqls = array();

        $sqls[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'product_spareparts (
            id_product_level_two INT(10),
            id_product_level_three INT(10)
        ) ENGINE ='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8';

        $sqls[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'product_spareparts_despice (
            id_product_level_one INT(10),
            id_product_level_two INT(10) AUTO_INCREMENT,
            name_product_despice_spareparts VARCHAR(200),
            PRIMARY KEY(id_product_level_two)
        ) ENGINE ='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8';
        
        $sqls[] = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'product_spareparts_config (
            id_config INT(10),
            name_tab_spareparts VARCHAR(20),
            title_tab_spareparts VARCHAR(40),
            content_tab_spareparts VARCHAR(600),
            btn_tab_spareparts VARCHAR(40),
            PRIMARY KEY(id_config)
        ) ENGINE ='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8';

    /* $sqls[] = 'CREATE TRIGGER '._DB_PREFIX_.'products__AD BEFORE DELETE ON '._DB_PREFIX_.'product
            FOR EACH ROW DELETE FROM '._DB_PREFIX_.'product_pieces
            WHERE '._DB_PREFIX_.'product_pieces.id_piece = old.id_product_level_one OR
                '._DB_PREFIX_.'product_pieces.id_product_level_one = old.id_product';*/

        $sqls[] = 'CREATE TRIGGER `'._DB_PREFIX_.'delete_spareparts_despice` BEFORE DELETE ON `'._DB_PREFIX_.'product`
                FOR EACH ROW DELETE FROM ps_product_spareparts_despice
                        WHERE '._DB_PREFIX_.'product_spareparts_despice.id_product_level_one = old.id_product';        
        
        $sqls[] = 'CREATE TRIGGER `'._DB_PREFIX_.'delete_spareparts` BEFORE DELETE ON `'._DB_PREFIX_.'product`
                FOR EACH ROW DELETE FROM '._DB_PREFIX_.'product_spareparts
                    WHERE '._DB_PREFIX_.'product_spareparts.id_product_level_three = old.id_product';
                    
        foreach($sqls as $sql):
            if(!DB::getInstance()->execute($sql))
                return false;
        endforeach;
        return true;
    }
}