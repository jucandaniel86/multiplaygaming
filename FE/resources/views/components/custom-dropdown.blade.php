@if(isset($options) && is_array($options) && count($options))
  <div class="dropdown hide-mobile-portrait w-dropdown">
    @php
      $displayedOptions = (array)$options;

      if(isset($includes)) {
        $displayedOptions = array_filter($options, function($val) use ($includes) {
          return in_array($val['id'], $includes);
        });
				$displayedOptions = array_values($displayedOptions);
      }

      $defaultOption = $displayedOptions[0];

      if(count($displayedOptions) > 1) {
			  $_tmp = array_filter($displayedOptions, function($val) {
					return $val['default'] === true;
			  });
				if(count($_tmp)) {
					$defaultOption = $_tmp[0];
				}
      }
    @endphp
    @if(isset($defaultOption))
      <div class="button is-small is-icon filter w-dropdown-toggle">
        <div class="wrap_button-label">
          <div class="state_rtp" style="display: flex;">
            <div class="sort-select-text">{{ $defaultOption['label'] }}</div>

            <x-icons.sort-down :class="'sort-icon sort-down'" :style="'display: none;'"/>
            <x-icons.sort-up :class="'sort-icon sort-up'" :style="'display: none;'"/>
            <x-icons.sort-arrows :class="'sort-icon sort-default'"
                                 :style="$defaultOption['default_icon'] == 'arrows' ? 'display: flex': 'display:none;' "/>
          </div>
        </div>
      </div>
    @endif
    <nav
      class="dropdown-list_sort games w-dropdown-list"
      role="listbox">
      <div class="hide-mobile-portrait">
        @foreach($displayedOptions as $option)
          <div class="component_radio-filters" id="{{ $option['id'] }}">
            @if(count($displayedOptions) > 1)
              <div class="title_dropdown">
                <div class="text-style-l1">{{ $option['label'] }}</div>
              </div>
            @endif
            @foreach($option['options'] as $_option)
              @php
                $values = explode('|', $_option['label']);
              @endphp
              <div href="#"
                   class="item-radio_filter no-wrap w-inline-block w--current"
                   role="option"
              >
                <label class="radio_filter default" style="display: flex">
                  <input
                    data-id="custom_dropdown"
                    data-label="{{ $option['label'] }}"
                    data-icon="{{ $_option['icon'] }}"
                    type="radio"
                    name="{{ isset($name) ? $name : 'sort_by' }}"
                    value="{{ $_option['value'] }}"
                    style="opacity: 0"

                  />
                </label>
                <div>{{ $values[0] }}</div>
                <x-icons.arrow-right :class="'icon-1x1-xsmall'"/>
                <div>{{ $values[1] }}</div>
              </div>
            @endforeach
          </div><!-- /.component_radio-filters -->
        @endforeach

      </div>
    </nav>
  </div>
@endif
