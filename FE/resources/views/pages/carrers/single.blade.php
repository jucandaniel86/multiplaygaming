@extends('layouts.website')
@section('content')
  <!-- TITLE SECTION -->
  <section class="section_position mobile-margin-small background-color-primary">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="padding-top padding-small">
            <div class="wrap-header_career">
              <a
                href="{{ route('fe.about.careers') }}"
                class="button is-text-icon is-small w-inline-block">
                <div class="align-center w-embed">
                  <x-icons.arrow-left/>
                </div>
                <div>{{ __('careers.title') }}</div>
              </a>
              <div class="padding-top padding-small">
                <h1 class="heading-style-h4">{{ $job->job_title }}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END TITLE SECTION -->

  <!--CONTENT SECTION -->
  <section class="section_position mobile-margin-small">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="w-layout-grid layout_position">
            <!-- SOCIAL AREA -->
            <div class="component_video-position" style="grid-area: video">
              <div class="wrap-cards_career">
                <div class="item_hr">
                  <div class="text_hr">
                    <div class="text-style-s1">{!! __('careers.questions') !!}</div>
                  </div>
                  <div class="person_hr">
                    <img loading="lazy" src="{{ asset('assets/imgs/recruiter.jpg') }}" alt="" class="img_hr"/>
                    <div class="name_hr">
                      <div class="text-style-s4">{{__('careers.recruiter.name')}}</div>
                      <div class="text-size-small text-color-grey">{{__('careers.recruiter.position')}}</div>
                      @if(isset($linkein))
                        <a class="link_hr w-inline-block">
                          <img src="{{ asset('assets/imgs/linkedin.svg') }}" loading="lazy" class="icon-1x1-small"/>
                          <div>LinkedIn</div>
                        </a>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="item_video w-condition-invisible">
                  <div class="margin-top margin-tiny w-condition-invisible"></div>
                </div>
              </div>
              <div class="button-wrap_form-contact sticky">
                <a href="#cv" class="button color_primary w-button">{{__('careers.apply')}}</a>
              </div>
            </div>
            <!-- END SOCIAL AREA -->

            <!-- CONTENT AREA -->
            <div class="component_body-position" style="grid-area: text">
              <!-- HEADING -->
              <div class="heading_body-position">
                <div class="wrap_career-details">
                  @if($job->department)
                    <div class="item_game-features">
                      <div class="data_game-details">
                        <div class="text-style-l4 text-color-grey">{{__('careers.department')}}</div>
                        <div class="text-style-s4">{{ $job->department->name }}</div>
                      </div>
                    </div>
                  @endif
                  @if($job->required_experience)
                    <div class="item_game-features">
                      <div class="line-vertical_game-details hide-mobile-portrait"></div>
                      <div class="data_game-details">
                        <div class="text-style-l4 text-color-grey">{{__('careers.experience')}}</div>
                        <div class="text-style-s4">{{ $job->required_experience }}</div>
                      </div>
                    </div>
                  @endif
                  @if($job->employment_type)
                    <div class="item_game-features">
                      <div class="line-vertical_game-details hide-mobile-portrait"></div>
                      <div class="data_game-details">
                        <div class="text-style-l4 text-color-grey">{{__('careers.employment')}}</div>
                        <div class="text-style-s4">{{ $job->employment_type }}</div>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
              <!-- HEADING -->

              <!-- CONTENT -->
              <div class="text-rich-text padding-bottom padding-small w-richtext">
                {!! $job->content !!}

                @if($job->role_overview)
                  <p><strong>{{__('careers.role_overview')}}</strong></p>
                  {!! $job->role_overview !!}
                @endif

                @if($job->responsibilities)
                  <p><strong>{{__('careers.responsibilities')}}</strong></p>
                  {!! $job->responsibilities !!}
                @endif

                @if($job->requirements)
                  <p><strong>{{__('careers.requirements')}}</strong></p>
                  {!! $job->requirements !!}
                @endif

                @if($job->work_conditions)
                  <p><strong>{{__('careers.work_conditions')}}</strong></p>
                  {!! $job->work_conditions !!}
                @endif
              </div>
              <!-- END CONTENT -->
            </div>
            <!-- END CONTENT AREA -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END CONTENT SECTION -->

  <!-- CV -->
  <section id="cv" class="section_cta-careers background-color-primary">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-medium">
          <div class="padding-bottom padding-small">
            <div class="padding-bottom padding-small show-tablet"></div>
            <div class="w-layout-grid component_cta-career">
              <div class="max-width-medium" style="grid-area: text">
                <div class="margin-bottom margin-tiny">
                  <h2 class="heading-style-h2_hero">No Job for you at the moment?</h2></div>
                <div class="max-width-small">
                  <p class="text-size-medium text-weight-medium">Even if you don’t see a
                    position that matches your skill set right now, send us your CV and we will keep it on file and let
                    you know if anything else comes up</p>
                </div>
              </div>
              <div style="grid-area: img;"
                   class="wrap_form-contact background-color-white">
                <div class="margin-bottom margin-xsmall">
                  <div class="text-style-s1">{{__('careers.submit')}}</div>
                </div>
                <div class="form_component-clients w-form">
                  <form
                    action="javascript:"
                    method="get"
                    class="form_contact career"
                  >
                    <div class="form-wrap_contact">
                      <div class="form_field-wrapper">
                        <label for="full_name" class="form_label">{{__('careers.name')}}</label>
                        <div class="_100 w-embed">
                          <input
                            type="text"
                            id="full_name"
                            name="name"
                            class="form_input embed"
                            placeholder="{{__('careers.name_short')}}"
                            required="">
                        </div>
                      </div>
                      <div class="form_field-wrapper">
                        <label for="email" class="form_label">{{__('careers.email')}}</label>
                        <div class="_100 w-embed">
                          <input
                            type="email"
                            id="email"
                            name="email"
                            class="form_input embed"
                            placeholder="email@domain.com"
                            required="">
                        </div>
                      </div>
                      <div class="form_field-wrapper">
                        <label for="career" class="form_label">{{__('careers.job')}}</label>
                        <select
                          id="career"
                          name="career"
                          class="hs-input w-select">
                          @foreach($jobs as $item)
                            <option
                              value="{{ $item->id }}"
                              @if($job->id == $item->id) selected @endif
                            >{{ $item->job_title }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form_field-wrapper">
                        <div class="item_upload w-file-upload">
                          <div class="upload_default w-file-upload-default">
                            <input
                              class="w-file-upload-input"
                              accept=""
                              name="cv"
                              type="file"
                              id="cv_file"
                              required=""
                              style="height: 44.0156px; width: 1px;">
                            <label
                              role="button"
                              for="cv_file"
                              class="button is-small is-icon color_theme upload w-file-upload-label">
                              <div class="w-inline-block">{{__('careers.uploadCV')}}</div>
                              <div class="w-embed">
                                <x-icons.upload/>
                              </div>
                            </label>
                            <div class="upload_text w-file-upload-info">{{__('careers.max_filesize')}}</div>
                          </div>
                          <div
                            class="upload_state w-file-upload-uploading w-hidden">
                            <div
                              class="button is-small is-icon color_theme upload w-file-upload-uploading-btn">
                              <x-icons.loading-animation/>
                              <div class="w-inline-block">Uploading...</div>
                            </div>
                          </div>
                          <div class="upload_state w-file-upload-success w-hidden">
                            <div class="button is-small is-icon color_theme upload w-file-upload-file">
                              <div class="text-weight-medium w-file-upload-file-name"></div>
                              <div aria-label="Remove file" role="button" tabindex="0"
                                   class="icon-link w-file-remove-link">
                                <div class="icon w-icon-file-upload-remove" aria-hidden="true">X</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <label
                      class="w-checkbox form_checkbox agreement_check">
                      <div
                        class="w-checkbox-input w-checkbox-input--inputType-custom footer_checkbox-icon has-small-text"></div>
                      <input
                        type="checkbox"
                        name="Agreement"
                        id="personal_data_checkbox"
                        data-name="Agreement"
                        style="opacity:0;position:absolute;z-index:-1">
                      <span
                        for="Agreement"
                        id="personal_data_label"
                        class="form_checkbox-label text-size-small w-form-label">
                        {{__('careers.agree')}}
                      </span>
                    </label>
                    <div class="button-wrap_form-contact margin-up">
                      <input
                        type="submit"
                        id="submit"
                        disabled="disabled"
                        class="button color_primary data-process w-button is-disabled"
                        value="{{__('careers.send')}}">
                    </div>
                  </form>
                  <div class="form_message-success w-form-done" tabindex="-1"></div>
                  <div class="form_message-error w-form-fail" tabindex="-1"></div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /CV -->

  <!-- CV FORM:: Login -->
  <script>
    Object.prototype.hasOwnNestedProperty = function (propertyPath) {
      if (!propertyPath)
        return false;

      var properties = propertyPath.split('.');
      var obj = this;

      for (var i = 0; i < properties.length; i++) {
        var prop = properties[i];

        if (!obj || !obj.hasOwnProperty(prop)) {
          return false;
        } else {
          obj = obj[prop];
        }
      }

      return true;
    };

    const resetForm = () => {
      $("#full_name").val("");
      $("#email").val("");
      $("#career").val({{ $job->id }});
      $("#cv_file").val('');
      $(".upload_state").addClass('w-hidden');
      $('.upload_default').removeClass('w-hidden');
    }

    $(document).ready(function () {
      $("#personal_data_checkbox").on('change', function () {
        const checked = $(this).prop('checked');
        if (checked) {
          $("#submit").removeAttr('disabled').removeClass('is-disabled');
        } else {
          $("#submit").attr('disabled', true).addClass('is-disabled');
        }
      });
      $("#submit").on('click', async () => {
        let formData = new FormData();
        formData.append('name', $("#full_name").val());
        formData.append('email', $("#email").val());
        formData.append('career', $("#career").val());

        var cvFile = document.querySelector('#cv_file');
        formData.append("cv", cvFile.files[0]);

        try {
          const {data} = await axios.post(baseURL + 'api/submit-your-cv', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
          if (data.success) {
            $(".form_message-error").hide().html("");
            $(".form_message-success").show().html(data.message);
            resetForm();
          }
        } catch (err) {
          $(".form_message-success").hide();
          if (err.hasOwnNestedProperty('response.data.message')) {
            $(".form_message-error").show().html(err.response.data.message);
          }
        }
      });
    })
  </script>
  <!-- END CV FORM:: Login -->

@endsection
