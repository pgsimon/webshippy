<?php

namespace Webshippy;

/**
 * Valiator for fulfillable order service
 */
class Validator
{
    /**
     * @var string validation error or empty string if no error.
     */
    protected string $error = '';

    /**
     * @var mixed decoded json
     */
    public mixed $json = null;

    /**
     * @see FulfillableOrderService::__construct()
     */
    public function __construct(protected int $argc, array $argv)
    {
        if (is_string($argv[1] ?? null)) {
            $this->json = json_decode($argv[1]);
        }
    }

    /**
     * Validate input arguments
     *
     * @return bool whether validation was successful
     */
    public function validate(): bool
    {
        if ($this->argc != 2) {
            $this->error = 'Ambiguous number of parameters!';
            return false;
        }

        if ($this->json == null) {
            $this->error = 'Invalid json!';
            return false;
        }

        return true;
    }

    /**
     * Get error message
     *
     * @return string error message or empty string if no error
     */
    public function getError(): string
    {
        return $this->error;
    }
}
