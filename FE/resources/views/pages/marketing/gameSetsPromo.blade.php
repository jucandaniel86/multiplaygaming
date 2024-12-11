@extends('layouts.website')
@section('content')
  <section class="section_games">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="margin-bottom margin-xsmall">
            <form action="#">
              <div class="margin-bottom margin-tiny">
                <!-- SEARCH FORM -->
                <x-form.search-item :title="__('marketing.game.title')"/>
                <!-- END SEARCH FORM -->
              </div>
            </form>
          </div>

          <div class="collection_campaign">
            <!-- ARTICLES LIST -->
            <div class="layout_campaigns-main" role="list" id="article-items-list">
              @foreach($articles as $article)
                <div class="item_campaigns-main" role="listitem">
                  <a
                    href="{{ route('fe.articles.single', ['slug' => $article->slug, 'id' => $article->id]) }}"
                    title="{{ $article->title }}"
                    class="card_campaign is-small hide-mobile-portrait w-inline-block">
                    <div
                      class="img_campaign"
                      alt="{{ $article->title }}"
                      style="background: url('{{ $article->thumbnail !== '' ? $article->thumbnail : asset('assets/imgs/dummy_586x460.png') }}')"></div>
                    <div class="content_campaign is-second">
                      <div class="wrap-label_campaign">
                        <div class="label is-secondary w-condition-invisible">
                          <div class="w-dyn-bind-empty"></div>
                        </div>
                      </div>
                      <div class="wrap_campaign-heading">
                        <div class="wrap_news-arrow">
                          <div class="text-size-regular w-dyn-bind-empty"></div>
                          <x-icons.arrow-right :class="'icon-1x1-small card_arrow'"/>
                        </div>
                        <div>{{ $article->title }}</div>
                      </div>
                    </div>
                  </a>
                  <div class="card_campaign is-large campaigns">
                    <div class="wrap-img_campaign is-latest">
                      <img
                        loading="lazy"
                        alt="{{ $article->title }}"
                        src="{{ $article->thumbnail !== '' ?
                            $article->thumbnail :
                            asset('assets/imgs/dummy_586x460.png')
                        }}"
                        class="img_compaign"/>
                    </div>
                    <a href="#" class="content_campaign w-inline-block">
                      <div class="wrap-label_campaign">
                        <div class="label is-secondary w-condition-invisible">
                          <div class="w-dyn-bind-empty"></div>
                        </div>
                        <div class="label_compaigns is-white w-condition-invisible">
                          <span class="icon-1x1-small card_arrow">
                            <x-icons.arrow-right/>
                          </span>
                        </div>
                      </div>
                      <div class="wrap_campaign-heading">
                        <div class="wrap_news-arrow">
                          <div class="text-size-regular w-dyn-bind-empty"></div>
                          <span class="icon-1x1-small card_arrow">
                            <x-icons.arrow-right/>
                          </span>
                        </div>
                        <div>{{ $article->title }}</div>
                      </div>
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
            <!-- END ARTICLES LIST -->
          </div><!-- /.collection_campaign -->
        </div>
      </div>
    </div>
  </section>

  <!-- TEMPLATE ID -->
  <template id="article-item-template">
    <div class="item_campaigns-main" role="listitem">
      <a
        href="#"
        class="card_campaign is-small hide-mobile-portrait w-inline-block link-block-15">
        <div class="img_campaign img_news"></div>
        <div class="content_campaign is-second">
          <div class="wrap-label_campaign">
            <div class="label is-secondary w-condition-invisible">
              <div class="w-dyn-bind-empty"></div>
            </div>
          </div>
          <div class="wrap_campaign-heading">
            <div class="wrap_news-arrow">
              <div class="text-size-regular w-dyn-bind-empty"></div>
              <x-icons.arrow-right :class="'icon-1x1-small card_arrow'"/>
            </div>
            <div class="article-title"></div>
          </div>
        </div>
      </a>
      <div class="card_campaign is-large campaigns">
        <div class="wrap-img_campaign is-latest">
          <img
            loading="lazy"
            alt=""
            src=""
            class="img_compaign"/>
        </div>
        <a href="#" class="content_campaign w-inline-block">
          <div class="wrap-label_campaign">
            <div class="label is-secondary w-condition-invisible">
              <div class="w-dyn-bind-empty"></div>
            </div>
            <div class="label_compaigns is-white w-condition-invisible">
              <span class="icon-1x1-small card_arrow">
                <x-icons.arrow-right/>
              </span>
            </div>
          </div>
          <div class="wrap_campaign-heading">
            <div class="wrap_news-arrow">
              <div class="text-size-regular w-dyn-bind-empty"></div>
              <span class="icon-1x1-small card_arrow">
                <x-icons.arrow-right/>
              </span>
            </div>
            <div class="article-title"></div>
          </div>
        </a>
      </div>
    </div>
  </template>
  <!-- END TEMPLATE ID -->

  <input name="article_type" value="promo_games" type="hidden"/>

  @include('components._tools', [
	  'title' => __('marketing.tools.toolsTitle'),
	  'list' => __('marketing.tools.toolsList')
  ])
  @include('components._cta')
@endsection
