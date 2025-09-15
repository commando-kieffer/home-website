<main>
    <div class="container--main bg--gw">
        <h1>Liste des décorations</h1>

        <section class="content--center">
            <?php if (!empty($active_listofusers_medals)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Commando</th>
                            <th>Grade</th>
                            <th>Médailles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($active_listofusers_medals as $user) : ?>
                            <tr>
                                <td><?= esc($user['username']); ?></td>
                                <td>
                                    <div class="tooltip-wrapper">
                                        <img class="jacket" src="/pictures/jackets/<?= esc($user['user_title']); ?>.png" alt="<?= esc($user['user_title']); ?>">
                                        <div class="tooltip-text"><?= esc($user['user_title']); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($user['medals'])) :
                                        foreach ($user['medals'] as $medal) : ?>
                                            <div class="tooltip-wrapper">
                                                <img class="medal" src="/pictures/medals/<?= esc($medal['name']); ?>.jpg" alt="<?= esc($medal['title']); ?>">
                                                <div class="tooltip-text">
                                                    <strong><?= esc($medal['title']); ?></strong><br>
                                                    <small><?= esc($medal['description']); ?></small>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <em>Aucune médaille</em>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>Aucun utilisateur actif trouvé.</p>
            <?php endif; ?>
        </section>
    </div>
</main>