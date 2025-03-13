<?php

namespace Octopy\Debugify\Origin;

use Octopy\Debugify\Debugify;
use Spatie\Backtrace\Backtrace;
use Spatie\Backtrace\Frame;

class OriginFactory
{
    /**
     * @return Origin
     */
    public function getOrigin() : Origin
    {
        $frame = $this->getFrame();

        return
            new Origin(
                file: $frame?->file,
                line: $frame?->lineNumber,
            );
    }

    /**
     * @return Frame|null
     */
    private function getFrame() : Frame|null
    {
        $frames = array_reverse(Backtrace::create()->frames(), true);

        $index = $this->search(function (Frame $frame) : bool {
            if ($frame->class === Debugify::class) {
                return true;
            }

            return false;
        }, $frames);

        return $frames[$index + 1] ?? null;
    }

    /**
     * @param  callable $callable
     * @param  array    $items
     * @return int|string|null
     */
    protected function search(callable $callable, array $items) : int|string|null
    {
        foreach ($items as $key => $item) {
            if ($callable($item, $key)) {
                return $key;
            }
        }

        return null;
    }
}