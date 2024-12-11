const OPEN_CLASS = 'w--open';
const GAME_FILTERS = ".w-dropdown"
const DROPDOWN_LIST = ".w-dropdown-list";
const DROPDOWN_COUNTER = ".filter_num-wrap";
const TABLET_RES = 767;

const isMobile = () => window.innerWidth <= TABLET_RES;

function handleCheckboxClick(_event) {
  let _checkbox = _event.target;
  if (_checkbox.checked) {
    $(_event.target).parent().find('.checkbox_filter').addClass('w--redirected-checked');
  } else {
    $(_event.target).parent().find('.checkbox_filter').removeClass('w--redirected-checked');
  }
}

function countCheckedItems(_total, _wrap) {
  if (_total > 0) {
    $(_wrap).find(DROPDOWN_COUNTER).show().html(_total);
  } else {
    $(_wrap).find(DROPDOWN_COUNTER).hide().html(0);
  }
}

export const makeID = (length) => {
  let result = '';
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const charactersLength = characters.length;
  let counter = 0;
  while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    counter += 1;
  }
  return result;
}

export const __initFilters = () => {
  let _filters = $(GAME_FILTERS);
  if (_filters.length === 0) return false;

  _filters.each(function () {
    $(this).attr('id', makeID(20));
    var _dd = $(this).find(DROPDOWN_LIST);
    var _wrap = this;

    $(this).click(function (event) {
      event.stopPropagation();
    });

    $(this).find('.w-dropdown-toggle').on('click touch', function (e) {
      closeOpenedMenus();

      _dd.toggleClass(OPEN_CLASS);
      $(e.currentTarget).parent().toggleClass(OPEN_CLASS);
      $(e.currentTarget).toggleClass(OPEN_CLASS);
    });

    $(this).find('.navbar_link').on('click tap touchstart', function (e) {
      closeOpenedMenus();

      _dd.toggleClass(OPEN_CLASS);
      $(e.currentTarget).parent().toggleClass(OPEN_CLASS);
      $(e.currentTarget).toggleClass(OPEN_CLASS);
    });

    $(this).find('input').each(function () {
      $(this).on('change', function (e) {
        handleCheckboxClick(e);
        countCheckedItems(_dd.find('input:checked').length, _wrap);
      });
    });
  });
}

const closeOpenedMenus = () => {
  if (isMobile()) return;
  if (document.querySelector(`${GAME_FILTERS}.${OPEN_CLASS}`)) {
    let _el = document.querySelector(`${GAME_FILTERS}.${OPEN_CLASS}`);

    _el.classList.remove(OPEN_CLASS);
    _el.querySelector(`.w-dropdown-toggle`).classList.remove(OPEN_CLASS)
    _el.querySelector(DROPDOWN_LIST).classList.remove(OPEN_CLASS)
  }
}

export const __initClickOutside = () => {
  window.addEventListener('click', function (e) {
    if (
      document.querySelector(`${GAME_FILTERS}.${OPEN_CLASS}`) &&
      document.querySelector(`${GAME_FILTERS}.${OPEN_CLASS}`).contains(e.target)) {
    } else {
      closeOpenedMenus();
    }
  });
}
