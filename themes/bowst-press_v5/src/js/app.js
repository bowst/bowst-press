/* eslint no-undef: 0 */
// import 'babel-polyfill';

// Pull colors.json into build so webpack watches it; SyncColorsPlugin runs before each compile
import '../data/colors.json';

// Load Styles
import '../scss/globals.scss';

// Bootstrap dependencies
import '@popperjs/core';
import { Alert, Button, Carousel, Collapse, Dropdown, Modal, Popover, Scrollspy, Tab, Toast, Tooltip } from 'bootstrap';

// FontAwesome
import '@fortawesome/fontawesome-free/js/regular';
import '@fortawesome/fontawesome-free/js/solid';
import '@fortawesome/fontawesome-free/js/brands';
import '@fortawesome/fontawesome-free/js/fontawesome';

// Vendor
// import 'magnific-popup/dist/jquery.magnific-popup.min'; // Need to install via NPM

// Custom Scripts
import './scripts';
import './main-nav-controller';
