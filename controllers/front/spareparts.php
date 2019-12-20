<?php
    class SparepartsproductsSparepartsModuleFrontController extends ModuleFrontController{
        
        public function __construct()
        {
            parent::__construct();
        }
        public function init()
        {
            parent::init();
        }
        public function initContent()
        {
            parent::initContent();

            $dataID = Tools::getValue('id');
            $dataSLUG = Tools::getValue('slug');
            $lists = $this->getSparepartsNevelThree($dataID);
            $json = $this->unifyListProduct($lists);

            $this->context->smarty->assign(
                array(
                  'product_two_id' => $dataID,
                  'url' =>_PS_MODULE_DIR_.'sparepartsproducts/helps/ajax_spareparts_list.php',
                  'json' => $json,
                  'slug' => $dataSLUG
                ));
                
            $this->setTemplate('module:sparepartsproducts/views/templates/front/sparepartsproducts.tpl');
        }

        public function getSparepartsNevelThree($idProductLevelOne)
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

        public function getListProductsTree($lists)
        {
            $json = null;
            if ( !empty($lists) ) :
                foreach($lists as $list):
                    $idPthree = $list['id_product_level_three'];
                    $idPtwo = $list['id_product_level_two'];
                    $image = Image::getCover($idPthree);
                    $product = new Product($idPthree, false, Context::getContext()->language->id);
                    $url = $this->context->link->getProductLink($product);
                    $link = new Link;
                    $imagePath = 'http://'.$link->getImageLink($product->link_rewrite, $image['id_image'], 'home_default');

                    $json[] = array('image'=>$imagePath, 'productSparePart'=>$product, 'idPtwo' => $idPtwo, 'idPthree' => $idPthree, 'url' => $url);
                    
                endforeach;
            endif;
            return $json;
        }

        public function getListProductsTwo($lists)
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
        public function unifyListProduct($lists)
        {
            $listTwo = $this->getListProductsTwo($lists);
            $listThree = $this->getListProductsTree($lists);
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
        // @overwriting of the frontController method
        protected function getBreadcrumbLinks()
        {
            // Obtenemos el producto
            $producto= new Product((int)Tools::getValue('id'), (int)$this->context->language->id);
            
            // obtememos la categoria
            $category = new Category((int)$producto->id_category_default, (int)$this->context->language->id);
            
            $breadcrumb = parent::getBreadcrumbLinks(); /* Get the Breadcrumb array from the parent function which is situated in the FrontController.php */
            
            $breadcrumb['links'][] = array(
            'title' => $this->module->l('Products', 'sparepartsproducts') , /* Title which you want to give to the location */
            'url' => $this->context->link->getCategoryLink((int)2),
            );
            
            $breadcrumb['links'][] = array(
            'title' => $category->name , /* Title which you want to give to the location */
            'url' => $this->context->link->getCategoryLink((int)$producto->id_category_default),  /* URL which you want to provide for a location */
            );
            
            $breadcrumb['links'][] = array(
            'title' => $this->module->l('Spareparts', 'sparepartsproducts') , /* Title which you want to give to the location */
            'url' => '' /* URL which you want to provide for a location */
            );     
            
            $breadcrumb['links'][] = array(
            'title' => $producto->name[1] , /* Title which you want to give to the location */
            'url' => '' /* URL which you want to provide for a location */
            );
            
            return $breadcrumb;
        } 
    }
?>