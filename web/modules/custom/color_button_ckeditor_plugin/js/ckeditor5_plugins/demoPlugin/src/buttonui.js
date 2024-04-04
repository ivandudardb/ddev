import { Plugin } from 'ckeditor5/src/core';
import { ButtonView } from 'ckeditor5/src/ui';
import icon from '../../../../icons/simpleBox.svg';
import Buttonview from './buttonview';

export default class Buttonui extends Plugin {

  init() {
    const editor = this.editor;
    const defaultColor = editor.config.get('default_color');

    editor.ui.componentFactory.add('linkPlugin', (locale) => {
      const command = editor.commands.get('insertLinkPlugin');
      const buttonView = new ButtonView(locale);

      buttonView.set({
        label: editor.t('Styled link'),
        tooltip: true,
        icon: icon,
      });

      buttonView.bind('isOn', 'isEnabled').to(command, 'value', 'isEnabled');

      this.listenTo(buttonView, 'execute', () => {
        const linkPluginView = new Buttonview(editor, defaultColor);
        linkPluginView.openModal();
      });

      return buttonView;
    });
  }
}
