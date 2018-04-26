import './main.scss';

// custom js
import * as Utils from './home/video/index';

// libs
import domready from 'domready';

domready(() => {
  Utils.player();
});
