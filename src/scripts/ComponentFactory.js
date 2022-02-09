// import Carousel from './components/Carousel';
import Hide from './components/Hide';
import Filter from './components/Filter';
import Modal from './components/Modal';
import Header from './components/Header';
import Form from './components/Form';
import Categories from './components/Categories';
import CachedForm from './components/CachedForm';
import Notif from './components/Notif';
import singleForm from './components/singleForm';
import Print from './components/Print';
import Video from './components/Video';

export default class ComponentFactory {
  constructor() {
    this.componentInstances = [];
    this.componentList = {
      // Carousel,
      Hide,
      Filter,
      Modal,
      Header,
      Categories,
      CachedForm,
      Form,
      Notif,
      singleForm,
      Video,
      Print,
    };
    this.init();
  }

  init() {
    const components = document.querySelectorAll('[data-component]');

    for (let i = 0; i < components.length; i++) {
      const element = components[i];
      const componentName = element.dataset.component;

      if (this.componentList[componentName]) {
        const instance = new this.componentList[componentName](element);
        this.componentInstances.push(instance);
      } else {
        console.log(`La composante ${componentName} n'existe pas`);
      }
    }
  }
}
