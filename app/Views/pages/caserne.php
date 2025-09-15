<main>
    <div class="container--main">
        <h1>La caserne</h1>

        <section class="content--center barracks-layout">
            <?php if (!empty($barracks_data)) : ?>
                <?php foreach ($barracks_data as $troopName => $bordees) : ?>
                    <?php
                        // Extraire le chef et le retirer des bordées
                        $chef = null;
                        foreach ($bordees as $bKey => &$users) {
                            foreach ($users as $i => $u) {
                                if ($u['is_chef']) {
                                    $chef = $u;
                                    unset($users[$i]);
                                }
                            }
                            $users = array_values($users); // réindexation propre
                        }
                    ?>
                    <div class="troop-block">
                        <!-- Titre de la Troop -->
                        <blockquote>
                            <?= esc($troopName); ?>
                        </blockquote>

                        <!-- Chef de Troop -->
                        <?php if ($chef): ?>
                            <table class="chef-table">
                                <thead>
                                    <tr>
                                        <th>Chef de Troop</th>
                                        <th>Spécialité</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="user-inline">
                                                <div class="tooltip-wrapper">
                                                    <img class="jacket" src="/pictures/jackets/<?= esc($chef['user_title']); ?>.png" alt="<?= esc($chef['user_title']); ?>">
                                                    <div class="tooltip-text"><?= esc($chef['user_title']); ?></div>
                                                </div>
                                                <span><?= esc($chef['username']); ?></span>
                                            </div>
                                        </td>
                                        <td><?= esc($chef['specialite'] ?? 'Commandement'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php endif; ?>


                        <div class="bordee-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Bordée 1</th>
                                        <th>Spécialité</th>
                                        <th>Bordée 2</th>
                                        <th>Spécialité</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $b1 = $bordees['Bordée 1'] ?? [];
                                    $b2 = $bordees['Bordée 2'] ?? [];
                                    $max = max(count($b1), count($b2));

                                    for ($i = 0; $i < $max; $i++) :
                                        $user1 = $b1[$i] ?? null;
                                        $user2 = $b2[$i] ?? null;
                                    ?>
                                        <tr>
                                            <td>
                                                <?php if ($user1): ?>
                                                    <div class="user-inline">
                                                        <div class="tooltip-wrapper">
                                                            <img class="jacket" src="/pictures/jackets/<?= esc($user1['user_title']); ?>.png" alt="<?= esc($user1['user_title']); ?>">
                                                            <div class="tooltip-text"><?= esc($user1['user_title']); ?></div>
                                                        </div>
                                                        <span><?= esc($user1['username']); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $user1 ? esc($user1['specialite']) : ''; ?></td>

                                            <td>
                                                <?php if ($user2): ?>
                                                    <div class="user-inline">
                                                        <div class="tooltip-wrapper">
                                                            <img class="jacket" src="/pictures/jackets/<?= esc($user2['user_title']); ?>.png" alt="<?= esc($user2['user_title']); ?>">
                                                            <div class="tooltip-text"><?= esc($user2['user_title']); ?></div>
                                                        </div>
                                                        <span><?= esc($user2['username']); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $user2 ? esc($user2['specialite']) : ''; ?></td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun membre actif trouvé dans la caserne.</p>
            <?php endif; ?>
        </section>
    </div>
</main>
