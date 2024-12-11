import {__ApiFetch} from "./ApiFetch.js";

export const formatDate = (_date) => {

  const date = new Date(_date);

  let year = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(date);
  let month = new Intl.DateTimeFormat('en', {month: 'short'}).format(date);
  let day = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(date);

  return `${month} ${day}, ${year}`;
}

const renderArticles = (data) => {
  const $wrapper = $('#article-items-list');
  const $noResults = $('#article-no-results');
  const $template = document.querySelector('#article-item-template');

  //display no results message
  if (!Array.isArray(data) || data.length === 0) {
    $wrapper.hide();
    $noResults.css('opacity', 1);
    return false;
  }

  //display results
  $wrapper.html('');
  $wrapper.show();
  $noResults.css('opacity', 0);

  data.forEach(_item => {
    let item = $template.content.cloneNode(true);
    if (_item.category) {
      item.querySelectorAll('.article-item-category')
        .forEach(el => el.innerHTML = (_item.category.name));
    }

    if (_item.thumbnail) {
      item.querySelectorAll('.img_news')
        .forEach(el => el.style.backgroundImage = `url(${_item.thumbnail})`);

      if ($(".img_compaign").length) {
        $('.img_compaign').attr('src', _item.thumbnail);
      }
    }
    item.querySelectorAll('.article-title').forEach(el => el.innerHTML = _item.title);
    item.querySelector('.link-block-15').href = baseURL + 'articles/' + _item.slug + '/' + _item.id;

    item.querySelectorAll('.article-publish-date')
      .forEach(el => el.innerHTML = formatDate(_item.published_date));

    $wrapper.append(item);
  });
}

const filterArticles = async () => {
  $('.item_games-main').css('opacity', '.6');

  let categories = [];
  if ($('input[name=filter--categories]').length > 0) {
    $('input[name=filter--categories]:checked').each(function () {
      categories.push(parseInt($(this).val()));
    });
  }

  try {
    const data = await __ApiFetch(baseURL + 'api/article-filter', {
      category_id: $('.article-type.w--current').length ?
        parseInt($('.article-type.w--current').data('id')) : 0,
      title: $('input[name=search_query]').val(),
      sort_by: $('input[name=sort_by]:checked').val(),
      article_type: $('input[name=article_type]').val() || 'news',
      categories: decodeURI(JSON.stringify(categories))
    });

    if (data.success) {
      renderArticles(data.data);
    }

  } catch (err) {
    console.warn('[ArticleFilter::err]', err);
  }

  $('.item_games-main').css('opacity', '1');
}

export const __initArticleFilters = () => {

  const articleFilterByCategory = async (e) => {

    e.preventDefault();

    $('.article-type').removeClass('w--current');
    $(e.target).addClass('w--current');

    filterArticles();
  }

  //actions
  $('.filter.article-type').on('click', (e) => articleFilterByCategory(e));
  $('[data-type="articles"]').on('keyup', (e) => filterArticles(e));
  $('input[name=sort_by]').on('change', (e) => filterArticles(e));
  $('input[name=filter--categories]').on('change', (e) => filterArticles(e));
}
