<?php

/**
 * Catalogue des mods Arma Reforger et outils du Commando, dans l'ordre d'affichage.
 * Lu par App\Models\ModModel, qui complète les champs absents.
 *
 * Champs :
 *  - name, category, icon (id du sprite pictures/mods/icons.svg), tagline (carte), summary (paragraphes)
 *  - group        : 'mods' (défaut) ou 'server' (outil hors Workshop)
 *  - workshop_id  : GUID Workshop ; repo_url : dépôt GitHub (pour un outil hors Workshop)
 *  - stats        : [[valeur, libellé], ...]
 *  - features     : [['title' => ..., 'text' => ...], ...]
 *  - content      : [['title' => ..., 'note' => ..., 'items' => [...]], ...]
 *  - standalone   : [['name', 'workshop_id', 'author', 'tagline', 'points' => [...]], ...] mods indépendants de la même gamme
 *  - requires     : [['name' => ..., 'slug' | 'url' => ...], ...]
 *  - facts        : [[libellé, valeur], ...] (fiche latérale)
 *  - credits      : [['asset' => ..., 'author' => ..., 'license' => ...], ...]
 *  - shots        : [['file' => 'slug-1', 'alt' => ..., 'pos' => object-position CSS], ...]
 *                   (fichiers public/pictures/mods/<file>.jpg et <file>-sm.jpg ; le premier sert de couverture)
 *  - cover        : même forme qu'un shot, pour une couverture hors galerie
 *  - install      : ['label' => ..., 'code' => ...] (défaut : entrée "game.mods" pour un mod)
 */

