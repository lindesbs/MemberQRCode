# MemberQRCode


Basierend auf dem RFC 6350 (https://datatracker.ietf.org/doc/html/rfc6350) koennen VCards als QRCode erstellt werden.
Diese werden auf der Webseite mittels InsertTag eingefuegt. Somit ist eine schnelle Adressweitergabe und Aufnahme in das eigene Kntaktverzeichniss am Smartphone moeglich.


Mittels MemberID {{qrcode:1}} oder bei der Installation von [heimrichhannot/contao-member_plus](https://packagist.org/packages/heimrichhannot/contao-member_plus) auch die Nutzung des Alias {{qrcode::stefan-lindecke}} 


Das Ausgabeformat kann mittels 2 Parameter gesteuert werden. {{qrcode::1::raw}}
Valide Typen sind 
- raw, liefert die vCard zurück
- png
- jpg
- gif
- svg
- text
- json

Weiter Konfigurationsmoeglichkkeiten sind hier das verwendete Template und die entsprchende Versionsgroesse.
Small benoetigt eine Version von 14, default eine von 22.


Beispiel
--------

{{qrcode::2::png::vcard_small::10::2::Dies ist der QR Code fuer meine vCard}}

InsertTag | MemberId | OutputFormat | Template | Version | Scale | AltText
--------- | -------- | ------------ | -------- | ------- | ----- | -------
qrcode | 2 | png | vcard_small | 14 | 2 | Dies ist der QR Code fuer meine vCard

Beispiele fuer Version: https://www.qrcode.com/en/about/version.html


Eigene Templates
----------------

Von der Vorlage kopieren und darauf achten, wenn in einer Zeile eine Erstzung durch eine Variable stattfindet, muss danach eine Leerzeile kommen.

Dies ist die Vorlage:

```
ORG:<?= $this->company; ?>

URL;WORK:<?= $this->website; ?>

URL;PRIVATE:<?= $this->website; ?>

EMAIL;type=WORK;type=PREF:<?= $this->email; ?>
```

In der RAW Ausgabe erscheint:
```
ORG:ktrion
URL;WORK:https://ktrion.de
URL;PRIVATE:https://ktrion.de
EMAIL;type=WORK;type=PREF:hallo@ktrion.de
```

Wichtig hierbei ist, das jede Information in einer eigenen Zeile steht.
Hat man im Template die zusaetzlichen Leerzeichen nicht

```
ORG:<?= $this->company; ?>
URL;WORK:<?= $this->website; ?>
URL;PRIVATE:<?= $this->website; ?>
EMAIL;type=WORK;type=PREF:<?= $this->email; ?>
```

sieht es folgendermassen aus, so koennen die Adressbuecher den Code aber nicht lesen.

```
ORG:ktrionURL;WORK:https://ktrion.deURL;PRIVATE:https://ktrion.deEMAIL;type=WORK;type=PREF:hallo@ktrion.de
```
