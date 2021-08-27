<?php for ($j = 0; $j < 3; $j++) : ?>
    <?php if ($j < $stars) : ?>
        <?php if ($j == 1) : ?>
            <i class="fas fa-star" style="font-size: 20px"></i>
        <?php else : ?>
            <i class="fas fa-star" style="font-size: 15px"></i>
        <?php endif; ?>
    <?php else : ?>
        <?php if ($j == 1) : ?>
            <i class="far fa-star" style="font-size: 20px"></i>
        <?php else : ?>
            <i class="far fa-star" style="font-size: 15px"></i>
        <?php endif; ?>
    <?php endif; ?>
<?php endfor; ?>