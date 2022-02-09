import ComponentFactory from './ComponentFactory';
import Icons from './utils/Icons';

class Main {
  constructor() {
    this.init();
  }

  init() {
    document.documentElement.classList.add('has-js');

    new ComponentFactory();

    let siteLocation = window.location;
    siteLocation = siteLocation.toString().split('pfe')[0];
    siteLocation += '/pfe/wp-content/themes/pfe/dist/assets/icons.svg';

    Icons.load(siteLocation);
  }
}
new Main();
