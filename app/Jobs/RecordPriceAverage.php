<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\TextbookPriceAverage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordPriceAverage implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		foreach (Post::selectRaw("AVG(price) as avg, MIN(price) as min, MAX(price) as max, isbn, `uni-id` as uni")->groupBy(['isbn', 'uni-id'])->cursor() as $result) {
			TextbookPriceAverage::create([
				'isbn' => $result->isbn,
				'avg' => round($result->avg, 0),
				'min' => $result->min,
				'max' => $result->max,
				'uni_id' => $result->uni,
			]);
		}
	}
}
