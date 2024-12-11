<div
  class="item_games-main"
  role="listitem" @if(isset($style)) style="{{ $style }}" @endif
>
  <div class="card_games-main">
    <a
      href="{{ route('fe.games.single', [ 'slug' => $game->slug ]) }}"
      title="{{ $game->name }}"
      class="hover_game-link w-inline-block"></a>
    <div class="wrap-label_games-main">
      <div class="label is-secondary {{ $game->is_branded ? '' : 'w-condition-invisible' }}">
        <div>{{ __('global.branded') }}</div>
      </div>
      <div class="label is-secondary {{ $game->is_coming_soon ? '' : 'w-condition-invisible' }}">
        <div>{{ __('global.comingSoon') }}</div>
      </div>
    </div>
    <div class="card-hover_game" style="opacity: 0; display: none;">
      <a
        href="{{ route('fe.games.single', [ 'slug' => $game->slug ]) }}"
        title="{{ $game->game_name }}"
        class="card-hover_game-link w-inline-block"></a>
      <div class="header_content">
        <div class="margin-bottom margin-tiny">
          <a
            href="{{ route('fe.games.single', [ 'slug' => $game->slug ]) }}"
            title="{{ $game->game_name }}"
            class="button is-text-arrow icon_button-text link-block link-block-2 link-block-3 link-block-4 w-inline-block">
            <div>{{ __('global.details') }}</div>
            <div class="icon_button-text w-embed">
              <x-icons.arrow-right/>
            </div>
          </a>
        </div>
        <div class="text-wrap_card-hover">
          <div class="text-style-s1 caps">{{ $game->game_name }}</div>
          @if($game->category)
            <div class="text-size-regular text-weight-medium">{{ $game->category->name }}</div>
          @endif
        </div>
      </div>
      <!-- header-content -->
      <div class="button-wrap_card-hover">
        @if($game->demo_url)
          <a rel="nofollow"
             href="{{ \App\Helpers\BladeHelper::generateDemoURL($game->demo_url) }}"
             target="_blank"
             title="{{ $game->game_name }}"
             class="button is-icon w-inline-block">
            <div>{{ __('global.demoPlay') }}</div>
            <div class="icon-center w-embed">
              <x-icons.demo/>
            </div>
          </a>
        @endif
      </div>
    </div>
    @if($game->thumbnail_url)
      <img
        sizes="(max-width: 479px) 90vw, (max-width: 767px) 44vw, (max-width: 1439px) 36vw, 30vw"
        loading="lazy"
        alt="{{ $game->game_name }}"
        src="{{ $game->thumbnail_url }}"
        srcset="{{ $game->thumbnail_url }} 500w, {{ $game->thumbnail_url }} 800w, {{ $game->thumbnail_url }} 1020w"
        class="img_small-card"/>
    @endif
    @if($game->thumbnail_small_url)
      <img
        loading="lazy"
        size="100vw"
        alt="{{ $game->game_name }}"
        src="{{ $game->thumbnail_small_url }}"
        class="img_large-card"/>
    @endif
  </div>
</div><!-- item_games-main -->
