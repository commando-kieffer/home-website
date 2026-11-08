<?php
/**
 * Page de détail d'un mod ou d'un outil.
 *
 * @var array                $entry  Entrée de App\Models\ModModel
 * @var array<string, array> $others Les autres entrées du même type
 */
$isTool = $entry['workshop_id'] === null;
?>
<main class="mod">
    <div class="mod__wrap">
        <a class="mod__back" href="/mods">
            <span aria-hidden="true">&larr;</span> Tous les mods
        </a>

        <header class="mod-head">
            <div class="mod-head__icon">
                <svg aria-hidden="true" focusable="false"><use href="/pictures/mods/icons.svg#<?= esc($entry['icon'], 'attr') ?>"></use></svg>
            </div>
            <div class="mod-head__text">
                <p class="mod-head__category"><?= esc($entry['category']) ?></p>
                <h1><?= esc($entry['name']) ?></h1>
                <p class="mod-head__tagline"><?= esc($entry['tagline']) ?></p>
                <div class="mod-head__actions">
                    <?php if ($entry['workshop_url']) : ?>
                        <a class="mod-btn" href="<?= esc($entry['workshop_url'], 'attr') ?>" target="_blank" rel="noopener">Voir sur le Workshop</a>
                    <?php endif; ?>
                    <?php if ($entry['repo_url']) : ?>
                        <a class="mod-btn" href="<?= esc($entry['repo_url'], 'attr') ?>" target="_blank" rel="noopener">Code source sur GitHub</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <?php if (!empty($entry['stats'])) : ?>
            <dl class="mod-stats" style="--stats: <?= count($entry['stats']) ?>">
                <?php foreach ($entry['stats'] as [$value, $label]) : ?>
                    <div class="mod-stats__item">
                        <dt><?= esc($label) ?></dt>
                        <dd><?= esc((string) $value) ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        <?php endif; ?>

        <div class="mod-layout">
            <div class="mod-main">
                <section class="mod-section">
                    <h2 class="mod-section__title">À propos</h2>
                    <?php foreach ($entry['summary'] as $paragraph) : ?>
                        <p class="mod-section__text"><?= esc($paragraph) ?></p>
                    <?php endforeach; ?>
                </section>

                <?php if (!empty($entry['shots'])) : ?>
                    <section class="mod-section">
                        <h2 class="mod-section__title">Captures</h2>
                        <ul class="mod-gallery">
                            <?php foreach ($entry['shots'] as $shot) : ?>
                                <li class="mod-gallery__item">
                                    <a class="mod-gallery__link" href="<?= esc($shot['src'], 'attr') ?>" data-lightbox data-alt="<?= esc($shot['alt'], 'attr') ?>">
                                        <img src="<?= esc($shot['thumb'], 'attr') ?>" srcset="<?= esc($shot['thumb'], 'attr') ?> 640w, <?= esc($shot['src'], 'attr') ?> 1920w" sizes="(min-width: 1024px) 400px, 100vw" alt="<?= esc($shot['alt'], 'attr') ?>" loading="lazy"<?= $shot['pos'] ? ' style="object-position: ' . esc($shot['pos'], 'attr') . '"' : '' ?>>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>

                <?php if (!empty($entry['features'])) : ?>
                    <section class="mod-section">
                        <h2 class="mod-section__title">Fonctionnalités</h2>
                        <ul class="mod-features">
                            <?php foreach ($entry['features'] as $feature) : ?>
                                <li class="mod-feature">
                                    <h3><?= esc($feature['title']) ?></h3>
                                    <p><?= esc($feature['text']) ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>

                <?php if (!empty($entry['content'])) : ?>
                    <section class="mod-section">
                        <h2 class="mod-section__title">Contenu</h2>
                        <?php foreach ($entry['content'] as $group) : ?>
                            <div class="mod-group">
                                <h3><?= esc($group['title']) ?></h3>
                                <?php if (!empty($group['note'])) : ?>
                                    <p class="mod-group__note"><?= esc($group['note']) ?></p>
                                <?php endif; ?>
                                <ul class="mod-chips">
                                    <?php foreach ($group['items'] as $item) : ?>
                                        <li><?= esc($item) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>

                <?php if (!empty($entry['standalone'])) : ?>
                    <section class="mod-section" id="mods-independants">
                        <h2 class="mod-section__title">Mods indépendants</h2>
                        <p class="mod-section__text mod-section__text--intro">Ces véhicules, réalisés par l’équipe du Commando, sont téléchargeables de manière indépendante.</p>
                        <ul class="mod-standalone">
                            <?php foreach ($entry['standalone'] as $mod) : ?>
                                <li class="mod-standalone__item">
                                    <div class="mod-standalone__head">
                                        <h3><?= esc($mod['name']) ?></h3>
                                        <p class="mod-standalone__meta">Par <?= esc($mod['author']) ?></p>
                                    </div>
                                    <p class="mod-standalone__text"><?= esc($mod['tagline']) ?></p>
                                    <ul class="mod-standalone__points">
                                        <?php foreach ($mod['points'] as $point) : ?>
                                            <li><?= esc($point) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <a class="mod-standalone__link" href="<?= esc($mod['workshop_url'], 'attr') ?>" target="_blank" rel="noopener">
                                        Voir sur le Workshop
                                        <svg aria-hidden="true" focusable="false"><use href="/pictures/mods/icons.svg#external"></use></svg>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>

                <?php if (!empty($entry['credits'])) : ?>
                    <section class="mod-section" id="credits">
                        <h2 class="mod-section__title">Crédits</h2>
                        <div class="mod-table-wrap">
                            <table class="mod-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Élément</th>
                                        <th scope="col">Auteur</th>
                                        <th scope="col">Licence</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($entry['credits'] as $credit) : ?>
                                        <tr>
                                            <td><?= esc($credit['asset']) ?></td>
                                            <td><?= esc($credit['author']) ?></td>
                                            <td><?= esc($credit['license']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                <?php endif; ?>
            </div>

            <aside class="mod-side">
                <div class="mod-panel">
                    <h2 class="mod-panel__title">Fiche</h2>
                    <dl class="mod-facts">
                        <?php if ($entry['workshop_id']) : ?>
                            <div>
                                <dt>ID Workshop</dt>
                                <dd class="mod-facts__id">
                                    <code><?= esc($entry['workshop_id']) ?></code>
                                    <a class="mod-facts__link" href="<?= esc($entry['workshop_url'], 'attr') ?>" target="_blank" rel="noopener" title="Ouvrir la page Workshop" aria-label="Ouvrir la page Workshop (nouvel onglet)">
                                        <svg aria-hidden="true" focusable="false"><use href="/pictures/mods/icons.svg#external"></use></svg>
                                    </a>
                                </dd>
                            </div>
                        <?php endif; ?>
                        <?php foreach ($entry['facts'] ?? [] as [$label, $value]) : ?>
                            <div>
                                <dt><?= esc($label) ?></dt>
                                <dd><?= esc($value) ?></dd>
                            </div>
                        <?php endforeach; ?>
                        <div>
                            <dt>Dépendances</dt>
                            <dd>
                                <?php if (empty($entry['requires'])) : ?>
                                    <?= $isTool ? 'Aucune' : 'Aucune, hormis le jeu' ?>
                                <?php else : ?>
                                    <ul class="mod-requires">
                                        <?php foreach ($entry['requires'] as $requirement) : ?>
                                            <li>
                                                <?php if (!empty($requirement['slug'])) : ?>
                                                    <a href="/mods/<?= esc($requirement['slug'], 'attr') ?>"><?= esc($requirement['name']) ?></a>
                                                <?php elseif (!empty($requirement['url'])) : ?>
                                                    <a href="<?= esc($requirement['url'], 'attr') ?>" target="_blank" rel="noopener"><?= esc($requirement['name']) ?></a>
                                                <?php else : ?>
                                                    <?= esc($requirement['name']) ?>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </dd>
                        </div>
                    </dl>
                </div>

                <?php if ($entry['install']) : ?>
                    <div class="mod-panel">
                        <h2 class="mod-panel__title"><?= esc($entry['install']['label']) ?></h2>
                        <pre class="mod-code"><code><?= esc($entry['install']['code']) ?></code></pre>
                        <button type="button" class="mod-copy" data-copy="<?= esc($entry['install']['code'], 'attr') ?>">Copier</button>
                    </div>
                <?php endif; ?>
            </aside>
        </div>

        <?php if (!empty($others)) : ?>
            <section class="mod-others" aria-labelledby="mod-others-title">
                <h2 id="mod-others-title" class="mod-section__title"><?= $entry['group'] === 'mods' ? 'Autres mods' : 'Nos mods' ?></h2>
                <ul class="mod-tiles">
                    <?php foreach ($others as $other) : ?>
                        <li class="mod-tile">
                            <a class="mod-tile__link" href="/mods/<?= esc($other['slug'], 'attr') ?>">
                                <span class="mod-tile__icon">
                                    <svg aria-hidden="true" focusable="false"><use href="/pictures/mods/icons.svg#<?= esc($other['icon'], 'attr') ?>"></use></svg>
                                </span>
                                <span>
                                    <span class="mod-tile__name"><?= esc($other['name']) ?></span><br>
                                    <span class="mod-tile__category"><?= esc($other['category']) ?></span>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>
    </div>
</main>
<?php if (!empty($entry['shots'])) : ?>
    <dialog class="lightbox" id="lightbox" aria-label="Visionneuse d’images">
        <button type="button" class="lightbox__btn lightbox__close" aria-label="Fermer">&times;</button>
        <button type="button" class="lightbox__btn lightbox__nav lightbox__nav--prev" aria-label="Image précédente">&lsaquo;</button>
        <figure class="lightbox__stage">
            <img class="lightbox__img" alt="">
            <figcaption class="lightbox__caption"></figcaption>
        </figure>
        <button type="button" class="lightbox__btn lightbox__nav lightbox__nav--next" aria-label="Image suivante">&rsaquo;</button>
        <p class="lightbox__counter" aria-hidden="true"></p>
    </dialog>
<?php endif; ?>
<script src="/js/mods.js" defer></script>
