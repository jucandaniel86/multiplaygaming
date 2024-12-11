@extends('layouts.website')
@section('content')
  <style>
    /*.component_hero-about {*/
    /*  flex-direction: row;*/
    /*}*/

    /*.wrap-img_hero-about {*/
    /*  position: relative;*/
    /*  right: auto;*/
    /*  height: 100%;*/
    /*}*/

    /*.wrap-img_hero-about img {*/
    /*  height: 100%;*/
    /*  position: relative;*/
    /*  right: auto;*/
    /*}*/
    .img_hero-about-2 {
      right: -1.125rem;
    }
  </style>
  <section class="section_hero-about">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-medium">
          <div class="component_hero-about">
            <div class="text-wrap_about">
              <div class="max-width-medium tablet-medium">
                <h1 class="heading-style-h2_hero margin-bottom margin-tiny">{{ __('about.company.pageTitle') }}</h1>
                <p class="text-size-medium text-weight-medium max-width-small">
                  {{ __('about.company.heroTxt') }}
                </p>
                <div class="margin-top margin-medium">
                  <a class="button w-button" href="#">{{ __('global.contactUs') }}</a>
                </div>
              </div>
            </div>
            <div class="image-component_about">
              <div class="wrap-img_hero-about">
                <img src="{{ asset('assets/imgs/gaming_powerhouse.png') }}" alt="" class="img_hero-about-2"/>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <x-highlight-component/>

  @include('components._content-image', [
    'title' => __('about.company.aboutTitle'),
    'text1' => __('about.company.aboutTxt'),
    'text2' => __('about.company.aboutTxt2'),
    'textLeft' => true,
    'button' => [
			'label' => __('global.contactUs'),
			'route' => 'fe.contact'
    ],
    'image' => 'assets/imgs/who_we_are.png'
  ])

  <x-scrolled-component
    :title="__('about.company.bestOfTitle')"
    :text="__('about.company.bestOfTxt')"
    :button="['label' => __('marketing.brand.getMoreInfo') ]">

    <div class="item_levels">
      <div>
        <div class="margin-bottom margin-tiny">
          <img
            src="https://cdn.prod.website-files.com/63b2c230b49fa188ad86ffec/63c83e44936369b2e03576c1_Casino-min.png"
            loading="lazy" class="img_feature"/>
          <h3 class="text-style-s1">Our Mission</h3>
        </div>
        <div class="text-size-medium">
          <ul>
            <li><b>Growth</b>: We are on a mission to expand our footprint worldwide, introducing our exceptional games
              to a
              broader audience of operators and technology partners.
            </li>
            <li><b>Innovation</b>: We are committed to advancing the technology behind our games, continuously enhancing
              their
              features to set new standards in the gaming experience.
            </li>
            <li><b>Player Engagement</b>: Our core focus is on the player; we aim to deliver games that are not only
              entertaining
              but deeply engaging and rewarding.
            </li>
          </ul>
        </div>
      </div>
    </div><!-- /.item_levels -->

    <div class="item_levels">
      <div>
        <div class="margin-bottom margin-tiny">
          <img
            src="https://cdn.prod.website-files.com/63b2c230b49fa188ad86ffec/63c83e44936369b2e03576c1_Casino-min.png"
            loading="lazy" class="img_feature"/>
          <h3 class="text-style-s1">Our Commitment</h3>
        </div>
        <div class="text-size-medium">
          With a foundation built on over ten years of experience in game development, Blue Jack Gaming is dedicated to
          excellence. Our transition from creating tailored solutions to becoming a leader in technology-driven slot
          entertainment underscores our commitment to innovation, quality, and the satisfaction of our partners and
          their players.
        </div>
      </div>
    </div><!-- /.item_levels -->

  </x-scrolled-component>


  <x-_partners/>
  <x-_cta/>
@endsection
