<?php

// Name: Case List
// Format: RSS
// Data Source: Fogbugz Filters for current user
Use dg\rssPhp;

$app->get('/caselist/:id', $apiAuthenticate(), $setFormat, function ($filter_id) use ($app) {

    $fogbugz = new FogBugz(
        $app->config->user,
        $app->config->pass,
        $app->config->url
    );

    try {

        $fogbugz->logon();
        
        $fogbugz->setCurrentFilter(array("sFilter" => $filter_id));
        $xml = $fogbugz->search(array(
            "cols" => "ixBug,sTitle,sPersonAssignedTo"
        ));
    }
    catch (Exception $e) {
        $error = sprintf(
            "[Code %d] %s\n",
            $e->getCode(),
            $e->getMessage()
        );
        Header("HTTP/1.1 500 Internal Server Error");
        $data = array('error' => $error);
        echo $app->geckoResponse->getResponse($data);
        exit(1);
    }
    
    $res = $app->response();
    //$res['Content-Type'] = 'application/rss+xml';
 
    $rssfeed  = '<?xml version="1.0" encoding="utf-8"?>';
    $rssfeed .= '<rss xmlns:a10="http://www.w3.org/2005/Atom" version="2.0">';
    $rssfeed .= '<channel>';
    $rssfeed .= '<title>Case List for Filter: ' . $filter_id . '</title>';
    $rssfeed .= '<link></link>';
    $rssfeed .= '<description>Case List from FogBugz</description>';

    foreach ($xml->cases->case as $case) {
 
        $title = $case->sPersonAssignedTo . ": " . (string) $case->sTitle;
        $description = '';
        $link = trim($app->config->url, '/') . '/default.asp?' . $case->ixBug;
 
        $rssfeed .= '<item>';
        $rssfeed .= '<title>' . $title . '</title>';
        $rssfeed .= '<description>' . $description . '</description>';
        $rssfeed .= '<link>' . $link . '</link>';
        $rssfeed .= '<pubDate>' . date('D, d M Y H:i:s T') . '</pubDate>';
        $rssfeed .= '</item>';
    }
 
    $rssfeed .= '</channel>';
    $rssfeed .= '</rss>';
 
    echo $rssfeed;
    
});


/* End of file caselist.php */
