<?php

use JotContent\Utilities\Formatting;

class FormattingTest extends PHPUnit_Framework_TestCase {

    public function testDefaultFormatDate() {
        $dates = array(
            array('2013-09-05 07:34:00', '05 September 2013'),
            array('2000-02-29 08:30:37', '29 February 2000')
        );

        foreach($dates as $datePair) {
            $this->assertEquals($datePair[1], Formatting::formatDate($datePair[0]));
        }

    }

    public function testIsoFormattedDate() {
        $dates = array(
            array('2013-09-05 07:34:00', '2013-09-05T07:34:00+01:00'),
            array('2000-02-29 08:30:37', '2000-02-29T08:30:37+00:00')
        );

        foreach($dates as $datePair) {
            $this->assertEquals($datePair[1], Formatting::formatDate($datePair[0], 'c'));
        }

    }

    public function testFormattedTimeDuration() {
        $durations = array(
            array(NULL, '00:00'),
            array(0,    '00:00'),
            array(1,    '00:01'),
            array(61,   '01:01'),
            array(3599, '59:59'),
            array(3600, '01:00:00'),
            array(4827, '01:20:27')
        );

        foreach($durations as $durationPair) {
            $this->assertEquals($durationPair[1], Formatting::formatTimeDuration($durationPair[0]));
        }
    }
}

?>
