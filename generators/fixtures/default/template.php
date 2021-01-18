<?= "<?php\n" ?>
return [
<?php foreach($columns as $field => $fixture): ?>
    '<?= $field ?>' => <?= $fixture?>,
<?php endforeach; ?>
];
