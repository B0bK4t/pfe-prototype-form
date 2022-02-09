/**Composante Header de Timtools */
export default class Header {
  /**
   * Méthode constructeur
   * @param {HTMLElement} element - Élément HTML sur lequel la composante est instanciée
   */
  constructor(element) {
    this.element = element;

    // Variables utilisées pour les différentes méthodes
    this.scrollPosition = 0;
    this.lastScrollPosition = 0;
    if (this.element.dataset.scrollLimit == undefined) {
      this.scrollLimit = 0.1;
    } else {
      this.scrollLimit = this.element.dataset.scrollLimit;
    }
    if (this.element.dataset.autoHide == undefined) {
      this.autoHide = true;
    } else {
      this.autoHide = this.element.dataset.autoHide;
    }
    this.html = document.documentElement;

    this.lis = document.querySelector('nav').querySelectorAll('li');

    this.init();
    this.initNavMobile();
  }

  /**
   * Méthode d'initialisation
   */
  init() {
    // Écouter le défilement sur la page
    window.addEventListener('scroll', this.onScroll.bind(this));

    //Mettre en place l'alerte de réservation
    this.reserver();
  }

  /**
   * Méthode appellée par le défilement
   * @param {event} event - Paramètre d'évenement (non utilisé ici, il est présent par habitude)
   */
  onScroll(event) {
    // Vérification de la position actuelle
    this.lastScrollPosition = this.scrollPosition;
    this.scrollPosition = document.scrollingElement.scrollTop;

    // Appel des méthodes
    if (this.autoHide != 'false') {
      this.setHeaderState();
    }
    this.setDirectionState();
  }

  /**
   * Méthode déterminant la visibilité de l'entête
   */
  setHeaderState() {
    // Si le défilement actuel est plus bas qu'une certaine valeur, cacher l'entête
    // Sinon, afficher l'entête
    const scrollHeight = document.scrollingElement.scrollHeight;
    if (this.scrollPosition > scrollHeight * this.scrollLimit) {
      this.html.classList.add('header-is-hidden');
    } else {
      this.html.classList.remove('header-is-hidden');
    }
  }

  /**
   * Méthode déterminant la direction du défilement
   */
  setDirectionState() {
    // Comparaison de la position actuelle et de la position précédente
    // Détermine la direction
    if (this.scrollPosition >= this.lastScrollPosition) {
      this.html.classList.add('is-scrolling-down');
      this.html.classList.remove('is-scrolling-up');
    } else {
      this.html.classList.remove('is-scrolling-down');
      this.html.classList.add('is-scrolling-up');
    }
  }

  /**
   * Méthode d'initialisation de la navigation mobile
   */
  initNavMobile() {
    // Écouter les interactions avec le bouton de menu
    const toggle = this.element.querySelector('.js-toggle');
    toggle.addEventListener('click', this.onToggleNav.bind(this));
  }

  /**
   * Méthode pour basculer les états du menu
   */
  onToggleNav() {
    this.html.classList.toggle('nav-is-active');
  }

  /**
   * Méthode pour ajouter la procédure de réservation
   */
  reserver() {
    for (let i = 0; i < this.lis.length; i++) {
      const li = this.lis[i];

      let link = li.querySelector('a');
      if (link != null) {
        let button = li;
        let href = link.getAttribute('href');
        if (href == '#') {
          let text = link.innerHTML;
          let content = text;
          button.innerHTML = `
            <button
                class="button"
                onclick="alert('Procédure de réservation')"
            >${content}</button>`;
        }
      }
    }
  }
}
