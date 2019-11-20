import $ from 'jquery';
import { expandableItem, toogleNav } from './modules/sidebar/sidebar';
import 'bootstrap/js/dist/alert';
__webpack_public_path__ = `${window.location.protocol}//${window.location.host}/dist/`;
const alertClose = document.querySelector('.alert-close');

toogleNav();
expandableItem(document.querySelectorAll('.must-expand'));

if (alert !== null) {
  alertClose.addEventListener('click', (e) => {
    e.target.closest('.animated').classList.add('zoomOut');
  });
}

// Load draft js
if (document.querySelectorAll('.draftjs').length > 0) {
  import(/* webpackChunkName: "draft" */ './modules/draft/draft.jsx');
}

// Load the image uploader
if (document.querySelector('#dropzone') !== null) {
  import(/* webpackChunkName: "dropzone" */ './modules/dropzone/dropzone').then((DropzoneMiddleware) => {
    window.dropzone = new DropzoneMiddleware.default('#dropzone');
  });
}

// Load the preventDelete modal
if (document.querySelectorAll('.modalOpener').length > 0) {
  import(/* webpackChunkName: "preventDelete" */ './modules/preventDelete/preventDelete').then((module) => {
    module.preventDelete();
  });
}

// Load the map loader
if (document.querySelector('.loadMap') !== null) {
  import(/* webpackChunkName: "loadmap" */ './modules/loadmap/loadmap').then((module) => {
    module.loadmap(document.querySelector('.loadMap'));
  });
}

// Load multiselect
if (document.querySelectorAll('.multiselect').length > 0) {
  import(/* webpackChunkName: "multiselect" */ './modules/multiselect/multiselect').then((module) => {
    module.multiselect(document.querySelectorAll('.multiselect'));
  });
}

// Sortable
if (document.querySelector('.sortable') !== null) {
  import(/* webpackChunkName: "sortable" */ './modules/sortable/sortable').then((module) => {
    module.sortable(document.querySelector('.sortable'));
    module.update(document.querySelector('.sortable-update'));
  });
}

// Product to url
if (document.querySelector('#products') !== null) {
  import(/* webpackChunkName: "urlSelect" */ './modules/urlSelect/urlSelect').then((module) => {
    module.urlSelect(document.querySelector('#products'));
  });
}

window.$ = $;