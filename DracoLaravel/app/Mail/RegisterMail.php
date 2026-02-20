<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Clase RegisterMail
 * * Esta clase es la encargada de estructurar y configurar el correo electrónico
 * de bienvenida que se envía automáticamente tras un registro exitoso.
 * Utiliza el sistema de Mailables de Laravel para separar la lógica de envío
 * del diseño visual (vista).
 * * @author Marta Arturo
 */
class RegisterMail extends Mailable
{

    
    use Queueable, SerializesModels;

    /**
     * @var string Nombre del usuario destinatario.
     */
    public string $name;

    /**
     * @var string Ruta absoluta de la imagen del logo para el correo.
     */
    public string $logo;


    /**
     * Crea una nueva instancia del mensaje.
     * * Inicializa los datos necesarios para la vista del correo. 
     * Se utiliza la URL de configuración de la aplicación para garantizar que 
     * el logo sea accesible desde clientes de correo externos.
     * * @author Marta Arturo
     * @param string $name Nombre del usuario registrado.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->logo = config('app.url') . '/media/imgs/logoDraco.png';
    }

    /**
     * Define el sobre del mensaje (Envelope).
     * * Configura los metadatos del correo, específicamente el asunto (Subject)
     * que verá el usuario en su bandeja de entrada.
     * * @author Arturo Marta
     * @return Envelope Configuración del remitente y asunto.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenido a Draco'
        );
    }

    /**
     * Define el contenido del mensaje (Content).
     * * Vincula el Mailable con la plantilla Blade correspondiente y 
     * suministra las variables necesarias para renderizar el HTML personalizado.
     * * @author Arturo Marta
     * @return Content Definición de la vista y datos inyectados.
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
     * Define los archivos adjuntos del mensaje.
     * * @author Arturo Marta
     * @return array Lista de adjuntos (actualmente vacío).
     */
    public function attachments(): array
    {
        return [];
    }
}

