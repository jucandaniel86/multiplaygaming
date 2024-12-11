import pkg from "./package.json";
console.log(process.env.PASSPORT_CLIENT_ID);
export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: process.env.APP_NAME,
    htmlAttrs: {
      lang: "en",
    },
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      { hid: "description", name: "description", content: "" },
      { name: "format-detection", content: "telephone=no" },
    ],
    link: [
      { rel: "icon", type: "image/x-icon", href: "/favicon.ico" },
      { rel: "preconnect", href: "https://fonts.gstatic.com" },
      {
        rel: "stylesheet",
        href: "https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap",
      },
      {
        rel: "stylesheet",
        href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css",
      },
      {
        rel: "stylesheet",
        href: "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css",
      },
    ],
  },

  publicRuntimeConfig: {
    // API_URL: process.env.API_URL,
    // LOGIN_URL: process.env.LOGIN_URL,
    APP_ENV: process.env.APP_ENV,
    APP_NAME: process.env.APP_NAME,
    CLIENT_VERSION: pkg.version,
    FRONTEND_ENDPOINT: process.env.FRONTEND_ENDPOINT,
    passport: {
      clientID: process.env.PASSPORT_CLIENT_ID,
      clientSecret: process.env.PASSPORT_CLIENT_SECRET,
      clientGrantType: process.env.PASSPORT_CLIENT_GRANT_TYPE,
    },
  },

  vuetify: {
    optionsPath: "./vuetify.options.js",
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    "@/assets/css/bootstrap.min.css",
    "@/assets/css/dashicons.min.css",
    "@/assets/css/style.css",
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    { src: "~plugins/toaster.js" },
    { src: "~plugins/alerts.js" },
    { src: "./plugins/log" },
    { src: "./plugins/vuetify.js" },
    { src: "./plugins/modal.js" },
    { src: "./plugins/datetimepicker.js" },
    { src: "~plugins/vue-ck-editor.js", mode: "client" },
    { src: "./plugins/prism.js" },
    { src: "./plugins/apex.js" },
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: ["@nuxtjs/vuetify"],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    "@nuxtjs/axios",
    "@nuxtjs/auth-next",
    "nuxt-sweetalert2",
    "@pinia/nuxt",
  ],

  async rewrites() {
    return [
      {
        source: "/",
        destination: "/html/theme/index.html",
      },
    ];
  },

  auth: {
    watchLoggedIn: true,
    plugins: ["~/plugins/permissions.js"],
    localStorage: {
      prefix: "auth.",
    },

    redirect: {
      login: "/auth/login",
      logout: "/auth/login",
      home: "/dashboard",
    },

    strategies: {
      local: {
        endpoints: {
          login: {
            url: `${process.env.PASSPORT_URL}/api/login`,
          },
          user: {
            url: `${process.env.PASSPORT_URL}/api/user`,
            method: "get",
            property: "DATA",
            autoFetch: true,
          },
          logout: {
            url: `${process.env.PASSPORT_URL}/api/logout`,
          },
        },
        token: {
          property: "token",
          global: true,
          tokenType: "",
          maxAge: 60 * 60,
        },
        tokenRequired: true,
        tokenType: "",
      },
    },
  },

  axios: {
    baseURL: process.env.API_URL,
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {},
};
