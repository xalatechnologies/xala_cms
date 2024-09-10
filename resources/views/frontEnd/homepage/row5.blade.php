<?php
$ProcessLimit = 10; // 0 = all
$Processes = Helper::Topics(17, 0, $ProcessLimit, 1);
?>
@if(count($Processes)>0)
<!-- Process Model Section similar to Agile Software Model -->
<section class="agile-process-section bg-grey py-5">
    <div class="container text-center">
        <!-- Section Title -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="agile-process-title">{{ __('frontend.homeProcessTitle') }}</h2>
            </div>
        </div>

        <!-- Process Steps -->
        <div class="row justify-content-center align-items-center agile-steps">
            <?php
                    $ii = 1;
                    ?>

            @foreach($Processes->sortBy('id') as $Process)
            <?php
                    if ($Process->$title_var != "") {
                        $title = $Process->$title_var;
                        $desc = $Process->$details_var;
                    } else {
                        $title = $Process->$title_var2;
                        $desc = $Process->$details_var2;
                    }  
                    ?>

            <div class="col-12 col-md-3 text-center mb-4">
                <div class="agile-step">
                    <div class="step-circle step-circle-blue">{{ $ii }}</div>
                    <h5 class="step-title">{{ $title }}</h5>
                    <p class="step-description">{{ $desc }}</p>
                </div>
            </div>

            <!-- Arrow between steps -->
            @if($ii != 3 and $ii != 6)
            <div class="col-12 col-md-1 text-center d-none d-md-block">
                <i class="bi bi-arrow-right process-arrow"></i>
            </div>
            @endif
            <?php
                        $ii++;
                        ?>
            @endforeach

        </div>
    </div>
</section>

@endif
