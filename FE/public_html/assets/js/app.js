import {__initFileUpload} from "./modules/FileUpload.js";

const v = new Date().getTime();

import {__initMenu} from "./modules/Menu.js";
import {__initClickOutside, __initFilters} from "./modules/Filters.js";
import {__initGameExpandDescription, __initGameHoverEffect, __initSort} from "./modules/Games.js";
import {__initParalax} from "./modules/Paralax.js";
import {__initCarousel} from "./modules/Carousel.js?v=1";
import {__initGameTabs} from "./modules/GameTabs.js";
import {__initArticleFilters} from "./modules/ArticlesFilter.js";
import {__initJobFilters} from "./modules/JobsFilter.js";
import {__initCheckboxses, __initNewsletter} from "./modules/Newsletter.js";
import {__initPrivacy} from "./modules/Privacy.js";
import {__initGameFilters} from './modules/GamesFilter.js'
import {__initAnnounce} from './modules/Announce.js?v=11';
import {__initPlus18Popup} from "./modules/Plus18.js";
import {__initHomeslider} from "./modules/HomeSlider.js?v=1";

const __init = () => {
  __initMenu();
  __initFilters();
  __initGameHoverEffect();
  __initParalax();
  __initSort();
  __initGameExpandDescription();
  __initCarousel();
  __initGameTabs();
  __initArticleFilters();
  __initJobFilters();
  __initCheckboxses();
  __initPrivacy();
  __initNewsletter();
  __initGameFilters();
  __initClickOutside();
  __initAnnounce();
  __initPlus18Popup();
  __initFileUpload();
  __initHomeslider();
}

addEventListener("DOMContentLoaded", (event) => __init());
