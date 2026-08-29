<main class="galerie <?= $in_album ? 'galerie--album' : 'galerie--home' ?>">
    <?php if ($in_album) { ?>
    <!-- Galerie de photos à l'intérieur d'une catégorie -->
    <div id="modal-bg"></div>
    <div id="modal" style="display: none">
        <button id="modal-close-btn" class="ck-button ck-button-big" onClick="closeModal()">Fermer</button>
        <img id="modal-img" width="100%" src="#" alt="En attente...">
        <div id="modal-caption">-</div>
    </div>
    <div>
        <div class="fixed-btn-container">
            <a class="ck-button" style="margin-right: 5px" href="https://www.youtube.com/user/CommandoKiefferTV" target="_blank">Chaîne YouTube</a>
            <a class="ck-button" href="/galerie">Retour aux albums</a>
        </div>
        <div class="gallery-image">
        <?php
            if (count($pictures) === 0) {
                echo "<p>Il n'y a aucune image dans cette catégorie.</p>";
            } else {
                foreach ($pictures as $image) {
                    ?>
                <figure onClick="openModal(<?php echo $image->id ?>)">
                    <img id="img-<?php echo $image->id ?>" src="<?php echo $image->url ?>"></img>
                    <div class="transparent-box">
                        <div class="opacity-low">
                            <figcaption id="caption-<?php echo $image->id ?>"><?php echo $image->description ?></figcaption>
                        </div>
                    </div>
                </figure>
            <?php
                } ?>
        <?php
            } ?>
        </div>
    </div>
    <script>
        const MODAL_IMG = document.querySelector('#modal-img')
        const MODAL_CAPTION = document.querySelector('#modal-caption')
        const PAGE = document.querySelector('.galerie')

        const openModal = id => {
            const img = document.querySelector(`#img-${id}`)
            const caption = document.querySelector(`#caption-${id}`)
            window.location.hash = `photo-${id}`
            MODAL_IMG.src = img.src
            MODAL_CAPTION.innerText = caption.innerText
            PAGE.classList.add('modal-open')
        }

        const closeModal = () => {
            PAGE.classList.remove('modal-open')
            window.location.hash = ''
        }

        window.addEventListener('load', () => {
            const hash = window.location.hash

            if (hash.length !== 0) {
                if (hash.startsWith('#photo-')) {
                    openModal(hash.replace('#photo-', ''))
                }
            }
        })
    </script>
    <?php } else { ?>
    <!-- Liste des catégories / accueil de la galerie -->
    <div class="gallery-home">
        <header class="gallery-home__head">
            <div class="gallery-home__intro">
                <h1>Galerie</h1>
                <?php if (!empty($categories)) : ?>
                    <p class="gallery-home__count"><?= count($categories) ?> album<?= count($categories) > 1 ? 's' : '' ?></p>
                <?php endif; ?>
            </div>
            <a class="gallery-home__yt" href="https://www.youtube.com/user/CommandoKiefferTV" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8ZM9.6 15.6V8.4l6.3 3.6-6.3 3.6Z"/></svg>
                Chaîne YouTube
            </a>
        </header>

        <?php if (empty($categories)) : ?>
            <p class="gallery-home__empty">Aucun album n'est disponible pour le moment.</p>
        <?php else : ?>
            <ul class="album-grid">
                <?php foreach ($categories as $category) : ?>
                    <li class="album-card">
                        <a class="album-card__link" href="/galerie/<?= esc($category->slug, 'attr') ?>">
                            <span class="album-card__cover" aria-hidden="true">
                                <img src="/pictures/logo_ck_blanc.png" alt="">
                            </span>
                            <span class="album-card__body">
                                <span class="album-card__title"><?= esc($category->name) ?></span>
                                <span class="album-card__desc"><?= str_replace('\n', '<br>', esc($category->short_description)) ?></span>
                                <span class="album-card__cta">Ouvrir l'album <span aria-hidden="true">&rarr;</span></span>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php } ?>
</main>
