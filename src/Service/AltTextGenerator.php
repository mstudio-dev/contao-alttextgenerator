<?php

namespace Mstudio\ContaoAltTextGenerator\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class AltTextGenerator
{
    private HttpClientInterface $client;
    private string $apiKey;
    private string $model;
    private string $projectDir;

    public function __construct(
        HttpClientInterface $client,
        string $apiKey,
        string $model,
        string $projectDir
    )
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->model = $model;
        $this->projectDir = rtrim($projectDir, '/');
    }

    public function generate(string $path): string
    {
        if ('' === trim($this->apiKey)) {
            return '';
        }

        $absolutePath = $this->projectDir . '/' . ltrim($path, '/');

        if (!is_file($absolutePath)) {
            return '';
        }

        $imageData = file_get_contents($absolutePath);

        if (false === $imageData) {
            return '';
        }

        $mimeType = mime_content_type($absolutePath);

        if (!is_string($mimeType) || !str_starts_with($mimeType, 'image/')) {
            return '';
        }

        $dataUrl = sprintf('data:%s;base64,%s', $mimeType, base64_encode($imageData));

        try {
            $response = $this->client->request(
                'POST',
                'https://api.openai.com/v1/chat/completions',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                    'json' => [
                        'model' => $this->model,
                        'messages' => [[
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => 'Erstelle einen kurzen, beschreibenden Alt-Text auf Deutsch mit maximal 120 Zeichen. Gib nur den Alt-Text aus.',
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => $dataUrl,
                                    ],
                                ],
                            ],
                        ]],
                    ],
                ]
            );

            $data = $response->toArray(false);
            $content = $data['choices'][0]['message']['content'] ?? '';
            $altText = '';

            if (is_string($content)) {
                $altText = trim($content);
            }

            if (is_array($content)) {
                $textParts = [];

                foreach ($content as $part) {
                    if (isset($part['text']) && is_string($part['text'])) {
                        $textParts[] = $part['text'];
                    }
                }

                $altText = trim(implode(' ', $textParts));
            }

            if ('' === $altText) {
                return '';
            }

            return mb_substr($altText, 0, 120);
        } catch (Throwable) {
            return '';
        }

        return '';
    }
}