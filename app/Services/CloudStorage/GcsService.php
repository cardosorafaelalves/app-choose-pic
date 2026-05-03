<?php

namespace App\Services\CloudStorage;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Str;

class GcsService
{
    protected StorageClient $storage;
    protected $bucketName;
    protected $bucket;

    private const UPLOAD_DIR = 'uploads/';
    private const URL_EXPIRATION = 10;
    private const URL_METHOD = 'PUT';
    private const URL_VERSION = 'v4';

    public function __construct()
    {
    }

    public function generateUploadUrl(array $dataRequest): array
    {
        $storage = new StorageClient([
            'keyFilePath' => storage_path('gcs/gcs-key.json'),
        ]);

        $bucket = $storage->bucket(env('GCS_BUCKET'));

        $fileName = self::UPLOAD_DIR . Str::uuid() . '_' . $dataRequest['file_name'];

        $object = $bucket->object($fileName);

        $url = $object->signedUrl(
            now()->addMinutes(self::URL_EXPIRATION),
            [
                'method' => self::URL_METHOD,
                'contentType' => $dataRequest['content_type'],
                'version' => self::URL_VERSION,
            ]
        );

        return [
            'upload_url' => $url,
            'path' => $fileName
        ];
    }
}
