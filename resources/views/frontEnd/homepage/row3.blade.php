<?php
$StaffLimit = 6; // 0 = all
$Staff = Helper::Topics(Helper::GeneralWebmasterSettings("home_content5_section_id"), 0, $StaffLimit, 1);
?>
@if(count($Staff)>0)
<section id="Staff" id="staff" class="staff bg-grey">
    <div class="container">
        <h2 class="section-title">{{ __('frontend.homeStaffTitle') }}</h2>
        <p class="section-subtitle text-center mb-5">{{ __('frontend.homeStaffDesc') }}</p>

        <div class="row">
            <?php
                $section_url = "";
                ?>
            @foreach($Staff->sortBy('id') as $Topic)
            <?php
                    if ($Topic->$title_var != "") {
                        $title = $Topic->$title_var;
                    } else {
                        $title = $Topic->$title_var2;
                    }
                    if ($Topic->$details_var != "") {
                        $details = $details_var;
                    } else {
                        $details = $details_var2;
                    }
                    if ($section_url == "") {
                        $section_url = Helper::sectionURL($Topic->webmaster_id);
                    }
                    $topic_link_url = Helper::topicURL($Topic->id,"",$Topic);
                    $HomeSectionType = @$Topic->webmasterSection->type;
                    if (!@$require_mp3_player && $HomeSectionType == 3) {
                        $require_mp3_player = 1;
                    }
                    ?>
            <div class="col-lg-6 mb-4">
                <div class="member d-flex align-items-start">
                    @if($Topic->photo_file !="")
                    <a href="{{ $topic_link_url }}">
                        <div class="pic">
                            <img class="img-fluid" loading="lazy" src="{{ URL::to('uploads/topics/'.$Topic->photo_file) }}" width="120" height="120" alt="{{ $title }}" />
                        </div>
                    </a>
                    @endif
                    <div class="member-info">
                        <a href="{{ $topic_link_url }}">
                            <h4>{!! $title !!}</h4>
                        </a>
                        {{--Additional Feilds--}}
                        @include("frontEnd.topic.fields",["cols"=>12,"Fields"=>@$Topic->webmasterSection->customFields->where("in_listing",true)])
                        <span></span>

                        @if(strip_tags($Topic->$details) !="")
                        <p>
                            {!! strip_tags($Topic->$details) !!}
                        </p>
                        
                        <a class="mt-2" href="{{ $topic_link_url }}">{{ __("frontend.moreDetails") }}</a>

                        @endif

                        {{-- @if(strip_tags($Topic->$details) !="")
                        <p>
                            {!! mb_substr(strip_tags($Topic->$details),0, 140)."..." !!}
                           
                        </p>
                        @endif --}}
                    </div>
                </div>
            </div>
            @endforeach

        </div>


    </div>
</section>
@endif
