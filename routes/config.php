<?php
use dflydev\markdown\MarkdownExtraParser;

$app->get('/require-config', function () use ($app, $configFile) {

    // If the file exists, perhaps a reload, we'll go back.
    if (file_exists($configFile)) {
      header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
      exit();
    }

    $configMe = file_get_contents(__DIR__ . '/../templates/configMe.md');
    $markdownParser = new MarkdownExtraParser();
    
    $index = $markdownParser->transformMarkdown($configMe);
    
    $app->render('page.php', array(
        'title' => 'Configuration Error',
        'body'  => $index
    ));

});


/* End of file config.php */
