@extends('layouts.website')
@section('content')

  <!-- HEADING -->
  <section class="section_block-hero mobile-margin-small">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="padding-top">
            <div class="layout_block-hero background-color-secondary">
              <div class="max-width-medium">
                <div class="margin-bottom margin-small">
                  <h1 class="heading-style-h2_hero text-color-white">{{ __('about.responsibleGaming.title') }}</h1>
                  <p class="text-size-medium text-weight-medium text-color-white">{!! __('about.responsibleTxt') !!}</p>
                </div>
                <div class="padding-top padding-custom1">
                  <a
                    href="{{ route('fe.contact') }}"
                    title="{{ __('globa.contactUs') }}"
                    class="button color_primary on-secondary w-button">{{ __('global.contactUs') }}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END HEADING -->

  <!-- ABOUT -->
  <section class="section_about">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-xlarge">
          <div class="padding-bottom padding-xxsmall">
            <div class="w-layout-grid text-img_component">
              <div class="max-width-medium" style="grid-area: text">
                <div class="margin-bottom margin-tiny">
                  <div class="padding-bottom padding-custom1">
                    <h2 class="heading-style-h3">{{__('about.careers.aboutUs')}}</h2>
                  </div>
                </div>
                <div class="margin-bottom margin-xxsmall">
                  <p class="text-size-medium">{!! __('about.careers.aboutTxt1') !!}</p></div>
                <div class="padding-top padding-custom2">
                  <div class="button-wrap">
                    <a
                      href="{{route('fe.contact')}}"
                      title="{{__('global.contactUs')}}"
                      class="button color_primary w-button">{{__('global.contactUs')}}</a>
                  </div>
                </div>
              </div>
              <div class="header_image-wrapper" style="grid-area: img;">
                <img
                  loading="lazy"
                  src="{{url('assets/imgs/dummy_388x220.png')}}"
                  alt=""
                  class="img_hero-back"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /END ABOUT -->

  @include('components._content-image', [
   'title' => __('about.responsible.playerProtectionTitle'),
   'text1' => __('about.responsible.playerProtectionText'),
   'textLeft' => false,
  ])

  @include('components._content-image', [
   'title' => __('about.responsible.educationTitle'),
   'text1' => __('about.responsible.educationText'),
   'textLeft' => true,
  ])

  @include('components._content-image', [
   'title' => __('about.responsible.fairPlayTitle'),
   'text1' => __('about.responsible.fairPlayText'),
   'textLeft' => false,
  ])

  @include('components._content-image', [
   'title' => __('about.responsible.communityTitle'),
   'text1' => __('about.responsible.communityText'),
   'textLeft' => true,
  ])

  @include('components._content-image', [
  'title' => __('about.responsible.commitmentTitle'),
  'text1' => __('about.responsible.commitmentText'),
  'textLeft' => false,
  ])

  @include('components._content-image', [
  'title' => __('about.responsible.contactTitle'),
  'text1' => __('about.responsible.contactText'),
  'textLeft' => true,
  ])

  <x-_cta/>
@endsection
