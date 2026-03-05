<?php

namespace Mstudio\ContaoAltTextGenerator\EventListener;

use Contao\FilesModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\StringUtil;
use Contao\Validator;
use Mstudio\ContaoAltTextGenerator\Service\AltTextGenerator;

#[AsHook('postUpload')]
class ImageUploadListener
{
    private AltTextGenerator $generator;
    private bool $replaceExistingAlt;

    public function __construct(AltTextGenerator $generator, bool $replaceExistingAlt)
    {
        $this->generator = $generator;
        $this->replaceExistingAlt = $replaceExistingAlt;
    }

    public function __invoke(array $files): void
    {
        foreach ($files as $path) {
            if (!is_string($path) || '' === trim($path)) {
                continue;
            }

            $this->processFile($path);
        }
    }

    private function processFile(string $path): void
    {
        $file = FilesModel::findByPath($path);

        if (!$file) {
            return;
        }

        if (!Validator::isImage($path)) {
            return;
        }

        $meta = StringUtil::deserialize($file->meta, true);
        $meta = is_array($meta) ? $meta : [];

        $existingAlt = $meta['de']['alt'] ?? '';

        if (!$this->replaceExistingAlt && is_string($existingAlt) && '' !== trim($existingAlt)) {
            return;
        }

        $alt = $this->generator->generate($path);

        if ('' === trim($alt)) {
            return;
        }

        $meta['de']['alt'] = $alt;

        $file->meta = StringUtil::serialize($meta);
        $file->save();
    }
}