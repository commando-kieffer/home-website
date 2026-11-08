<?php
/**
 * Carte d'un mod : capture en couverture, ou icône à défaut.
 *
 * @var array $mod Entrée de App\Models\ModModel
 */
$cover = $mod['cover'];
?>
<li class="mod-card">
    <a class="mod-card__link" href="/mods/<?= esc($mod['slug'], 'attr') ?>">
        <div class="mod-card__media">
            <?php if ($cover) : ?>
                <img class="mod-card__img" src="<?= esc($cover['thumb'], 'attr') ?>" alt="<?= esc($cover['alt'], 'attr') ?>" loading="lazy"<?= $cover['pos'] ? ' style="object-position: ' . esc($cover['pos'], 'attr') . '"' : '' ?>>
            <?php else : ?>
                <svg class="mod-card__icon" aria-hidden="true" focusable="false"><use href="/pictures/mods/icons.svg#<?= esc($mod['icon'], 'attr') ?>"></use></svg>
            <?php endif; ?>
            <span class="mod-card__badge"><?= esc($mod['category']) ?></span>
        </div>
        <div class="mod-card__body">
            <h3 class="mod-card__title"><?= esc($mod['name']) ?></h3>
            <p class="mod-card__text"><?= esc($mod['tagline']) ?></p>
            <span class="mod-card__more">Voir le détail <span aria-hidden="true">&rarr;</span></span>
        </div>
    </a>
</li>
