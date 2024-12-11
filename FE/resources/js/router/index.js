import {createRouter, createWebHistory} from "vue-router";

import Home from '../pages/home';
//Slots
import Slots from '../pages/slots';
import Roadmap from '../pages/slots/roadmap';
import MediaPack from '../pages/slots/mediapack';
import Game from '../pages/slots/game_page';

//Promotions
import Tools from '../pages/promotions/tools';
import Promotions from '../pages/promotions/promotions';
import PromotionsPage from '../pages/promotions/promotion_page';

//Brand Assets
import BrandAssets from '../pages/brands/brand-assets';
import GameAssets from '../pages/brands/game-assets';
import MediaAssets from '../pages/brands/media-assets';

//Support
import Support from '../pages/support';

//Compliance
import Compliance from '../pages/compliance';

//My Account
import Account from '../pages/account'

const routes = [
  {
    path: '/client-area/',
    name: 'ca.index',
    component: Home
  },
  {
    path: '/client-area/slots/game-library',
    name: 'ca.slots.games',
    component: Slots
  },
  {
    path: '/client-area/slots/road-map',
    name: 'ca.slots.roadmap',
    component: Roadmap
  },
  {
    path: '/client-area/slots/media-pack',
    name: 'ca.slots.mediapack',
    component: MediaPack
  },
  {
    path: '/client-area/game/:slug',
    name: 'ca.slots.game_page',
    component: Game
  },
  {
    path: '/client-area/promotions',
    name: 'ca.promotions',
    component: Promotions
  },
  {
    path: '/client-area/promotions/:slug',
    name: 'ca.promotions.single',
    component: PromotionsPage
  },
  {
    path: '/client-area/promotions/tools',
    name: 'ca.promotions.tools',
    component: Tools
  },
  {
    path: '/client-area/support',
    name: 'ca.support',
    component: Support
  },
  {
    path: '/client-area/compliance',
    name: 'ca.compliance',
    component: Compliance
  },
  {
    path: '/client-area/brand-assets',
    name: 'ca.brands.assets',
    component: BrandAssets
  },
  {
    path: '/client-area/game-assets',
    name: 'ca.brands.games',
    component: GameAssets
  },
  {
    path: '/client-area/promo-media-pack',
    name: 'ca.brands.media',
    component: MediaAssets
  },

  {
    path: '/client-area/my-account',
    name: 'ca.account',
    component: Account
  },
]

export default createRouter({
  history: createWebHistory(),
  routes
})
