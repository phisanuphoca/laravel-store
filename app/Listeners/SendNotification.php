<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\NewOrderSendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification implements ShouldQueue
{
  use InteractsWithQueue;
  public $tries = 3;
  /**
   * Create the event listener.
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   */
  public function handle(OrderCreated $event): void
  {
    try {
      $output = new \Symfony\Component\Console\Output\ConsoleOutput();
      $output->writeln("<info>send email</info>");


      $mailData = [
        'title' => 'There is a new order',
        'body' => 'Please check the order from ' . $event->customer->email
      ];

      Mail::to($event->userReceiver->email)->send(new NewOrderSendMail($mailData));

      //more codes for other things
    } catch (\Exception $e) {
      $output->writeln("<error>error</error>");
    }
  }
}
