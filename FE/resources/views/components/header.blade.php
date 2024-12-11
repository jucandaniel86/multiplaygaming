<div class="navbar_component w-nav" role="banner" data-collapse="medium">
  <div class="navbar_container">
    <div class="button-group_nav">
      <a
        href="{{ url('/') }}"
        title="{{ env('APP_NAME') }}"
        class="navbar_logo-link w-nav-brand"
        aria-label="home">
        <img
          src="{{ asset('assets/imgs/logo.png?v=1') }}"
          loading="lazy"
          alt="{{ env('APP_NAME') }}"
          class="navbar_logo"/>
      </a>
    </div>
    <a href="/" class="navbar_logo-link hide w-nav-brand" aria-label="home">
      <img
        src="{{ asset('assets/imgs/logo.png') }}"
        loading="lazy"
        alt="{{ env('APP_NAME') }}"
        class="navbar_logo">
    </a>
    <nav
      role="navigation"
      class="navbar_menu is-page-height-tablet w-nav-menu">
      <div class="navbar_link-wrap">
        @foreach(config('website.website_menu') as $menu)
          @if(!count($menu['childs']))
            <a
              href="{{ $menu['route'] ? route($menu['route']) : '#' }}"
              title="{{ $menu['label'] }}"
              class="navbar_link w-nav-link">{{ __($menu['label']) }}</a>
          @else
            <div class="navbar_menu-dropdown w-dropdown">
              <a
                class="navbar_link is-dropdown-button w-dropdown-toggle"
                role="button"
                onclick="__openMobileMenu(this)"
                tabindex="0">
                <div class="navbar_link">
                  {{ __($menu['label']) }}
                </div>
                <div class="dropdown-icon hide-tablet w-embed">
                  <x-icons.arrow-down/>
                </div>
                <div class="dropdown-icon tablet_menu w-embed">
                  <x-icons.arrow-down/>
                </div>
              </a>
              <nav class="navbar_dropdown-list w-dropdown-list">
                <div class="navbar_dropdown-link-list">
                  @foreach($menu['childs'] as $childs)
                    <a
                      href="{{ $childs['route'] ? route($childs['route']) : '#' }}"
                      title="{{ __($childs['label']) }}"
                      class="navbar_dropdown-link w-inline-block">
                      <div class="navbar11_icon-wrapper">
                        <img
                          src="{{ asset('assets/imgs/icons/' . $childs['icon']) }}"
                          loading="lazy"
                          alt="{{ __($childs['label']) }}"
                          class="icon-1x1-small"/>
                      </div>
                      <div class="navbar11_text-wrapper">
                        <div
                          class="text-size-regular text-weight-medium">{{ __($childs['label']) }}</div>
                      </div>
                    </a>
                  @endforeach
                </div>
              </nav>
            </div>
          @endif
        @endforeach
      </div>

      <div class="navbar_menu-buttons">
        <a
          id="search_button"
          href="#"
          class="button is-text-icon is-small hide-tablet w-inline-block">
          <div class="align-center w-embed">
            <x-icons.search/>
          </div>
        </a>
        <div class="line-vertical_navbar hide-tablet"></div>
        <a
          href="{{ route('fe.clientArea') }}"
          target="_blank"
          class="button is-text-icon is-small nav w-inline-block">
          <div>{{__('menu.client_area')}}</div>
          <div class="align-center nav-main w-embed">
            <x-icons.user/>
          </div>
          <div class="align-center nav-alt w-embed">
            <x-icons.user/>
          </div>
        </a>
        <a href="{{ route('fe.contact') }}"
           style="grid-area:contact"
           class="button is-small color-primary nav w-button">{{ __('menu.contact') }}</a>
      </div>
    </nav>
    <div class="wrap_menu-buttons">
      <a href="#"
         class="button is-text-icon is-small is-seacrh w-inline-block">
        <img
          src="https://cdn.prod.website-files.com/63b2c230b49fa188ad86ffec/63dd481eb11a9e276e529fa3_Ghost.svg"
          loading="lazy" alt="" class="icon-1x1-small">
      </a>
      <div class="wrap-navbar_menu-button">
        <div class="nav-menu-button w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button"
             tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false"></div>
      </div>
    </div>
  </div>
  <!-- MOBILE OVERLAY -->
  <div class="w-nav-overlay" data-wf-ignore="" id="w-nav-overlay-0">
  </div>
  <!-- END MOBILE OVERLAY -->
</div>

<script>
  const TABLET_RES = 767;
  const DROPDOWN_LIST = ".w-dropdown-list";
  const OPEN_CLASS = 'w--open';

  const isMobile = () => window.innerWidth <= TABLET_RES;

  const __openMobileMenu = (obj) => {
    if (!isMobile()) return false;

    let _cObject = $(obj);
    let _dd = _cObject.parent().find(DROPDOWN_LIST);

    _dd.toggleClass(OPEN_CLASS);
    $(_cObject).parent().toggleClass(OPEN_CLASS);
    $(_cObject).toggleClass(OPEN_CLASS);
  }
</script>
