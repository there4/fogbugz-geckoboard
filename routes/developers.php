<?php
// Name: Developer Working On Display
// Format: Custom Text
// Data Source: Fogbugz Working On data for each customer

$app->get('/developers', $apiAuthenticate(), $setFormat, function () use ($app) {

    $fogbugz = new FogBugz(
        $app->config->user,
        $app->config->pass,
        $app->config->url
    );

    try {

        $developers = array();

        $fogbugz->logon();

        $xml = $fogbugz->listPeople();
        $ignore = explode(',', $app->config->ignore);

        $now = new DateTime();
        foreach ($xml->people->children() as $person) {

            // Ignore users idle for more than 4 months
            $lastseen = new DateTime((string) $person->dtLastActivity);
            $interval = $now->diff($lastseen);
            if ($interval->format('%m') > 4) {
              continue;
            }

            if (in_array((string) $person->sFullName, $ignore)) {
              continue;
            }
            $developers[] = (object) array(
                "name"      => utf8_encode((string) $person->sFullName),
                "email"     => utf8_encode((string) $person->sEmail),
                "workingOn" => utf8_encode((string) $person->ixBugWorkingOn)
            );
        }

        //print "<pre>";var_dump($developers);
        foreach ($developers as &$developer) {
            if (empty($developer->workingOn) || ($developer->workingOn === 0)) {
                $developer->workingOn = (object) array(
                    "number" => "",
                    "title" => "&nbsp;",
                    "status" => ""
                );
                continue;
            }
            $xml = $fogbugz->search(array(
                'q'    => (int) $developer->workingOn,
                'cols' => 'ixBug,sTitle,sStatus'
            ));
            $case = $xml->cases->case;

            $developer->workingOn = (object) array(
                "number" => utf8_encode((string) $case->ixBug),
                "title"  => utf8_encode((string) $case->sTitle),
                "status" => utf8_encode((string) $case->sStatus)
            );
        }
        unset($developer);

        //https://insight.geckoboard.com/css/dashboard.css
        $html = '<div><dl class="b-project-list">';

        foreach ($developers as $developer) {
          if (empty($developer->workingOn->number)) {
              $html .= '<dt class="t-size-x14 t-main"><span class="led red"></span>' . $developer->name . "</dt>";
              $html .= '<dd class="t-size-x11"><span class="t-muted">&nbsp;</span></dd>';
          }
          else {
              $html .= '<dt class="t-size-x14 t-main"><span class="led green"></span>' . $developer->name . "</dt>";
              $html .= sprintf(
                  '<dd class="t-size-x11 t-main"><a class="t-muted" href="https://learningstation.fogbugz.com/default.asp?%d">Case %d</a><span class="t-muted">: %s</span></dd>',
                  $developer->workingOn->number,
                  $developer->workingOn->number,
                  $developer->workingOn->title
              );
          }
        }

        $html .= "</dl></div>";

        $data = array('item' => array(
            array('text' => $html)
        ));
        $response = $app->geckoResponse->getResponse($data);

        echo $response;

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

});

/* End of file developers.php */
