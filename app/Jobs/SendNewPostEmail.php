<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPUnit\Logging\Exception;

class SendNewPostEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    /*
    target arr
    subject str
    body str
    */

    public static function newMail($targetAddresses, $subject, $body): PHPMailer
    {

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'schwaksor@gmail.com'; // SMTP account username example
        $mail->Password = env('GMAIL_APP_PASS'); // app key password
        $mail->SMTPSecure = 'tls';

        foreach ($targetAddresses as $address) {
            $mail->addAddress($address);
        }

        $mail->Subject = $subject;

        // Email body
        $mail->Body = $body;

        return $mail;
    }

    /**
     * Create a new job instance.
     */
    public function __construct($targets, $subject, $body)
    {
        Log::info('job construct');
        //
        $this->email = ['target' => $targets, 'body' => $body, 'subject' => $subject];
        Log::info('job constructed');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('job sending');
        try {
            //
            $mail = $this::newMail($this->email['target'], $this->email['subject'], $this->email['body']);

            if (! $mail->send()) {
                Log::info('Message could not be sent.\n'.$mail->ErrorInfo);
            } else {
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
