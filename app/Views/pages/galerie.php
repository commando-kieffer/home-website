<main class="galerie <?= $in_album ? 'galerie--album' : 'galerie--home' ?>">
    <?php if ($in_album) :
        $albumName = $category->name ?? 'Album';
        $photoCount = count($pictures);
        $initialBatch = 10;
    ?>
    <!-- Galerie de photos à l'intérieur d'un album -->
    <div class="album" data-open-photo="<?= esc((string) $pic_id, 'attr') ?>">
        <header class="album__head">
            <a class="album__back" href="/galerie">
                <span aria-hidden="true">&larr;</span> Tous les albums
            </a>
            <h1><?= esc($albumName) ?></h1>
            <p class="album__meta">
                <?php if ($photoCount > 0) : ?>
                    <?= $photoCount ?> photo<?= $photoCount > 1 ? 's' : '' ?>
                    <span class="album__meta-sep" aria-hidden="true">&middot;</span>
                <?php endif; ?>
                <a href="https://www.youtube.com/user/CommandoKiefferTV" target="_blank" rel="noopener">Chaîne YouTube</a>
            </p>
        </header>

        <?php if ($photoCount === 0) : ?>
            <p class="album__empty">Il n'y a aucune image dans cet album.</p>
        <?php else : ?>
            <ul class="album__grid" id="album-grid">
                <?php foreach ($pictures as $i => $image) :
                    $caption = trim((string) ($image->description ?? ''));
                    $alt = $caption !== '' ? $caption : trim((string) ($image->name ?? 'Photo'));
                ?>
                    <li class="album-photo" data-id="<?= esc((string) $image->id, 'attr') ?>"<?= $i >= $initialBatch ? ' hidden' : '' ?>>
                        <button type="button" class="album-photo__btn"
                            data-full="<?= esc($image->url, 'attr') ?>"
                            data-caption="<?= esc($caption, 'attr') ?>">
                            <img
                                <?= $i < $initialBatch ? 'src="' . esc($image->url, 'attr') . '" ' : '' ?>data-src="<?= esc($image->url, 'attr') ?>"
                                alt="<?= esc($alt) ?>"
                                loading="lazy">
                            <?php if ($caption !== '') : ?>
                                <span class="album-photo__caption"><?= esc($caption) ?></span>
                            <?php endif; ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p id="album-loading" class="album__loading"<?= $photoCount <= $initialBatch ? ' hidden' : '' ?>>Chargement des photos&hellip;</p>
        <?php endif; ?>

        <div id="album-carousel" class="carousel" role="dialog" aria-modal="true" aria-label="Visionneuse de photos" tabindex="-1" hidden>
            <button type="button" class="carousel__close" aria-label="Fermer la visionneuse">&times;</button>
            <button type="button" class="carousel__nav carousel__nav--prev" aria-label="Photo précédente">
                <span aria-hidden="true">&lsaquo;</span>
            </button>
            <figure class="carousel__stage">
                <img class="carousel__img" id="carousel-img" src="" alt="">
                <figcaption class="carousel__caption" id="carousel-caption" hidden></figcaption>
            </figure>
            <button type="button" class="carousel__nav carousel__nav--next" aria-label="Photo suivante">
                <span aria-hidden="true">&rsaquo;</span>
            </button>
            <div class="carousel__counter" id="carousel-counter" aria-hidden="true"></div>
        </div>
    </div>

    <script>
        (function () {
            const grid = document.getElementById('album-grid');
            if (!grid) return;

            const photos = Array.prototype.slice.call(grid.querySelectorAll('.album-photo'));
            const BATCH = <?= $initialBatch ?>;
            const loading = document.getElementById('album-loading');
            // The first batch is already rendered server-side.
            let revealed = Math.min(BATCH, photos.length);
            let ticking = false;

            function revealUpTo(target) {
                target = Math.min(target, photos.length);
                for (; revealed < target; revealed++) {
                    const li = photos[revealed];
                    li.hidden = false;
                    const img = li.querySelector('img');
                    if (img && !img.getAttribute('src') && img.dataset.src) {
                        img.src = img.dataset.src;
                    }
                }
                if (loading) loading.hidden = revealed >= photos.length;
                if (revealed >= photos.length) {
                    window.removeEventListener('scroll', onScroll);
                    window.removeEventListener('resize', onScroll);
                }
            }

            // Load the next batch once the reader nears the bottom of the page,
            // then keep topping up until the page is scrollable again.
            function fill() {
                ticking = false;
                if (revealed >= photos.length) return;
                const nearEnd = window.innerHeight + window.scrollY >=
                    document.documentElement.scrollHeight - window.innerHeight * 0.6;
                if (nearEnd) {
                    revealUpTo(revealed + BATCH);
                    requestAnimationFrame(fill);
                }
            }

            function onScroll() {
                if (ticking) return;
                ticking = true;
                requestAnimationFrame(fill);
            }

            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onScroll, { passive: true });
            if (loading) loading.hidden = revealed >= photos.length;
            fill();

            /* ---------- Carousel ---------- */
            const items = photos.map(function (li) {
                const btn = li.querySelector('.album-photo__btn');
                return { id: li.dataset.id, url: btn.dataset.full, caption: btn.dataset.caption || '' };
            });

            const carousel = document.getElementById('album-carousel');
            const carImg = document.getElementById('carousel-img');
            const carCaption = document.getElementById('carousel-caption');
            const carCounter = document.getElementById('carousel-counter');
            let current = -1;
            let lastFocus = null;

            function preload(index) {
                const it = items[(index + items.length) % items.length];
                if (it) { const im = new Image(); im.src = it.url; }
            }

            function render(index) {
                if (!items.length) return;
                current = (index + items.length) % items.length;
                const it = items[current];
                carImg.src = it.url;
                carImg.alt = it.caption || ('Photo ' + (current + 1));
                carCaption.textContent = it.caption;
                carCaption.hidden = it.caption === '';
                carCounter.textContent = (current + 1) + ' / ' + items.length;
                preload(current + 1);
                preload(current - 1);
                setHash('photo-' + it.id);
            }

            function setHash(value) {
                if (window.history && history.replaceState) {
                    history.replaceState(null, '', value ? '#' + value : location.pathname + location.search);
                } else {
                    location.hash = value;
                }
            }

            function openCarousel(index) {
                lastFocus = document.activeElement;
                render(index);
                carousel.hidden = false;
                document.documentElement.classList.add('carousel-open');
                carousel.focus();
            }

            function closeCarousel() {
                carousel.hidden = true;
                document.documentElement.classList.remove('carousel-open');
                setHash('');
                if (lastFocus && typeof lastFocus.focus === 'function') {
                    lastFocus.focus();
                } else if (current > -1 && photos[current]) {
                    const b = photos[current].querySelector('.album-photo__btn');
                    if (b) b.focus();
                }
            }

            const next = function () { render(current + 1); };
            const prev = function () { render(current - 1); };

            photos.forEach(function (li, i) {
                li.querySelector('.album-photo__btn').addEventListener('click', function () { openCarousel(i); });
            });
            carousel.querySelector('.carousel__close').addEventListener('click', closeCarousel);
            carousel.querySelector('.carousel__nav--next').addEventListener('click', next);
            carousel.querySelector('.carousel__nav--prev').addEventListener('click', prev);
            carousel.addEventListener('click', function (e) {
                if (e.target === carousel || e.target === carImg.parentNode) closeCarousel();
            });

            document.addEventListener('keydown', function (e) {
                if (carousel.hidden) return;
                if (e.key === 'Escape') closeCarousel();
                else if (e.key === 'ArrowRight') next();
                else if (e.key === 'ArrowLeft') prev();
            });

            let touchX = 0, touchY = 0;
            carousel.addEventListener('touchstart', function (e) {
                touchX = e.changedTouches[0].clientX;
                touchY = e.changedTouches[0].clientY;
            }, { passive: true });
            carousel.addEventListener('touchend', function (e) {
                const dx = e.changedTouches[0].clientX - touchX;
                const dy = e.changedTouches[0].clientY - touchY;
                if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy)) { dx < 0 ? next() : prev(); }
            }, { passive: true });

            /* ---------- Deep linking ---------- */
            function indexOfId(id) {
                for (let i = 0; i < items.length; i++) {
                    if (String(items[i].id) === String(id)) return i;
                }
                return -1;
            }

            function openFromHash() {
                const m = location.hash.match(/^#photo-(.+)$/);
                if (!m) return false;
                const idx = indexOfId(decodeURIComponent(m[1]));
                if (idx === -1) return false;
                revealUpTo(idx + 1);
                openCarousel(idx);
                return true;
            }

            const requested = grid.closest('.album').dataset.openPhoto;
            if (requested && requested !== '-1' && requested !== '') {
                const idx = indexOfId(requested);
                if (idx > -1) { revealUpTo(idx + 1); openCarousel(idx); }
                else openFromHash();
            } else {
                openFromHash();
            }

            window.addEventListener('hashchange', function () {
                if (carousel.hidden) openFromHash();
            });
        })();
    </script>

    <?php else : ?>
    <!-- Liste des albums / accueil de la galerie -->
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
    <?php endif; ?>
</main>
