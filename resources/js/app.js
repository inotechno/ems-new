import './bootstrap';
import 'alpinejs';
import { htmlEditButton } from 'quill-html-edit-button';
import Quill from 'quill';
import "@sjmc11/tourguidejs/src/scss/tour.scss";
import {TourGuideClient} from "@sjmc11/tourguidejs";

Quill.register('modules/htmlEditButton', htmlEditButton);

window.Quill = Quill;
window.TourGuideClient = TourGuideClient;
