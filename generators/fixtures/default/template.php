<?= "<?php\n" ?>
use Faker\Factory;
$fk = Factory::create('<?= $locale ?>');
return [
<?php foreach($columns as $field => $fixture): ?>
    '<?= $field ?>' => <?= $fixture?>,
<?php endforeach; ?>
];
