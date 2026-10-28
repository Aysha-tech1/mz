<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DigitalProduct extends Model
{
    public const UPLOAD_EXTENSIONS = [
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
        'odt', 'ods', 'odp', 'csv', 'txt', 'zip',
    ];

    public const UPLOAD_MIME_TYPES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.ms-office',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.oasis.opendocument.text',
        'application/vnd.oasis.opendocument.spreadsheet',
        'application/vnd.oasis.opendocument.presentation',
        'text/csv',
        'application/csv',
        'text/plain',
        'application/zip',
        'application/x-zip-compressed',
        'application/x-cfb',
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'full_description',
        'label',
        'step_number',
        'price',
        'is_free',
        'file_path',
        'is_active',
        'old_price',
        'is_coming_soon',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:3',
            'is_free' => 'boolean',
            'is_active' => 'boolean',
            'is_coming_soon' => 'boolean',
            'is_featured' => 'boolean',
            'step_number' => 'integer',
            'downloads_count' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (DigitalProduct $product): void {
            if (blank($product->slug) || ($product->isDirty('title') && ! $product->isDirty('slug'))) {
                $product->slug = static::uniqueSlugFromTitle((string) $product->title, $product->id);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $field ??= $this->getRouteKeyName();

        return $this->where($field, $value)
            ->when(ctype_digit((string) $value), fn (Builder $query) => $query->orWhere($this->getKeyName(), $value))
            ->first();
    }

    public static function slugFromTitle(string $title): string
    {
        $slug = preg_replace('/[^\p{L}\p{N}\s-]+/u', '', $title) ?? '';
        $slug = preg_replace('/[\s-]+/u', '-', trim($slug)) ?? '';
        $slug = trim($slug, '-');

        return $slug !== '' ? $slug : 'ملف';
    }

    public static function uniqueSlugFromTitle(string $title, int|string|null $ignoreId = null): string
    {
        $base = static::slugFromTitle($title);
        $slug = $base;
        $i = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('step_number');
    }

    public function displayPrice(): string
    {
        if ($this->is_free) {
            return 'مجاني';
        }

        return $this->formatOmr($this->price);
    }

    public function displayOldPrice(): ?string
    {
        if (blank($this->old_price) || $this->is_free) {
            return null;
        }

        return $this->formatOmr($this->old_price);
    }

    public function savingsAmount(): ?string
    {
        if ($this->is_free || blank($this->old_price) || ! is_numeric($this->old_price)) {
            return null;
        }

        $saved = (float) $this->old_price - (float) $this->price;

        if ($saved <= 0) {
            return null;
        }

        return $this->formatOmr($saved);
    }

    public function recordDownload(): void
    {
        $this->increment('downloads_count');
    }

    public function displayDownloads(): string
    {
        return ((int) $this->downloads_count).' تنزيل';
    }

    public function ctaLabel(): string
    {
        if ($this->is_coming_soon) {
            return 'قريبًا';
        }

        return $this->is_free ? 'تحميل مجاني' : 'احصل عليه';
    }

    public function fileUrl(): ?string
    {
        if (blank($this->file_path)) {
            return null;
        }

        return Storage::disk('public')->url($this->file_path);
    }

    public function downloadFilename(): string
    {
        $extension = strtolower((string) pathinfo((string) $this->file_path, PATHINFO_EXTENSION));

        if ($extension === '') {
            $extension = $this->extensionFromMime();
        }

        $base = preg_replace('/[\\\\\/:*?"<>|]+/u', '', (string) $this->title) ?? '';
        $base = trim($base, " \t\n\r\0\x0B.");
        $base = $base !== '' ? $base : 'file';

        return $extension !== '' ? $base.'.'.$extension : $base;
    }

    public function downloadHeaders(): array
    {
        $mime = $this->fileMimeType() ?? 'application/octet-stream';

        return [
            'Content-Type' => $mime,
        ];
    }

    public function fileMimeType(): ?string
    {
        if (blank($this->file_path) || ! Storage::disk('public')->exists($this->file_path)) {
            return null;
        }

        return Storage::disk('public')->mimeType($this->file_path) ?: null;
    }

    private function extensionFromMime(): string
    {
        return match ($this->fileMimeType()) {
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel', 'application/vnd.ms-office' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/vnd.oasis.opendocument.text' => 'odt',
            'application/vnd.oasis.opendocument.spreadsheet' => 'ods',
            'application/vnd.oasis.opendocument.presentation' => 'odp',
            'text/csv', 'application/csv' => 'csv',
            'text/plain' => 'txt',
            'application/zip', 'application/x-zip-compressed' => 'zip',
            default => '',
        };
    }

    private function formatOmr(mixed $amount): string
    {
        return number_format((float) $amount, 3).' ر.ع.';
    }
}
