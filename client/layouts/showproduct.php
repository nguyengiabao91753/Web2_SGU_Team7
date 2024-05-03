<!-- Slider -->
<?php include("slider.php") ?>


<!-- Banner -->
<?php include("small-banner.php") ?>
<script>
	//phân trang đê


	//load dữ liệu
	function loadData(pageNumber) {
		var rowofPage = 8;
		$(".row.showsp").empty();
		$.ajax({
			url: '../chucnang/phantrang.php',
			type: 'get',
			data: {
				tableName: "products",
				rowofPage: rowofPage,
				pageNumber: pageNumber,
				ID: "ProductID",
				key: "feature"
			},
			// dataType: 'json',
			success: function(response) {
				$(".row.showsp").append('<p>hello</p>');
				$(".row.showsp").html(response);
			}

		});
	}

	$(document).ready(function() {

		loadData(1);

	});
</script>


<section class="bg0 p-t-23 p-b-140">
	<div class="container">
		<div class="p-b-10">
			<h3 class="ltext-103 cl5">
				Featured
			</h3>
		</div>

		<div class="row showsp">

		</div>
		
	</div>
</section>