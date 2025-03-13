<?php

namespace Octopy\Debugify\Http\Payloads;

use DOMDocument;
use DOMXPath;
use Octopy\Debugify\Support\PrimitiveType;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

/**
 * symfony/var-dumper
 * @property PrimitiveType $value
 */
class SymfonyPayload extends Payload
{
    /**
     * @return string
     */
    protected function getType() : string
    {
        return 'symfony';
    }

    /**
     * @inheritDoc
     */
    protected function getContent() : array
    {
        return [
            'label' => 'HTML',
            'value' => $this->getValue(),
        ];
    }

    /**
     * @return string
     */
    private function getValue() : string
    {
        $cloner = new VarCloner;
        $dumper = new HtmlDumper;
        $cloned = $cloner->cloneVar($this->value);

        $html = $dumper->dump($cloned, true);

        // remove the <script> and <style> tags because both are already provided
        // in the Client and also to reduce the size of the payload sent.
        $dom = new DOMDocument;
        @$dom->loadHTML($html);

        $xpath = new DOMXPath($dom);
        $element = $xpath->query("//pre[starts-with(@id, 'sf-dump-')]");

        if ($element->length > 0) {
            return $dom->saveHTML($element->item(0));
        }

        return $html;
    }
}