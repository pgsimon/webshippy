<?php

namespace Webshippy;

use Exception;
use League\Csv\Reader;
use Iterator;
use League\Csv\SyntaxError;

/**
 * Service class to retrieve fulfillable orders
 */
class FulfillableOrderService
{
    /**
     * @var Validator validator class for service
     */
    public Validator $validator;

    /**
     * @var Formatter $formatter class for service
     */
    public Formatter $formatter;

    /**
     * Set mandatory properties
     *
     * @param int $argc the number of arguments passed to script
     * @param array $argv array of arguments passed to script
     * @param string $csvFile destination of csv file
     */
    public function __construct(protected int $argc, protected array $argv, protected string $csvFile)
    {
        $this->validator = new Validator($argc, $argv);
    }

    /**
     * Execute service
     *
     * @throws Exception if we set an invalid (e.g: negative number) header offset
     * @throws SyntaxError when csv syntax is invalid or file is empty
     * @return bool whether service executed successfully
     */
    public function execute(): bool
    {
        if (!$this->validator->validate()) {
            return false;
        }

        $csv = Reader::createFromPath($this->csvFile);
        $csv->setHeaderOffset(0);

        try {
            $header = $csv->getHeader();
            $records = $csv->getRecords();
        } catch (SyntaxError) {
            return false;
        }

        $body = $this->processRecords($records);

        $this->formatter = new Formatter($header, $body);
        $this->formatter->format();

        return true;
    }

    /**
     * Process csv records
     *
     * @param Iterator $records csv records
     * @return array sorted and assorted elements of csv body
     */
    protected function processRecords(Iterator $records): array
    {
        $body = [];
        foreach ($records as $record) {
            $productId = $record['product_id'] ?? null;
            $quantity = $this->validator->json->{$productId} ?? null;
            if ($quantity != null && $record['quantity'] > $quantity) {
                continue;
            }

            $body[] = $record;
        }

        usort($body, function (array $a, array $b): int {
            $aPriority = $a['priority'] ?? null;
            $bPriority = $b['priority'] ?? null;
            $aCreatedAt = $a['created_at'] ?? null;
            $bCreatedAt = $b['created_at'] ?? null;

            $priority = ($bPriority <=> $aPriority);
            if ($priority == 0) {
                return $aCreatedAt <=> $bCreatedAt;
            }
            return $priority;
        });

        return $body;
    }
}
