<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class C5LinkAttributePackage extends Package {

    protected $pkgHandle = 'c5_link_attribute';
    protected $appVersionRequired = '5.5.1';
    protected $pkgVersion = '0.2';

    public function getPackageDescription() 
    {
         return t("An attribute type for an URL with title.");
    }

    public function getPackageName() 
    {
         return t("Link Attribute");
    }
         
    public function install() 
    {
        Loader::model('attribute/type');
        Loader::model('attribute/category');
        
        $pkg = parent::install();

        $at = AttributeType::add('link', 'Link', $pkg);
        $cat = AttributeKeyCategory::getByHandle('collection');
        $cat->associateAttributeKeyType($at);
    }

    public function upgrade() 
    {
        $pkg = parent::install();
    }
    
}
?>
