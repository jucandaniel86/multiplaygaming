<header class="app-header">
  <div class="container">
    <div class="app-logo-container">
      <a href="{{ url('/') }}" class="app-logo">
        <img
          src="https://cdn.prod.website-files.com/63b2c230b49fa188ad86ffec/63f4c9689497e0d7c32f4a31_BGaming_logo.svg"
          loading="lazy"
          alt="{{ env('APP_NAME') }}"
          class="app-logo-img"/>
      </a>
    </div>
    <nav role="navigation" class="navbar_menu is-page-height-tablet w-nav-menu">
      <div class="navbar_link-wrap">
        @foreach(config('website.website_menu') as $menu)
          @if(!count($menu['childs']))
            <a
              href="{{ $menu['route'] ? route($menu['route']) : '#' }}"
              title="{{ $menu['label'] }}"
              class="navbar_link w-nav-link">{{ $menu['label'] }}</a>
          @else
            <div class="navbar_menu-dropdown w-dropdown">
              <div class="navbar_link is-dropdown-button w-dropdown-toggle"
                   role="button"
                   tabindex="0">
                <div class="navbar_link">
                  <div>{{ $menu['label'] }}</div>
                </div>
                <div class="dropdown-icon hide-tablet w-embed">
                  <x-icons.arrow-down/>
                </div>
                <div class="dropdown-icon tablet_menu w-embed">
                  <x-icons.arrow-down/>
                </div>
              </div>
              <nav class="navbar_dropdown-list w-dropdown-list">
                <div class="navbar_dropdown-link-list">
                  @foreach($menu['childs'] as $childs)
                    <a
                      href="{{ $childs['route'] ? route($childs['route']) : '#' }}"
                      title="{{ $childs['label'] }}"
                      class="navbar_dropdown-link w-inline-block">
                      <div class="navbar11_icon-wrapper">
                        <img
                          src="{{ asset('assets/imgs/icons/' . $childs['icon']) }}"
                          loading="lazy"
                          alt="{{ $childs['label'] }}"
                          class="icon-1x1-small"/>
                      </div>
                      <div class="navbar11_text-wrapper">
                        <div
                          class="text-size-regular text-weight-medium">{{ $childs['label'] }}</div>
                      </div>
                    </a>
                  @endforeach
                </div>
              </nav>
            </div>
          @endif
        @endforeach
      </div>
      <!-- main menu -->

      <div class="navbar_menu-buttons">
        <a id="search_button"
           href="#"
           class="button is-text-icon is-small hide-tablet w-inline-block">
          <div class="align-center w-embed">
            <x-icons.search/>
          </div>
        </a>
        <div class="line-vertical_navbar hide-tablet"></div>
        <a
          href="#"
          target="_blank" class="button is-text-icon is-small nav w-inline-block"
          style="grid-area: client-area"
        >
          <div>{{__('global.clientArea')}}</div>
          <div class="align-center nav-main w-embed">
            <x-icons.user/>
          </div>
          <div class="align-center nav-alt w-embed">
            <x-icons.user/>
          </div>
        </a>
        <a href="{{ route('fe.contact') }}"
           style="grid-area:contact"
           class="button is-small color-primary nav w-button">{{ __('global.contactUs') }}</a>
      </div>
    </nav>
  </div>
</header>
