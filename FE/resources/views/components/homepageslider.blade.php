@php
  if(!function_exists('remove_style_attribute')) {
    function remove_style_attribute($input) {
      return preg_replace('/(<[^>]+) style=".*?"/i', '$1', $input);
    }
  }
@endphp
@if(isset($games))
  <section class="section overflow-hidden padding-global mobile-fixed-height">
    <div class="container-large padding-section-xsmal container-swiper">
      <div class="padding-top padding-xxsmall"></div>
      <div
        class="collection-list-wrap_hero-home is-hidden swiper swiper-hero w-dyn-list swiper-fade swiper-initialized swiper-horizontal swiper-watch-progress swiper-backface-hidden">
        <div
          role="list"
          class="collection-list_hero-home swiper-wrapper"
          style="transition-duration: 0ms; transition-delay: 0ms;">
        @foreach($games as $key => $game)
          <!-- GROUP -->
            <div
              role="group"
              class="collection-item_hero-home swiper-slide w-dyn-item swiper-slide-prev"
              aria-label="{{ $key + 1 }} / {{ count($games) }}"
            >
              <div class="w-layout-grid header_component slider">
                <div class="max-width-medium column_text-component" style="grid-area: text">
                  @if($game->is_coming_soon)
                    <div class="label margin-bottom margin-tiny">{{__('global.upcomingReleases')}}</div>
                  @endif
                  <h2 class="heading-style-h2_hero tablet-large margin-bottom margin-tiny">{{ $game->game_name }}</h2>
                  <div class="text-size-medium">{!! remove_style_attribute($game->short_description) !!}</div>
                  <div class="wrap_game-details margin-top margin-xsmall">
                    @if($game->category)
                      <div class="item_game-features">
                        <div class="data_game-details">
                          <div class="text-style-l4 text-color-grey">{{__('global.gameType')}}</div>
                          <div class="text-style-s4">{{ $game->category->name }}</div>
                        </div>
                        <div class="line-vertical_game-details mobile"></div>
                      </div>
                    @endif
                    <div class="item_game-features">
                      <div class="data_game-details">
                        <div class="text-style-l4 text-color-grey">{{__('global.rtp')}}</div>
                        <div class="display-inlineflex">
                          <div class="text-style-s4">{{ $game->rtp ? $game->rtp : 'N/A' }}</div>
                          <div class="text-style-s4">%</div>
                        </div>
                      </div>
                      <div class="line-vertical_game-details mobile"></div>
                    </div>
                    <div class="item_game-features">
                      <div class="data_game-details">
                        <div class="text-style-l4 text-color-grey">{{__('global.releaseDate')}}</div>
                        <div class="text-style-s4">{{Carbon\Carbon::parse($game->release_date)->format("M d, Y")}}</div>
                      </div>
                    </div>
                  </div>

                  <div class="button-group padding-vertical padding-tiny margin-top margin-xsmall full">
                    @if($game->demo_url)
                      <a
                        href="{{ \App\Helpers\BladeHelper::generateDemoURL($game->demo_url) }}"
                        target="_blank"
                        title="Play {{ $game->game_name }} demo"
                        class="button color_primary w-button">{{__('global.playDemo')}}</a>
                    @endif
                    <a
                      href="{{ route('fe.games.single', ['slug' => $game->slug ]) }}"
                      title="{{ $game->game_name }}"
                      class="button color_theme w-button">{{ __('global.moreInfo') }}</a>
                  </div>
                </div>
                <div class="header_image-wrapper" style="grid-area: img">
                  <img
                    loading="eager"
                    alt="{{ $game->game_name }}"
                    src="{{ $game->thumbnail_small_url }}"
                    class="img_hero-back slider home">
                </div>
              </div>
              <div class="w-layout-grid header_component slider w-condition-invisible">
                <div class="component_event">
                  <div class="max-width-medium tablet-full">
                    @if($game->is_coming_soon)
                      <div class="label is-white margin-bottom margin-tiny">{{__('global.upcomingReleases')}}</div>
                    @endif
                    <div class="heading-style-h2_hero text-color-white tablet-large margin-bottom margin-xxsmall">
                      {{ $game->game_name }}
                    </div>
                    <p class="text-size-medium text-color-white margin-bottom margin-tiny w-condition-invisible">
                      {!! $game->short_description !!}
                    </p>
                    <div class="button-group padding-top padding-tiny margin-top margin-xsmall">
                      <a
                        href="{{ route('fe.games.single', ['slug' => $game->slug ]) }}"
                        title="{{ $game->game_name }}"
                        class="button color_primary on-secondary w-button">{{__('global.seeDetails')}}</a>
                    </div>
                  </div>
                </div>
                <div class="header_image-wrapper" style="grid-area: img">
                  <img
                    loading="eager" alt="{{ $game->game_name }}"
                    src="{{ $game->thumbnail_small_url }}"
                    class="img_hero-back-game"/>
                </div>
              </div>
            </div>
            <!-- GROUP -->
          @endforeach
        </div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
      </div>

      <!-- PAGINATION -->
      <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal">
        @for($i=1; $i<= count($games); $i++)
          <span
            class="swiper-pagination-bullet {{ $i === 1 ? 'swiper-pagination-bullet-active' : '' }}"
            tabindex="0"
            role="button"
            data-id="{{ $i - 1 }}"
            aria-label="Go to slide {{ $i }}"></span>
        @endfor
      </div>
      <div class="swiper-navigation_pages">
        <div
          class="swiper-button_prev hero_arrow"
          tabindex="0"
          role="button"
          aria-label="Previous slide"
        >
          <x-icons.arrow-left :fill="'#000'"/>
        </div>
        <div
          class="swiper-button_next hero_arrow"
          tabindex="0"
          role="button"
          aria-label="Next slide"
        >
          <x-icons.arrow-right :fill="'#000'"/>
        </div>
      </div>
    </div>
  </section>
@endif
