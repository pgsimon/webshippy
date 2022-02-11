<?php
// @codingStandardsIgnoreFile PHP codesniffer still does not recognise the new PHP 8.1 enum feature

namespace Webshippy;

/**
 * Enum for priorities
 */
enum Priority: int
{
    /**
     * Low priority
     */
    case LOW = 1;

    /**
     * Medium priority
     */
    case MEDIUM = 2;

    /**
     * High priority
     */
    case HIGH = 3;
}
