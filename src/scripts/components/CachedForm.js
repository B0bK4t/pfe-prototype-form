import Cache from '../utils/Cache';
export default class CachedForm {
  constructor(element) {
    this.element = element;
    this.step = this.element.dataset.step;
    this.cacheN = `saved-form-${this.element.dataset.id}`;

    if (this.step == 'Origin') {
      this.title = this.element.querySelector('#title');
      this.content = this.element.querySelector('#content');
      this.catSection = this.element.querySelector('.cats');
      this.categories = this.catSection.querySelectorAll('input');
      this.origin = this.element.querySelector('#origin');
      this.mat = this.element.querySelector('#mat');

      this.add = this.element.querySelectorAll('.js-click');

      this.submit = this.element.querySelector('#submit');
    } else if (this.step == 'Target') {
      this.button = document.querySelector('#button');
    }

    this.protocol = this.element.querySelector('#protocol');
    this.url = this.element.querySelector('#url').value;
    this.url = this.url.split('?')[0];

    this.returnURL = '';

    this.init();
  }

  init() {
    if (this.step == 'Origin') {
      for (let i = 0; i < this.add.length; i++) {
        const a = this.add[i];
        a.addEventListener('click', this.cacheAndSend.bind(this));
      }
      this.submit.addEventListener('click', this.clearAll.bind(this));
      if (Cache.get(this.cacheN) == undefined) {
        let inputs = [this.title, this.content, this.origin, this.mat];
        for (let i = 0; i < inputs.length; i++) {
          const p = inputs[i];
          p.value = '';
        }
        for (let i = 0; i < this.categories.length; i++) {
          const c = this.categories[i];
          c.checked = false;
        }
      }
    } else if (this.step == 'Target') {
      const data = Cache.get(this.cacheN);
      if (data != undefined) {
        this.button.innerHTML = 'Retour';
        this.button.setAttribute('href', `${data}`);
      }
    }
  }

  cacheAndSend(e) {
    let catPart = '';
    for (let i = 0; i < this.categories.length; i++) {
      const c = this.categories[i];
      if (c.checked) {
        catPart += `${c.dataset.name.replaceAll(' ', '_').replaceAll(',', '|')},`;
      }
    }
    this.returnURL = `${this.url}?title=${this.title.value}&content=${this.content.value}&cats=${catPart}&origin=${this.origin.value}&mat=${this.mat.value}`;
    Cache.set(this.cacheN, this.returnURL, true);
  }

  clearAll(e) {
    Cache.remove(this.cacheN);
  }
}
