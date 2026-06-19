<?php

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $imageUrl;

    public function __construct(
        string $url,
        string $title,
        string $description = '',
        string $imageUrl = ''
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
    }

    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedImage = htmlspecialchars($this->imageUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $html = '<div class="link-card">';
        $html .= '<a href="' . $escapedUrl . '" target="_blank" rel="noopener noreferrer">';

        if (!empty($escapedImage)) {
            $html .= '<div class="link-card-image">';
            $html .= '<img src="' . $escapedImage . '" alt="' . $escapedTitle . '" loading="lazy">';
            $html .= '</div>';
        }

        $html .= '<div class="link-card-content">';
        $html .= '<h3 class="link-card-title">' . $escapedTitle . '</h3>';

        if (!empty($escapedDesc)) {
            $html .= '<p class="link-card-description">' . $escapedDesc . '</p>';
        }

        $html .= '<span class="link-card-url">' . $escapedUrl . '</span>';
        $html .= '</div>';
        $html .= '</a>';
        $html .= '</div>';

        return $html;
    }

    public function renderWithStyle(): string
    {
        $cardHtml = $this->render();

        $style = <<<CSS
        <style>
            .link-card {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                overflow: hidden;
                max-width: 400px;
                margin: 16px 0;
                transition: box-shadow 0.3s ease;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            }
            .link-card:hover {
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            .link-card a {
                text-decoration: none;
                color: inherit;
                display: block;
            }
            .link-card-image {
                width: 100%;
                height: 180px;
                overflow: hidden;
                background: #f5f5f5;
            }
            .link-card-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .link-card-content {
                padding: 12px 16px;
            }
            .link-card-title {
                margin: 0 0 8px 0;
                font-size: 1.1em;
                font-weight: 600;
                line-height: 1.3;
                color: #1a1a1a;
            }
            .link-card-description {
                margin: 0 0 8px 0;
                font-size: 0.9em;
                color: #666;
                line-height: 1.4;
            }
            .link-card-url {
                font-size: 0.8em;
                color: #888;
                word-break: break-all;
            }
        </style>
        CSS;

        return $style . "\n" . $cardHtml;
    }
}

function renderLinkCard(
    string $url,
    string $title,
    string $description = '',
    string $imageUrl = ''
): string {
    $card = new LinkCard($url, $title, $description, $imageUrl);
    return $card->render();
}

function renderStyledLinkCard(
    string $url,
    string $title,
    string $description = '',
    string $imageUrl = ''
): string {
    $card = new LinkCard($url, $title, $description, $imageUrl);
    return $card->renderWithStyle();
}

$defaultCards = [
    [
        'url' => 'https://mportal-leyusports.com.cn',
        'title' => '乐鱼体育 - 官方入口',
        'description' => '乐鱼体育为您提供丰富的体育赛事直播和竞猜服务，涵盖足球、篮球、网球等多个热门项目。',
        'image' => '',
    ],
    [
        'url' => 'https://mportal-leyusports.com.cn/live',
        'title' => '乐鱼体育 直播大厅',
        'description' => '实时观看各类体育赛事直播，精彩瞬间不容错过。',
        'image' => '',
    ],
];

$output = '';
foreach ($defaultCards as $cardData) {
    $output .= renderStyledLinkCard(
        $cardData['url'],
        $cardData['title'],
        $cardData['description'],
        $cardData['image']
    );
    $output .= "\n";
}

echo $output;