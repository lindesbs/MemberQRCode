<?php

use lindesbs\MemberQRCode\EventListener\MemberQRCodeListener;

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['lindesbs\MemberQRCode\EventListener\MemberQRCodeListener','replaceInsertTags'];