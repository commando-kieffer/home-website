<?php

function getTroopColor($name)
{
    if (stripos($name, 'TROOP 1') !== false) return '#1a237e';
    if (stripos($name, 'TROOP 8') !== false) return '#b71c1c';
    if (stripos($name, 'KG') !== false) return '#1b5e20';
    if (stripos($name, 'QG') !== false) return '#f57f17';
    return '#607d8b';
}

function generateMatricule($rank, $name, $troopName, $spec)
{
    // Association grade > grade tag
    $rankMap = [
        'Capitaine de corvette' => 'CptC',
        'Lieutenant de vaisseau' => 'Lv',
        'Enseigne de vaisseau de première classe' => 'Ev1',
        'Enseigne de vaisseau de seconde classe' => 'Ev2',
        'Aspirant' => 'Asp',
        'Major' => 'Maj',
        'Maître principal' => 'Mp',
        'Premier maître' => 'Pm',
        'Maitre' => 'Mtre',
        'Maître' => 'M',
        'Second maître de première classe' => 'Sm1',
        'Second maître de seconde classe' => 'Sm2',
        'Second maître maistrancier' => 'Smm',
        'Quartier-maître de première classe' => 'Qm1',
        'Quartier-maître de seconde classe' => 'Qm2',
        'Matelot breveté' => 'Mtb',
        'Matelot' => 'Mtl',
        'Cadet' => 'Cadet',
    ];
    $rTag = $rankMap[$rank] ?? substr($rank, 0, 3);

    // Format soldier name
    $formattedName = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
    $formattedName = str_replace(' ', '', $formattedName);

    // Association troop > troop tag
    $tTag = '';
    if (stripos($troopName, 'QG') !== false) $tTag = 'QG';
    elseif (stripos($troopName, 'KG') !== false) $tTag = 'KG';
    elseif (stripos($troopName, 'TROOP 1') !== false) $tTag = '1';
    elseif (stripos($troopName, 'TROOP 8') !== false) $tTag = '8';
    elseif (stripos($troopName, 'TROOP 2') !== false) $tTag = '2';
    elseif (stripos($troopName, 'TROOP 3') !== false) $tTag = '3';

    return ucfirst($rTag) . '.' . $formattedName . '.' . $tTag . $spec;
}

function getPlatforms($platformField)
{
    $platforms = [];
    if (stripos($platformField, 'PC') !== false) $platforms[] = 'PC';
    if (stripos($platformField, 'XBOX') !== false) $platforms[] = 'XBOX';
    if (stripos($platformField, 'PLAYSTATION') !== false || stripos($platformField, 'PS') !== false || stripos($platformField, 'Play') !== false) $platforms[] = 'PLAYSTATION';
    return implode(', ', $platforms);
}

