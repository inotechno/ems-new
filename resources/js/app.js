import './bootstrap';
import 'alpinejs';
import { htmlEditButton } from 'quill-html-edit-button';
import Quill from 'quill';

Quill.register('modules/htmlEditButton', htmlEditButton);

window.Quill = Quill;
