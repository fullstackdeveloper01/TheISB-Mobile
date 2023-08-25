<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Mail;

class UserResetPasswordNotification extends Notification
{
    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(url('/') . route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false));
        $expire = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');
        $subcopy = mailTemplates('If you are having trouble clicking the button, just copy and paste the URL below into your web browser', 'reset password notification');

        $email = $notifiable->getEmailForPasswordReset();
        $subject = mailTemplates('Reset Password Notification', 'reset password notification');
        
        $emailData['url'] = $url;
        $emailData['expire'] = $expire;
        $emailData['user_name'] = mailTemplates('Hello!', 'reset password notification');
        $html = view('mail.reset-password',$emailData);

       $this->sendEmail_($email, $subject, $html);

        return (new MailMessage)
            ->subject(mailTemplates('Reset Password Notification', 'reset password notification'))
            ->greeting(mailTemplates('Hello!', 'reset password notification'))
            ->line(mailTemplates('You are receiving this email because we received a password reset request for your account.', 'reset password notification'))
            ->action(mailTemplates('Reset Password', 'reset password notification'), $url)
            ->line(str_replace('{time}', $expire, mailTemplates('This password reset link will expire in {time} minutes.', 'reset password notification')))
            ->line(mailTemplates('If you did not request a password reset, no further action is required.', 'reset password notification'))
            ->salutation(mailTemplates('Regards', 'reset password notification'))
            ->markdown('vendor.notifications.email', [
                'subcopy' => $subcopy,
            ]);            
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function sendEmail_($email,$subject,$message)
    {   
        $params = array(

            'to'        => $email,   

            'subject'   => $subject,

            'html'      => $message,

            'from'      => 'support@html.manageprojects.in',
            
            'fromname'  => 'Framesport'

        );

        $request =  'https://api.sendgrid.com/api/mail.send.json';

        $headr = array();

        $pass = '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';

        $headr[] = 'Authorization: Bearer '.$pass;
    
        $session = curl_init($request);

        curl_setopt ($session, CURLOPT_POST, true);

        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

        curl_setopt($session, CURLOPT_HEADER, false);

        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // add authorization header

        curl_setopt($session, CURLOPT_HTTPHEADER,$headr);

        $response = curl_exec($session);

        curl_close($session);

        return true;
    }
}
