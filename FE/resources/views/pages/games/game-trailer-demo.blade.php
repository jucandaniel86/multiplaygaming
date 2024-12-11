<div class="{{ isset($class) ? $class : 'button-group padding-vertical padding-tiny' }}">
  @if($game->demo_url)
    <a rel="nofollow"
       href="{{ $game->demo_url }}"
       target="_blank"
       title="Demo URL for {{ $game->game_name }} game"
       class="button is-icon color_primary w-inline-block">
      <div>{{__('games.single.demo')}}</div>
      <div class="align-center w-embed">
        <x-icons.demo :fill="'#17161C'"/>
      </div>
    </a>
  @endif
  @if($game->trailer_url)
    <a
      {{--      target="_blank"--}}
      onclick="openYTPopup()"
      class="button color_theme w-button"
      title="Watch trailer for {{ $game->game_name }} game"
      role="button">
      {{__('games.single.trailer')}}
    </a>
  @endif
</div>
