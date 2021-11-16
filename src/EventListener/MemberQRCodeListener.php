<?php

namespace lindesbs\MemberQRCode\EventListener;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Environment;
use Contao\MemberModel;
use DateTime;
use FrontendTemplate;


/**
 * @Hook("replaceInsertTags")
 */
class MemberQRCodeListener
{
    public const TAG = 'qrcode';


    /**
     * @return string|bool
     */
    public function replaceInsertTags($tag)
    {
        $chunks = explode('::', $tag);

        $localTag = array_shift($chunks);
        if (($localTag === self::TAG) && (count($chunks) > 0)) {
            $member = array_shift($chunks);

            $memberObj = MemberModel::findByIdOrAlias($member);

            $arrTypes = [
            'gif' => QRCode::OUTPUT_IMAGE_GIF,
            'jpg' => QRCode::OUTPUT_IMAGE_JPG,
            'png' => QRCode::OUTPUT_IMAGE_PNG,
            'svg' => QRCode::OUTPUT_MARKUP_SVG,
            'text' => QRCode::OUTPUT_STRING_TEXT,
            'json' => QRCode::OUTPUT_STRING_JSON,

            ];

            if ($memberObj) {
                $outputType = QRCode::OUTPUT_IMAGE_PNG;
                $version = 20;
                $eccLevel = QRCode::ECC_L;
                $scale = 2;
                $strTemplate = "vcard_default";
				$altText="";

                // Ausgabeformat
                if (count($chunks) > 0) {
                    $outputType = array_shift($chunks);
                    if ($outputType === "raw") {
                        $objTemplate = new FrontendTemplate($strTemplate);
                        $objTemplate->setData($memberObj->row());
                        return nl2br($objTemplate->parse());
                    }

                    if (array_key_exists($outputType, $arrTypes)) {
                        $outputType = $arrTypes[$outputType];
                    }

                    // Template ?
                    if (count($chunks) > 0) {
                        $strTemplate = array_shift($chunks);
                    }

                    // Version ?
                    if (count($chunks) > 0) {
                        $version = array_shift($chunks);
                    }

                    // Scale ?
                    if (count($chunks) > 0) {
                        $scale = array_shift($chunks);
                    }

					// ALT Text ?
					if (count($chunks) > 0) {
						$altText = array_shift($chunks);
					}
                }

                $objTemplate = new FrontendTemplate($strTemplate);
                $objTemplate->setData($memberObj->row());

                $date = new DateTime();
                $objTemplate->revTimecode = $date->format('c');

                $options = new QROptions(
                    [
                    'version' => $version,
                    'outputType' => $outputType,
                    'eccLevel' => $eccLevel,
                    'scale' => $scale
                    ]
                );

                $objQRCode = new QRCode($options);
                $strOutput = sprintf('<img src="%s" alt="%s">', $objQRCode->render($objTemplate->parse()), htmlentities($altText));

                return $strOutput;
            }

        }
        return false;
    }
}
