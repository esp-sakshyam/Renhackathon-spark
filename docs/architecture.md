# AgroPan — Architecture Document

## System Overview

AgroPan is a **client-side agriculture decision & risk simulation platform** focused exclusively on Nepal. It enables farmers, agricultural advisors, and policymakers to simulate crop outcomes before planting — projecting yield, risk, and profit based on Nepal's climate, terrain, and market realities.

> "AgroPan is not a website — it's a decision engine with a calm, intelligent interface."

---

## Architecture Principles

| Principle | Rationale |
|---|---|
| **Client-first** | Zero backend dependency for the prototype — runs entirely in-browser so any farmer with a phone can use it offline. |
| **Data-structured** | Simulation data (crops, districts, seasons) is separated from UI logic, making it trivial to swap placeholder data for real API responses. |
| **Mobile-first** | 65%+ of Nepal's internet users access via mobile. Every layout and interaction is designed for small screens first, then enhanced. |
| **Progressive** | Intersection Observer animations, lazy images, and minimal JS footprint. No frameworks, no build tools — opens in any browser. |
| **Nepal-contextualized** | Every data point, crop name (with Nepali script), district, and risk factor is calibrated to Nepal's agriculture reality. |

---

## Folder Structure

```
agropan/
├── index.html              ← Single-page application entry
├── css/
│   ├── variables.css       ← Design tokens (colors, spacing, fonts)
│   ├── base.css            ← CSS reset + global element styles
│   ├── layout.css          ← Page structure, grid utilities, navbar
│   └── components.css      ← UI components (buttons, cards, sim panel)
├── js/
│   ├── animations.js       ← Intersection Observer scroll reveals
│   ├── simulate.js         ← Simulation engine (crop data + logic)
│   └── main.js             ← App controller (nav, form, rendering)
├── gallery/                ← Real Nepali agriculture photographs
├── docs/
│   └── architecture.md     ← This document
└── README.md               ← Project overview & quick start
```

---

## Module Dependency Graph

```
index.html
  ├── css/variables.css    (design tokens)
  ├── css/base.css         (reset, depends on variables)
  ├── css/layout.css       (layout, depends on variables)
  ├── css/components.css   (components, depends on variables)
  │
  ├── js/animations.js     (standalone — Intersection Observer)
  ├── js/simulate.js       (standalone — pure data + logic)
  └── js/main.js           (depends on simulate.js for AgroPanSim)
```

### Loading Order
Scripts load in this order at the bottom of `<body>`:
1. `animations.js` — Registers scroll observers immediately
2. `simulate.js` — Exposes `AgroPanSim` global module
3. `main.js` — Wires DOM events, uses `AgroPanSim.simulate()`

---

## Simulation Engine (`simulate.js`)

### Data Model

**CROP_DATA** — 10 crop profiles with:
- `yieldRange` [min, max] kg/ropani
- `costPerRopani` NPR
- `pricePerKg` [min, max] NPR
- `bestSeason` — optimal planting window
- `riskFactors` — array of real agronomic risks

**DISTRICT_DATA** — 10 Nepal districts with:
- `zone` — ecological classification
- `yieldMod` — yield multiplier (0.7–1.12)
- `riskMod` — risk multiplier (0.82–1.30)

### Simulation Flow

```
User Input → {district, crop, season, land}
  │
  ├── Lookup CROP_DATA[crop]
  ├── Lookup DISTRICT_DATA[district]
  ├── Compute getSeasonModifier(crop, season)
  │
  ├── Yield = yieldRange × districtMod × seasonMod
  ├── Revenue = totalYield × priceRange
  ├── Profit = Revenue − (costPerRopani × land)
  ├── Risk = baseRisk(30) × districtRiskMod × seasonRiskMod
  ├── Confidence = f(riskScore)
  │
  └── Output → {yield, profit, risk, confidence, recommendation}
```

### Risk Classification
| Score Range | Level | Color |
|---|---|---|
| 0–35 | Low | `#2E7D65` (green) |
| 36–60 | Medium | `#F2A900` (amber) |
| 61–100 | High | `#D94F3B` (red) |

---

## CSS Architecture

### Token-Driven Design
All visual properties flow from `variables.css`. A single change to `--color-primary` updates every component in the system.

### Layer Order
1. **Variables** — tokens only, no selectors on elements
2. **Base** — element-level resets and defaults
3. **Layout** — structural rules (container, grid, navbar)
4. **Components** — self-contained UI blocks

### Responsive Strategy
- **Mobile-first**: Base styles are for `320px+`
- **Tablet** (`768px`): 2-column grids, show desktop nav
- **Desktop** (`1024px`): Full layout, 3-4 column grids

---

## Animation Strategy

| Animation | Trigger | Method |
|---|---|---|
| Scroll reveal | Element enters viewport | Intersection Observer |
| Staggered reveal | Container enters viewport | CSS `transition-delay` per child |
| Counter animation | Page load | `requestAnimationFrame` |
| Risk bar fill | Simulation runs | CSS transition + rAF |
| Button shake | Invalid form | CSS `@keyframes` injected via JS |

All animations respect `prefers-reduced-motion: reduce`.

---

## Accessibility

- Semantic HTML5 elements throughout
- ARIA labels on navigation and interactive elements
- Keyboard-navigable focus states (`:focus-visible`)
- Color contrast ratios meet WCAG AA
- Screen-reader-only utility class (`.sr-only`)
- Reduced motion media query support

---

## Future Architecture (Production Path)

| Phase | Enhancement |
|---|---|
| **v1.1** | Replace placeholder data with Nepal DOA API integration |
| **v1.2** | Add offline support via Service Worker + IndexedDB caching |
| **v2.0** | WebAssembly-compiled agronomic model for complex simulations |
| **v2.1** | Multi-language support (English + Nepali) with `i18n` module |
| **v3.0** | District-level heatmap visualization using Canvas/WebGL |
| **v3.1** | Policy dashboard for aggregate simulation analytics |

---

*Document version: 1.0 · Last updated: February 2026*
