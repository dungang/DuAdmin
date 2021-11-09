<div class="step-widget">
    <div class="step-line"></div>
    <div class="steps">
        <?php foreach ($steps as $index => $step) : ?>
            <div class="step"><span class="info-tag <?= $step['activeClass'] ?>"><strong><?= $index + 1 ?></strong> <?= $step['name'] ?> <i class="fa fa-angle-double-right"></i></span></div>
        <?php endforeach; ?>
    </div>
</div>