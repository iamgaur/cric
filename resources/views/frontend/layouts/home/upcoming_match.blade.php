<h2 itemprop="headline" class="mb-3">Upcomig Matches</h2>
	<div class="row row_Upcomig">
	@foreach($upcoming as $upmatch)	
		<div class="col-md-6">
			<a href="" class="live_match_mx mb-2">
				<div class="date_time_match_coming">
				<span class="date_match"> {{ date('d M Y', strtotime($upmatch['match_date'])) }} </span>
				<span class="time_match">4:30 PM | 11:00 AM GMT / 01:00 PM LOCAL</span>
				</div>
				<div class="live_match">
				<div class="img_mx_text"><img title="" alt="" src="img/india.png"> <span>{{ $upmatch['location'] }}</span></div>
				<div class="max_width_box"><h5>{{ $upmatch['match_title'] }}</h5></div>
				<div class="img_mx_text"><span>AUS</span><img title="" alt="" src="img/ast.jpg"> </div>
				</div>
			</a>
		</div>
	@endforeach	
	</div>
<div class="text-right">
	<a href="" class="btn">View More</a>
</div>