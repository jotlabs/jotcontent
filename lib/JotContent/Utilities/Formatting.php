<?php

namespace JotContent\Utilities;

use DateTime;


class Formatting {

    public static function formatDate($date, $toFormat='d F Y', $fromFormat='Y-m-d H:i:s') {
        $dateStr = '';

        if (!empty($date)) {
            $posted = DateTime::createFromFormat($fromFormat, $date);
            $dateStr = $posted->format($toFormat);
        }

        return $dateStr;
    }


    public function formatTimeDuration($duration) {
        $durationStr    = '';
        $durationFormat = 'H:i:s';

        if ($duration < 3600) {
            $durationFormat = 'i:s';
        }

        $durationStr = gmdate($durationFormat, $duration);

        return $durationStr;
    }


}


?>
