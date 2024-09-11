<?php
$PortfoliosLimit = 12; ; // 0 = all
$Portfolios = Helper::Topics(4, 0, $PortfoliosLimit, 1);
?>
@if(count($Portfolios)>0)
<!-- Work For Our Clients Section -->
<section class="work-section py-5">
    <div class="container">
        <!-- Section Heading: Badge on one line, Title and Arrows on the next -->
        <div class="row mb-4">
            <div class="col-12">
                <!-- Our Work Badge on the first line -->
                <span class="badge badge-tag mb-3">{{ __('frontend.ourWork') }}</span>
            </div>
            <div class="col-12 d-flex justify-content-between align-items-center">
                <!-- Title on the left and Pagination Arrows on the right -->
                <p class="mb-0">{{ __('frontend.ourWorkDesc') }}</p>
                <div class="d-flex">
                    <button class="btn btn-slider me-2"><i class="bi bi-arrow-left"></i></button>
                    <button class="btn btn-slider"><i class="bi bi-arrow-right"></i></button>
                </div>
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

                    ?>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="project-card">
                    <img src="{{ URL::to('uploads/topics/'.$Portfolio->photo_file) }}" alt="{{ $title }}" class="img-fluid project-img">
                    <div class="card-content p-3">
                        <div>
                            <h4>{{ $title }}</h4>
                            <p>{{ $details }}</p>
                            <div class="project-tags">
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
                        <a href="#" class="arrow-link">
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="row mt-5">
            <div class="col text-center">
                <a href="/portfolio" class="btn cta-button cta-button-primary"> {{ __('frontend.viewMore') }}</a>
            </div>
        </div>
    </div>
</section>
@endif
