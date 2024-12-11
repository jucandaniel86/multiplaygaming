<div
  role="listitem"
  class="item_position">
  <a
    href="{{ route('fe.careers.single', ['slug' => $job->slug, 'id' => $job->id]) }}"
    class="card_position w-inline-block">
    <div class="header_card">
      <div class="margin-bottom margin-xsmall">
        @if($job->department)
          <div class="label is-white">
            <div>{{ $job->department->name }}</div>
          </div>
        @endif
      </div>
      <div class="text-style-s1 caps cairo">{{ $job->job_title }}</div>
      <div class="wrap_positions-details">
        <div class="text-size-regular">{{ $job->employment_type }}</div>
        <div class="divider-verticle_position"></div>
        <div class="text-size-regular">{{ $job->required_experience }}</div>
        <div class="text-size-regular hide">
          {{ Carbon\Carbon::parse($job->created_at)->format("M d, Y") }}
        </div>
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
