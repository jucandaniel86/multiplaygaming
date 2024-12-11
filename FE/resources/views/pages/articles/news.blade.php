@extends('layouts.website')
@section('content')
  @include('pages.articles.block')

  @if(isset($articles) && count($articles) > 0)
    <section class="section_slider-hero">
      <div class="padding-global">
        <div class="container-large">
          <div class="padding-section-small">
            <div class="padding-top padding-xxsmall">
              <div class="padding-top">
                <div class="w-layout-grid header_component slider">
                  <div class="component_news-banner" style="grid-area: text">
                    <div class="max-width-medium">
                      <div class="margin-bottom margin-tiny">
                        <div class="text-size-regular text-color-white text-weight-medium">
                          {{ $articles[0]->published_date ?
                             Carbon\Carbon::parse($articles[0]->published_date)->format("M d, Y") :
                             Carbon\Carbon::parse($articles[0]->updated_at)->format("M d, Y")
                          }}
                        </div>
                      </div>
                      <h2 class="heading-style-h2_hero text-color-white">
                        {{ $articles[0]->short_title != '' ? $articles[0]->short_title : $articles[0]->title }}
                      </h2>
                      <div class="margin-top margin-small">
                        <div class="button-group">
                          <a
                            href="{{ route('fe.articles.single', [ 'slug' => $articles[0]->slug, 'id' => $articles[0]->id]) }}"
                            class="button color_primary on-secondary w-button">{{ __('global.seeDetails') }}</a>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="header_image-wrapper" style="grid-area: img; justify-content: center;">
                    @if($articles[0]->banner_url)
                      <img
                        style="max-height: 530px; object-fit: none;"
                        src="{{ $articles[0]->banner }}"
                        alt="{{ $articles[0]->title }}"
                        class="img_hero-back-game"/>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif

  <section class="section_news mobile-margin-small">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="margin-bottom margin-xsmall">

            <div class="padding-section-medium">
              <div class="margin-bottom margin-xsmall">
                <h1 class="heading-style-h3">{{__('articles.news')}}</h1>
              </div>

              <div class="margin-bottom margin-xsmall">
                <div class="layout_filters news hide-mobile-portrait">
                  <div class="max-width-xsmall mobile-full">
                    <div class="item_search">
                      <img src="{{ asset('assets/imgs/icons/search.svg') }}" class="icon-1x1-xsmall"/>
                      <input
                        class="field_search w-input"
                        maxlength="256"
                        name="search_query"
                        placeholder="{{ __('games.search') }}"
                        type="text"
                        id="field-2"
                        data-type="articles"
                        required="">
                    </div>
                  </div>
                  <div class="item_filters">
                    <div class="wrap_filters">
                      <x-dropdown
                        :label="__('articles.type')"
                        :items="$categories"
                        :name="'categories'"
                      />
                      <x-custom-dropdown
                        :options="config('website.generalSort')"
                        :includes="['date']"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <!-- FILTERS -->

              <!-- ARTICLE LIST -->
              <div class="layout_games-main news" id="article-items-list">
                @foreach($articles as $key => $article)
                  <div
                    role="listitem"
                    class="item_games-main"
                  >
                    <a
                      href="{{ route('fe.articles.single', [ 'slug' => $article->slug, 'id' => $article->id]) }}"
                      class="link-block-15 w-inline-block"
                    >
                      <div class="card_news is-small hide-mobile-portrait">
                        <div
                          style="
                          @if($article->thumbnail )
                            background-image:url('{{ $article->thumbnail }}');
                          @endif
                            "
                          class="img_news is-second main-page"></div>

                        <div class="content_news">
                          @if($article->category)
                            <div class="label is-white">
                              <div>{{ $article->category->name }}</div>
                            </div>
                          @endif
                          <div class="wrap_news-heading">
                            <div class="wrap_news-arrow">
                              <div class="text-size-regular">
                                {{ $article->published_date ?
                                      Carbon\Carbon::parse($article->published_date)->format("M d, Y") :
                                      Carbon\Carbon::parse($article->updated_at)->format("M d, Y")
                                }}
                              </div>
                              <x-icons.arrow-right :class="'icon-1x1-small'"/>
                            </div>
                            <div>{{ $article->title }}</div>
                          </div>
                        </div>
                      </div>
                      <div class="card_news is-large mobile-news">
                        <div
                          style="
                          @if($article->thumbnail )
                            background-image:url('{{ $article->thumbnail }}');
                          @endif
                            "
                          class="img_news is-latest mobile"></div>
                        <div class="content_news">
                          @if($article->category)
                            <div class="label is-white">
                              <div>{{ $article->category->name }}</div>
                            </div>
                          @endif
                          <div class="wrap_news-heading">
                            <div class="wrap_news-arrow">
                              <div class="text-size-regular">
                                {{ $article->published_date ?
                                    Carbon\Carbon::parse($article->published_date)->format("M d, Y") :
                                    Carbon\Carbon::parse($article->updated_at)->format("M d, Y")
                                }}
                              </div>
                              <x-icons.arrow-right :class="'icon-1x1-small'"/>
                            </div>
                            <div>{{ $article->title }}</div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
              <!-- / ARTICLE LIST -->

              <!-- NOT FOUND -->
              <div
                class="margin-vertical margin-large align-center"
                id="article-no-results"
                @if(count($articles) > 0) style="opacity: 0" @endif
              >
                <div class="max-width-xsmall text-align-center">
                  <div class="margin-bottom margin-xxsmall">
                    <div class="img_no-results">
                      <x-icons.search-zoom/>
                    </div>
                  </div>
                  <div class="text-style-s2">{{__('articles.noResults')}}</div>
                  <div class="text-size-small text-weight-medium text-color-grey">{{__('articles.noResultTxt')}}</div>
                </div>
              </div>
              <!-- /NOT FOUND -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- TEMPLATE ID -->
  <template id="article-item-template">
    <div
      role="listitem"
      class="item_games-main"
    >
      <a
        href=""
        class="link-block-15 w-inline-block"
      >
        <div class="card_news is-small hide-mobile-portrait">
          <div style=" "
               class="img_news is-second main-page"></div>

          <div class="content_news">
            <div class="label is-white article-item-category">
              <div></div>
            </div>
            <div class="wrap_news-heading">
              <div class="wrap_news-arrow">
                <div class="text-size-regular article-publish-date"></div>
                <x-icons.arrow-right :class="'icon-1x1-small'"/>
              </div>
              <div class="article-title"></div>
            </div>
          </div>
        </div>
        <div class="card_news is-large mobile-news">
          <div
            style=""
            class="img_news is-latest mobile"></div>
          <div class="content_news">
            <div class="label is-white  article-item-category">
              <div></div>
            </div>
            <div class="wrap_news-heading">
              <div class="wrap_news-arrow">
                <div class="text-size-regular article-publish-date"></div>
                <x-icons.arrow-right :class="'icon-1x1-small'"/>
              </div>
              <div class="article-title"></div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </template>

  <input name="article_type" value="news" type="hidden"/>

  <x-_cta/>
@endsection
