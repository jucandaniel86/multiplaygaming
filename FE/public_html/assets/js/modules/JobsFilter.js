import {__ApiFetch} from "./ApiFetch.js";
import {formatDate} from "./ArticlesFilter.js";

let displayedItems = 6;
let limitOnPage = 6;
let page = 1;

let morePressed = false;

const NEXT_BUTT_CLASS = ".w-pagination-next";
const ITEM_CLASS = ".item_position";
const SEARCH_INPUT = "input[name=search-job]";
const FILTER_DEPARTMENT = "input[name=filter--department]";

const disableMoreButton = (_total) => {

  if (displayedItems + limitOnPage >= _total) {
    return $(NEXT_BUTT_CLASS).hide();
  }

  return $(NEXT_BUTT_CLASS).show();
}

const filterJobs = async () => {
  $(ITEM_CLASS).css('opacity', '.6');

  let departments = [];
  if ($(FILTER_DEPARTMENT).length > 0) {
    $(FILTER_DEPARTMENT + ':checked').each(function () {
      departments.push(parseInt($(this).val()));
    });
  }

  try {
    const {data, success} = await __ApiFetch(baseURL + 'api/jobs-filter', {
      start: page,
      length: limitOnPage,
      search: $(SEARCH_INPUT).val(),
      sort_by: $('input[name=sort_by]:checked').val(),
      departments: decodeURI(JSON.stringify(departments))
    });

    if (success) {
      renderJobs(data.items);
      disableMoreButton(data.total);
    }

  } catch (err) {
    console.warn('[JobFilters::err]', err);
  }

  $(ITEM_CLASS).css('opacity', '1');
}

const renderJobs = (data) => {
  const $wrapper = $('.collection-list_positions');
  const $noResults = $('#jobs-no-results');
  const $template = document.querySelector('#career-item-template');

  //increment displayed items
  displayedItems += data.length;

  //display no results message
  if (!Array.isArray(data) || data.length === 0) {
    $wrapper.hide();
    $noResults.show();
    return false;
  }

  //display results
  if (!morePressed) {
    $wrapper.html('');
  }
  $wrapper.show();
  $noResults.hide();

  data.forEach(_item => {
    let item = $template.content.cloneNode(true);
    if (_item.department) {
      item.querySelectorAll('.job-item-department')
        .forEach(el => el.innerHTML = (_item.department.name));
    }

    item.querySelectorAll('.text-style-s1.caps ').forEach(el => el.innerHTML = _item.job_title);
    item.querySelector('.card_position').href = baseURL + 'jobs/' + _item.slug + '/' + _item.id;
    item.querySelector('.employment_type').innerHTML = _item.employment_type;
    item.querySelector('.experience').innerHTML = _item.required_experience;

    $wrapper.append(item);
  });
}

export const __initJobFilters = () => {

  const moreArticles = (_event) => {
    _event.preventDefault();
    morePressed = true;
    page++;
    filterJobs();
  }

  $(NEXT_BUTT_CLASS).on('click', (e) => moreArticles(e));
  $(SEARCH_INPUT).on('keyup', (e) => {
    morePressed = false;
    displayedItems = 0;
    page = 1;
    filterJobs(e)
  });

  $('input[name=jobs_sort_by]').on('change', (e) => {
    morePressed = false;
    displayedItems = 0;
    page = 1;
    filterJobs(e)
  });
  $(FILTER_DEPARTMENT).on('change', (e) => {
    morePressed = false;
    displayedItems = 0;
    page = 1;
    filterJobs(e)
  });
}
