@php
  if(!function_exists('remove_style_attribute')) {
	  function remove_style_attribute($input) {
			return preg_replace('/(<[^>]+) style=".*?"/i', '$1', $input);
	  }
  }
@endphp
@extends('layouts.website')
@section('content')
  <script>
    const openYTPopup = () => {
      $("#youtube_embeded_popup").css('display', 'flex');
    }
    const closeYTPopup = () => {
      $("#youtube_embeded_popup").css('display', 'none');
    }
  </script>
  @include('pages.games.youtubepopup', ['game' => $game ])
  <section class="section_game-hero mobile-margin padding-global">
    <div class="container-large padding-section-large">
      <div class="w-layout-grid header_component game padding-top">
        <div class="wrap_game-details-hero" style="grid-area: text">
          <div class="max-width-medium mobile-full">
            <div class="margin-bottom margin-tiny"></div>
            <h1 class="heading-style-h2_hero margin-bottom margin-tiny">{{ $game->game_name }}</h1>
            <div class="text-size-medium">{!! remove_style_attribute($game->short_description) !!}</div>
            <div class="wrap_game-details margin-top margin-xsmall show-mobile-landscape">
              @if($game->category)
                <div class="item_game-features">
                  <div class="data_game-details">
                    <div class="text-style-l4 text-color-grey">{{__('games.single.gameType')}}</div>
                    <div class="text-style-s4">{{ $game->category->name }}</div>
                  </div>
                  <div class="line-vertical_game-details"></div>
                </div>
              @endif
              @if($game->volatility)
                <div class="item_game-features">
                  <div class="data_game-details">
                    <div class="text-style-l4 text-color-grey">{{__('games.single.vilatility')}}</div>
                    <div class="text-style-s4">{{ $game->volatility->description() }}</div>
                  </div>
                  <div class="line-vertical_game-details"></div>
                </div>
              @endif
              @if($game->rtp)
                <div class="item_game-features">
                  <div class="data_game-details">
                    <div class="text-style-l4 text-color-grey">{{__('games.single.rtp')}}</div>
                    <div class="display-inlineflex">
                      <div class="text-style-s4">{{ $game->rtp }}</div>
                      <div class="text-style-s4">%</div>
                    </div>
                  </div>
                  <div class="line-vertical_game-details"></div>
                </div>
              @endif
              @if($game->release_date)
                <div class="item_game-features">
                  <div class="data_game-details">
                    <div class="text-style-l4 text-color-grey">{{__('games.single.date')}}</div>
                    <div class="text-style-s4">{{Carbon\Carbon::parse($game->release_date)->format("M d, Y")}}</div>
                  </div>
                </div>
              @endif
            </div>

            <div class="margin-top margin-xsmall">
              @include('pages.games.game-trailer-demo', ['game' => $game ])
            </div>
          </div>
          <div class="wrap_game-details margin-top margin-xsmall hide-mobile-landscape">
            @if($game->category)
              <div class="item_game-features">
                <div class="data_game-details">
                  <div class="text-style-l4 text-color-grey">{{__('games.single.gameType')}}</div>
                  <div class="text-style-s4">{{ $game->category->name }}</div>
                </div>
              </div>
            @endif
            @if($game->volatility)
              <div class="item_game-features">
                <div class="line-vertical_game-details"></div>
                <div class="data_game-details">
                  <div class="text-style-l4 text-color-grey">{{__('games.single.vilatility')}}</div>
                  <div class="text-style-s4">{{ $game->volatility->description() }}</div>
                </div>
              </div>
            @endif

            @if($game->rtp)
              <div class="item_game-features">
                <div class="line-vertical_game-details"></div>
                <div class="data_game-details">
                  <div class="text-style-l4 text-color-grey">{{__('games.single.rtp')}}</div>
                  <div class="display-inlineflex">
                    <div class="text-style-s4">{{ number_format($game->rtp, 2) }}</div>
                    <div class="text-style-s4">%</div>
                  </div>
                </div>
              </div>
            @endif
            @if($game->release_date)
              <div class="item_game-features">
                <div class="line-vertical_game-details"></div>
                <div class="data_game-details">
                  <div class="text-style-l4 text-color-grey">{{__('games.single.date')}}</div>
                  <div class="text-style-s4">{{ Carbon\Carbon::parse($game->release_date)->format("M d, Y") }}</div>
                </div>
              </div>
            @endif
          </div>
        </div>

        @if($game->thumbnail_small_url)
          <div class="header_image-wrapper" style="grid-area: img">
            <img
              loading="eager" alt=""
              src="{{ $game->thumbnail_small_url }}"
              sizes="(max-width: 479px) 87vw, (max-width: 767px) 73vw, (max-width: 991px) 5vw, (max-width: 1439px) 41vw, 30vw"
              class="img_hero-back">
          </div>
        @endif
      </div>

    </div>
  </section>

  <section class="section_about-game padding-global">
    <div class="container-large">
      <div class="padding-section-medium">
        <div class="padding-bottom padding-xxsmall">
          <div class="w-layout-grid layout_about-game expand">
            <div style="grid-area:img" class="max-width-small">
              <div class="padding-bottom padding-xxsmall">
                <div class="button-group text-icon-buttons">
                  @if($game->rules_url)
                    <a
                      href="{{ $game->rules_url }}"
                      target="_blank"
                      class="button is-text-icon w-inline-block">
                      <div>{{__('games.single.rules')}}</div>
                      <div class="icon_button-text w-embed">
                        <x-icons.rules/>
                      </div>
                    </a>
                  @endif
                  <div class="w-condition-invisible w-embed"><a
                      href="#" target="_blank"
                      class="button is-text-icon w-inline-block">
                      <div>{{__('games.rules')}}</div>
                      <div class="icon_button-text w-embed">
                        <x-icons.rules/>
                      </div>
                    </a>
                  </div>
                  @if($game->promo_pack_url)
                    <a
                      href="{{$game->promo_pack_url}}"
                      target="_blank"
                      title="Promo pack for {{$game->game_name}}"
                      class="button is-text-icon w-inline-block">
                      <div>{{__('games.single.promoPack')}}</div>
                      <div class="icon_button-text w-embed">
                        <x-icons.pack/>
                      </div>
                    </a>
                  @endif
                  <div class="button is-text-icon">
                    <div>{{__('games.single.copyDemoLink')}}</div>
                    <div class="icon_button-text w-embed">
                      <x-icons.copy-link/>
                    </div>
                  </div>
                </div>
              </div>
              @if($game->description)
                <div class="rich-text_game w-richtext">
                  {!! remove_style_attribute($game->description) !!}
                </div>
              @endif
              <div class="component_descriprion-collapse">
                <a
                  href="#"
                  class="button is-text-icon _more w-inline-block">
                  <div>{{__('global.readMore')}}</div>
                  <div class="w-embed">
                    <x-icons.arrow-down :fill="'#292D32'"/>
                  </div>
                </a
                ><a
                  href="#"
                  data-collapse="false"
                  class="button _hide is-text-icon trigger w-inline-block hide"

                >
                  <div>{{__('global.hide')}}</div>
                  <div class="w-embed">
                    <x-icons.arrow-up :fill="'#292D32'"/>
                  </div>
                </a>
              </div>
              <div class="padding-top padding-custom2">
                <div class="button-wrap">
                  @include('pages.games.game-trailer-demo', ['game' => $game, 'class' => 'button-group' ])
                </div>
              </div>
            </div>
            <div class="image-wrapper_about-game" style="grid-area: text">
              @if($game->description_img_url)
                <div class="img_about-game">
                  <div
                    class="img_back-about-game hide-mobile-portrait"></div>
                  <img
                    loading="lazy"
                    alt="{{ $game->game_name }}"
                    src=" {{$game->description_img_url}}"
                    class="img_back-about-game resp">
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES / DETAILS -->
  <section class="section_game-details padding-global">
    <div class="container-large">
      <div class="padding-section-medium">
        <div class="w-embed">
          <style>
            .item_game-feature:nth-child(1) {
              border-width: 0px;
            }
          </style>
        </div>
        <div class="w-layout-grid layout_game-details">
          @if(isset($game->features) && count($game->features))
            <div class="component_game-features" style="grid-area: features">
              <h2 class="heading-style-h5 _3">{{__('games.single.features')}}</h2>
              <div class="collection_game-features">
                <div role="list" class="list_game-features">
                  @foreach($game->features as $feature)
                    @if($feature->is_highlighted)
                      <div role="listitem" class="item_game-feature">
                        <x-icons.star :class="'icon-1x1-medium'"/>
                        <div class="text-size-medium text-weight-bold game_details">{{ $feature->name}}</div>
                      </div>
                    @endif
                  @endforeach
                </div>
              </div>
            </div>
          @endif
          <div class="component_game-details" style="grid-area: details;">
            <h2 class="heading-style-h5 _3">{{__('games.single.details')}}</h2>
            <div class="grid_game-details">
              @if($game->category)
                <div class="item_game-details">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.single.gameType')}}</div>
                  <div class="text-size-medium text-weight-bold game_details">{{ $game->category->name }}</div>
                </div>
              @endif
              @if($game->lines)
                <div class="item_game-details">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.single.lines')}}</div>
                  <div class="text-size-medium text-weight-bold game_details">{{ $game->lines }}</div>
                </div>
              @endif
              @if($game->volatility)
                <div class="item_game-details">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.single.vilatility')}}</div>
                  <div
                    class="text-size-medium text-weight-bold game_details">{{ $game->volatility->description() }}</div>
                </div>
              @endif
              @if($game->fs_rate)
                <div class="item_game-details w-condition-invisible">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.single.fsRate')}}</div>
                  <div
                    class="text-size-medium text-weight-bold game_details">{{ number_format($game->fs_rate,2) }}</div>
                </div>
              @endif
              @if($game->rtp)
                <div class="item_game-details">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.single.rtp')}}</div>
                  <div class="display-inlineflex">
                    <div class="text-size-medium text-weight-bold game_details">{{ number_format($game->rtp, 2) }}</div>
                    <div class="text-size-medium text-weight-bold game_details">%</div>
                  </div>
                </div>
              @endif
              @if($game->hit_rate)
                <div class="item_game-details">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.single.hitRate')}}</div>
                  <div
                    class="text-size-medium text-weight-bold game_details">{{ number_format($game->hit_rate, 2) }}</div>
                </div>
              @endif
              @if($game->max_multiplier)
                <div class="item_game-details">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.single.multiplier')}}</div>
                  <div class="display-inlineflex">
                    <div class="text-size-medium text-weight-bold game_details">x</div>
                    <div
                      class="text-size-medium text-weight-bold game_details">{{ number_format($game->max_multiplier, 2) }}</div>
                  </div>
                </div>
              @endif
              @if($game->max_win)
                <div class="item_game-details">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.single.maxWin')}}</div>
                  <div class="display-inlineflex">
                    <div class="text-size-medium text-weight-bold game_details">€</div>
                    <div
                      class="text-size-medium text-weight-bold game_details">{{ number_format($game->max_win, 2) }}</div>
                  </div>
                </div>
              @endif
              @if($game->game_id)
                <div class="item_game-details">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.single.id')}}</div>
                  <div class="text-size-medium text-weight-bold game_details">{{ $game->game_id }}</div>
                </div>
              @endif
              @if($game->release_date)
                <div class="item_game-details">
                  <div class="text-size-medium text-color-dark-grey">{{__('games.releaseDate')}}</div>
                  <div
                    class="text-size-medium text-weight-bold game_details">{{ Carbon\Carbon::parse($game->release_date)->format("M d, Y") }}</div>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="padding-bottom padding-small"></div>
      </div>
    </div>
  </section>
  <!-- / FEATURES / DETAILS -->

  <!-- DEMO SECTION -->
  @if($game->demo_img_url)
    <section class="section_demo" style="background-image: url('{{ $game->demo_img_url }}')">
      <div class="padding-global full">
        <div class="container-large full">
          <div class="padding-section-xlarge game-demo">
            <div class="max-width-small">
              <div class="margin-bottom margin-medium">
                <div class="heading-style-h4 text-color-white game-details">{{ $game->demo_text_header }}</div>
              </div>
              @if($game->demo_url)
                <div class="button-wrap">
                  <a rel="nofollow"
                     href="{{ \App\Helpers\BladeHelper::generateDemoURL($game->demo_url) }}"
                     target="_blank"
                     title="Demo URL for {{ $game->game_name }} game"
                     class="button is-icon color_primary w-inline-block">
                    <div>{{__('games.single.demo')}}</div>
                    <div class="align-center w-embed">
                      <x-icons.demo :fill="'#17161C'"/>
                    </div>
                  </a>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- /DEMO SECTION -->

  <!-- GAME GALLERY -->
  @includeWhen(isset($game->gallery) && count($game->gallery), 'pages.games.slider', [ 'game' => $game])
  <!-- END GAME GALLERY -->

  <!-- FEATURES DETAILED -->
  <section class="section_game-features">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-medium">
          <div class="max-width-medium">
            <div class="margin-bottom margin-small">
              <h2 class="heading-style-h3">{{ __('games.single.features') }}</h2>
            </div>
          </div>
          <div class="tabs_games">
            <div class="tabs-menu_games w-tab-menu">
              @foreach($game->features as $key => $feature)
                <div class="tab-link_games w-inline-block w-tab-link {{ $key == 0 ? 'w--current' : '' }}">
                  <div class="header-tab-link_games">
                    <div class="tab_icon">
                      <x-icons.arrow-down-features/>
                    </div>
                    <div class="text-size-medium text-weight-bold game_details">{{ $feature->long_name }}</div>
                  </div>
                  <div class="body-tab-link_games">
                    <div class="text-rich_games-tab w-richtext">
                      {!! $feature->pivot->content !!}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            @if($game->trailer_url)
              <div class="tab-content_games w-tab-content">
                <div class="item_features-tabs ">
                  <div class="video_embed">
                    {!! $game->trailer_url !!}
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END FEATURES DETAILED -->
  <x-_partners/>
  <!-- ALSO LIKE SECTION -->
  @includeWhen($relatedGames, 'pages.games.related-games', ['relatedGames' => $relatedGames ])
  <!-- END ALSO LIKE SECTION -->
@endsection
