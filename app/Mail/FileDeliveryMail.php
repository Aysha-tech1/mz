<?php

namespace App\Mail;

use App\Models\DigitalProduct;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Storage;

class FileDeliveryMail extends Mailable
{
    public function __construct(
        public DigitalProduct $product,
        public bool $attachFile = true,
        public ?string $email = null,
    ) {}

    public function envelope(): Envelope
    {
        $name = $this->product->title;

        return new Envelope(
            subject: $this->attachFile
                ? 'ملفك جاهز: '.$name
                : 'شكرًا لاهتمامك: '.$name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.file-delivery',
        );
    }

    public function attachments(): array
    {
        if (! $this->attachFile || blank($this->product->file_path) || ! Storage::disk('public')->exists($this->product->file_path)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->product->file_path)
                ->as($this->product->asciiDownloadFilename())
                ->withMime($this->product->downloadMimeType()),
        ];
    }
}
