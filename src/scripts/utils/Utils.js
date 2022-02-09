/** Classe utilitaires statiques (pas besoin d'instancier cette classe) */
export default class Utils {
  /**
   * Retourne un string où les valeurs spécifiées ont été remplacées
   * @param {string} content - texte contenant les éléments à remplacer entourées par {{}}
   * @param {object} data - Clés / valeurs à chercher et à remplacer
   * @return {string} Retourne le contenu avec les clés remplacées
   */
  static parseTemplate(content, data) {
    for (const key in data) {
      const regex = new RegExp(`\{\{${key}\}\}`, 'gi');
      content = content.replace(regex, data[key]);
    }

    return content;
  }

  static format(string) {
    let str = string;
    str = str.toLowerCase();
    str = str.replaceAll('’', "'");
    str = str.replaceAll('à', 'a');
    str = str.replaceAll('â', 'a');
    str = str.replaceAll('é', 'e');
    str = str.replaceAll('è', 'e');
    str = str.replaceAll('ë', 'e');
    str = str.replaceAll('ê', 'e');
    str = str.replaceAll('ù', 'u');
    str = str.replaceAll('ö', 'o');
    str = str.replaceAll('-', '');
    str = str.replaceAll('œ', 'oe');
    return str;
  }

  static removeFromArray(array, value) {
    array.splice(array.indexOf(value), 1);
  }
}