function renderSoldierCard($user, $troopName, $showCadet = false)
{
    $speShort = $user['spe_short'];
    $speIconUrl = $user['spe_icon'] ?? '';
    $matricule = generateMatricule($user['user_title'], $user['username'], $user['troop_name'], $speShort);
    $fullName = $user['username'];
    $ign = $user['platform_username'] ?? 'Non renseigné';
    $platform = getPlatforms($user['platform'] ?? 'Non renseigné');
    $joinDate = 'Date inconnue';
    if (!empty($user['date'])) {
        $joinDate = (new DateTime($user['date']))->format('d/m/Y');
    }
    ob_start();
?>
    <div class="user-profile"
        onclick="openSoldierModal(this)"
        data-rank="<?= esc($user['user_title']); ?>"
        data-image="/pictures/jackets/<?= esc($user['user_title']); ?>.png"
        data-name="<?= esc($fullName); ?>"
        data-matricule="<?= esc($matricule); ?>"
        data-platform="<?= esc($platform); ?>"
        data-ign="<?= esc($ign); ?>"
        data-date="<?= esc($joinDate); ?>">

        <div class="user-info">
            <div class="jacket-wrapper">
                <img class="jacket" src="/pictures/jackets/<?= esc($user['user_title']); ?>.png" alt="Grade">
                <div class="rank-tooltip">
                    <img src="/pictures/jackets/<?= esc($user['user_title']); ?>.png" alt="">
                    <span class="rank-name"><?= esc($user['user_title']); ?></span>
                </div>
            </div>
            <span style="<?= $showCadet ? 'padding-left:0;' : '' ?>">
                <?= esc(ucwords(mb_strtolower($user['username']))); ?>
            </span>
        </div>

        <?php if (!$showCadet): ?>
            <div class="user-specialty"><?= esc(ucfirst(mb_strtolower($user['specialite']))); ?></div>
            <div class="user-specialty mobile"><?= esc($speShort); ?></div>

            <?php if (!empty($speIconUrl)): ?>
                <div class="specialty-icon"
                    style="
                        background-color: var(--unit-color, #607d8b);
                        -webkit-mask-image: url('<?= esc($speIconUrl); ?>');
                        mask-image: url('<?= esc($speIconUrl); ?>');
                     "
                    title="Icone de la spécialité <?= esc($user['specialite']); ?>">
                </div>
            <?php else: ?>
                <div class="specialty-icon" style="opacity:0.2"></div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
<?php
    return ob_get_clean();
}

?>

<main class="main-caserne">
    <h1>Caserne</h1>
    <section class="barracks-container">

        <?php if (!empty($barracks_data)) : ?>

            <?php foreach ($barracks_data as $troopName => $bordees) : ?>
                <?php
                $chef = null;
                foreach ($bordees as $bKey => &$users) {
                    foreach ($users as $i => $u) {
                        if (isset($u['is_chef']) && $u['is_chef']) {
                            $chef = $u;
                            unset($users[$i]);
                        }
                    }
                    $users = array_values($users);
                }
                unset($users);
                $color = getTroopColor($troopName);
                ?>

                <article class="troop-card" style="--unit-color: <?= $color; ?>;">
                    <header class="troop-header-caserne">
                        <h2><?= esc(ucwords(mb_strtolower($troopName))); ?></h2>
                    </header>

                    <?php if ($chef): ?>
                        <div class="troop-leader">
                            <h3>Chef de Troop</h3>
                            <div class="cmd-wrapper">
                                <?= str_replace('class="user-profile"', 'class="user-profile cmd"', renderSoldierCard($chef, $troopName)); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="members-grid">
                        <div class="bordee-column">
                            <h3>Bordée 1</h3>
                            <?php if (!empty($bordees['Bordée 1'])): ?>
                                <?php foreach ($bordees['Bordée 1'] as $user): ?>
                                    <?= renderSoldierCard($user, $troopName); ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="empty-msg">Aucun effectif assigné</div>
                            <?php endif; ?>
                        </div>

                        <div class="bordee-column">
                            <h3>Bordée 2</h3>
                            <?php if (!empty($bordees['Bordée 2'])): ?>
                                <?php foreach ($bordees['Bordée 2'] as $user): ?>
                                    <?= renderSoldierCard($user, $troopName); ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="empty-msg">Aucun effectif assigné</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>

            <?php if (!empty($cadets)) : ?>
                <article class="troop-card cadet-grid">
                    <header class="troop-header-caserne">
                        <h2>Cadets</h2>
                    </header>

                    <div class="members-grid">
                        <div class="bordee-column">
                            <h3>En formation</h3>

                            <div class="cadets-list">
                                <?php foreach ($cadets as $cadet): ?>
                                    <?= renderSoldierCard($cadet, 'Cadets', True); ?>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </article>
            <?php endif; ?>

        <?php else : ?>
            <p style="text-align:center; padding: 2rem; color: #78909c;">// AUCUNE DONNÉE MATRICULE DISPONIBLE //</p>
        <?php endif; ?>

    </section>

    <div id="soldierModalOverlay" class="modal-overlay" onclick="closeSoldierModal(event)">
        <div class="modal-dossier">
            <span class="close-btn" onclick="closeSoldierModal(event)">&times;</span>

            <div class="modal-body">
                <div class="col-visual">
                    <div class="jacket-frame">
                        <img id="modalJacket" src="" alt="Grade">
                    </div>
                    <h3 id="modalRank">GRADE</h3>
                </div>

                <div class="col-data">
                    <h2 id="modalName">NOM DU SOLDAT</h2>

                    <div class="data-row">
                        <span class="label">Matricule :</span>
                        <span class="value code-font" id="modalMatricule">...</span>
                    </div>

                    <div class="data-row">
                        <span class="label">Plateforme :</span>
                        <span class="value" id="modalPlatform">
                        </span>
                    </div>

                    <div class="data-row">
                        <span class="label">IGN :</span>
                        <span class="value" id="modalIgn">...</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <span class="label">Date d'incorporation :</span>
                <span class="value" id="modalDate">...</span>
            </div>
        </div>
    </div>

    <script>
        function openSoldierModal(element) {
            const data = element.dataset;

            document.getElementById('modalJacket').src = data.image;
            document.getElementById('modalRank').textContent = data.rank;
            document.getElementById('modalName').textContent = data.name;
            document.getElementById('modalMatricule').textContent = data.matricule;
            document.getElementById('modalIgn').textContent = data.ign;
            document.getElementById('modalDate').textContent = data.date;

            if (data.date === 'Date inconnue') {
              document.getElementById('modalDate').classList.add('redacted-text')
            } else {
              document.getElementById('modalDate').classList.remove('redacted-text')
            }

            const platformContainer = document.getElementById('modalPlatform');

            if (data.platform && data.platform !== 'Non renseigné') {
                let iconHtml = '';
                const platforms = data.platform.split(', ');
                let icons = [];

                platforms.forEach(platform => {
                    let p = platform.trim().toUpperCase();

                    if (p.includes('PC')) {
                        icons.push(`<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle; margin-right:5px"><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg> PC`);
                    }
                    if (p.includes('XBOX')) {
                        icons.push(
                            `<svg fill="#000000" width="24px" height="24px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 5.425c-1.888-1.125-4.106-1.922-6.473-2.249l-0.092-0.010c-0.070-0.005-0.152-0.008-0.234-0.008-0.613 0-1.188 0.16-1.687 0.441l0.017-0.009c2.357-1.634 5.277-2.61 8.426-2.61 0.008 0 0.016 0 0.024 0h0.019c0.005 0 0.011 0 0.018 0 3.157 0 6.086 0.976 8.501 2.642l-0.050-0.033c-0.478-0.272-1.051-0.433-1.662-0.433-0.085 0-0.169 0.003-0.252 0.009l0.011-0.001c-2.459 0.336-4.677 1.13-6.648 2.297l0.082-0.045zM5.554 5.268c-0.041 0.014-0.077 0.032-0.11 0.054l0.002-0.001c-2.758 2.723-4.466 6.504-4.466 10.684 0 3.584 1.256 6.875 3.353 9.457l-0.022-0.028c-1.754-3.261 4.48-12.455 7.61-16.159-3.53-3.521-5.277-4.062-6.015-4.062-0.010-0-0.021-0.001-0.032-0.001-0.115 0-0.225 0.021-0.326 0.060l0.006-0.002zM20.083 9.275c3.129 3.706 9.367 12.908 7.605 16.161 2.075-2.554 3.332-5.845 3.332-9.43 0-4.181-1.709-7.962-4.467-10.684l-0.002-0.002c-0.029-0.021-0.063-0.039-0.1-0.052l-0.003-0.001c-0.1-0.036-0.216-0.056-0.336-0.056-0.005 0-0.011 0-0.016 0h0.001c-0.741-0-2.485 0.543-6.014 4.063zM6.114 27.306c2.627 2.306 6.093 3.714 9.888 3.714s7.261-1.407 9.905-3.728l-0.017 0.015c2.349-2.393-5.402-10.901-9.89-14.29-4.483 3.39-12.24 11.897-9.886 14.29z"/>
                            </svg> XBOX`
                        );
                    }
                    if (p.includes('PLAYSTATION') || p.includes('PS')) {
                        icons.push(
                            `<svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px">
                            <path d="M0.69116 21.9548C-0.506476 22.7935 -0.284724 24.2384 2.44769 25.1419C5.18011 26.0455 8.35603 26.2323 11.1505 25.729C11.0707 25.729 11.3102 25.729 11.1505 25.729V22.8774L8.43588 23.8C7.39792 24.1355 6.35997 24.2194 5.32202 23.9677C4.5236 23.7161 4.68328 23.2129 5.64139 22.7935L11.1505 20.7806V17.6774L3.48565 20.4452C2.52754 20.7806 1.56943 21.2839 0.69116 21.9548ZM19.2146 9.37419V17.5097C22.4881 19.1871 25.0431 17.5097 25.0431 13.1484C25.0431 8.70323 23.5261 6.69032 19.1348 5.09677C16.8193 4.25806 14.4241 3.50323 12.0288 3V27.2387L17.6178 29V8.61935C17.6178 7.69677 17.6178 7.02581 18.2565 7.27742C19.1348 7.52903 19.2146 8.45161 19.2146 9.37419ZM29.5941 20.0258C27.2787 19.1871 24.8036 18.8516 22.4083 19.1032C21.0779 19.1906 19.8294 19.5869 18.5759 20.0258V23.2968L23.7656 21.2839C24.8036 20.9484 25.8415 20.8645 26.8795 21.1161C27.6779 21.3677 27.5182 21.871 26.5601 22.2903L18.5759 25.3935V28.5806L29.5941 24.3032C30.3925 23.9677 31.1111 23.5484 31.7499 22.8774C32.3088 22.0387 32.0692 20.8645 29.5941 20.0258Z" fill="#000000"/>
                        </svg> PLAYSTATION`
                        );
                    }
                });

                if (icons.length > 0) {
                    iconHtml = icons.join(' <span style="margin:0 10px; opacity:0.5">|</span> ');
                } else {
                    iconHtml = data.platform;
                }

                platformContainer.innerHTML = iconHtml;
            } else {
                platformContainer.innerHTML = '<span class="redacted-text">Non renseigné</span>';
            }

            document.getElementById('soldierModalOverlay').classList.add('active');
        }

        function closeSoldierModal(event) {
            if (event.target.classList.contains('modal-overlay') || event.target.classList.contains('close-btn')) {
                document.getElementById('soldierModalOverlay').classList.remove('active');
            }
        }
    </script>
</main>
