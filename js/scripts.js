




jQuery(document).ready(function ($) {
    // Sélectionne l'élément du menu burger et le menu de navigation mobile
    const burgerMenu = document.getElementById("burgerMenu");
    const mobileNav = document.querySelector(".nav-links");
    // Lorsque l'élément burgerMenu est cliqué, on bascule les classes 'active' pour afficher/masquer le menu
    burgerMenu.addEventListener("click", function () {
        burgerMenu.classList.toggle("active");
        mobileNav.classList.toggle("active");
    });

    // Fonction pour gérer l'affichage et la fermeture de la modale
    function handleModal(button) {
        var modal = document.getElementById("contactModal");
        var span = document.getElementsByClassName("close")[0];

        button.onclick = function () {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }

    var modalButtons = document.querySelectorAll(".contact-modal");

    modalButtons.forEach(function (button) {
        handleModal(button);
    });

    // Met à jour le champ du formulaire en fonction de la référence photo
    function updateFormField() {
        if (typeof photoRef !== 'undefined') {
            $('input[name="your-subject"]').val(photoRef['value']);
        }
    }

    jQuery('.contact-modal').on('click', function () {
        updateFormField();
    });
    // Initialisation de la pagination pour charger les photos suivantes
    let currentPage = 1;
    const itemsPerPage = 8;
    $('#loadMore').click(function () {
        updatePhotos(currentPage + 1, true);
    });
    // Charge les photos de la page actuelle
    updatePhotos(currentPage);

    // Fonction pour mettre à jour les photos en fonction des filtres appliqués
    function updatePhotos(page = 1, append = false) {
        let categorie = document.getElementById('filter_categorie').getAttribute('data-value');
        let format = document.getElementById('filter_format').getAttribute('data-value');
        let date = document.getElementById('filter_date').getAttribute('data-value');
        console.log("Catégorie:", categorie, "Format:", format, "Date:", date, "Page:", page);
        // Effectue une requête AJAX pour récupérer les photos en fonction des filtres et de la page
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
                action: 'filter_photos',
                categorie: categorie,
                format: format,
                date: date,
                page: page,
                items_per_page: itemsPerPage,
            },
            success: function (response) {
                if (append) {
                    // Si on ajoute les photos à la page existante
                    $('#photo-container').append(response);
                    console.log('refresh lightbox here');
                    initializeLightbox();
                    hoverImageFunction()
                    currentPage++;
                } else {
                    // Si on remplace les photos existantes
                    $('#photo-container').html(response);
                    initializeLightbox();
                    hoverImageFunction()
                }
            },
            error: function (error) {
                console.log('Erreur AJAX:', error);
            }
        });

    }

    // Fonction pour initialiser la Lightbox pour afficher les images en plein écran
    function initializeLightbox() {
        if (window.lightboxInstance) {
            window.lightboxInstance = null;
        }
        window.lightboxInstance = new Lightbox();
    }
    // Classe pour gérer la Lightbox et la navigation entre les images
    class Lightbox {
        constructor() {
            // Sélection des éléments nécessaires pour la Lightbox
            this.galleryImages = document.querySelectorAll('.gallery-image');
            this.galleryContainer = document.querySelectorAll('.gallery');
            this.gallerySpans = document.querySelectorAll('.span_link');
            this.lightbox = document.querySelector('.lightbox');
            this.lightboxImage = document.querySelector('.lightbox-image');
            this.closeButton = document.querySelector('.lightbox-close');
            this.prevButton = document.querySelector('.lightbox-prev');
            this.nextButton = document.querySelector('.lightbox-next');
            this.overlay = document.querySelector('.lightbox-overlay');
            this.lightboxCategory = document.querySelector('.lightbox-categorie');
            this.lightboxReference = document.querySelector('.lightbox-reference');

            this.images = this.createImageList();
            this.currentIndex = null;

            this.initEvents();
        }
        // Crée une liste d'images avec leurs propriétés (src, alt, etc.)
        createImageList() {
            return Array.from(this.galleryImages).map((img, index) => ({
                src: img.src,
                alt: img.alt,
                index,
                reference: img.dataset.reference,
                categories: img.dataset.categorie,
            }));
        }

        initEvents() {
            // Initialise les événements pour chaque image dans la galerie
            this.galleryContainer.forEach((gallery) => {
                const spanLink = gallery.querySelector('.span_link');
                const spanIcon = gallery.querySelector('.icon_eye');


                const image = gallery.querySelector('img');
                const index = this.images.findIndex(img => img.src === image.src);
                // Vérifie si l'image existe dans la liste
                if (index === -1) {
                    console.error("Image non trouvée dans la liste.");
                    return;
                }
                // Si l'élément spanLink est trouvé, on ajoute un événement de clic pour ouvrir la lightbox
                if (spanLink) {
                    spanLink.addEventListener('click', () => {
                        this.open(index);
                    });
                }
                // Si l'élément spanIcon est trouvé, on ajoute un événement pour rediriger vers un autre URL
                if (spanIcon) {
                    spanIcon.addEventListener('click', () => {
                        const url = spanIcon.dataset.url;
                        if (url) {
                            window.location.href = url;
                        }
                    });
                }
            });

            // Ajout des événements pour les boutons de la lightbox (précédent, suivant, fermeture)
            this.nextButton.addEventListener('click', () => this.next());
            this.prevButton.addEventListener('click', () => this.prev());
            this.closeButton.addEventListener('click', () => this.close());
            this.overlay.addEventListener('click', () => this.close());

            // Navigation au clavier
            document.addEventListener('keydown', (e) => {
                if (this.lightbox.classList.contains('hidden')) return;

                switch (e.key) {
                    case 'ArrowRight':
                        this.next();
                        break;
                    case 'ArrowLeft':
                        this.prev();
                        break;
                    case 'Escape':
                        this.close();
                        break;
                }
            });
        }

        // Ouvrir la lightbox
        open(index) {
            if (index < 0 || index >= this.images.length) {
                console.error(`Index hors limites lors de l’ouverture : ${index}`);
                return;
            }

            this.currentIndex = index;
            this.updateImage();

            this.lightbox.classList.remove('hidden');
            setTimeout(() => {
                this.lightbox.classList.add('show');
            }, 10);
        }


        close() {
            this.lightbox.classList.remove('show');
            setTimeout(() => {
                this.lightbox.classList.add('hidden');
            }, 300);
        }


        // Afficher l'image actuelle
        updateImage() {
            if (this.currentIndex === null || this.currentIndex < 0 || this.currentIndex >= this.images.length) {
                console.error(`Index invalide : ${this.currentIndex}`);
                return;
            }

            const { src, alt, reference, categories } = this.images[this.currentIndex];
            this.lightboxImage.src = src;
            this.lightboxImage.alt = alt;

            // Ajouter la référence ACF
            const referenceElement = document.querySelector('.lightbox-reference');
            if (referenceElement) {
                referenceElement.textContent = `${reference}`;
            }

            // Ajouter les catégories
            const categoriesElement = document.querySelector('.lightbox-categorie');
            if (categoriesElement) {
                categoriesElement.textContent = `${categories}`;
            }
        }
        // Aller à l'image suivante
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.updateImage();
        }

        // Aller à l'image précédente
        prev() {
            this.currentIndex =
                (this.currentIndex - 1 + this.images.length) % this.images.length;
            this.updateImage();
        }
    }

    let elements_select = document.querySelectorAll('.custom_select');

    elements_select.forEach(function (element) {
        element.querySelector('.custom_default').addEventListener('click', function () {
            element.querySelector('.custom_options').classList.toggle('hidden');
            element.classList.toggle('border_switch');
            element.querySelector('.icon_select').classList.toggle('fa-chevron-down');
            element.querySelector('.icon_select').classList.toggle('fa-chevron-up');
            element.querySelectorAll('.custom_options li').forEach(function (li, index) {
                li.classList.remove('anim_select');
                setTimeout(() => {
                    li.classList.add('anim_select');
                }, index * 50);
            });
        });

        // Gestionnaire d'événement pour chaque élément <li> à l'intérieur de '.custom_options'
        element.querySelectorAll('.custom_options li').forEach(function (li) {

            li.addEventListener('click', function (event) {
                event.stopPropagation();

                let selectedValue = li.getAttribute('data-value');
                let selectedText = li.textContent;
                // Met à jour le texte de la div custom_default avec le texte sélectionné
                element.querySelector('.custom_default').innerHTML = selectedText + ' <span class="icon_select fas fa-chevron-down"></span>';

                // Met à jour la data-value de l'élément parent custom_select
                element.setAttribute('data-value', selectedValue);

                element.querySelector('.custom_options').classList.add('hidden');
                element.classList.remove('border_switch');
                element.querySelector('.icon_select').classList.remove('fa-chevron-up');
                element.querySelector('.icon_select').classList.add('fa-chevron-down');
                currentPage = 1;
                updatePhotos(currentPage, false); // Appel de la fonction AJAX ici
            });
        });
    });
    document.addEventListener('click', function (e) {
        elements_select.forEach(function (element) {
            if (!element.contains(e.target)) { // Vérifie si le clic est en dehors de l'élément custom_select
                element.querySelector('.custom_options').classList.add('hidden');
                element.classList.remove('border_switch');
                element.querySelector('.icon_select').classList.remove('fa-chevron-up');
                element.querySelector('.icon_select').classList.add('fa-chevron-down');
                element.querySelectorAll('.custom_options li').forEach(function (li) {
                    li.classList.remove('anim_select');
                });
            }
        });
    });
});


