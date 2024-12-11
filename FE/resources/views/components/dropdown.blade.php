@if(isset($items) && count($items))
  <div class="dropdown games z-index-5 w-dropdown">
    <div
      class="button is-small is-icon filter w-dropdown-toggle"
      id="w-dropdown-toggle-5"
      role="button" tabindex="0">
      <div>{{ isset($label) ? $label : __('games.undefined') }}</div>
      <div id="count" class="filter_num-wrap" style="display: none;">0</div>
      <div class="icon_check w-embed" style="display: flex;">
        <x-icons.arrow-bottom/>
      </div>
    </div>
    <nav class="dropdown-list w-dropdown-list">
      <div class="w-dyn-list">
        <div role="list" class="w-dyn-items">
          <div role="listitem" class="w-dyn-item">
            @foreach($items as $key => $gameFilters)
              <label class="w-checkbox checkbox-item_filter">
                <div class="w-checkbox-input w-checkbox-input--inputType-custom checkbox_filter"></div>
                <input
                  id="checkbox-{{ $key }}"
                  type="checkbox"
                  name="filter--{{ $name  }}"
                  value="{{ $gameFilters['id'] }}"
                  style="opacity:0;position:absolute;z-index:-1">
                <span
                  class="checkbox-label_filter w-form-label"
                  for="checkbox-{{ $key }}">{{ $gameFilters['label'] }}</span>
              </label>
            @endforeach
          </div>
        </div>
      </div>
    </nav>
  </div>
@endif
