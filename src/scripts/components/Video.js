/** Componsante Video de TimTools */
export default class Video {
  /**
   * Méthode constructeur
   * @param {HTMLElement} element - Élément HTML sur lequel la composante est instanciée
   */
  constructor(element) {
    this.element = element;
    this.videoContainer = this.element.querySelector('.js-video');
    this.poster = this.element.querySelector('.js-poster');
    this.videoId = this.element.dataset.videoId;
    this.autoplay = this.poster ? 1 : 0; //Si poster autoplay est vrai, sinon faux
    this.playerReady = false;

    //Ajouter l'instance au tableau des instances
    Video.instances.push(this);

    //Vérifier s'il y a un ID de vidéo
    if (this.videoId) {
      Video.loadScript();
    } else {
      console.log('Vous devez spécifier un ID');
    }
  }

  /**
   * Méthode pour charger le script de l'API YouTube une seule fois
   */
  static loadScript() {
    if (!Video.scriptIsLoading) {
      Video.scriptIsLoading = true;
      const script = document.createElement('script');
      script.src = 'https://www.youtube.com/iframe_api';
      document.body.appendChild(script);
    }
  }

  /**
   * Méthode d'initialisation
   */
  init() {
    this.initPlayer = this.initPlayer.bind(this);

    //Ajouter un événement click sur l'image s'il y en a une, sinon l'ajouter sur le player YouTube
    if (this.poster) {
      this.element.addEventListener('click', this.initPlayer);
    } else {
      this.initPlayer();
    }
  }

  /**
   * Méthode d'initialisation après clic
   * @param {event} event Événement lié au clic
   */
  initPlayer(event) {
    if (event) {
      this.element.removeEventListener('click', this.initPlayer);
    }

    //Création d'un player youtube
    this.player = new YT.Player(this.videoContainer, {
      videoId: this.videoId,
      height: '100%',
      width: '100%',
      playerVars: {
        rel: 0, //0 pour donner des suggestions liées à la vidéo
        autoplay: this.autoplay, //Activer l'autoplay
      },
      events: {
        onReady: () => {
          this.playerReady = true;
          const observer = new IntersectionObserver(this.watch.bind(this), {
            rootMargin: '0px 0px 0px 0px',
          });
          observer.observe(this.element);
        },
        onStateChange: (event) => {
          if (event.data == YT.PlayerState.PLAYING) {
            Video.pauseAll(this);
          } else if (event.data == YT.PlayerState.ENDED) {
            this.player.seekTo(0);
            this.player.pauseVideo();
          }
        },
      },
    });
  }
  /**
   * Méthode d'observation du document
   * @param {array} entries Tableau des players observés
   */
  watch(entries) {
    if (this.playerReady && !entries[0].isIntersecting) {
      this.player.pauseVideo();
    }
  }

  /**
   * Méthode d'initialisation générale
   */
  static initAll() {
    document.documentElement.classList.add('is-video-ready');

    for (let i = 0; i < Video.instances.length; i++) {
      const instance = Video.instances[i];
      instance.init();
    }
  }

  /**
   * Méthode d'observation du document
   * @param {object} currentInstance Tableau des players observés
   */
  static pauseAll(currentInstance) {
    for (let i = 0; i < Video.instances.length; i++) {
      const instance = Video.instances[i];
      if (instance.playerReady && instance !== currentInstance) {
        instance.player.pauseVideo();
      }
    }
  }
}

Video.instances = []; //Instances de players

window.onYouTubeIframeAPIReady = Video.initAll; //Appeller fonction initiale
