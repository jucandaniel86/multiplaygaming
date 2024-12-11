<section class="section_branded-games">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-large mobile-small">
        <div class="padding-vertical padding-small">
          @if(isset($title))
            <div class="margin-bottom margin-xsmall">
              <h2 class="heading-style-h3">{{ $title }}</h2>
            </div>
          @endif
          @if(isset($games) && count($games))
            <div class="layout_games-main branded w-dyn-items" role="list">
              @foreach($games as $game)
                @include('components._featured_game-item', ['game' => $game])
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
