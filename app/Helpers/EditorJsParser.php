<?php

namespace App\Helpers;

class EditorJsParser
{
    /**
     * Convert EditorJS blocks array into HTML
     *
     * @param array $body
     * @return string
     */
    public static function parse(array $body): string
    {
        if (empty($body['blocks'])) {
            return '';
        }

        $html = '';

        foreach ($body['blocks'] as $block) {
            $type = $block['type'] ?? null;
            $data = $block['data'] ?? [];

            switch ($type) {
                case 'header':
                    $level = $data['level'] ?? 2;
                    $html .= "<h{$level} class='text-2xl font-bold mt-6 mb-2'>{$data['text']}</h{$level}>";
                    break;

                case 'paragraph':
                    $html .= "<p class='mb-4 leading-relaxed'>{$data['text']}</p>";
                    break;

                case 'quote':
                    $html .= "<blockquote class='pl-4 border-l-4 border-gray-300 italic my-4'>{$data['text']}</blockquote>";
                    break;

                case 'list':
                    $html .= "<ul class='list-disc pl-6 mb-4'>";
                    foreach ($data['items'] ?? [] as $item) {
                        $html .= "<li>{$item}</li>";
                    }
                    $html .= "</ul>";
                    break;

                case 'checklist':
                    $html .= "<ul class='list-none mb-4'>";
                    foreach ($data['items'] ?? [] as $item) {
                        $checked = $item['checked'] ? 'checked' : '';
                        $html .= "<li><input type='checkbox' class='mr-2' disabled {$checked}>{$item['text']}</li>";
                    }
                    $html .= "</ul>";
                    break;

                case 'code':
                    $html .= "<pre class='bg-gray-100 p-4 rounded mb-4'>{$data['code']}</pre>";
                    break;

                // Add more block types if needed

                default:
                    break;
            }
        }

        return $html;
    }
}
