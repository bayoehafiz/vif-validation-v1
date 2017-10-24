<script type="text/javascript">
	jQuery(function($){
<?
foreach($noties as $type => $all){
	if($type){?>
	noty({text: "<?=implode('<br>', (array)$all)?>", type:'<?=$type?>',timeout: 5000});
<?}}?>
	});
</script>
