<?= "<?php \n"?>
return [
<?php foreach($trans as $words=>$message):?>
	'<?=$words?>' => '<?= $message?>',
<?php endforeach;?>
];