function hoverImageFunction() {
    // Sélectionne tous les conteneurs d'image avec la classe 'div_container_photo'
    const photoContainers = document.querySelectorAll('.div_container_photo');
    // Boucle sur chaque conteneur d'image
    photoContainers.forEach(container => {

        // Sélectionne l'image, le superposé (overlay) et les éléments span dans le conteneur
        const image = container.querySelector('.gallery-image');
        const overlay = container.querySelector('.overlay');
        const spans = container.querySelectorAll('span');
        // Fonction pour afficher les éléments au survol
        const showElements = () => {
            overlay.style.opacity = '1'; // Affiche le superposé (overlay)
            overlay.style.transition = 'opacity 0.3s ease-in-out'; // Ajoute une transition douce pour l'apparition du superposé
            image.style.filter = 'brightness(60%)'; // Applique un filtre de luminosité sur l'image
            spans.forEach(span => {
                span.style.opacity = '1'; // Affiche les spans (icônes ou autres éléments)
                span.style.transition = 'opacity 0.3s ease-in-out';  // Transition pour une apparition douce des spans
                image.style.filter = 'brightness(60%)';
            });
        };
        // Fonction pour masquer les éléments lorsque le survol est retiré
        const hideElements = () => {
            overlay.style.opacity = '0';
            image.style.filter = 'brightness(100%)';
            spans.forEach(span => {
                span.style.opacity = '0';
            });
        };
        // Ajoute un événement de survol sur le conteneur pour afficher les éléments
        container.addEventListener('mouseenter', showElements);
        // Ajoute un événement de sortie de survol sur le conteneur pour masquer les éléments
        container.addEventListener('mouseleave', hideElements);
    });
}