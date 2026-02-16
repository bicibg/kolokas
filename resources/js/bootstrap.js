/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs.
 */

import Popper from 'popper.js';
import $ from 'jquery';

window.Popper = Popper;
window.$ = window.jQuery = $;

import 'bootstrap';
