<?php
$home_page_id = Helper::GeneralWebmasterSettings("home_content4_section_id");
?>
@if($home_page_id >0)
<?php
$HomePage = Helper::Topic(Helper::GeneralWebmasterSettings("home_content4_section_id"));
$page_form = @$HomePage->form;
?>
@if(!empty($HomePage))
@if(@$HomePage->$details_var !="")
{!! @$HomePage->$details_var !!}
@if(!empty($page_form))
<?php
        $form_url = Helper::sectionURL($page_form->id);
        ?>
<div class="text-center mt-3">
    <a href="{{ $form_url }}" class="btn btn-lg btn-primary">
        <i class="fa-solid fa-send-o"></i> {{ __('backend.submit') }} {!! $page_form->{"title_".@Helper::currentLanguage()->code} !!}
    </a>
</div>
@endif
@endif
@endif
@endif