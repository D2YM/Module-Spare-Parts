<?php
if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class Configurespareparts extends ObjectModel{

    protected $tabTextSpareParts;
    protected $titleSpareParts;
    protected $contentSpareParts;
    protected $btnTextSpareParts;

    public function __construct($tabTextSpareParts, $titleSpareParts, $contentSpareParts, $btnTextSpareParts)
    {        
        $this->tabTextSpareParts = $tabTextSpareParts;
        $this->titleSpareParts = $titleSpareParts;
        $this->contentSpareParts = $contentSpareParts;
        $this->btnTextSpareParts = $btnTextSpareParts;
    }
    public function saveConfigure()
    {   
        if($this->configureDate()):
            if($this->updateDate()):
                return true;
            else:
                return false;
            endif;
        else:
            if($this->insertDate()):                
                return true;
            else:
                return false;
            endif;
        endif;
        return false;
    }
    public function configureDate()
    {
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'product_spareparts_config` WHERE `id_config` = 1';
        if(DB::getInstance()->execute($sql))
            return DB::getInstance()->getRow($sql);
        else
            return false;
    }
    public function insertDate()
    {
        $data = array(
            'id_config'             => 1,
            'name_tab_spareparts'   => $this->tabTextSpareParts,
            'title_tab_spareparts'  => $this->titleSpareParts, 
            'content_tab_spareparts'=> $this->contentSpareParts, 
            'btn_tab_spareparts'    => $this->btnTextSpareParts
        );
        $table = 'product_spareparts_config';
        $ans = DB::getInstance()->insert(            
            $table,
            $data
        );
        return $ans;
    }
    public function updateDate()
    {
        $data = array(
            'name_tab_spareparts'   => $this->tabTextSpareParts,
            'title_tab_spareparts'  => $this->titleSpareParts, 
            'content_tab_spareparts'=> $this->contentSpareParts, 
            'btn_tab_spareparts'    => $this->btnTextSpareParts
        );
        $table = 'product_spareparts_config';
        $where = 'id_config = 1';
        $limit = 1;
        $ans = DB::getInstance()->update(            
            $table,
            $data,
            $where,
            $limit
        );
        return $ans;
    }
    public static function getData($term)
    {
        $sql = 'SELECT `'.$term.'` FROM `'._DB_PREFIX_.'product_spareparts_config` WHERE `id_config` = 1';
        return DB::getInstance()->getRow($sql)[$term];
    }
}