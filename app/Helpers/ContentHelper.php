<?php

namespace App\Helpers;

class ContentHelper
{
    /**
     * Mengubah link YouTube biasa menjadi iframe embed.
     *
     * @param string|null $htmlContent Konten HTML yang mungkin berisi link YouTube.
     * @return string Konten HTML dengan link YouTube yang sudah diubah menjadi iframe.
     */
    public static function embedYoutubeVideos(?string $htmlContent): string
    {
        if (empty($htmlContent)) {
            return '';
        }

        // Pola regex untuk menemukan link YouTube (watch?v=VIDEO_ID)
        // Bisa menangani link http, https, dengan atau tanpa www, dan parameter tambahan (&t=...)
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]{11})(?:[^\s<>"]*)/';

        // Ganti setiap link yang cocok dengan iframe
        $processedContent = preg_replace_callback(
            $pattern,
            function ($matches) {
                $videoId = $matches[1]; // Ambil ID video dari hasil regex

                // Hasilkan kode iframe yang responsif
                return '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; margin-bottom: 1rem;">
                            <iframe
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;"
                                src="https://www.youtube.com/embed/' . $videoId . '"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>';
            },
            $htmlContent
        );

        return $processedContent;
    }
}
