import Utils from './../utils/Utils';

export default class Modal {
  constructor(element) {
    this.element = element;
    this.modalId = this.element.dataset.modalId;
    this.init();
  }

  init() {
    this.element.addEventListener('click', this.open.bind(this));
    this.close = this.close.bind(this);
  }

  updateContent() {
    if (this.modalId == 'tpl-modal-ajout') {
      this.modalElement.innerHTML = Utils.parseTemplate(this.modalElement.innerHTML, {
        title: this.element.dataset.modalTitle,
      });
    }
  }

  open(event) {
    event.preventDefault();
    this.appendModal();
  }

  close(event) {
    if (event.type == 'click' || event.code == 'Escape') {
      window.removeEventListener('keydown', this.close);
      document.documentElement.classList.remove('modal-is-active');
      document.documentElement.classList.remove('inProgress');
      this.closeButton.removeEventListener('click', this.close);
      setTimeout(this.destroy.bind(this), 1000);
    }
  }

  destroy() {
    this.modalElement.parentElement.removeChild(this.modalElement);
  }

  appendModal() {
    const template = document.querySelector(`#${this.modalId}`);
    if (template) {
      this.modalElement = template.content.firstElementChild.cloneNode(true);
      this.updateContent();
      document.body.appendChild(this.modalElement);
      this.element.getBoundingClientRect();
      document.documentElement.classList.add('modal-is-active');
      document.documentElement.classList.add('inProgress');
      this.closeButton = this.modalElement.querySelector('.js-close');
      this.closeButton.addEventListener('click', this.close);
      window.addEventListener('keydown', this.close);
    } else {
      console.log(`Le <template> avec le id ${this.modalId} n'existe pas`);
    }
  }
}
