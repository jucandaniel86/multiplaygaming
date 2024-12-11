@extends('layouts.website')
@section('content')
  @include('pages.articles.block')
  <section class="section_news mobile-margin-small">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="margin-bottom margin-xsmall">
            <div class="button-wrap">
              <a
                href="{{ route('fe.home') }}"
                class="button is-text-icon is-small w-inline-block">
                <div class="align-center w-embed">
                  <x-icons.arrow-left/>
                </div>
                <div>{{__('global.backToHome')}}</div>
              </a>
            </div>
          </div>

          <div class="margin-bottom margin-xsmall">
            <!-- SEARCH FORM -->
            <x-form.search-item :title="__('articles.articles')"/>

            <!-- FILTERS -->
            <div class="layout_filters news hide-mobile-portrait">
              <div class="wrap_filters-type">
                <div class="item_filters">
                  <label class="form_label">{{__('global.filterBy')}}</label>
                  <div class="wrap_filters">
                    @foreach($categories as $key => $category)
                      <a
                        href="#"
                        data-id="{{ $category->id }}"
                        title="{{ $category->label }}"
                        class="button is-small filter article-type w-button">
                        {{ $category->label }}
                      </a>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="item_filters">
                <label class="form_label">{{__('global.sortBy')}}</label>
                <x-custom-dropdown
                  :options="config('website.generalSort')"
                  :includes="['date']"
                />
              </div>
            </div>
          </div>

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
            id="games-no-results"
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
  <input name="article_type" value="articles" type="hidden"/>

  <x-_cta/>
@endsection
