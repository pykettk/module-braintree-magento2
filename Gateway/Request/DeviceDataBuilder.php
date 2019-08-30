<?php
declare(strict_types=1);

namespace Magento\Braintree\Gateway\Request;

use Magento\Braintree\Gateway\Helper\SubjectReader;
use Magento\Braintree\Observer\DataAssignObserver;
use Magento\Payment\Gateway\Request\BuilderInterface;

/**
 * Class DeviceDataBuilder
 */
class DeviceDataBuilder implements BuilderInterface
{
    /**
     * @var string $deviceDataKey
     */
    private static $deviceDataKey = 'deviceData';

    /**
     * @var SubjectReader $subjectReader
     */
    private $subjectReader;

    /**
     * DeviceDataBuilder constructor
     *
     * @param SubjectReader $subjectReader
     */
    public function __construct(SubjectReader $subjectReader)
    {
        $this->subjectReader = $subjectReader;
    }

    /**
     * @inheritdoc
     */
    public function build(array $buildSubject): array
    {
        $result = [];
        $paymentDO = $this->subjectReader->readPayment($buildSubject);
        $payment = $paymentDO->getPayment();
        $data = $payment->getAdditionalInformation();

        if (!empty($data[DataAssignObserver::DEVICE_DATA])) {
            $result[self::$deviceDataKey] = $data[DataAssignObserver::DEVICE_DATA];
        }

        return $result;
    }
}
