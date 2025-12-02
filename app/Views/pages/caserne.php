<?php
// --- FONCTIONS UTILITAIRES ---

// Récupération de la couleur HEX selon le nom de la Troop (Palette Mat/Tactique)
function getTroopColor($name) {
    if (stripos($name, 'TROOP 1') !== false) return '#1a237e'; // Bleu Marine Profond
    if (stripos($name, 'TROOP 8') !== false) return '#b71c1c'; // Rouge Sang
    if (stripos($name, 'KG') !== false) return '#1b5e20'; // Vert Camo
    if (stripos($name, 'QG') !== false) return '#f57f17'; // Ocre Jaune
    return '#607d8b'; // Gris Bleu par défaut (Recrues/Réservistes)
}

function getSpecialtyTag($spec) {
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

// Récupération de l'icône SVG
function getSpecialtyIcon($specialty) {
    $s = mb_strtolower($specialty);

    // 1. INFIRMIER (La Croix)
    // Symbole universel de soin.
    if (strpos($s, 'infirmier') !== false) {
        return '<path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>';
    }

    // 2. SAPEUR / INGÉNIEUR (La Clé à molette)
    // Symbolise la réparation et le sabotage.
    if (strpos($s, 'sapeur') !== false) {
        return '<path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"></path>';
    }

    // 3. SOUTIEN (Munitions / 3 Balles)
    // Le rôle du soutien est souvent de fournir des munitions ou un tir de suppression.
    if (strpos($s, 'soutien') !== false) {
        return '<path d="M9 4c0-1.11-.89-2-2-2S5 2.89 5 4v12H3v2h6v-2H7V4zm7 0c0-1.11-.89-2-2-2s-2 .89-2 2v12h-2v2h6v-2h-2V4zm7 0c0-1.11-.89-2-2-2s-2 .89-2 2v12h-2v2h6v-2h-2V4z"></path>';
    }

    // 4. VOLTIGEUR (L'Aile)
    // Symbolise la mobilité, l'infanterie légère et rapide.
    if (strpos($s, 'voltigeur') !== false) {
        return '<path d="M22 16l-5.6-3.2 2.8-5.2L11 8.9 7 2 2 2v2l2 4-2 6 2 2 4 4 2 2 4-4 2-2 4 4 2-2z"></path>';
    }

    // 5. ASSAUT (L'Éclair)
    // Symbolise l'action de choc, la vitesse et l'attaque frontale.
    if (strpos($s, 'assaut') !== false) {
        return '<path d="M7 2v11h3v9l7-12h-4l4-8z"></path>';
    }

    // 6. TIREUR D'ÉLITE / SNIPER (Viseur de précision)
    // Une cible avec un point central pour la précision chirurgicale.
    if (strpos($s, "élite") !== false || strpos($s, "snp") !== false) {
        return '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v4h4v2h-4v4h-2v-4H7v-2h4V7z"></path><circle cx="12" cy="12" r="2"></circle>';
    }

    // 7. TIREUR DE PRÉCISION (Réticule simple)
    // Similaire au sniper mais moins "zoomé", un réticule ouvert.
    if (strpos($s, 'précision') !== false || strpos($s, 'tp') !== false) {
        return '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v4h4v2h-4v4h-2v-4H7v-2h4V7z"></path>';
    }

    // 8. COMMANDEMENT / OFFICIER (L'Étoile)
    // Symbole de leadership.
    if (strpos($s, 'officier') !== false || strpos($s, 'commandement') !== false || strpos($s, 'cmd') !== false) {
        return '<path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>';
    }

    // 9. FUSILIER (Défaut - Fusil d'assaut)
    // L'icône de base pour le soldat standard.
    // (Note : Si aucun cas au-dessus ne matche, on retourne celle-ci)
    return '<path d="M12 2C9.24 2 7 4.24 7 7v10c0 1.1.9 2 2 2v1c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1c1.1 0 2-.9 2-2V7c0-2.76-2.24-5-5-5zm3 15H9v-2h6v2zm0-4H9V7c0-1.66 1.34-3 3-3s3 1.34 3 3v6z"></path>';

}

function generateMatricule($rank, $name, $troopName, $spec) {
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
        'Maitre' => 'Mtre', 'Maître' => 'M',
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
?>

<main class="main-caserne">
    <h1>Caserne</h1>
    <section class="barracks-container">
        <?php if (!empty($barracks_data)) : ?>
            <?php foreach ($barracks_data as $troopName => $bordees) : ?>
                <?php
                    // Logique d'extraction du chef
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

                    // Définir la couleur tactique de l'unité
                    $color = getTroopColor($troopName);
                ?>

                <article class="troop-card" style="--unit-color: <?= $color; ?>;">
                    
                    <header class="troop-header-caserne">
                        <h2><?= esc(ucwords(mb_strtolower($troopName))); ?></h2>
                    </header>

                    <?php if ($chef): ?>
                        <?php
                                // Préparation des données pour la modale
                                $matricule = generateMatricule($chef['user_title'], $chef['username'], $troopName, $chef['specialite']);
                                // Données factices pour l'exemple (à remplacer par vos vraies données DB si dispos)
                                $fullName = $chef['username'] . " Paul"; 
                                $ign = $chef['username'] . "_BF2042";
                                $platform = ($i % 2 == 0) ? 'PC' : 'XBOX'; // Alternance pour l'exemple
                                $joinDate = date("d/m/Y", strtotime("-".rand(1, 500)." days")); // Date aléatoir
                            ?>
                    <div class="troop-leader">
                        <h3>Chef de Troop</h3>
                        <div class="user-profile cmd"
                            onclick="openSoldierModal(this)"
                            data-rank="<?= esc($chef['user_title']); ?>"
                            data-image="/pictures/jackets/<?= esc($chef['user_title']); ?>.png"
                            data-name="<?= esc($fullName); ?>"
                            data-matricule="<?= esc($matricule); ?>"
                            data-platform="<?= esc($platform); ?>"
                            data-ign="<?= esc($ign); ?>"
                            data-date="<?= esc($joinDate); ?>"
                        >
                            
                            <div class="user-info">
                                <div class="jacket-wrapper">
                                    <img class="jacket" src="/pictures/jackets/<?= esc($chef['user_title']); ?>.png" alt="<?= esc($chef['user_title']); ?>">
                                    
                                    <div class="rank-tooltip">
                                        <img src="/pictures/jackets/<?= esc($chef['user_title']); ?>.png" alt="">
                                        <span class="rank-name"><?= esc($chef['user_title']); ?></span>
                                    </div>
                                </div>
                                <span><?= esc(ucwords(mb_strtolower($chef['username']))); ?></span>
                            </div>
                            <div class="user-specialty"><?= esc(ucfirst(mb_strtolower($chef['specialite'] ?? 'Commandement'))); ?></div>
                            <div class="user-specialty mobile"><?= esc(getSpecialtyTag($chef['specialite'] ?? 'Commandement')); ?></div>
                            <svg class="specialty-icon" viewBox="0 0 24 24">
                                <?= getSpecialtyIcon($chef['specialite'] ?? 'Commandement'); ?>
                            </svg>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="members-grid">
                        
                        <div class="bordee-column">
                            <h3>Bordée 1</h3>
                            <?php if (!empty($bordees['Bordée 1'])): ?>
                                <?php foreach ($bordees['Bordée 1'] as $user): ?>
                                    <?php
                                        // Préparation des données pour la modale
                                        $matricule = generateMatricule($user['user_title'], $user['username'], $troopName, $user['specialite']);
                                        // Données factices pour l'exemple (à remplacer par vos vraies données DB si dispos)
                                        $fullName = $user['username'] . " Paul"; 
                                        $ign = $user['username'] . "_BF2042";
                                        $platform = ($i % 2 == 0) ? 'PC' : 'XBOX'; // Alternance pour l'exemple
                                        $joinDate = date("d/m/Y", strtotime("-".rand(1, 500)." days")); // Date aléatoire

                                    ?>
                                    <div class="user-profile" 
                                        onclick="openSoldierModal(this)"
                                        data-rank="<?= esc($user['user_title']); ?>"
                                        data-image="/pictures/jackets/<?= esc($user['user_title']); ?>.png"
                                        data-name="<?= esc($fullName); ?>"
                                        data-matricule="<?= esc($matricule); ?>"
                                        data-platform="<?= esc($platform); ?>"
                                        data-ign="<?= esc($ign); ?>"
                                        data-date="<?= esc($joinDate); ?>"
                                    >
                                        <div class="user-info">
                                            <div class="jacket-wrapper">
                                                <img class="jacket" src="/pictures/jackets/<?= esc($user['user_title']); ?>.png" alt="Grade">
                                                <div class="rank-tooltip">
                                                    <img src="/pictures/jackets/<?= esc($user['user_title']); ?>.png" alt="">
                                                    <span class="rank-name"><?= esc($user['user_title']); ?></span>
                                                </div>
                                            </div>
                                            <span><?= esc(ucwords(mb_strtolower($user['username']))); ?></span>
                                        </div>
                                        <div class="user-specialty"><?= esc(ucfirst(mb_strtolower($user['specialite']))); ?></div>
                                        <div class="user-specialty mobile"><?= esc(getSpecialtyTag($user['specialite'])); ?></div>
                                        <svg class="specialty-icon" viewBox="0 0 24 24">
                                            <?= getSpecialtyIcon($user['specialite']); ?>
                                        </svg>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="empty-msg">Aucun effectif assigné</div>
                            <?php endif; ?>
                        </div>

                        <div class="bordee-column">
                            <h3>Bordée 2</h3>
                            <?php if (!empty($bordees['Bordée 2'])): ?>
                                <?php foreach ($bordees['Bordée 2'] as $user): ?>
                                    <?php
                                        // Préparation des données pour la modale
                                        $matricule = generateMatricule($user['user_title'], $user['username'], $troopName, $user['specialite']);
                                        // Données factices pour l'exemple (à remplacer par vos vraies données DB si dispos)
                                        $fullName = $user['username'] . " Paul"; 
                                        $ign = $user['username'] . "_BF2042";
                                        $platform = ($i % 2 == 0) ? 'PC' : 'XBOX'; // Alternance pour l'exemple
                                        $joinDate = date("d/m/Y", strtotime("-".rand(1, 500)." days")); // Date aléatoire

                                    ?>
                                    <div class="user-profile" 
                                        onclick="openSoldierModal(this)"
                                        data-rank="<?= esc($user['user_title']); ?>"
                                        data-image="/pictures/jackets/<?= esc($user['user_title']); ?>.png"
                                        data-name="<?= esc($fullName); ?>"
                                        data-matricule="<?= esc($matricule); ?>"
                                        data-platform="<?= esc($platform); ?>"
                                        data-ign="<?= esc($ign); ?>"
                                        data-date="<?= esc($joinDate); ?>"
                                    >
                                        <div class="user-info">
                                            <div class="jacket-wrapper">
                                                <img class="jacket" src="/pictures/jackets/<?= esc($user['user_title']); ?>.png" alt="Grade">
                                                <div class="rank-tooltip">
                                                    <img src="/pictures/jackets/<?= esc($user['user_title']); ?>.png" alt="">
                                                    <span class="rank-name"><?= esc($user['user_title']); ?></span>
                                                </div>
                                            </div>
                                            <span><?= esc(ucwords(mb_strtolower($user['username']))); ?></span>
                                        </div>
                                        <div class="user-specialty"><?= esc(ucfirst(mb_strtolower($user['specialite']))); ?></div>
                                        <div class="user-specialty mobile"><?= esc(getSpecialtyTag($user['specialite'])); ?></div>
                                        <svg class="specialty-icon" viewBox="0 0 24 24">
                                            <?= getSpecialtyIcon($user['specialite']); ?>
                                        </svg>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="empty-msg">Aucun effectif assigné</div>
                            <?php endif; ?>
                        </div>

                    </div> </article>
            <?php endforeach; ?>
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
                    <span class="label">IGN (BF6) :</span>
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
    // Récupération des données via les attributs data-
    const data = element.dataset;
    
    // Remplissage des champs
    document.getElementById('modalJacket').src = data.image;
    document.getElementById('modalRank').textContent = data.rank;
    document.getElementById('modalName').textContent = data.name;
    document.getElementById('modalMatricule').textContent = data.matricule;
    document.getElementById('modalIgn').textContent = data.ign;
    document.getElementById('modalDate').textContent = data.date;

    // Gestion Plateforme (Icones SVG simples)
    const platformContainer = document.getElementById('modalPlatform');
    let iconHtml = '<span style="font-style:italic; opacity:0.7;">Fonctionnalité à venir</span>';
    
    if(data.platform === 'PC') {
        iconHtml = `<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg> PC`;
    } else if (data.platform === 'XBOX') {
        iconHtml = `<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.36 12.83l-1.07-2.57-1.04 2.57h-4.5l-1.04-2.57-1.07 2.57H5.5l3.29-7.5h6.43l3.29 7.5h-2.15z"/></svg> XBOX`;
    }
    platformContainer.innerHTML = iconHtml;

    // Affichage
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