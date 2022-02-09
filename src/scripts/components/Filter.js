import Utils from '../utils/Utils';

export default class Filter {
  /**
   * Méthode constructeur
   * @param {HTMLElement} element - Élément HTML sur lequel la composante est instanciée
   */
  constructor(element) {
    this.element = element;
    this.filters = this.element.querySelectorAll('.js-clickable');
    this.elements = this.element.querySelectorAll('.filtered');
    this.reset = document.querySelector('#reset');
    this.inputs = this.element.querySelectorAll('input');
    this.classes = [];
    this.search = this.element.querySelector('.search-bar');

    this.init();
  }

  /**
   * Méthode d'initialisation
   */
  init() {
    for (let i = 0; i < this.inputs.length; i++) {
      const c = this.inputs[i];
      c.checked = false;
    }

    for (let i = 0; i < this.filters.length; i++) {
      const c = this.filters[i];
      c.addEventListener('click', this.checkF.bind(this));
    }

    this.reset.addEventListener('click', this.resetF.bind(this));

    this.search.value = '';
    this.search.addEventListener('keyup', this.checkS.bind(this));
  }

  resetF() {
    this.classes = [];
    this.verify();

    for (let i = 0; i < this.inputs.length; i++) {
      const c = this.inputs[i];
      c.checked = false;
    }
  }

  checkF(e) {
    if (e.target.checked != undefined) {
      let value = e.target.parentElement.querySelector('input').value;
      if (e.target.checked) {
        this.classes.push(value);
      } else {
        Utils.removeFromArray(this.classes, value);
      }
      this.verify();
    }
  }

  verify() {
    let current = this.classes;
    if (current.length > 0) {
      for (let i = 0; i < this.elements.length; i++) {
        const ex = this.elements[i];
        let exCats = ex.dataset.cat.split(';');
        exCats.pop();

        for (let ii = 0; ii < current.length; ii++) {
          const c = current[ii];
          if (exCats.indexOf(c) == -1) {
            ex.classList.add('hiddenF');
            break;
          } else {
            ex.classList.remove('hiddenF');
          }
        }
      }
    } else {
      for (let i = 0; i < this.elements.length; i++) {
        const ex = this.elements[i];
        ex.classList.remove('hiddenF');
      }
    }
  }

  checkS() {
    let v = Utils.format(this.search.value);
    for (let i = 0; i < this.elements.length; i++) {
      const c = this.elements[i];
      let title = Utils.format(c.querySelector('h2').innerHTML);
      if (!title.includes(v)) {
        c.classList.add('hiddenS');
      } else {
        c.classList.remove('hiddenS');
      }
    }
  }
}
