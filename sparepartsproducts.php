<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once __DIR__.'/classes/Installspareparts.php';
include_once __DIR__.'/classes/Uninstallspareparts.php';
include_once __DIR__.'/classes/Configurespareparts.php';

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use Symfony\Component\VarDumper\VarDumper;

    class Sparepartsproducts extends Module
    {
        public function __construct()
        {
            $this->name = 'sparepartsproducts';
            $this->author = 'Arigato';
            $this->version = '1.0.0';
            $this->bootstrap = true;
            parent:: __construct();
            $this->displayName = $this->l('Spare parts products');
            $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
            $this->description = $this->l('This is Module for prestashop, use for select spare parts of product');
            $this->ps_versions_compliancy = array('min'=> '1.7.0.0', 'max'=>'1.7.9.9');
        }
        public function install()
        {
            Installspareparts::createTable();
            return  parent::install() &&
                    $this->registerHook('displayHeader') &&
                    $this->registerHook('displayBackOfficeHeader') &&
                    $this->registerHook('displayTabSparePartsProducts') &&
                    $this->registerHook('displayContentTabSparePartsProducts') &&
                    $this->registerHook('displayAdminProductsExtra');
        }
        public function uninstall()
        {
            Uninstallspareparts::deleteTable();
            return parent::uninstall();
        }
        public function getContent()
        {
            $output = null;
            if (Tools::isSubmit('submit'.$this->name)):
                $tabTex = strval(Tools::getValue('TAB_TITLE'));
                $titleTabSpareparts = strval(Tools::getValue('TITLE_SPAREPARTS'));
                $contentTabSpareparts = strval(Tools::getValue('CONTENT_SPAREPARTS'));
                $btnTabSpareparts = strval(Tools::getValue('BUTTON_SPAREPARTS'));

                if($this->valideForm($tabTex) &&
                   $this->valideForm($titleTabSpareparts) &&
                   $this->valideForm($contentTabSpareparts) &&
                   $this->valideForm($btnTabSpareparts)):

                        $configure = new Configurespareparts($tabTex, $titleTabSpareparts, $contentTabSpareparts, $btnTabSpareparts);
                        $output = $configure->saveConfigure();
                        if($output):
                            $output = $this->displayConfirmation($this->l('Settings updated'));
                        else:
                            $output = $this->displayError($this->l('Invalid Configuration value'));
                        endif;
                else:
                    $output = $this->displayError($this->l('All fields are required'));
                endif;
            endif;          
            return $output.$this->displayForm();                                         
        }
        public function displayForm()
        {
            // Get default language
            $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');

            // Init Fields form array
            $fieldsForm[0]['form'] = [
                'legend' => [
                    'title' => $this->l('Settings for Spare parts'),
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Tab tittle'),
                        'name' => 'TAB_TITLE',
                        'size' => 20,
                        'required' => true
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Tab title area spare parts'),
                        'name' => 'TITLE_SPAREPARTS',
                        'size' => 40,
                        'required' => true
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('Tab Content in spare parts'),
                        'name' => 'CONTENT_SPAREPARTS',
                        'tinymce' => true,
                        'autoload_rte' => true,
                        'size' => 600,
                        'required' => true
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Button title area spare parts'),
                        'name' => 'BUTTON_SPAREPARTS',
                        'size' => 40,
                        'required' => true
                    ]
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right'
                ]
            ];

            $helper = new HelperForm();

            // Module, token and currentIndex
            $helper->module = $this;
            $helper->name_controller = $this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
            $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

            // Language
            $helper->default_form_language = $defaultLang;
            $helper->allow_employee_form_lang = $defaultLang;

            // Title and toolbar
            $helper->title = $this->displayName;
            $helper->show_toolbar = true;        // false -> remove toolbar
            $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
            $helper->submit_action = 'submit'.$this->name;
            $helper->toolbar_btn = [
                'save' => [
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                    '&token='.Tools::getAdminTokenLite('AdminModules'),
                ],
                'back' => [
                    'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                    'desc' => $this->l('Back to list')
                ]
            ];

            // Load current value
            $helper->fields_value['TAB_TITLE']          = Configurespareparts::getData('name_tab_spareparts');
            $helper->fields_value['TITLE_SPAREPARTS']   = Configurespareparts::getData('title_tab_spareparts');
            $helper->fields_value['CONTENT_SPAREPARTS'] = Configurespareparts::getData('content_tab_spareparts');
            $helper->fields_value['BUTTON_SPAREPARTS']  = Configurespareparts::getData('btn_tab_spareparts');

            return $helper->generateForm($fieldsForm);
        }
        public function valideForm($inputText)
        {
            if (!$inputText || empty($inputText)):
                return false;
            else:
                return true;
            endif;
        }
        public function hookDisplayTabSparePartsProducts()
        {
            $this->context->smarty->assign(array(
                'name_tab_spareparts' => Configurespareparts::getData('name_tab_spareparts')
            ));
            return $this->display(__FILE__,'views/templates/hook/tabspareparts.tpl');
        }
        public function hookDisplayContentTabSparePartsProducts()
        {
            $productSlug = array();
            if (Validate::isLoadedObject($product = new Product((int)Tools::getValue('id_product')))):
                $productSlug = $product;
            endif;
            $slug = $productSlug->link_rewrite[1];
            $this->context->smarty->assign(array(
                'title_tab_spareparts'  => Configurespareparts::getData('title_tab_spareparts'),
                'content_tab_spareparts'=> Configurespareparts::getData('content_tab_spareparts'),
                'btn_tab_spareparts'    => Configurespareparts::getData('btn_tab_spareparts'),
                'idProductValue' =>(int)Tools::getValue('id_product'),
                'productSlug' => $slug
            ));
            return $this->display(__FILE__,'views/templates/hook/contentspareparts.tpl');
        }
        public function hookDisplayHeader($params)
        {
            $this->context->controller->addCSS(array(
                $this->_path.'views/css/spareparts.css'
            ));
            $this->context->controller->addJS(array(
                $this->_path.'views/js/events.js'
            ));
        }
        public function hookDisplayBackOfficeHeader($params)
        {
            Media::addJsDef(array(
                'queryVariantProduct'   => '/'.basename(_PS_ADMIN_DIR_).'/ajax_products_list.php',
                'ajax_spareparts'       => $this->_path.'helps/ajax_spareparts.php',
                'ajax_spareparts_delete'=> $this->_path.'helps/ajax_spareparts_delete.php',
                'ajax_spareparts_list'  => $this->_path.'helps/ajax_spareparts_list.php'
            ));
            $this->context->controller->addCSS(array(
                $this->_path.'views/libs/select2/css/select2.css',
                $this->_path.'views/css/style.css'
            ));
            $this->context->controller->addJS(array(
                $this->_path.'views/js/bootstrap.bundle.min.js',
                $this->_path.'views/libs/select2/js/select2.full.js',
                $this->_path.'views/js/main.js',
                $this->_path.'views/js/selectProducts.js',
                $this->_path.'views/js/eraseProducts.js',
                $this->_path.'views/js/listProducts.js'
            ));
        }
        public function hookDisplayAdminProductsExtra($params)
        {                            
            if (Validate::isLoadedObject($product = new Product((int)$params['id_product']))) {
                // validate module
                //unset($product);                  
               
                $id_shop = Context::getContext()->shop->id;
                //$languages = $this->context->controller->getLanguages();
                $this->context->smarty->assign(array(
                    'product' => $product,
                    'languages_items' => Language::getLanguages(false, $this->context->shop->id),
                    'id_productmain_spareparts' => (int)$params['id_product']
                ));
                
                return $this->display(__FILE__, 'views/templates/admin/hookAdminProductsExtra.tpl');
            }
        }
    }   