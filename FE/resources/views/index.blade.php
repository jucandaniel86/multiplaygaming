@extends('layouts.website')
@section('content')
  <x-homepageslider :games="$sliderGames"/>

  {{--  <x-about--}}
  {{--    :title="__('home.scrolledComponent.title')"--}}
  {{--    :text="__('home.scrolledComponent.txt')"--}}
  {{--    :image="asset('assets/imgs/homebanner.png')"--}}
  {{--  />--}}
  <style>
    .online-creators__mobile {
      display: none;
    }

    .online-creators__desktop {
      display: block;
    }

    @media (max-width: 499px) {
      .online-creators__mobile {
        display: block;
      }

      .online-creators__desktop {
        display: none;
      }
    }
  </style>

  <section class="section_about-us padding-global">
    <div class="container-large padding-section-medium" style="overflow: hidden;">
      <img
        src="{{ asset('assets/imgs/online_casino_creators_2.jpg?v=1') }}"
        style="border-radius: 20px; "
        class="online-creators__desktop"
        alt=""/>
      <img
        src="{{ asset('assets/imgs/online_casino_creators_portrait.jpg?v=1') }}"
        class="online-creators__mobile"
        alt=""/>

    </div>
  </section>

  <x-highlight-component
    :title="__('home.highlightTitle')"
    :lang-source="'home.highlightItems'"
  />

  @include('components._featured_games', [
    'title' => __('global.featured_games'),
    'games' => $featuredGames
  ])

  <x-partners :style="'border-bottom:1px solid #ccc;'"/>

  <x-partners
    :title="__('marketing.tools.partnersPlatform')"
    :partner-type="'platform'"
  />

  <x-more-articles
    :title="__('home.latestNews')"
    :articles="$latestnews"
    :route="'fe.articles.news'"
  />

  <x-more-articles
    :title="__('home.popularArticles')"
    :articles="$lastarticles"
    :class="'layout_seo-news'"
    :itemClass="'item_seo-news'"
  />

  <x-_cta/>
@endsection
