<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$f = Loader::helper('form');
?>
<style>
.at-link { margin: .25em .5em; border-top: 1px solid white; }
</style>

<div class="ccm-attribute">
<?php
$pos = 0;
foreach($links as $l) {
    $tN = "akID[".$akID."][".$l['linkID']."][title]";
    $uN = "akID[".$akID."][".$l['linkID']."][url]";
?>
<div class="at-link" data-id="<?echo $l['linkID']?>" data-pos="<?echo $l['pos']?>">
<p>
<label>Title</label><?php echo $f->text($tN, $l['title']); ?>
</p>
<p>
<label>URL</label><?php echo $f->text($uN, $l['url']); ?>
</p>
</div>
<?php
    $pos += 1;
}
?>

<div class="at-link" data-pos="<?echo $pos?>">
<input type="hidden" name="akID[<?echo $akID?>][new][1][pos]" value="<?echo $pos?>"/>
<p>
  <label>Title</label>
  <input id="akID[<?echo $akID?>][new][1][title]" type="text" 
         name="akID[<?echo $akID?>][new][1][title]" value="" 
         class="ccm-input-text" />
</p>
<p>
  <label>URL</label>
  <input id="akID[<?echo $akID?>][new][1][url]" type="text" 
         name="akID[<?echo $akID?>][new][1][url]" value="" 
         class="ccm-input-text" />
</p>
</div>
<? $pos += 1; ?>
</div>

