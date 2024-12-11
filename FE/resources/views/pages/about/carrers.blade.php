@extends('layouts.website')
@section('content')
  <section data-w-id="04104de6-8682-f5ca-dc83-8a47e8b58ff2" class="section_hero-about overflow-hidden">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="padding-top">
            <div class="component_hero-careers" style="height: 25.375rem;">
              <div class="max-width-medium tablet-medium">
                <h1
                  class="heading-style-h2_hero text-color-white"
                  style="font-size: 1.875rem; line-height: 1.975rem;">{{__('about.careers.title')}}</h1>
                <div class="margin-top margin-medium">
                  <a
                    href="#open-positions"
                    class="button color_primary on-secondary w-button">{{__('about.careers.check')}}</a>
                </div>
              </div>
              <div class="wrap_hero-careers">
                <img
                  src="{{ url('/assets/imgs/boss.png') }}"
                  loading="lazy"
                  alt=""
                  style="top: -58.6%; right: -1px; height: auto; border-bottom-right-radius: .75rem;"
                  class="img_careers-responsive img_hero-about-2">
                <div class="wrap-img_back-hero-career hide-tablet">
                  <img
                    src="{{ url('/assets/imgs/boss.png') }}"
                    loading="lazy"
                    alt=""
                    class="img_back-hero-career img_hero-about-2">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <x-highlight-component
    :title="__('about.careers.highlightTitle')"
    :text="__('about.careers.highlightText')"
    :lang-source="'about.careers.highlightItems'"/>

  <!-- OPEN POSITIONS -->
  <section id="open-positions" class="section_campaigns">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-medium">
          <div class="margin-bottom margin-xsmall">
            <h2 class="heading-style-h3">{{__('about.careers.openPositions')}}</h2>
          </div>
          <div class="margin-bottom margin-xsmall">
            <div class="w-form">
              <form>
                <div class="margin-bottom margin-tiny">
                  <div class="layout_filters">
                    <div class="max-width-xsmall mobile-full">
                      <div class="item_search">
                        <x-icons.search class="icon-1x1-xsmall"/>
                        <input
                          class="field_search w-input"
                          maxlength="256" name="search-job"
                          placeholder="{{__('global.search')}}"
                          type="text"
                          required=""/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="layout_filters-career hide-mobile-portrait">
                  <div class="item_filters">
                    <label for="name" class="form_label">{{__('global.filterBy')}}</label>
                    <div class="wrap_filters_careers">
                      <x-dropdown
                        :label="__('about.careers.department')"
                        :items="$departments"
                        :name="'department'"
                      />
                      <div fs-cmsfilter-element="reset" class="wrap_remove-tags">
                        <a
                          id="clear"
                          href="#"
                          class="button is-text-icon is-small clear w-inline-block">
                          <div>{{__('about.careers.clearFilters')}}</div>
                          <div class="hide">{{__('about.careers.clearFilters')}}</div>
                          <div class="align-center w-embed">
                            <x-icons.clear/>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>

                  <div class="item_sort-career">
                    <label class="form_label">{{__('global.sortBy')}}</label>
                    <x-custom-dropdown
                      :options="config('website.generalSort')"
                      :includes="['date']"
                      :name="'jobs_sort_by'"
                    />
                  </div>
                </div>
                <div class="component_filters-mobile">
                  <div class="component_dropdown filters">
                    <div class="close-area filters"></div>
                    <div class="wrap_quick-links filters">
                      <div class="item_search-load up"></div>
                      <div class="component_close filters">
                        <div class="text-size-small text-weight-medium">{{__('global.filterBy')}}</div>
                        <x-icons.clear :class="'icon-1x1-xsmall cursor-pointer'"/>
                      </div>
                      <div class="wrap_filters games">
                        <x-dropdown
                          :label="__('about.careers.department')"
                          :items="$departments"
                          :name="'department'"
                        />
                        <div id="reset" class="wrap_remove-tags">
                          <a href="#"
                             class="button is-text-icon is-small clear w-inline-block">
                            <div>{{__('about.careers.clearFilters') }}</div>
                            <div class="hide">{{__('about.careers.clearFilters') }}</div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="button is-small is-icon filter-trigger">
                    <div>{{__('global.filterBy')}}</div>
                    <div class="icon_check w-embed">
                      <x-icons.arrow-down :fill="'#292D32'"/>
                    </div>
                  </div>
                  <div class="item_sort-by">
                    <div class="text-block">{{__('global.sortBy')}}: latest</div>
                  </div>
                </div>
              </form>
              <div class="w-form-done">
                <div>{{__('about.careers.successMessage')}}</div>
              </div>
              <div class="w-form-fail">
                <div>{{__('about.careers.errorMessage')}}</div>
              </div>
            </div>
          </div>
          <!-- JOBS WRAPPER -->
          <div>
            <!-- LIST -->
            @if(count($jobs))
              <div role="list" class="collection-list_positions">
                @foreach($jobs as $job)
                  @include('pages.about.job_item', ['job' => $job])
                @endforeach
              </div>
          @endif
          <!-- END LIST -->

            <!-- NOT FOUND -->
            <div
              class="margin-vertical margin-large align-center"
              id="jobs-no-results"
              @if(count($jobs) > 0) style="display: none" @endif
            >
              <div class="max-width-xsmall text-align-center">
                <div class="margin-bottom margin-xxsmall">
                  <div class="img_no-results">
                    <x-icons.search-zoom/>
                  </div>
                </div>
                <div class="text-style-s2">{{__('about.careers.noResults')}}</div>
                <div
                  class="text-size-small text-weight-medium text-color-grey">{{__('about.careers.noResultsTxt')}}</div>
              </div>
            </div>
            <!-- /NOT FOUND -->

            <!-- NAVIGATION -->
            <div
              role="navigation"
              class="w-pagination-wrapper pagination-container_news">
              <a
                href="#" class="w-pagination-previous hide"
                style="display: none;">
                <x-icons.arrow-left/>
                <div class="w-inline-block">{{__('about.careers.prev')}}</div>
              </a>
              <a
                href="#"
                @if(!$moreButton) style="display: none;" @endif
                class="w-pagination-next button color_primary is-next">
                <div class="w-inline-block">{{__('about.careers.cta')}}</div>
              </a>
            </div>
            <!-- END NAVIGATION -->
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- RECRUITMENT PROCESS -->
  <x-scrolled-component
    :title="__('about.careers.recruitmentTitle')"
    :text="''"
    :componentName="'component_process'"
    :sectionName="'layout_process'"
    :button="['label' => __('about.careers.cta'), 'route'  => 'fe.contact' ]">
    @foreach(__('about.careers.process') as $key => $item)
      <div class="item_process">
        <div class="num-wrap">
          <div class="text-style-s1 text-color-secondary">{{ $key + 1 }}</div>
        </div>
        <div class="wrap-text_process"><h3 class="text-style-s1">{{ $item['title'] }}</h3>
          <div class="text-size-medium">{{ $item['text'] }}</div>
        </div>
      </div>
    @endforeach
  </x-scrolled-component>
  <!-- END RECRUITMENT PROCESS -->

  <!-- BENEFITS -->
  <section class="section_benefits">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-xlarge">
          <div class="padding-bottom padding-xxsmall">
            <div class="w-layout-grid header_component">
              <div class="career_image-wrapper" style="grid-area: img">
                <img
                  loading="lazy" alt=""
                  src="{{ asset('assets/imgs/our_partners_clients.png') }}"
                  class="img_career">
              </div>
              <div class="max-width-medium" style="grid-area: text">
                <div class="padding-bottom padding-xxsmall">
                  <h2 class="heading-style-h3">{{__('about.careers.aboutUs')}}</h2>
                </div>
                <div class="margin-bottom margin-xxsmall">
                  <p class="text-size-medium">{!! __('about.careers.aboutTxt1') !!}</p>
                </div>
                <div class="padding-top padding-custom2">
                  <div class="button-wrap">
                    <a href="#open-positions"
                       class="button color_primary w-button">{{__('about.careers.checkCareers')}}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END BENEFITS -->

  @include('components._content-image', [
   'title' => __('about.careers.ourCultureTitle'),
   'text1' => __('about.careers.ourCultureText'),
   'textLeft' => false,
   'image' => 'assets/imgs/our_culture.jpg'
 ])

  @include('components._content-image', [
   'title' => __('about.careers.benefitsTitle'),
   'text1' => __('about.careers.benefitsText1'),
	 'text2' => __('about.careers.benefitsText2'),
   'textLeft' => true,
   "image" => "assets/imgs/benefits.png"
  ])

  <!-- ITEM TEMPLATE -->
  <template id="career-item-template">
    <div
      role="listitem"
      class="item_position">
      <a
        href=""
        class="card_position w-inline-block">
        <div class="header_card">
          <div class="margin-bottom margin-xsmall">
            <div class="label is-white job-item-department">
              <div></div>
            </div>
          </div>
          <div class="text-style-s1 caps cairo"></div>
          <div class="wrap_positions-details">
            <div class="text-size-regular employment_type"></div>
            <div class="divider-verticle_position"></div>
            <div class="text-size-regular experience"></div>
            <div class="text-size-regular hide"></div>
          </div>
        </div>
        <div class="button is-text small">
          <div>{{__('about.careers.learnMore')}}</div>
          <div class="icon_button-text w-embed">
            <x-icons.arrow-right :fill="'#17161C'"/>
          </div>
        </div>
      </a>
    </div>
  </template>
  <!-- END ITEM TEMPLATE -->
@endsection
