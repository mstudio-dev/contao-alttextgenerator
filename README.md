# Contao Alt Text Generator

Automatisches Erzeugen eines deutschen ALT-Textes beim Upload von Bildern in Contao 5.x.

## Installation

1. Paket installieren:

   composer require mstudio-dev/contao-alttextgenerator

2. API-Key in `.env.local` hinterlegen:

   OPENAI_API_KEY=dein_api_key

3. Cache leeren:

   vendor/bin/contao-console cache:clear

## Konfiguration

In `config/config.yaml`:

```yaml
mstudio_contao_alt_text_generator:
  model: gpt-4o-mini
  replace_existing_alt: false
```

### Optionen

- `model` (string, default: `gpt-4o-mini`): OpenAI-Modell für die Bildbeschreibung.
- `replace_existing_alt` (bool, default: `false`):
  - `false`: vorhandene ALT-Texte in `de` bleiben unverändert.
  - `true`: vorhandene ALT-Texte in `de` werden überschrieben.

## Verhalten

- Hook: `postUpload` (Contao 5)
- Nur Bilddateien werden verarbeitet.
- ALT-Text wird ausschließlich für Sprache `de` gespeichert.
- Die Bilddaten werden als Data-URL an OpenAI gesendet.

## Hinweis

Die Nutzung externer KI-Dienste kann datenschutzrechtliche Anforderungen auslösen. Vor Produktiveinsatz bitte rechtlich prüfen.
