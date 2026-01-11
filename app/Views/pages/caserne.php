<?php

function getTroopColor($name)
{
    if (stripos($name, 'TROOP 1') !== false) return '#1a237e'; // Bleu Marine Profond
    if (stripos($name, 'TROOP 8') !== false) return '#b71c1c'; // Rouge Sang
    if (stripos($name, 'KG') !== false) return '#1b5e20'; // Vert Camo
    if (stripos($name, 'QG') !== false) return '#f57f17'; // Ocre Jaune
    return '#607d8b'; // Gris Bleu par défaut (Recrues/Réservistes)
}

function getSpecialtyTag($spec)
{
    // Par défaut : les 3 premières lettres
    $sTag = substr($spec, 0, 3);

    // Logique spécifique
    if (stripos($spec, 'Fusilier') !== false) $sTag = 'Fsl';
    elseif (stripos($spec, 'Assaut') !== false) $sTag = 'Ast';
    elseif (stripos($spec, 'Soutien') !== false) $sTag = 'Stn';
    elseif (stripos($spec, 'Sapeur') !== false) $sTag = 'Sap';
    elseif (stripos($spec, 'Infirmier') !== false) $sTag = 'Inf';
    elseif (stripos($spec, 'Voltigeur') !== false) $sTag = 'Vol';
    elseif (stripos($spec, 'Tireur de précision') !== false) $sTag = 'Tp';
    elseif (stripos($spec, "Tireur d'élite") !== false) $sTag = 'Snp';
    elseif (stripos($spec, "Officier Marinier") !== false) $sTag = 'Cmd';
    elseif (stripos($spec, "Officier") !== false) $sTag = 'Cmd';
    elseif (stripos($spec, "Commandement") !== false) $sTag = 'Cmd';

    return ucfirst($sTag);
}

