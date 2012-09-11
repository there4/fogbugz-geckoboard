<?php

// Name: Kiln Commit Feed
// Description: Simplified feed from the kiln logs
// Format: RSS
// Data Source: Kiln RSS Feed
Use dg\rssPhp;

$app->get('/kiln', function () use ($app) {

    $rss = Feed::loadRss($app->config->kiln_rss);

    $res = $app->response();
    $res['Content-Type'] = 'application/rss+xml';
 
    $rssfeed  = '<?xml version="1.0" encoding="utf-8"?>';
    $rssfeed .= '<rss xmlns:a10="http://www.w3.org/2005/Atom" version="2.0">';
    $rssfeed .= '<channel>';
    $rssfeed .= '<title>' . $rss->title . '</title>';
    $rssfeed .= '<link>' . $rss->link .'</link>';
    $rssfeed .= '<description>' . $rss->description . '</description>';
 
    foreach ($rss->item as $item) {
 
        $rssfeed .= '<item>';
        $rssfeed .= '<title>' . trim(strip_tags($item->author)) . ': ' . strip_tags($item->description) . '</title>';
        $rssfeed .= '<description>' . strip_tags($item->description) . '</description>';
        $rssfeed .= '<link>' . $item->link . '</link>';
        $rssfeed .= '<pubDate>' . $item->timestamp . '</pubDate>';
        $rssfeed .= '</item>';
    }
 
    $rssfeed .= '</channel>';
    $rssfeed .= '</rss>';
 
    echo $rssfeed;

});

/* End of file root.php */
