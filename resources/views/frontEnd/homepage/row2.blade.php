<?php
$PortfoliosLimit = 12; ; // 0 = all
$Portfolios = Helper::Topics(4, 0, $PortfoliosLimit, 1);
?>
@if(count($Portfolios)>0)
<!-- Work For Our Clients Section -->
<section id="CaseStudy" class="work-section py-5">
    <div class="container">
        <!-- Section Heading: Badge on one line, Title and Arrows on the next -->
        <div class="row mb-4">
            <div class="col-12">
                <!-- Our Work Badge on the first line -->
                <span class="badge badge-tag mb-3">{{ __('frontend.ourWork') }}</span>
            </div>
            <div class="col-12 d-flex justify-content-between align-items-center">
                <!-- Title on the left and Pagination Arrows on the right -->
                <p class="mb-0 section-subtitle">{{ __('frontend.ourWorkDesc') }}</p>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="row">
            @foreach($Portfolios->sortBy('id') as $Portfolio)
            <?php
                    if ($Portfolio->$title_var != "") {
                        $title = $Portfolio->$title_var;
                        $details = $Portfolio->$details_var;
                    } else {
                        $title = $Portfolio->$title_var2;
                        $details = $Portfolio->$details_var2;
                    }
                    $url = $Portfolio->seo_url_slug_en;

                    ?>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                
                <div class="project-card p-2">
                    <img src="{{ URL::to('uploads/topics/'.$Portfolio->photo_file) }}" alt="{{ $title }}" class="img-fluid project-img">
                    <div class="card-body p-3">
                       
                                <h5 class="step-title">{{ $title }}</h5>
                                
                                @if($Portfolio->fields->get(1))
                                    <p class="text-muted">{{$Portfolio->fields->get(1)->field_value}}</p>
                                @endif
                                <p>{!! $details !!}</p>

                                <div class="project-tags text-center pt-2">
                                    @foreach($Portfolio->tags as $PortfolioTag)
                                    <?php
                                        $PortfolioTaged = Helper::Tag($PortfolioTag->tag_id);
                                    ?>
                                    @if($PortfolioTaged != null)
                                        <span class="badge tag mb-1">{{ $PortfolioTaged->title }}</span>
                                        @endif
                                    @endforeach
                                </div>
                    </div>
                    <div class="card-footer mt-auto text-center p-3">
                        <a href="{{ "case-studies/".$url }}" class="btn cta-button cta-button-primary"> {{ __('frontend.viewDetails') }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="row">
            <div class="col text-center">
                <a href="case-studies" class="btn cta-button cta-button-primary"> {{ __('frontend.viewMore') }}</a>
            </div>
        </div>
    </div>
</section>
@endif
