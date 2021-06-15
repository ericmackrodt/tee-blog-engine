<?php

function injectMd($input)
{
    preg_match('/\[inject-md[\s]+"(.+)"\]/', $input, $output);
    if (empty($output)) {
        return $input;
    }

    $injectPath = BLOG_PAGE_PATH . $output[1];

    $md = file_get_contents($injectPath);

    return str_replace($output[0], $md, $input);
}

function splitContents($input)
{
    $lines = explode(PHP_EOL, $input);
    $body = ['left-content' => '', 'content' => '', 'right-content' => ''];
    $previous_content = null;

    foreach ($lines as $key => $line) {
        preg_match('/\$\$\s(content|right-content|left-content)\s\$\$/', $line, $matches, PREG_UNMATCHED_AS_NULL);
        if (!empty($matches)) {
            $previous_content = $matches[1];
            continue;
        }

        if (empty($previous_content)) {
            $previous_content = 'content';
        }

        $line = injectMd($line);

        $body[$previous_content] = $body[$previous_content] . $line . PHP_EOL;
    }

    return $body;
}

function renderSingleContent($contents, $key)
{
    if (empty($contents[$key])) {
        return null;
    }

    return renderMarkdown($contents[$key]);
}

function getPage(string $page)
{
    global $templates;
    $object = loadPageMd($page);

    $contents = splitContents($object->body());

    $templates->addData(
        [
            'page_title' => $object->title,
            'page_slug' => 'pages/' . $page,
        ],
        withVariant('gallery')
    );

    return array(
        'title' => $object->title,
        'slug' => $page,
        'left-content' => renderSingleContent($contents, 'left-content'),
        'content' => renderSingleContent($contents, 'content'),
        'right-content' => renderSingleContent($contents, 'right-content')
    );
}

return function (string $key) use ($templates) {
    $data = getPage(($key));
    return $templates->render(withVariant('page'), ['data' => $data]);
};
