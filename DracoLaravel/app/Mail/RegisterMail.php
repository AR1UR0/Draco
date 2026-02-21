<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
* RegisterMail Class
* This class is responsible for structuring and configuring the welcome email
* that is automatically sent after successful registration.
* It uses Laravel's Mailables system to separate the sending logic
* from the visual design (view).
* @author Marta Arturo
*/
class RegisterMail extends Mailable
{

    
    use Queueable, SerializesModels;

    /**
    * @var string Recipient username.
    */
    public string $name;

    /**
    * @var string Absolute path to the logo image for the email.
    */
    public string $logo;


    /**
    * Creates a new instance of the message.
    * Initializes the data necessary for viewing the email.
    * The application's configuration URL is used to ensure that
    * the logo is accessible from external email clients.
    * @author Marta Arturo
    * @param string $name Registered user name.
    */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->logo = config('app.url') . '/media/imgs/logoDraco.png';
    }

    /**
    * Defines the message envelope.
    * Configures the email metadata, specifically the subject
    * that the user will see in their inbox.
    * @author Arturo Marta
    * @return Envelope Sender and subject settings.
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenido a Draco'
        );
    }

    /**
    * Defines the message content.
    * Links the Mailable to the corresponding Blade template and
    * supplies the necessary variables to render the custom HTML.
    * @author Arturo Marta
    * @return Content Definition of the view and injected data.
    */
    public function content(): Content
    {
        return new Content(
            view: 'emails.register',
            with: [
                'name' => $this->name,
                'logo' => $this->logo,
            ]
        );
    }

    /**
    * Defines the message attachments.
    * * @author Arturo Marta
    * @return array List of attachments (currently empty).
    */
    public function attachments(): array
    {
        return [];
    }
}

