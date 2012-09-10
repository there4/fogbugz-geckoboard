<?php
use dflydev\markdown\MarkdownExtraParser;

$app->get('/', function () use ($app) {

    $readMe = file_get_contents(__DIR__ . '/../README.md');
    $markdownParser = new MarkdownExtraParser();
    
    $index = $markdownParser->transformMarkdown($readMe);
    
    $app->render('page.php', array('body' => $index));

});

/* End of file root.php */
