<section class="section_may-like">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-medium">
        @if(isset($title))
          <div class="padding-bottom padding-small">
            <h2 class="heading-style-h3">{{ $title }}</h2>
          </div>
        @endif
        <div>
          @if(isset($articles)  && count($articles))
            <div role="list" class="{{ isset($class) ? $class : 'component_may-like' }}">
              @foreach($articles as $key => $article)
                <div
                  role="listitem"
                  class="{{ isset($itemClass) ? $itemClass : "collection_item-may-like" }}">
                  <a
                    href="{{ route('fe.articles.single', [ 'slug' => $article->slug, 'id' => $article->id ]) }}"
                    title="{{ $article->title }}"
                    class="card_news is-second article w-inline-block">
                    <div
                      style="
                      @if($article->thumbnail )
                        background-image:url('{{ $article->thumbnail }}');
                      @endif
                        grid-area: news-2;"
                      class="img_news {{ (isset($itemClass) && $itemClass   === "item_seo-news") && $key === 2 ? 'is-long' : 'is-second_small'  }}"></div>
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
                  </a>
                  <a
                    href="{{ route('fe.articles.single', [ 'slug' => $article->slug, 'id' => $article->id ]) }}"
                    title="{{ $article->title }}"
                    class="card_news is-latest article w-inline-block">
                    <div
                      style="
                      @if($article->thumbnail )
                        background-image:url('{{ $article->thumbnail }}');
                      @endif
                        "
                      class="img_news is-latest"></div>
                    <div class="content_news is-large">
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
                  </a>
                </div>
              @endforeach
              @if(count($articles) >= 3)
                <a
                  href="{{ route((isset($route) ? $route: 'fe.articles')) }}"
                  title="{{ __('global.allArticles')  }}"
                  class="card_button  w-inline-block">
                  <div class="button is-text">
                    <div>{{ __('global.allArticles') }}</div>
                  </div>
                  <div class="icon_button-text w-embed">
                    <x-icons.arrow-right/>
                  </div>
                </a>
              @endif
            </div>
          @endif
        </div>
        <div class="padding-bottom padding-xsmall hide-mobile-landscape"></div>
      </div>
    </div>
  </div>
</section>
