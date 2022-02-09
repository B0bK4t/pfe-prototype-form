export default class Hide {
  /**
   * Méthode constructeur
   * @param {HTMLElement} element - Élément HTML sur lequel la composante est instanciée
   */
  constructor(element) {
    this.element = element;
    this.button = this.element.querySelector('#filter');
    this.div = this.element.querySelector('[data-filter]');

    this.init();
  }

  /**
   * Méthode d'initialisation
   */
  init() {
    this.button.addEventListener('click', this.toggle.bind(this));
  }

  toggle() {
    this.div.classList.toggle('shown');
    if (this.div.classList.contains('shown')) {
      this.button.querySelector('#message').innerHTML = 'Cacher';
    } else {
      this.button.querySelector('#message').innerHTML = 'Afficher';
    }
  }
}
