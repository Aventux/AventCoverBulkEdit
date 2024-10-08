# AventCoverBulkEdit für Shopware 6

**AventCoverBulkEdit** ist ein nützliches Plugin für Shopware 6, das im Bulk-Edit-Modus eine Schaltfläche hinzufügt, mit der Coverbilder automatisch festgelegt werden können. Das Plugin nutzt das erste Bild eines Artikels, um dieses als Coverbild zu definieren, was die Bearbeitung umfangreicher Produktkataloge vereinfacht.

## Funktionen
- **Massenbearbeitung von Coverbildern**: Fügt im Bulk-Edit-Modus eine Option hinzu, um das erste Bild eines Artikels als Coverbild festzulegen.
- **Effiziente Verwaltung**: Spart Zeit bei der Bearbeitung von Produktkatalogen mit vielen Artikeln, indem Coverbilder automatisch gesetzt werden.

## Installation
Um das AventCoverBulkEdit-Plugin zu installieren, führen Sie folgende Schritte aus:

```bash
composer require aventux/cover-bulk-edit
bin/console plugin:refresh
bin/console plugin:install -a AventCoverBulkEdit
bin/console cache:clear
```

## Konfiguration
Nach der Installation und Aktivierung des Plugins ist keine weitere Konfiguration erforderlich. Die Schaltfläche zur Festlegung der Coverbilder erscheint automatisch im Bulk-Edit-Modus.

## Ist etwas nicht wie erwartet?
Sollten Sie auf ein Problem stoßen oder Verbesserungsvorschläge haben, freuen wir uns über Ihre Rückmeldungen und Beiträge.

## Beiträge
Falls Sie Ideen für neue Funktionen haben, einen Fehler gefunden haben oder Verbesserungen vorschlagen möchten, können Sie gerne einen Pull Request in unserem GitHub-Repository erstellen. Jede Hilfe ist willkommen!

## Support
Für Fragen oder Unterstützung besuchen Sie unser GitHub-Repository oder kontaktieren Sie unser Support-Team.

Vielen Dank, dass Sie AventCoverBulkEdit für Ihren Shopware 6 Shop nutzen!

