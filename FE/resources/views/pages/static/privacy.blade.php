@extends('layouts.website')
@section('content')
  <x-_page-header
    :title="__('privacy.title')"
    :text="__('privacy.hero_txt')"
    :button="[
    'route' => 'fe.contact',
    'label' => __('global.contactUs')
  ]"
  />

  <section class="section_rich-text">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-medium">
          <div class="padding-bottom padding-small">
            <div class="w-layout-grid layout_probably-fair">
              <!-- TEXT SECTION -->
              <div class="component_text-fair">
                <div id="intro" class="item_text-privacy">
                  <div class="padding-bottom padding-xxsmall">
                    <div class="heading-style-h3">{{__('privacy.introTitle')}}</div>
                  </div>
                  <div class="text-rich-text w-richtext">{!! __('privacy.introTxt') !!}</div>
                </div>
                @foreach(__('privacy.content') as $item)
                  <div id="{{ $item['id'] }}" class="item_text-privacy">
                    <div class="padding-bottom padding-xxsmall">
                      <div class="heading-style-h3">{{ $item['title'] }}</div>
                    </div>
                    <div class="text-rich-text w-richtext">{!! $item['text'] !!}</div>
                  </div>
                @endforeach

                <div id="contact" class="item_text-privacy">
                  <div class="padding-bottom padding-xxsmall">
                    <div class="heading-style-h3">{{__('privacy.contact')}}</div>
                  </div>
                  <div class="text-rich-text w-richtext">{!! __('privacy.contactTxt') !!}</div>
                </div>
              </div>
              <!-- END TEXT SECTION -->
              <!-- QUICK LINKS SECTION -->
              <div class="component_nav-fair hide-mobile-landscape">
                <div class="item_nav-fair">
                  <div class="header_nav-fair">
                    <div class="text-style-s1">{{__('privacy.quickLinks')}}</div>
                  </div>
                </div>
                <div class="item_nav-fair">
                  @foreach(__('privacy.quick_links') as $links)
                    <a href="#{{ $links['id'] }}" class="link_nav-fair w-inline-block">
                      <div class="text-size-medium text-weight-medium">{{ $links['text'] }}</div>
                    </a>
                  @endforeach
                </div>
              </div>
              <!-- END QUICK LINKS SECTION -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
