<?= "<?php\n" ?>
use Faker\Factory;
$fk = Factory::create('<?= $locale ?>');
return [
<?php for($i=0; $i<$count; $i++):?>
    [
<?php foreach($columns as $field => $fixture): ?>
    	'<?= $field ?>' => <?= $fixture?>,
<?php endforeach; ?>
    ],
<?php endfor;?>
];
