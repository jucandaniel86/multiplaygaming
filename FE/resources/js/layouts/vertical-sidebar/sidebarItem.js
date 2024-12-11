import {
  CircleIcon,
  DeviceGamepad2Icon,
  Certificate2Icon,
  AdCircleIcon,
  BrandFinderIcon,
  UserIcon,
  KeyIcon,
  BugIcon,
  DashboardIcon,
  BrandChromeIcon,
  HelpIcon,
} from 'vue-tabler-icons';
import {baseURL} from "../../config";

const sidebarItem = [
  {divider: true},
  {header: 'Client Area'},
  {
    title: 'Dashboard',
    icon: DashboardIcon,
    to: '/client-area'
  },
  {
    title: 'Slots',
    icon: DeviceGamepad2Icon,
    to: '/',
    children: [
      {
        title: 'Game Library',
        icon: CircleIcon,
        to: '/client-area/slots/game-library'
      },
      {
        title: 'Road Map',
        icon: CircleIcon,
        to: '/client-area/slots/road-map'
      },
      {
        title: 'Media Pack',
        icon: CircleIcon,
        to: '/client-area/slots/media-pack'
      },
    ]
  },
  {
    title: 'Promotions',
    icon: AdCircleIcon,
    to: '/auth',
    children: [
      {
        title: 'Enhance Promo Tools',
        icon: CircleIcon,
        to: '/client-area/promotions/tools'
      },
      // {
      //   title: 'Network Promotions',
      //   icon: CircleIcon,
      //   to: '/client-area/promotions'
      // },
    ]
  },

  {
    title: 'Brand Assets',
    icon: BrandFinderIcon,
    to: '/auth',
    children: [
      {
        title: 'Brand Assets',
        icon: CircleIcon,
        to: '/client-area/brand-assets'
      },
      {
        title: 'General Game Assets',
        icon: CircleIcon,
        to: '/client-area/game-assets'
      },
      {
        title: 'Promo media pack assets',
        icon: CircleIcon,
        to: '/client-area/promo-media-pack'
      }
    ]
  },

  {
    title: 'Compliance',
    icon: Certificate2Icon,
    to: '/client-area/compliance',
  },

  {
    title: 'Support',
    icon: HelpIcon,
    to: '/client-area/support',
  },

  {
    title: 'My Account',
    icon: UserIcon,
    to: '/client-area/my-account',
  },
  {
    title: 'Logout',
    icon: CircleIcon,
    type: 'external',
    to: baseURL + '/logout'
  },
];

export default sidebarItem;
