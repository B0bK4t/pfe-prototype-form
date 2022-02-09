export default class Notif {
  constructor(element) {
    this.element = element;
    this.close = this.element.querySelector('.close');

    this.init();
  }

  init() {
    this.close.addEventListener('click', this.closeF.bind(this));
  }

  closeF() {
    this.element.parentElement.removeChild(this.element);
  }
}