return [
    'core' => [
        'name'        => 'CK Core',
        'category'    => 'Système',
        'icon'        => 'core',
        'workshop_id' => '6A9E08A3BF66AFF4',
        'tagline'     => 'Faction France, menu CK, loadouts, troops et redéploiement entre bases : le socle du Commando.',
        'shots'       => [
            ['file' => 'core-1', 'alt' => 'Le menu CK, onglet Troop'],
            ['file' => 'core-2', 'alt' => 'La carte de redéploiement du STTRIB'],
        ],
        'summary'     => [
            'CK Core regroupe ce dont les autres mods et nos serveurs ont besoin : un menu en jeu, des loadouts sauvegardables, un système de troops calqué sur notre hiérarchie, des arsenaux ouverts à toutes les factions et la faction France.',
            'Les joueurs l’utilisent depuis le menu CK (F5). Les Game Masters et les créateurs de mission disposent en plus de prefabs et de réglages dédiés.',
        ],
        'stats'       => [
            ['24', 'scripts'],
        ],
        'features'    => [
            ['title' => 'Menu CK', 'text' => 'S’ouvre avec F5 ou Vue + RB à la manette, la touche se change dans les options. Cinq onglets : Info, Identité, Arsenal, Troop et Briefing, navigables au clavier et à la manette.'],
            ['title' => 'Pseudo et identité', 'text' => 'Un surnom affiché au-dessus de la tête, dans le chat, la liste des joueurs, la carte et Game Master, avec filtre de grossièretés. Une fiche (naissance, lieu, groupe sanguin, bio) visible dans l’inventaire.'],
            ['title' => 'Loadouts', 'text' => 'Cinq emplacements à renommer, supprimer, exporter et importer sous forme de code. Le chargement se fait près d’un arsenal, avec un délai. Un loadout de réapparition se choisit au déploiement.'],
            ['title' => 'Troops et groupes', 'text' => 'Une troop compte deux bordées, chacune avec sa fréquence radio aléatoire. Dix couleurs, groupes ouverts à tous et jusqu’à 40 groupes par faction.'],
            ['title' => 'Arsenaux multi-factions', 'text' => 'Chaque arsenal propose les objets de toutes les factions, y compris celles des mods chargés. L’URSS est exclue.'],
            ['title' => 'STTRIB', 'text' => 'Poste de redéploiement placé par le Game Master. Depuis la carte, les joueurs se téléportent vers un autre STTRIB, avec un fondu et un bruit de moteur.'],
            ['title' => 'Faction France', 'text' => 'La faction US devient « France », avec drapeaux tricolores et icônes dédiés, y compris dans le filtre de Game Master.'],
            ['title' => 'Vue à la première personne', 'text' => 'Réglage Game Master : première personne forcée au combat, troisième personne rendue après 30 s de calme. Conducteurs, pilotes et équipages de blindés sont exemptés.'],
            ['title' => 'Outils de mission', 'text' => 'Écran d’introduction (logo, titre, lieu, date, musique), briefing mis en forme depuis un fichier de config, loadouts partagés et troops préconfigurées.'],
            ['title' => 'Tuile du menu principal', 'text' => 'Un bouton « Rejoindre le serveur du CK » dans le menu principal du jeu.'],
        ],
        'content'     => [
            [
                'title' => 'Prefabs pour créateurs de mission',
                'items' => ['CK_MissionIntro', 'CK_MissionSettings', 'CK_Troops', 'CK_STTRIB'],
            ],
        ],
    ],

    'props' => [
        'name'        => 'CK Props',
        'category'    => 'Props',
        'icon'        => 'props',
        'workshop_id' => '6A8CDBAAAC085EFF',
        'tagline'     => 'Drapeaux du CK, flèches au sol, décors de briefing et de jour J, tables de chronométrage.',
        'cover'       => ['file' => 'props-cover', 'alt' => 'Le drapeau du CK dans le vent'],
        'summary'     => [
            'Des objets à poser en Game Master ou dans Workbench : les drapeaux et écussons du Commando et de ses troops, des flèches peintes au sol pour guider un parcours, des décors de briefing et deux tables pour chronométrer un exercice.',
            'Ce mod ne dépend pas de CK Core.',
        ],
        'stats'       => [
            ['131', 'objets Game Master'],
        ],
        'features'    => [
            ['title' => 'Drapeaux', 'text' => '14 motifs en 5 formes : deux mâts, un drapeau décoratif sur pied, et des drapeaux 1:2 et 2:3. Sur les mâts, le drapeau CK reste en place au lieu de prendre celui de la faction propriétaire dans une base Conflict.'],
            ['title' => 'Flèches au sol', 'text' => 'Quatre formes en quatre couleurs et trois tailles (0,5, 1 et 1,5 m), posées comme des décals.'],
            ['title' => 'Tables de chronométrage', 'text' => 'La table Départ lance un compte à rebours 3-2-1 et un coup de pistolet. La table Arrivée envoie le résultat, en popup et dans le chat, aux joueurs proches (300 m par défaut). Les deux se jumellent par clé et fonctionnent en multijoueur.'],
            ['title' => 'Décors de briefing et de jour J', 'text' => 'Carte du Débarquement en Normandie, carte murale vierge, manuel de terrain, bureau, lampe, bombe d’aviation inerte, casque allemand, estrade et plaque du CK.'],
            ['title' => 'Monde de démonstration', 'text' => 'Un monde de test, CK_Props_Showcase, présente les objets pour les créateurs de mission.'],
        ],
        'content'     => [
            [
                'title' => 'Motifs de drapeau',
                'items' => [
                    'CK 2004', 'CK Bis', 'CK France',
                    'Troop 1', 'Troop 1 – Wyverne', 'Troop 1 – Phoenix',
                    'Troop 8', 'Troop 8 – Drakkar', 'Troop 8 – Léviathan',
                    'Troop K-Gun', 'Troop K-Gun – Char', 'Troop K-Gun – Infanterie',
                    'QG – Commandement', 'QG – Game Master (Zeus)',
                ],
            ],
            [
                'title' => 'Formes de drapeau',
                'items' => ['Mât A', 'Mât B', 'Drapeau décoratif sur pied', 'Drapeau 1:2', 'Drapeau 2:3'],
            ],
            [
                'title' => 'Flèches au sol',
                'items' => ['Droite', 'Virage à gauche', 'Virage à droite', 'Demi-tour'],
            ],
            [
                'title' => 'Autres props',
                'items' => [
                    'Table de chrono (Départ)', 'Table de chrono (Arrivée)',
                    'Carte du Débarquement en Normandie', 'Carte murale vierge', 'Manuel de terrain',
                    'Vieux bureau en bois', 'Vieille lampe de bureau',
                    'Casque d’acier allemand', 'Bombe d’aviation (inerte)',
                    'Estrade en bois', 'Estrade avec plaque CK', 'Plaque insigne du Commando Kieffer',
                ],
            ],
        ],
        'facts'       => [
            ['Contributeurs', 'MrPixel67, Noks - Ohliger'],
        ],
        'credits'     => [
            ['asset' => 'Military aviabomb', 'author' => 'radioape', 'license' => 'CC BY 4.0'],
        ],
    ],

    'structures' => [
        'name'        => 'CK Structures',
        'category'    => 'Structures',
        'icon'        => 'structures',
        'workshop_id' => '6AA514EDBA6B2C30',
        'tagline'     => 'Château d’Achnacarry, ambassade, maisons, immeuble, bureaux et dépôt de véhicules.',
        'summary'     => [
            'Onze bâtiments à placer dans Workbench, dont une reconstitution du château d’Achnacarry, où les commandos ont été formés. Les autres sont modernes : une ambassade, cinq maisons, un immeuble, un bureau et un dépôt de véhicules.',
            'Les bâtiments ne sont pas des entités Game Master : on les place dans Workbench. Un scénario Game Master d’essai en pose un exemplaire de chacun sur Arland. Ce mod ne dépend ni de CK Core ni de CK Props.',
        ],
        'stats'       => [
            ['11', 'bâtiments'],
            ['87', 'prefabs'],
        ],
        'shots'       => [
            ['file' => 'structures-1', 'alt' => 'L’ambassade vue du dessus, avec ses deux postes de garde'],
            ['file' => 'structures-2', 'alt' => 'La façade de l’ambassade'],
            ['file' => 'structures-3', 'alt' => 'L’immeuble et les maisons modernes en bord de mer'],
            ['file' => 'structures-4', 'alt' => 'Le dépôt de véhicules et ses deux hélisurfaces'],
            ['file' => 'structures-5', 'alt' => 'L’intérieur d’un appartement moderne'],
            ['file' => 'structures-6', 'alt' => 'Les murs en contreplaqué dans Workbench'],
        ],
        'features'    => [
            ['title' => 'Château d’Achnacarry', 'text' => 'Le château avec ses portes et ses fenêtres posées une à une : dix types de portes et dix-sept types de fenêtres, ces dernières existant aussi en version à vitres brisées.'],
            ['title' => 'Ambassade', 'text' => 'Un bâtiment néoclassique en U, avec dôme et portique, et son poste de garde.'],
            ['title' => 'Bâtiments modernes', 'text' => 'Cinq maisons, un immeuble de quatre étages et un bureau de trois étages avec parking souterrain.'],
            ['title' => 'Dépôt de véhicules', 'text' => 'Un hangar avec six baies et deux hélisurfaces. Un menu avec filtres et recherche fait apparaître un véhicule du catalogue de la faction du joueur, et un onglet permet de le rendre. Hélicoptères et avions utilisent les hélisurfaces, le reste les baies.'],
            ['title' => 'Portes vitrées coulissantes', 'text' => 'Un jeu de sons dédié pour les portes vitrées coulissantes des bâtiments modernes.'],
        ],
        'content'     => [
            [
                'title' => 'Bâtiments',
                'items' => [
                    'Château d’Achnacarry', 'Ambassade', 'Poste de garde',
                    'Maison moderne 01', 'Maison moderne 02', 'Maison moderne 03', 'Maison moderne 04', 'Maison moderne 05',
                    'Immeuble moderne', 'Bureau moderne', 'Dépôt de véhicules',
                ],
            ],
            [
                'title' => 'Variantes du dépôt',
                'items' => ['Meublé', 'Bureau', 'Plate-forme', 'Hélisurface'],
            ],
            [
                'title' => 'Murs en contreplaqué',
                'items' => ['Base', 'Accroupi', 'Cadre de porte', 'Ventre', 'Enjambement', 'Fenêtre'],
            ],
        ],
    ],

    'vehicles' => [
        'name'        => 'CK Vehicles',
        'category'    => 'Véhicules',
        'icon'        => 'vehicles',
        'workshop_id' => '6A9751849C60B09F',
        'tagline'     => 'La jeep G503 et le VLFS, plus l’AMX-10, le CB90 et le CRAB en mods indépendants.',
        'summary'     => [
            'Deux véhicules à roues aux couleurs du Commando : la jeep G503, un 4×4 d’esprit Willys MB, et le VLFS, un véhicule léger des forces spéciales françaises. Les cinq versions sont ajoutées au catalogue de la faction US, donc à celui de la faction France de CK Core.',
            'Ce mod ne dépend ni de CK Core ni d’un autre mod du Commando. La gamme compte aussi l’AMX-10, le CB90 et le CRAB, réalisés par Ev2.Poli : chacun est un mod indépendant, présenté plus bas.',
        ],
        'stats'       => [
            ['5', 'véhicules dans ce mod'],
            ['3', 'véhicules en mods indépendants'],
        ],
        'shots'       => [
            ['file' => 'vehicles-2', 'alt' => 'La jeep G503 sur une pente rocheuse', 'pos' => '85% 70%'],
            ['file' => 'vehicles-1', 'alt' => 'L’arrière du VLFS, portières et hayon ouverts, avec ses banquettes'],
        ],
        'features'    => [
            ['title' => 'G503', 'text' => 'Boîte manuelle avec levier en H animé et bouton de démarrage au plancher, pare-brise rabattable, rétroviseur gauche et roue de secours. Capot marqué « FR » avec la croix de Lorraine, plaque « NORMANDIE ».'],
            ['title' => 'G503 armée', 'text' => 'La version M2 remplace la banquette arrière par un servant de M2HB sur son affût : débattement de ±60° et site de −15° à +40°. Elle compte trois places.'],
            ['title' => 'VLFS', 'text' => 'Cinq portières et hayons animés, dont l’état est répliqué en multijoueur. Pare-brise rabattable, deux porte-jerrycans qui s’ouvrent comme coffre, extincteur, sélecteur de vitesse et frein à main animés.'],
            ['title' => 'Trois versions du VLFS', 'text' => 'Standard (7 places), transport (12 places) et ravitaillement (3 places, quatre caisses et une radio). Le copilote sert une M60.'],
            ['title' => 'Vue rétroviseur', 'text' => 'Depuis la place du conducteur, on bascule sur la caméra du rétroviseur gauche, et la touche F permet d’en sortir.'],
        ],
        'standalone'  => [
            [
                'name'        => 'AMX-10 RCR SEPAR',
                'workshop_id' => 'F817CB4F29EA6483',
                'author'      => 'Ev2.Poli',
                'tagline'     => 'Un engin blindé à roues de reconnaissance, avec un canon de 105 mm et la conduite de tir SEPAR.',
                'points'      => [
                    'Quatre postes : conducteur, tireur, chef de char et chargeur.',
                    'Conduite de tir SEPAR : télémètre laser, stabilisation, poursuite de cible et zoom.',
                    'Vision de jour, de nuit et thermique.',
                    'Canon de 105 mm (APFSDS, HEAT, explosif), mitrailleuse coaxiale et tourelleau télécommandé de 12,7 mm pour le chef.',
                    'Trappes animées, équipage protégé quand elles sont fermées, réarmement aux camions et dépôts de munitions.',
                    'Encore en développement : des bugs sont possibles.',
                ],
            ],
            [
                'name'        => 'Combat Boat 90 (CB90)',
                'workshop_id' => 'F06B8471D28E73C3',
                'author'      => 'Ev2.Poli',
                'tagline'     => 'Une embarcation de combat avec conduite de tir thermique et un intérieur où l’on peut se déplacer.',
                'points'      => [
                    'Canon MPA de 30 mm : télémètre laser, correction balistique, stabilisation, poursuite de cible et zoom de ×1 à ×20.',
                    'Vision de jour, de nuit et thermique.',
                    'Timonerie, compartiment passagers et pont praticables, avec une rampe d’étrave pour les débarquements.',
                    '20 places : pilote, tireur ou navigateur, et 18 passagers. Jusqu’à 80 km/h.',
                    'Deux modèles, le CB90 armé et le CB90 Naval sans arme avec radar animé, en 16 variantes dont une livrée française.',
                ],
            ],
            [
                'name'        => 'CRAB Commando Kieffer',
                'workshop_id' => '6A8D0DD2CC90238E',
                'author'      => 'Ev2.Poli',
                'tagline'     => 'Un véhicule de reconnaissance amphibie : une coque de BRDM-2 portant la tourelle d’un LAV-25.',
                'points'      => [
                    'Canon de 25 mm avec un zoom de ×1 à ×12.',
                    'Livrées MERDC et « Terre de France ».',
                ],
            ],
        ],
        'content'     => [
            [
                'title' => 'Véhicules',
                'items' => [
                    'G503 ¼ tonne 4×4 – 4 places',
                    'G503 ¼ tonne 4×4 (M2) – 3 places',
                    'VLFS – 7 places',
                    'VLFS (transport) – 12 places',
                    'VLFS (ravitaillement) – 3 places',
                ],
            ],
        ],
    ],

    'animations' => [
        'name'        => 'CK Animations',
        'category'    => 'Animations',
        'icon'        => 'animations',
        'workshop_id' => '6A9D589BBA8CDD8B',
        'tagline'     => 'Salut militaire, garde-à-vous et repos, dans le menu d’emotes et pour les IA.',
        'shots'       => [
            ['file' => 'animations-1', 'alt' => 'Un soldat qui fait le salut militaire', 'pos' => '50% 22%'],
        ],
        'summary'     => [
            'Ajoute une catégorie « CK » au menu d’emotes du jeu avec trois poses continues : le salut militaire français, le garde-à-vous et le repos. Les Game Masters peuvent aussi les faire jouer à des soldats IA.',
            'Aucun graphe d’animation du jeu n’est modifié. Les poses passent par un graphe séparé, et ce mod ne dépend que du jeu de base.',
        ],
        'stats'       => [
            ['3', 'emotes'],
            ['4', 'actions Game Master'],
        ],
        'features'    => [
            ['title' => 'Salut', 'text' => 'Le salut militaire français.'],
            ['title' => 'Garde-à-vous', 'text' => 'Position d’attente au garde-à-vous.'],
            ['title' => 'Repos', 'text' => 'Les mains derrière le dos.'],
            ['title' => 'Annulation', 'text' => 'Tirer, sprinter, sauter, lever, viser ou recharger l’arme interrompt la pose. Les touches de déplacement n’interrompent que le salut. Les poses se jouent debout.'],
            ['title' => 'Actions Game Master', 'text' => '« CK - Salut », « CK - Garde à vous », « CK - Repos » et « CK - Arrêter l’animation », appliquées aux soldats ou groupes IA sélectionnés. Les IA reprennent leur comportement dès qu’elles sont menacées.'],
        ],
    ],

    'weapons' => [
        'name'        => 'CK Weapons',
        'category'    => 'Armes',
        'icon'        => 'weapons',
        'workshop_id' => '6AA54374BFF59CB0',
        'tagline'     => '20 armes avec leurs chargeurs, accessoires et animations, du FAMAS au L115A3.',
        'shots'       => [
            ['file' => 'weapons-1', 'alt' => 'Deux fusils et leurs chargeurs sur une table du monde de test'],
            ['file' => 'weapons-2', 'alt' => 'Deux fusils M16 sur une table du monde de test'],
        ],
        'summary'     => [
            'Seize familles d’armes à feu, avec leurs chargeurs, leurs accessoires, leurs munitions, leurs animations de personnage et leurs sons. Chaque arme a son propre modèle et son propre jeu d’animations.',
            'Le catalogue est ajouté à la faction US, donc aux arsenaux de la faction France de CK Core. Un monde de test Game Master présente toutes les armes et tous les chargeurs sur des tables.',
        ],
        'stats'       => [
            ['20', 'armes'],
            ['26', 'accessoires'],
            ['18', 'chargeurs et munitions'],
            ['483', 'animations'],
        ],
        'features'    => [
            ['title' => 'Modes de tir propres à chaque arme', 'text' => 'Sélecteurs et animations dédiés : FAMAS (sûr, coup par coup, rafale de 3), MP5 à quatre positions, SIG 552 avec rafale.'],
            ['title' => 'Culasse et pompe', 'text' => 'L115A3 et Hekate à verrou, M3 à pompe avec rechargement cartouche par cartouche. La chevrotine envoie neuf plombs.'],
            ['title' => 'Munitions', 'text' => 'Le .300 BLK (subsonique et supersonique), le .338 Lapua Magnum, le .45 ACP et le calibre 12 ont leurs propres projectiles. La vitesse initiale dépend de la longueur du canon.'],
            ['title' => 'Laser et lampe', 'text' => 'Ctrl+L pour le laser, Ctrl+K pour la lampe, avec un état synchronisé en multijoueur.'],
            ['title' => 'Pièces mobiles', 'text' => 'Hausse de la poignée de transport du M16, tambour de visée du FAMAS, hausses relevables du Type 20, bague de zoom des lunettes et bipieds.'],
            ['title' => 'Règles d’accessoires', 'text' => 'La poignée de transport et les optiques sur rail s’excluent, et certaines optiques exigent la poignée.'],
            ['title' => 'Chargeurs séparés', 'text' => 'Douze types de chargeurs : ceux des différentes armes ne se mélangent pas.'],
            ['title' => 'Animations de personnage', 'text' => 'Prises en main, rechargements, armement de la culasse et animations d’inspection sur mesure.'],
        ],
        'content'     => [
            [
                'title' => 'Fusils d’assaut',
                'items' => ['M16A4', 'M16A3', 'M16A4 M203', 'M16A3 M203', 'Fass 04', 'Type 20', 'FAMAS G2', 'FAMAS G2 (Tan)', 'Aug 3', 'Bren 2 (5.56)'],
            ],
            [
                'title' => 'PDW et pistolets-mitrailleurs',
                'items' => ['Money Badger (.300 BLK)', 'MP5A2 (9x19)', 'MP9 (9x19)', 'UMP45 (.45 ACP)'],
            ],
            [
                'title' => 'Fusil à pompe',
                'items' => ['M3 Combat Shotgun (12 ga)'],
            ],
            [
                'title' => 'Fusils de précision',
                'items' => ['L115A3 Long Range Rifle', 'Mini Hekate II (.338 LM)'],
            ],
            [
                'title' => 'Pistolets',
                'items' => ['G17', 'G41', 'P250 Compact'],
            ],
        ],
        'credits'     => [
            ['asset' => 'L115A3', 'author' => 'Oxenci', 'license' => 'CC BY 4.0'],
            ['asset' => 'Howa Type 20', 'author' => 'Hung Do', 'license' => 'CC BY 4.0'],
            ['asset' => 'Aug A3 M1 with Aimpoint micro T2', 'author' => 'Al', 'license' => 'CC BY 4.0'],
            ['asset' => 'Honey Badger', 'author' => 'bagusmars', 'license' => 'CC BY 4.0'],
            ['asset' => 'MP9', 'author' => 'Firewarden3D', 'license' => 'CC BY 4.0'],
            ['asset' => 'Benelli M3 Tactical', 'author' => 'Amapsis', 'license' => 'CC BY 4.0'],
            ['asset' => 'CZ Bren 2', 'author' => 'studio-svoboda (CGTrader)', 'license' => 'Non précisée'],
            ['asset' => 'UMP45', 'author' => 'emrekarabacak (CGTrader)', 'license' => 'Non précisée'],
            ['asset' => 'PGM 338 Sniper Rifle', 'author' => 'Alexandre P.', 'license' => 'CC BY 4.0'],
            ['asset' => 'H&K MP5', 'author' => 'wisdom3D', 'license' => 'CC BY-NC 4.0'],
        ],
    ],

    'equipment' => [
        'name'        => 'CK Equipment',
        'category'    => 'Équipement',
        'icon'        => 'equipment',
        'workshop_id' => '6AC77EB1B55B1228',
        'tagline'     => 'Béret vert, tenue de combat, écussons de troop, galons de grade et smartphone SICS.',
        'shots'       => [
            ['file' => 'equipment-1', 'alt' => 'Des commandos en tenue du CK sous une tente'],
            ['file' => 'equipment-4', 'alt' => 'Un commando consulte le SICS, avec écusson et galon sur l’épaule', 'pos' => '50% 46%'],
            ['file' => 'equipment-2', 'alt' => 'Le béret vert à l’insigne du CK', 'pos' => '50% 15%'],
            ['file' => 'equipment-3', 'alt' => 'Un galon de grade et un écusson de Troop 1'],
        ],
        'summary'     => [
            'Ce que portent les commandos : le béret vert à l’insigne du CK, une tenue Crye G3 en camouflage BME, des écussons de troop, un galon de poitrine pour chaque grade et un smartphone durci, le SICS, qui sert de carte.',
            'Tout est ajouté à l’arsenal de la faction US, pour un coût nul. Les tenues reprennent les modèles de GRS - Apparel avec les textures du CK.',
        ],
        'stats'       => [
            ['44', 'objets à l’arsenal'],
            ['24', 'écussons'],
            ['16', 'galons de grade'],
        ],
        'features'    => [
            ['title' => 'Béret vert', 'text' => 'Porté à la britannique, avec l’insigne du Commando Kieffer 2004. Il accueille les micros-casques et masques de GRS.'],
            ['title' => 'Tenue Crye G3 (BME)', 'text' => 'Une chemise de combat aux manches retroussées et un pantalon, avec des textures refaites en 2048 px.'],
            ['title' => 'Écussons de troop', 'text' => 'Douze modèles, chacun en tissu brodé ou en silicone, avec velcro.'],
            ['title' => 'Galons de poitrine', 'text' => 'Un galon pour chacun des 16 grades, de Matelot à Capitaine de corvette, avec velcro.'],
            ['title' => 'SICS débarqué', 'text' => 'Le Système d’information du combat Scorpion débarqué : un smartphone durci qui ouvre la carte en plein écran. Toutes les 15 s, il place votre position, l’état-major de chaque troop du CK et les chefs des autres groupes. Hors de portée réseau, la dernière position connue est grisée avec son ancienneté.'],
        ],
        'content'     => [
            [
                'title' => 'Écussons',
                'note'  => 'Chacun en version tissu et en version silicone.',
                'items' => [
                    'CK',
                    'Troop 1', 'Troop 1 – Wyverne', 'Troop 1 – Phoenix',
                    'Troop 8', 'Troop 8 – Drakkar', 'Troop 8 – Léviathan',
                    'Troop K-Gun', 'Troop K-Gun – Char', 'Troop K-Gun – Infanterie',
                    'QG – Commandement', 'QG – Zeus',
                ],
            ],
            [
                'title' => 'Galons de poitrine',
                'note'  => 'Mêmes abréviations que la caserne.',
                'items' => ['Mtl', 'Mtb', 'Qm2', 'Qm1', 'Smm', 'Sm2', 'Sm1', 'M', 'Pm', 'Mp', 'Maj', 'Asp', 'Ev2', 'Ev1', 'Lv', 'CptC'],
            ],
            [
                'title' => 'Tenue et coiffe',
                'items' => ['Béret vert (commando)', 'Chemise de combat Crye G3 (BME)', 'Pantalon de combat Crye G3 (BME)'],
            ],
        ],
        'requires'    => [
            ['name' => 'CK Core', 'slug' => 'core'],
            ['name' => 'GRS - Apparel', 'url' => 'https://reforger.armaplatform.com/workshop/65157D09F042428A-GRS-Apparel'],
            ['name' => 'GRS - Patches', 'url' => 'https://reforger.armaplatform.com/workshop/657B064AE0E231DF-GRS-Patches'],
            ['name' => 'GRS - Dev Framework', 'url' => 'https://reforger.armaplatform.com/workshop/65DACC64CE785B6C-GRS-DevFramework'],
        ],
        'credits'     => [
            ['asset' => 'Modèles de tenue', 'author' => 'GRS (GRS - Apparel)', 'license' => '—'],
            ['asset' => 'Système d’écussons', 'author' => 'GRS (GRS - Patches, GRS - Dev Framework)', 'license' => '—'],
        ],
    ],

    'stress-test' => [
        'name'        => 'CK Server Stress Test',
        'category'    => 'Système',
        'icon'        => 'stress-test',
        'workshop_id' => '6A897DA9B919F1CD',
        'tagline'     => 'Un scénario serveur qui lance des vagues d’IA croissantes et mesure les performances.',
        'summary'     => [
            'Scénario serveur sur Arland qui n’a besoin d’aucun joueur : il fait apparaître des vagues d’IA américaines et soviétiques de plus en plus nombreuses et enregistre les performances du serveur dans un fichier CSV.',
            'Il sert à mesurer ce qu’un serveur dédié encaisse avant de décrocher. Le manager peut aussi être posé dans une autre carte.',
        ],
        'stats'       => [
            ['20 min', 'de test'],
            ['4', 'paliers de charge'],
        ],
        'features'    => [
            ['title' => 'Sans joueur', 'text' => 'Démarre dès la première image du serveur. Première vague à 30 s, puis une toutes les 20 s pendant 20 minutes.'],
            ['title' => 'Charge croissante', 'text' => 'La taille des vagues double toutes les 5 minutes : 30, 60, 120 puis 240 soldats par camp. Les groupes de 10 reçoivent un ordre de recherche et destruction.'],
            ['title' => 'Limites levées', 'text' => 'Le budget Game Master est ignoré, la limite d’IA passe à 100 000 et le niveau de détail des IA est forcé à 0. Les unités sont supprimées à la fin.'],
            ['title' => 'Mesures', 'text' => 'Une ligne CSV toutes les 2 secondes et un fichier de résumé indiquant running, finished ou aborted. Un résumé resté sur running signale un serveur planté.'],
            ['title' => 'Réglable', 'text' => 'Treize options en ligne de commande (-ckst_*) et vingt-trois attributs sur l’entité manager.'],
        ],
        'facts'       => [
            ['Carte', 'Arland'],
            ['Scénario', '{182B5D688EBCF5EC}Missions/CK_StressTest_Arland.conf'],
        ],
    ],

    'panel' => [
        'group'       => 'server',
        'name'        => 'Arma Reforger Panel',
        'category'    => 'Outil serveur',
        'icon'        => 'panel',
        'repo_url'    => 'https://github.com/commando-kieffer/arma-reforger-panel',
        'tagline'     => 'Panneau web pour installer, lancer et surveiller un serveur Arma Reforger.',
        'summary'     => [
            'Panneau web auto-hébergé pour installer, lancer et surveiller un serveur dédié Arma Reforger sous Ubuntu. Le compte root peut donner des droits limités à d’autres utilisateurs.',
            'C’est un fork d’arma-reforger-panel de Mateusz Gołębiewski, que nous avons largement étendu : code découpé en modules, interface en français et en anglais, thèmes, comptes avec droits, éditeur de configuration et installeur complet.',
        ],
        'features'    => [
            ['title' => 'Installation en une commande', 'text' => 'Le script installe SteamCMD, le serveur, le panneau, nginx, un certificat Let’s Encrypt et un pare-feu UFW. L’option --panel-only n’installe que le panneau sur un serveur existant.'],
            ['title' => 'Contrôle du serveur', 'text' => 'Démarrer, arrêter, redémarrer, mettre à jour via SteamCMD, ou forcer l’arrêt.'],
            ['title' => 'Supervision', 'text' => 'Courbes CPU et mémoire en direct, console en direct et historique des logs téléchargeable en zip.'],
            ['title' => 'Joueurs', 'text' => 'Liste des joueurs connectés avec leur nom et leur identité, et expulsion depuis le panneau.'],
            ['title' => 'Configuration', 'text' => 'Cartes de réglage pour le nombre de joueurs, la visibilité, le crossplay, le gameplay et la persistance, plus un éditeur config.json avec validation. Les 20 dernières sauvegardes sont conservées.'],
            ['title' => 'Mods et scénarios', 'text' => 'Ensembles de mods, export JSON et suppression des mods téléchargés. Les scénarios sont détectés sur l’installation du serveur.'],
            ['title' => 'Comptes', 'text' => 'Connexion OAuth2 (compatible XenForo) en plus du mot de passe root, et 14 droits à attribuer à chaque utilisateur.'],
            ['title' => 'Thèmes', 'text' => 'Trois thèmes fournis : Commando Kieffer - Zeus, Retro 2000 et Terminal. On peut en importer, en exporter, et changer le logo et les icônes.'],
        ],
        'requires'    => [
            ['name' => 'Python 3.10+'],
            ['name' => 'Flask'],
            ['name' => 'bcrypt'],
            ['name' => 'SteamCMD'],
        ],
        'facts'       => [
            ['Licence', 'MIT'],
            ['Plateforme', 'Ubuntu 20.04, 22.04 ou 24.04 (x86_64)'],
            ['Projet d’origine', 'arma-reforger-panel, par Mateusz Gołębiewski'],
        ],
        'install'     => [
            'label' => 'Installation',
            'code'  => "git clone https://github.com/commando-kieffer/arma-reforger-panel.git\ncd arma-reforger-panel\nsudo bash install.sh",
        ],
    ],
];
