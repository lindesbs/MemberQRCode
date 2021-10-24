<?php

namespace lindesbs\MemberQRCode\EventListener;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\ServiceAnnotation\Hook;

/**
 * @Hook("replaceInsertTags")
 */
class MemberQRCodeListener
{
    public const TAG = 'qrcode';

    /**
     * @var ContaoFramework
     */
    private $framework;


    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    /**
     * @return string|bool
     */
    public function __invoke(string $tag)
    {
        $chunks = explode('::', $tag);

        echo "*";
        dd($chunks);

        if (self::TAG !== $chunks[0]) {
            return false;
        }

        return str_rot13($chunks[1]);
    }
}
