/* Boutons « Copier » de la fiche d'un mod. */

function copyText(text) {
    if (navigator.clipboard && window.isSecureContext) {
        return navigator.clipboard.writeText(text);
    }

    // Repli pour les contextes non sécurisés (HTTP).
    return new Promise((resolve, reject) => {
        const field = document.createElement('textarea');
        field.value = text;
        field.setAttribute('readonly', '');
        field.style.position = 'fixed';
        field.style.opacity = '0';
        document.body.appendChild(field);
        field.select();

        const copied = document.execCommand('copy');
        field.remove();

        copied ? resolve() : reject(new Error('copy failed'));
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-copy]').forEach((button) => {
        const label = button.textContent;
        let timer;

        button.addEventListener('click', async () => {
            try {
                await copyText(button.dataset.copy);
                button.textContent = 'Copié';
            } catch (e) {
                button.textContent = 'Copie impossible';
            }

            clearTimeout(timer);
            timer = setTimeout(() => { button.textContent = label; }, 1800);
        });
    });
});

/* Visionneuse des captures d'un mod. */
document.addEventListener('DOMContentLoaded', () => {
    const links = Array.from(document.querySelectorAll('[data-lightbox]'));
    const dialog = document.getElementById('lightbox');

    if (!links.length || !dialog || typeof dialog.showModal !== 'function') {
        return;
    }

    const img = dialog.querySelector('.lightbox__img');
    const caption = dialog.querySelector('.lightbox__caption');
    const counter = dialog.querySelector('.lightbox__counter');
    const prev = dialog.querySelector('.lightbox__nav--prev');
    const next = dialog.querySelector('.lightbox__nav--next');
    const root = document.documentElement;
    let current = 0;

    prev.hidden = next.hidden = links.length < 2;

    function show(index) {
        current = (index + links.length) % links.length;
        const link = links[current];

        img.src = link.href;
        img.alt = link.dataset.alt || '';
        caption.textContent = link.dataset.alt || '';
        counter.textContent = links.length > 1 ? `${current + 1} / ${links.length}` : '';

        // Précharge l'image suivante.
        new Image().src = links[(current + 1) % links.length].href;
    }

    links.forEach((link, index) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            show(index);
            root.classList.add('lightbox-open');
            dialog.showModal();
        });
    });

    prev.addEventListener('click', () => show(current - 1));
    next.addEventListener('click', () => show(current + 1));
    dialog.querySelector('.lightbox__close').addEventListener('click', () => dialog.close());

    // Un clic hors de l'image et des boutons ferme la visionneuse.
    dialog.addEventListener('click', (event) => {
        if (!event.target.closest('.lightbox__img, .lightbox__btn, .lightbox__caption')) {
            dialog.close();
        }
    });

    dialog.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') show(current - 1);
        if (event.key === 'ArrowRight') show(current + 1);
    });

    dialog.addEventListener('close', () => root.classList.remove('lightbox-open'));
});
