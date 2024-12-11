export const __initCarousel = () => {
  const $parent = $('.slider_gallery');
  if (!$parent.length) return;

  let leftArrow = $parent.find('.w-slider-arrow-left');
  let rightArrow = $parent.find('.w-slider-arrow-right');
  let dots = $parent.find('.w-slider-dot');
  let currentSlide = 0;
  let totalSlides = $('.w-slide').length;

  const moveRight = () => {
    if (currentSlide >= totalSlides - 1) currentSlide = 0;
    else
      currentSlide++;

    $('.w-slide').each(function () {
      let itemWidth = parseInt($(this).width()) + parseInt($(this).css('margin-right'));

      $(this).css({
        'transition': 'transform 500ms ease-out 0s',
        'transform': `translateX(-${itemWidth * currentSlide}px)`
      });
    });
  }

  const moveLeft = () => {
    if (currentSlide === 0) currentSlide = totalSlides - 1;
    else
      currentSlide--;

    $('.w-slide').each(function () {
      let itemWidth = parseInt($(this).width()) + parseInt($(this).css('margin-right'));

      $(this).css({
        'transition': 'transform 500ms ease-out 0s',
        'transform': `translateX(-${itemWidth * currentSlide}px)`
      });
    });
  }

  const moveDots = (_event) => {
    let currentDot = $(_event.target);
    let currentIndex = currentDot.index();

    dots.removeClass('w-active');
    currentDot.addClass('w-active');

    $('.w-slide').each(function () {
      let itemWidth = parseInt($(this).width()) + parseInt($(this).css('margin-right'));

      $(this).css({
        'transition': 'transform 500ms ease-out 0s',
        'transform': `translateX(-${itemWidth * currentIndex}px)`
      });
    });

  }

  leftArrow.on('click', () => moveLeft());
  rightArrow.on('click', () => moveRight());
  dots.on('click', (e) => moveDots(e))

}
