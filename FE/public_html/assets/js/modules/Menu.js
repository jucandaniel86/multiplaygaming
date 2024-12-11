export const __initMenu = () => {
 
  let menuButton = document.querySelector('.nav-menu-button');
  let navbarContainer = document.querySelector('.navbar_container');
  let localButton = document.querySelector('.wg-element-wrapper');

  function toggleMenu() {
    navbarContainer.classList.toggle('menu_opened');
    menuButton.classList.toggle('w--open');
    if (menuButton.classList.contains('w--open')) {

      $(".w-nav-overlay").css({display: 'block'});
      let $clone = $('.navbar_menu').clone().attr('data-nav-menu-open', '');
      $('.w-nav-overlay').html($clone);
      $('.w-nav-overlay .navbar_menu').animate({
        top: '0px',
      });
    } else {
      $('.w-nav-overlay .navbar_menu').animate({
          top: '-600px',
        }, 500,
        function () {
          $(".w-nav-overlay").css({display: 'none'});
          $('.w-nav-overlay').html('');

        }
      )

    }
  }

  function removeMenuIfOpened() {
    if (navbarContainer.classList.contains('menu_opened')) {
      navbarContainer.classList.remove('menu_opened');
    }
  }

  if (menuButton && navbarContainer) {
    menuButton.addEventListener('click', toggleMenu);
  }

  if (localButton && navbarContainer) {
    localButton.addEventListener('click', removeMenuIfOpened);
  }

  //Search plugin
  let searchButton = document.querySelector('#search_button');
  let searchBar = document.querySelector('.searchbar');
  let layoutPreSearch = document.querySelector('.layout_pre-search');
  let layoutSearchResults = document.querySelector('.layout_search-results');

  function handleSearch() {
    if (searchBar.value.trim() !== '') {
      layoutPreSearch.style.display = 'none';
      layoutSearchResults.style.display = 'block';
    }
  }

  searchButton.addEventListener('click', handleSearch);
}
