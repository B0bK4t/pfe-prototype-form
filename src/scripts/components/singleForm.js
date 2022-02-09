export default class SingleForm {
  constructor(element) {
    this.element = element;
    this.edit = this.element.querySelector('.edit');
    this.close = this.element.querySelector('.close');
    this.parent = this.element.parentElement;

    this.init();
  }

  init() {
    this.edit.addEventListener('click', this.editMode.bind(this));
    this.close.addEventListener('click', this.closeEdit.bind(this));
  }

  editMode() {
    this.parent.classList.add('is-editing');
  }

  closeEdit() {
    this.parent.classList.remove('is-editing');
  }
}
