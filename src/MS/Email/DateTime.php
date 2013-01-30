<?php

namespace MS\DateTime;

/**
 * An extension of the PHP native DateTime object to provide powerful convenience methods
 *
 * @version 0.3
 *
 * @author msmith
 */
class DateTime extends \DateTime
{
    /**
     * Creates a new msDateTime object
     *
     * @param  str          $time
     * @param  DateTimeZone $object
     * @return msDateTime
     */
    public function __construct($time = null, $object = null)
    {
        if ($time && is_numeric($time) && $time == intval($time)) {
            $time = '@' . $time;
        }

        if ($object) {
            parent::__construct($time, $object);
        } elseif ($time) {
            parent::__construct($time);
        } else {
            parent::__construct();
        }
    }

    /**
     * Creates a new msDateTime object inline to preserve fluid calls
     *
     * @param  str          $time
     * @param  DateTimeZone $object
     * @return msDateTime
     */
    public static function create($time = null, $object = null)
    {
        return new self($time, $object);
    }

    /**
     * Returns the current timestamp in "Y-m-d H:i:s" format
     *
     * @return str
     */
    public function  __toString()
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * Creates a copy of the current object
     *
     * @return msDateTime
     */
    public function copy()
    {
        return clone $this;
    }

    /**
     * Compares this object to $msDateTime2 by returning the difference in seconds
     *
     * @param  msDateTime $msDateTime2
     * @return int
     */
    public function compare($msDateTime2)
    {
        return $this->getTimestamp() - $msDateTime2->getTimestamp();
    }

    /**
     * Outputs the current timestamp in a general format. Should only be used for debugging.
     *
     * @return str
     */
    public function dump()
    {
        return $this->format('r');
    }

    /**
     * Sets the internal timestamp to midnight of the current day
     *
     * @return msDateTime
     */
    public function beginningOfDay()
    {
        return $this->setTime(00, 00, 00);
    }

    /**
     * Returns true if the current timestamp is the beginning of the day
     *
     * @return bool
     */
    public function isBeginningOfDay()
    {
        return $this->getTimestamp() == $this->copy()->beginningOfDay()->getTimestamp();
    }

    /**
     * Sets the internal timestamp to one second before midnight
     *
     * @return msDateTime
     */
    public function endOfDay()
    {
        return $this->setTime(23, 59, 59);
    }

    /**
     * Returns true if the current timestamp is the end of the day
     *
     * @return bool
     */
    public function isEndOfDay()
    {
        return $this->getTimestamp() == $this->copy()->endOfDay()->getTimestamp();
    }

    /**
     * Sets the internal timestamp to Sunday of the current week
     *
     * @return msDateTime
     */
    public function firstDayOfWeek()
    {
        return $this->modify(sprintf('-%d days', $this->format('w')));
    }

    /**
     * Returns true if the current timestamp is the first day of the week
     *
     * @return bool
     */
    public function isFirstDayOfWeek()
    {
        return $this->getTimestamp() == $this->copy()->firstDayOfWeek()->getTimestamp();
    }

    /**
     * Sets the internal timestamp to Saturday of the current week
     *
     * @return msDateTime
     */
    public function finalDayOfWeek()
    {
        return $this->modify(sprintf('+%d days', 6 - $this->format('w')));
    }

    /**
     * Returns true if the current timestamp is the final day of the week
     *
     * @return bool
     */
    public function isFinalDayOfWeek()
    {
        return $this->getTimestamp() == $this->copy()->finalDayOfWeek()->getTimestamp();
    }

    /**
     * Sets the internal timestamp to the first day of the curent month
     *
     * @return msDateTime
     */
    public function firstDayOfMonth()
    {
        return $this->modify(sprintf('-%d days', $this->format('d') - 1));
    }

    /**
     * Returns true if the current timestamp is the first day of the month
     *
     * @return bool
     */
    public function isFirstDayOfMonth()
    {
        return $this->getTimestamp() == $this->copy()->firstDayOfMonth()->getTimestamp();
    }

    /**
     * Sets the internal timestamp to the last day of the current month
     *
     * @return msDateTime
     */
    public function finalDayOfMonth()
    {
        return $this->firstDayOfMonth()->modify('+1 month -1 day');
    }

    /**
     * Returns true if the current timestamp is the final day of the month
     *
     * @return bool
     */
    public function isFinalDayOfMonth()
    {
        return $this->getTimestamp() == $this->copy()->finalDayOfMonth()->getTimestamp();
    }

    /**
     * Returns the current quarter number (1, 2, 3 or 4)
     *
     * @return int
     */
    public function getQuarter()
    {
        return intval(($this->format('n') -1) / 3) + 1;
    }

    /**
     * Sets the internal timestamp to the first day of the current quarter (1/1, 4/1, 7/1 or 10/1)
     *
     * @return msDateTime
     */
    public function firstDayOfQuarter()
    {
        return $this->setDate($this->format('Y'), ($this->getQuarter() - 1) * 3 + 1, 1);
    }

    /**
     * Returns true if the current timestamp is the first day of the current quarter
     *
     * @return bool
     */
    public function isFirstDayOfQuarter()
    {
        return $this->getTimestamp() == $this->copy()->firstDayOfQuarter()->getTimestamp();
    }

    /**
     * Sets the internal timestamp to the last day of the current quarter (3/31, 6/30, 9/30 or 12/31)
     *
     * @return msDateTime
     */
    public function finalDayOfQuarter()
    {
        return $this->firstDayOfQuarter()->modify('+3 months -1 day');
    }

    /**
     * Returns true if the current timestamp is the final day of the current quarter
     *
     * @return bool
     */
    public function isFinalDayOfQuarter()
    {
        return $this->getTimestamp() == $this->copy()->finalDayOfQuarter()->getTimestamp();
    }

    /**
     * @return bool
     */
    public function isToday()
    {
        $dt = new self();

        return $this->format('Y-m-d') == $dt->format('Y-m-d');
    }

    /**
     * @return bool
     */
    public function isTomorrow()
    {
        $dt = new self('+1 day');

        return $this->format('Y-m-d') == $dt->format('Y-m-d');
    }

    /**
     * @return bool
     */
    public function isYesterday()
    {
        $dt = new self('-1 day');

        return $this->format('Y-m-d') == $dt->format('Y-m-d');
    }

    /**
     * Uses ISO-8601 weeks Monday - Sunday
     *
     * @return bool
     */
    public function isCurrentWeek()
    {
        $dt = new self();

        return $this->format('Y-W') == $dt->format('Y-W');
    }

    /**
     * @return bool
     */
    public function isCurrentMonth()
    {
        $dt = new self();

        return $this->format('Y-m') == $dt->format('Y-m');
    }

    /**
     * @return bool
     */
    public function isCurrentYear()
    {
        $dt = new self();

        return $this->format('Y') == $dt->format('Y');
    }

}