function getSpecialtyIcon($specialty)
{
    $s = mb_strtolower($specialty);

    // 1. INFIRMIER
    if (strpos($s, 'infirmier') !== false) {
        return '<path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>';
    }

    // 2. SAPEUR / INGÉNIEUR
    if (strpos($s, 'sapeur') !== false) {
        return '<path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"></path>';
    }

    // 3. SOUTIEN
    if (strpos($s, 'soutien') !== false) {
        return '<path d="M9 4c0-1.11-.89-2-2-2S5 2.89 5 4v12H3v2h6v-2H7V4zm7 0c0-1.11-.89-2-2-2s-2 .89-2 2v12h-2v2h6v-2h-2V4zm7 0c0-1.11-.89-2-2-2s-2 .89-2 2v12h-2v2h6v-2h-2V4z"></path>';
    }

    // 4. VOLTIGEUR
    if (strpos($s, 'voltigeur') !== false) {
        return '<path d="M22 16l-5.6-3.2 2.8-5.2L11 8.9 7 2 2 2v2l2 4-2 6 2 2 4 4 2 2 4-4 2-2 4 4 2-2z"></path>';
    }

    // 5. ASSAUT
    if (strpos($s, 'assaut') !== false) {
        return '<path d="M7 2v11h3v9l7-12h-4l4-8z"></path>';
    }

    // 6. TIREUR D'ÉLITE / SNIPER
    if (strpos($s, "élite") !== false || strpos($s, "snp") !== false) {
        return '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v4h4v2h-4v4h-2v-4H7v-2h4V7z"></path><circle cx="12" cy="12" r="2"></circle>';
    }

    // 7. TIREUR DE PRÉCISION
    if (strpos($s, 'précision') !== false || strpos($s, 'tp') !== false) {
        return '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v4h4v2h-4v4h-2v-4H7v-2h4V7z"></path>';
    }

    // 8. COMMANDEMENT / OFFICIER
    if (strpos($s, 'officier') !== false || strpos($s, 'commandement') !== false || strpos($s, 'cmd') !== false) {
        return '<path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>';
    }

    // 9. FUSILIER (Défaut)
    return '<path d="M12 2C9.24 2 7 4.24 7 7v10c0 1.1.9 2 2 2v1c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1c1.1 0 2-.9 2-2V7c0-2.76-2.24-5-5-5zm3 15H9v-2h6v2zm0-4H9V7c0-1.66 1.34-3 3-3s3 1.34 3 3v6z"></path>';
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

    // Association troop > troop tag
    $tTag = 'UNK';
    if (stripos($troopName, 'QG') !== false) $tTag = 'QG';
    elseif (stripos($troopName, 'KG') !== false) $tTag = 'KG';
    elseif (stripos($troopName, 'TROOP 1') !== false) $tTag = '1';
    elseif (stripos($troopName, 'TROOP 8') !== false) $tTag = '8';
    elseif (stripos($troopName, 'TROOP 2') !== false) $tTag = '2';
    elseif (stripos($troopName, 'TROOP 3') !== false) $tTag = '3';

    // Association spécialitée > spécialité tag
    $sTag = getSpecialtyTag($spec);

    return ucfirst($rTag) . '.' . ucfirst(mb_strtolower($name)) . '.' . $tTag . ucfirst($sTag);
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
    $matricule = "En attente d'affectation";
    if (!$showCadet) {
        $matricule = generateMatricule($user['user_title'], $user['username'], $troopName, $user['specialite']);
    }
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
            <div class="user-specialty mobile"><?= esc(getSpecialtyTag($user['specialite'])); ?></div>

            <svg class="specialty-icon" viewBox="0 0 24 24">
                <?= getSpecialtyIcon($user['specialite']); ?>
            </svg>
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
                // Extraction du chef (logique identique à ton code)
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
            // 1. Récupération des données via les attributs data-
            const data = element.dataset;

            // 2. Remplissage des champs simples
            document.getElementById('modalJacket').src = data.image;
            document.getElementById('modalRank').textContent = data.rank;
            document.getElementById('modalName').textContent = data.name;
            document.getElementById('modalMatricule').textContent = data.matricule;
            document.getElementById('modalIgn').textContent = data.ign;
            document.getElementById('modalDate').textContent = data.date;

            // 3. Gestion Plateforme (Icones SVG)
            const platformContainer = document.getElementById('modalPlatform');

            if (data.platform && data.platform !== 'Non renseigné') {
                let iconHtml = '';
                // On sépare si plusieurs plateformes (ex: "PC, XBOX")
                const platforms = data.platform.split(', ');
                let icons = [];

                platforms.forEach(platform => {
                    // On nettoie la chaîne pour éviter les espaces parasites
                    let p = platform.trim().toUpperCase();

                    if (p.includes('PC')) {
                        icons.push(`<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle; margin-right:5px"><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg> PC`);
                    }
                    if (p.includes('XBOX')) {
                        icons.push(`<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle; margin-right:5px"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.36 12.83l-1.07-2.57-1.04 2.57h-4.5l-1.04-2.57-1.07 2.57H5.5l3.29-7.5h6.43l3.29 7.5h-2.15z"/></svg> XBOX`);
                    }
                    if (p.includes('PLAYSTATION') || p.includes('PS')) {
                        icons.push(`<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle; margin-right:5px"><path d="M8.5 12.5L12 16l3.5-3.5L12 9l-3.5 3.5zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg> PLAYSTATION`);
                    }
                });

                if (icons.length > 0) {
                    iconHtml = icons.join(' <span style="margin:0 10px; opacity:0.5">|</span> ');
                } else {
                    // Si on reconnait pas la plateforme, on affiche le texte brut
                    iconHtml = data.platform;
                }

                platformContainer.innerHTML = iconHtml;
            } else {
                platformContainer.innerHTML = 'Non renseigné';
            }

            // 4. Affichage de la modale
            document.getElementById('soldierModalOverlay').classList.add('active');
        }

        function closeSoldierModal(event) {
            // Ferme si on clique sur le bouton X ou sur le fond gris (overlay)
            if (event.target.classList.contains('modal-overlay') || event.target.classList.contains('close-btn')) {
                document.getElementById('soldierModalOverlay').classList.remove('active');
            }
        }
    </script>
</main>