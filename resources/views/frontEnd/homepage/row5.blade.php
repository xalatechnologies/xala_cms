<?php
$ProcessLimit = 10; // 0 = all
$Processes = Helper::Topics(17, 0, $ProcessLimit, 1);
?>
@if(count($Processes)>0)
<!-- Process Model Section similar to Agile Software Model -->
<section class="agile-process-section bg-grey py-8">
    <div class="container text-center">
        <!-- Section Title -->
        <div class="row">
            <div class="col-12">
                <h2 class="agile-process-title">{{ __('frontend.homeProcessTitle') }}</h2>
            </div>
        </div>

        <!-- Process Steps -->
        <div class="row justify-content-center text-center process-flow">
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

            <div class="col-6 col-md-2 text-center">
                <div class="agile-step">
                <div class="step-circle step-circle-blue">{{ $ii }}
                            @if (!$loop->last)
                                <i class="fas fa-arrow-right process-arrow"></i>                            
                            @endif
                            </div>
                    <h5 class="step-title">{{ $title }}</h5> 
                </div>
            </div>

          
            <?php
                        $ii++;
                        ?>
            @endforeach

        </div>
    </div>
</section>

@endif

@push('after-scripts')
     <script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    if (window.innerWidth <= 768) { // Check if it's mobile
        // Hide arrows for step 2 and step 4 on mobile
        document.querySelectorAll('.agile-step').forEach(function(step, index) {
            if (index === 1 || index === 3) { // 2nd and 4th step (index starts from 0)
                let arrow = step.querySelector('.process-arrow');
                if (arrow) {
                    arrow.style.display = 'none';
                }
            }
        });
    }
});
</script>
@endpush