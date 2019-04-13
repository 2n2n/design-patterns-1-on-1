<?php

interface Person
{
    public function getFullName(): string;
}

abstract class Investorable implements Person
{
    public function __construct($firstname, $lastname, $amount)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->amount = $amount;
    }

    public function getFullName(): string
    {
        return sprintf('%s, %s', $this->lastname, $this->firstname);
    }

    public function calculateInvestment(): float
    {
        return $this->amount + ($this->amount * $this->INVESTMENT_MULTIPLIER);
    }

    public function displayInvestment(): string
    {
        return sprintf('%s has invested %s', $this->getFullName(), number_format($this->calculateInvestment(), 2, '.', ','));
    }
}

class BasicInvestor extends Investorable
{
    protected $INVESTMENT_MULTIPLIER = .45;

    public function __construct()
    {
        parent::__construct(...func_get_args());
    }
}

class PremiumInvestor extends Investorable
{
    protected $INVESTMENT_MULTIPLIER = 1;

    public function __construct()
    {
        parent::__construct(...func_get_args());
    }
}

class Investor
{
    public static function make($type, $firstname, $lastname, $amount): Investorable
    {
        switch ($type) {
            case 'basic':
                return new BasicInvestor($firstname, $lastname, $amount);
            case 'prem':
                return new PremiumInvestor($firstname, $lastname, $amount);
            default:
                throw new \Exception('Invalid Investor type');
        }
    }
}

try {
    $investor1 = Investor::make('prem', 'Jan paul', 'Almanoche', 10000);
    echo $investor1->displayInvestment().PHP_EOL;
    echo '======================'.PHP_EOL;
    $investor2 = Investor::make('prem', 'Anthony Yolach', 'Lloveras', '50000');
    echo $investor2->displayInvestment().PHP_EOL;
} catch (\Exception $e) {
    echo '***********************'.PHP_EOL;
    echo $e->getMessage().PHP_EOL;
    echo '***********************'.PHP_EOL;
}
