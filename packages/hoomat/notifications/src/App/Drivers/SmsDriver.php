<?php

namespace Hoomat\Notifications\App\Drivers;

use Hoomat\Notifications\App\Drivers\Interfaces\NotificationDriverInterface;

class SmsDriver implements NotificationDriverInterface
{
    private ?string $from = null;

    private array $receivers = [];

    private array $details = [];

    private string $text = '';


    /**
     * Send Message after Setting Receivers and Text
     *
     * @return void
     * @throws \SoapFault
     */
    public function send(): void
    {
        ini_set('soap.wsdl_cache_enabled', '0');
        $client = new \SoapClient(config('BSManager.sms_server.iran.api_url'), ['encoding' => 'UTF-8']);

        $client->SendSms($this->getParams());
    }


    /**
     * Set Sender Number
     *
     * @param string $from
     * @return static
     */
    public function from(string $from): static
    {
        $this->from = $from;
        return $this;
    }


    /**
     * Set Receivers Phone Numbers
     *
     * @param array|string $receivers - single or multiple phone number
     * @return static
     */
    public function to(array|string $receivers): static
    {
        $this->receivers = !is_array($receivers) ? [ltrim($receivers, '0')] : array_map(function($rec) {
            return ltrim($rec, '0');
        }, $receivers);

        return $this;
    }


    /**
     * Set SMS Text Message
     *
     * @param string $text
     * @return static
     */
    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }


    /**
     * There is no need to Use this :)
     *
     * @param array $details
     * @return static
     */
    public function details(array $details): static
    {
        $this->details = $details;
        return $this;
    }


    /**
     * Get IranSmsPanel Params for Sending SMS
     *
     * @return array
     */
    private function getParams(): array
    {
        return [
            'username' => config('BSManager.sms_server.iran.USERNAME'),
            'password' => config('BSManager.sms_server.iran.PASSWORD'),
            'from' => $this->from ?? config('BSManager.sms_server.iran.NUMBER'),
            'to' => $this->receivers,
            'text' => $this->text,
            'isflash' => true,
            'udh' => '',
            'recId' => [0],
            'status' => 0x0
        ];
    }
}
