# Release Checklist

## Vor dem Tag

- [ ] `composer validate --no-check-publish` läuft ohne Fehler
- [ ] `find src -name '*.php' -print0 | xargs -0 -n1 php -l` läuft ohne Fehler
- [ ] README und Konfigurationsbeispiele sind aktuell
- [ ] Zielversion ist festgelegt (z. B. `v0.1.0`)

## Release

- [ ] Änderungen committen
- [ ] Annotated Tag erstellen (`git tag -a v0.1.0 -m "v0.1.0"`)
- [ ] `main` und Tag zu GitHub pushen (`git push origin main --follow-tags`)

## Nach dem Release

- [ ] GitHub Release anlegen (Titel: `v0.1.0`)
- [ ] Kurzbeschreibung mit Highlights ergänzen
- [ ] Installation kurz verifizieren (`composer require mstudio-dev/contao-alttextgenerator`)
