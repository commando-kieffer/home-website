<?php
/**
 * Page « Métiers » — organigramme des pôles du Commando.
 *
 * $jobs_tree = [
 *   'primary'   => [ JobTreeNode{ label, officer, members } ],  // Commandement
 *   'secondary' => [ JobTreeNode, ... ],                        // pôles
 *   'tertiary'  => [ JobTreeNode, ... ],                        // pôles
 * ]
 * Chaque membre est un UserDTO : { username, primary_group, ... }.
 */

$rankOf = static function ($user): ?string {
    if ($user === null || $user === false) {
        return null;
    }
    if (!isset($user->primary_group)) {
        return null;
    }
    $rank = trim((string) $user->primary_group);

    return $rank !== '' ? $rank : null;
};

$initialOf = static function ($user): string {
    $name = isset($user->username) ? trim((string) $user->username) : '';

    return $name !== '' ? mb_strtoupper(mb_substr($name, 0, 1)) : '?';
};

/* Abréviations de grade (mêmes que la caserne). Repli sur le nom complet si absent. */
$shortRankOf = static function (?string $rank): ?string {
    static $map = [
        'Capitaine de corvette'                    => 'CptC',
        'Lieutenant de vaisseau'                    => 'Lv',
        'Enseigne de vaisseau de première classe'   => 'Ev1',
        'Enseigne de vaisseau de seconde classe'    => 'Ev2',
        'Aspirant'                                  => 'Asp',
        'Réserviste'                                => 'Rés',
        'Major'                                     => 'Maj',
        'Maître principal'                          => 'Mp',
        'Premier maître'                            => 'Pm',
        'Maître'                                    => 'M',
        'Second maître de première classe'          => 'Sm1',
        'Second maître de seconde classe'           => 'Sm2',
        'Second maître maistrancier'                => 'Smm',
        'Quartier-maître de première classe'        => 'Qm1',
        'Quartier-maître de seconde classe'         => 'Qm2',
        'Matelot breveté'                           => 'Mtb',
        'Matelot'                                   => 'Mtl',
        'Cadet'                                     => 'Cadet',
    ];

    return $rank === null ? null : ($map[$rank] ?? $rank);
};

$primary   = $jobs_tree['primary'][0] ?? null;
$commandant = ($primary && !empty($primary->members)) ? $primary->members[0] : null;
$staff      = ($primary && count($primary->members) > 1) ? array_slice($primary->members, 1) : [];

$poles = array_merge($jobs_tree['secondary'] ?? [], $jobs_tree['tertiary'] ?? []);
?>
<main class="metiers">
    <div class="metiers__wrap">
        <header class="metiers__head">
            <h1>Métiers</h1>
            <p class="metiers__intro">
                Le Commando s'organise en métiers, chacun rattaché au Commandant et animé par un chef de métier.
            </p>
        </header>

        <section class="metiers__command" aria-label="Commandement">
            <?php if ($commandant) : ?>
                <article class="command-card">
                    <span class="command-card__label">Commandant</span>
                    <div class="command-card__id">
                        <span class="avatar avatar--lg" data-initial="<?= esc($initialOf($commandant)) ?>">
                            <?php if ($rankOf($commandant)) : ?>
                                <img src="/pictures/jackets/<?= esc($rankOf($commandant)) ?>.png" alt=""
                                    loading="lazy" onerror="this.remove()">
                            <?php endif; ?>
                        </span>
                        <span class="command-card__name"><?= esc($commandant->username) ?></span>
                        <?php if ($rankOf($commandant)) : ?>
                            <span class="command-card__rank"><?= esc($rankOf($commandant)) ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if ($staff) : ?>
                        <div class="command-card__staff">
                            <span class="command-card__staff-label">État-major</span>
                            <ul>
                                <?php foreach ($staff as $member) : ?>
                                    <li>
                                        <?php if ($rankOf($member)) : ?>
                                            <span><?= esc($shortRankOf($rankOf($member))) ?></span>
                                        <?php endif; ?>
                                        <?= esc($member->username) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </article>
            <?php else : ?>
                <article class="command-card command-card--vacant">
                    <span class="command-card__label">Commandant</span>
                    <span class="command-card__name">Poste à pourvoir</span>
                </article>
            <?php endif; ?>
        </section>

        <?php if (!empty($poles)) : ?>
            <div class="metiers__divider"><span>Les métiers</span></div>

            <ul class="poles">
                <?php foreach ($poles as $pole) :
                    $chef    = $pole->officer ?: null;
                    $chefId  = $chef && isset($chef->user_id) ? $chef->user_id : null;
                    $members = array_values(array_filter(
                        $pole->members ?? [],
                        static fn ($m) => $chefId === null || !isset($m->user_id) || $m->user_id !== $chefId
                    ));
                    $count = count($members);
                    // Le chef de métier compte comme un membre du métier.
                    $headcount = $count + ($chef ? 1 : 0);
                ?>
                    <li class="pole">
                        <div class="pole__head">
                            <h2 class="pole__name"><?= esc($pole->label) ?></h2>
                            <span class="pole__count"><?= $headcount ?> membre<?= $headcount > 1 ? 's' : '' ?></span>
                        </div>

                        <?php if ($chef) : ?>
                            <div class="pole__chef">
                                <span class="avatar" data-initial="<?= esc($initialOf($chef)) ?>">
                                    <?php if ($rankOf($chef)) : ?>
                                        <img src="/pictures/jackets/<?= esc($rankOf($chef)) ?>.png" alt=""
                                            loading="lazy" onerror="this.remove()">
                                    <?php endif; ?>
                                </span>
                                <span class="pole__chef-info">
                                    <span class="pole__chef-role">Chef de métier</span>
                                    <span class="pole__chef-name"><?= esc($chef->username) ?></span>
                                    <?php if ($rankOf($chef)) : ?>
                                        <span class="pole__chef-rank"><?= esc($rankOf($chef)) ?></span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php else : ?>
                            <div class="pole__chef pole__chef--vacant">
                                <span class="pole__chef-info">
                                    <span class="pole__chef-role">Chef de métier</span>
                                    <span class="pole__chef-name">Poste à pourvoir</span>
                                    <span class="pole__chef-rank">Lancez-vous&nbsp;!</span>
                                </span>
                            </div>
                        <?php endif; ?>

                        <?php if ($count > 0) : ?>
                            <ul class="pole__members">
                                <?php foreach ($members as $member) : ?>
                                    <li class="pole__member">
                                        <span class="pole__member-name"><?= esc($member->username) ?></span>
                                        <?php if ($rankOf($member)) : ?>
                                            <span class="pole__member-rank"><?= esc($rankOf($member)) ?></span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p class="pole__empty">Aucun membre pour le moment.</p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</main>
