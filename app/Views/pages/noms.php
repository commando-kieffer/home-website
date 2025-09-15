<main>
    <div class="container--main bg--gw">
        <h1>Liste des noms disponibles</h1>

        <section class="content--center">
            <?php if (!empty($commando_names)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commando_names as $commando) : ?>
                            <tr>
                                <td style="text-align: center;"><?= esc($commando["name"]); ?></td>
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
