<?php
/**
 * Copyright © Happy Horizon Utrecht Development & Technology B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\WysiwygDownloads\Model;

/**
 * Classifies media files that must not be treated as raster images.
 */
class MediaFileType
{
    /**
     * Extensions getimagesize() can read on PHP 8.3.
     *
     * @var string[]
     */
    private const RASTER_IMAGE_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'webp',
        'bmp',
    ];

    /**
     * Documents and other non-images. Rendition generation rejects these.
     *
     * @var string[]
     */
    private const RENDITION_SKIP_EXTENSIONS = [
        'pdf',
        'doc',
        'docx',
        'docm',
        'odt',
        'csv',
        'txt',
        'xml',
        'xls',
        'xlsx',
        'ods',
        'zip',
        'tar',
        'mp3',
        'mp4',
        'ogg',
        'webm',
        'mov',
        'avi',
        'wmv',
        'swf',
        'rm',
        'ics',
    ];

    /**
     * Fallback when fileinfo returns a generic type.
     *
     * @var array<string, string>
     */
    private const MIME_TYPES_BY_EXTENSION = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'csv' => 'text/plain',
        'txt' => 'text/plain',
        'xml' => 'application/xml',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'zip' => 'application/zip',
        'tar' => 'application/x-tar',
        'mp3' => 'audio/mpeg',
        'mp4' => 'video/mp4',
        'ogg' => 'video/ogg',
        'webm' => 'video/webm',
        'mov' => 'video/quicktime',
        'avi' => 'video/x-msvideo',
        'wmv' => 'video/x-ms-wmv',
        'swf' => 'application/x-shockwave-flash',
        'rm' => 'application/vnd.rn-realmedia',
        'ics' => 'text/calendar',
        'svg' => 'image/svg+xml',
    ];

    /**
     * @var string[]
     */
    private const GENERIC_MIME_TYPES = [
        'application/octet-stream',
        'application/x-empty',
        'inode/x-empty',
    ];

    /**
     * Raster images keep Magento's own asset creation, including dimensions.
     */
    public function isRasterImage(string $path): bool
    {
        return in_array($this->extension($path), self::RASTER_IMAGE_EXTENSIONS, true);
    }

    /**
     * PDF and other documents cannot be resized into a rendition.
     */
    public function shouldSkipRendition(string $path): bool
    {
        return in_array($this->extension($path), self::RENDITION_SKIP_EXTENSIONS, true);
    }

    /**
     * Mime type from fileinfo, with the known extension map as fallback.
     *
     * Does not call getimagesize() / getimagesizefromstring().
     */
    public function detectMimeType(string $absolutePath, string $content): string
    {
        $extension = $this->extension($absolutePath);
        $detected = $this->detectWithFileinfo($absolutePath, $content);

        if ($detected === null || in_array($detected, self::GENERIC_MIME_TYPES, true)) {
            return self::MIME_TYPES_BY_EXTENSION[$extension] ?? $detected ?? 'application/octet-stream';
        }

        return $detected;
    }

    private function detectWithFileinfo(string $absolutePath, string $content): ?string
    {
        if (function_exists('mime_content_type') && is_file($absolutePath)) {
            $mimeType = mime_content_type($absolutePath);
            if (is_string($mimeType) && $mimeType !== '') {
                return $mimeType;
            }
        }

        if (!class_exists(\finfo::class)) {
            return null;
        }

        $mimeType = (new \finfo(FILEINFO_MIME_TYPE))->buffer($content);

        return is_string($mimeType) && $mimeType !== '' ? $mimeType : null;
    }

    private function extension(string $path): string
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION));
    }
}
