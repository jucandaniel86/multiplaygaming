<div class="margin-bottom margin-xsmall">
  <form action="#">
    <x-form.search-item :title="__('games.title')" :dataType="'games'"/>
    <div class="layout_filters games-hide">
      <div class="item_filters">
        <label class="form_label">{{ __('games.filterBy') }}</label>
        @if(!$isCategory)
          <div class="wrap_filters games">
            @include('components.dropdown', [
              'label' => __('games.gameType'),
              'items' => $categories,
              'name' => 'game_type'
            ])
            @include('components.dropdown', [
              'label' => __('games.features'),
              'items' => $features,
              'name' => 'game_features'
           ])
          </div>
        @else
          <div class="collection_type-buttons game-page w-dyn-list">
            <div class="list_type-buttons game-page w-dyn-items">
              @foreach($categories as $category)
                <div class="item_game-type w-dyn-item">
                  <a
                    href="{{ route('fe.games.game_type', [ 'slug' => $category->slug]) }}"
                    class="button is-small filter game-type w-button {{ $category->id == $categoryID ? 'w--current' : '' }}"
                    title="{{ $category->label }}"
                  >{{ $category->label }}</a>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </div>
      <div class="item_filters">
        <label for="name" class="form_label hide-mobile-portrait">{{ __('games.sortBy') }}</label>
        <x-custom-dropdown
          :options="config('website.generalSort')"
          :includes="['release_date', 'rtp', 'volatility', 'multiplier']"
          :name="'game_sort_by'"
        />
      </div>
    </div>

  </form>
</div>
