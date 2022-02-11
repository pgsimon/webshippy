<?php

namespace Webshippy;

class Formatter
{
    /**
     * name of the priority field
     */
    protected const PRIORITY = 'priority';

    /**
     * @var array formatted result
     */
    protected array $result = [];

    /**
     * @param array $header csv header
     * @param array $body csv body
     */
    public function __construct(protected array $header, protected array $body)
    {
    }

    /**
     * Format data
     *
     * @return void
     */
    public function format(): void
    {
        $this->addHeader();
        $this->addSeparator();
        $this->addBody();
    }

    /**
     * Add formatted header to result
     *
     * @return void
     */
    protected function addHeader(): void
    {
        $result = [];
        foreach ($this->header as $column) {
            $result[] = str_pad($column, 20);
        }
        $this->result[] = $result;
    }

    /**
     * Add separator between header and body
     *
     * @return void
     */
    protected function addSeparator(): void
    {
        $this->result[] = array_fill(0, count($this->header), str_repeat('=', 20));
    }

    /**
     * Add formatted body to result
     *
     * @return void
     */
    protected function addBody(): void
    {
        foreach ($this->body as $row) {
            $result = [];
            if (!is_array($row)) {
                continue;
            }
            foreach ($row as $key => $column) {
                if ($key == static::PRIORITY) {
                    $column = match ((int)$column) {
                        Priority::LOW->value => Priority::LOW->name,
                        Priority::MEDIUM->value => Priority::MEDIUM->name,
                        Priority::HIGH->value => Priority::HIGH->name,
                    };
                }
                $result[] = str_pad(mb_strtolower($column), 20);
            }
            $this->result[] = $result;
        }
    }

    /**
     * Get formatted result
     *
     * @return array formatted result
     */
    public function getResult(): array
    {
        return $this->result;
    }
}
