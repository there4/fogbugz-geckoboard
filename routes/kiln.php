<?php

// Name: Kiln Commit Feed
// Description: Simplified feed from the kiln logs
// Format: RSS
// Data Source: Kiln RSS Feed
Use dg\rssPhp;

$app->get('/kiln', $apiAuthenticate(), $setFormat, function () use ($app) {

    $rss = Feed::loadRss($app->config->kiln_rss);

    $res = $app->response();
    $res['Content-Type'] = 'application/rss+xml';
 
    $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
    $rssfeed .= '<rss version="2.0">';
    $rssfeed .= '<channel>';
    $rssfeed .= '<title>' . $item->title . '</title>';
    $rssfeed .= '<link>' . $item->link .'</link>';
    $rssfeed .= '<description>' . $item->description . '</description>';
    $rssfeed .= '<language>en-us</language>';
 
    foreach ($rss->item as $item) {
 
        $rssfeed .= '<item>';
        $rssfeed .= '<title>' . trim(strip_tags($item->author)) . ': ' .$item->description . '</title>';
        $rssfeed .= '<description>' . $item->description . '</description>';
        $rssfeed .= '<link>' . $item->link . '</link>';
        $rssfeed .= '<pubDate>' . $item->timestamp . '</pubDate>';
        $rssfeed .= '</item>';
    }
 
    $rssfeed .= '</channel>';
    $rssfeed .= '</rss>';
 
    echo $rssfeed;

});

/* End of file root.php */
