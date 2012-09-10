<?php

// Name: Support Case Count Overview
// Format: RAG column and numbers
// Data Source: Fogbugz Filters for current user

$app->get('/helpdesksummary', $apiAuthenticate(), $setFormat, function () use ($app) {

    // TODO: Move these filters to the config file
    $filters = (object) array(
        "critical" => (object) array("id" => 178, "count" => 0),
        "high"     => (object) array("id" => 179, "count" => 0),
        "normal"   => (object) array("id" => 180, "count" => 0)
    );
    
    $fogbugz = new FogBugz(
        $app->config->user,
        $app->config->pass,
        $app->config->url
    );
    
    try {

        $fogbugz->logon();
        
        foreach ($filters as &$filter) {
            $fogbugz->setCurrentFilter(array("sFilter" => $filter->id));
            $xml = $fogbugz->search(array(
                "cols" => 'ixBug'
            ));
            $filter->count = $xml->cases->case->count();
        }
        unset($filter);
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

    $data = array('item' => array(
        array('value' => $filters->critical->count, 'text' => 'Critical Priority'),
        array('value' => $filters->high->count, 'text' => 'High Priority'),
        array('value' => $filters->normal->count, 'text' => 'Normal Priority')
    ));
    $response = $app->geckoResponse->getResponse($data);
    echo $response;
});


/* End of file helpdesksummary.php */
