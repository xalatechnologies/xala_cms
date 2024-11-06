<?php
$ClientsLimit = 12;
$Clients = Helper::Topics(9, 0, $ClientsLimit, 1);
?>
@if(count($Clients)>0)
<section id="Tools" class="tools-section bg-grey py-5">
    <div class="container">
        <!-- Section Title -->
        <div class="row mb-4 text-center">
            <div class="col-12">
                <h2 class="tools-title">{{ __('frontend.clientsTitle') }}</h2>
                <p class="section-subtitle">{{ __('frontend.clientsDesc') }}</p>
            </div>
        </div>

        <!-- Tools Cards Grid -->
        <div class="row tools-grid">
            @foreach($Clients->sortBy('id') as $Client)
            <?php
                    if ($Client->$title_var != "") {
                        $title = $Client->$title_var;
                    } else {
                        $title = $Client->$title_var2;
                    }

                    ?>

            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="tool-card text-center p-3">
                    <img src="{{ URL::to('uploads/topics/'.$Client->photo_file) }}" alt="{{ $title }}" class="img-fluid mb-2">
                </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="more-btn">
                    <a href="#Contact" class="btn cta-button cta-button-primary"> {{ __('frontend.getintouch') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
