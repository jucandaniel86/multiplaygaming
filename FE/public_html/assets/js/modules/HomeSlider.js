const HOME_SLIDER_WRAPPER = ".swiper-wrapper";
const HOME_SLIDER_ITEM = ".collection-item_hero-home ";
const HOME_SLIDER_BULLET = ".swiper-pagination-bullet";
const HOME_SLIDER_BULLET_ACTIVE = "swiper-pagination-bullet-active";
const HOME_SLIDER_PREV_BUT = ".swiper-button_prev";
const HOME_SLIDER_NEXT_BUT = ".swiper-button_next";

let currentItem = 0;

const resizeSliderItems = () => {
  const wrapperWidth = parseFloat($(HOME_SLIDER_WRAPPER).width()).toFixed(2);

  $(HOME_SLIDER_ITEM).each(function (key, item) {
    $(this).css({
      width: `${wrapperWidth}px`,
      opacity: key === 0 ? 1 : 0,
      zIndex: key === 0 ? 1 : 0,
      transform: `translate3d(-${wrapperWidth * key}px, 0px, 0px)`
    })
  })
}

const changeOnBullet = (_event) => {
  const bullet = $(_event.target);
  currentItem = parseInt(bullet.data('id'));

  animateToID(currentItem);
}

const animateToID = (id) => {
  if (typeof id !== "undefined") {

    $(HOME_SLIDER_BULLET).removeClass(HOME_SLIDER_BULLET_ACTIVE);
    $(HOME_SLIDER_BULLET).eq(id).addClass(HOME_SLIDER_BULLET_ACTIVE);

    $(HOME_SLIDER_ITEM).animate({
      opacity: 0,
    }, 300, function () {
      $(`${HOME_SLIDER_ITEM}`).eq(id).animate({
        opacity: 1,
        zIndex: 1,
      }, 300)
    })
  }
}

const movePrev = () => {
  let total = ($(HOME_SLIDER_ITEM).length - 1);
  if (currentItem === 0) currentItem = total;
  else currentItem--;

  animateToID(currentItem);
}

const moveNext = () => {
  let total = ($(HOME_SLIDER_ITEM).length - 1);
  if (currentItem >= total) currentItem = 0;
  else currentItem++;

  animateToID(currentItem);
}

export const __initHomeslider = () => {
  resizeSliderItems();

  $(window).on('resize', resizeSliderItems);
  $(HOME_SLIDER_BULLET).on('click', changeOnBullet);
  $(HOME_SLIDER_PREV_BUT).on('click', movePrev);
  $(HOME_SLIDER_NEXT_BUT).on('click', moveNext);
}
