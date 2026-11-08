<?php
/**
 * Page « Mods » — vitrine des mods Arma Reforger du Commando.
 *
 * @var array<string, array> $mods  Mods du Workshop (voir App\Models\ModModel)
 * @var array<string, array> $tools Outil serveur hors Workshop
 */
?>
<main class="mods">
    <section class="mods-hero" aria-labelledby="mods-title">
        <div class="mods-hero__inner">
            <p class="mods-hero__eyebrow">Arma Reforger</p>
            <h1 id="mods-title">Nos mods</h1>
            <p class="mods-hero__lead">
                Le Commando développe ses propres mods pour Arma Reforger : une faction française, des props, des bâtiments, des véhicules, des armes et des tenues. Ils sont publiés sur le Workshop. Nous proposons aussi un panneau web pour gérer un serveur.
            </p>
        </div>
    </section>

    <div class="mods__wrap">
        <section aria-labelledby="mods-list-title">
            <h2 id="mods-list-title" class="mods__heading">Mods du Workshop</h2>
            <ul class="mod-grid">
                <?php foreach ($mods as $mod) : ?>
                    <?= view('pages/_mod_card', ['mod' => $mod]) ?>
                <?php endforeach; ?>
            </ul>
        </section>

        <?php if (!empty($tools)) : ?>
            <section class="mods__tools" aria-labelledby="mods-tools-title">
                <h2 id="mods-tools-title" class="mods__heading">Outil serveur</h2>
                <ul class="mod-grid mod-grid--wide">
                    <?php foreach ($tools as $tool) : ?>
                        <?= view('pages/_mod_card', ['mod' => $tool]) ?>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>
    </div>
</main>
