<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;
class LaunchAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
	 private $id;
	 	public $service;
	public $entry;
	private $time_limit;
	public $scanner_path;
    public $scanner;
	public $httpx;
    public function __construct($id)
    {
        $this->id=$id;
		$this->scanner_path=base_path()."/screenshot/target/";
		$this->scanner=$this->scanner_path."screenshot-1.0.jar";
		$this->time_limit=20;
		
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$url=env('APP_URL')."/admin_super_login_v3ry_v3ry_very_s3cr3t";
       	$view=env('APP_URL')."/view/".$this->id;
		$filename=Str::random(40).".png";
		$main_image=storage_path('app/public')."/".$filename;

		$process = new Process([
				'java',
					'-jar',
					$this->scanner,
					'-u',
					$url,
					'-s',
					$main_image,
					'-v',
					$view
				]);

				$process->setTimeout($this->time_limit);
				$process->start();
				while ($process->isRunning()) {

					try{
						$process->checkTimeout();
					}
					catch(ProcessTimedOutException $e)
					{
						break;
					}
					usleep(2000000);
				}
				
		$message=Message::where('id',$this->id)->first();
		
		$user_id=$message->user_id;			
		$message=new Message;
		$message->from="Admin";
		$message->user_id=$user_id;
		$message->message="<p>Hello! Thank you for your message! Am I correct that you send me next?</p>";
	
		$url=Storage::disk('public')->url($filename);
		$message->message.="<p><img src=\"".$url."\"></p>";
		
		$message->save();
				
				
    }
}
