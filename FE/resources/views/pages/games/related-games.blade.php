<section class="section_games-more">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-xlarge">
        <div class="margin-bottom margin-small">
          <div class="heading-style-h3">{{ __('games.single.alsoLike') }}</div>
        </div>
        <div class="grid_games-more">
          <div style="grid-area: collection">
            <div class="layout_games-more">
              @foreach($relatedGames as $key => $game)
                @include('components._featured_game-item', ['game' => $game, 'style' => 'grid-area: game-' . $key + 1])
              @endforeach
            </div>
          </div>
          <a
            href="{{ route('fe.games') }}"
            class="card_button game w-inline-block">
            <div class="button is-text">
              <div>{{ __('games.single.catalog') }}</div>
            </div>
            <div class="icon_button-text w-embed">
              <x-icons.arrow-right :fill="'#17161C'"/>
            </div>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>
