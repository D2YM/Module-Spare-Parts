<?php
if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class Uninstallspareparts
{
    public static function deleteTable(){ 
        $sqls = array();
        $sqls[] = 'DROP  TABLE IF EXISTS '._DB_PREFIX_.'product_spareparts_despice';
        $sqls[] = 'DROP  TABLE IF EXISTS '._DB_PREFIX_.'product_spareparts';
        $sqls[] = 'DROP  TABLE IF EXISTS '._DB_PREFIX_.'product_spareparts_config';
        $sqls[] = 'DROP  TRIGGER '._DB_PREFIX_.'delete_spareparts_despice';
        $sqls[] = 'DROP  TRIGGER '._DB_PREFIX_.'delete_spareparts';

        foreach($sqls as $sql)
        {
            if(!DB::getInstance()->execute($sql))
                return false;
        }
    }
}