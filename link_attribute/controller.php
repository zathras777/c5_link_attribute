<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class LinkAttributePackage extends Package {

     protected $pkgHandle = 'link_attribute';
     protected $appVersionRequired = '5.5.1';
     protected $pkgVersion = '0.1';

     public function getPackageDescription() {
          return t("An attribute type for an URL with title.");
     }

     public function getPackageName() {
          return t("Link Attribute");
     }
     
    public function install() {
        Loader::model('attribute/type');
        Loader::model('attribute/category');
        
        $pkg = parent::install();

        $at = AttributeType::add('link', 'Link', $pkg);
        $cat = AttributeKeyCategory::getByHandle('collection');
        $cat->associateAttributeKeyType($at);

        Loader::model('attribute/set');
        $aset = AttributeSet::getByHandle('navigation');
//        $att->setAttributeSet($aset);
    }

    public function upgrade() {
        $pkg = parent::install();
    }
    
}
?>
