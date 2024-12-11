@extends('layouts.website')
@section('content')
  <section class="section_games">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          @include('components.games.filters')
          <div class="margin-bottom margin-medium z-index-1">
            @if(count($games) > 0)
              <div class="layout_games-main branded" role="list" id="game__list">
                @foreach($games as $game)
                  @include('components._featured_game-item', ['game' => $game])
                @endforeach
              </div>
            @endif
          </div><!-- /GAME LIST -->

          <x-no-found :condition="count($games) > 0"/>

          <!-- PAGINATION -->
          @if(isset($pagination))
            <div
              role="navigation"
              aria-label="List"
              class="w-pagination-wrapper pagination-container_news">
              <a href="#"
                 class="w-pagination-previous"
                 style="display: none;">
                <x-icons.prev/>
                <div class="w-inline-block">{{ __('global.prev') }}</div>
              </a>
              <a
                href="#"
                class="w-pagination-next button color_theme is-next"
              >
                <div class="w-inline-block">{{ __('global.showMore') }}</div>
              </a>
            </div>
          @endif
        <!-- /END PAGINATION -->

          <!-- CATEGORIES -->
          @if(!$isCategory)
            <div class="margin-top margin-small hide-mobile-portrait">
              <div class="item_filters all-games _2">
                <a href="{{ route('fe.games') }}"
                   class="button is-small filter game-type w-button w--current">{{ __('global.allGames') }}</a>
                <div class="collection_type-buttons game-page w-dyn-list">
                  <div class="list_type-buttons game-page w-dyn-items">
                    @foreach($categories as $category)
                      <div class="item_game-type w-dyn-item">
                        <a
                          href="{{ route('fe.games.game_type', [ 'slug' => $category->slug]) }}"
                          class="button is-small filter game-type w-button"
                          title="{{ $category->label }}"
                        >{{ $category->label }}</a>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
        @endif
        <!-- /END CATERGORIES -->
        </div>
      </div>
    </div>
  </section>

  <!-- GAME TEMPLATE -->
  <template id="game-item__template">
    <div
      class="item_games-main"
      role="listitem"
    >
      <div class="card_games-main">
        <a class="hover_game-link w-inline-block game__url"></a>
        <div class="wrap-label_games-main">
          <div class="label is-secondary game__is_branded">
            <div>{{ __('global.branded') }}</div>
          </div>
          <div class="label is-secondary game__is_coming_soon">
            <div>{{ __('global.comingSoon') }}</div>
          </div>
        </div>
        <div class="card-hover_game" style="opacity: 0; display: none;">
          <a class="card-hover_game-link w-inline-block game__url"></a>
          <div class="header_content">
            <div class="margin-bottom margin-tiny">
              <a
                class="button is-text-arrow icon_button-text link-block link-block-2
                link-block-3 link-block-4 w-inline-block game__url">
                <div>{{ __('global.details') }}</div>
                <div class="icon_button-text w-embed">
                  <x-icons.arrow-right/>
                </div>
              </a>
            </div>
            <div class="text-wrap_card-hover">
              <div class="text-style-s1 caps game__name"></div>
              <div class="text-size-regular text-weight-medium game__category"></div>
            </div>
          </div>
          <!-- header-content -->
          <div class="button-wrap_card-hover">
            <a
              rel="nofollow"
              target="_blank"
              class="button is-icon w-inline-block game__demo_url">
              <div>{{ __('global.demoPlay') }}</div>
              <div class="icon-center w-embed">
                <x-icons.demo/>
              </div>
            </a>
          </div>
        </div>
        <img
          loading="lazy"
          class="img_large-card game__thumbnail"/>

        <img
          loading="lazy"
          class="img_small-card game__thumbnail"/>
      </div>
    </div>
  </template>
  <!-- END GAME TEMPLATE -->

  @if($isCategory)
    <input type="hidden" id="category_id" value="{{ $categoryID }}"/>
  @endif

  <x-_partners/>
  <x-_cta/>
@endsection
