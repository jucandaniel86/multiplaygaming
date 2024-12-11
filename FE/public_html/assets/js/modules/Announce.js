const BANNER_PROMO_KEY = "hide_banner_promo";
export const __initAnnounce = () => {

  const hideAnnounce = () => {
    $(".banner-promo").hide();
    window.localStorage.setItem(BANNER_PROMO_KEY, true);
  }

  $('.hide_button').on('click', () => hideAnnounce());
  if (!window.localStorage.getItem(BANNER_PROMO_KEY)) {
    $(".banner-promo").show();
  }

}

