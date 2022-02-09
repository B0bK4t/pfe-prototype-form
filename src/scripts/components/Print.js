export default class Print {
  constructor(element) {
    this.element = element;
    this.button = this.element.querySelector('.button');
    this.iframe = document.createElement('iframe');
    this.init();
  }

  init() {
    if (this.button != null) {
      this.button.addEventListener('click', this.createIFrame.bind(this));
    }
  }

  createIFrame(event) {
    event.preventDefault();
    this.iframe.style.height = 0;
    this.iframe.style.width = 0;
    this.iframe.style.visibility = 'hidden';
    this.iframe.setAttribute('srcdoc', '<html><body></body></html>');
    this.iframe.addEventListener('load', this.copyImg.bind(this));
    this.iframe.addEventListener('afterprint', this.clearIFrame.bind(this));
    this.iframe.addEventListener('onclose', this.clearIFrame.bind(this));
    this.element.appendChild(this.iframe);
  }

  copyImg() {
    const image = document.getElementById('carte').cloneNode();
    image.style.maxWidth = '100%';
    const body = this.iframe.contentDocument.body;
    body.style.textAlign = 'center';
    body.appendChild(image);

    image.addEventListener('load', this.printImg.bind(this));
  }

  printImg() {
    this.iframe.contentWindow.print();
  }

  clearIFrame() {
    this.iframe.parentNode.removeChild(this.iframe);
  }
}
