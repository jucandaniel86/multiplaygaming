//const
import {__initGameHoverEffect} from "./Games.js";

const GAME_SEARCH_QUERY = '[data-type="games"]';
const GAME_SEARCH_CATEGORY = '#category_id';
const GAME_SEARCH_FEATURES = 'input[name=filter--game_features]';
const GAME_SEARCH_CATEGORIES = 'input[name=filter--game_type]';
const GAME_SORT_BY = "input[name=game_sort_by]";
const GAME_TEMPLATE_ID = "#game-item__template";
const GAME_LIST = "#game__list";
const GAME_NO_RESULTS = "#article-no-results";

const renderGame = (_data) => {
  const $wrapper = $(GAME_LIST);
  const $noResults = $(GAME_NO_RESULTS);
  const $template = document.querySelector(GAME_TEMPLATE_ID);

  //display no results message
  if (!Array.isArray(_data) || _data.length === 0) {
    $wrapper.hide();
    $noResults.css('opacity', 1).show();
    return false;
  }

  //display results
  $wrapper.html('');
  $wrapper.show();
  $noResults.css('opacity', 0);

  //create items template
  _data.forEach(_item => {
    let item = $template.content.cloneNode(true);

    if (_item.category) {
      item.querySelectorAll('.game__category')
        .forEach(el => el.innerHTML = (_item.category.name));
    }

    if (_item.thumbnail_url) {
      item.querySelectorAll('.game__thumbnail.img_small-card')
        .forEach(el => {
          el.setAttribute('alt', _item.game_name);
          el.setAttribute('src', _item.thumbnail_url);
        });
    }

    if (_item.thumbnail_small_url) {
      item.querySelectorAll('.game__thumbnail.img_large-card')
        .forEach(el => {
          el.setAttribute('alt', _item.game_name);
          el.setAttribute('src', _item.thumbnail_small_url);
        });
    }

    if (_item.demo_url) {
      item.querySelectorAll('.game__demo_url').forEach(el => {
        el.setAttribute('title', _item.game_name);
        el.setAttribute('href', _item.demo_url);
        el.style.display = 'block';
      })
    } else {
      item.querySelectorAll('.game__demo_url').forEach(el => {
        el.style.display = 'none';
      })
    }

    item.querySelector('.game__is_branded').style.display = _item.is_branded ? 'block' : 'none';
    item.querySelector('.game__is_coming_soon').style.display = _item.is_coming_soon ? 'block' : 'none';

    item.querySelectorAll('.game__name').forEach(el => el.innerHTML = _item.game_name);

    Array.from(item.querySelectorAll('.game__url')).forEach(el => {
      el.setAttribute('href', `${baseURL}game/${_item.slug}`);
      el.setAttribute('title', _item.game_name);
    });

    $wrapper.append(item);
  });
  //init hover effect
  __initGameHoverEffect();
}

const filterGames = async () => {
  let _DataFilter = {};
  if (String($(GAME_SEARCH_QUERY).val()).length > 2) {
    _DataFilter.search = String($(GAME_SEARCH_QUERY).val());
  }
  if (typeof $(GAME_SORT_BY).val() !== "undefined" && String($(GAME_SORT_BY + ":checked").val()) !== "") {
    _DataFilter.sort_by = String($(GAME_SORT_BY + ":checked").val());
  }

  if (typeof $(GAME_SEARCH_CATEGORY).val() !== "undefined" && !isNaN($(GAME_SEARCH_CATEGORY).val())) {
    _DataFilter.category_id = parseInt($(GAME_SEARCH_CATEGORY).val());
  }

  if ($(GAME_SEARCH_FEATURES).length > 0) {
    let _tmpFeatures = [];
    $(`${GAME_SEARCH_FEATURES}:checked`).each(function () {
      _tmpFeatures.push(parseInt($(this).val()));
    });
    _DataFilter.features = _tmpFeatures;
  }

  if ($(GAME_SEARCH_CATEGORIES).length > 0) {
    let _tmpCategories = [];
    $(`${GAME_SEARCH_CATEGORIES}:checked`).each(function () {
      _tmpCategories.push(parseInt($(this).val()));
    });
    _DataFilter.categories = _tmpCategories;
  }

  try {
    const {data} = await axios(`${baseURL}api/games-filter`, {
      method: 'GET',
      params: _DataFilter
    });

    if (data.success) {
      renderGame(data.data.items);
    }
  } catch (err) {
    console.warn('[[GameController::err]]', err);
  }
}

export const __initGameFilters = () => {
  $(GAME_SEARCH_QUERY).on('keyup', filterGames);
  $(GAME_SORT_BY).on('change', filterGames);
  $(GAME_SEARCH_FEATURES).on('change', filterGames);
  $(GAME_SEARCH_CATEGORIES).on('change', filterGames);
}
