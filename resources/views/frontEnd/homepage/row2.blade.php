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
                <span class="badge badge-tag mb-3">{{ __('frontend.homeContents2Title') }}</span>
            </div>
            <div class="col-12 d-flex justify-content-between align-items-center">
                <!-- Title on the left and Pagination Arrows on the right -->
                <h2 class="work-title mb-0">{{ __('frontend.homeContents2desc') }}</h2>
                <div class="d-flex">
                    <button class="btn btn-slider me-2"><i class="bi bi-arrow-left"></i></button>
                    <button class="btn btn-slider"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="row">
            @foreach($Portfolios as $Portfolio)
            <?php
                    if ($Portfolio->$title_var != "") {
                        $title = $Portfolio->$title_var;
                    } else {
                        $title = $Portfolio->$title_var2;
                    }

                    ?>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="project-card">
                    <img src="{{ URL::to('uploads/topics/'.$Portfolio->photo_file) }}" alt="Ecommerce Store" class="img-fluid project-img">
                    <div class="project-content">
                        <div>
                            <h5 class="project-title">{{ $title }}</h5>
                            <div class="project-tags">
                                @foreach($Portfolio->tags as $PortfolioTag)
                                <span class="badge tag">{{ $PortfolioTag->$title }}</span>
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
