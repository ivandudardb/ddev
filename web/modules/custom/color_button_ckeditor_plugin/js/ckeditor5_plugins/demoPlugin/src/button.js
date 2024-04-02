import Buttonediting from './buttonediting';
import Buttonui from './buttonui';
import { Plugin } from 'ckeditor5/src/core';

export default class Button extends Plugin {
  static get requires() {
    return [Buttonediting, Buttonui];
  }
}
