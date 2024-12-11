export const __initGameHoverEffect = () => {
  const games = $(".card_games-main");
  if (games.length === 0) return false;

  games.off('hover');
  games.hover(function () {
    $(this).find('.card-hover_game').css({display: 'flex'}).animate({opacity: 1}, 500)
  }, function () {
    $(this).find('.card-hover_game').css({opacity: 0, display: 'none'})
  })
}

export const __initSort = () => {
  $('input[data-id=custom_dropdown]').on('change', (e) => {
    let _c = $(e.target);
    $('.radio_filter').removeClass('active');
    _c.parent().addClass('active');

    let _label = _c.attr('data-label');
    let _icon = _c.attr('data-icon');

    if (_label) {
      $('.sort-select-text').html(_label);
    }

    if (_icon) {
      $('.sort-icon').css('display', 'none');
      switch (_icon) {
        case 'up':
          $('.sort-up').css('display', 'flex');
          break;
        case 'down':
          $('.sort-down').css('display', 'flex');
          break;
      }
    }
  })
}

export const __initGameExpandDescription = () => {
  const _wrapper = $(".component_descriprion-collapse");
  if (_wrapper.length === 0) return false;

  _wrapper.find('a.button').on('click', (e) => {
    e.preventDefault();

    if ($(e.target).parent().hasClass('_more')) {
      $('._hide').removeClass('hide');
      $(e.target).parent().addClass('hide');
      _wrapper.prev().addClass('open');
    }

    if ($(e.target).parent().hasClass('_hide')) {
      $('._more').removeClass('hide');
      $(e.target).parent().addClass('hide');
      _wrapper.prev().removeClass('open');
    }

  })
}
