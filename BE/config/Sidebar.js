export const ADMIN_MENU = [
  {
    label: "Dashboard",
    path: "dashboard",
    icon: "fa fa-tachometer-alt me-2",
    child: [],
    id: "dashboard",
  },

  {
    label: "Games",
    path: null,
    icon: "fas fa-gamepad me-2",
    child: [
      {
        path: "games-add",
        label: "Add new game",
      },
      {
        path: "games",
        label: "Games",
      },
      {
        path: "article-categories",
        label: "Categories",
      },
      {
        path: "features",
        label: "Features",
      },
      {
        path: "mechanics",
        label: "Mechanics",
      },
    ],
    id: "games",
  },
  {
    label: "Articles",
    path: null,
    icon: "far fa-file-alt me-2",
    child: [
      {
        path: "articles",
        label: "Articles",
      },
      {
        path: "article-categories",
        label: "Categories",
      },
    ],
    id: "articles",
  },
  {
    label: "Translations",
    path: "translations",
    icon: "far fa-closed-captioning me-2",
    child: [],
    id: "translations",
  },
  {
    label: "Careers",
    path: null,
    icon: "fas fa-user-secret me-2",
    child: [
      {
        path: "jobs",
        label: "Jobs",
      },
      {
        path: "departments",
        label: "Departments",
      },
    ],
    id: "departments",
  },
  {
    label: "Partners",
    path: "partners",
    icon: "fa fa-star me-2",
    child: [],
    id: "partners",
  },
  {
    label: "Announces",
    path: "announces",
    icon: "fa fa-globe me-2",
    child: [],
    id: "announces",
  },

  {
    label: "Users Administration",
    icon: "far fa-user me-2",
    path: null,
    child: [
      {
        path: "users",
        label: "Users",
      },
      {
        path: "permissions",
        label: "Permissions",
      },
      {
        path: "roles",
        label: "Roles",
      },
    ],
    id: "users",
  },

  {
    label: "Client Area",
    path: null,
    icon: "fas fa-users me-2",
    child: [],
    id: "client_area",
    child: [
      {
        path: "client-area-games",
        label: "Games",
      },
      {
        path: "client-area-banners",
        label: "Banners",
      },
      {
        path: "client-area-brand-assets",
        label: "Brand Assets",
      },
      {
        path: "client-area-jurisdictions",
        label: "Jurisdictions",
      },
    ],
  },
  {
    label: "Reports",
    path: null,
    icon: "fas fa-chart-area me-2",
    child: [],
    id: "reports",
    child: [
      {
        path: "reports-dashboard",
        label: "Dashboard",
      },
      {
        path: "reports-summary",
        label: "Summary",
      },
      {
        path: "reports-games",
        label: "Games",
      },
      {
        path: "reports-players",
        label: "Players",
      },
      {
        path: "reports-sessions",
        label: "Sessions",
      },
      {
        path: "reports-invoices",
        label: "Invoices",
      },
    ],
  },
  {
    label: "Clients",
    path: "clients",
    icon: "fas fa-building me-2",
    child: [],
    id: "clients",
  },
];
