<main class="galerie">
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
    <div>
        <div class="fixed-btn-container">
            <a class="ck-button" style="margin-right: 5px" href="https://www.youtube.com/user/CommandoKiefferTV" target="_blank">Chaîne YouTube</a>
        </div>
        <div class="category-container">
            <?php foreach ($categories as $category) { ?>
                <a
                    class="category-cell"
                    href="/galerie/<?php echo $category->slug; ?>">
                    <h1 class="category-title"><?php echo $category->name; ?></h1>
                    <p class="category-description"><?php echo str_replace("\\n", "<br>", htmlspecialchars($category->short_description)); ?></p>
                 </a>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
</main>