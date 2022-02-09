export default class Categories {
  /**
   * Méthode constructeur
   * @param {HTMLElement} element - Élément HTML sur lequel la composante est instanciée
   */
  constructor(element) {
    this.element = element;

    this.init();
  }

  /**
   * Méthode d'initialisation
   */
  init() {
    this.enleverVigule();
  }

  enleverVigule() {
    let str = this.element.querySelector('#smol').innerHTML;
    str = str.slice(0, str.length - 2);
    this.element.querySelector('#smol').innerHTML = str;
  }
}
