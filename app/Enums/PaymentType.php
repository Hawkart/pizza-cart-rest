<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentType extends Enum
{
    const Cash = 1;
    const Card = 2;
}
