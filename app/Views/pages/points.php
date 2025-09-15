<?php $i = 0; ?>
<main>
    <div class="container--main bg--gw">
        <h1>Tableau récapitulatif</h1>
        <blockquote>
            Médaille de bronze (400pts) <br>
            Médaille d'argent (900pts) <br>
            Médaille d'or (1500pts)
        </blockquote>

        <section class="content--center">
            <?php if (!empty($active_listofusers_points)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Commando</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($active_listofusers_points as $user) : ?>
                            <?php $i++; ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= esc($user['username']); ?></td>
                                <td><?= esc($user['panel_pts']); ?></td>
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