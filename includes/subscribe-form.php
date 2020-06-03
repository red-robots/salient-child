<?php 
$title = get_field("subscribe_toptext","option"); 
$code = get_field("subscribe_code","option"); 
?>
<div class="subscribe-form-wrapper">
	<?php if ($title) { ?>
	<h2 class="subscribeTxt"><?php echo $title ?></h2>	
	<?php } ?>

	<?php if ($code) { ?>
	<div class="formCode"><?php echo $code ?></div>	
	<?php } ?>
</div>