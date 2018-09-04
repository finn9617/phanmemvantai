@extends('blank')
@section('content')
<script type="text/javascript">

	// $(document).ready(function(){
	// 	$('#clearFrom').click(function(){
	// 		alert('the action is: ' + $('#acountForm').attr('action'));
	// 		// $("#acountForm").remove();
	// 		// document.getElementById('acountForm').submit();
	// 	})
	// })

	$(document).ready(function(){	
	function back(){
		// alert('11');
		window.history.back();
	}
</script>
@if(isset($formCreat))
<section class="content-header">

	      <!-- back page -->
      <div class="row">
        <div class="col-md-12 prePage">
          <a href="#" onclick="back()" class="" id="back">
            <span class="glyphicon glyphicon-step-backward">
              <span class="prePage">Quay lại </span>
            </span>
          </a>
        </div>
      </div>
      <!-- ./ back page -->
</section>
<section class="content">
<div class="row">
	<div class="col-md-12">
	<div class="box box-warning col-md-11">
		<div class="box-body">
		@if ($errors->any())
	    <div class="callout callout-danger">
	    	<h4><i class="glyphicon glyphicon-warning-sign"></i>&nbsp&nbspCó lỗi xảy ra</h4>
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
		@endif
			{!!$formCreat!!}
		</div>
	</div>
	</div>
</div>
</section>
@endif

@endsection


