<?php
/**
 * This class implements time formatting to localized 'N units, M units ago`
 * format.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class DateFormatter extends \CDateFormatter
{
    /**
     * Time interval in seconds during which date will be formatted as
     * 'just now'. Note that values more than 59 seconds will simply
     *
     * @type int
     * @since 0.1.0
     */
    public $justNowSpan = 10;
    /**
     * Cached current datetime.
     *
     * @var \DateTime
     * @since 0.1.0
     */
    protected $now;
    /**
     * Isolated list of time intervals/units to clarify code.
     *
     * @var string[]
     * @since 0.1.0
     */
    protected $intervals = array(
        'y' => 'years',
        'm' => 'months',
        'd' => 'days',
        'h' => 'hours',
        'i' => 'minutes',
        's' => 'seconds',
    );

    public function __construct()
    {
        try {
            parent::__construct(\Yii::app()->language);
        } catch (CException $e) {
            parent::__construct('en');
        }
    }

    /**
     * Typical initializer.
     *
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        $this->reset();
    }

    /**
     * Formats date to 'xxx {unit}, zzz {unit} ago'.
     *
     * @param string|\DateTime $date       Date to be formatted.
     * @param int              $unitsLimit How many date units (years, months,
     * days, etc.) should be processed.
     *
     * @throws \BadMethodCallException Thrown if incorrect $unitsLimit is
     * provided.
     *
     * @return string Formatted date.
     * @since 0.1.0
     */
    public function formatAsTimeAgo($date, $unitsLimit=2)
    {
        if (!is_int($unitsLimit) || $unitsLimit < 1) {
            $message = 'Maximum units limit has to be integer not less than one.';
            throw new \BadMethodCallException($message);
        }
        if (!$date instanceof \DateTime) {
            try {
                $date = new \DateTime($date);
            } catch (\Exception $e) {
                $message = 'Invalid date provided.';
                throw new \BadMethodCallException($message, 0, $e);
            }
        }
        $tsDiff = $this->now->getTimestamp() - $date->getTimestamp();
        if ($tsDiff < $this->justNowSpan) {
            return \Yii::t('templates', 'timeInterval.justNow');
        }
        $diff = $date->diff($this->now);

        $counter = 0; // Number of date units already analyzed. I need just two @tm.
        $dateInterval = array();
        foreach ($this->intervals as $key => $interval) {
            if ($counter >= $unitsLimit) {
                break;
            }
            if ($counter > 0) {
                $counter++;
            }
            if ($diff->$key > 0) {
                $dateInterval[] = $this->formatInterval($diff->$key, $interval);
                if ($counter === 0) {
                    $counter = 1;
                }
            }
        }
        if (sizeof($dateInterval) > 0) {
            return \Yii::t(
                'templates', 'timeInterval.ago',
                array('{interval}' => implode(', ', $dateInterval),)
            );
        }
        // No seconds ago? Return 'just now'.
        return \Yii::t('templates', 'timeInterval.justNow');
    }

    /**
     * Internal function to clarify the code.
     *
     * @param int    $interval Interval in specified time units,
     * @param string $tKey     Translation key.
     *
     * @return string Formatted interval.
     * @since 0.1.0
     */
    protected function formatInterval($interval, $tKey)
    {
        return \Yii::t('templates', 'timeInterval.'.$tKey, $interval);
    }

    /**
     * Resets current time.
     *
     * @return void
     * @since 0.1.0
     */
    public function reset()
    {
        $this->now = new \DateTime;
    }
}
