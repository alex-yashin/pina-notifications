<?php

namespace PinaNotifications\Types;

use Pina\Types\DirectoryType;
use Pina\Types\ValidateException;
use PinaNotifications\Transports\TransportRegistry;
use function Pina\__;

class TransportType extends DirectoryType
{
    public function getVariants()
    {
        $transports = TransportRegistry::getAllExcept([]);
        $r = [];
        foreach ($transports as $type => $transport) {
            $r[] = [
                'id' => $type,
                'title' => $type,
            ];
        }
        return $r;
    }

    public function format($value): string
    {
        $variants = $this->getVariants();
        foreach ($variants as $v) {
            if ($v['id'] == $value) {
                return isset($v['title']) ? $v['title'] : '';
            }
        }

        return $value ?? '';
    }

    public function normalize($value, $isMandatory)
    {
        $variants = $this->getVariants();
        $ids = array_column($variants, 'id');
        if (!in_array($value, $ids)) {
            throw new ValidateException(__("Выберите значение"));
        }

        return $value;
    }


    public function getSQLType(): string
    {
        return "varchar(" . $this->getSize() . ")";
    }

    public function getSize(): int
    {
        return 32;
    }

}